<?php

namespace App\Http\Controllers;

use App\Events\NewMessage;
use App\Models\Message;
use Illuminate\Http\Request;
use Nette\Utils\Random;

class AppController extends Controller
{
    //
    public function __construct()
    {
        $message = new Message;
        $message->message = Random::generate('12');
        $message->save();

        //calls an event
        event(new NewMessage($message));
    }
}
