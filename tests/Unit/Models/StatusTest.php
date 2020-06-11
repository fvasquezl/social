<?php

namespace Tests\Unit\Models;

use App\Models\Status;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

//use PHPUnit\Framework\TestCase;
use Tests\TestCase;

class StatusTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_state_belongs_to_a_user()
    {
        $status = factory(Status::class)->create();
        $this->assertInstanceOf(User::class, $status->user);
    }
}
