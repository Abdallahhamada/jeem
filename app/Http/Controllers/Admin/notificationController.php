<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Admin;
use App\Models\Admin\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\defaultMessage;
use Illuminate\Support\Facades\DB;
use App\Traits\translate;

class notificationController extends Controller
{
    use defaultMessage,translate;

    public function index(){

        $this->data = Notification::all();

        return $this->success();
    }

    public function store(Request $request){

        $request->validate([
            'token' => 'required|string'
        ]);

        Admin::find(Auth::id())->update([
            'token' => $request->token
        ]);
    }

    public function destroy(){

        DB::table('admin_notifications')->truncate();

        $this->message = $this->DELETE_TRANSLATE('NOTIFICATION');

        $this->success();
    }
}
