<?php

namespace Tests\Feature;

use App\Events\StatusCreated;
use App\Http\Resources\StatusResource;
use App\Models\Status;
use App\User;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class CreateStatusTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function guest_users_cannot_create_statuses()
    {
        $response = $this->postJson(route('statuses.store'), ['body' => 'My first status']);

        $response->assertStatus(401);
    }

    /** @test */
    public function a_authenticated_user_can_create_statuses()
    {
        Event::fake([StatusCreated::class]);
        $user = factory(User::class)->create();
        $this->actingAs($user);

        $response = $this->postJson(route('statuses.store'), ['body' => 'My first status']);

        $response->assertJson([
            'data' => ['body' => 'My first status']
        ]);

        $this->assertDatabaseHas('statuses', [
            'user_id' => $user->id,
            'body' => 'My first status'
        ]);
    }

    /** @test */
    public function an_event_is_fired_when_a_status_is_created()
    {
        Event::fake([StatusCreated::class]);
        Broadcast::shouldReceive('socket')->andReturn('socket-id');


        $user = factory(User::class)->create();

        $this->actingAs($user)->postJson(route('statuses.store'), ['body' => 'My first status']);

        Event::assertDispatched(StatusCreated::class, function ($statusCreatedEvent) {
            $this->assertInstanceOf(ShouldBroadcast::class, $statusCreatedEvent);
            $this->assertInstanceOf(StatusResource::class, $statusCreatedEvent->status);
            $this->assertInstanceOf(Status::class, $statusCreatedEvent->status->resource);
            $this->assertEquals($statusCreatedEvent->status->id, Status::first()->id);
            $this->assertEquals('socket-id',
                $statusCreatedEvent->socket,
                'The event' . get_class($statusCreatedEvent) . ' must call the method "dontBroadcastToCurrentUser" in the constructor');
            return true;
        });

    }

    /** @test */
    public function a_status_requires_a_body()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);

        $response = $this->postJson(route('statuses.store'), ['body' => '']);

        $response->assertStatus(422);

        $response->assertJsonStructure([
            'message', 'errors' => ['body']
        ]);

    }

    /** @test */
    public function a_status_body_requires_a_minimum_length()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);

        $response = $this->postJson(route('statuses.store'), ['body' => 'asdf']);

        $response->assertStatus(422);

        $response->assertJsonStructure([
            'message', 'errors' => ['body']
        ]);

    }
}
