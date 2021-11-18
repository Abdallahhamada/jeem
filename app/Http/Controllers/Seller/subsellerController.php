<?php

namespace App\Http\Controllers\Seller;

use Illuminate\Http\Request;
use App\Models\Seller\Seller;
use App\Traits\defaultMessage;
use App\Models\Seller\Subseller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\subsellerRequest;
use Spatie\Permission\Models\Permission;
use App\Models\Permissions\ModelHasPermissions;
use App\Traits\checkAuthorizationSeller;
use App\Traits\translate;

class subsellerController extends Controller
{
    use defaultMessage,translate,checkAuthorizationSeller;

    public function __construct()
    {

        $this->middleware('permission:all-subsellers',['only' => ['index']]);

        $this->middleware('permission:edit-subseller',['only' => ['update']]);

        $this->middleware('permission:create-subseller',['only' => ['create']]);

        $this->middleware('permission:show-subseller',['only' => ['show']]);

        $this->middleware('permission:delete-subseller',['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function permission(Request $request)
    {

        $this->data = Permission::get(
            [
                'id',
                'name',
                'name_ar'
            ]
        );

        return $this->success();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->data = Seller::find($this->userID())->subseller;

        return $this->success();
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(subsellerRequest $request)
    {

        $user = Subseller::create([
            'seller_id' => Auth::id(),
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        $user->givePermissionTo($request->permission);

        $this->message = $this->CREATE_TRANSLATE('SUBSELLER');

        return $this->success();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $subseller = Subseller::where('id', $id)->where('seller_id', $this->userID())->first();

        $subseller->getAllPermissions();

        $this->data = $subseller;

        return $this->success();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(subsellerRequest $request, Subseller $subseller)
    {

        Subseller::where('id', $subseller->id)->where('seller_id', $this->userID())->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        Subseller::find($subseller->id)->syncPermissions($request->permission);

        $this->message = $this->UPDATE_TRANSLATE('SUBSELLER');

        return $this->success();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subseller $subseller)
    {
        $user = Subseller::where('id', $subseller->id)->where('seller_id', $this->userID())->delete();

        ModelHasPermissions::where('model_id', $subseller->id)->delete();

        if ($user) {

            $this->message = $this->DELETE_TRANSLATE('SUBSELLER');

            return $this->success();

        }else{

            $this->message = $this->FAILED_DELETE_TRANSLATE('SUBSELLER');

            return $this->error();
        }
    }
}
