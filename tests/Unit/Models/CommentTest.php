<?php

namespace Tests\Unit\Models;

use App\Models\Comment;
use App\Models\Like;
use App\User;


use Illuminate\Foundation\Testing\RefreshDatabase;
//use PHPUnit\Framework\TestCase;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_comment_belongs_to_a_user()
    {

        $comment = factory( Comment::class)->create();

        $this->assertInstanceOf(User::class,$comment->user);
    }

    /** @test */
    public function a_comment_morph_many_likes()
    {
        $comment = factory( Comment::class)->create();

        factory(Like::class)->create([
            'likeable_id' =>$comment->id,  //1
            'likeable_type' => get_class($comment)  // App\\Models\\Comment
        ]);

        $this->assertInstanceOf(Like::class,$comment->likes->first());
    }

    /** @test */
    public function a_comment_can_be_liked_and_unlike()
    {
        $comment = factory(Comment::class)->create();

        $this->actingAs(factory(User::class)->create());

        $comment->like();

        $this->assertEquals(1, $comment->fresh()->likes->count());

        $comment->unlike();

        $this->assertEquals(0, $comment->fresh()->likes->count());

    }
}
