<?php

namespace Tests\Feature;

use App\Models\Friendship;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CanRequestFriendshipTest extends TestCase
{

    use RefreshDatabase;


    /** @test */
    public function guest_users_cannot_create_friendship_request()
    {

        $recipient = factory(User::class)->create();

        $response = $this->postJson(route('friendships.store', $recipient));

        $response->assertStatus(401);
    }

    /** @test */
    public function can_create_friendship_request()
    {
        $sender = factory(User::class)->create();
        $recipient = factory(User::class)->create();

        $response = $this->actingAs($sender)->postJson(route('friendships.store', $recipient));

        $response->assertJson([
            'friendship_status' => 'pending'
        ]);

        $this->assertDatabaseHas('friendships', [
            'sender_id' => $sender->id,
            'recipient_id' => $recipient->id,
            'status' => 'pending'
        ]);

        $this->actingAs($sender)->postJson(route('friendships.store', $recipient));
        $this->assertCount(1,Friendship::all());
    }

    /** @test */
    public function guest_users_cannot_delete_friendship_request()
    {

        $recipient = factory(User::class)->create();

        $response = $this->deleteJson(route('friendships.destroy', $recipient));

        $response->assertStatus(401);
    }

    /** @test */
    public function can_delete_friendship_request()
    {

        $sender = factory(User::class)->create();
        $recipient = factory(User::class)->create();

        Friendship::create([
            'sender_id' => $sender->id,
            'recipient_id' => $recipient->id,
        ]);

        $response = $this->actingAs($sender)->deleteJson(route('friendships.store', $recipient));

        $response->assertJson([
            'friendship_status' => 'deleted'
        ]);

        $this->assertDatabaseMissing('friendships', [
            'sender_id' => $sender->id,
            'recipient_id' => $recipient->id,
        ]);
    }


    /** @test */
    public function guest_users_cannot_accept_friendship_request()
    {

        $user = factory(User::class)->create();

        $response = $this->postJson(route('accept-friendships.store', $user));

        $response->assertStatus(401);
    }


    /** @test */
    public function can_accept_friendship_request()
    {
        $sender = factory(User::class)->create();
        $recipient = factory(User::class)->create();

        Friendship::create([
            'sender_id' => $sender->id,
            'recipient_id' => $recipient->id,
            'status' => 'pending'
        ]);

        $response= $this->actingAs($recipient)->postJson(route('accept-friendships.store', $sender));

        $response->assertJson([
            'friendship_status' => 'accepted'
        ]);

        $this->assertDatabaseHas('friendships', [
            'sender_id' => $sender->id,
            'recipient_id' => $recipient->id,
            'status' => 'accepted'
        ]);
    }

    /** @test */
    public function guest_users_cannot_deny_friendship_request()
    {

        $recipient = factory(User::class)->create();

        $response = $this->deleteJson(route('accept-friendships.store', $recipient));

        $response->assertStatus(401);
    }


    /** @test */
    public function can_deny_friendship_request()
    {

        $sender = factory(User::class)->create();
        $recipient = factory(User::class)->create();

        Friendship::create([
            'sender_id' => $sender->id,
            'recipient_id' => $recipient->id,
            'status' => 'pending'
        ]);

        $response= $this->actingAs($recipient)->deleteJson(route('accept-friendships.store', $sender));

        $response->assertJson([
            'friendship_status' => 'denied'
        ]);

        $this->assertDatabaseHas('friendships', [
            'sender_id' => $sender->id,
            'recipient_id' => $recipient->id,
            'status' => 'deny'
        ]);
    }
}
