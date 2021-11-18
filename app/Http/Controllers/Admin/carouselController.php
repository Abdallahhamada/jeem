<?php

namespace App\Http\Controllers\Admin;

use App\Models\Seller\Seller;
use App\Traits\defaultMessage;
use App\Models\Carousel\Carousel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
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
    public function index()
    {

        // return Carousel::where('carousel_status',1)->get();

        $user = Carousel::where('carousel_status',1)->get();

        foreach ($user as $key => $value) {

            $seller = Carousel::find($user[$key]->id)->sellers;

            $user[$key]['seller'] = $seller->name;

        }

        $this->data = $user;

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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Carousel $carousel)
    {
        Carousel::find($carousel->id)->update([
            'admin_status' => DB::raw('NOT admin_status')
        ]);

        $this->message = $this->STATUS_TRANSLATE('CAROUSEL');

        return $this->success();
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy(Carousel $carousel)
    {

        $check = Carousel::find($carousel->id)->delete();

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
