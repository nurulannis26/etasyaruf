<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotifController extends Controller
{
    public function notif(){
        $notification = array(
            'message' => 'Sedang Dalam Pengembangan!',
            'alert-type' => 'warning'
        );
        return back()->with($notification);
    }

}
