<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Buyer\Address;
use Illuminate\Http\Request;
use App\Traits\defaultMessage;
use Illuminate\Support\Facades\Auth;
use App\Traits\translate;

class addressController extends Controller
{

    use defaultMessage,translate;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->data = Address::where('buyer_id',Auth::id())->get();

        return $this->success();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'address' => 'required|string',
            'phone' => 'required|numeric',
        ]);

        $response = Address::create([
            'phone' => $request->phone,
            'address' => $request->address,
            'buyer_id' => Auth::id()
        ]);

        $this->message = $this->CREATE_TRANSLATE('ADDRESS');

        $this->data = [
            'id' => $response->id
        ];

        return $this->success();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        Address::find($id)->where('buyer_id',Auth::id())->where('status',false)->delete();

        $this->message = $this->DELETE_TRANSLATE('ADDRESS');

        return $this->success();
    }
}
