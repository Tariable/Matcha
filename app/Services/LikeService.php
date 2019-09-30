<?php

namespace App\Services;

use App\Chat;
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
        if ($this->profileModel::where('id', $partner_id)->exists()) {
            if ($likeId = $this->getLikeId($profile_id, $partner_id)) {
                $this->chatModel->create(['profile_id' => $profile_id, 'partner_id' => $partner_id]);
                $this->likeModel->where('like_id', array_values($likeId))->delete();
            } else {
                $this->likeModel->create(['profile_id' => $profile_id, 'partner_id' => $partner_id]);
            }
        }
    }

    public function getLikeId($profile_id, $partner_id)
    {
        return $likeId = $this->likeModel->where('profile_id', $partner_id)->
        where('partner_id', $profile_id)->pluck('like_id')->toArray();
    }
}