<?php

namespace Tests\Browser;

use App\Models\Friendship;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class UsersCanRequestFriendShipTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * @test
     * @throws \Throwable
     */
    public function guest_cannot_create_friendship_requests()
    {
        $recipient = factory(User::class)->create();

        $this->browse(function (Browser $browser) use ($recipient) {
            $browser->visit(route('users.show', $recipient))
                ->press('@request-friendship')
                ->assertPathIs('/login')
            ;
        });
    }

    /**
     * @test
     * @throws \Throwable
     */
    public function senders_can_create_and_delete_friendship_requests()
    {
        $sender = factory(User::class)->create();
        $recipient = factory(User::class)->create();

        $this->browse(function (Browser $browser) use ($sender, $recipient) {
            $browser->loginAs($sender)
                ->visit(route('users.show', $recipient))
                ->press('@request-friendship')
                ->waitForText('Cancel request')
                ->assertSee('Cancel request')
                ->visit(route('users.show', $recipient))
                ->assertSee('Cancel request')
                ->press('@request-friendship')
                ->waitForText('Request friendship')
                ->assertSee('Request friendship')
            ;
        });
    }


    /**
     * @test
     * @throws \Throwable
     */
    public function a_user_cannot_send_friend_request_to_itself()
    {
        $user = factory(User::class)->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit(route('users.show', $user))
                ->assertMissing('@request-friendship')
                ->assertSee('Are you')
            ;
        });
    }

    /**
     * @test
     * @throws \Throwable
     */
    public function senders_can_delete_accepted_friendship_requests()
    {
        $sender = factory(User::class)->create();
        $recipient = factory(User::class)->create();

        Friendship::create([
            'sender_id' => $sender->id,
            'recipient_id' => $recipient->id,
            'status' => 'accepted'
        ]);


        $this->browse(function (Browser $browser) use ($sender, $recipient) {
            $browser->loginAs($sender)
                ->visit(route('users.show', $recipient))
                ->assertSee('Remove friendship')
                ->press('@request-friendship')
                ->waitForText('Request friendship')
                ->assertSee('Request friendship')
                ->visit(route('users.show', $recipient))
                ->assertSee('Request friendship')
            ;
        });
    }


    /**
     * @test
     * @throws \Throwable
     */
    public function senders_cannot_delete_denied_friendship_requests()
    {
        $sender = factory(User::class)->create();
        $recipient = factory(User::class)->create();

        Friendship::create([
            'sender_id' => $sender->id,
            'recipient_id' => $recipient->id,
            'status' => 'denied'
        ]);


        $this->browse(function (Browser $browser) use ($sender, $recipient) {
            $browser->loginAs($sender)
                ->visit(route('users.show', $recipient))
                ->assertSee('Friendship denied')
                ->press('@request-friendship')
                ->waitForText('Friendship denied')
                ->assertSee('Friendship denied')
                ->visit(route('users.show', $recipient))
                ->assertSee('Friendship denied')
            ;
        });
    }

    /**
     * @test
     * @throws \Throwable
     */
    public function recipients_can_accept_friendship_requests()
    {
        $sender = factory(User::class)->create();
        $recipient = factory(User::class)->create();


        Friendship::create([
            'sender_id' => $sender->id,
            'recipient_id' => $recipient->id
        ]);

        $this->browse(function (Browser $browser) use ($sender, $recipient) {
            $browser->loginAs($recipient)
                ->visit(route('accept-friendships.index'))
                ->assertSee($sender->name)
                ->press('@accept-friendship')
                ->waitForText('you are friends',7)
                ->assertSee('you are friends')
                ->visit(route('accept-friendships.index'))
                ->assertSee('you are friends')
            ;
        });
    }

    /**
     * @test
     * @throws \Throwable
     */
    public function recipients_can_deny_friendship_requests()
    {
        $sender = factory(User::class)->create();
        $recipient = factory(User::class)->create();


        Friendship::create([
            'sender_id' => $sender->id,
            'recipient_id' => $recipient->id
        ]);

        $this->browse(function (Browser $browser) use ($sender, $recipient) {
            $browser->loginAs($recipient)
                ->visit(route('accept-friendships.index'))
                ->assertSee($sender->name)
                ->press('@deny-friendship')
                ->waitForText('Denied request')
                ->assertSee('Denied request')
                ->visit(route('accept-friendships.index'))
                ->assertSee('Denied request')
            ;
        });
    }


    /**
     * @test
     * @throws \Throwable
     */
    public function recipients_can_delete_friendship_requests()
    {
        $sender = factory(User::class)->create();
        $recipient = factory(User::class)->create();


        Friendship::create([
            'sender_id' => $sender->id,
            'recipient_id' => $recipient->id
        ]);

        $this->browse(function (Browser $browser) use ($sender, $recipient) {
            $browser->loginAs($recipient)
                ->visit(route('accept-friendships.index'))
                ->assertSee($sender->name)
                ->press('@delete-friendship')
                ->waitForText('Request deleted')
                ->assertSee('Request deleted')
                ->visit(route('accept-friendships.index'))
                ->assertDontSee('Request deleted')
                ->assertDontSee($sender->name)
            ;
        });
    }
}
