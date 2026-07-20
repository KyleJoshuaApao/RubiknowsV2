<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <a href="{{ route('admin.messages.index') }}" class="mr-4 text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </a>
                <h2 class="font-semibold text-2xl text-gray-800 leading-tight tracking-tight">
                    {{ $message->subject }}
                </h2>
            </div>
            
            <form action="{{ route('admin.messages.update', $message) }}" method="POST" class="flex items-center space-x-2">
                @csrf
                @method('PUT')
                <select name="status" class="text-sm border-gray-300 rounded-lg shadow-sm focus:border-orange-500 focus:ring-orange-500" onchange="this.form.submit()">
                    <option value="New" {{ $message->status === 'New' ? 'selected' : '' }}>New</option>
                    <option value="Read" {{ $message->status === 'Read' ? 'selected' : '' }}>Read</option>
                    <option value="Replied" {{ $message->status === 'Replied' ? 'selected' : '' }}>Replied</option>
                    <option value="Archived" {{ $message->status === 'Archived' ? 'selected' : '' }}>Archived</option>
                    <option value="Spam" {{ $message->status === 'Spam' ? 'selected' : '' }}>Spam</option>
                </select>
            </form>
        </div>
    </x-slot>

    <div class="mt-6 bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden max-w-4xl">
        <div class="p-6 sm:p-8">
            <div class="flex items-start justify-between border-b pb-6 mb-6">
                <div>
                    <h3 class="text-lg font-medium text-gray-900">{{ $message->name }}</h3>
                    <div class="mt-1 flex flex-col space-y-1 text-sm text-gray-500">
                        <a href="mailto:{{ $message->email }}" class="text-[#E07B2A] hover:underline">{{ $message->email }}</a>
                        @if($message->phone)
                            <span>Phone: {{ $message->phone }}</span>
                        @endif
                        @if($message->company)
                            <span>Company: {{ $message->company }}</span>
                        @endif
                    </div>
                </div>
                <div class="text-sm text-gray-500">
                    {{ $message->created_at->format('M j, Y, g:i a') }}
                </div>
            </div>

            <div class="prose max-w-none text-gray-700 whitespace-pre-wrap">
                {{ $message->message }}
            </div>
            
            @if($message->attachment_path)
                <div class="mt-8 pt-6 border-t border-gray-100">
                    <h4 class="text-sm font-medium text-gray-900 mb-3">Attachments</h4>
                    <a href="{{ Storage::url($message->attachment_path) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-700 hover:bg-gray-100">
                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                        View Attachment
                    </a>
                </div>
            @endif
        </div>
        
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex justify-between">
            <form action="{{ route('admin.messages.destroy', $message) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this message?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium">Delete Message</button>
            </form>
            <a href="mailto:{{ $message->email }}?subject=Re: {{ urlencode($message->subject) }}" class="inline-flex items-center px-4 py-2 bg-[#E07B2A] border border-transparent rounded-lg font-medium text-sm text-white hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 shadow-sm">
                Reply via Email
            </a>
        </div>
    </div>
</x-app-layout>
