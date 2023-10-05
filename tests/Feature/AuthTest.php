<?php

namespace Tests\Feature;

use App\Models\Job;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class AuthTest extends TestCase
{
    private function createJob($empoyerId = null) : Job {
        return Job::factory()->create([
            'employer_id' => $empoyerId ?? $this->userIsEmployer()->id
        ]);
    }

    public function test_visit_not_auth_user_on_job_page() : void
    {
//        dd($this->user());
//        dd($this->createJob());

        $response = $this->get('/jobs/1');

        $response->assertStatus(403);
    }

    public function test_log_in() : void {
        $user = $this->user();

        $response = $this->actingAs($user)->get('/');

        $response->assertStatus(302);
    }

    public function test_log_out() : void {
        $user = $this->user();

        $response = $this->actingAs($user)
            ->delete("/auth/$user->id");

        $this->test_visit_not_auth_user_on_job_page();
    }

    public function test_registration() : void {
        $user = [
            'name' => 'catTest',
            'email' => fake()->unique()->safeEmail(),
            'password' => 'password', // password
            'password_confirmation' => 'password',
        ];

        $response = $this->post('/register', $user)->assertStatus(302)
        ->assertSessionHas('success');

        $this->assertEquals(session('success'), 'User was created!');

        $this->assertDatabaseHas('users', [
            'name' => $user['name']
        ]);

    }
}
