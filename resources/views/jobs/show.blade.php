<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $job->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <!-- Company Info -->
                    <div class="flex items-center gap-4 mb-6 pb-6 border-b">
                        @if($job->company->logo)
                            <img src="{{ asset('storage/' . $job->company->logo) }}" alt="{{ $job->company->name }}" class="w-16 h-16 rounded">
                        @else
                            <div class="w-16 h-16 bg-gray-200 rounded flex items-center justify-center">
                                <span class="text-2xl font-bold text-gray-500">{{ substr($job->company->name, 0, 1) }}</span>
                            </div>
                        @endif
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900">{{ $job->title }}</h3>
                            <p class="text-lg text-gray-600">{{ $job->company->name }}</p>
                            @if($job->company->website)
                                <a href="{{ $job->company->website }}" target="_blank" class="text-blue-600 hover:underline text-sm">
                                    Visit Website →
                                </a>
                            @endif
                        </div>
                    </div>

                    <!-- Job Details -->
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div>
                            <span class="text-gray-600 text-sm">Location</span>
                            <p class="font-semibold">{{ $job->location }}</p>
                        </div>
                        <div>
                            <span class="text-gray-600 text-sm">Job Type</span>
                            <p class="font-semibold">{{ ucfirst($job->type) }}</p>
                        </div>
                        @if($job->category)
                            <div>
                                <span class="text-gray-600 text-sm">Category</span>
                                <p class="font-semibold">{{ $job->category }}</p>
                            </div>
                        @endif
                        @if($job->salary_min && $job->salary_max)
                            <div>
                                <span class="text-gray-600 text-sm">Salary Range</span>
                                <p class="font-semibold">${{ number_format($job->salary_min) }} - ${{ number_format($job->salary_max) }}</p>
                            </div>
                        @endif
                    </div>

                    <!-- Description -->
                    <div class="mb-6">
                        <h4 class="font-semibold text-lg mb-2">Job Description</h4>
                        <p class="text-gray-700 whitespace-pre-line">{{ $job->description }}</p>
                    </div>

                    <!-- Requirements -->
                    @if($job->requirements)
                        <div class="mb-6">
                            <h4 class="font-semibold text-lg mb-2">Requirements</h4>
                            <p class="text-gray-700 whitespace-pre-line">{{ $job->requirements }}</p>
                        </div>
                    @endif

                    <!-- Apply Button or Status -->
                    @auth
                        @if(auth()->user()->isJobseeker())
                            @if($job->hasApplied(auth()->id()))
                                <div class="bg-gray-100 p-4 rounded text-center">
                                    <p class="text-gray-700 font-semibold">✅ You have already applied for this position</p>
                                </div>
                            @else
                                <!-- Application Form -->
                                <div class="border-t pt-6">
                                    <h4 class="font-semibold text-lg mb-4">Apply for this position</h4>
                                    <form action="{{ route('applications.store', $job) }}" method="POST" enctype="multipart/form-data">
                                        @csrf

                                        <div class="mb-4">
                                            <label for="cover_letter" class="block text-sm font-medium text-gray-700">Cover Letter</label>
                                            <textarea name="cover_letter" id="cover_letter" rows="6" 
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                                placeholder="Tell us why you're a great fit for this role...">{{ old('cover_letter') }}</textarea>
                                            @error('cover_letter')
                                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="mb-4">
                                            <label for="resume" class="block text-sm font-medium text-gray-700">Resume/CV *</label>
                                            <input type="file" name="resume" id="resume" accept=".pdf,.doc,.docx" required
                                                class="mt-1 block w-full">
                                            <p class="text-xs text-gray-500 mt-1">Accepted formats: PDF, DOC, DOCX (Max: 5MB)</p>
                                            @error('resume')
                                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded">
                                            Submit Application
                                        </button>
                                    </form>
                                </div>
                            @endif
                        @else
                            <div class="bg-blue-50 p-4 rounded">
                                <p class="text-blue-800">This feature is only available for job seekers.</p>
                            </div>
                        @endif
                    @else
                        <div class="bg-gray-100 p-4 rounded text-center">
                            <p class="text-gray-700 mb-3">Please login to apply for this job</p>
                            <a href="{{ route('login') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded inline-block">
                                Login
                            </a>
                        </div>
                    @endauth
                </div>
            </div>

            <div class="text-center">
                <a href="{{ route('jobs.index') }}" class="text-blue-600 hover:underline">← Back to all jobs</a>
            </div>
        </div>
    </div>
</x-app-layout>
