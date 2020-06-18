<?php

namespace Tests\Unit\Models;

use App\Traits\HasLikes;
use App\User;
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
    public function a_state_has_many_comments()
    {
        $status = factory(Status::class)->create();
        factory(Comment::class)->create([
            'status_id' => $status->id
        ]);

        $this->assertInstanceOf(Comment::class, $status->comments->first());
    }

    /** @test */
    public function a_status_model_must_use_the_trait_has_likes()
    {
        $this->assertClassUsesTrait(HasLikes::class,Status::class);
    }

}
