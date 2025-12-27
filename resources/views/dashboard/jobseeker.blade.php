<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Applications') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="mb-6">
                <a href="{{ route('jobs.index') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Browse Jobs
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Your Applications</h3>
                    
                    @forelse($applications as $application)
                        <div class="border-b py-4 last:border-b-0">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h4 class="font-semibold text-lg">{{ $application->job->title }}</h4>
                                    <p class="text-gray-600 text-sm">{{ $application->job->company->name }}</p>
                                    <p class="text-gray-600 text-sm">{{ $application->job->location }}</p>
                                    <p class="text-sm mt-2">
                                        Status: 
                                        <span class="px-2 py-1 rounded text-xs font-semibold
                                            @if($application->status === 'accepted') bg-green-100 text-green-800
                                            @elseif($application->status === 'rejected') bg-red-100 text-red-800
                                            @elseif($application->status === 'interview') bg-blue-100 text-blue-800
                                            @else bg-yellow-100 text-yellow-800
                                            @endif">
                                            {{ ucfirst($application->status) }}
                                        </span>
                                    </p>
                                    <p class="text-xs text-gray-500 mt-1">Applied {{ $application->created_at->diffForHumans() }}</p>
                                </div>
                                <div>
                                    <a href="{{ route('jobs.show', $application->job) }}" class="text-blue-600 hover:text-blue-800">View Job</a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500">You haven't applied to any jobs yet.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
