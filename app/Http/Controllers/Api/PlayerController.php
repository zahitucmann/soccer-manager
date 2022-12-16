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
        $players = Player::all();

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

        $player->first_name = $request->first_name ? $request->first_name : $player->first_name;
        $player->last_name = $request->last_name ? $request->last_name : $player->last_name;
        $player->country = $request->country ? $request->country : $player->country;

        $player->save();

        return $this->successResponse($player);
    }
}
