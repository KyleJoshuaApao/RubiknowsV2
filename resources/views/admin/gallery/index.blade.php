<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center">
            <div>
                <h2 class="font-semibold text-2xl text-gray-800 leading-tight tracking-tight">
                    {{ __('Media Gallery') }}
                </h2>
                <p class="text-sm text-gray-500 mt-1">Manage project photos, videos, and construction progress media.</p>
            </div>
            <div class="mt-4 sm:mt-0">
                <a href="{{ route('admin.gallery.create') }}" class="inline-flex items-center bg-[#E07B2A] text-white px-4 py-2 rounded-lg shadow-sm hover:bg-orange-600 hover:shadow transition-all duration-200 font-medium text-sm">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Upload Media
                </a>
            </div>
        </div>
    </x-slot>

    <div class="mt-6">
        @if($media->isEmpty())
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-12 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <h3 class="text-lg font-medium text-gray-900">No media found</h3>
                <p class="mt-1 text-sm text-gray-500">Get started by uploading your first photo or video.</p>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($media as $item)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden group">
                        <div class="aspect-w-16 aspect-h-10 bg-gray-100 relative">
                            @if($item->type === 'Photo')
                                <img src="{{ Storage::url($item->url) }}" alt="{{ $item->title }}" class="object-cover w-full h-48">
                            @else
                                <div class="w-full h-48 flex items-center justify-center bg-gray-800 text-white">
                                    <svg class="w-12 h-12 opacity-50" fill="currentColor" viewBox="0 0 20 20"><path d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z"></path></svg>
                                </div>
                            @endif
                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-40 transition-all duration-200 flex items-center justify-center opacity-0 group-hover:opacity-100 space-x-3">
                                <a href="{{ route('admin.gallery.edit', $item) }}" class="p-2 bg-white text-gray-900 rounded-full hover:bg-[#E07B2A] hover:text-white shadow-lg transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                </a>
                                <form action="{{ route('admin.gallery.destroy', $item) }}" method="POST" class="inline-block" onsubmit="return confirm('Delete this media?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1.5 bg-white text-red-600 rounded-full hover:bg-red-600 hover:text-white shadow-lg transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                        <div class="p-4 border-t border-gray-100">
                            <h3 class="text-sm font-semibold text-gray-900 truncate" title="{{ $item->title }}">{{ $item->title }}</h3>
                            <div class="flex items-center justify-between mt-2">
                                <span class="text-xs text-gray-500">{{ $item->category }}</span>
                                <span class="px-2 py-0.5 rounded text-[10px] font-medium {{ $item->type === 'Photo' ? 'bg-blue-50 text-blue-600' : 'bg-purple-50 text-purple-600' }}">{{ $item->type }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            @if($media->hasPages())
                <div class="mt-6">
                    {{ $media->links() }}
                </div>
            @endif
        @endif
    </div>
</x-app-layout>
