<?php

namespace App\Http\Controllers;

use App\Models\JobListing; // ← GANTI INI
use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class JobApplicationController extends Controller
{
    public function store(Request $request, JobListing $jobListing) // ← GANTI INI
    {
        $job = $jobListing; // ← TAMBAHKAN INI
        
        if ($job->hasApplied(auth()->id())) {
            return back()->with('error', 'You have already applied for this job');
        }

        $validated = $request->validate([
            'cover_letter' => 'nullable|string',
            'resume' => 'required|file|mimes:pdf,doc,docx|max:5120',
        ]);

        if ($request->hasFile('resume')) {
            $validated['resume'] = $request->file('resume')->store('resumes', 'public');
        }

        $validated['job_listing_id'] = $job->id; // ← GANTI dari job_id
        $validated['user_id'] = auth()->id();

        JobApplication::create($validated);

        return redirect()->route('jobs.show', $job)->with('success', 'Application submitted successfully');
    }

    public function show(JobApplication $application)
    {
        $this->authorize('view', $application);
        $application->load('user', 'job');
        
        return view('applications.show', compact('application'));
    }

    public function updateStatus(Request $request, JobApplication $application)
    {
        $this->authorize('update', $application);

        $validated = $request->validate([
            'status' => 'required|in:pending,reviewed,interview,accepted,rejected',
        ]);

        $application->update($validated);

        return back()->with('success', 'Application status updated');
    }
}
