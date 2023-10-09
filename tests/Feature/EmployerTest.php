<?php

namespace Tests\Feature;

use App\Models\Job;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EmployerTest extends TestCase
{
    public function test_create_job_as_employer() : void {
        $user = $this->user();
        $user2 = $this->user();
        $employer = $this->employer($user);
        $infoJob = [
            'title' => fake()->jobTitle,
            'location' => 'Test City',
            'salary' => fake()->numberBetween(5_000, 150_000),
            'description' => fake()->paragraphs(3, true),
            'experience' => fake()->randomElement(Job::$experience),
            'category' => fake()->randomElement(Job::$category),
        ];

        $response = $this->actingAs($user2)->post('my-jobs', $infoJob)->assertStatus(302);
        $this->assertEquals(session('error'), 'You need to register as an employer first!');
        $response = $this->actingAs($user)->post('my-jobs', $infoJob)->assertStatus(302);

        $this->assertDatabaseHas('jobs', [
            'title' => $infoJob['title'],
            'location' => $infoJob['location'],
            'salary' => $infoJob['salary'],
            'description' => $infoJob['description'],
            'experience' => $infoJob['experience'],
            'category' => $infoJob['category'],
        ]);

        $this->assertEquals(session('success'), 'Job created successfully');
    }

    public function test_delete_job_as_employer() : void {
        $user = $this->user();
        $employer = $this->employer($user);
        $infoJob = [
            'title' => fake()->jobTitle,
            'location' => 'Test City',
            'salary' => fake()->numberBetween(5_000, 150_000),
            'description' => fake()->paragraphs(3, true),
            'experience' => fake()->randomElement(Job::$experience),
            'category' => fake()->randomElement(Job::$category),
        ];

        $response = $this->actingAs($user)->post('my-jobs', $infoJob)->assertStatus(302);

        $this->assertDatabaseHas('jobs', [
            'title' => $infoJob['title'],
            'location' => $infoJob['location'],
            'salary' => $infoJob['salary'],
            'description' => $infoJob['description'],
            'experience' => $infoJob['experience'],
            'category' => $infoJob['category'],
        ]);

        $this->assertEquals(session('success'), 'Job created successfully');

        $job = Job::where('title', 'like', $infoJob['title'])->first();

        $response = $this->delete("my-jobs/$job->id")->assertStatus(302);

        $this->assertSoftDeleted('jobs', [
            'title' => $infoJob['title'],
            'location' => $infoJob['location'],
            'salary' => $infoJob['salary'],
            'description' => $infoJob['description'],
            'experience' => $infoJob['experience'],
            'category' => $infoJob['category'],
        ]);

        $this->assertEquals(session('success'), 'Job was deleted successfully');

    }
}
