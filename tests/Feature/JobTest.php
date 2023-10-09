<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class JobTest extends TestCase
{
    public function test_apply_job() : void {
        $job = $this->job();
        $user = $this->user();
        Storage::fake('avatars');

        $file = UploadedFile::fake()->image('avatar.jpeg');
        $info = [
            'expected_salary' => 10000,
            'cv' => $file
        ];

        $response = $this->actingAs($user)->post("job/$job->id/application", $info)
            ->assertStatus(302);

        $this->assertDatabaseHas('job_applications', [
            'user_id' => $user->id,
            'job_id' => $job->id,
        ]);

        $response = $this->get("/jobs/$job->id")->assertSeeText('You have already to this job');
    }


    public function test_cancel_applied_job() : void {
        $job = $this->job();
        $user = $this->user();
        Storage::fake('avatars');

        $file = UploadedFile::fake()->image('avatar.jpeg');
        $info = [
            'expected_salary' => 10000,
            'cv' => $file
        ];

        $response = $this->actingAs($user)->post("job/$job->id/application", $info)
            ->assertStatus(302);

        $idApplication = $job->jobApplications()->where('user_id', '=', $user->id)->first();

        $this->delete("my-job-applications/$idApplication->id")->assertStatus(302);
        $this->assertEquals(session('success'), 'The job application was removed.');

        $this->assertDatabaseMissing('job_applications', [
            'user_id' => $user->id,
            'job_id' => $job->id,
        ]);

//        $this->delete("my-job-applications/$job2->id")->assertStatus(403);
    }


}
