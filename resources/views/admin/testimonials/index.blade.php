<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center">
            <div>
                <h2 class="font-black text-3xl uppercase tracking-tighter text-richblack-900 leading-tight">
                    {{ __('Testimonials') }}
                </h2>
                <p class="text-sm font-bold uppercase tracking-widest text-gray-500 mt-2">Manage client reviews and feedback.</p>
            </div>
            <div class="mt-4 sm:mt-0">
                <a href="{{ route('admin.testimonials.create') }}" class="inline-flex items-center bg-brand-500 text-white px-4 py-2  shadow-sm hover:bg-brand-600 hover:shadow transition-all duration-200 font-medium text-sm">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Add Testimonial
                </a>
            </div>
        </div>
    </x-slot>

    <div class="bg-white border-t-4 border-brand-500 border-b border-x border-gray-200 mt-8">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-8 py-5 text-left text-xs font-black text-richblack-900 uppercase tracking-widest border-b border-gray-200">Client & Role</th>
                        <th scope="col" class="px-8 py-5 text-left text-xs font-black text-richblack-900 uppercase tracking-widest border-b border-gray-200">Quote</th>
                        <th scope="col" class="px-8 py-5 text-left text-xs font-black text-richblack-900 uppercase tracking-widest border-b border-gray-200">Status</th>
                        <th scope="col" class="px-8 py-5 text-right text-xs font-black text-richblack-900 uppercase tracking-widest border-b border-gray-200">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-50">
                    @forelse($testimonials as $testimonial)
                        <tr class="hover:bg-gray-50 transition-colors duration-150 group">
                            <td class="px-8 py-6 whitespace-nowrap">
                                <div class="text-base font-black text-richblack-900 uppercase tracking-widest">{{ $testimonial->client_name }}</div>
                                <div class="text-xs text-gray-500 mt-0.5">
                                    {{ $testimonial->role ? $testimonial->role . ' at ' : '' }}
                                    {{ $testimonial->company ?? 'Independent Client' }}
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-600 italic max-w-md truncate">
                                    "{{ Str::limit($testimonial->quote, 60) }}"
                                </div>
                            </td>
                            <td class="px-8 py-6 whitespace-nowrap">
                                @if($testimonial->is_published)
                                    <span class="inline-flex items-center px-2.5 py-1  text-xs font-medium bg-green-50 text-green-700 border border-green-200">
                                        Published
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1  text-xs font-medium bg-gray-50 text-gray-600 border border-gray-200">
                                        Hidden
                                    </span>
                                @endif
                            </td>
                            <td class="px-8 py-6 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end space-x-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                    <a href="{{ route('admin.testimonials.edit', $testimonial) }}" class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50  transition-colors" title="Edit">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </a>
                                    <form action="{{ route('admin.testimonials.destroy', $testimonial) }}" method="POST" class="inline-block" data-confirm="Are you sure you want to delete this testimonial? This action cannot be undone.">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50  transition-colors" title="Delete">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="h-12 w-12 text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                    </svg>
                                    <h3 class="text-lg font-medium text-gray-900">No testimonials yet</h3>
                                    <p class="mt-1 text-sm text-gray-500">Get started by adding client feedback.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($testimonials->hasPages())
            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50">
                {{ $testimonials->links() }}
            </div>
        @endif
    </div>
</x-app-layout>

