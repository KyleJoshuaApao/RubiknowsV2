<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-2xl text-gray-800 leading-tight tracking-tight">
                    {{ __('Contact Messages') }}
                </h2>
                <p class="text-sm text-gray-500 mt-1">Manage inquiries submitted from the contact form.</p>
            </div>
            <div>
                <button type="submit" form="bulk-delete-form" id="bulk-delete-btn" disabled
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-semibold rounded-lg shadow-sm text-white bg-red-600 hover:bg-red-700 disabled:opacity-50 disabled:cursor-not-allowed transition-all duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    Delete Selected (<span id="selected-count">0</span>)
                </button>
            </div>
        </div>
    </x-slot>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mt-6">
        <form id="bulk-delete-form" action="{{ route('admin.messages.bulk-delete') }}" method="POST">
            @csrf
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-100">
                    <thead class="bg-gray-50/80">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-left w-10">
                                <input type="checkbox" id="select-all" class="rounded border-gray-300 text-[#E07B2A] focus:ring-[#E07B2A]">
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Sender</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Subject</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Date</th>
                            <th scope="col" class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-50">
                        @forelse($messages as $msg)
                            <tr class="hover:bg-gray-50/50 transition-colors duration-150 group {{ $msg->status === 'New' ? 'bg-orange-50/30' : '' }}">
                                <td class="px-6 py-4 whitespace-nowrap w-10">
                                    <input type="checkbox" name="ids[]" value="{{ $msg->id }}" class="select-item rounded border-gray-300 text-[#E07B2A] focus:ring-[#E07B2A]">
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $msg->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $msg->email }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900 font-medium truncate max-w-xs">{{ $msg->subject }}</div>
                                    <div class="text-xs text-gray-500 truncate max-w-xs">{{ Str::limit($msg->message, 50) }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $colors = [
                                            'New' => 'bg-orange-100 text-orange-800 border-orange-200',
                                            'Read' => 'bg-blue-50 text-blue-700 border-blue-200',
                                            'Replied' => 'bg-green-50 text-green-700 border-green-200',
                                            'Archived' => 'bg-gray-100 text-gray-700 border-gray-200',
                                            'Spam' => 'bg-red-50 text-red-700 border-red-200',
                                        ];
                                        $color = $colors[$msg->status] ?? 'bg-gray-50 text-gray-600';
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium border {{ $color }}">
                                        {{ $msg->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $msg->created_at->diffForHumans() }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end space-x-4">
                                        <a href="{{ route('admin.messages.show', $msg) }}" class="inline-flex items-center text-[#E07B2A] hover:text-orange-700">
                                            View Message <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                        </a>
                                        <button type="submit" form="delete-form-{{ $msg->id }}" class="text-red-500 hover:text-red-700 transition-colors focus:outline-none">
                                            Delete
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                    No contact messages found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </form>
        @if($messages->hasPages())
            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50">
                {{ $messages->links() }}
            </div>
        @endif
    </div>

    <!-- Single Delete Forms (Defined outside to prevent HTML nesting) -->
    @foreach($messages as $msg)
        <form id="delete-form-{{ $msg->id }}" action="{{ route('admin.messages.destroy', $msg) }}" method="POST" class="hidden">
            @csrf
            @method('DELETE')
        </form>
    @endforeach

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const selectAllCheckbox = document.getElementById('select-all');
            const itemCheckboxes = document.querySelectorAll('.select-item');
            const bulkDeleteBtn = document.getElementById('bulk-delete-btn');
            const selectedCountSpan = document.getElementById('selected-count');

            function updateBulkButtonState() {
                const checkedCount = document.querySelectorAll('.select-item:checked').length;
                selectedCountSpan.textContent = checkedCount;
                
                if (checkedCount > 0) {
                    bulkDeleteBtn.removeAttribute('disabled');
                } else {
                    bulkDeleteBtn.setAttribute('disabled', 'disabled');
                }
            }

            if (selectAllCheckbox) {
                selectAllCheckbox.addEventListener('change', function () {
                    itemCheckboxes.forEach(cb => {
                        cb.checked = selectAllCheckbox.checked;
                    });
                    updateBulkButtonState();
                });
            }

            itemCheckboxes.forEach(cb => {
                cb.addEventListener('change', function () {
                    const allChecked = document.querySelectorAll('.select-item:checked').length === itemCheckboxes.length;
                    if (selectAllCheckbox) {
                        selectAllCheckbox.checked = allChecked;
                    }
                    updateBulkButtonState();
                });
            });
        });
    </script>
</x-app-layout>
