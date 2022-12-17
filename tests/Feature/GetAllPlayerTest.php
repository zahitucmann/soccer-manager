<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Team;
use App\Models\Player;
use Tests\TestCase;

class GetAllPlayerTest extends TestCase
{
    private $user1;
    private $team1;

    private $user2;
    private $team2;

    public function setUp():void {
        parent::setUp();
        $this->user1 = User::factory()->create();
        $this->team1 = Team::factory()->for($this->user1)->create();
        $this->player1 = Player::factory()->for($this->team1)->create();
        $this->player2 = Player::factory()->for($this->team1)->create();
        $this->player3 = Player::factory()->for($this->team1)->create();
        $this->player4 = Player::factory()->for($this->team1)->create();

        $this->user2 = User::factory()->create();
        $this->team2 = Team::factory()->for($this->user2)->create();
        $this->player5 = Player::factory()->for($this->team2)->create();
    }

    public function test_get_all_player()
    {
        $user1Token = $this->user1->createToken("API TOKEN")->plainTextToken;
        $response = $this->withoutExceptionHandling()->withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer '.$user1Token
        ])->getJson('api/players');

        $response
            ->assertStatus(200)
            ->assertJsonCount(4, 'data');
    }
}
