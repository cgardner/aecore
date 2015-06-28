<?php namespace App\Http\Controllers;

use App\Http\Requests;

class NotificationsController extends Controller
{
    public function readNotificaton($id)
    {
        \Notifynder::readOne($id);
    }
}