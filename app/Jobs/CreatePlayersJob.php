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
        $this->playerGenerator('goalkeeper', 3, $this->team_id);
        $this->playerGenerator('defender', 6, $this->team_id);
        $this->playerGenerator('midfielder', 6, $this->team_id);
        $this->playerGenerator('attacker', 5, $this->team_id);

        $team = Team::find($this->team_id);
        $team->setTeamValue();
        $team->save();
    }

    private function playerGenerator($playerType, $count, $teamId) {
        $faker = Container::getInstance()->make(Generator::class);

        for ($i = 0; $i < $count; $i++) {
            $player = new Player([
                'first_name' => $faker->firstNameMale(),
                'last_name' => $faker->lastName(),
                'country' => $faker->country()
            ]);

            $player->player_type = $playerType;
            $player->market_value = rand();
            $player->age =rand(18, 40);
            $player->team_id = $teamId;

            $player->save();
        }
    }
}