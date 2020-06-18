<?php

namespace Tests\Unit\Models;

use App\User;
use App\Models\Like;
use App\Models\Status;
use App\Models\Comment;
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
    public function a_state_morph_many_likes()
    {
        $status = factory(Status::class)->create();

        factory(Like::class)->create([
            'likeable_id' =>$status->id,  //1
            'likeable_type' => get_class($status)  // App\\Models\\Status
        ]);

        $this->assertInstanceOf(Like::class, $status->likes->first());
    }


    /** @test */
    public function a_state_has_many_comments()
    {
        $status = factory(Status::class)->create();
        factory(Comment::class)->create([
            'status_id' => $status->id
        ]);

        $this->assertInstanceOf(Comment::class, $status->comments->first());
    }

    /** @test */
    public function a_state_can_be_liked_and_unlike()
    {
        $status = factory(Status::class)->create();

        $this->actingAs(factory(User::class)->create());

        $status->like();

        $this->assertEquals(1, $status->fresh()->likes->count());

        $status->unlike();

        $this->assertEquals(0, $status->fresh()->likes->count());

    }


    /** @test */
    public function a_status_can_be_liked_once()
    {
        $status = factory(Status::class)->create();

        $this->actingAs(factory(User::class)->create());

        $status->like();
        $this->assertEquals(1, $status->likes->count());

        $status->like();
        $this->assertEquals(1, $status->fresh()->likes->count());
    }


    /** @test */
    public function a_status_know_if_it_has_been_liked()
    {
        $status = factory(Status::class)->create();
        $this->assertFalse($status->isLiked());

        $this->actingAs(factory(User::class)->create());
        $this->assertFalse($status->isLiked());

        $status->like();
        $this->assertTrue($status->isLiked());
    }

    /** @test */
    public function a_status_knows_how_many_likes_it_has()
    {
        $status = factory(Status::class)->create();

        $this->assertEquals(0, $status->likesCount());

        factory(Like::class,2)->create([
            'likeable_id' =>$status->id,  //1
            'likeable_type' => get_class($status)  // App\\Models\\Status
        ]);

        $this->assertEquals(
            2,
            $status->likesCount()
        );
    }
}
