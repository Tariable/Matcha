<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\IdFunctions;

class Preference extends Model
{
    use IdFunctions;

    protected $guarded = [];

    public function profile()
    {
        return $this->belongsTo(Profile::class, 'id');
    }
}
