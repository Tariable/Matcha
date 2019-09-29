<?php

namespace App\Http\Controllers;

use App\Chat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    protected $chatModel;

    public function __construct(Chat $model){
        $this->chatModel = $model;
    }

    public function storeChat(){
        $this->chatModel->saveChat();
    }

    public function getMessages($chatId){
        $chat = $this->chatModel->getById($chatId);
        return response()->json($chat->messages);
    }

    public function getChats(){
        return response()->json($this->chatModel->getProfileChats(auth()->id()));
    }
}
