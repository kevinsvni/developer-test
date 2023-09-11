<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class UserRegisterTest extends TestCase
{
    public function test_registration_form(){
        $response = $this->get("/registration");

        $response->assertStatus(200);
    }

    public function test_user_duplication(){
        $user1 = User::make([
            'name' => 'KevinM',
            'email' => 'kvnm@gmail.com'
        ]);
        $user2 = User::make([
            'name' => 'KevinS',
            'email' => 'kvns@gmail.com'
        ]);

        $this->assertTrue($user1->name != $user2->name);
    }

    public function test_user_registration(){
        $response = $this->post('/post-registration',[
            'name' => 'KSz',
            'email' => 'kvnzdf@gmail.com',
            'password' => 'asd123',
        ]);

        $response->assertRedirect('/dashboard');
    }
}
