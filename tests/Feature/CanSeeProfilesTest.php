<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CanSeeProfilesTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function can_see_profiles_test()
    {
        $this->withoutExceptionHandling();

       factory(User::class)->create(['name'=>'Faustino']);

       $this->get('@Faustino')->assertSee('Faustino');

    }
}
