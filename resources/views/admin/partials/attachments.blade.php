{{-- Files sent with a message or quotation request. Expects $files and $route (route name taking the record and an index). --}}
@if($files)
    <ul class="space-y-2">
        @foreach($files as $index => $file)
            <li class="flex items-center justify-between gap-4 px-4 py-2 bg-gray-50 border border-gray-200 text-sm">
                <span class="flex items-center gap-2 min-w-0 text-gray-800">
                    <svg class="w-4 h-4 flex-none text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                    <span class="truncate">{{ $file['name'] }}</span>
                    @if($file['size'])<span class="flex-none text-gray-400">{{ \Illuminate\Support\Number::fileSize($file['size'], precision: 1) }}</span>@endif
                </span>
                @if($file['disk'])
                    <a href="{{ route($route, [$record, $index]) }}" class="flex-none font-bold text-brand-600 hover:text-brand-700">Download</a>
                @else
                    <span class="flex-none text-gray-400" title="The file is no longer in storage">Unavailable</span>
                @endif
            </li>
        @endforeach
    </ul>
@endif
