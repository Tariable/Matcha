<?php

namespace App\Http\Controllers;

use App\Events\NewMessage;
use App\Http\Requests\StoreMessage;
use App\Message;

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
        broadcast(new NewMessage($message));
        return response()->json($message);
    }
}
