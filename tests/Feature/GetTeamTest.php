<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Team;
use App\Models\Player;
use Tests\TestCase;

class GetTeamTest extends TestCase
{
    private $user1;
    private $team1;

    private $user2;
    private $team2;

    public function setUp():void {
        parent::setUp();
        $this->user1 = User::factory()->create();
        $this->team1 = Team::factory()->for($this->user1)->create();

        $this->user2 = User::factory()->create();
        $this->team2 = Team::factory()->for($this->user2)->create();
    }

    public function test_get_team_succes()
    {
        $user1Token = $this->user1->createToken("API TOKEN")->plainTextToken;
        $response = $this->withoutExceptionHandling()->withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer '.$user1Token
        ])->getJson('api/teams/'.$this->team1->id);

        $response
            ->assertStatus(200)
            ->assertJsonPath('data.id', $this->team1->id);
    }

    public function test_get_team_failure()
    {
        $user1Token = $this->user1->createToken("API TOKEN")->plainTextToken;
        $response = $this->withoutExceptionHandling()->withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer '.$user1Token
        ])->getJson('api/teams/'.$this->team2->id);

        $response
            ->assertStatus(401)
            ->assertJsonPath('message', 'Permission Denied! You are not owner of this player\'s team.');
    }
}
