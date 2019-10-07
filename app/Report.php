<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $guarded = [];

    public function report($profile_id, $reported_id, $description)
    {
        Report::create(['profile_id' => $profile_id, 'reported_id' => $reported_id, 'description' => $description]);
    }

    public function getReportedId($id)
    {
        return $this->where('profile_id', $id)->get()->pluck('reported_id')->toArray();
    }

}
