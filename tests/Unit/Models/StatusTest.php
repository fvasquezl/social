<?php

namespace Tests\Unit\Models;

use App\Models\Like;
use App\Models\Status;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

//use PHPUnit\Framework\TestCase;
use Tests\TestCase;

class StatusTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_state_belongs_to_a_user()
    {
        $status = factory(Status::class)->create();
        $this->assertInstanceOf(User::class, $status->user);
    }

    /** @test */
    public function a_state_has_many_likes()
    {
        $status = factory(Status::class)->create();
        factory(Like::class)->create([
            'status_id'=>$status->id
        ]);

        $this->assertInstanceOf(Like::class, $status->likes->first());
    }


    /** @test */
    public function a_state_can_be_liked()
    {
        $status = factory(Status::class)->create();

        $this->actingAs(factory(User::class)->create());

        $status->like();
        $this->assertEquals(1,$status->likes->count());

    }


    /** @test */
    public function a_status_can_be_liked_once()
    {
        $status = factory(Status::class)->create();

        $this->actingAs(factory(User::class)->create());

        $status->like();
        $this->assertEquals(1,$status->likes->count());

        $status->like();
        $this->assertEquals(1,$status->fresh()->likes->count());
    }

}
