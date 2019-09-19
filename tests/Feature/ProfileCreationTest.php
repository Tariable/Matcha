<?php

namespace Tests\Feature;

use App\Profile;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProfileCreationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_profile_can_be_created()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->post('/profiles', [
            'name' => 'ProfileName',
            'date_of_birth' => '2000-09-19',
            'description' => 'Profile_description',
            'gender' => 'male',
            'latitude' => 55.751244,
            'longitude' => 37.618423,
        ]);

        $this->assertCount(1, Profile::all());
    }

    /** @test */
    public function a_name_is_required()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->post('/profiles', [
            'name' => '',
            'date_of_birth' => '2000-09-19',
            'description' => 'Profile_description',
            'gender' => 'male',
            'latitude' => 55.751244,
            'longitude' => 37.618423,
        ]);

        $response->assertSessionHasErrors('name');
    }

    /** @test */
    public function a_name_must_have_min_2_character()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->post('/profiles', [
            'name' => '1',
            'date_of_birth' => '2000-09-19',
            'description' => 'Profile_description',
            'gender' => 'male',
            'latitude' => 55.751244,
            'longitude' => 37.618423,

        ]);
        $response->assertSessionHasErrors('name');
    }

    /** @test */
    public function a_name_must_have_max_60_character()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->post('/profiles', [
            'name' => 'jwefhlkjafhljkasdhalskdjfhalskdjfhlakjsdhflaksjdhflkajsdfhlja',
            'date_of_birth' => '2000-09-19',
            'description' => 'Profile_description',
            'gender' => 'male',
            'latitude' => 55.751244,
            'longitude' => 37.618423,

        ]);
        $response->assertSessionHasErrors('name');
    }

    /** @test */
    public function a_name_cant_have_numbers()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->post('/profiles', [
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
    public function a_date_of_birth_is_required()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->post('/profiles', [
            'name' => 'ProfileName',
            'date_of_birth' => '',
            'description' => 'Profile_description',
            'gender' => 'male',
            'latitude' => 55.751244,
            'longitude' => 37.618423,

        ]);


        $response->assertSessionHasErrors('date_of_birth');
    }

    /** @test */
    public function format_of_date_of_birth()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->post('/profiles', [
            'date_of_birth' => '05-03-1998',
            'name' => 'ProfileName',
            'description' => 'Profile_description',
            'gender' => 'male',
            'latitude' => 55.751244,
            'longitude' => 37.618423,

        ]);

        $response->assertSessionHasErrors('date_of_birth');
    }

    /** @test */
    public function age_must_be_over_18()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->post('/profiles', [
            'date_of_birth' => '05-09-2003',
            'name' => 'ProfileName',
            'description' => 'Profile_description',
            'gender' => 'male',
            'latitude' => 55.751244,
            'longitude' => 37.618423,

        ]);

        $response->assertSessionHasErrors('date_of_birth');
    }

    /** @test */
    public function age_must_be_less_than_100()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->post('/profiles', [
            'date_of_birth' => '21-08-1919',
            'name' => 'ProfileName',
            'description' => 'Profile_description',
            'gender' => 'male',
            'latitude' => 55.751244,
            'longitude' => 37.618423,
        ]);

        $response->assertSessionHasErrors('date_of_birth');
    }

    /** @test */
    public function a_description_is_required()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->post('/profiles', [
            'name' => 'ProfileName',
            'date_of_birth' => '2000-09-19',
            'description' => '',
            'gender' => 'male',
            'latitude' => 55.751244,
            'longitude' => 37.618423,
        ]);

        $response->assertSessionHasErrors('description');
    }

    /** @test */
    public function a_gender_is_required()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->post('/profiles', [
            'name' => 'ProfileName',
            'date_of_birth' => '2000-09-19',
            'description' => 'Profile_description',
            'gender' => '',
            'latitude' => 55.751244,
            'longitude' => 37.618423,

        ]);

        $response->assertSessionHasErrors('gender');
    }

    /** @test */
    public function a_gender_can_only_be_female_or_male()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->post('/profiles', [
            'name' => 'ProfileName',
            'date_of_birth' => '2000-09-19',
            'description' => 'Profile_description',
            'gender' => 'Male',
            'latitude' => 55.751244,
            'longitude' => 37.618423,
        ]);

        $response->assertSessionHasErrors('gender');
    }

    /** @test */
    public function a_latitude_is_required()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->post('/profiles', [
            'name' => 'ProfileName',
            'date_of_birth' => '2000-09-19',
            'description' => 'Profile_description',
            'gender' => 'male',
            'latitude' => '',
            'longitude' => 37.618423,

        ]);

        $response->assertSessionHasErrors('latitude');
    }

    /** @test */
    public function a_latitude_must_be_in_range_180()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->post('/profiles', [
            'name' => 'ProfileName',
            'date_of_birth' => '2000-09-19',
            'description' => 'Profile_description',
            'gender' => 'male',
            'latitude' => 189,
            'longitude' => 37.618423,

        ]);

        $response->assertSessionHasErrors('latitude');
    }

    /** @test */
    public function a_longitude_is_required()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->post('/profiles', [
            'name' => 'ProfileName',
            'date_of_birth' => '2000-09-19',
            'description' => 'Profile_description',
            'gender' => 'male',
            'latitude' => 55.751244,
            'longitude' => '',
        ]);

        $response->assertSessionHasErrors('longitude');
    }

    /** @test */
    public function a_longitude_must_be_in_range_90()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->post('/profiles', [
            'name' => 'ProfileName',
            'date_of_birth' => '2000-09-19',
            'description' => 'Profile_description',
            'gender' => 'male',
            'latitude' => 55.751244,
            'longitude' => -90.34,
        ]);

        $response->assertSessionHasErrors('longitude');
    }
}
