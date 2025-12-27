<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Application Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <!-- Job Info -->
                    <div class="mb-6 pb-6 border-b">
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ $application->job->title }}</h3>
                        <p class="text-gray-600">{{ $application->job->company->name }}</p>
                    </div>

                    <!-- Applicant Info -->
                    <div class="mb-6">
                        <h4 class="font-semibold text-lg mb-3">Applicant Information</h4>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <span class="text-gray-600 text-sm">Name</span>
                                <p class="font-semibold">{{ $application->user->name }}</p>
                            </div>
                            <div>
                                <span class="text-gray-600 text-sm">Email</span>
                                <p class="font-semibold">{{ $application->user->email }}</p>
                            </div>
                            <div>
                                <span class="text-gray-600 text-sm">Applied Date</span>
                                <p class="font-semibold">{{ $application->created_at->format('M d, Y') }}</p>
                            </div>
                            <div>
                                <span class="text-gray-600 text-sm">Current Status</span>
                                <p class="font-semibold">
                                    <span class="px-2 py-1 rounded text-xs
                                        @if($application->status === 'accepted') bg-green-100 text-green-800
                                        @elseif($application->status === 'rejected') bg-red-100 text-red-800
                                        @elseif($application->status === 'interview') bg-blue-100 text-blue-800
                                        @elseif($application->status === 'reviewed') bg-purple-100 text-purple-800
                                        @else bg-yellow-100 text-yellow-800
                                        @endif">
                                        {{ ucfirst($application->status) }}
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Cover Letter -->
                    @if($application->cover_letter)
                        <div class="mb-6">
                            <h4 class="font-semibold text-lg mb-2">Cover Letter</h4>
                            <div class="bg-gray-50 p-4 rounded">
                                <p class="text-gray-700 whitespace-pre-line">{{ $application->cover_letter }}</p>
                            </div>
                        </div>
                    @endif

                    <!-- Resume -->
                    @if($application->resume)
                        <div class="mb-6">
                            <h4 class="font-semibold text-lg mb-2">Resume/CV</h4>
                            <a href="{{ asset('storage/' . $application->resume) }}" target="_blank" 
                                class="inline-flex items-center bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                📄 Download Resume
                            </a>
                        </div>
                    @endif

                    <!-- Update Status (Only for Employer) -->
                    @if(auth()->user()->id === $application->job->company->user_id)
                        <div class="border-t pt-6">
                            <h4 class="font-semibold text-lg mb-4">Update Application Status</h4>
                            <form action="{{ route('applications.updateStatus', $application) }}" method="POST">
                                @csrf
                                @method('PATCH')

                                <div class="flex gap-4 items-end">
                                    <div class="flex-1">
                                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                                        <select name="status" id="status" required
                                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            <option value="pending" {{ $application->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="reviewed" {{ $application->status === 'reviewed' ? 'selected' : '' }}>Reviewed</option>
                                            <option value="interview" {{ $application->status === 'interview' ? 'selected' : '' }}>Interview</option>
                                            <option value="accepted" {{ $application->status === 'accepted' ? 'selected' : '' }}>Accepted</option>
                                            <option value="rejected" {{ $application->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                                        </select>
                                    </div>
                                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded">
                                        Update Status
                                    </button>
                                </div>
                            </form>
                        </div>
                    @endif
                </div>
            </div>

            <div class="text-center">
                <a href="{{ route('dashboard') }}" class="text-blue-600 hover:underline">← Back to Dashboard</a>
            </div>
        </div>
    </div>
</x-app-layout>
