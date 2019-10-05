<?php

namespace App\Services;

use App\Chat;
use App\Events\NewMatch;
use App\Pivots\Subscription;
use App\Profile;
use App\Like;

class LikeService
{

    protected $profileModel;
    protected $chatModel;
    protected $likeModel;

    public function __construct(Profile $profileModel, Chat $chatModel, Like $likeModel)
    {
        $this->profileModel = $profileModel;
        $this->chatModel = $chatModel;
        $this->likeModel = $likeModel;
    }

    public function saveIfExist($profile_id, $partner_id)
    {
        if (Profile::where('id', $partner_id)->exists()) {
            if ($likeId = $this->likeModel->where('profile_id', $partner_id)->
            where('partner_id', $profile_id)->pluck('like_id')->toArray()) {
                $chat = Chat::create();
                Subscription::create(['chat_id' => $chat->id, 'profile_id' => $partner_id]);
                Subscription::create(['chat_id' => $chat->id, 'profile_id' => $profile_id]);
                $chat->messages()->create(['from' => 0, 'to' => $partner_id, 'text' => 'It\'s a match!']);
                broadcast(new NewMatch($chat));
                $this->likeModel->where('like_id', array_values($likeId))->delete();
                $responseMessage = 'It\'s a match';
            } else {
                $this->likeModel->create(['profile_id' => $profile_id, 'partner_id' => $partner_id]);
                $responseMessage = 'First like';
            }
        }
        return $responseMessage;
    }

    public function getLikeId($profile_id, $partner_id)
    {
        return $likeId = $this->likeModel->where('profile_id', $partner_id)->
        where('partner_id', $profile_id)->pluck('like_id')->toArray();
    }
}
