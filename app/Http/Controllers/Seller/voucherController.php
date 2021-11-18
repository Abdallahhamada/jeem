<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Http\Requests\voucherRequest;
use App\Models\Voucher\Voucher;
use Illuminate\Http\Request;
use App\Traits\defaultMessage;
use App\Traits\checkAuthorizationSeller;
use App\Traits\translate;

class voucherController extends Controller
{
    use defaultMessage, translate, checkAuthorizationSeller;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->data = Voucher::where('seller_id',$this->userID())->get();

        return $this->success();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(voucherRequest $request)
    {

        $data = $request->all();

        $data['seller_id'] = $this->userID();

        Voucher::create($data);

        $this->message = $this->CREATE_TRANSLATE('VOUCHER');

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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Voucher $voucher)
    {

        $check = Voucher::where('id', $voucher->id)->delete();

        if ($check) {

            $this->message = $this->DELETE_TRANSLATE('VOUCHER');

            return $this->success();
        } else {

            $this->message = $this->FAILED_DELETE_TRANSLATE('VOUCHER');

            return $this->error();
        }
    }
}
