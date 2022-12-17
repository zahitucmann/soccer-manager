<?php

namespace App\Http\Controllers\Api;

use App\Models\Player;
use App\Models\Team;
use Illuminate\Http\Request;

class PlayerController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $currentUserTeamId = Team::where('user_id', auth('sanctum')->user()->id)->first()->id;
        $players = Player::where('team_id', $currentUserTeamId)->get();

        return $this->successResponse($players);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $currentUserTeamId = Team::where('user_id', auth('sanctum')->user()->id)->first()->id;
        
        if ($id != $currentUserTeamId) {
            return $this->errorResponse('Permission Denied! You are not owner of this player\'s team.', 401);
        }

        $player = Player::find($id);

        return $this->successResponse($player);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $player = Player::findOrFail($id);

        if (Team::where('user_id', auth('sanctum')->user()->id)->first()->id != $player->team_id) {
            return $this->errorResponse('Permission Denied! You are not owner of this player\'s team.', 401);
        }

        $player->update($request->post());

        return $this->successResponse($player);
    }
}
