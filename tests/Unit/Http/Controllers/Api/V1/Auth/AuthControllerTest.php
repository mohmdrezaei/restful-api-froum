<?php

namespace Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Api\V1\Auth\AuthController;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    // test register
    public function test_register_should_be_validate()
    {
        $response = $this->postJson(route('auth.register'));
        $response->assertStatus(422);
    }

    public function test_new_user_can_register()
    {
        $response = $this->postJson(route('auth.register'), [
            'name' => 'mohammad rezaei',
            'email' => 'mhwmdrz9@gamil.com',
            'password' => '12345678'
        ]);
        $response->assertStatus(201);
    }

    //test login
    public function test_login_should_be_validate()
    {
        $response = $this->postJson(route('auth.login'));
        $response->assertStatus(422);
    }

    public function test_user_can_login_with_true_credentials()
    {
        $user = User::factory()->create();
        $response = $this->postJson(route('auth.login'), [
            'email' => $user->email,
            'password' => $user->password
        ]);
        $response->assertStatus(200);
    }

    public function test_show_user_info_if_logged_in()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route('auth.user'));
        $response->assertStatus(200);    }

    //test logout
    public function test_logged_in_user_can_logout()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->postJson(route('auth.logout'));
        $response->assertStatus(200);
    }
}
