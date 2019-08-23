<?php

namespace Tests\Feature;

use App\Profile;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProfileCreationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_profile_can_be_created()
    {
        $response = $this->post('/profiles', [
            'name' => 'ProfileName',
            'date_of_birth' => '2000-09-19',
            'description' => 'Profile_description',
            'rating' => 100,
            'notification' => false,
            'tags' => '1;2;3',
            'gender' => 'Male',
            'current_latitude' => 55.751244,
            'current_longitude' => 37.618423,
        ]);

        $response->assertOk();
        $this->assertCount(1, Profile::all());
    }

    /** @test */
    public function a_name_is_required()
    {
        $response = $this->post('/profiles', [
            'name' => '',
            'date_of_birth' => '2000-09-19',
            'description' => 'Profile_description',
            'rating' => 100,
            'notification' => false,
            'tags' => '1;2;3',
            'gender' => 'Male',
            'current_latitude' => 55.751244,
            'current_longitude' => 37.618423,

        ]);

        $response->assertSessionHasErrors('name');
    }

    /** @test */
    public function a_name_must_have_min_2_character()
    {
        $response = $this->post('/profiles', [
            'name' => '1',
            'date_of_birth' => '2000-09-19',
            'description' => 'Profile_description',
            'rating' => 100,
            'notification' => false,
            'tags' => '1;2;3',
            'gender' => 'Male',
            'current_latitude' => 55.751244,
            'current_longitude' => 37.618423,

        ]);
        $response->assertSessionHasErrors('name');
    }

    /** @test */
    public function a_name_must_have_max_60_character()
    {
        $response = $this->post('/profiles', [
            'name' => '1111111111111111111111111111111111111111111111111111111111111',
            'date_of_birth' => '2000-09-19',
            'description' => 'Profile_description',
            'rating' => 100,
            'notification' => false,
            'tags' => '1;2;3',
            'gender' => 'Male',
            'current_latitude' => 55.751244,
            'current_longitude' => 37.618423,

        ]);
        $response->assertSessionHasErrors('name');
    }

    /** @test */
    public function a_date_of_birth_is_required()
    {
        $response = $this->post('/profiles', [
            'name' => 'ProfileName',
            'date_of_birth' => '',
            'description' => 'Profile_description',
            'rating' => 100,
            'notification' => false,
            'tags' => '1;2;3',
            'gender' => 'Male',
            'current_latitude' => 55.751244,
            'current_longitude' => 37.618423,

        ]);


        $response->assertSessionHasErrors('date_of_birth');
    }

    /** @test */
    public function format_of_date_of_birth()
    {
        $response = $this->post('/profiles', [
            'date_of_birth' => '05-03-1998',
            'name' => 'ProfileName',
            'description' => 'Profile_description',
            'rating' => 100,
            'notification' => false,
            'tags' => '1;2;3',
            'gender' => 'Male',
            'current_latitude' => 55.751244,
            'current_longitude' => 37.618423,

        ]);

        $response->assertSessionHasErrors('date_of_birth');
    }

    /** @test */
    public function age_must_be_over_18()
    {
        $response = $this->post('/profiles', [
            'date_of_birth' => '05-09-2003',
            'name' => 'ProfileName',
            'description' => 'Profile_description',
            'rating' => 100,
            'notification' => false,
            'tags' => '1;2;3',
            'gender' => 'Male',
            'current_latitude' => 55.751244,
            'current_longitude' => 37.618423,

        ]);

        $response->assertSessionHasErrors('date_of_birth');
    }

    /** @test */
    public function age_must_be_less_than_100()
    {
        $response = $this->post('/profiles', [
            'date_of_birth' => '21-08-1919',
            'name' => 'ProfileName',
            'description' => 'Profile_description',
            'rating' => 100,
            'notification' => false,
            'tags' => '1;2;3',
            'gender' => 'Male',
            'current_latitude' => 55.751244,
            'current_longitude' => 37.618423,
        ]);

        $response->assertSessionHasErrors('date_of_birth');
    }

    /** @test */
    public function a_description_is_required()
    {
        $response = $this->post('/profiles', [
            'name' => 'ProfileName',
            'date_of_birth' => '2000-09-19',
            'description' => '',
            'rating' => 100,
            'notification' => false,
            'tags' => '1;2;3',
            'gender' => 'Male',
            'current_latitude' => 55.751244,
            'current_longitude' => 37.618423,
        ]);

        $response->assertSessionHasErrors('description');
    }


    /** @test */
    public function a_rating_is_required()
    {
        $response = $this->post('/profiles', [
            'name' => 'ProfileName',
            'date_of_birth' => '2000-09-19',
            'description' => 'cool description',
            'rating' => '',
            'notification' => false,
            'tags' => '1;2;3',
            'gender' => 'Male',
            'current_latitude' => 55.751244,
            'current_longitude' => 37.618423,
        ]);

        $response->assertSessionHasErrors('rating');
    }

    /** @test */
    public function a_notification_is_required()
    {
        $response = $this->post('/profiles', [
            'name' => 'ProfileName',
            'date_of_birth' => '2000-09-19',
            'description' => 'cool description',
            'rating' => 50,
            'notification' => '',
            'tags' => '1;2;3',
            'gender' => 'Male',
            'current_latitude' => 55.751244,
            'current_longitude' => 37.618423,
        ]);

        $response->assertSessionHasErrors('notification');
    }

    /** @test */
    public function tags_can_be_empty()
    {
        $this->withoutExceptionHandling();
        $response = $this->post('/profiles', [
            'name' => 'ProfileName',
            'date_of_birth' => '2000-09-19',
            'description' => 'cool description',
            'rating' => 50,
            'notification' => true,
            'tags' => '',
            'gender' => 'Male',
            'current_latitude' => 55.751244,
            'current_longitude' => 37.618423,
        ]);

        $response->assertOk();
        $this->assertCount(1, Profile::all());
    }

    /** @test */
    public function a_gender_is_required()
    {
        $response = $this->post('/profiles', [
            'name' => 'ProfileName',
            'date_of_birth' => '2000-09-19',
            'description' => 'Profile_description',
            'rating' => 100,
            'notification' => false,
            'tags' => '1;2;3',
            'gender' => '',
            'current_latitude' => 55.751244,
            'current_longitude' => 37.618423,

        ]);

        $response->assertSessionHasErrors('gender');
    }

    /** @test */
    public function a_gender_can_only_be_Female_or_Male()
    {
        $response = $this->post('/profiles', [
            'name' => 'ProfileName',
            'date_of_birth' => '2000-09-19',
            'description' => 'Profile_description',
            'rating' => 100,
            'notification' => false,
            'tags' => '1;2;3',
            'gender' => 'male',
            'current_latitude' => 55.751244,
            'current_longitude' => 37.618423,
        ]);

        $response->assertSessionHasErrors('gender');
    }

    /** @test */
    public function a_current_latitude_is_required()
    {
        $response = $this->post('/profiles', [
            'name' => 'ProfileName',
            'date_of_birth' => '2000-09-19',
            'description' => 'Profile_description',
            'rating' => 100,
            'notification' => false,
            'tags' => '1;2;3',
            'gender' => 'Male',
            'current_latitude' => '',
            'current_longitude' => 37.618423,

        ]);

        $response->assertSessionHasErrors('current_latitude');
    }

    /** @test */
    public function a_current_latitude_must_be_in_range_180()
    {
        $response = $this->post('/profiles', [
            'name' => 'ProfileName',
            'date_of_birth' => '2000-09-19',
            'description' => 'Profile_description',
            'rating' => 100,
            'notification' => false,
            'tags' => '1;2;3',
            'gender' => 'Male',
            'current_latitude' => 189,
            'current_longitude' => 37.618423,

        ]);

        $response->assertSessionHasErrors('current_latitude');
    }

    /** @test */
    public function a_current_longitude_is_required()
    {
        $response = $this->post('/profiles', [
            'name' => 'ProfileName',
            'date_of_birth' => '2000-09-19',
            'description' => 'Profile_description',
            'rating' => 100,
            'notification' => false,
            'tags' => '1;2;3',
            'gender' => 'Male',
            'current_latitude' => 55.751244,
            'current_longitude' => '',
        ]);

        $response->assertSessionHasErrors('current_longitude');
    }

    /** @test */
    public function a_current_longitude_must_be_in_range_90()
    {
        $response = $this->post('/profiles', [
            'name' => 'ProfileName',
            'date_of_birth' => '2000-09-19',
            'description' => 'Profile_description',
            'rating' => 100,
            'notification' => false,
            'tags' => '1;2;3',
            'gender' => 'Male',
            'current_latitude' => 55.751244,
            'current_longitude' => -90.34,
        ]);

        $response->assertSessionHasErrors('current_longitude');
    }
}
