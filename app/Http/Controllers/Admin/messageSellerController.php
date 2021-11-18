<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Admin;
use App\Traits\defaultMessage;
use App\Models\Admin\messageSeller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\messageSellerRequest;
use App\Models\Seller\Seller;
use App\Traits\translate;

class messageSellerController extends Controller
{
    use defaultMessage,translate;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sellers = messageSeller::get();


        foreach ($sellers as $seller) {

            $seller->seller->setVisible(['name']);
        }

        $this->data = $sellers;

        return $this->success();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(messageSellerRequest $request, Seller $seller)
    {

        $admin = Admin::find(Auth::id());

        $reminder = $admin->reminder;

        if (messageSeller::where('seller_id', $seller->id)->exists()) {

            $sellerData = messageSeller::where('seller_id', $seller->id)->first();

            $sellerCount = $sellerData->count;

            if ($request->count > ($reminder + $sellerCount)) {

                $this->message = 'this\'s out your reminder';

                return $this->error();

            } else {

                $adminReminder = ($reminder + $sellerCount) - $request->count;

                Admin::where('id', Auth::id())->update([

                    'reminder' => $adminReminder
                ]);

                messageSeller::where('seller_id', $seller->id)->update([
                    'count' => $request->count
                ]);

                $this->message = $this->UPDATE_TRANSLATE('SELLER_MESSAGES');
            }
        } else {

            if ($request->count > $reminder) {

                $this->message = 'this\'s out your reminder';

                return $this->error();

            } else {

                $reminder = $reminder - $request->count;

                Admin::where('id', Auth::id())->update([
                    'reminder' => $reminder
                ]);

                messageSeller::create([
                    'seller_id' => $seller->id,
                    'count' => $request->count
                ]);

                $this->message = $this->CREATE_TRANSLATE('SELLER_MESSAGES');

                return $this->success();
            }
        }

        return $this->success();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Seller $seller, messageSeller $message)
    {

        $admin = Admin::find(Auth::id());

        $reminder = $admin->reminder;

        $sellerCount = $message->count;

        $adminReminder = ($reminder + $sellerCount);

        Admin::where('id', Auth::id())->update([

            'reminder' => $adminReminder
        ]);

        messageSeller::where('seller_id', $seller->id)->delete();

        $this->message = $this->DELETE_TRANSLATE('SELLER_MESSAGES');

        return $this->success();
    }
}
