<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Team;
use App\Jobs\CreatePlayersJob;
use Faker\Generator;
use Illuminate\Container\Container;

class CreateTeamJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $user_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user_id)
    {
        $this->user_id = $user_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $faker = Container::getInstance()->make(Generator::class);

        $team = new Team([
            'name' => $faker->lexify(),
            'country' => $faker->country()
        ]);

        $team->user_id = $this->user_id;
        $team->save();

        CreatePlayersJob::dispatchSync($team->id);
    }
}
