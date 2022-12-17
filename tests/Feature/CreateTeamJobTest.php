<?php

namespace Tests\Feature;

use App\Jobs\CreatePlayersJob;
use App\Jobs\CreateTeamJob;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Bus;

class CreateTeamJobTest extends TestCase
{
    private $user;

    public function setUp():void {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_it_will_dispatch_job_create_player()
    {
        Bus::fake([CreatePlayersJob::class]);

        CreateTeamJob::dispatchSync($this->user->id);

		Bus::assertDispatched(CreatePlayersJob::class, 1);
    }
}
