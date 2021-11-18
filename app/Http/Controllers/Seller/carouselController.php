<?php

namespace App\Http\Controllers\Seller;

use App\Models\Seller\Seller;
use App\Traits\defaultMessage;
use App\Traits\defaultSaveFiles;
use App\Models\Carousel\Carousel;
use App\Traits\translate;
use App\Http\Controllers\Controller;
use App\Http\Requests\carouselRequest;
use Illuminate\Support\Facades\Storage;
use App\Traits\checkAuthorizationSeller;
use Illuminate\Support\Facades\App;

class carouselController extends Controller
{
    use defaultMessage,translate, defaultSaveFiles, checkAuthorizationSeller;

    public function __construct()
    {

        $this->middleware('permission:all-carousels', ['only' => ['index']]);

        $this->middleware('permission:edit-carousel', ['only' => ['update']]);

        $this->middleware('permission:create-carousel', ['only' => ['create']]);

        $this->middleware('permission:delete-carousel', ['only' => ['destroy']]);
    }

    /**
     * Retrive Data For Creating And Update.
     *
     * @return JSON
     */

    private function retriveData($request)
    {

        $data = [
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'seller_id' => $this->userID()
        ];

        if ($request->hasFile('image')) {

            $image = $this->storeFile($request, 'carousel', 'image');

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
        $this->data = Seller::find($this->userID())->carousels;

        return $this->success();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(carouselRequest $request)
    {


        $data = $this->retriveData($request);

        if ($this->checkAuthorization('carousel_status', 'carousel')) {

            Carousel::create($data);

            $this->message = $this->CREATE_TRANSLATE('CAROUSEL');

            return $this->success();

        } else {

            $this->message = __('tables.PERMISSION');

            return $this->error();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->data = $response = Carousel::where('id', $id)->where('seller_id', $this->userID())->first();

        $this->data['image'] = $this->getStorageImagePath($response['image_path']);

        return $this->success();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(carouselRequest $request, Carousel $carousel)
    {

        Carousel::where('id', $carousel->id)->where('seller_id', $this->userID())->update($this->retriveData($request));

        if ($request->hasFile('image')) {

            Storage::delete($carousel->image_path);
        }

        $this->message = $this->UPDATE_TRANSLATE('CAROUSEL');

        return $this->success();
    }

    /**
     * Update Carousel Status
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function status(Carousel $carousel)
    {


        Carousel::find($carousel->id)->toggleStatus();

        $this->data = [

            'status' => Carousel::find($carousel->id)->carousel_status
        ];

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

        $check = Carousel::where('id', $carousel->id)->where('seller_id', $this->userID())->delete();

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
