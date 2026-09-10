<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <a href="{{ route('admin.jobs.index') }}" class="mr-4 text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </a>
                <h2 class="font-black text-3xl uppercase tracking-tighter text-richblack-900 leading-tight">
                    Job Posting #{{ $job->id }}
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-6">
        <!-- Main Details -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white  shadow-sm border border-gray-100 p-6 sm:p-8">
                <h3 class="text-lg font-medium text-gray-900 border-b pb-4 mb-4">Job Details</h3>

                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-6">
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Job Title</dt>
                        <dd class="mt-1 text-sm text-gray-900 font-semibold">{{ $job->title }}</dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Employment Type</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ ucfirst($job->type) }}</dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Location</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $job->location }}</dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Status</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $job->is_archived ? 'Archived' : 'Active' }}</dd>
                    </div>

                    <div class="sm:col-span-2">
                        <dt class="text-sm font-medium text-gray-500">Job Description</dt>
                        <dd class="mt-2 text-sm text-gray-700 whitespace-pre-wrap bg-gray-50 p-4 ">{{ $job->description }}</dd>
                    </div>

                    <div class="sm:col-span-2">
                        <dt class="text-sm font-medium text-gray-500">Requirements</dt>
                        <dd class="mt-2 text-sm text-gray-700 whitespace-pre-wrap bg-gray-50 p-4 ">{{ $job->requirements }}</dd>
                    </div>
                </dl>
            </div>

            <!-- Applications Section -->
            <div class="bg-white shadow-sm border border-gray-100 p-6 sm:p-8 mt-6">
                <h3 class="text-lg font-medium text-gray-900 border-b pb-4 mb-4">Applications ({{ $job->applications_count }})</h3>

                @if($job->applications->isEmpty())
                    <p class="text-gray-500 text-center py-8">No applications received yet.</p>
                @else
                    <div class="space-y-4">
                        @foreach($job->applications as $application)
                            <div class="border-t border-gray-100 pt-4">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <p class="font-medium text-gray-900">{{ $application->name }}</p>
                                        <p class="text-sm text-gray-500">{{ $application->email }}</p>
                                        @if($application->phone)
                                            <p class="text-sm text-gray-500">{{ $application->phone }}</p>
                                        @endif
                                    </div>
                                    <div class="text-right">
                                        <span class="px-2 py-1 text-xs rounded-full
                                            {{ $application->status === 'pending' ? 'bg-yellow-100 text-yellow-800' :
                                              ($application->status === 'reviewed' ? 'bg-blue-100 text-blue-800' :
                                              ($application->status === 'accepted' ? 'bg-green-100 text-green-800' :
                                              ($application->status === 'rejected' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800')))}}">
                                            {{ ucfirst($application->status) }}
                                        </span>
                                    </div>
                                </div>

                                @if($application->portfolio_path || $application->resume_path)
                                    <div class="mt-2 flex space-x-3 text-sm">
                                        @if($application->resume_path)
                                            <a href="{{ Storage::url($application->resume_path) }}" target="_blank" class="inline-flex items-center px-3 py-1 bg-white border border-gray-300 text-sm text-gray-700 hover:bg-gray-50">
                                                <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 2l4 4m0 0l-4 4m4-4H4a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2v-9"></path></svg>
                                                View Resume
                                            </a>
                                        @endif
                                        @if($application->portfolio_path)
                                            <a href="{{ Storage::url($application->portfolio_path) }}" target="_blank" class="inline-flex items-center px-3 py-1 bg-white border border-gray-300 text-sm text-gray-700 hover:bg-gray-50">
                                                <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.163 5.477 3 6.253v13C4.163 18.527 5.749 19 7.5 19s3.337-.477 4.5-1.253m0-13C13.168 5.477 14.754 5 16.5 5s1.663.477 2.5 1.253v13"></path></svg>
                                                View Portfolio
                                            </a>
                                        @endif
                                    </div>
                                @endif

                                @if($application->cover_letter)
                                    <div class="mt-2 prose max-w-none text-gray-700 whitespace-pre-wrap">
                                        <strong>Cover Letter:</strong><br>
                                        {{ $application->cover_letter }}
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <!-- Sidebar / Actions -->
        <div class="space-y-6">
            <!-- Job Status Management -->
            <div class="bg-white  shadow-sm border border-gray-100 p-6">
                <h3 class="text-base font-medium text-gray-900 mb-4">Job Status</h3>
                <form action="{{ route('admin.jobs.update', $job) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <x-input-label for="is_archived" value="Job Status" />
                        <div class="mt-1 flex items-center">
                            <input id="is_archived" type="checkbox" class="rounded border-gray-300 text-brand-500 shadow-sm focus:ring-[#E07B2A]" name="is_archived" value="1" {{ $job->is_archived ? 'checked' : '' }}>
                            <span class="ml-2 text-sm font-medium text-gray-700">{{ $job->is_archived ? 'Archived (Hidden from public)' : 'Active (Visible on public)' }}</span>
                        </div>
                    </div>

                    <button type="submit" class="w-flex justify-center py-1.5 px-3 border border-transparent  shadow-sm text-sm font-medium text-white bg-brand-500 hover:bg-brand-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                        Update Status
                    </button>
                </form>
            </div>

            <!-- Delete -->
            <div class="mt-4 text-center">
                <form action="{{ route('admin.jobs.destroy', $job) }}" method="POST" data-confirm="Are you sure you want to delete this job posting? This action cannot be undone.">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-sm text-red-600 hover:text-red-800 font-medium">Delete Job Posting</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>