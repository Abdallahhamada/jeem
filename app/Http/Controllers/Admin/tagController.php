<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tag\Tag;
use App\Models\Seller\Seller;
use App\Traits\defaultMessage;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Traits\translate;

class tagController extends Controller
{
    use defaultMessage,translate;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tags = Tag::where('tag_status',true)->get();

        foreach ($tags as $item) {

            $item->seller->setVisible(['name']);
        }

        $this->data = $tags;

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
        $this->data = $response = Tag::where('id', $id)->where('seller_id', $seller->id)->first();

        $this->data['image'] = $this->getStorageImagePath($response['image_path']);

        return $this->success();
    }

     /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Tag $tag)
    {

        Tag::find($tag->id)->update([
            'admin_status' => DB::raw('NOT admin_status')
        ]);

        $this->message = $this->STATUS_TRANSLATE('TAG');

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
        $check = Tag::where($tag->id)->delete();

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
