<?php namespace App\Http\Controllers;

use App\Http\Requests;

class NotificationsController extends Controller
{
    
    public function readAll()
    {
        \Notifynder::readAll(\Auth::User()->id);
        return view('layouts.application.notifications');
    }
    
    public function readNotification($notification_id)
    {
        \Notifynder::readOne($notification_id);
    }
    
}