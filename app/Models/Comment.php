<?php

namespace App\Models;
///54.183.27.104
use App\User;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $guarded=[];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    public function like()
    {
        $this->likes()->firstOrCreate([
            'user_id' => auth()->id()
        ]);
    }

    public function unlike()
    {
        $this->likes()->where([
            'user_id' => auth()->id()
        ])->delete();
    }

}
