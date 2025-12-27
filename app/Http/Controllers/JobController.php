<?php

namespace App\Http\Controllers;

use App\Models\JobListing; // ← GANTI INI
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index(Request $request)
    {
        $query = JobListing::with('company') // ← GANTI INI
            ->where('is_active', true)
            ->where(function($q) {
                $q->whereNull('expires_at')
                  ->orWhere('expires_at', '>', now());
            });

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('location')) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $jobs = $query->latest()->paginate(10);

        return view('jobs.index', compact('jobs'));
    }

    public function show(JobListing $jobListing) // ← GANTI INI
    {
        $job = $jobListing; // ← TAMBAHKAN INI (biar variable tetap $job)
        $job->load('company', 'applications');
        return view('jobs.show', compact('job'));
    }

    public function create()
    {
        $company = auth()->user()->company;
        
        if (!$company) {
            return redirect()->route('companies.create')
                ->with('message', 'Please create your company profile first');
        }

        return view('jobs.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string',
            'type' => 'required|in:full-time,part-time,contract,remote',
            'category' => 'nullable|string',
            'salary_min' => 'nullable|numeric|min:0',
            'salary_max' => 'nullable|numeric|min:0',
            'requirements' => 'nullable|string',
            'expires_at' => 'nullable|date|after:today',
        ]);

        $validated['company_id'] = auth()->user()->company->id;

        JobListing::create($validated); // ← GANTI INI

        return redirect()->route('dashboard')->with('success', 'Job posted successfully');
    }

    public function edit(JobListing $jobListing) // ← GANTI INI
    {
        $job = $jobListing; // ← TAMBAHKAN INI
        $this->authorize('update', $job);
        return view('jobs.edit', compact('job'));
    }

    public function update(Request $request, JobListing $jobListing) // ← GANTI INI
    {
        $job = $jobListing; // ← TAMBAHKAN INI
        $this->authorize('update', $job);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string',
            'type' => 'required|in:full-time,part-time,contract,remote',
            'category' => 'nullable|string',
            'salary_min' => 'nullable|numeric|min:0',
            'salary_max' => 'nullable|numeric|min:0',
            'requirements' => 'nullable|string',
            'is_active' => 'boolean',
            'expires_at' => 'nullable|date',
        ]);

        $job->update($validated);

        return redirect()->route('dashboard')->with('success', 'Job updated successfully');
    }

    public function destroy(JobListing $jobListing) // ← GANTI INI
    {
        $job = $jobListing; // ← TAMBAHKAN INI
        $this->authorize('delete', $job);
        $job->delete();

        return redirect()->route('dashboard')->with('success', 'Job deleted successfully');
    }
}
