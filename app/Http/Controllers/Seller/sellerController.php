<?php

namespace App\Http\Controllers\Seller;

use App\Models\Seller\Seller;
use App\Traits\defaultMessage;
use App\Traits\defaultRegister;
use App\Http\Requests\loginRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\passwordRequest;
use App\Http\Requests\sellerRegisterRequest;
use App\Http\Requests\sellerRequest;
use App\Jobs\resetPasswordJob;
use App\Models\Seller\PdfFile;
use App\Models\Seller\resetPassword;
use App\Traits\checkAuthorizationSeller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Traits\defaultSaveFiles;
use Dirape\Token\Token;
use Illuminate\Support\Facades\Storage;
use App\Traits\translate;
use App\Models\Invoice\Invoice;

class sellerController extends Controller
{

    /**
     * This Trait For Handling Default Messages Of Controller
     */

    use defaultMessage, translate, defaultSaveFiles, defaultRegister, checkAuthorizationSeller;

    public function __construct()
    {

        $this->middleware('permission:change-password-seller', ['only' => ['password']]);

        $this->middleware('permission:update-profile-seller', ['only' => ['info']]);
    }

    /**
     * @group Seller Auth
     */

    /**
     * seller Method For Seller Dashboard
     *
     * @return Json
     */

    public function show()
    {

        $this->data = $response = Auth::user();

        $this->data['image'] = ($response['image_name'] === 'avatar.svg' ? $this->getImagePath($response['image_path']) : $this->getStorageImagePath($response['image_path']));

        return $this->success();
    }

    /**
     * Login Method For Seller Dashboard
     *
     * @return Json
     */

    public function login(loginRequest $request)
    {

        $seller = Seller::where('email', $request->email)->first();

        $auth = $this->defaultLogin('seller', $request->email, $request->password);

        if ($token = $this->defaultLogin('subseller', $request->email, $request->password)) {

            $this->message = __('tables.SUCCESS_LOGIN');

            $this->data = [
                'token' => $token,
                'token_type' => 'bearer',
                'expire' => Auth::guard('subseller')->factory()->getTTL() * 60,
                'role' => 'seller'
            ];

            return $this->success();
        } else if ($auth && $seller && $seller->verified != '1') {

            $this->data = [
                'token' => $seller->token
            ];

            $this->message = __('tables.ACCOUNT_ACTIVE');

            return response()->json([
                'status' => false,
                'message' => $this->message,
                'data' => $this->data
            ], 200);
        } else if ($auth && $seller && $seller->active != '1') {

            $this->message = __('tables.ACCOUNT_WAIT_ACTIVE');

            return $this->error();
        } else if ($token = $auth) {

            $this->message = __('tables.SUCCESS_LOGIN');

            $this->data = [
                'token' => $token,
                'token_type' => 'bearer',
                'expire' => Auth::guard('seller')->factory()->getTTL() * 60,
                'role' => 'seller'
            ];

            return $this->success();
        } else {

            $this->message = __('tables.INVALIED_EMAIL_PASSWORD');

            return $this->error();
        }
    }


    /**
     * Login Method For Seller Dashboard
     *
     * @return Json
     */

    public function register(sellerRegisterRequest $request)
    {

        $this->name = $request->name;

        $this->email = $request->email;

        $this->phone = $request->phone;

        $this->password = $request->password;

        $this->city = $request->city;

        $this->category_id = $request->category;

        $this->defaultRegister(Seller::class, 'seller');

        $this->data = [
            'token' => $this->token
        ];

        return $this->success();
    }

    /**
     * LogOut Method From Seller
     *
     * @return JSON
     */

    public function logout()
    {
        $this->defaultLogout();

        return $this->success();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function active(sellerRequest $request, $token)
    {
        $seller = Seller::where('token', $token)->where('otp_phone', $request->phone)->where('otp_email', $request->email)->first();

        $filePath = $request->file('file')->store('sellers/files', 'public');

        Storage::put($filePath, Storage::get($filePath));

        PdfFile::create([
            'path' => $filePath,
            'seller_id' => Seller::where('token', $token)->first()->id
        ]);

        Seller::where('token', $token)->where('otp_phone', $request->phone)->where('otp_email', $request->email)->update([
            'verified' => DB::raw('NOT verified'),
            'token' => null,
            'otp_phone' => null,
            'otp_email' => null
        ]);

        Invoice::create([
            'name' => $seller->name,
            'seller_id' => $seller->id
        ]);

        $this->message = __('tables.ACCOUNT_ACTIVE_SUCCESS');

        return $this->success();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function sendAvtivePhoneAgain($token)
    {

        $seller = Seller::where('token', $token)->first();

        $this->verifyPhoneAgain(Seller::class, $seller->phone, $token);

        return $this->success();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function activeCheck($token)
    {

        $seller = Seller::where('token', $token)->where('verified', false)->exists();

        if ($seller) {

            return $this->success();
        } else {

            $this->message = 'this token not found or expired';

            return $this->error();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function renewCheck($token)
    {

        $seller = resetPassword::where('token', $token)->exists();

        if ($seller) {

            return $this->success();
        } else {

            $this->message = 'this token not found or expired';

            return $this->error();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:sellers,email|unique:password_seller_resets,email'
        ]);

        $token = (new Token())->Unique('password_seller_resets', 'token', 60);

        $seller = Seller::where('email', $request->email)->first();

        resetPasswordJob::dispatch('seller', $token, $request->email, $seller->name);

        // Mail::to($request->email)->send(new resetAccount($token));

        resetPassword::create([
            'email' => $request->email,
            'token' => $token
        ]);

        $this->message = __('tables.RESET_PASSWORD');

        return $this->success();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function renew(Request $request, $token)
    {
        //|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%]).*$/

        $request->validate([
            'password' => 'required|string|min:8|same:confirm-password'
        ]);

        $resetPassword = resetPassword::where('token', $token);

        $email = $resetPassword->first()->email;

        Seller::where('email', $email)->update([
            'password' => bcrypt($request->password)
        ]);

        $resetPassword->delete();

        $this->message = $this->UPDATE_TRANSLATE('PASSWORD');

        return $this->success();
    }

    public function password(passwordRequest $request)
    {

        Seller::find($this->userID())->update([
            'password' => bcrypt($request->password)
        ]);

        $this->message = $this->UPDATE_TRANSLATE('PASSWORD');

        return $this->success();
    }


    public function info(Request $request)
    {

        $data = [
            'country' => (($request->country === "null") ? json_decode($request->country) : $request->country),
            'city'  => (($request->city === "null") ? json_decode($request->city) : $request->city),
            'pincode' => (($request->pincode === "null") ? json_decode($request->pincode) : $request->pincode),
            'state' => (($request->state === "null") ? json_decode($request->state) : $request->state),
            'address' => (($request->address === "null") ? json_decode($request->adddescriress) : $request->address),
            'descri' => (($request->descri === "null") ? json_decode($request->descri) : $request->descri)
        ];


        Seller::find($this->userID())->update($data);

        if ($request->hasFile('image')) {

            $image = $this->storeFile($request, 'sellers', 'image');

            Seller::find($this->userID())->update([
                'image_name' => $image['name'],
                'image_path' => $image['imagePath']
            ]);

            data_set($data, 'image', $this->getStorageImagePath($image['imagePath']));
        }

        $this->message = $this->UPDATE_TRANSLATE('INFO');

        $this->data = $data;

        return $this->success();
    }
}
