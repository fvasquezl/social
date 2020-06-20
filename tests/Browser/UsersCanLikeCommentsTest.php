<?php

namespace Tests\Browser;

use App\Models\Comment;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class UsersCanLikeCommentsTest extends DuskTestCase
{
    use DatabaseMigrations;
    /**
     * A Dusk test example.
     *
     * @test
     * @throws \Throwable
     */
    public function users_can_like_unlike_comment()
    {
        $user = factory(User::class)->create();
        $comment = factory(Comment::class)->create();

        $this->browse(function (Browser $browser) use ($user, $comment) {
            $browser->loginAs($user)
                ->visit('/')
                ->waitForText($comment->body)
                ->assertSeeIn('@comment-likes-count', 0)
                ->press('@comment-like-btn')
                ->waitForText('YOU LIKE')
                ->assertSee('YOU LIKE')
                ->assertSeeIn('@comment-likes-count', 1)
                ->press('@comment-like-btn')
                ->waitForText('I LIKE')
                ->assertSee('I LIKE')
                ->assertSeeIn('@comment-likes-count', 0);
        });
    }
}
