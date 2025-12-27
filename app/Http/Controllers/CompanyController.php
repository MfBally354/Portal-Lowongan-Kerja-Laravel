<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CompanyController extends Controller
{
    public function create()
    {
        if (auth()->user()->company) {
            return redirect()->route('companies.edit', auth()->user()->company);
        }
        return view('companies.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'website' => 'nullable|url',
            'location' => 'nullable|string',
            'industry' => 'nullable|string',
            'logo' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $validated['user_id'] = auth()->id();

        Company::create($validated);

        return redirect()->route('dashboard')->with('success', 'Company created successfully');
    }

    public function edit(Company $company)
    {
        $this->authorize('update', $company);
        return view('companies.edit', compact('company'));
    }

    public function update(Request $request, Company $company)
    {
        $this->authorize('update', $company);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'website' => 'nullable|url',
            'location' => 'nullable|string',
            'industry' => 'nullable|string',
            'logo' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            if ($company->logo) {
                Storage::disk('public')->delete($company->logo);
            }
            $validated['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $company->update($validated);

        return redirect()->route('dashboard')->with('success', 'Company updated successfully');
    }
}
