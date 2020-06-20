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
    public function guest_users_cannot_like_statuses()
    {

        $status = factory(Status::class)->create();

        $this->browse(function (Browser $browser) use ($status) {
            $browser->visit('/')
                ->waitForText($status->body)
                ->press('@like-btn')
                ->assertPathIs('/login');
        });
    }


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
                ->assertSeeIn('@likes-count', 0)
                ->press('@like-btn')
                ->waitForText('YOU LIKE')
                ->assertSee('YOU LIKE')
                ->assertSeeIn('@likes-count', 1)
                ->press('@like-btn')
                ->waitForText('I LIKE')
                ->assertSee('I LIKE')
                ->assertSeeIn('@likes-count', 0);
        });
    }


}
