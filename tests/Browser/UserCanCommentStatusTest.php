<?php

namespace Tests\Browser;

use App\Models\Comment;
use App\Models\Status;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class UserCanCommentStatusTest extends DuskTestCase
{
    use DatabaseMigrations;


    /**
     * A Dusk test example.
     *
     * @test
     * @throws \Throwable
     */
    public function all_users_can_see_all_comments()
    {
        $status = factory(Status::class)->create();
        $comments = factory(Comment::class, 2)->create(['status_id' => $status->id]);

        $this->browse(function (Browser $browser) use ($status, $comments) {

            $browser->visit('/')->waitForText($status->body);

            foreach ($comments as $comment) {
                $browser->assertSee($comment->body)
                    ->assertSee($comment->user->name);
            }
        });
    }


    /**
     * A Dusk test example.
     *
     * @test
     * @throws \Throwable
     */
    public function authenticated_users_can_comment_statuses()
    {
        $status = factory(Status::class)->create();
        $user = factory(User::class)->create();
        $this->browse(function (Browser $browser) use ($status, $user) {
            $comment = 'My first comment';
            $browser->loginAs($user)
                ->visit('/')
                ->waitForText($status->body)
                ->type('comment', $comment)
                ->press('@comment-btn')
                ->waitForText($comment)
                ->assertSee($comment);
        });
    }

    /**
     * A Dusk test example.
     *
     * @test
     * @throws \Throwable
     */
    public function users_can_see_comment_in_real_time()
    {
        $status = factory(Status::class)->create();
        $user = factory(User::class)->create();

        $this->browse(function (Browser $browser1, Browser $browser2) use ($status, $user) {
            $comment = 'My first comment';

            $browser1->visit('/');

            $browser2->loginAs($user)
                ->visit('/')
                ->waitForText($status->body)
                ->type('comment', $comment)
                ->press('@comment-btn');

            $browser1->waitForText($comment)
                ->assertSee($comment);
        });
    }

}
