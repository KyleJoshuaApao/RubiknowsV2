<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center">
            <div>
                <h2 class="font-black text-3xl uppercase tracking-tighter text-richblack-900 leading-tight">News</h2>
                <p class="text-sm font-bold uppercase tracking-widest text-gray-500 mt-2">Updates shown on the home page, linked to your Facebook posts.</p>
            </div>
            <div class="mt-4 sm:mt-0">
                <a href="{{ route('admin.news.create') }}" class="inline-flex items-center bg-brand-500 text-white px-4 py-2 shadow-sm hover:bg-brand-600 transition-all duration-200 font-medium text-sm">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Add News Post
                </a>
            </div>
        </div>
    </x-slot>

    <div class="bg-white border-t-4 border-brand-500 border-b border-x border-gray-200 mt-8">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-8 py-5 text-left text-xs font-black text-richblack-900 uppercase tracking-widest border-b border-gray-200">Post</th>
                        <th scope="col" class="px-8 py-5 text-left text-xs font-black text-richblack-900 uppercase tracking-widest border-b border-gray-200">Date</th>
                        <th scope="col" class="px-8 py-5 text-left text-xs font-black text-richblack-900 uppercase tracking-widest border-b border-gray-200">Status</th>
                        <th scope="col" class="px-8 py-5 text-right text-xs font-black text-richblack-900 uppercase tracking-widest border-b border-gray-200">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-50">
                    @forelse($posts as $post)
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            <td class="px-8 py-5">
                                <div class="flex items-center gap-4">
                                    @if($post->image_path)
                                        <img src="{{ \App\Support\MediaUrl::for($post->image_path) }}" alt="" class="h-14 w-20 object-cover border border-gray-200">
                                    @endif
                                    <div class="min-w-0">
                                        <div class="text-sm font-black text-richblack-900">{{ $post->title ?: Str::limit($post->body, 60) }} @if($post->is_preview)<span class="ml-2 inline-flex items-center px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider bg-amber-50 text-amber-700 border border-amber-200" title="Only visible to signed-in admins">Preview</span>@endif</div>
                                        <a href="{{ $post->facebook_url }}" target="_blank" rel="noopener" class="text-xs text-blue-600 hover:underline">View on Facebook</a>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-5 whitespace-nowrap text-sm text-gray-600">{{ $post->posted_at->format('M j, Y g:i A') }}</td>
                            <td class="px-8 py-5 whitespace-nowrap">
                                @if(! $post->is_published)
                                    <span class="inline-flex items-center px-2.5 py-1 text-xs font-medium bg-gray-50 text-gray-600 border border-gray-200">Hidden</span>
                                @elseif($post->posted_at->isFuture())
                                    <span class="inline-flex items-center px-2.5 py-1 text-xs font-medium bg-amber-50 text-amber-700 border border-amber-200">Scheduled</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 text-xs font-medium bg-green-50 text-green-700 border border-green-200">Published</span>
                                @endif
                            </td>
                            <td class="px-8 py-5 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end space-x-2">
                                    <a href="{{ route('admin.news.edit', $post) }}" class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 transition-colors" title="Edit">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </a>
                                    <form action="{{ route('admin.news.destroy', $post) }}" method="POST" class="inline-block" data-confirm="Delete this news post? This cannot be undone.">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 transition-colors" title="Delete">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center">
                                <h3 class="text-lg font-medium text-gray-900">No news yet</h3>
                                <p class="mt-1 text-sm text-gray-500">Add a post to show company updates on the home page.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($posts->hasPages())
            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50">{{ $posts->links() }}</div>
        @endif
    </div>
</x-app-layout>
