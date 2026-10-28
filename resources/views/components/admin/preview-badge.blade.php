@props(['type', 'item'])

@if($item->is_preview)
    <span class="ml-2 inline-flex items-center gap-1 align-middle">
        <span class="inline-flex items-center px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider bg-amber-50 text-amber-700 border border-amber-200" title="Only visible to signed-in admins">Preview</span>
        <form action="{{ route('admin.preview.publish', [$type, $item->getKey()]) }}" method="POST" class="inline" data-confirm="Show this to the public?">
            @csrf
            @method('PATCH')
            <button type="submit" class="px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider bg-richblack-900 text-white hover:bg-brand-600">Make public</button>
        </form>
    </span>
@endif
