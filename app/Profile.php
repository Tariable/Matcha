<?php

namespace App;

use App\Pivots\Subscription;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use App\Traits\IdFunctions;

class Profile extends Model
{
    use IdFunctions;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'id');
    }

    public function photo()
    {
        return $this->hasMany(Photo::class, 'user_id');
    }

    public function preference()
    {
        return $this->hasOne(Preference::class, 'id');
    }

    public function like()
    {
        return $this->hasMany(Like::class, 'profile_id');
    }

    public function ban()
    {
        return $this->hasMany(Ban::class, 'profile_id');
    }

    public function chats()
    {
        return $this->belongsToMany(Chat::class, 'subscription')->using(Subscription::class);
    }

    public function messages()
    {
        return $this->hasManyThrough(
            Message::class,          // The model to access to
            Subscription::class, // The intermediate table that connects the User with the Podcast.
            'profile_id',                 // The column of the intermediate table that connects to this model by its ID.
            'chat_id',              // The column of the intermediate table that connects the Podcast by its ID.
            'id',                      // The column that connects this model with the intermediate model table.
            'chat_id'               // The column of the Audio Files table that ties it to the Podcast.
        );
    }

//    public function chats(){
//        return $this->belongsToMany(Chat::class, 'chat_profile');
//    }

    public function getAll(){
        return $this->take(20)->get();
    }

    public function getChatProfiles($myId){
        $profiles = $this->where('id', '!=', $myId)->get();

        $unreadIds = Message::select(\DB::raw('`from` as sender_id, count(`from`) as messages_count'))
            ->where('to', auth()->id())
            ->where('read', false)
            ->groupBy('from')
            ->get();

        $profiles = $profiles->map(function($contact) use ($unreadIds) {
            $contactUnread = $unreadIds->where('sender_id', $contact->id)->first();
            $contact->unread = $contactUnread ? $contactUnread->messages_count : 0;
            return $contact;
        });

        return $profiles;
    }

    public function getAge($profileId){
        $date = $this->whereId($profileId)->pluck('date_of_birth')->first();
        return Carbon::createFromFormat('Y-m-d', $date)->diffInYears(Carbon::now(), false);
    }

    //--------------------------------------scope section--------------------------------------//


    public function scopeCloseTo(Builder $query, $longitude, $latitude, $range)
    {
        return $query->whereRaw("
       ST_Distance_Sphere(
            point(longitude, latitude),
            point(?, ?)
        ) / 1000 < ?
    ", [
            $longitude,
            $latitude,
            $range,
        ]);
    }

    public function scopeInRange(Builder $query, $longitude, $latitude)
    {
        return $query->whereRaw("
       ST_Distance_Sphere(
            point(longitude, latitude),
            point(?, ?)
        ) / 1000 < distance
    ", [
            $longitude,
            $latitude,
        ]);
    }

}
