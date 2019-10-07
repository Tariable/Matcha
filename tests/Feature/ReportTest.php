<?php

namespace Tests\Feature;

use App\Profile;
use App\Report;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReportTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    use RefreshDatabase;

    /** @test */
    public function a_user_can_report()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();

        $this->actingAs($user)->post('/report', [
            'reported_id' => 5,
            'description' => 'Insulting behaviour',
        ]);
        $this->assertCount(1, Report::all());
    }

}

