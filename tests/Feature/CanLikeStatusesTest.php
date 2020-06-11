<?php

namespace Tests\Feature;

use App\Models\Status;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CanLikeStatusesTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function an_authenticated_user_can_like_statuses()
    {
        $user = factory(User::class)->create();
        $status = factory(Status::class)->create();

        $this->actingAs($user)->postJson(route('statuses.likes.store',$status));
        $this->assertDatabaseHas('likes',[
            'user_id' => $user->id,
            'status_id' => $status->id,
        ]);
    }
}
