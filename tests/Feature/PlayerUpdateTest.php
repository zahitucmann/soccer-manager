<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Team;
use App\Models\Player;
use Tests\TestCase;

class PlayerUpdateTest extends TestCase
{
    private $user1;
    private $team1;
    private $player1;

    private $user2;
    private $team2;
    private $player2;

    public function setUp():void {
        parent::setUp();
        $this->user1 = User::factory()->create();
        $this->team1 = Team::factory()->for($this->user1)->create();
        $this->player1 = Player::factory()->for($this->team1)->create();

        $this->user2 = User::factory()->create();
        $this->team2 = Team::factory()->for($this->user2)->create();
        $this->player2 = Player::factory()->for($this->team2)->create();
    }

    public function test_player_update_success()
    {
        $user1Token = $this->user1->createToken("API TOKEN")->plainTextToken;
        $response = $this->withoutExceptionHandling()->withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer '.$user1Token
        ])->putJson('api/players/'.$this->player1->id, ['first_name' => 'updatedFirstName']);

        $response
            ->assertStatus(200)
            ->assertJsonPath('data.first_name', 'updatedFirstName');
    }

    public function test_player_update_failure()
    {
        $user1Token = $this->user1->createToken("API TOKEN")->plainTextToken;
        $response = $this->withoutExceptionHandling()->withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer '.$user1Token
        ])->putJson('api/players/'.$this->player2->id, ['firs_name' => 'updatedFirstName']);

        $response
            ->assertStatus(401)
            ->assertJsonPath('message', 'Permission Denied! You are not owner of this player\'s team.');
    }
}
