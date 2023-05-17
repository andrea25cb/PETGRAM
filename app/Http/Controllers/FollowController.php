<?php

namespace App\Http\Controllers;

use App\Models\Follower;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FollowController extends Controller
{
    public function followUser($userId)
    {
        $followerId = Auth::id();
        $follower = Follower::firstOrCreate([
            'follower_id' => $followerId,
            'following_id' => $userId,
        ]);

        return back();
    }

    public function unfollowUser($userId)
    {
        $followerId = Auth::id();
        Follower::where('follower_id', $followerId)
            ->where('following_id', $userId)
            ->delete();

        return back();
    }
}
