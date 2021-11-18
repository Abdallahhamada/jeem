<?php

namespace App\Http\Controllers\Admin\Seller;

use App\Models\Seller\Seller;
use App\Traits\defaultMessage;
use App\Models\Carousel\Carousel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Traits\translate;

class carouselController extends Controller
{
    use defaultMessage,translate;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $this->data = Seller::find($id)->carousels;

        return $this->success();
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Seller $seller,$id)
    {
        $this->data = $response = Carousel::where('id', $id)->where('seller_id', $seller->id)->first();

        $this->data['image'] = $this->getStorageImagePath($response['image_path']);

        return $this->success();
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy(Seller $seller,Carousel $carousel)
    {

        $check = Carousel::where('id', $carousel->id)->where('seller_id', $seller->id)->delete();

        if ($check) {

            Storage::delete($carousel->image_path);

            $this->message = $this->DELETE_TRANSLATE('CAROUSEL');

            return $this->success();
        } else {

            $this->message = $this->FAILED_DELETE_TRANSLATE('CAROUSEL');

            return $this->error();
        }
    }
}
