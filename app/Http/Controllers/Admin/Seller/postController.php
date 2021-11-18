<?php

namespace App\Http\Controllers\Admin\Seller;

use App\Models\Post\Post;
use App\Models\Seller\Seller;
use App\Traits\defaultMessage;
use App\Http\Controllers\Controller;
use App\Http\Requests\postRequest;
use App\Models\Buyer\Buyer;
use App\Models\Post\commentPost;
use Illuminate\Support\Facades\Storage;
use App\Traits\checkAuthorizationSeller;
use App\Traits\translate;

class postController extends Controller
{
    use defaultMessage,translate;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $posts = Seller::find($id)->posts;

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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function comments(Seller $seller,Post $post)
    {

        $comments = Post::where('seller_id',$seller->id)->where('id',$post->id)->first()->comments;

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

    public function show(Seller $seller,$id)
    {
        $this->data = $response = Post::where('id', $id)->where('seller_id', $seller->id)->first();

        $this->data['image'] = $this->getStorageImagePath($response['image_path']);

        return $this->success();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy(Seller $seller,Post $post)
    {
        $check = Post::where('id', $post->id)->where('seller_id', $seller->id)->delete();

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
