<?php

namespace App\Http\Controllers;

use App\Models\JobListing; // ← GANTI INI
use App\Models\JobApplication;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->isEmployer()) {
            $company = $user->company;
            
            if (!$company) {
                return redirect()->route('companies.create')
                    ->with('message', 'Please create your company profile first');
            }

            $jobs = $company->jobs()->withCount('applications')->latest()->get();
            $totalApplications = JobApplication::whereHas('job', function($q) use ($company) {
                $q->where('company_id', $company->id);
            })->count();

            return view('dashboard.employer', compact('jobs', 'totalApplications'));
        }

        $applications = $user->applications()->with('job.company')->latest()->get();
        return view('dashboard.jobseeker', compact('applications'));
    }
}
