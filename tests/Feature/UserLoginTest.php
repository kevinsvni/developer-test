<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class UserLoginTest extends TestCase
{
    public function test_login_form()
    {
        $response = $this->get("/login");

        $response->assertStatus(200);
    }

    public function test_user_login()
    {
        $response = $this->post('/post-login', [
            'email' => 'user@example.com',
            'password' => '123password',
        ]);

        $response->assertRedirect('/login');
    }
}
