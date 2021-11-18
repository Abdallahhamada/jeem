<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Http\Requests\reviewRequest;
use App\Models\Review\Review;
use Illuminate\Support\Facades\Auth;
use App\Traits\defaultMessage;
use App\Traits\translate;

class reviewController extends Controller
{
    use defaultMessage,translate;

    public function index()
    {

        $reviews = Review::where('buyer_id', Auth::id())->get();

        foreach ($reviews  as $key => $item) {

            $product = Review::find($item->id)->products;

            $reviews[$key]['product'] = $product->title;
        }

        $this->data = $reviews;

        return $this->success();
    }

    public function store(reviewRequest $request)
    {

        Review::create([
            'buyer_id' => Auth::id(),
            'product_id' => $request->id,
            'content' => $request->content,
            'rating' => $request->count
        ]);

        $this->message = $this->CREATE_TRANSLATE('REVIEW');

        return $this->success();
    }

    public function update(reviewRequest $request)
    {
        Review::where('id', $request->review_id)->where('buyer_id', Auth::id())->update([
            'content' => $request->content,
            'rating' => $request->count
        ]);

        $this->message = $this->UPDATE_TRANSLATE('REVIEW');

        return $this->success();
    }

    public function destroy(Review $review)
    {
        Review::where('id', $review->id)->where('buyer_id', Auth::id())->delete();

        $this->message = $this->DELETE_TRANSLATE('REVIEW');

        return $this->success();
    }
}
