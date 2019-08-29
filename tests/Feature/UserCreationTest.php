<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Hash;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserCreationTest extends TestCase
{
    use RefreshDatabase;
    /** @test */

    public function a_user_can_be_registered()
    {

        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();
        dd($user->id());

        $response = $this->post('/register', [
            'email' => 'userEmail@test.com',
            'password' => 'qwerty',
            'password_confirmation' => 'qwerty',
        ]);

        $this->assertCount(1, User::all());
        $response->assertRedirect('/home');
    }

    /** @test */

    public function email_is_required()
    {

//      $this->withoutExceptionHandling();

        $response = $this->post('/register', [
            'email' => '',
            'password' => 'qwerty',
            'password_confirmation' => 'qwerty',
        ]);

        $response->assertSessionHasErrors('email');

    }

    /** @test */

    public function email_is_unique()
    {
        $this->withoutExceptionHandling();

        $this->post('/register', [
            'email' => 'test@test.com',
            'password' => 'qwerty',
            'password_confirmation' => 'qwerty',
        ]);

        $this->post('/register', [
            'email' => 'test@test.com',
            'password' => 'qwerty',
            'password_confirmation' => 'qwerty',
        ]);

        $this->assertCount(1, User::all());

    }
}
