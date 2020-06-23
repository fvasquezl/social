<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class UsersCanRegisterTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * A Dusk test example.
     * @test
     * @throws \Throwable
     */
    public function user_can_register()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                ->type('name', 'FaustinoVasquez')
                ->type('first_name', 'Faustino')
                ->type('last_name', 'Vasquez')
                ->type('email', 'fvasquez@local.com')
                ->type('password', 'password')
                ->type('password_confirmation', 'password')
                ->press('@register-btn')
                ->assertPathIs('/')
                ->assertAuthenticated();
        });
    }

    /**
     * A Dusk test example.
     * @test
     * @throws \Throwable
     */
    public function user_cannot_register_with_invalid_information()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                ->type('name', '')
                ->press('@register-btn')
                ->assertPathIs('/register')
                ->assertPresent('.invalid-feedback');
        });
    }
}
