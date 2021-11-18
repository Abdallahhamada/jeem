<?php

namespace App\Http\Controllers\Seller;

use App\Models\Post\Post;
use App\Models\Seller\Seller;
use App\Traits\defaultMessage;
use App\Traits\defaultSaveFiles;
use App\Http\Controllers\Controller;
use App\Http\Requests\postRequest;
use App\Models\Buyer\Buyer;
use App\Models\Post\commentPost;
use Illuminate\Support\Facades\Storage;
use App\Traits\checkAuthorizationSeller;
use App\Traits\translate;

class postController extends Controller
{
    use defaultMessage,translate, defaultSaveFiles, checkAuthorizationSeller;

    public function __construct()
    {

        $this->middleware('permission:all-posts',['only' => ['index']]);

        $this->middleware('permission:edit-post',['only' => ['update']]);

        $this->middleware('permission:create-post',['only' => ['create']]);

        $this->middleware('permission:delete-post',['only' => ['destroy']]);
    }

    /**
     * Retrive Data For Creating And Update.
     *
     * @return JSON
     */

    private function retriveData($request)
    {

        $data = [
            'content' => strip_tags($request->content),
            'seller_id' => $this->userID()
        ];

        if ($request->hasFile('image')) {

            $image = $this->storeFile($request, 'posts', 'image');

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
        $posts = Seller::find($this->userID())->posts;

        foreach($posts as $post){

            $commentCount = 0;

            $likeCount = 0;

            $comments = $post->comments;

            foreach($comments as $comment){

                if($comment->comment){

                    $commentCount +=  1;
                }

                if($comment->like){

                    $likeCount +=  1;
                }
            }

            $post->commentCount = $commentCount;

            $post->likeCount = $likeCount;
        }

        $this->data = $posts;

        return $this->success();
    }

    public function create(postRequest $request)
    {
        $data = $this->retriveData($request);

        Post::create($data);

        $this->message = $this->CREATE_TRANSLATE('POST');

        return $this->success();

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function comments(Post $post)
    {

        $comments = Post::where('seller_id',$this->userID())->where('id',$post->id)->first()->comments;

        foreach($comments as $comment){

            $comment->buyer =  Buyer::find($comment->buyer_id)->setVisible(['name']);
        }

        $this->data = $comments ;

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
        $this->data = $response = Post::where('id', $id)->where('seller_id', $this->userID())->first();

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
    public function update(postRequest $request, Post $post)
    {
        Post::where('id', $post->id)->where('seller_id', $this->userID())->update($this->retriveData($request));

        if ($request->hasFile('image')) {

            Storage::delete($post->image_path);
        }

        $this->message = $this->UPDATE_TRANSLATE('POST');

        return $this->success();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy(Post $post)
    {
        $check = Post::where('id', $post->id)->where('seller_id', $this->userID())->delete();

        commentPost::where('post_id',$post->id)->delete();

        if ($check) {

            Storage::delete($post->image_path);

            $this->message = $this->DELETE_TRANSLATE('POST');

            return $this->success();

        }else{

            $this->message = $this->FAILED_DELETE_TRANSLATE('POST');

            return $this->error();
        }
    }
}
