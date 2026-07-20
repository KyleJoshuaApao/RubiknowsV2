<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <a href="{{ route('admin.applications.index') }}" class="mr-4 text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </a>
                <div>
                    <h2 class="font-semibold text-2xl text-gray-800 leading-tight tracking-tight">
                        {{ $application->name }}'s Application
                    </h2>
                    <p class="text-sm text-gray-500 mt-1">Applying for: {{ $application->job ? $application->job->title : 'Removed Position' }}</p>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-6">
        <!-- Main Application Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Cover Letter -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 sm:p-8">
                <h3 class="text-lg font-medium text-gray-900 border-b pb-4 mb-4">Cover Letter / Message</h3>
                @if($application->cover_letter)
                    <div class="prose max-w-none text-gray-700 whitespace-pre-wrap">{{ $application->cover_letter }}</div>
                @else
                    <p class="text-gray-400 italic">No cover letter provided.</p>
                @endif
            </div>

            <!-- Documents -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 sm:p-8">
                <h3 class="text-lg font-medium text-gray-900 border-b pb-4 mb-4">Attached Documents</h3>
                
                <div class="space-y-4">
                    @if($application->resume_path)
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg border border-gray-200">
                            <div class="flex items-center">
                                <svg class="w-8 h-8 text-red-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Resume / CV</p>
                                    <p class="text-xs text-gray-500">Provided by applicant</p>
                                </div>
                            </div>
                            <a href="{{ Storage::url($application->resume_path) }}" target="_blank" class="px-3 py-1.5 bg-white border border-gray-300 rounded text-sm font-medium text-gray-700 hover:bg-gray-50 shadow-sm">View</a>
                        </div>
                    @else
                        <p class="text-sm text-gray-500 italic">No resume attached.</p>
                    @endif

                    @if($application->portfolio_path)
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg border border-gray-200">
                            <div class="flex items-center">
                                <svg class="w-8 h-8 text-blue-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Portfolio / Extra Material</p>
                                    <p class="text-xs text-gray-500">Provided by applicant</p>
                                </div>
                            </div>
                            <a href="{{ Storage::url($application->portfolio_path) }}" target="_blank" class="px-3 py-1.5 bg-white border border-gray-300 rounded text-sm font-medium text-gray-700 hover:bg-gray-50 shadow-sm">View</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar / Actions -->
        <div class="space-y-6">
            <!-- Applicant Contact -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-base font-medium text-gray-900 mb-4">Contact Details</h3>
                <div class="space-y-4">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        <a href="mailto:{{ $application->email }}" class="text-sm text-[#E07B2A] hover:underline">{{ $application->email }}</a>
                    </div>
                    @if($application->phone)
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            <span class="text-sm text-gray-700">{{ $application->phone }}</span>
                        </div>
                    @endif
                    <div class="pt-4 border-t border-gray-100">
                        <p class="text-xs text-gray-500">Applied on: {{ $application->created_at->format('F j, Y, g:i a') }}</p>
                    </div>
                </div>
            </div>

            <!-- Workflow Management -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-base font-medium text-gray-900 mb-4">Hiring Workflow</h3>
                <form action="{{ route('admin.applications.update', $application) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')
                    
                    <div>
                        <x-input-label for="status" value="Application Status" />
                        <select id="status" name="status" class="mt-1 block w-full text-sm border-gray-300 rounded-md shadow-sm focus:border-orange-500 focus:ring-orange-500">
                            <option value="Received" {{ $application->status === 'Received' ? 'selected' : '' }}>Received</option>
                            <option value="Under Review" {{ $application->status === 'Under Review' ? 'selected' : '' }}>Under Review</option>
                            <option value="Interview Scheduled" {{ $application->status === 'Interview Scheduled' ? 'selected' : '' }}>Interview Scheduled</option>
                            <option value="Accepted" {{ $application->status === 'Accepted' ? 'selected' : '' }}>Accepted</option>
                            <option value="Rejected" {{ $application->status === 'Rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                    </div>

                    <button type="submit" class="w-full flex justify-center py-1.5 px-3 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-[#E07B2A] hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                        Update Status
                    </button>
                </form>
            </div>

            <!-- Delete -->
            <div class="mt-4 text-center">
                <form action="{{ route('admin.applications.destroy', $application) }}" method="POST" data-confirm="Delete this application and all attached files forever? This action cannot be undone.">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-sm text-red-600 hover:text-red-800 font-medium">Delete Application</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
