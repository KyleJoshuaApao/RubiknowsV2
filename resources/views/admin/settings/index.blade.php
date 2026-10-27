<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center">
            <div>
                <h2 class="font-black text-3xl uppercase tracking-tighter text-richblack-900 leading-tight">
                    {{ __('System Settings') }}
                </h2>
                <p class="text-sm font-bold uppercase tracking-widest text-gray-500 mt-2">Manage global website configurations and metadata.</p>
            </div>
        </div>
    </x-slot>

    <div class="mt-6 bg-white  shadow-sm border border-gray-100 overflow-hidden max-w-4xl">
        <form action="{{ route('admin.settings.store') }}" method="POST">
            @csrf
            
            <div class="p-6 sm:p-8 space-y-8">
                <!-- Branding Section -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 border-b pb-2 mb-4">Branding & Contact</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="company_name" value="Company Name" />
                            <x-text-input id="company_name" name="company_name" type="text" class="mt-1 block w-full" value="{{ $settings['company_name'] ?? 'RubiKnows' }}" />
                        </div>
                        <div>
                            <x-input-label for="contact_email" value="Contact Email" />
                            <x-text-input id="contact_email" name="contact_email" type="email" class="mt-1 block w-full" value="{{ $settings['contact_email'] ?? '' }}" placeholder="Where website notifications are sent" />
                        </div>
                        <div>
                            <x-input-label for="contact_phone" value="Contact Phone" />
                            <x-text-input id="contact_phone" name="contact_phone" type="text" class="mt-1 block w-full" value="{{ $settings['contact_phone'] ?? '' }}" />
                        </div>
                        <div>
                            <x-input-label for="office_address" value="Office Address" />
                            <x-text-input id="office_address" name="office_address" type="text" class="mt-1 block w-full" value="{{ $settings['office_address'] ?? '' }}" />
                        </div>
                    </div>
                </div>

                <!-- About Page Details Section -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 border-b pb-2 mb-4">About Page Content</h3>
                    
                    <!-- Include Quill CDN Assets directly -->
                    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet" integrity="sha384-VvSC4PGxeMkOaAmyuDGZECjY2dkqdO/IdBYBUK+BCYNc3WIvRxHLUzQ5OSgUaMA7" crossorigin="anonymous">
                    <style>
                        /* Set a clean, professional theme border & heights for editor */
                        .ql-toolbar.ql-snow {
                            border-color: #e5e7eb !important;
                            border-width: 1px !important;
                            border-style: solid !important;
                            border-top-left-radius: 0.375rem;
                            border-top-right-radius: 0.375rem;
                            background-color: #f9fafb;
                            padding: 10px !important;
                        }
                        .ql-container.ql-snow {
                            border-color: #e5e7eb !important;
                            border-width: 1px !important;
                            border-style: solid !important;
                            border-top: none !important;
                            border-bottom-left-radius: 0.375rem;
                            border-bottom-right-radius: 0.375rem;
                            font-family: 'Inter', sans-serif;
                            font-size: 0.875rem;
                        }
                        .ql-editor {
                            min-height: 200px;
                            padding: 16px !important;
                        }
                        /* Fix Tailwind Preflight resetting Quill SVG icons */
                        .ql-toolbar svg {
                            height: 18px !important;
                            width: 18px !important;
                            display: inline-block !important;
                            vertical-align: middle !important;
                        }
                        /* Restore Quill's specific SVG stroke and fill rules */
                        .ql-toolbar .ql-stroke {
                            fill: none !important;
                            stroke: #444 !important;
                            stroke-linecap: round;
                            stroke-linejoin: round;
                            stroke-width: 2;
                        }
                        .ql-toolbar .ql-fill {
                            fill: #444 !important;
                            stroke: none !important;
                        }
                        .ql-toolbar .ql-even {
                            fill-rule: evenodd;
                        }
                    </style>

                    <div class="space-y-6">
                        <!-- Story Title -->
                        <div>
                            <x-input-label for="about_story_title" value="Our Story Title" />
                            <x-text-input id="about_story_title" name="about_story_title" type="text" class="mt-1 block w-full" value="{{ $settings['about_story_title'] ?? '' }}" placeholder="Who we are" />
                        </div>
                        
                        <!-- Story Content (Rich Editor) -->
                        <div>
                            <x-input-label value="Our Story Body" />
                            <input type="hidden" name="about_story_content" id="about_story_content" value="{{ $settings['about_story_content'] ?? '' }}">
                            <div class="mt-1">
                                <div id="about_story_editor">
                                    {!! \App\Support\SafeHtml::clean($settings['about_story_content'] ?? null) !!}
                                </div>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">Leave empty to show the standard company introduction on the About page.</p>
                        </div>

                        <!-- Story Stats -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <x-input-label for="about_projects_count" value="Projects Completed Count" />
                                <x-text-input id="about_projects_count" name="about_projects_count" type="number" class="mt-1 block w-full" value="{{ $settings['about_projects_count'] ?? '' }}" placeholder="e.g. 100" />
                            </div>
                            <div>
                                <x-input-label for="about_experience_years" value="Years Experience" />
                                <x-text-input id="about_experience_years" name="about_experience_years" type="number" class="mt-1 block w-full" value="{{ $settings['about_experience_years'] ?? '' }}" placeholder="e.g. 5" />
                            </div>
                            <div>
                                <x-input-label for="about_est_year" value="Est. Year" />
                                <x-text-input id="about_est_year" name="about_est_year" type="text" class="mt-1 block w-full" value="{{ $settings['about_est_year'] ?? '' }}" placeholder="e.g. 2020" />
                            </div>
                        </div>
                    </div>
                </div>

                <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js" integrity="sha384-hcxmSutM10NL6iGBAA0LStIhy+kWJxfrhqWVMRuABZH5Vqztexq2nBz/Xnfllly9" crossorigin="anonymous"></script>
                <script nonce="{{ Vite::cspNonce() }}">
                    document.addEventListener('DOMContentLoaded', function () {
                        // Only formatting the public About page supports.
                        const toolbarOptions = [
                            ['bold', 'italic'],
                            ['link'],
                            ['clean']
                        ];

                        const quillStory = new Quill('#about_story_editor', {
                            theme: 'snow',
                            placeholder: 'Tell visitors how the company started, what you do and who you work with.',
                            modules: { toolbar: toolbarOptions }
                        });

                        // Sync content to hidden inputs on form submission
                        const form = document.querySelector('form');
                        if (form) {
                            form.addEventListener('submit', function () {
                                document.getElementById('about_story_content').value = quillStory.root.innerHTML;
                            });
                        }
                    });
                </script>
                </div>

                <!-- SEO Section -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 border-b pb-2 mb-4">SEO Defaults</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <x-input-label for="seo_description" value="Default Meta Description" />
                            <textarea id="seo_description" name="seo_description" rows="3" maxlength="300" class="block w-full bg-gray-50 border-0 border-b-4 border-gray-200 focus:border-brand-500 focus:ring-0 px-4 py-4 font-bold text-gray-900 transition-colors">{{ $settings['seo_description'] ?? '' }}</textarea>
                            <p class="text-xs text-gray-500 mt-1">Shown by Google and when links are shared. Aim for one or two sentences (up to about 155 characters) saying what you do and where.</p>
                        </div>
                    </div>
                </div>

                <!-- Social Links Section -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 border-b pb-2 mb-4">Social Media Links</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="social_facebook" value="Facebook URL" />
                            <x-text-input id="social_facebook" name="social_facebook" type="url" class="mt-1 block w-full" value="{{ $settings['social_facebook'] ?? '' }}" placeholder="https://facebook.com/..." />
                        </div>
                        <div>
                            <x-input-label for="social_linkedin" value="LinkedIn URL" />
                            <x-text-input id="social_linkedin" name="social_linkedin" type="url" class="mt-1 block w-full" value="{{ $settings['social_linkedin'] ?? '' }}" placeholder="https://linkedin.com/company/..." />
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 mt-2">Links appear in the website footer. Leave a field empty to hide it.</p>
                    <x-input-error class="mt-2" :messages="$errors->get('social_facebook')" />
                    <x-input-error class="mt-2" :messages="$errors->get('social_linkedin')" />
                </div>
            </div>

            <div class="px-8 py-5 bg-gray-50 border-t border-gray-200 flex justify-end">
                <button type="submit" class="inline-flex items-center bg-brand-500 text-white px-6 py-3 font-bold uppercase tracking-widest text-xs hover:bg-brand-600 transition-colors">
                    Save Settings
                </button>
            </div>
        </form>
    </div>
</x-app-layout>

