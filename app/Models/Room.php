<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Room extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'tutor_id'];

    public function tutor()
    {
        return $this->belongsTo(User::class, 'tutor_id');
    }

    public function students()
    {
        return $this->belongsToMany(User::class, 'room_user');
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function rating()
    {
        return $this->hasMany(Rating::class);
    }
}
