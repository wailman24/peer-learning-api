<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('chat.room.{roomId}', function ($user, $roomId) {
    return true; // You can add auth logic like checking if user belongs to the room
});
