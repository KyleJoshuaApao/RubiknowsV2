@props(['type', 'model'])

@php($previewCount = $model::query()->where('is_preview', true)->count())

@if($previewCount)
    <form action="{{ route('admin.preview.publish-all', $type) }}" method="POST" class="inline-block" data-confirm="Show all {{ $previewCount }} preview items to the public?">
        @csrf
        @method('PATCH')
        <button type="submit" class="inline-flex items-center border border-richblack-900 text-richblack-900 px-4 py-2 font-medium text-sm hover:bg-richblack-900 hover:text-white transition-colors">Make {{ $previewCount }} preview {{ Str::plural('item', $previewCount) }} public</button>
    </form>
@endif
