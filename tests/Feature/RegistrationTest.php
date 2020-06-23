<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tests\TestCase;

class RegistrationTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function users_can_register()
    {
        $this->get(route('register'))->assertSuccessful();

       $response = $this->post(route('register'), $this->userValidData());

       $response->assertRedirect('/');

       $this->assertDatabaseHas('users',[
           'name' => 'FaustinoVasquez_2',
           'first_name' => 'Faustino',
           'last_name' => 'Vasquez',
           'email' => 'fvasquez@local.com',
       ]);

       $this->assertTrue(
           Hash::check('password',User::first()->password), 'The password need to be hashed'
       );
    }


    //Name

    /** @test */
    public function the_name_is_required()
    {
        $this->post(
            route('register'),
            $this->userValidData(['name'=>null])
        )->assertSessionHasErrors('name');
    }

    /** @test */
    public function the_name_must_to_be_a_string()
    {
        $this->post(
            route('register'),
            $this->userValidData(['name'=>1234])
        )->assertSessionHasErrors('name');
    }

    /** @test */
    public function the_name_may_not_greater_than_60_characters()
    {
        $this->post(
            route('register'),
            $this->userValidData(['name'=>Str::random(61)])
        )->assertSessionHasErrors('name');
    }

    /** @test */
    public function the_name_must_be_unique()
    {
        factory(User::class)->create(['name'=>'FaustinoVasquez_2']);

        $this->post(
            route('register'),
            $this->userValidData()
        )->assertSessionHasErrors('name');
    }

    /** @test */
    public function the_name_may_only_contain_letters_and_numbers()
    {
        $this->post(
            route('register'),
            $this->userValidData(['name'=>'Faustino Vasquez'])
        )->assertSessionHasErrors('name');

        $this->post(
            route('register'),
            $this->userValidData(['name'=>'FaustinoVasquez<*>'])
        )->assertSessionHasErrors('name');
    }

    /** @test */
    public function the_name_must_be_at_least_3_characters()
    {
        $this->post(
            route('register'),
            $this->userValidData(['name'=>'as'])
        )->assertSessionHasErrors('name');
    }



    //First_name

    /** @test */
    public function the_first_name_is_required()
    {
        $this->post(
            route('register'),
            $this->userValidData(['first_name'=>null])
        )->assertSessionHasErrors('first_name');
    }

    /** @test */
    public function the_first_name_must_to_be_a_string()
    {
        $this->post(
            route('register'),
            $this->userValidData(['first_name'=>1234])
        )->assertSessionHasErrors('first_name');
    }

    /** @test */
    public function the_first_name_may_not_greater_than_60_characters()
    {
        $this->post(
            route('register'),
            $this->userValidData(['first_name'=>Str::random(61)])
        )->assertSessionHasErrors('first_name');
    }

    /** @test */
    public function the_first_name_may_only_contain_letters()
    {
        $this->post(
            route('register'),
            $this->userValidData(['first_name'=>'Faustino2'])
        )->assertSessionHasErrors('first_name');

        $this->post(
            route('register'),
            $this->userValidData(['first_name'=>'Faustino*'])
        )->assertSessionHasErrors('first_name');
    }

    /** @test */
    public function the_first_name_must_be_at_least_3_characters()
    {
        $this->post(
            route('register'),
            $this->userValidData(['first_name'=>'as'])
        )->assertSessionHasErrors('first_name');
    }



    //Last_name

    /** @test */
    public function the_last_name_is_required()
    {
        $this->post(
            route('register'),
            $this->userValidData(['last_name'=>null])
        )->assertSessionHasErrors('last_name');
    }

    /** @test */
    public function the_last_name_must_to_be_a_string()
    {
        $this->post(
            route('register'),
            $this->userValidData(['last_name'=>1234])
        )->assertSessionHasErrors('last_name');
    }

    /** @test */
    public function the_last_name_may_not_greater_than_60_characters()
    {
        $this->post(
            route('register'),
            $this->userValidData(['last_name'=>Str::random(61)])
        )->assertSessionHasErrors('last_name');
    }

    /** @test */
    public function the_last_name_may_only_contain_letters()
    {
        $this->post(
            route('register'),
            $this->userValidData(['last_name'=>'Vasquez2'])
        )->assertSessionHasErrors('last_name');

        $this->post(
            route('register'),
            $this->userValidData(['last_name'=>'Vasquez*'])
        )->assertSessionHasErrors('last_name');
    }

    /** @test */
    public function the_last_name_must_be_at_least_3_characters()
    {
        $this->post(
            route('register'),
            $this->userValidData(['last_name'=>'as'])
        )->assertSessionHasErrors('last_name');
    }



    //Email

    /** @test */
    public function the_email_is_required()
    {
        $this->post(
            route('register'),
            $this->userValidData(['email'=>null])
        )->assertSessionHasErrors('email');
    }


    /** @test */
    public function the_email_must_be_valid_address()
    {
        $this->post(
            route('register'),
            $this->userValidData(['email'=>'invalid@'])
        )->assertSessionHasErrors('email');
    }

    /** @test */
    public function the_email_must_be_unique()
    {
        factory(User::class)->create(['email'=>'fvasquez@local.com']);

        $this->post(
            route('register'),
            $this->userValidData()
        )->assertSessionHasErrors('email');
    }



    //Password

    /** @test */
    public function the_password_is_required()
    {
        $this->post(
            route('register'),
            $this->userValidData(['password'=>null])
        )->assertSessionHasErrors('password');
    }

    /** @test */
    public function the_password_must_to_be_a_string()
    {
        $this->post(
            route('register'),
            $this->userValidData(['password'=>1234])
        )->assertSessionHasErrors('password');
    }

    /** @test */
    public function the_password_must_be_at_least_8_characters()
    {
        $this->post(
            route('register'),
            $this->userValidData(['password'=>'asdfght'])
        )->assertSessionHasErrors('password');
    }

    /** @test */
    public function the_password_must_be_confirmed()
    {
        $this->post(
            route('register'),
            $this->userValidData([
                'password'=>'password',
                'password_confirmation' => null
            ])
        )->assertSessionHasErrors('password');
    }

    /**
     * @param array $overrides
     * @return string[]
     */
    public function userValidData($overrides=[]): array
    {
        return array_merge([
            'name' => 'FaustinoVasquez_2',
            'first_name' => 'Faustino',
            'last_name' => 'Vasquez',
            'email' => 'fvasquez@local.com',
            'password' => 'password',
            'password_confirmation' => 'password'
        ],$overrides);
    }
}
