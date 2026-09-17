<x-public-layout>
    <x-slot name="title">Contact Us</x-slot>

    @php
        $settings = Cache::remember('site_settings', 3600, fn () => \App\Models\Setting::pluck('value', 'key')->toArray());
        $activeTab = old('_tab', request('tab', 'general'));
    @endphp

    <x-public.page-intro eyebrow="Contact" number="08" title="Start with the next right conversation." lede="Whether you are exploring an idea or ready to discuss a scope, our team is here to listen." />

    <section class="rk-section">
        <div class="rk-container rk-contact-layout" x-data="{ tab: @js($activeTab) }">
            <aside>
                <x-public.eyebrow>Contact details</x-public.eyebrow>
                <h2 class="rk-section__title mt-4">Find the right way to reach us.</h2>
                <dl class="rk-contact-list">
                    @if(!empty($settings['office_address']))
                        <div><dt>Head office</dt><dd>{{ $settings['office_address'] }}</dd></div>
                    @endif
                    @if(!empty($settings['contact_phone']))
                        <div><dt>Phone</dt><dd><a href="tel:{{ $settings['contact_phone'] }}">{{ $settings['contact_phone'] }}</a></dd></div>
                    @endif
                    @if(!empty($settings['contact_email']))
                        <div><dt>Email</dt><dd><a href="mailto:{{ $settings['contact_email'] }}">{{ $settings['contact_email'] }}</a></dd></div>
                    @endif
                </dl>
                @if(!empty($settings['office_address']))
                    <div class="rk-contact-note">
                        <strong class="block text-[#171613]">Visiting us?</strong>
                        Use the office address above to plan your visit or <a class="underline decoration-[#e0a92a] underline-offset-4" href="https://www.openstreetmap.org/?mlat=7.450816&mlon=125.816674#map=17/7.450816/125.816674" target="_blank" rel="noopener">open the location in OpenStreetMap</a>.
                    </div>
                @endif
            </aside>

            <div>
                <div class="rk-tabs" role="tablist" aria-label="Contact request type">
                    <button type="button" role="tab" @click="tab = 'general'" :class="{ 'is-active': tab === 'general' }" :aria-selected="(tab === 'general').toString()">General inquiry</button>
                    <button type="button" role="tab" @click="tab = 'quote'" :class="{ 'is-active': tab === 'quote' }" :aria-selected="(tab === 'quote').toString()">Request a quotation</button>
                </div>

                <div class="pt-8" x-show="tab === 'general'" x-transition.opacity role="tabpanel">
                    <x-public.eyebrow>General inquiry</x-public.eyebrow>
                    <h2 class="mt-4 text-3xl tracking-[-.05em] sm:text-4xl">Tell us what you need.</h2>
                    <form class="rk-form mt-8" action="{{ route('public.contact.submit') }}" method="POST">
                        @csrf
                        <input type="hidden" name="_tab" value="general">
                        <div class="rk-form__split">
                            <div><label for="contact_name">Name *</label><input id="contact_name" name="name" type="text" value="{{ old('name') }}" required autocomplete="name">@error('name')<p class="rk-field-error">{{ $message }}</p>@enderror</div>
                            <div><label for="contact_email">Email *</label><input id="contact_email" name="email" type="email" value="{{ old('email') }}" required autocomplete="email">@error('email')<p class="rk-field-error">{{ $message }}</p>@enderror</div>
                        </div>
                        <div class="rk-form__split">
                            <div><label for="contact_company">Company</label><input id="contact_company" name="company" type="text" value="{{ old('company') }}" autocomplete="organization">@error('company')<p class="rk-field-error">{{ $message }}</p>@enderror</div>
                            <div><label for="contact_phone">Phone</label><input id="contact_phone" name="phone" type="text" value="{{ old('phone') }}" autocomplete="tel">@error('phone')<p class="rk-field-error">{{ $message }}</p>@enderror</div>
                        </div>
                        <div><label for="contact_subject">Subject *</label><input id="contact_subject" name="subject" type="text" value="{{ old('subject', request('subject')) }}" required>@error('subject')<p class="rk-field-error">{{ $message }}</p>@enderror</div>
                        <div><label for="contact_message">Message *</label><textarea id="contact_message" name="message" required>{{ old('message') }}</textarea>@error('message')<p class="rk-field-error">{{ $message }}</p>@enderror</div>
                        <x-public.action type="submit" class="w-full sm:w-auto">Send message</x-public.action>
                    </form>
                </div>

                <div class="pt-8" x-cloak x-show="tab === 'quote'" x-transition.opacity role="tabpanel">
                    <x-public.eyebrow>Project quotation</x-public.eyebrow>
                    <h2 class="mt-4 text-3xl tracking-[-.05em] sm:text-4xl">Give us the important details.</h2>
                    <p class="mt-4 max-w-2xl text-[#69665f] leading-relaxed">A little context helps our engineering team understand your project and respond thoughtfully.</p>
                    <form class="rk-form mt-8" action="{{ route('public.quotation.submit') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="_tab" value="quote">
                        <section class="rk-form-section">
                            <h3>Contact information</h3>
                            <div class="rk-form__split">
                                <div><label for="quote_name">Full name *</label><input id="quote_name" name="name" type="text" value="{{ old('name') }}" required autocomplete="name">@error('name')<p class="rk-field-error">{{ $message }}</p>@enderror</div>
                                <div><label for="quote_company">Company</label><input id="quote_company" name="company" type="text" value="{{ old('company') }}" autocomplete="organization">@error('company')<p class="rk-field-error">{{ $message }}</p>@enderror</div>
                                <div><label for="quote_email">Email *</label><input id="quote_email" name="email" type="email" value="{{ old('email') }}" required autocomplete="email">@error('email')<p class="rk-field-error">{{ $message }}</p>@enderror</div>
                                <div><label for="quote_phone">Phone</label><input id="quote_phone" name="phone" type="text" value="{{ old('phone') }}" autocomplete="tel">@error('phone')<p class="rk-field-error">{{ $message }}</p>@enderror</div>
                            </div>
                        </section>
                        <section class="rk-form-section">
                            <h3>Project details</h3>
                            <div class="rk-form__split">
                                <div>
                                    <label for="quote_service">Primary service needed *</label>
                                    <select id="quote_service" name="service_needed" required>
                                        <option value="">Select a service</option>
                                        @foreach(['General Construction', 'Structural Engineering', 'Civil Engineering', 'Project Management', 'Consultancy', 'Other'] as $option)
                                            <option value="{{ $option }}" @selected(old('service_needed') === $option)>{{ $option }}</option>
                                        @endforeach
                                    </select>
                                    @error('service_needed')<p class="rk-field-error">{{ $message }}</p>@enderror
                                </div>
                                <div><label for="quote_location">Project location *</label><input id="quote_location" name="project_location" type="text" value="{{ old('project_location') }}" required placeholder="City, Province">@error('project_location')<p class="rk-field-error">{{ $message }}</p>@enderror</div>
                                <div><label for="quote_budget">Estimated budget range</label><input id="quote_budget" name="budget" type="text" value="{{ old('budget') }}">@error('budget')<p class="rk-field-error">{{ $message }}</p>@enderror</div>
                                <div><label for="quote_timeline">Expected timeline</label><input id="quote_timeline" name="timeline" type="text" value="{{ old('timeline') }}">@error('timeline')<p class="rk-field-error">{{ $message }}</p>@enderror</div>
                            </div>
                            <div class="mt-5"><label for="quote_description">Project description *</label><textarea id="quote_description" name="description" required>{{ old('description') }}</textarea>@error('description')<p class="rk-field-error">{{ $message }}</p>@enderror</div>
                            <div class="mt-5"><label for="quote_attachment">Attach documents</label><input id="quote_attachment" name="attachment" type="file" accept=".pdf,.doc,.docx,.jpg,.png,.zip"><p class="mt-2 text-xs text-[#69665f]">Optional · PDF, DOC, JPG, PNG, or ZIP · maximum 10 MB</p>@error('attachment')<p class="rk-field-error">{{ $message }}</p>@enderror</div>
                        </section>
                        <x-public.action type="submit" class="w-full sm:w-auto">Submit request</x-public.action>
                    </form>
                </div>
            </div>
        </div>
    </section>
</x-public-layout>
