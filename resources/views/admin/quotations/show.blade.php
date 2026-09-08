<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <a href="{{ route('admin.quotations.index') }}" class="mr-4 text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </a>
                <h2 class="font-black text-3xl uppercase tracking-tighter text-richblack-900 leading-tight">
                    Quotation Request #{{ $quotation->id }}
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-6">
        <!-- Main Details -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white  shadow-sm border border-gray-100 p-6 sm:p-8">
                <h3 class="text-lg font-medium text-gray-900 border-b pb-4 mb-4">Project Requirements</h3>
                
                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-6">
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Service Needed</dt>
                        <dd class="mt-1 text-sm text-gray-900 font-semibold">{{ $quotation->service_needed }}</dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Project Location</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $quotation->project_location }}</dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Estimated Budget</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $quotation->budget }}</dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Timeline</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $quotation->timeline }}</dd>
                    </div>
                    
                    <div class="sm:col-span-2">
                        <dt class="text-sm font-medium text-gray-500">Project Description</dt>
                        <dd class="mt-2 text-sm text-gray-700 whitespace-pre-wrap bg-gray-50 p-4 ">{{ $quotation->description }}</dd>
                    </div>

                    @if($quotation->attachment_path)
                        <div class="sm:col-span-2">
                            <dt class="text-sm font-medium text-gray-500 mb-2">Attached Document</dt>
                            <dd>
                                <a href="{{ Storage::url($quotation->attachment_path) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300  text-sm text-gray-700 hover:bg-gray-50 shadow-sm">
                                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                                    Download Attachment
                                </a>
                            </dd>
                        </div>
                    @endif
                </dl>
            </div>
            
            <!-- Reply Section -->
            <div class="bg-white shadow-sm border border-gray-100 p-6 sm:p-8 mt-6">
                <h3 class="text-lg font-medium text-gray-900 border-b pb-4 mb-4">Direct Reply</h3>
                
                @if($quotation->replied_at)
                    <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-4">
                        <p class="text-sm text-green-700 font-medium">Replied on {{ \Carbon\Carbon::parse($quotation->replied_at)->format('M j, Y g:i A') }}</p>
                    </div>
                    <div class="prose max-w-none text-gray-700 whitespace-pre-wrap">{{ $quotation->reply_message }}</div>
                @else
                    <form action="{{ route('admin.quotations.reply', $quotation) }}" method="POST">
                        @csrf
                        <div>
                            <label for="sender_name" class="block text-sm font-medium text-gray-700">Reply As (Sender Name)</label>
                            <div class="mt-1">
                                <input type="text" id="sender_name" name="sender_name" value="{{ auth()->user()->name }}" class="shadow-sm border-gray-300 focus:border-brand-500 focus:ring-brand-500 block w-full sm:text-sm rounded-md">
                            </div>
                            <p class="mt-1 text-xs text-gray-500">This name will appear in the email signature. Default is your name.</p>
                        </div>
                        <div class="mt-4">
                            <label for="reply_message" class="block text-sm font-medium text-gray-700">Write your reply (will be emailed directly to client)</label>
                            <div class="mt-1">
                                <textarea id="reply_message" name="reply_message" rows="5" class="shadow-sm border-gray-300 focus:border-brand-500 focus:ring-brand-500 block w-full sm:text-sm rounded-md" placeholder="Type your reply here..." required></textarea>
                            </div>
                        </div>
                        <div class="mt-4 flex justify-end">
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded shadow-sm text-white bg-brand-500 hover:bg-brand-600 focus:outline-none">
                                Send Reply via Email
                            </button>
                        </div>
                    </form>
                @endif
            </div>
        </div>

        <!-- Sidebar / Actions -->
        <div class="space-y-6">
            <!-- Client Info -->
            <div class="bg-white  shadow-sm border border-gray-100 p-6">
                <h3 class="text-base font-medium text-gray-900 mb-4">Client Contact</h3>
                <div class="space-y-3">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-gray-400 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        <div>
                            <p class="text-base font-black text-richblack-900 uppercase tracking-widest">{{ $quotation->name }}</p>
                            @if($quotation->company)
                                <p class="text-xs text-gray-500">{{ $quotation->company }}</p>
                            @endif
                        </div>
                    </div>
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        <a href="mailto:{{ $quotation->email }}" class="text-sm text-brand-500 hover:underline">{{ $quotation->email }}</a>
                    </div>
                    @if($quotation->phone)
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            <span class="text-sm text-gray-700">{{ $quotation->phone }}</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Workflow Management -->
            <div class="bg-white  shadow-sm border border-gray-100 p-6">
                <h3 class="text-base font-medium text-gray-900 mb-4">Workflow Management</h3>
                <form action="{{ route('admin.quotations.update', $quotation) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')
                    
                    <div>
                        <x-input-label for="status" value="Quotation Status" />
                        <select id="status" name="status" class="mt-1 block w-full text-sm border-gray-300  shadow-sm focus:border-orange-500 focus:ring-orange-500">
                            <option value="Pending" {{ $quotation->status === 'Pending' ? 'selected' : '' }}>Pending</option>
                            <option value="Under Review" {{ $quotation->status === 'Under Review' ? 'selected' : '' }}>Under Review</option>
                            <option value="Estimated" {{ $quotation->status === 'Estimated' ? 'selected' : '' }}>Estimated</option>
                            <option value="Sent" {{ $quotation->status === 'Sent' ? 'selected' : '' }}>Sent to Client</option>
                            <option value="Closed" {{ $quotation->status === 'Closed' ? 'selected' : '' }}>Closed</option>
                        </select>
                    </div>

                    <div>
                        <x-input-label for="assigned_engineer_id" value="Assigned To" />
                        <select id="assigned_engineer_id" name="assigned_engineer_id" class="mt-1 block w-full text-sm border-gray-300  shadow-sm focus:border-orange-500 focus:ring-orange-500">
                            <option value="">-- Unassigned --</option>
                            @foreach($engineers as $engineer)
                                <option value="{{ $engineer->id }}" {{ $quotation->assigned_engineer_id == $engineer->id ? 'selected' : '' }}>
                                    {{ $engineer->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="w-full flex justify-center py-1.5 px-3 border border-transparent  shadow-sm text-sm font-medium text-white bg-brand-500 hover:bg-brand-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                        Update Workflow
                    </button>
                </form>
            </div>

            <!-- Delete -->
            <div class="mt-4 text-center">
                <form action="{{ route('admin.quotations.destroy', $quotation) }}" method="POST" data-confirm="Are you sure you want to delete this quotation request? This action cannot be undone.">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-sm text-red-600 hover:text-red-800 font-medium">Delete Request</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

