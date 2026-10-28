<x-public-layout>
    <x-slot name="title">Contact us</x-slot>
    <x-slot name="description">Contact RUBIKNOWS in Tagum City, Davao del Norte. Call, email or send a message, or request a quotation for your project.</x-slot>

    @php
        $contact = \App\Support\ContactDetails::fromSettings();
        [$phone, $email, $address] = [$contact->phone, $contact->email, $contact->address];
        $activeTab = old('_tab', request('tab') === 'quote' ? 'quote' : 'general');
        $selectedService = old('service_needed', request('service'));
        $serviceChoices = $serviceOptions->push('Other or not sure')->unique()->values();
    @endphp

    <x-public.page-header title="Contact us" lede="Call, email or visit the office, or send us the details of your project using the form." :breadcrumbs="['Contact' => null]" />

    <section class="rk-section">
        <div class="rk-container rk-contact-grid" x-data="{ tab: @js($activeTab) }">
            <aside aria-labelledby="details-title">
                <h2 id="details-title" class="rk-subheading">Contact details</h2>
                <dl class="rk-contact-list">
                    @if($phone)
                        <div><dt>Phone</dt><dd><a href="tel:{{ $contact->phoneHref }}">{{ $phone }}</a></dd></div>
                    @endif
                    @if($email)
                        <div><dt>Email</dt><dd><a href="mailto:{{ $email }}">{{ $email }}</a></dd></div>
                    @endif
                    @if($address)
                        <div>
                            <dt>Office</dt>
                            <dd>
                                {{ $address }}
                                <a class="rk-contact-list__map" href="https://www.openstreetmap.org/?mlat=7.450816&mlon=125.816674#map=17/7.450816/125.816674" target="_blank" rel="noopener">View on map</a>
                            </dd>
                        </div>
                    @endif
                </dl>
                <div class="rk-note rk-note--muted">
                    <h3>Requesting a quotation?</h3>
                    <p>Plans, a sketch, photos of the site or a short description all help. Attach what you have and we will tell you what else we need.</p>
                </div>
            </aside>

            <div>
                <div class="rk-tabs" role="tablist" aria-label="Type of enquiry">
                    <button type="button" role="tab" id="tab-general" aria-controls="panel-general" @click="tab = 'general'" :aria-selected="(tab === 'general').toString()" :tabindex="tab === 'general' ? 0 : -1" @keydown.arrow-right.prevent="tab = 'quote'; $nextTick(() => document.getElementById('tab-quote').focus())">Send a message</button>
                    <button type="button" role="tab" id="tab-quote" aria-controls="panel-quote" @click="tab = 'quote'" :aria-selected="(tab === 'quote').toString()" :tabindex="tab === 'quote' ? 0 : -1" @keydown.arrow-left.prevent="tab = 'general'; $nextTick(() => document.getElementById('tab-general').focus())">Request a quotation</button>
                </div>

                @error('form')<p class="rk-form-alert" role="alert">{{ $message }}</p>@enderror

                <div id="panel-general" role="tabpanel" aria-labelledby="tab-general" x-show="tab === 'general'" @if($activeTab !== 'general') x-cloak @endif>
                    <form class="rk-form" action="{{ route('public.contact.submit') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <x-public.spam-guard />
                        <input type="hidden" name="_tab" value="general">
                        <div class="rk-form__row">
                            <div class="rk-field">
                                <label for="contact_name">Name *</label>
                                <input class="rk-input" id="contact_name" name="name" type="text" value="{{ old('_tab') === 'general' ? old('name') : '' }}" required autocomplete="name">
                                @if(old('_tab') === 'general') @error('name')<p class="rk-field__error">{{ $message }}</p>@enderror @endif
                            </div>
                            <div class="rk-field">
                                <label for="contact_email">Email *</label>
                                <input class="rk-input" id="contact_email" name="email" type="email" value="{{ old('_tab') === 'general' ? old('email') : '' }}" required autocomplete="email">
                                @if(old('_tab') === 'general') @error('email')<p class="rk-field__error">{{ $message }}</p>@enderror @endif
                            </div>
                        </div>
                        <div class="rk-form__row">
                            <div class="rk-field">
                                <label for="contact_phone">Mobile number <span class="rk-optional">(optional)</span></label>
                                <input class="rk-input" id="contact_phone" name="phone" type="tel" value="{{ old('_tab') === 'general' ? old('phone') : '' }}" autocomplete="tel">
                                @if(old('_tab') === 'general') @error('phone')<p class="rk-field__error">{{ $message }}</p>@enderror @endif
                            </div>
                            <div class="rk-field">
                                <label for="contact_company">Company <span class="rk-optional">(optional)</span></label>
                                <input class="rk-input" id="contact_company" name="company" type="text" value="{{ old('_tab') === 'general' ? old('company') : '' }}" autocomplete="organization">
                                @if(old('_tab') === 'general') @error('company')<p class="rk-field__error">{{ $message }}</p>@enderror @endif
                            </div>
                        </div>
                        <div class="rk-field">
                            <label for="contact_subject">Subject *</label>
                            <input class="rk-input" id="contact_subject" name="subject" type="text" value="{{ old('_tab') === 'general' ? old('subject') : request('subject') }}" required>
                            @if(old('_tab') === 'general') @error('subject')<p class="rk-field__error">{{ $message }}</p>@enderror @endif
                        </div>
                        <div class="rk-field">
                            <label for="contact_message">Message *</label>
                            <textarea class="rk-input" id="contact_message" name="message" rows="6" required>{{ old('_tab') === 'general' ? old('message') : '' }}</textarea>
                            @if(old('_tab') === 'general') @error('message')<p class="rk-field__error">{{ $message }}</p>@enderror @endif
                        </div>
                        <x-public.file-field id="contact_attachments" label="Attach photos or documents" :show-errors="old('_tab') === 'general'" />
                        <p class="rk-field__hint">We use your details only to reply to you. See our <a href="{{ route('public.privacy') }}">privacy policy</a>.</p>
                        <div><button type="submit" class="rk-btn rk-btn--primary">Send message</button></div>
                    </form>
                </div>

                <div id="panel-quote" role="tabpanel" aria-labelledby="tab-quote" x-show="tab === 'quote'" @if($activeTab !== 'quote') x-cloak @endif>
                    @error('quotation')<p class="rk-form-alert" role="alert">{{ $message }}</p>@enderror
                    <form class="rk-form" action="{{ route('public.quotation.submit') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <x-public.spam-guard />
                        <input type="hidden" name="_tab" value="quote">
                        <fieldset class="rk-fieldset">
                            <legend>Your details</legend>
                            <div class="rk-form__row">
                                <div class="rk-field">
                                    <label for="quote_name">Full name *</label>
                                    <input class="rk-input" id="quote_name" name="name" type="text" value="{{ old('_tab') === 'quote' ? old('name') : '' }}" required autocomplete="name">
                                    @if(old('_tab') === 'quote') @error('name')<p class="rk-field__error">{{ $message }}</p>@enderror @endif
                                </div>
                                <div class="rk-field">
                                    <label for="quote_company">Company <span class="rk-optional">(optional)</span></label>
                                    <input class="rk-input" id="quote_company" name="company" type="text" value="{{ old('_tab') === 'quote' ? old('company') : '' }}" autocomplete="organization">
                                    @if(old('_tab') === 'quote') @error('company')<p class="rk-field__error">{{ $message }}</p>@enderror @endif
                                </div>
                                <div class="rk-field">
                                    <label for="quote_email">Email *</label>
                                    <input class="rk-input" id="quote_email" name="email" type="email" value="{{ old('_tab') === 'quote' ? old('email') : '' }}" required autocomplete="email">
                                    @if(old('_tab') === 'quote') @error('email')<p class="rk-field__error">{{ $message }}</p>@enderror @endif
                                </div>
                                <div class="rk-field">
                                    <label for="quote_phone">Mobile number <span class="rk-optional">(optional)</span></label>
                                    <input class="rk-input" id="quote_phone" name="phone" type="tel" value="{{ old('_tab') === 'quote' ? old('phone') : '' }}" autocomplete="tel">
                                    @if(old('_tab') === 'quote') @error('phone')<p class="rk-field__error">{{ $message }}</p>@enderror @endif
                                </div>
                            </div>
                        </fieldset>
                        <fieldset class="rk-fieldset">
                            <legend>Your project</legend>
                            <div class="rk-form__row">
                                <div class="rk-field">
                                    <label for="quote_service">Service needed *</label>
                                    <select class="rk-input" id="quote_service" name="service_needed" required>
                                        <option value="">Select a service</option>
                                        @foreach($serviceChoices as $option)
                                            <option value="{{ $option }}" @selected($selectedService === $option)>{{ $option }}</option>
                                        @endforeach
                                    </select>
                                    @error('service_needed')<p class="rk-field__error">{{ $message }}</p>@enderror
                                </div>
                                <div class="rk-field">
                                    <label for="quote_location">Project location *</label>
                                    <input class="rk-input" id="quote_location" name="project_location" type="text" value="{{ old('project_location') }}" required placeholder="Barangay, city or municipality">
                                    @error('project_location')<p class="rk-field__error">{{ $message }}</p>@enderror
                                </div>
                                <div class="rk-field">
                                    <label for="quote_budget">Budget range <span class="rk-optional">(optional)</span></label>
                                    <input class="rk-input" id="quote_budget" name="budget" type="text" value="{{ old('budget') }}" placeholder="e.g. ₱2–3 million">
                                    @error('budget')<p class="rk-field__error">{{ $message }}</p>@enderror
                                </div>
                                <div class="rk-field">
                                    <label for="quote_timeline">Target start or completion <span class="rk-optional">(optional)</span></label>
                                    <input class="rk-input" id="quote_timeline" name="timeline" type="text" value="{{ old('timeline') }}" placeholder="e.g. start by March">
                                    @error('timeline')<p class="rk-field__error">{{ $message }}</p>@enderror
                                </div>
                            </div>
                            <div class="rk-field">
                                <label for="quote_description">Describe the work *</label>
                                <textarea class="rk-input" id="quote_description" name="description" rows="6" required placeholder="What do you want to build or fix? Floor area, number of storeys, and anything else you know.">{{ old('description') }}</textarea>
                                @error('description')<p class="rk-field__error">{{ $message }}</p>@enderror
                            </div>
                            <x-public.file-field id="quote_attachments" label="Plans, sketches or site photos" :show-errors="old('_tab') === 'quote'" />
                        </fieldset>
                        <p class="rk-field__hint">We use your details only to prepare and follow up on your quotation. See our <a href="{{ route('public.privacy') }}">privacy policy</a>.</p>
                        <div><button type="submit" class="rk-btn rk-btn--primary">Send quotation request</button></div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</x-public-layout>
