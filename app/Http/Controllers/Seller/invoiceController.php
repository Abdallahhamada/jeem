<?php

namespace App\Http\Controllers\Seller;

use App\Traits\defaultMessage;
use App\Models\Invoice\Invoice;
use App\Traits\defaultSaveFiles;
use App\Http\Controllers\Controller;
use App\Http\Requests\invoiceRequest;
use Illuminate\Support\Facades\Storage;
use App\Traits\checkAuthorizationSeller;
use App\Traits\translate;

class invoiceController extends Controller
{
    use defaultMessage,translate, defaultSaveFiles,checkAuthorizationSeller;

    public function __construct()
    {
        $this->middleware('permission:create-invoice',['only' => ['store']]);

        $this->middleware('permission:edit-invoice',['only' => ['update']]);

        $this->middleware('permission:delete-invoice',['only' => ['destroy']]);
    }

    private function retriveData($request)
    {

        $data = [
            'name' => $request->name,
            'seller_id' => $this->userID(),
            'shipping_charge' => $request->charge
        ];

        if ($request->hasFile('image')) {

            $image = $this->storeFile($request, 'invoice', 'image');

            $data['image_name'] = $image['name'];

            $data['image_path'] = $image['imagePath'];
        }

        return $data;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $response = Invoice::where('seller_id', $this->userID())->first();

        if ($response) {

            $this->data = $response;

            $this->data['image'] = ($response['image_name'] === 'avatar.svg' ? $this->getImagePath($response['image_path']) : $this->getStorageImagePath($response['image_path']));

            return $this->success();

        }else{

            $this->data =[
                "name" => "Jeem Company",
                "image" => $this->getImagePath('images/default/logo.svg')
            ];

            return $this->success();
        }

        // die;
    }

    public function show($id)
    {
        $this->data = $response = Invoice::where('id', $id)->where('seller_id', $this->userID())->first();

        $this->data['image'] = $this->getStorageImagePath($response['image_path']);

        return $this->success();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(invoiceRequest $request)
    {
        $data = $this->retriveData($request);

        $check = Invoice::where('seller_id', $this->userID())->get()->count();

        if(!$check){

            Invoice::create($data);

            $this->message = $this->CREATE_TRANSLATE('INVOICE');

            return $this->success();

        }

        $this->message = 'Invoice Already Found';

        return $this->error();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(invoiceRequest $request, Invoice $invoice)
    {

        Invoice::where('id', $invoice->id)->where('seller_id', $this->userID())->update($this->retriveData($request));

        if ($request->hasFile('logo')) {

            Storage::delete($invoice->image_path);
        }

        $this->message = $this->UPDATE_TRANSLATE('INVOICE');

        return $this->success();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
      * @return \Illuminate\Http\Response
     */
    public function destroy(Invoice $invoice)
    {
        $check = Invoice::where('id', $invoice->id)->where('seller_id', $this->userID())->delete();

        if ($check) {

            Storage::delete($invoice->image_path);

            $this->message = $this->DELETE_TRANSLATE('INVOICE');

            return $this->success();

        }else{

            $this->message = $this->FAILED_DELETE_TRANSLATE('INVOICE');

            return $this->error();
        }
    }
}
