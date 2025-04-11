<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Points extends Model
{
    protected $fillable = [
        'user_id',
        'points',
        'action',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
