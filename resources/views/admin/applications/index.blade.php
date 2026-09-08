<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-black text-3xl uppercase tracking-tighter text-richblack-900 leading-tight">
                    {{ __('Applicant Tracking') }}
                </h2>
                <p class="text-sm font-bold uppercase tracking-widest text-gray-500 mt-2">Review resumes and manage job applications.</p>
            </div>
        </div>
    </x-slot>

    <div class="bg-white border-t-4 border-brand-500 border-b border-x border-gray-200 mt-8">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-8 py-5 text-left text-xs font-black text-richblack-900 uppercase tracking-widest border-b border-gray-200">Applicant Info</th>
                        <th scope="col" class="px-8 py-5 text-left text-xs font-black text-richblack-900 uppercase tracking-widest border-b border-gray-200">Position Applied</th>
                        <th scope="col" class="px-8 py-5 text-left text-xs font-black text-richblack-900 uppercase tracking-widest border-b border-gray-200">Status</th>
                        <th scope="col" class="px-8 py-5 text-left text-xs font-black text-richblack-900 uppercase tracking-widest border-b border-gray-200">Applied Date</th>
                        <th scope="col" class="px-8 py-5 text-right text-xs font-black text-richblack-900 uppercase tracking-widest border-b border-gray-200">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-50">
                    @forelse($applications as $app)
                        <tr class="hover:bg-gray-50 transition-colors duration-150 group {{ $app->status === 'Received' ? 'bg-brand-50/30' : '' }}">
                            <td class="px-8 py-6 whitespace-nowrap">
                                <div class="text-base font-black text-richblack-900 uppercase tracking-widest">{{ $app->name }}</div>
                                <div class="text-xs text-gray-500">{{ $app->email }}</div>
                            </td>
                            <td class="px-8 py-6 whitespace-nowrap">
                                @if($app->job)
                                    <div class="text-sm text-gray-900 font-medium">{{ $app->job->title }}</div>
                                    <div class="text-xs text-gray-500">{{ $app->job->location }}</div>
                                @else
                                    <div class="text-sm text-red-500 italic">Job Removed</div>
                                @endif
                            </td>
                            <td class="px-8 py-6 whitespace-nowrap">
                                @php
                                    $colors = [
                                        'Received' => 'bg-orange-100 text-orange-800 border-orange-200',
                                        'Under Review' => 'bg-blue-50 text-blue-700 border-blue-200',
                                        'Interview Scheduled' => 'bg-purple-50 text-purple-700 border-purple-200',
                                        'Accepted' => 'bg-green-50 text-green-700 border-green-200',
                                        'Rejected' => 'bg-gray-100 text-gray-700 border-gray-200',
                                    ];
                                    $color = $colors[$app->status] ?? 'bg-gray-50 text-gray-600';
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-1  text-xs font-medium border {{ $color }}">
                                    {{ $app->status }}
                                </span>
                            </td>
                            <td class="px-8 py-6 whitespace-nowrap text-sm text-gray-500">
                                {{ $app->created_at->format('M j, Y') }}
                            </td>
                            <td class="px-8 py-6 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('admin.applications.show', $app) }}" class="inline-flex items-center text-brand-500 hover:text-orange-700">
                                    Review Application <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                No job applications found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($applications->hasPages())
            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50">
                {{ $applications->links() }}
            </div>
        @endif
    </div>
</x-app-layout>

