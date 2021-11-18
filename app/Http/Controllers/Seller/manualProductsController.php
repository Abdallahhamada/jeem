<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Http\Requests\manualProductRequest;
use App\Models\Product\manualProduct;
use App\Traits\defaultMessage;
use Illuminate\Http\Request;
use App\Imports\productsImport;
use App\Models\Buyer\manualBuyer;
use App\Models\Order\Order;
use App\Traits\checkAuthorizationSeller;
use App\Traits\translate;

class manualProductsController extends Controller
{
    use defaultMessage, checkAuthorizationSeller,translate;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $data = [
            "inside" => [],
            "outside" => []
        ];

        $products = Order::where('seller_id', $this->userID())->where('delivery_id', 11)->get();

        $manual_ids = manualBuyer::where('seller_id',$this->userID())->get();

        if($manual_ids->count() > 0) {

            foreach ($manual_ids as $id) {

                $manualProduct = manualProduct::where('buyer_id',$id->id)->get();

                foreach ($manualProduct as $value) {

                    $value->buyer->setVisible(['name', "address", "phone","tax"]);

                    array_push($data['outside'], $value->setHidden(['buyer_id']));
                }
            }

        }

        foreach ($products as $value) {

            $value->product->setVisible(['title']);

            $value->buyer->setVisible(['name']);

            if ($value->address) {

                $value->address->setVisible(['address']);
            }

            array_push($data['inside'], $value->setHidden(['buyer_id', 'seller_id', 'product_id', 'delivery_id']));
        }

        $this->data = $data;

        return $this->success();
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(manualProductRequest $request)
    {

        $sellerId = manualBuyer::create([
            "seller_id" => $this->userID(),
            "name" => $request->name,
            "tax" => $request->tax,
            "phone"  => $request->phone,
            "address" => $request->address
        ]);

        if ($request->file('file')) {

            $file = ((new productsImport)->toArray($request->file('file')))[0];

            for ($i = 0; $i < count($file); $i++) {

                manualProduct::create(
                    [
                        "buyer_id" => $sellerId->id,
                        "title" => $file[$i]['title'],
                        "descri" => $file[$i]['description'],
                        "price" => $file[$i]['price'],
                        "discount" => $file[$i]['discount'],
                        "count" => $file[$i]['count'],
                        "total" => $file[$i]['count'] * $file[$i]['price']
                    ]
                );
            }
        }

        if ($request->products) {

            $products = json_decode($request->products);

            for ($i = 0; $i < count($products); $i++) {

                manualProduct::create(
                    [
                        "buyer_id" => $sellerId->id,
                        "title" => $products[$i]->title,
                        "descri" => $products[$i]->description,
                        "price" => $products[$i]->price,
                        "discount" => $products[$i]->discount,
                        "count" => $products[$i]->count,
                        "total" => $products[$i]->count * $products[$i]->price
                    ]
                );
            }
        }

        if ($request->productsID) {

            $productsID = json_decode($request->productsID);

            for ($i = 0; $i < count($productsID); $i++) {

                manualProduct::create(
                    [
                        "buyer_id" => $sellerId->id,
                        "title" => $productsID[$i]->title,
                        "descri" => $productsID[$i]->descri,
                        "price" => $productsID[$i]->price,
                        "discount" => $productsID[$i]->discount,
                        "count" => $productsID[$i]->count,
                        "total" => $productsID[$i]->count * $productsID[$i]->price
                    ]
                );
            }
        }

        $this->message = $this->CREATE_TRANSLATE('PRODUCT');

        $this->data = manualProduct::where('buyer_id', $sellerId->id)->get();

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
    public function destroy(manualProduct $manual)
    {

        $check = manualProduct::where('id', $manual->id)->delete();

        if ($check) {

            $this->message = $this->DELETE_TRANSLATE('PRODUCT');

            return $this->success();
        } else {

            $this->message = $this->FAILED_DELETE_TRANSLATE('PRODUCT');

            return $this->error();
        }
    }
}
