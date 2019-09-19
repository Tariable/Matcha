<?php

namespace Tests\Feature;

use App\Preference;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PreferenceEditTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    use RefreshDatabase;

    /** @test */
    public function a_user_cant_view_edit_page_if_preference_doesnt_exist()
    {
        $user = factory(User::class)->create();
        $response = $this->actingAs($user)->get('/preferences/edit');
        $response->assertRedirect('/preferences/create');
    }

    /** @test */
    public function a_user_can_edit_lower_age()
    {
        $user = factory(User::class)->create();
        factory(Preference::class)->create();
        $response = $this->actingAs($user)->post('/preferences/update', [
            'lowerAge' => 18,
            'upperAge' => 28,
            'distance' => 20,
            'sex' => 'male',
        ]);
        $newLowerAge = Preference::pluck('lowerAge')->first();
        $this->assertTrue($newLowerAge == '18');
        $this->assertCount(1, Preference::all());
    }

    /** @test */
    public function a_user_can_edit_upper_age()
    {
        $user = factory(User::class)->create();
        factory(Preference::class)->create();
        $response = $this->actingAs($user)->post('/preferences/update', [
            'lowerAge' => 18,
            'upperAge' => 60,
            'distance' => 20,
            'sex' => 'male',
        ]);
        $newUpperAge = Preference::pluck('upperAge')->first();
        $this->assertTrue($newUpperAge == '60');
        $this->assertCount(1, Preference::all());
    }

    /** @test */
    public function a_user_can_edit_distance()
    {
        $user = factory(User::class)->create();
        factory(Preference::class)->create();
        $response = $this->actingAs($user)->post('/preferences/update', [
            'lowerAge' => 18,
            'upperAge' => 28,
            'distance' => 90,
            'sex' => 'male',
        ]);
        $newDistance = Preference::pluck('distance')->first();
        $this->assertTrue($newDistance == '90');
        $this->assertCount(1, Preference::all());
    }

    /** @test */
    public function a_user_can_edit_sex()
    {
        $user = factory(User::class)->create();
        factory(Preference::class)->create();
        $response = $this->actingAs($user)->post('/preferences/update', [
            'lowerAge' => 18,
            'upperAge' => 28,
            'distance' => 20,
            'sex' => '%ale',
        ]);
        $newSex = Preference::pluck('sex')->first();
        $this->assertTrue($newSex == '%ale');
        $this->assertCount(1, Preference::all());
    }

    /** @test */
    public function a_user_cant_edit_with_wrong_lowerAge()
    {
        $user = factory(User::class)->create();
        factory(Preference::class)->create();
        $response = $this->actingAs($user)->post('/preferences/update', [
            'lowerAge' => 17,
            'upperAge' => 28,
            'distance' => 20,
            'sex' => 'male',
        ]);
        $response->assertSessionHasErrors('lowerAge');
    }

    /** @test */
    public function a_user_cant_edit_with_wrong_upperAge()
    {
        $user = factory(User::class)->create();
        factory(Preference::class)->create();
        $response = $this->actingAs($user)->post('/preferences/update', [
            'lowerAge' => 18,
            'upperAge' => 101,
            'distance' => 20,
            'sex' => 'male',
        ]);
        $response->assertSessionHasErrors('upperAge');
    }

    /** @test */
    public function a_user_cant_edit_with_wrong_distance()
    {
        $user = factory(User::class)->create();
        factory(Preference::class)->create();
        $response = $this->actingAs($user)->post('/preferences/update', [
            'lowerAge' => 18,
            'upperAge' => 25,
            'distance' => 0,
            'sex' => 'male',
        ]);
        $response->assertSessionHasErrors('distance');
    }

}
