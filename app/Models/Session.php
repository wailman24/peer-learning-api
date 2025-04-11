<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    protected $fillable = ['room_id', 'title', 'start_time', 'meet_link'];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
