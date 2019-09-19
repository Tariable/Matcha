<?php

namespace Tests\Feature;

use App\Profile;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProfileEditTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    use RefreshDatabase;

    /** @test */
    public function a_user_cant_view_edit_page_if_profile_doesnt_exist()
    {
        $user = factory(User::class)->create();
        $response = $this->actingAs($user)->get('/profiles/edit');
        $response->assertRedirect('/profiles/create');
    }

    /** @test */
    public function a_user_can_edit_name()
    {
        $user = factory(User::class)->create();
        factory(Profile::class)->create();
        $this->actingAs($user)->post('/profiles/update', [
            'name' => 'ProfileName',
            'date_of_birth' => '2000-09-19',
            'description' => 'Profile_description',
            'gender' => 'male',
            'latitude' => 55.751244,
            'longitude' => 37.618423,
        ]);
        $newName = Profile::pluck('name')->first();
        $this->assertTrue($newName == 'ProfileName');
        $this->assertCount(1, Profile::all());
    }

    public function a_user_redirects_to_recs()
    {
        $user = factory(User::class)->create();
        factory(Profile::class)->create();
        $response = $this->actingAs($user)->post('/profiles/update', [
            'name' => 'ProfileName',
            'date_of_birth' => '2000-09-19',
            'description' => 'Profile_description',
            'gender' => 'male',
            'latitude' => 55.751244,
            'longitude' => 37.618423,
        ]);
        $response->assertRedirect('/recs');
    }

    /** @test */
    public function a_user_can_edit_date_of_birth()
    {
        $user = factory(User::class)->create();
        factory(Profile::class)->create();
        $this->actingAs($user)->post('/profiles/update', [
            'name' => 'ProfileName',
            'date_of_birth' => '2000-09-19',
            'description' => 'Profile_description',
            'gender' => 'male',
            'latitude' => 55.751244,
            'longitude' => 37.618423,
        ]);
        $newName = Profile::pluck('date_of_birth')->first();
        $this->assertTrue($newName == '2000-09-19');
        $this->assertCount(1, Profile::all());
    }

    /** @test */
    public function a_user_can_edit_gender()
    {
        $user = factory(User::class)->create();
        factory(Profile::class)->create();
        $this->actingAs($user)->post('/profiles/update', [
            'name' => 'ProfileName',
            'date_of_birth' => '2000-09-19',
            'description' => 'Profile_description',
            'gender' => 'female',
            'latitude' => 55.751244,
            'longitude' => 37.618423,
        ]);
        $newName = Profile::pluck('gender')->first();
        $this->assertTrue($newName == 'female');
        $this->assertCount(1, Profile::all());
    }

    /** @test */
    public function a_user_cant_edit_with_wrong_name()
    {
        $user = factory(User::class)->create();
        factory(Profile::class)->create();
        $response = $this->actingAs($user)->post('/profiles/update', [
            'name' => 'max1',
            'date_of_birth' => '2000-09-19',
            'description' => 'Profile_description',
            'gender' => 'male',
            'latitude' => 55.751244,
            'longitude' => 37.618423,
        ]);
        $response->assertSessionHasErrors('name');
    }

    /** @test */
    public function a_user_cant_edit_with_wrong_date_of_birth()
    {
        $user = factory(User::class)->create();
        factory(Profile::class)->create();
        $response = $this->actingAs($user)->post('/profiles/update', [
            'name' => 'max',
            'date_of_birth' => '1000-09-19',
            'description' => 'Profile_description',
            'gender' => 'male',
            'latitude' => 55.751244,
            'longitude' => 37.618423,
        ]);
        $response->assertSessionHasErrors('date_of_birth');
    }

    /** @test */
    public function a_user_cant_edit_with_wrong_gender()
    {
        $user = factory(User::class)->create();
        factory(Profile::class)->create();
        $response = $this->actingAs($user)->post('/profiles/update', [
            'name' => 'max1',
            'date_of_birth' => '2000-09-19',
            'description' => 'Profile_description',
            'gender' => '',
            'latitude' => 55.751244,
            'longitude' => 37.618423,
        ]);
        $response->assertSessionHasErrors('gender');
    }
}
