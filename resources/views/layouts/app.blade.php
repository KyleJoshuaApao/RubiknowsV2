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
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600|roboto-slab:600,700,800,900&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <!-- Chart.js -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    </head>
    <body class="font-sans antialiased text-gray-900 bg-gray-50 flex h-screen overflow-hidden">

        <!-- ===== SIDEBAR ===== -->
        <aside class="w-64 bg-[#0a0a0a] shadow-2xl flex-shrink-0 flex flex-col hidden md:flex text-gray-300 relative z-20">
            <!-- Subtle gradient overlay on sidebar -->
            <div class="absolute inset-0 bg-gradient-to-b from-transparent via-transparent to-black/30 pointer-events-none"></div>
            <!-- Fine grid pattern on sidebar -->
            <div class="absolute inset-0 bg-grid-pattern-dark-fine pointer-events-none opacity-30"></div>

            <!-- Branding -->
            <div class="h-20 flex items-center px-6 bg-[#000000] border-b border-white/[0.04] relative z-10">
                <a href="{{ url('/') }}" class="flex items-center gap-2.5 group">
                    <div class="relative">
                        <img src="{{ asset('LOGO.png') }}" alt="Rubiknows Logo" class="h-7 w-auto object-contain transition-all duration-500 group-hover:scale-105">
                        <div class="absolute -inset-1 bg-brand-500/20 rounded-full blur-lg opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    </div>
                    <div class="font-sans text-xl tracking-wide">
                        <span class="text-white font-light">RUBI</span><span class="text-[#E07B2A] font-bold">KNOWS</span>
                    </div>
                </a>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 px-3 py-6 space-y-6 overflow-y-auto scrollbar-thin">
                <!-- Overview Section -->
                <div>
                    <div class="flex items-center justify-between px-4 mb-3">
                        <h3 class="text-[10px] font-semibold text-gray-600 uppercase tracking-[0.2em]">Overview</h3>
                        <div class="w-6 h-px bg-white/5"></div>
                    </div>
                    <a href="{{ route('dashboard') }}" class="nav-active-indicator group flex items-center px-4 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-brand-500/10 text-white' : 'text-gray-400 hover:bg-white/[0.04] hover:text-white' }}">
                        <svg class="w-5 h-5 mr-3 flex-shrink-0 {{ request()->routeIs('dashboard') ? 'text-brand-500' : 'text-gray-500 group-hover:text-white' }} transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                        </svg>
                        <span>Dashboard</span>
                        @if(request()->routeIs('dashboard'))
                            <span class="ml-auto w-1.5 h-1.5 rounded-full bg-brand-500"></span>
                        @endif
                    </a>
                </div>

                <!-- Website Content Section -->
                <div>
                    <div class="flex items-center justify-between px-4 mb-3">
                        <h3 class="text-[10px] font-semibold text-gray-600 uppercase tracking-[0.2em]">Website Content</h3>
                        <div class="w-6 h-px bg-white/5"></div>
                    </div>

                    <a href="{{ route('admin.projects.index') }}" class="group flex items-center px-4 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('admin.projects.*') ? 'bg-brand-500/10 text-white' : 'text-gray-400 hover:bg-white/[0.04] hover:text-white' }}">
                        <svg class="w-5 h-5 mr-3 flex-shrink-0 {{ request()->routeIs('admin.projects.*') ? 'text-brand-500' : 'text-gray-500 group-hover:text-white' }} transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                        <span>Project Portfolio</span>
                        @if(request()->routeIs('admin.projects.*'))
                            <span class="ml-auto w-1.5 h-1.5 rounded-full bg-brand-500"></span>
                        @endif
                    </a>

                    <a href="{{ route('admin.gallery.index') }}" class="group flex items-center px-4 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 mt-0.5 {{ request()->routeIs('admin.gallery.*') ? 'bg-brand-500/10 text-white' : 'text-gray-400 hover:bg-white/[0.04] hover:text-white' }}">
                        <svg class="w-5 h-5 mr-3 flex-shrink-0 {{ request()->routeIs('admin.gallery.*') ? 'text-brand-500' : 'text-gray-500 group-hover:text-white' }} transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <span>Media Gallery</span>
                        @if(request()->routeIs('admin.gallery.*'))
                            <span class="ml-auto w-1.5 h-1.5 rounded-full bg-brand-500"></span>
                        @endif
                    </a>

                    <a href="{{ route('admin.services.index') }}" class="group flex items-center px-4 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 mt-0.5 {{ request()->routeIs('admin.services.*') ? 'bg-brand-500/10 text-white' : 'text-gray-400 hover:bg-white/[0.04] hover:text-white' }}">
                        <svg class="w-5 h-5 mr-3 flex-shrink-0 {{ request()->routeIs('admin.services.*') ? 'text-brand-500' : 'text-gray-500 group-hover:text-white' }} transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <span>Services</span>
                        @if(request()->routeIs('admin.services.*'))
                            <span class="ml-auto w-1.5 h-1.5 rounded-full bg-brand-500"></span>
                        @endif
                    </a>

                    <a href="{{ route('admin.clients.index') }}" class="group flex items-center px-4 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 mt-0.5 {{ request()->routeIs('admin.clients.*') ? 'bg-brand-500/10 text-white' : 'text-gray-400 hover:bg-white/[0.04] hover:text-white' }}">
                        <svg class="w-5 h-5 mr-3 flex-shrink-0 {{ request()->routeIs('admin.clients.*') ? 'text-brand-500' : 'text-gray-500 group-hover:text-white' }} transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        <span>Clients & Partners</span>
                        @if(request()->routeIs('admin.clients.*'))
                            <span class="ml-auto w-1.5 h-1.5 rounded-full bg-brand-500"></span>
                        @endif
                    </a>

                    <a href="{{ route('admin.testimonials.index') }}" class="group flex items-center px-4 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 mt-0.5 {{ request()->routeIs('admin.testimonials.*') ? 'bg-brand-500/10 text-white' : 'text-gray-400 hover:bg-white/[0.04] hover:text-white' }}">
                        <svg class="w-5 h-5 mr-3 flex-shrink-0 {{ request()->routeIs('admin.testimonials.*') ? 'text-brand-500' : 'text-gray-500 group-hover:text-white' }} transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                        <span>Testimonials</span>
                        @if(request()->routeIs('admin.testimonials.*'))
                            <span class="ml-auto w-1.5 h-1.5 rounded-full bg-brand-500"></span>
                        @endif
                    </a>
                </div>

                <!-- Communications Section -->
                <div>
                    <div class="flex items-center justify-between px-4 mb-3">
                        <h3 class="text-[10px] font-semibold text-gray-600 uppercase tracking-[0.2em]">Communications</h3>
                        <div class="w-6 h-px bg-white/5"></div>
                    </div>

                    <a href="{{ route('admin.messages.index') }}" class="group flex items-center px-4 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('admin.messages.*') ? 'bg-brand-500/10 text-white' : 'text-gray-400 hover:bg-white/[0.04] hover:text-white' }}">
                        <svg class="w-5 h-5 mr-3 flex-shrink-0 {{ request()->routeIs('admin.messages.*') ? 'text-brand-500' : 'text-gray-500 group-hover:text-white' }} transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <span>Inbox (Contact Us)</span>
                        @php $unreadMsgs = \App\Models\ContactMessage::where('status', 'New')->count(); @endphp
                        @if($unreadMsgs > 0)
                            <span class="ml-auto bg-brand-500 text-white py-0.5 px-2 rounded-full text-[10px] font-semibold min-w-[20px] text-center">{{ $unreadMsgs }}</span>
                        @endif
                        @if(request()->routeIs('admin.messages.*'))
                            <span class="ml-auto w-1.5 h-1.5 rounded-full bg-brand-500"></span>
                        @endif
                    </a>

                    <a href="{{ route('admin.quotations.index') }}" class="group flex items-center px-4 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 mt-0.5 {{ request()->routeIs('admin.quotations.*') ? 'bg-brand-500/10 text-white' : 'text-gray-400 hover:bg-white/[0.04] hover:text-white' }}">
                        <svg class="w-5 h-5 mr-3 flex-shrink-0 {{ request()->routeIs('admin.quotations.*') ? 'text-brand-500' : 'text-gray-500 group-hover:text-white' }} transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <span>Quotation Requests</span>
                        @php $pendingQuotes = \App\Models\QuotationRequest::where('status', 'Pending')->count(); @endphp
                        @if($pendingQuotes > 0)
                            <span class="ml-auto bg-blue-500 text-white py-0.5 px-2 rounded-full text-[10px] font-semibold min-w-[20px] text-center">{{ $pendingQuotes }}</span>
                        @endif
                        @if(request()->routeIs('admin.quotations.*'))
                            <span class="ml-auto w-1.5 h-1.5 rounded-full bg-brand-500"></span>
                        @endif
                    </a>
                </div>

                <!-- Human Resources Section -->
                <div>
                    <div class="flex items-center justify-between px-4 mb-3">
                        <h3 class="text-[10px] font-semibold text-gray-600 uppercase tracking-[0.2em]">Human Resources</h3>
                        <div class="w-6 h-px bg-white/5"></div>
                    </div>

                    <a href="{{ route('admin.jobs.index') }}" class="group flex items-center px-4 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('admin.jobs.*') ? 'bg-brand-500/10 text-white' : 'text-gray-400 hover:bg-white/[0.04] hover:text-white' }}">
                        <svg class="w-5 h-5 mr-3 flex-shrink-0 {{ request()->routeIs('admin.jobs.*') ? 'text-brand-500' : 'text-gray-500 group-hover:text-white' }} transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <span>Job Postings</span>
                        @if(request()->routeIs('admin.jobs.*'))
                            <span class="ml-auto w-1.5 h-1.5 rounded-full bg-brand-500"></span>
                        @endif
                    </a>

                    <a href="{{ route('admin.applications.index') }}" class="group flex items-center px-4 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 mt-0.5 {{ request()->routeIs('admin.applications.*') ? 'bg-brand-500/10 text-white' : 'text-gray-400 hover:bg-white/[0.04] hover:text-white' }}">
                        <svg class="w-5 h-5 mr-3 flex-shrink-0 {{ request()->routeIs('admin.applications.*') ? 'text-brand-500' : 'text-gray-500 group-hover:text-white' }} transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                        <span>Applicants</span>
                        @php $newApps = \App\Models\JobApplication::where('status', 'Received')->count(); @endphp
                        @if($newApps > 0)
                            <span class="ml-auto bg-green-500 text-white py-0.5 px-2 rounded-full text-[10px] font-semibold min-w-[20px] text-center">{{ $newApps }}</span>
                        @endif
                        @if(request()->routeIs('admin.applications.*'))
                            <span class="ml-auto w-1.5 h-1.5 rounded-full bg-brand-500"></span>
                        @endif
                    </a>
                </div>

                <!-- System Settings Section -->
                <div>
                    <div class="flex items-center justify-between px-4 mb-3">
                        <h3 class="text-[10px] font-semibold text-gray-600 uppercase tracking-[0.2em]">System</h3>
                        <div class="w-6 h-px bg-white/5"></div>
                    </div>
                    @if(Auth::user()->role === 'Super Admin')
                        <a href="{{ route('admin.users.index') }}" class="group flex items-center px-4 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 mb-0.5 {{ request()->routeIs('admin.users.*') ? 'bg-brand-500/10 text-white' : 'text-gray-400 hover:bg-white/[0.04] hover:text-white' }}">
                            <svg class="w-5 h-5 mr-3 flex-shrink-0 {{ request()->routeIs('admin.users.*') ? 'text-brand-500' : 'text-gray-500 group-hover:text-white' }} transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                            <span>User Management</span>
                            @if(request()->routeIs('admin.users.*'))
                                <span class="ml-auto w-1.5 h-1.5 rounded-full bg-brand-500"></span>
                            @endif
                        </a>
                    @endif
                    <a href="{{ route('admin.settings.index') }}" class="group flex items-center px-4 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('admin.settings.*') ? 'bg-brand-500/10 text-white' : 'text-gray-400 hover:bg-white/[0.04] hover:text-white' }}">
                        <svg class="w-5 h-5 mr-3 flex-shrink-0 {{ request()->routeIs('admin.settings.*') ? 'text-brand-500' : 'text-gray-500 group-hover:text-white' }} transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span>Global Settings</span>
                        @if(request()->routeIs('admin.settings.*'))
                            <span class="ml-auto w-1.5 h-1.5 rounded-full bg-brand-500"></span>
                        @endif
                    </a>
                </div>
            </nav>

            <!-- User Info (Bottom Sidebar) -->
            <div class="relative z-10 p-4 border-t border-white/[0.04] bg-gradient-to-t from-black/40 to-transparent">
                <a href="{{ route('profile.edit') }}" class="flex items-center hover:bg-white/[0.04] p-2 rounded-lg transition-all duration-200 group">
                    <div class="w-8 h-8 rounded-full overflow-hidden bg-white/[0.06] border border-white/[0.08] flex items-center justify-center flex-shrink-0 ring-2 ring-transparent group-hover:ring-brand-500/30 transition-all duration-300">
                        @if(Auth::user()->profile_photo_url)
                            <img src="{{ Storage::url(Auth::user()->profile_photo_url) }}" alt="{{ Auth::user()->name }}" class="h-full w-full object-cover">
                        @else
                            <span class="text-white font-bold text-sm">{{ substr(Auth::user()->name, 0, 1) }}</span>
                        @endif
                    </div>
                    <div class="ml-3 truncate">
                        <p class="text-sm font-medium text-white group-hover:text-brand-500 transition-colors">{{ Auth::user()->name }}</p>
                        <p class="text-[11px] text-gray-500 truncate">{{ Auth::user()->email }}</p>
                    </div>
                </a>
                <form method="POST" action="{{ route('logout') }}" class="mt-3">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2 text-xs font-medium rounded-lg text-gray-500 hover:text-white hover:bg-white/[0.04] transition-all duration-200">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                        Sign Out
                    </button>
                </form>
            </div>
        </aside>

        <!-- ===== MAIN CONTENT ===== -->
        <main class="flex-1 flex flex-col h-screen overflow-hidden">

            <!-- Top Navbar -->
            <header class="h-20 bg-white border-b border-gray-200/60 flex items-center justify-between px-6 lg:px-8 z-10 flex-shrink-0">
                <div class="flex items-center flex-1 min-w-0">
                    <button class="md:hidden text-gray-400 hover:text-gray-600 mr-2 p-2 rounded-lg hover:bg-gray-100 transition-colors focus:outline-none focus:ring-2 focus:ring-brand-500/50">
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
                    <button @click="open = !open" @click.outside="open = false" class="p-2.5 rounded-xl text-gray-400 hover:text-brand-500 hover:bg-brand-50 transition-all relative focus:outline-none" title="Notifications">
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
                         class="absolute right-0 mt-2 w-[22rem] bg-white rounded-2xl shadow-xl border border-gray-100 py-2 z-50 text-gray-800"
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
            <div class="flex-1 overflow-y-auto bg-[#f8f9fc]">
                <!-- Subtle top gradient -->
                <div class="h-px bg-gradient-to-r from-transparent via-brand-500/20 to-transparent"></div>

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
                 class="relative w-full max-w-md bg-white rounded-2xl shadow-2xl overflow-hidden"
                 style="transform:scale(0.92);opacity:0;transition:transform 0.22s cubic-bezier(.34,1.56,.64,1),opacity 0.18s ease;">
                <!-- Top accent bar -->
                <div class="h-1 w-full bg-gradient-to-r from-orange-500 via-amber-400 to-orange-600"></div>
                <div class="px-7 pt-7 pb-6">
                    <!-- Icon -->
                    <div class="flex items-center gap-4 mb-5">
                        <div class="flex-shrink-0 w-11 h-11 rounded-xl bg-orange-50 border border-orange-100 flex items-center justify-center">
                            <svg class="w-5 h-5 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-orange-500 mb-0.5">Confirm Action</p>
                            <h3 id="rk-confirm-title" class="text-base font-bold text-gray-900 leading-snug">Are you sure?</h3>
                        </div>
                    </div>
                    <p id="rk-confirm-message" class="text-sm text-gray-500 leading-relaxed mb-7"></p>
                    <div class="flex items-center gap-3 justify-end">
                        <button id="rk-confirm-cancel"
                                class="px-5 py-2.5 rounded-xl border border-gray-200 bg-white text-sm font-semibold text-gray-600 hover:bg-gray-50 hover:border-gray-300 transition-all duration-200">
                            Cancel
                        </button>
                        <button id="rk-confirm-ok"
                                class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-orange-500 to-amber-500 text-white text-sm font-bold shadow-lg shadow-orange-200 hover:from-orange-600 hover:to-amber-600 hover:shadow-orange-300 transition-all duration-200">
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
                    success : { icon: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>', bar: '#f97316', iconColor: '#f97316', bg: '#fff' },
                    error   : { icon: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>', bar: '#ef4444', iconColor: '#ef4444', bg: '#fff' },
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