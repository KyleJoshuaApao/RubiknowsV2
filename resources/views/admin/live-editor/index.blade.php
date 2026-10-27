<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Homepage editor') }}
            </h2>
            <div class="text-sm text-gray-500">
                Changes preview on the right as you type. Click "Save" to publish them.
            </div>
        </div>
    </x-slot>

    <div x-data="liveEditor()" class="flex h-[80vh] border-t border-gray-200" x-init="initEditor">
        <div class="w-1/4 min-w-[18rem] h-full bg-white border-r border-gray-200 overflow-y-auto p-6 shadow-sm">
            <form method="POST" action="{{ route('admin.live-editor.store') }}">
                @csrf
                <div class="mb-6 pb-6 border-b border-gray-200 flex justify-between items-center sticky top-0 bg-white z-10 pt-2">
                    <h3 class="font-bold text-gray-800 text-lg">Homepage</h3>
                    <button type="submit" class="px-4 py-2 bg-brand-500 text-white font-bold rounded hover:bg-brand-600 transition text-sm">
                        Save
                    </button>
                </div>

                <div class="mb-8">
                    <h4 class="font-bold text-gray-700 uppercase tracking-widest text-xs mb-1">Key figures</h4>
                    <p class="text-xs text-gray-500 mb-4">Shown under the main heading. Leave empty to use the figures from Settings.</p>
                    <template x-for="(stat, index) in settings.stats" :key="index">
                        <div class="mb-4 p-4 bg-gray-50 border border-gray-200 rounded">
                            <div class="mb-2">
                                <label class="block text-xs font-bold text-gray-600 mb-1" :for="`stat-value-${index}`">Figure (e.g. 120+)</label>
                                <input type="text" :id="`stat-value-${index}`" x-model="stat.value" :name="`home_stats_bar[${index}][value]`" maxlength="20" class="w-full text-sm border-gray-300 rounded shadow-sm" @input="updatePreview">
                            </div>
                            <div class="mb-2">
                                <label class="block text-xs font-bold text-gray-600 mb-1" :for="`stat-label-${index}`">Label (e.g. Projects completed)</label>
                                <input type="text" :id="`stat-label-${index}`" x-model="stat.label" :name="`home_stats_bar[${index}][label]`" maxlength="60" class="w-full text-sm border-gray-300 rounded shadow-sm" @input="updatePreview">
                            </div>
                            <button type="button" class="text-xs font-bold text-red-600 hover:text-red-800" @click="settings.stats.splice(index, 1); updatePreview()">Remove</button>
                        </div>
                    </template>
                    <button type="button" x-show="settings.stats.length < 4" class="text-sm font-bold text-brand-600 hover:text-brand-700" @click="settings.stats.push({ value: '', label: '' })">+ Add a figure</button>
                </div>

                <div class="mb-8">
                    <h4 class="font-bold text-gray-700 uppercase tracking-widest text-xs mb-1">Careers block</h4>
                    <p class="text-xs text-gray-500 mb-4">Open positions are listed automatically from Jobs.</p>
                    <div class="mb-4">
                        <label class="block text-xs font-bold text-gray-600 mb-1" for="careers-title">Heading</label>
                        <input type="text" id="careers-title" x-model="settings.careers.title" name="home_careers[title]" maxlength="120" class="w-full text-sm border-gray-300 rounded shadow-sm" placeholder="Work with us" @input="updatePreview">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-1" for="careers-description">Text</label>
                        <textarea id="careers-description" x-model="settings.careers.description" name="home_careers[description]" rows="4" maxlength="400" class="w-full text-sm border-gray-300 rounded shadow-sm" @input="updatePreview"></textarea>
                    </div>
                </div>
            </form>
        </div>

        <div class="flex-1 h-full bg-gray-100 relative">
            <div class="absolute top-4 right-6 z-10 flex gap-1 bg-white p-1 rounded shadow" role="group" aria-label="Preview size">
                <button type="button" class="px-3 py-1.5 text-xs font-bold rounded" :class="device === 'desktop' ? 'bg-gray-900 text-white' : 'text-gray-600 hover:text-gray-900'" @click="device = 'desktop'">Desktop</button>
                <button type="button" class="px-3 py-1.5 text-xs font-bold rounded" :class="device === 'mobile' ? 'bg-gray-900 text-white' : 'text-gray-600 hover:text-gray-900'" @click="device = 'mobile'">Phone</button>
            </div>
            <div class="absolute inset-0 m-4 mt-16 flex justify-center">
                <div class="h-full shadow-2xl rounded overflow-hidden border-4 border-gray-300 bg-white transition-all" :style="device === 'mobile' ? 'width: 390px' : 'width: 100%'">
                    <iframe id="preview-iframe" title="Homepage preview" src="{{ route('public.home', ['preview' => 'true'], false) }}" class="w-full h-full border-0"></iframe>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script nonce="{{ Vite::cspNonce() }}">
        document.addEventListener('alpine:init', () => {
            Alpine.data('liveEditor', () => ({
                settings: {
                    stats: @json(array_values($settings['home_stats_bar'] ?? [])),
                    careers: Object.assign({ title: '', description: '' }, @json((object) ($settings['home_careers'] ?? []))),
                },
                device: 'desktop',
                iframeReady: false,

                initEditor() {
                    const iframe = document.getElementById('preview-iframe');
                    iframe.addEventListener('load', () => {
                        this.iframeReady = true;
                        this.updatePreview();
                    });
                },

                updatePreview() {
                    if (!this.iframeReady) return;

                    // Send plain copies: Alpine's reactive proxies cannot be cloned into the iframe.
                    const data = JSON.parse(JSON.stringify({ stats: this.settings.stats, careers: this.settings.careers }));

                    document.getElementById('preview-iframe').contentWindow.postMessage({ type: 'live-editor-update', data }, window.location.origin);
                },
            }));
        });
    </script>
    @endpush
</x-app-layout>
