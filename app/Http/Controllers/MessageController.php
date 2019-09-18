<?php

namespace App\Http\Controllers;

use App\Message;

class MessageController extends Controller
{
    protected $messageModel;

    public function __construct(Message $model){
        $this->messageModel = $model;
    }

    public function index()
    {
        return view('messages.show');
    }
}
