<?php

namespace App\Http\Controllers;

use App\Chat;
use App\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    protected   $chatModel;
    protected   $profileModel;

    public      $chats = [];

    public function __construct(Chat $modelChat, Profile $modelProfile){
        $this->chatModel = $modelChat;
        $this->profileModel = $modelProfile;
    }

    public function updateChat($chat_id){
        $chat = $this->chatModel->getById($chat_id);
        return $this->prepareData($chat);
    }

    public function storeChat(){
        $this->chatModel->saveChat();
    }

    public function getMessages($chatId){
        $myId = auth()->id();
        $chat = $this->chatModel->getById($chatId);
        $chat->messages()->where('to', $myId)->update(['read' => 1]);
        return response()->json($chat->messages);
    }

    public function getChats(){
        $myProfile = Profile::whereId(auth()->id())->first();
        foreach ($myProfile->chats as $chat){
            array_push($this->chats, $this->prepareData($chat));
        }
        return response()->json($this->chats);
    }

    public function prepareData(Chat $chat){
        $currentChat = $chat;
        $currentChat->partner = $chat->partner()->first();
        $currentChat->photo = $currentChat->partner->photo()->first();
        $currentChat->message = $chat->messagesReverse()->first();
        $currentChat->unread = $chat->unreadMessages()->count();
        return $currentChat;
    }
}
