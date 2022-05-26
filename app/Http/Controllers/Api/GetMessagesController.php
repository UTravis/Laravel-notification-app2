<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;

class GetMessagesController extends Controller
{
    //
    public function get()
    {
        $messages = Message::where('is_read', 0)->orderBy('id', 'desc')->get();
        return response()->json($messages);
    }

    //================= Mark Message As Read ==================\\
    public function update($id)
    {
        $message = Message::findOrFail($id);
        $message->is_read = 1;
        $message->save();

        return response()->json($message);
    }
}
