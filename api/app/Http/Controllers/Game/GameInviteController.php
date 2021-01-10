<?php

namespace App\Http\Controllers\Game;

use App\Http\Message;
use App\Models\GameInvite;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class GameInviteController extends Controller
{
    /**
     * Instantiate the controller
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Fetch game related to invite code
     *
     * @group Game management
     * @urlParam code string required 6-character Invite code Example: 1ADC31
     *
     * @param string $code
     * @return void
     */
    public function show(string $code)
    {
        return Message::ok('Game related to invite', GameInvite::findOrFail($code)->game->description());
    }

    /**
     * Destroy game invite
     *
     * User which is creating the team will be set as its owner
     *
     * @group Game management
     * @urlParam code string required 6-character Invite code Example: 1ADC31
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(string $code)
    {
        $invite = GameInvite::findOrFail($code);

        if ($invite->game->owner_id != Auth::id()) {
            return Message::error(403, 'Only game owner can delete invites');
        }

        $invite->delete();
        return Message::ok('Invite destroyed');
    }
}
