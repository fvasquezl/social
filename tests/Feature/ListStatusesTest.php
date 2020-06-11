<?php

namespace Tests\Feature;

use App\Models\Status;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ListStatusesTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function can_get_all_statuses()
    {
        $this->withoutExceptionHandling();

        $statuses1 = factory(Status::class)->create(['created_at'=>now()->subDays(4)]);
        $statuses2 = factory(Status::class)->create(['created_at'=>now()->subDays(3)]);
        $statuses3 = factory(Status::class)->create(['created_at'=>now()->subDays(2)]);
        $statuses4 = factory(Status::class)->create(['created_at'=>now()->subDays(1)]);

        $response = $this->getJson(route('statuses.index'));
        $response->assertSuccessful();
        $response->assertJson([
            'meta'=>['total' => 4]
        ]);
        $response->assertJsonStructure([
            'data', 'links'=> ['prev', 'next']
        ]);

        $this->assertEquals(
            $statuses4->body,
            $response->json('data.0.body')
       );
    }
}
