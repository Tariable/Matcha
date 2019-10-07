<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Report extends Model
{
    protected $guarded = [];

    public function report($profile_id, $reported_id, $description)
    {
        Report::create(['profile_id' => $profile_id, 'reported_id' => $reported_id, 'description' => $description]);
        $reports = $this->where('reported_id', $reported_id)->count();
        if ($reports >= 3) {
            User::where('id', $reported_id)->update(['banned' => 1]);
        }
    }

    public function getReportedId($id)
    {
        return $this->where('profile_id', $id)->get()->pluck('reported_id')->toArray();
    }

}
