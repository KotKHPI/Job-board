<?php

namespace App\Http\Controllers;

use App\Http\Requests\JobRequest;
use App\Models\Job;
use Illuminate\Http\Request;

class MyJobController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAnyEmployer', Job::class);
//        dd(auth()->user()->employer->jobs()->with(['employer', 'jobApplications', 'jobApplications.user'])->get());
        return view('my_job.index',
            ['jobs' => auth()->user()->employer->jobs()
                ->with(['employer', 'jobApplications', 'jobApplications.user'])
                ->latest()
                ->withTrashed()
                ->get()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Job::class);
        return view('my_job.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(JobRequest $request)
    {
        $this->authorize('create', Job::class);
        auth()->user()->employer->jobs()->create($request->validated());

        return redirect()->route('my-jobs.index')->with('success', 'Job created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('my_job.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Job $myJob)
    {
        $this->authorize('update', $myJob);
        return view('my_job.edit', ['job' => $myJob]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(JobRequest $request, Job $myJob)
    {
        $this->authorize('update', $myJob);
        $myJob->update($request->validated());

        return redirect()->route('my-jobs.index')->with('success', 'Job was updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Job $my_job)
    {
        $my_job->delete();

        return redirect()->route('my-jobs.index')->with('success', 'Job was deleted successfully');
    }
}
