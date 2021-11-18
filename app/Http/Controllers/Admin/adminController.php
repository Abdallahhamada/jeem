<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Traits\defaultMessage;
use App\Traits\defaultRegister;
use App\Http\Requests\loginRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\contactRequest;
use App\Http\Requests\passwordRequest;
use App\Jobs\contactJob;
use App\Models\Admin\Admin;
use App\Models\Admin\Contact;
use Illuminate\Support\Facades\Auth;
use App\Traits\translate;

class adminController extends Controller
{

    /**
     * This Trait For Handling Default Messages Of Controller
     */

    use defaultMessage,translate, defaultRegister;

    /**
     * Login Method For Admin Dashboard
     *
     * @return Json
     */

    public function login(loginRequest $request)
    {

        if ($token = $this->defaultLogin('admin', $request->email, $request->password)) {

            $this->message = __('tables.SUCCESS_LOGIN');

            $this->data = [
                'token' => $token,
                'token_type' => 'bearer',
                'expire' => Auth::guard('admin')->factory()->getTTL() * 60,
                'role' => 'admin'
            ];
            return $this->success();

        } else {

            $this->message = __('tables.INVALIED_EMAIL_PASSWORD');

            return $this->error();
        }
    }

    /**
     * LogOut Method From Admin
     *
     * @return JSON
     */

    public function logout()
    {

        $this->defaultLogout();

        return $this->success();
    }

    /**
     * seller Method For Seller Dashboard
     *
     * @return Json
     */

    public function show(){

        $this->data = Auth::user();

        return $this->success();
     }

     public function password(passwordRequest $request)
    {

       Admin::find(Auth::id())->update([

           'password' => bcrypt($request->password)

       ]);

       $this->message = $this->UPDATE_TRANSLATE('PASSWORD');

       return $this->success();
    }

    public function contact(contactRequest $request){

        $check = Contact::where('email',$request->email)->first();

        if(!$check){

            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'message' => $request->message
            ];

            Contact::create($data);

            contactJob::dispatch($data);

            $this->message = __('tables.CONTACT_ADD');

            return $this->success();

        }else{

            $this->message = __('tables.CONTACT_EXIST');

            return $this->success();
        }
    }
}
