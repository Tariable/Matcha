<?php

namespace Tests\Feature;

use App\Preference;
use App\Profile;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RecommendationsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_recs()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();

        $profile = factory(Profile::class)->create(
            ['name' => 'maleName',
            'gender' => 'male',
            'date_of_birth' => '2000-09-19',
            'latitude' => 55.75124,
            'longitude' => 37.618423,
            ]);

        $preference = factory(Preference::class)->create(
            ['lowerAge' => 18,
            'upperAge' => 28,
            'distance' => 100,
            'sex' => 'female',
            ]);

        $testingUser = factory(User::class)->create();

        $testingProfile = factory(Profile::class)->create(
            ['name' => 'femaleName',
            'gender' => 'female',
            'date_of_birth' => '2000-09-19',
            'latitude' => 55.751244,
            'longitude' => 37.618423,
            ]);

        $testingPrference = factory(Preference::class)->create(
            ['lowerAge' => 18,
            'upperAge' => 28,
            'distance' => 100,
            'sex' => 'male'
        ]);

        $this->assertCount(2, Profile::all());
        $this->assertCount(2, Preference::all());
        $this->assertCount(2, User::all());
        $response = $this->actingAs($user)->get('/recs');
    }
}
