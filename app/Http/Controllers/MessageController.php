<?php

namespace App\Http\Controllers;

use App\Chat;
use App\Events\UpdateChat;
use App\Http\Requests\StoreMessage;
use App\Message;
use Illuminate\Support\Facades\DB;

class MessageController extends Controller
{
    protected $messageModel;

    public function __construct(Message $model){
        $this->messageModel = $model;
    }

    public function index(){
        return view('messages.show');
    }

    public function show($id){
        return response()->json($this->messageModel->getProfileMessages(auth()->id(), $id));
    }

    public function store(StoreMessage $request){
        $message = $this->messageModel->saveMessage($request->input(), auth()->id());
        $chat = Chat::where('id', $message->chat_id)->first();
        broadcast(new UpdateChat($chat));
        return response()->json($message);
    }
}
