<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Traits\IdFunctions;
use App\Traits\ProfileScopes;

class Profile extends Model
{
    use IdFunctions;
    use ProfileScopes;

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

}
