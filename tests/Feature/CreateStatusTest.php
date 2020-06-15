<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
    public function a_user_can_create_statuses()
    {

        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();
        $this->actingAs($user);

        $response = $this->postJson(route('statuses.store'), ['body' => 'My first status']);


        $response->assertJson([
           'data'=>['body' =>'My first status']
        ]);

        $this->assertDatabaseHas('statuses', [
            'user_id' => $user->id,
            'body' => 'My first status'
        ]);
    }


    /** @test */
    public function a_status_requires_a_body()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);

        $response = $this->postJson(route('statuses.store'), ['body' => '']);

        $response->assertStatus(422);

        $response->assertJsonStructure([
            'message','errors' =>['body']
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
            'message','errors' =>['body']
        ]);

    }
}
