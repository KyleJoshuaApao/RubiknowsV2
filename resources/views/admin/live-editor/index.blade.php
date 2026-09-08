<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Live CMS Editor') }}
            </h2>
            <div class="text-sm text-gray-500">
                Changes typed below will preview instantly. Click "Save Layout" to publish.
            </div>
        </div>
    </x-slot>

    <!-- Alpine JS Component -->
    <div x-data="liveEditor()" class="flex h-[80vh] border-t border-gray-200" x-init="initEditor">
        <!-- Sidebar: Configuration Panel -->
        <div class="w-1/4 h-full bg-white border-r border-gray-200 overflow-y-auto p-6 shadow-sm">
            <form method="POST" action="{{ route('admin.live-editor.store') }}">
                @csrf
                <div class="mb-6 pb-6 border-b border-gray-200 flex justify-between items-center sticky top-0 bg-white z-10 pt-2">
                    <h3 class="font-bold text-gray-800 text-lg">Layout Elements</h3>
                    <button type="submit" class="px-4 py-2 bg-brand-500 text-white font-bold rounded hover:bg-brand-600 transition text-sm">
                        Save Layout
                    </button>
                </div>

                <!-- Stats Bar Section -->
                <div class="mb-8">
                    <h4 class="font-bold text-gray-700 uppercase tracking-widest text-xs mb-4">By The Numbers (Stats Bar)</h4>
                    <template x-for="(stat, index) in settings.stats" :key="index">
                        <div class="mb-4 p-4 bg-gray-50 border border-gray-200 rounded">
                            <div class="mb-2">
                                <label class="block text-xs font-bold text-gray-600 mb-1">Value (e.g. 250+)</label>
                                <input type="text" x-model="stat.value" :name="`home_stats_bar[${index}][value]`" class="w-full text-sm border-gray-300 rounded shadow-sm" @input="updatePreview">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-600 mb-1">Label (e.g. Projects)</label>
                                <input type="text" x-model="stat.label" :name="`home_stats_bar[${index}][label]`" class="w-full text-sm border-gray-300 rounded shadow-sm" @input="updatePreview">
                            </div>
                        </div>
                    </template>
                </div>

                <!-- Markets Section -->
                <div class="mb-8">
                    <h4 class="font-bold text-gray-700 uppercase tracking-widest text-xs mb-4">Markets Grid</h4>
                    <label class="block text-xs font-medium text-gray-500 mb-2">Comma separated list of markets</label>
                    <textarea name="home_markets" x-model="settings.markets_string" rows="4" class="w-full text-sm border-gray-300 rounded shadow-sm" @input="updatePreview"></textarea>
                </div>

                <!-- Trust Marquee Section -->
                <div class="mb-8">
                    <h4 class="font-bold text-gray-700 uppercase tracking-widest text-xs mb-4">Trust Marquee</h4>
                    <label class="block text-xs font-medium text-gray-500 mb-2">Comma separated client names</label>
                    <textarea name="home_marquee" x-model="settings.marquee_string" rows="4" class="w-full text-sm border-gray-300 rounded shadow-sm" @input="updatePreview"></textarea>
                </div>

                <!-- Careers Section -->
                <div class="mb-8">
                    <h4 class="font-bold text-gray-700 uppercase tracking-widest text-xs mb-4">Careers Block</h4>
                    <div class="mb-4">
                        <label class="block text-xs font-bold text-gray-600 mb-1">Title</label>
                        <input type="text" x-model="settings.careers.title" name="home_careers[title]" class="w-full text-sm border-gray-300 rounded shadow-sm" @input="updatePreview">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-1">Description</label>
                        <textarea x-model="settings.careers.description" name="home_careers[description]" rows="5" class="w-full text-sm border-gray-300 rounded shadow-sm" @input="updatePreview"></textarea>
                    </div>
                </div>
            </form>
        </div>

        <!-- Main Panel: Live Iframe Preview -->
        <div class="w-3/4 h-full bg-gray-100 flex items-center justify-center relative">
            <div class="absolute inset-0 m-4 shadow-2xl rounded overflow-hidden border-4 border-gray-300 bg-white">
                <iframe id="preview-iframe" src="{{ route('public.home', ['preview' => 'true'], false) }}" class="w-full h-full border-0"></iframe>
            </div>
            
            <!-- Mobile/Desktop Toggles (Optional UI) -->
            <div class="absolute top-6 right-8 flex gap-2 z-10 bg-white p-1 rounded shadow">
                <button class="p-2 text-gray-500 hover:text-brand-500"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg></button>
                <button class="p-2 text-gray-500 hover:text-brand-500"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg></button>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('liveEditor', () => ({
                settings: {
                    stats: @json($settings['home_stats_bar'] ?? []),
                    markets_string: @json(implode(', ', $settings['home_markets'] ?? [])),
                    marquee_string: @json(implode(', ', $settings['home_marquee'] ?? [])),
                    careers: @json($settings['home_careers'] ?? ['title' => '', 'description' => ''])
                },
                iframeReady: false,

                initEditor() {
                    const iframe = document.getElementById('preview-iframe');
                    iframe.onload = () => {
                        this.iframeReady = true;
                        // Give a small delay to ensure alpine loaded in iframe
                        setTimeout(() => this.updatePreview(), 500);
                    };
                },

                updatePreview() {
                    if(!this.iframeReady) return;
                    
                    const iframe = document.getElementById('preview-iframe');
                    
                    // Parse strings back to arrays for preview
                    const payload = {
                        type: 'live-editor-update',
                        data: {
                            stats: this.settings.stats,
                            markets: this.settings.markets_string.split(',').map(s => s.trim()).filter(s => s),
                            marquee: this.settings.marquee_string.split(',').map(s => s.trim()).filter(s => s),
                            careers: this.settings.careers
                        }
                    };
                    
                    iframe.contentWindow.postMessage(payload, '*');
                }
            }))
        })
    </script>
    @endpush
</x-app-layout>
