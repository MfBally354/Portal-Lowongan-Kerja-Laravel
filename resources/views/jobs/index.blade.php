<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Browse Jobs') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Search & Filter -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <form action="{{ route('jobs.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <input type="text" name="search" placeholder="Job title..." value="{{ request('search') }}"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <div>
                            <input type="text" name="location" placeholder="Location..." value="{{ request('location') }}"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <div>
                            <select name="type" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">All Types</option>
                                <option value="full-time" {{ request('type') === 'full-time' ? 'selected' : '' }}>Full Time</option>
                                <option value="part-time" {{ request('type') === 'part-time' ? 'selected' : '' }}>Part Time</option>
                                <option value="contract" {{ request('type') === 'contract' ? 'selected' : '' }}>Contract</option>
                                <option value="remote" {{ request('type') === 'remote' ? 'selected' : '' }}>Remote</option>
                            </select>
                        </div>
                        <div>
                            <button type="submit" class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Search
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Jobs List -->
            <div class="space-y-4">
                @forelse($jobs as $job)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition">
                        <div class="p-6">
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <div class="flex items-center gap-4 mb-2">
                                        @if($job->company->logo)
                                            <img src="{{ asset('storage/' . $job->company->logo) }}" alt="{{ $job->company->name }}" class="w-12 h-12 rounded">
                                        @else
                                            <div class="w-12 h-12 bg-gray-200 rounded flex items-center justify-center">
                                                <span class="text-xl font-bold text-gray-500">{{ substr($job->company->name, 0, 1) }}</span>
                                            </div>
                                        @endif
                                        <div>
                                            <h3 class="text-xl font-semibold text-gray-900">
                                                <a href="{{ route('jobs.show', $job) }}" class="hover:text-blue-600">
                                                    {{ $job->title }}
                                                </a>
                                            </h3>
                                            <p class="text-gray-600">{{ $job->company->name }}</p>
                                        </div>
                                    </div>
                                    
                                    <div class="flex flex-wrap gap-3 text-sm text-gray-600 mt-3">
                                        <span class="flex items-center">
                                            📍 {{ $job->location }}
                                        </span>
                                        <span class="flex items-center">
                                            💼 {{ ucfirst($job->type) }}
                                        </span>
                                        @if($job->salary_min && $job->salary_max)
                                            <span class="flex items-center">
                                                💰 ${{ number_format($job->salary_min) }} - ${{ number_format($job->salary_max) }}
                                            </span>
                                        @endif
                                        <span class="flex items-center text-gray-500">
                                            🕒 {{ $job->created_at->diffForHumans() }}
                                        </span>
                                    </div>

                                    @if($job->description)
                                        <p class="text-gray-700 mt-3 line-clamp-2">
                                            {{ Str::limit($job->description, 150) }}
                                        </p>
                                    @endif
                                </div>
                                
                                <div>
                                    <a href="{{ route('jobs.show', $job) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                        View Details
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-center text-gray-500">
                            No jobs found. Try adjusting your search criteria.
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $jobs->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
