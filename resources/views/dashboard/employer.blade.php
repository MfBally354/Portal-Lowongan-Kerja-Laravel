<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Employer Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('message'))
                <div class="mb-4 bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded">
                    {{ session('message') }}
                </div>
            @endif

            <!-- Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-600 text-sm">Total Jobs</div>
                    <div class="text-3xl font-bold">{{ $jobs->count() }}</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-600 text-sm">Total Applications</div>
                    <div class="text-3xl font-bold">{{ $totalApplications }}</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-600 text-sm">Active Jobs</div>
                    <div class="text-3xl font-bold">{{ $jobs->where('is_active', true)->count() }}</div>
                </div>
            </div>

            <!-- Actions -->
            <div class="mb-6 flex gap-4">
                <a href="{{ route('jobs.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Post New Job
                </a>
                <a href="{{ route('companies.edit', auth()->user()->company) }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Edit Company Profile
                </a>
            </div>

            <!-- Jobs List -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Your Job Posts</h3>
                    
                    @forelse($jobs as $job)
                        <div class="border-b py-4 last:border-b-0">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h4 class="font-semibold text-lg">{{ $job->title }}</h4>
                                    <p class="text-gray-600 text-sm">{{ $job->location }} • {{ ucfirst($job->type) }}</p>
                                    <p class="text-sm mt-2">Applications: <span class="font-semibold">{{ $job->applications_count }}</span></p>
                                </div>
                                <div class="flex gap-2">
                                    <a href="{{ route('jobs.edit', $job) }}" class="text-blue-600 hover:text-blue-800">Edit</a>
                                    <form action="{{ route('jobs.destroy', $job) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500">No jobs posted yet.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
