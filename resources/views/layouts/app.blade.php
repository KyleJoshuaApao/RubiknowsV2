<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>
            @isset($header)
                {{ strip_tags($header) }} | RubiKnows Admin
            @else
                RubiKnows Admin Portal
            @endisset
        </title>

        <!-- Favicon -->
        <link rel="icon" type="image/png" href="{{ asset('LOGO.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Chart.js -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    </head>
    <body class="font-sans antialiased text-richblack-900 bg-white flex h-screen overflow-hidden">

        <!-- ===== SIDEBAR ===== -->
        <aside class="w-64 bg-richblack-950 flex-shrink-0 flex flex-col hidden md:flex text-gray-300 relative z-20">

            <!-- Branding -->
            <div class="h-20 flex items-center px-6 bg-richblack-950 relative z-10 border-b-4 border-brand-500 rounded-none">
                <a href="{{ url('/') }}" class="flex items-center gap-2.5 group">
                    <img src="{{ asset('RK3.png') }}" alt="Rubiknows Logo" class="h-7 w-auto object-contain transition-transform duration-300 group-hover:scale-105">
                    <span class="text-2xl tracking-tight">
                        <span class="text-white font-light">RUBI</span><span class="text-brand-500 font-bold">KNOWS</span>
                    </span>
                </a>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 px-3 py-6 space-y-6 overflow-y-auto scrollbar-thin">
                @php
                    $icons = json_decode(file_get_contents(resource_path('views/components/icons.blade.php')), true);
                    $unreadMsgs = \App\Models\ContactMessage::where('status', 'New')->count();
                    $pendingQuotes = \App\Models\QuotationRequest::where('status', 'Pending')->count();
                    $newApps = \App\Models\JobApplication::where('status', 'Received')->count();
                @endphp

                <!-- Overview Section -->
                <x-snav-section title="Overview" />
                <x-snav-item
                    href="{{ route('dashboard') }}"
                    icon="{{$icons['dashboard']}}"
                    label="Dashboard"
                    activeWhen="['dashboard']"
                />

                <!-- Website Content Section -->
                <x-snav-section title="Website Content" />
                <x-snav-item
                    href="{{ route('admin.projects.index') }}"
                    icon="{{$icons['projects']}}"
                    label="Project Portfolio"
                    activeWhen="['admin.projects.*']"
                />
                <x-snav-item
                    href="{{ route('admin.gallery.index') }}"
                    icon="{{$icons['gallery']}}"
                    label="Media Gallery"
                    activeWhen="['admin.gallery.*']"
                    class="mt-0.5"
                />
                <x-snav-item
                    href="{{ route('admin.services.index') }}"
                    icon="{{$icons['services']}}"
                    label="Services"
                    activeWhen="['admin.services.*']"
                    class="mt-0.5"
                />
                <x-snav-item
                    href="{{ route('admin.clients.index') }}"
                    icon="{{$icons['clients']}}"
                    label="Clients & Partners"
                    activeWhen="['admin.clients.*']"
                    class="mt-0.5"
                />
                <x-snav-item
                    href="{{ route('admin.testimonials.index') }}"
                    icon="{{$icons['testimonials']}}"
                    label="Testimonials"
                    activeWhen="['admin.testimonials.*']"
                    class="mt-0.5"
                />

                <!-- Communications Section -->
                <x-snav-section title="Communications" />
                <x-snav-item
                    href="{{ route('admin.messages.index') }}"
                    icon="{{$icons['messages']}}"
                    label="Inbox (Contact Us)"
                    badge="{{$unreadMsgs}}"
                    badgeColor="brand-500"
                    activeWhen="['admin.messages.*']"
                />
                <x-snav-item
                    href="{{ route('admin.quotations.index') }}"
                    icon="{{$icons['quotations']}}"
                    label="Quotation Requests"
                    badge="{{$pendingQuotes}}"
                    badgeColor="blue-500"
                    activeWhen="['admin.quotations.*']"
                    class="mt-0.5"
                />

                <!-- Human Resources Section -->
                <x-snav-section title="Human Resources" />
                <x-snav-item
                    href="{{ route('admin.jobs.index') }}"
                    icon="{{$icons['jobs']}}"
                    label="Job Postings"
                    activeWhen="['admin.jobs.*']"
                />
                <x-snav-item
                    href="{{ route('admin.applications.index') }}"
                    icon="{{$icons['applications']}}"
                    label="Applicants"
                    badge="{{$newApps}}"
                    badgeColor="green-500"
                    activeWhen="['admin.applications.*']"
                    class="mt-0.5"
                />

                <!-- System Settings Section -->
                <x-snav-section title="System" />
                @if(Auth::user()->role === 'Super Admin')
                    <x-snav-item
                        href="{{ route('admin.users.index') }}"
                        icon="{{$icons['users']}}"
                        label="User Management"
                        activeWhen="['admin.users.*']"
                        class="mb-0.5"
                    />
                @endif
                <x-snav-item
                    href="{{ route('admin.settings.index') }}"
                    icon="{{$icons['settings']}}"
                    label="Global Settings"
                    activeWhen="['admin.settings.*']"
                />
            </nav>

            <!-- User Info (Bottom Sidebar) -->
            <div class="relative z-10 p-4 border-t border-richblack-900 bg-richblack-950">
                <a href="{{ route('profile.edit') }}" class="flex items-center hover:bg-white/5 p-2 transition-all duration-200 group">
                    <div class="w-8 h-8 overflow-hidden bg-richblack-900 border border-gray-700 flex items-center justify-center flex-shrink-0 group-hover:border-brand-500 transition-colors">
                        @if(Auth::user()->profile_photo_url)
                            <img src="{{ Storage::url(Auth::user()->profile_photo_url) }}" alt="{{ Auth::user()->name }}" class="h-full w-full object-cover">
                        @else
                            <span class="text-white font-bold text-sm">{{ substr(Auth::user()->name, 0, 1) }}</span>
                        @endif
                    </div>
                    <div class="ml-3 truncate">
                        <p class="text-sm font-bold text-white group-hover:text-brand-500 transition-colors">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-400 truncate">{{ Auth::user()->email }}</p>
                    </div>
                </a>
                <form method="POST" action="{{ route('logout') }}" class="mt-3">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2 text-xs font-bold text-gray-400 hover:text-white hover:bg-brand-500 hover:text-white transition-all duration-200">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                        Sign Out
                    </button>
                </form>
            </div>
        </aside>

        <!-- ===== MAIN CONTENT ===== -->
        <main class="flex-1 flex flex-col h-screen overflow-hidden">

            <!-- Top Navbar -->
            <header class="h-20 bg-white border-b-4 border-gray-100 flex items-center justify-between px-6 lg:px-8 z-10 flex-shrink-0 relative">
                <!-- Subtle top geometric accent -->
                <div class="absolute top-0 left-0 w-1/3 h-1 bg-gradient-to-r from-brand-500 to-transparent"></div>
                <div class="flex items-center flex-1 min-w-0">
                    <button class="md:hidden text-gray-400 hover:text-brand-500 mr-4 focus:outline-none transition-colors">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <!-- Page Title dynamically inserted -->
                    @isset($header)
                        <div class="flex-1 min-w-0 text-gray-900">
                            {{ $header }}
                        </div>
                    @endisset
                </div>

                @php
                    $unreadMsgs = \App\Models\ContactMessage::where('status', 'New')->count();
                    $pendingQuotes = \App\Models\QuotationRequest::where('status', 'Pending')->count();
                    $newApps = \App\Models\JobApplication::where('status', 'Received')->count();
                    $totalNotifications = $unreadMsgs + $pendingQuotes + $newApps;
                @endphp
                <div class="flex items-center space-x-3 relative" x-data="{ open: false }">
                    <!-- Notification Bell -->
                    <button @click="open = !open" @click.outside="open = false" class="p-2.5  text-gray-400 hover:text-brand-500 hover:bg-brand-50 transition-all relative focus:outline-none" title="Notifications">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                        </svg>
                        @if($totalNotifications > 0)
                            <span class="absolute top-2 right-2 w-2 h-2 bg-brand-500 rounded-full border-2 border-white animate-pulse-soft"></span>
                        @endif
                    </button>

                    <!-- Notification Dropdown -->
                    <div x-show="open"
                         x-transition:enter="transition ease-out duration-150"
                         x-transition:enter-start="transform opacity-0 scale-95 translate-y-2"
                         x-transition:enter-end="transform opacity-100 scale-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-100"
                         x-transition:leave-start="transform opacity-100 scale-100 translate-y-0"
                         x-transition:leave-end="transform opacity-0 scale-95 translate-y-2"
                         class="absolute right-0 mt-2 w-[22rem] bg-white  shadow-xl border border-gray-100 py-2 z-50 text-gray-800"
                         style="top: 100%; display: none;">
                        <div class="px-5 py-3 border-b border-gray-100 flex items-center justify-between">
                            <span class="text-xs font-semibold uppercase text-gray-500 tracking-wider">Notifications</span>
                            @if($totalNotifications > 0)
                                <span class="text-[10px] font-mono text-brand-500 bg-brand-50 px-2 py-0.5 rounded-full">{{ $totalNotifications }} new</span>
                            @endif
                        </div>
                        <div class="max-h-72 overflow-y-auto no-scrollbar">
                            @if($unreadMsgs > 0)
                                <a href="{{ route('admin.messages.index') }}" class="block px-5 py-3.5 hover:bg-gray-50 border-b border-gray-50 transition-colors group">
                                    <div class="flex items-start gap-3">
                                        <span class="w-2 h-2 mt-1.5 bg-brand-500 rounded-full flex-shrink-0 group-hover:scale-125 transition-transform"></span>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm text-gray-900">
                                                You have <span class="font-bold text-brand-500">{{ $unreadMsgs }}</span> unread contact message{{ $unreadMsgs > 1 ? 's' : '' }}.
                                            </p>
                                            <p class="text-xs text-gray-400 mt-0.5">Click to view inbox</p>
                                        </div>
                                    </div>
                                </a>
                            @endif

                            @if($pendingQuotes > 0)
                                <a href="{{ route('admin.quotations.index') }}" class="block px-5 py-3.5 hover:bg-gray-50 border-b border-gray-50 transition-colors group">
                                    <div class="flex items-start gap-3">
                                        <span class="w-2 h-2 mt-1.5 bg-blue-500 rounded-full flex-shrink-0 group-hover:scale-125 transition-transform"></span>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm text-gray-900">
                                                You have <span class="font-bold text-blue-600">{{ $pendingQuotes }}</span> pending quotation request{{ $pendingQuotes > 1 ? 's' : '' }}.
                                            </p>
                                            <p class="text-xs text-gray-400 mt-0.5">Click to review quotations</p>
                                        </div>
                                    </div>
                                </a>
                            @endif

                            @if($newApps > 0)
                                <a href="{{ route('admin.applications.index') }}" class="block px-5 py-3.5 hover:bg-gray-50 border-b border-gray-50 transition-colors group">
                                    <div class="flex items-start gap-3">
                                        <span class="w-2 h-2 mt-1.5 bg-green-500 rounded-full flex-shrink-0 group-hover:scale-125 transition-transform"></span>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm text-gray-900">
                                                You have <span class="font-bold text-green-600">{{ $newApps }}</span> new job application{{ $newApps > 1 ? 's' : '' }}.
                                            </p>
                                            <p class="text-xs text-gray-400 mt-0.5">Click to review applicants</p>
                                        </div>
                                    </div>
                                </a>
                            @endif

                            @if($totalNotifications === 0)
                                <div class="px-5 py-10 text-center">
                                    <svg class="w-10 h-10 mx-auto text-gray-200 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                                    </svg>
                                    <p class="text-sm text-gray-400">No new notifications</p>
                                    <p class="text-xs text-gray-300 mt-1">You're all caught up!</p>
                                </div>
                            @endif
                        </div>
                        @if($totalNotifications > 0)
                            <div class="px-5 py-2.5 border-t border-gray-100 text-center">
                                <span class="text-xs text-gray-400">Notifications auto-dismiss when addressed</span>
                            </div>
                        @endif
                    </div>
                </div>
            </header>

            <!-- Scrollable Content Area -->
            <div class="flex-1 overflow-y-auto bg-white">
                <div class="p-6 lg:p-8">
                    <!-- Alert System -->
                    {{-- Flash toasts are rendered by the global RubiKnows toast system below --}}

                    {{ $slot }}
                </div>
            </div>
        </main>

        <!-- ============================================================
             RUBIKNOWS — Global Toast Notification System
             ============================================================ -->
        <div
            id="rk-toast-container"
            class="fixed top-5 right-5 z-[99999] flex flex-col gap-3 pointer-events-none"
            aria-live="polite"
        ></div>

        <!-- ============================================================
             RUBIKNOWS — Custom Confirm Modal
             ============================================================ -->
        <div id="rk-confirm-backdrop"
             class="fixed inset-0 z-[99998] flex items-center justify-center p-4"
             style="display:none!important; background:rgba(0,0,0,0.55); backdrop-filter:blur(4px);">
            <div id="rk-confirm-box"
                 class="relative w-full max-w-md bg-white  shadow-2xl overflow-hidden"
                 style="transform:scale(0.92);opacity:0;transition:transform 0.22s cubic-bezier(.34,1.56,.64,1),opacity 0.18s ease;">
                <!-- Top accent bar -->
                <div class="h-1 w-full bg-gradient-to-r from-brand-500 via-brand-400 to-brand-600"></div>
                <div class="px-7 pt-7 pb-6">
                    <!-- Icon -->
                    <div class="flex items-center gap-4 mb-5">
                        <div class="flex-shrink-0 w-11 h-11  bg-brand-50 border border-brand-100 flex items-center justify-center">
                            <svg class="w-5 h-5 text-brand-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold uppercase tracking-widest text-brand-500 mb-0.5">Confirm Action</p>
                            <h3 id="rk-confirm-title" class="text-base font-bold text-gray-900 leading-snug">Are you sure?</h3>
                        </div>
                    </div>
                    <p id="rk-confirm-message" class="text-sm text-gray-500 leading-relaxed mb-7"></p>
                    <div class="flex items-center gap-3 justify-end">
                        <button id="rk-confirm-cancel"
                                class="px-5 py-2.5  border border-gray-200 bg-white text-sm font-semibold text-gray-600 hover:bg-gray-50 hover:border-gray-300 transition-all duration-200">
                            Cancel
                        </button>
                        <button id="rk-confirm-ok"
                                class="px-5 py-2.5  bg-gradient-to-r from-brand-500 to-brand-600 text-white text-sm font-bold shadow-lg shadow-brand-200 hover:from-brand-600 hover:to-brand-700 transition-all duration-200">
                            Confirm
                        </button>
                    </div>
                </div>
                <!-- Logo watermark -->
                <div class="absolute bottom-3 left-6 flex items-center gap-1.5 opacity-30 select-none">
                    <img src="{{ asset('LOGO.png') }}" alt="" class="h-4 w-auto">
                    <span class="text-[9px] font-bold tracking-widest text-gray-400 uppercase">RubiKnows</span>
                </div>
            </div>
        </div>

        <script>
        /* ================================================================
           RubiKnows — Notification & Confirm System
           ================================================================ */
        (function () {
            'use strict';

            /* ---------- TOAST ---------- */
            var _toastContainer = document.getElementById('rk-toast-container');

            function rkToast(message, type) {
                type = type || 'success';
                var cfg = {
                    success : { icon: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>', bar: '#16a34a', iconColor: '#16a34a', bg: '#fff' },
                    error   : { icon: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l2-2m-2 2l2-2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>', bar: '#E31B23', iconColor: '#E31B23', bg: '#fff' },
                    info    : { icon: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>', bar: '#3b82f6', iconColor: '#3b82f6', bg: '#fff' },
                };
                var c = cfg[type] || cfg.success;
                var toast = document.createElement('div');
                toast.style.cssText = 'pointer-events:all;min-width:300px;max-width:380px;background:'+c.bg+';border-radius:16px;box-shadow:0 8px 32px rgba(0,0,0,0.13),0 2px 8px rgba(0,0,0,0.07);overflow:hidden;transform:translateX(120%);opacity:0;transition:transform 0.38s cubic-bezier(.34,1.56,.64,1),opacity 0.25s ease;';
                toast.innerHTML = '<div style="height:3px;background:'+c.bar+';border-radius:999px 999px 0 0"></div>'
                    + '<div style="display:flex;align-items:flex-start;gap:12px;padding:14px 16px 14px 16px;">'
                    + '<div style="flex-shrink:0;width:34px;height:34px;border-radius:10px;background:'+c.bar+'18;display:flex;align-items:center;justify-content:center;">'
                    + '<svg style="width:18px;height:18px;color:'+c.iconColor+'" fill="none" viewBox="0 0 24 24" stroke="'+c.iconColor+'">'+c.icon+'</svg></div>'
                    + '<div style="flex:1;min-width:0;">'
                    + '<p style="font-size:10px;font-weight:700;letter-spacing:.15em;text-transform:uppercase;color:'+c.bar+';margin:0 0 2px 0;">'
                    + (type === 'success' ? 'Success' : type === 'error' ? 'Error' : 'Notice') + '</p>'
                    + '<p style="font-size:13px;font-weight:500;color:#1a1a1a;margin:0;line-height:1.5;">'+message+'</p></div>'
                    + '<button onclick="this.closest(\'[data-rk-toast]\').remove()" style="flex-shrink:0;padding:2px;background:none;border:none;cursor:pointer;color:#9ca3af;margin-top:1px;">'
                    + '<svg style="width:15px;height:15px" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>'
                    + '</div>';
                toast.setAttribute('data-rk-toast', '1');
                _toastContainer.appendChild(toast);
                requestAnimationFrame(function () {
                    requestAnimationFrame(function () {
                        toast.style.transform = 'translateX(0)';
                        toast.style.opacity   = '1';
                    });
                });
                setTimeout(function () { dismissToast(toast); }, 5000);
            }

            function dismissToast(toast) {
                toast.style.transform = 'translateX(120%)';
                toast.style.opacity   = '0';
                setTimeout(function () { if (toast.parentNode) toast.parentNode.removeChild(toast); }, 400);
            }

            window.rkToast = rkToast;

            /* ---------- Auto-fire session flash toasts ---------- */
            @if(session('success'))
            window.addEventListener('DOMContentLoaded', function () {
                rkToast({{ json_encode(session('success')) }}, 'success');
            });
            @endif
            @if(session('error'))
            window.addEventListener('DOMContentLoaded', function () {
                rkToast({{ json_encode(session('error')) }}, 'error');
            });
            @endif

            /* ---------- CONFIRM MODAL ---------- */
            var _backdrop = document.getElementById('rk-confirm-backdrop');
            var _box      = document.getElementById('rk-confirm-box');
            var _title    = document.getElementById('rk-confirm-title');
            var _msg      = document.getElementById('rk-confirm-message');
            var _okBtn    = document.getElementById('rk-confirm-ok');
            var _cancelBtn= document.getElementById('rk-confirm-cancel');
            var _pendingResolve = null;

            function openConfirm(message, title) {
                _title.textContent   = title   || 'Are you sure?';
                _msg.textContent     = message || 'This action cannot be undone.';
                _backdrop.style.cssText = 'display:flex!important;position:fixed;inset:0;z-index:99998;align-items:center;justify-content:center;padding:1rem;background:rgba(0,0,0,0.55);backdrop-filter:blur(4px);';
                requestAnimationFrame(function () {
                    requestAnimationFrame(function () {
                        _box.style.transform = 'scale(1)';
                        _box.style.opacity   = '1';
                    });
                });
                return new Promise(function (resolve) { _pendingResolve = resolve; });
            }

            function closeConfirm(result) {
                _box.style.transform = 'scale(0.92)';
                _box.style.opacity   = '0';
                setTimeout(function () {
                    _backdrop.style.cssText = 'display:none!important;';
                }, 220);
                if (_pendingResolve) { _pendingResolve(result); _pendingResolve = null; }
            }

            _okBtn.addEventListener('click',     function () { closeConfirm(true);  });
            _cancelBtn.addEventListener('click',  function () { closeConfirm(false); });
            _backdrop.addEventListener('click',   function (e) { if (e.target === _backdrop) closeConfirm(false); });
            document.addEventListener('keydown',  function (e) { if (e.key === 'Escape') closeConfirm(false); });

            window.rkConfirm = openConfirm;

            /* ---------- Intercept all data-confirm forms ---------- */
            document.addEventListener('submit', function (e) {
                var form = e.target;
                var msg  = form.getAttribute('data-confirm');
                if (!msg) return;
                e.preventDefault();
                openConfirm(msg).then(function (ok) {
                    if (ok) {
                        form.removeAttribute('data-confirm');
                        form.submit();
                    }
                });
            }, true);

        })();
        </script>
    </body>
</html>