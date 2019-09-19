<?php

namespace Tests\Feature;

use App\Preference;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PreferenceCreationTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_preference_can_be_created_without_tags()
    {
        $user = factory(User::class)->create();

        $this->withoutExceptionHandling();

        $response = $this->actingAs($user)->post('/preferences', [
            'lowerAge' => 18,
            'upperAge' => 28,
            'distance' => 20,
            'sex' => 'male',
        ]);

        $this->assertCount(1, Preference::all());
        $response->assertRedirect('/recs');
    }

    /** @test */
    public function a_preference_cant_be_created_with_lower_age_less_18()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->post('/preferences', [
            'lowerAge' => 17,
            'upperAge' => 28,
            'distance' => 20,
            'sex' => 'male',
        ]);

        $response->assertSessionHasErrors("lowerAge");
    }

    /** @test */
    public function a_preference_cant_be_created_with_lower_age_more_97()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->post('/preferences', [
            'lowerAge' => 98,
            'upperAge' => 28,
            'distance' => 20,
            'sex' => 'male',
        ]);

        $response->assertSessionHasErrors('lowerAge');
    }

    /** @test */
    public function a_preference_cant_be_created_with_upper_age_more_100()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->post('/preferences', [
            'lowerAge' => 18,
            'upperAge' => 101,
            'distance' => 20,
            'sex' => 'male',
        ]);

        $response->assertSessionHasErrors('upperAge');
    }

    /** @test */
    public function a_preference_cant_be_created_with_upper_age_less_21()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->post('/preferences', [
            'lowerAge' => 18,
            'upperAge' => 20,
            'distance' => 20,
            'sex' => 'male',
        ]);

        $response->assertSessionHasErrors('upperAge');
    }

    /** @test */
    public function a_preference_cant_be_created_with_distance_less_3()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->post('/preferences', [
            'lowerAge' => 18,
            'upperAge' => 21,
            'distance' => 2,
            'sex' => 'male',
        ]);

        $response->assertSessionHasErrors('distance');
    }

    /** @test */
    public function a_preference_cant_be_created_with_distance_more_100()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->post('/preferences', [
            'lowerAge' => 18,
            'upperAge' => 21,
            'distance' => 101,
            'sex' => 'male',
        ]);

        $response->assertSessionHasErrors('distance');
    }

    /** @test */
    public function lower_age_is_required()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->post('/preferences', [
            'lowerAge' => '',
            'upperAge' => 21,
            'distance' => 101,
            'sex' => 'male',
        ]);

        $response->assertSessionHasErrors('lowerAge');
    }

    /** @test */
    public function upper_age_is_required()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->post('/preferences', [
            'lowerAge' => 20,
            'upperAge' => '',
            'distance' => 101,
            'sex' => 'male',
        ]);

        $response->assertSessionHasErrors('upperAge');
    }

    /** @test */
    public function distance_is_required()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->post('/preferences', [
            'lowerAge' => 18,
            'upperAge' => 21,
            'distance' => '',
            'sex' => 'male',
        ]);

        $response->assertSessionHasErrors('distance');
    }

    /** @test */
    public function sex_is_required()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->post('/preferences', [
            'lowerAge' => 18,
            'upperAge' => 21,
            'distance' => 5,
            'sex' => '',
        ]);

        $response->assertSessionHasErrors('sex');
    }

    /** @test */
    public function sex_only_male_female_bi()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->post('/preferences', [
            'lowerAge' => 18,
            'upperAge' => 21,
            'distance' => 5,
            'sex' => 'b',
        ]);

        $response->assertSessionHasErrors('sex');
    }
}
