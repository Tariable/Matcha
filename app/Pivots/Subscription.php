<?php


namespace App\Pivots;


use Illuminate\Database\Eloquent\Relations\Pivot;

class Subscription extends Pivot
{
    public function profile()
    {
        return $this->belongsTo('App\Profile');
    }

    public function chat()
    {
        return $this->belongsTo('App\Chat');
    }

    public function messages()
    {
        return $this->hasManyThrough('App\Message', 'App\Chat');
    }
}
