<?php

namespace Tests\Unit\Http\Resources;

use App\Models\Status;
use Illuminate\Foundation\Testing\RefreshDatabase;
//use PHPUnit\Framework\TestCase;
use Tests\TestCase;

class StatusResourceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_status_resource_must_have_the_necessary_fields()
    {

        $status = factory(Status::class)->create();
    }
}
