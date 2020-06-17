<?php

namespace Tests\Unit\Http\Resources;

use App\Http\Resources\CommentResource;
use App\Models\Status;
use Illuminate\Foundation\Testing\RefreshDatabase;

//use PHPUnit\Framework\TestCase;
use Tests\TestCase;

class CommentResourceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_comment_resource_must_have_the_necessary_fields()
    {
        $comment = factory(Status::class)->create();
        $commentResource = CommentResource::make($comment)->resolve();

        $this->assertEquals(
            $comment->body,
            $commentResource['body']
        );
        $this->assertEquals(
            $comment->user->name,
            $commentResource['user_name']
        );

        $this->assertEquals(
            'https://aprendible.com/images/default-avatar.jpg',
            $commentResource['user_avatar']
        );
    }
}
