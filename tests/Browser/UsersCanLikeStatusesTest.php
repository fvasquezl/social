<?php

namespace Tests\Browser;

use App\Models\Status;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class UsersCanLikeStatusesTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * A Dusk test example.
     *
     * @test
     * @throws \Throwable
     */
    public function users_can_like_unlike_statuses()
    {
        $user = factory(User::class)->create();
        $status = factory(Status::class)->create();

        $this->browse(function (Browser $browser) use ($user, $status) {
            $browser->loginAs($user)
                ->visit('/')
                ->waitForText($status->body)
                ->press('@like-btn')
                ->waitForText('You Liked')
                ->assertSee('You Liked')

                ->press('@unlike-btn')
                ->screenshot('button')
                ->waitForText('I Like')
                ->assertSee('I Like');

        });
    }
}
