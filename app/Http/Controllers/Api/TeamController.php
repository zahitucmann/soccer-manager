<?php

namespace App\Http\Controllers\Api;

use App\Models\Team;
use Illuminate\Http\Request;

class TeamController extends BaseController
{
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
        
        $team = Team::find($id);

        return $this->successResponse($team);
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
        $currentUserTeamId = Team::where('user_id', auth('sanctum')->user()->id)->first()->id;
        $team = Team::findOrFail($id);

        if ($team->id != $currentUserTeamId) {
            return $this->errorResponse('Permission Denied! You are not owner of this player\'s team.', 401);
        }

        $team->update($request->post());

        return $this->successResponse($team);
    }
}
