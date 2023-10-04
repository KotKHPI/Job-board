<?php

namespace Tests\Feature;

use App\Models\Job;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
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
            ->get('/jobs/logout')->dd();

        $this->test_visit_not_auth_user_on_job_page();
    }
}
