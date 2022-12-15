<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Player;
use App\Models\Team;
use Faker\Generator;
use Illuminate\Container\Container;

class CreatePlayersJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $team_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($team_id)
    {
        $this->team_id = $team_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $teamValue = 0;

        $teamValue = $this->playerGenerator('goalkeeper', 3, $this->team_id, $teamValue);
        $teamValue = $this->playerGenerator('defender', 6, $this->team_id, $teamValue);
        $teamValue = $this->playerGenerator('midfielder', 6, $this->team_id, $teamValue);
        $teamValue = $this->playerGenerator('attacker', 5, $this->team_id, $teamValue);

        Team::find($this->team_id)->update(['team_value' =>  $teamValue]);
    }

    private function playerGenerator($playerType, $count, $teamId, $teamValue) {
        $faker = Container::getInstance()->make(Generator::class);
        
        for ($i = 0; $i < $count; $i++) {
            $player = Player::create([
                'first_name' => $faker->firstNameMale(),
                'last_name' => $faker->lastName(),
                'country' => $faker->country(),
                'player_type' => $playerType,
                'market_value' => rand(),
                'age' => rand(18, 40),
                'team_id' => $teamId
            ]);

            $teamValue += $player->market_value;
        }

        return $teamValue;
    }
}
