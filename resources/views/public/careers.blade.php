<x-public-layout>
    <x-slot name="title">Careers</x-slot>
    <x-slot name="description">Open positions at RubiKnows, an engineering and construction company in Tagum City, Davao del Norte. Apply online with your resume.</x-slot>

    <x-public.page-header title="Careers" lede="Join an engineering and construction team based in Tagum City. We hire engineers, site staff and skilled workers who take pride in their work." :breadcrumbs="['Careers' => null]" />

    <section class="rk-section" x-data="{ applyFor: @js((string) old('job_id', request('job', ''))), submitting: false, choose(id) { this.applyFor = String(id); this.$nextTick(() => { document.getElementById('application-form').scrollIntoView({ behavior: 'smooth', block: 'start' }); document.getElementById('job_id').focus({ preventScroll: true }); }) } }">
        <div class="rk-container rk-careers-grid">
            <div>
                <h2 class="rk-subheading">Open positions</h2>
                @if($jobs->isNotEmpty())
                    <div class="rk-jobs">
                        @foreach($jobs as $job)
                            @php($requirements = is_array($job->requirements) ? implode("\n", $job->requirements) : (string) $job->requirements)
                            <details class="rk-job" id="job-{{ $job->id }}" @if($loop->first && $jobs->count() === 1) open @endif>
                                <summary>
                                    <span>
                                        <span class="rk-job__title">{{ $job->title }}</span>
                                        <span class="rk-job__meta">
                                            @if($job->type)<span class="rk-tag">{{ $job->type }}</span>@endif
                                            @if($job->location)<span class="rk-tag">{{ $job->location }}</span>@endif
                                        </span>
                                    </span>
                                    <span class="rk-job__toggle" aria-hidden="true"></span>
                                </summary>
                                <div class="rk-job__body rk-prose">
                                    {{ \App\Support\Markdown::render($job->description) }}
                                    @if(trim($requirements) !== '')
                                        <h3>Qualifications</h3>
                                        {{ \App\Support\Markdown::render($requirements) }}
                                    @endif
                                    <p><button type="button" class="rk-btn rk-btn--dark" @click="choose({{ $job->id }})">Apply for this position</button></p>
                                </div>
                            </details>
                        @endforeach
                    </div>
                    {{ $jobs->links('vendor.pagination.public') }}
                @else
                    <div class="rk-note">
                        <p>There are no open positions right now. You can still send a general application, and we will contact you when a suitable role opens.</p>
                    </div>
                @endif

                <div class="rk-note rk-note--muted">
                    <h3>What happens next</h3>
                    <p>We read every application. If your experience matches what we need, we will contact you by phone or email to arrange an interview.</p>
                </div>
            </div>

            <aside id="application-form" class="rk-form-panel" aria-labelledby="apply-title">
                <h2 id="apply-title">Apply online</h2>
                <p class="rk-form-panel__intro">Fields marked * are required. If no listed role fits, choose “General application”.</p>

                @if($errors->has('application') || $errors->has('form'))
                    <p class="rk-form-alert" role="alert">{{ $errors->first('application') ?: $errors->first('form') }}</p>
                @endif

                <form class="rk-form" action="{{ route('public.careers.apply') }}" method="POST" enctype="multipart/form-data" @submit="submitting = true" :aria-busy="submitting.toString()">
                    @csrf
                    <x-public.spam-guard />
                    <div class="rk-field">
                        <label for="job_id">Position *</label>
                        <select class="rk-input" id="job_id" name="job_id" x-model="applyFor" required>
                            <option value="">Select a position</option>
                            @foreach($jobs as $job)<option value="{{ $job->id }}">{{ $job->title }}</option>@endforeach
                            <option value="{{ \App\Http\Requests\StoreJobApplicationRequest::GENERAL_APPLICATION }}">General application</option>
                        </select>
                        @error('job_id')<p class="rk-field__error">{{ $message }}</p>@enderror
                    </div>
                    <div class="rk-field">
                        <label for="application_name">Full name *</label>
                        <input class="rk-input" id="application_name" name="name" type="text" value="{{ old('name') }}" required autocomplete="name" @error('name') aria-invalid="true" @enderror>
                        @error('name')<p class="rk-field__error">{{ $message }}</p>@enderror
                    </div>
                    <div class="rk-form__row">
                        <div class="rk-field">
                            <label for="application_email">Email *</label>
                            <input class="rk-input" id="application_email" name="email" type="email" value="{{ old('email') }}" required autocomplete="email" @error('email') aria-invalid="true" @enderror>
                            @error('email')<p class="rk-field__error">{{ $message }}</p>@enderror
                        </div>
                        <div class="rk-field">
                            <label for="application_phone">Mobile number <span class="rk-optional">(optional)</span></label>
                            <input class="rk-input" id="application_phone" name="phone" type="tel" value="{{ old('phone') }}" autocomplete="tel" @error('phone') aria-invalid="true" @enderror>
                            @error('phone')<p class="rk-field__error">{{ $message }}</p>@enderror
                        </div>
                    </div>
                    <div class="rk-field">
                        <label for="application_message">Cover letter or message</label>
                        <textarea class="rk-input" id="application_message" name="message" rows="5">{{ old('message') }}</textarea>
                        @error('message')<p class="rk-field__error">{{ $message }}</p>@enderror
                    </div>
                    <div class="rk-field">
                        <label for="application_resume">Resume or CV *</label>
                        <input class="rk-input" id="application_resume" name="resume" type="file" accept=".pdf,.doc,.docx" required aria-describedby="resume-hint">
                        <p class="rk-field__hint" id="resume-hint">PDF, DOC or DOCX, up to 5 MB.</p>
                        @error('resume')<p class="rk-field__error">{{ $message }}</p>@enderror
                    </div>
                    <div class="rk-field">
                        <label for="application_portfolio">Portfolio <span class="rk-optional">(optional)</span></label>
                        <input class="rk-input" id="application_portfolio" name="portfolio" type="file" accept=".pdf,.zip" aria-describedby="portfolio-hint">
                        <p class="rk-field__hint" id="portfolio-hint">PDF or ZIP, up to 10 MB.</p>
                        @error('portfolio')<p class="rk-field__error">{{ $message }}</p>@enderror
                    </div>
                    <p class="rk-field__hint">By applying you agree that we may use your details to assess your application, as described in our <a href="{{ route('public.privacy') }}">privacy policy</a>.</p>
                    <button type="submit" class="rk-btn rk-btn--primary rk-btn--block" :disabled="submitting">
                        <span x-text="submitting ? 'Sending application…' : 'Send application'">Send application</span>
                    </button>
                </form>
            </aside>
        </div>
    </section>
</x-public-layout>
