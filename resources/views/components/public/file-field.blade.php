@props(['id', 'label' => 'Attach files', 'showErrors' => true])

@php($error = $showErrors ? ($errors->first('attachments') ?: $errors->first('attachments.*')) : null)

<div class="rk-field" x-data="{ names: [] }">
    <label for="{{ $id }}">{{ $label }} <span class="rk-optional">(optional)</span></label>
    <input class="rk-input" id="{{ $id }}" name="attachments[]" type="file" multiple accept="{{ \App\Support\SubmissionFiles::accept() }}" aria-describedby="{{ $id }}-hint" @change="names = Array.from($event.target.files).map(file => file.name)" @if($error) aria-invalid="true" @endif>
    <p class="rk-field__hint" id="{{ $id }}-hint">Up to {{ \App\Support\SubmissionFiles::MAX_FILES }} files, 15 MB each: photos (JPG, PNG, HEIC), PDF, Word, Excel, CAD drawings (DWG, DXF) or ZIP.</p>
    <ul class="rk-file-list" x-show="names.length" x-cloak>
        <template x-for="name in names" :key="name"><li x-text="name"></li></template>
    </ul>
    @if($error)<p class="rk-field__error">{{ $error }}</p>@endif
</div>
