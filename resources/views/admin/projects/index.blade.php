<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center">
            <div>
                <h2 class="font-black text-3xl uppercase tracking-tighter text-richblack-900 leading-tight">
                    {{ __('Project Portfolio') }}
                </h2>
                <p class="text-sm font-bold uppercase tracking-widest text-gray-500 mt-2">Manage your past and ongoing projects.</p>
            </div>
            <div class="mt-4 sm:mt-0">
                <a href="{{ route('admin.projects.create') }}" class="inline-flex items-center bg-brand-500 text-white px-6 py-3 font-bold uppercase tracking-widest text-xs hover:bg-brand-600 transition-colors">
                    + Add Project
                </a>
            </div>
        </div>
    </x-slot>

    <div class="bg-white border-t-4 border-brand-500 border-b border-x border-gray-200 mt-8">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-8 py-5 text-left text-xs font-black text-richblack-900 uppercase tracking-widest border-b border-gray-200">Project Title</th>
                        <th scope="col" class="px-8 py-5 text-left text-xs font-black text-richblack-900 uppercase tracking-widest border-b border-gray-200">Client & Location</th>
                        <th scope="col" class="px-8 py-5 text-left text-xs font-black text-richblack-900 uppercase tracking-widest border-b border-gray-200">Status</th>
                        <th scope="col" class="px-8 py-5 text-right text-xs font-black text-richblack-900 uppercase tracking-widest border-b border-gray-200">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($projects as $project)
                        <tr class="hover:bg-gray-50 transition-colors duration-150 group">
                            <td class="px-8 py-6 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-12 w-12 bg-richblack-950 text-white flex items-center justify-center">
                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                    </div>
                                    <div class="ml-5">
                                        <div class="text-base font-black text-richblack-900">{{ $project->title }}</div>
                                        <div class="text-xs font-bold uppercase tracking-widest text-gray-400 mt-1 truncate max-w-xs">{{ Str::limit($project->description, 40) }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-6 whitespace-nowrap">
                                <div class="text-sm font-bold text-richblack-900 uppercase tracking-wider">{{ $project->client ?? 'Internal' }}</div>
                                <div class="text-xs font-bold text-gray-500 uppercase tracking-widest flex items-center mt-1">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    {{ $project->location ?? 'N/A' }}
                                </div>
                            </td>
                            <td class="px-8 py-6 whitespace-nowrap">
                                @if($project->status === 'Completed')
                                    <span class="inline-flex items-center px-3 py-1 text-[10px] font-black uppercase tracking-widest bg-green-50 text-green-700 border border-green-200">
                                        <span class="w-1.5 h-1.5 bg-green-500 mr-2"></span>
                                        Completed
                                    </span>
                                @elseif($project->status === 'Ongoing')
                                    <span class="inline-flex items-center px-3 py-1 text-[10px] font-black uppercase tracking-widest bg-brand-50 text-brand-700 border border-brand-200">
                                        <span class="w-1.5 h-1.5 bg-brand-500 mr-2 animate-pulse"></span>
                                        Ongoing
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 text-[10px] font-black uppercase tracking-widest bg-gray-50 text-gray-600 border border-gray-200">
                                        {{ $project->status ?? 'Draft' }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-8 py-6 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end space-x-3 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                    <a href="{{ route('admin.projects.edit', $project) }}" class="text-xs font-bold uppercase tracking-widest text-brand-500 hover:text-brand-700 transition-colors" title="Edit">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.projects.destroy', $project) }}" method="POST" class="inline-block" data-confirm="Are you sure you want to delete this project? This action cannot be undone.">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-xs font-bold uppercase tracking-widest text-red-500 hover:text-red-700 transition-colors" title="Delete">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-8 py-16 text-center border-t border-gray-100">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="h-12 w-12 text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                    </svg>
                                    <h3 class="text-lg font-black uppercase tracking-widest text-richblack-900">No projects yet</h3>
                                    <p class="mt-2 text-xs font-bold uppercase tracking-widest text-gray-500">Get started by creating a new project entry.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($projects->hasPages())
            <div class="px-8 py-5 border-t border-gray-200 bg-gray-50">
                {{ $projects->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
