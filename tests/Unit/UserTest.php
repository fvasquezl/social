<?php

namespace Tests\Unit;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

//use PHPUnit\Framework\TestCase;
use Tests\TestCase;

class UserTest extends TestCase
{

    /** @test */
    public function route_key_name_is_set_to_name()
    {
        $user= factory(User::class)->make();
        $this->assertEquals('name',$user->getRouteKeyName());
    }

    /** @test */
    public function user_has_a_link_to_their_profile()
    {
        $user= factory(User::class)->make();
        $this->assertEquals(route('users.show',$user),$user->link());
    }

    /** @test */
    public function user_has_avatar()
    {
        $user= factory(User::class)->make();
        $this->assertEquals('https://aprendible.com/images/default-avatar.jpg',$user->avatar());
    }
}
