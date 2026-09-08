<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-black text-3xl uppercase tracking-tighter text-richblack-900 leading-tight">
                    {{ __('Quotation Requests') }}
                </h2>
                <p class="text-sm font-bold uppercase tracking-widest text-gray-500 mt-2">Manage and assign project estimation requests.</p>
            </div>
            <div>
                <button type="submit" form="bulk-delete-form" id="bulk-delete-btn" disabled
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-semibold  shadow-sm text-white bg-red-600 hover:bg-red-700 disabled:opacity-50 disabled:cursor-not-allowed transition-all duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    Delete Selected (<span id="selected-count">0</span>)
                </button>
            </div>
        </div>
    </x-slot>

    <div class="bg-white border-t-4 border-brand-500 border-b border-x border-gray-200 mt-8">
        <form id="bulk-delete-form" action="{{ route('admin.quotations.bulk-delete') }}" method="POST">
            @csrf
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-100">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-left w-10">
                                <input type="checkbox" id="select-all" class="rounded border-gray-300 text-brand-500 focus:ring-[#E07B2A]">
                            </th>
                            <th scope="col" class="px-8 py-5 text-left text-xs font-black text-richblack-900 uppercase tracking-widest border-b border-gray-200">Client Details</th>
                            <th scope="col" class="px-8 py-5 text-left text-xs font-black text-richblack-900 uppercase tracking-widest border-b border-gray-200">Project Needs</th>
                            <th scope="col" class="px-8 py-5 text-left text-xs font-black text-richblack-900 uppercase tracking-widest border-b border-gray-200">Assignment</th>
                            <th scope="col" class="px-8 py-5 text-left text-xs font-black text-richblack-900 uppercase tracking-widest border-b border-gray-200">Status</th>
                            <th scope="col" class="px-8 py-5 text-right text-xs font-black text-richblack-900 uppercase tracking-widest border-b border-gray-200">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-50">
                        @forelse($quotations as $quote)
                            <tr class="hover:bg-gray-50 transition-colors duration-150 group {{ $quote->status === 'Pending' ? 'bg-brand-50/30' : '' }}">
                                <td class="px-8 py-6 whitespace-nowrap w-10">
                                    <input type="checkbox" name="ids[]" value="{{ $quote->id }}" class="select-item rounded border-gray-300 text-brand-500 focus:ring-[#E07B2A]">
                                </td>
                                <td class="px-8 py-6 whitespace-nowrap">
                                    <div class="text-base font-black text-richblack-900 uppercase tracking-widest">{{ $quote->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $quote->company ?? 'Individual' }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900 font-medium">{{ $quote->service_needed }}</div>
                                    <div class="text-xs text-gray-500 truncate max-w-xs">Loc: {{ $quote->project_location }} | Budget: {{ $quote->budget }}</div>
                                </td>
                                <td class="px-8 py-6 whitespace-nowrap">
                                    @if($quote->assignedEngineer)
                                        <div class="flex items-center">
                                            <div class="h-6 w-6  bg-gray-200 flex items-center justify-center text-xs font-bold text-gray-600 mr-2">
                                                {{ substr($quote->assignedEngineer->name, 0, 1) }}
                                            </div>
                                            <span class="text-sm text-gray-700">{{ $quote->assignedEngineer->name }}</span>
                                        </div>
                                    @else
                                        <span class="text-sm text-gray-400 italic">Unassigned</span>
                                    @endif
                                </td>
                                <td class="px-8 py-6 whitespace-nowrap">
                                    @php
                                        $colors = [
                                            'Pending' => 'bg-orange-100 text-orange-800 border-orange-200',
                                            'Under Review' => 'bg-blue-50 text-blue-700 border-blue-200',
                                            'Estimated' => 'bg-purple-50 text-purple-700 border-purple-200',
                                            'Sent' => 'bg-green-50 text-green-700 border-green-200',
                                            'Closed' => 'bg-gray-100 text-gray-700 border-gray-200',
                                        ];
                                        $color = $colors[$quote->status] ?? 'bg-gray-50 text-gray-600';
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-1  text-xs font-medium border {{ $color }}">
                                        {{ $quote->status }}
                                    </span>
                                </td>
                                <td class="px-8 py-6 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end space-x-4">
                                        <a href="{{ route('admin.quotations.show', $quote) }}" class="inline-flex items-center text-brand-500 hover:text-orange-700">
                                            Review <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                        </a>
                                        <button type="submit" form="delete-form-{{ $quote->id }}" class="text-red-500 hover:text-red-700 transition-colors focus:outline-none">
                                            Delete
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                    No quotation requests found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </form>
        @if($quotations->hasPages())
            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50">
                {{ $quotations->links() }}
            </div>
        @endif
    </div>

    <!-- Single Delete Forms (Defined outside to prevent HTML nesting) -->
    @foreach($quotations as $quote)
        <form id="delete-form-{{ $quote->id }}" action="{{ route('admin.quotations.destroy', $quote) }}" method="POST" class="hidden">
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

