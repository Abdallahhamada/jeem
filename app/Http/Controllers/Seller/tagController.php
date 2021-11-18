<?php

namespace App\Http\Controllers\Seller;

use App\Models\Tag\Tag;
use App\Models\Seller\Seller;
use App\Traits\defaultMessage;
use App\Traits\defaultSaveFiles;
use App\Http\Requests\tagRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Traits\checkAuthorizationSeller;
use App\Traits\translate;

class tagController extends Controller
{
    use defaultMessage,translate, defaultSaveFiles, checkAuthorizationSeller;

    public function __construct()
    {

        $this->middleware('permission:all-tags',['only' => ['index']]);

        $this->middleware('permission:edit-tag',['only' => ['update']]);

        $this->middleware('permission:create-tag',['only' => ['create']]);

        $this->middleware('permission:delete-tag',['only' => ['destroy']]);
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
            'seller_id' => $this->userID()
        ];

        if ($request->hasFile('image')) {

            $image = $this->storeFile($request, 'tags', 'image');

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
        $this->data = Seller::find($this->userID())->tags;

        return $this->success();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(tagRequest $request)
    {

        if($this->checkAuthorization('tag_status','tag')){

            $data = $this->retriveData($request);

            Tag::create($data);

            $this->message = $this->CREATE_TRANSLATE('TAG');

            return $this->success();

        }else{
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
        $this->data = $response = Tag::where('id', $id)->where('seller_id', $this->userID())->first();

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
    public function update(tagRequest $request, Tag $tag)
    {
        Tag::where('id', $tag->id)->where('seller_id', $this->userID())->update($this->retriveData($request));

        if ($request->hasFile('image')) {

            Storage::delete($tag->image_path);
        }

        $this->message = $this->UPDATE_TRANSLATE('TAG');

        return $this->success();
    }

    /**
     * Update Tag Status
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function status(Tag $tag)
    {

        Tag::find($tag->id)->toggleStatus();

        $this->message = $this->STATUS_TRANSLATE('TAG');

        $this->data = [
            'status' => Tag::find($tag->id)->tag_status
        ];

        return $this->success();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag)
    {
        $check = Tag::where('id', $tag->id)->where('seller_id', $this->userID())->delete();

        if ($check) {

            Storage::delete($tag->image_path);

            $this->message = $this->DELETE_TRANSLATE('TAG');

            return $this->success();

        }else{

            $this->message = $this->FAILED_DELETE_TRANSLATE('TAG');

            return $this->error();
        }
    }
}
