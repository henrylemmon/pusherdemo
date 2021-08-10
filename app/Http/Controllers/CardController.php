<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\User;
use Illuminate\Http\Request;
use App\Events\ScoreUpdated;

class CardController extends Controller
{
    /**
     * @throws \Exception
     */
    public function show(Card $card)
    {
        $user = auth()->user();
        $user->score = $user->score + $card->value;
        if ($user->save()) {
            event(new ScoreUpdated($user));
            return redirect()->back()->withValue($card->value);
        } else {
            throw new \Exception('What the fuck went wrong');
        }
    }

    public function leaderboard()
    {
        return User::all(['id', 'name', 'score']);
    }
}
