<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

/**
 * Channel untuk notifikasi user
 * Hanya user yang bersangkutan yang bisa akses channel ini
 */
Broadcast::channel('notifikasi-user.{userId}', function ($user, $userId) {
    return (int) $user->id === (int) $userId;
});
