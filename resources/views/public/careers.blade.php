<x-public-layout>
    <x-slot name="title">Careers</x-slot>

    <x-public.page-intro eyebrow="Careers" number="07" title="Build work you can stand behind." lede="We are looking for thoughtful, capable people who care about the quality of the work and the way it is delivered." />

    <section class="rk-section" x-data="{ applyFor: @js(old('job_title', request('job'))), submitting: false }">
        <div class="rk-container rk-career-layout">
            <div>
                <x-public.eyebrow>Open positions</x-public.eyebrow>
                <h2 class="rk-section__title mt-4">Find the role that fits your next chapter.</h2>
                <div class="rk-job-list mt-12">
                    @forelse($jobs as $job)
                        <article class="rk-job">
                            <div class="rk-job__top">
                                <div>
                                    <h2>{{ $job->title }}</h2>
                                    <p class="rk-job__meta">
                                        @if($job->type)<span>{{ $job->type }}</span>@endif
                                        @if($job->location)<span>{{ $job->location }}</span>@endif
                                    </p>
                                </div>
                                <a href="#application-form" class="rk-job__apply" @click="applyFor = @js($job->title)">Apply now</a>
                            </div>
                            @if($job->description)<p class="rk-job__description">{{ Str::limit(strip_tags($job->description), 400) }}</p>@endif
                        </article>
                    @empty
                        <p class="rk-empty">We currently have no open positions. Please check back soon.</p>
                    @endforelse
                </div>
                @if($jobs->hasPages())
                    <div class="mt-12 flex justify-center">{{ $jobs->links('vendor.pagination.tailwind') }}</div>
                @endif
            </div>

            <aside id="application-form" class="rk-form-panel lg:sticky lg:top-24">
                <x-public.eyebrow>Apply to RubiKnows</x-public.eyebrow>
                <h2>Send your application.</h2>
                <p class="rk-form-panel__intro">Share your details and resume. If there is no exact role for you, choose General Application.</p>

                @error('application')<p class="rk-field-error border-l-2 border-red-700 bg-red-50 p-3">{{ $message }}</p>@enderror

                <form class="rk-form" action="{{ route('public.careers.apply') }}" method="POST" enctype="multipart/form-data" @submit="submitting = true" :aria-busy="submitting.toString()">
                    @csrf
                    <div>
                        <label for="job_title">Position applied for *</label>
                        <select id="job_title" name="job_title" x-model="applyFor" required>
                            <option value="">Select a position</option>
                            <option value="General Application">General Application</option>
                            @foreach($jobs as $job)<option value="{{ $job->title }}">{{ $job->title }}</option>@endforeach
                        </select>
                        @error('job_title')<p class="rk-field-error">{{ $message }}</p>@enderror
                    </div>
                    <div class="rk-form__split">
                        <div>
                            <label for="application_name">Full name *</label>
                            <input id="application_name" name="name" type="text" value="{{ old('name') }}" required autocomplete="name">
                            @error('name')<p class="rk-field-error">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="application_email">Email *</label>
                            <input id="application_email" name="email" type="email" value="{{ old('email') }}" required autocomplete="email">
                            @error('email')<p class="rk-field-error">{{ $message }}</p>@enderror
                        </div>
                    </div>
                    <div>
                        <label for="application_phone">Phone</label>
                        <input id="application_phone" name="phone" type="text" value="{{ old('phone') }}" autocomplete="tel">
                        @error('phone')<p class="rk-field-error">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="application_message">Cover letter or message</label>
                        <textarea id="application_message" name="message" rows="4">{{ old('message') }}</textarea>
                        @error('message')<p class="rk-field-error">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="application_resume">Resume / CV *</label>
                        <input id="application_resume" name="resume" type="file" accept=".pdf,.doc,.docx" required>
                        <p class="mt-2 text-xs text-[#69665f]">PDF, DOC, or DOCX · maximum 5 MB</p>
                        @error('resume')<p class="rk-field-error">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="application_portfolio">Portfolio</label>
                        <input id="application_portfolio" name="portfolio" type="file" accept=".pdf,.zip">
                        <p class="mt-2 text-xs text-[#69665f]">PDF or ZIP · optional · maximum 10 MB</p>
                        @error('portfolio')<p class="rk-field-error">{{ $message }}</p>@enderror
                    </div>
                    <x-public.action type="submit" x-bind:disabled="submitting" class="w-full" x-bind:class="{ 'opacity-60': submitting }"><span x-text="submitting ? 'Submitting application…' : 'Submit application'"></span></x-public.action>
                </form>
            </aside>
        </div>
    </section>
</x-public-layout>
