<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="flex items-center gap-2">
                <span class="w-1.5 h-1.5 rounded-full bg-brand-500 animate-pulse-soft"></span>
                <h2 class="font-semibold text-xl text-gray-900 leading-tight tracking-tight">
                    {{ __('Dashboard Overview') }}
                </h2>
            </div>
            <span class="hidden sm:inline-flex text-[10px] font-mono text-gray-400 bg-gray-100 px-2 py-0.5 rounded-full border border-gray-200/60">
                {{ date('l, F j, Y') }}
            </span>
        </div>
    </x-slot>

    <!-- Welcome Section -->
    <div class="mb-8 relative overflow-hidden rounded-2xl">
        <div class="absolute inset-0 bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900"></div>
        <div class="absolute inset-0 bg-grid-pattern-dark-fine opacity-20"></div>
        <!-- Decorative gradient orbs -->
        <div class="absolute -right-16 -top-16 w-72 h-72 bg-brand-500/20 rounded-full blur-[100px]"></div>
        <div class="absolute -left-8 -bottom-8 w-48 h-48 bg-brand-500/10 rounded-full blur-[80px]"></div>
        
        <div class="relative z-10 p-8 sm:p-10">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6">
                <div class="space-y-2">
                    <div class="flex items-center gap-3">
                        <h3 class="text-2xl sm:text-3xl font-bold font-['Roboto_Slab'] tracking-tight text-white">
                            Welcome back, {{ Auth::user()->name }}
                        </h3>
                        <span class="hidden sm:inline-flex text-lg">👋</span>
                    </div>
                    <p class="text-gray-400 max-w-xl text-sm leading-relaxed">
                        Here's what's happening with your projects and website content today. 
                        <span class="text-gray-500">Stay on top of your engineering portfolio.</span>
                    </p>
                    <div class="flex items-center gap-4 pt-1">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-green-500/10 text-green-400 border border-green-500/20 rounded-full text-xs font-medium">
                            <span class="w-1.5 h-1.5 bg-green-500 rounded-full animate-pulse"></span>
                            System Online
                        </span>
                        <span class="text-xs text-gray-600 font-mono">
                            v2.0
                        </span>
                    </div>
                </div>
                <div class="flex-shrink-0 flex items-center gap-3">
                    <a href="{{ route('admin.projects.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-brand-500 hover:bg-brand-600 text-white text-xs font-medium rounded-lg transition-all duration-200 shadow-lg shadow-brand-500/20 hover:shadow-brand-500/30">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        New Project
                    </a>
                    <a href="{{ url('/') }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2.5 bg-white/5 hover:bg-white/10 text-gray-300 hover:text-white text-sm font-medium rounded-xl border border-white/10 transition-all duration-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                        View Site
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8 stagger-children">
        @php
            $totalProjects = \App\Models\Project::count();
            $lastMonthProjects = \App\Models\Project::where('created_at', '<', now()->startOfMonth())->count();
            $thisMonthProjects = \App\Models\Project::where('created_at', '>=', now()->startOfMonth())->count();
            if ($totalProjects === 0) {
                $projectTrend = null;
                $projectTrendLabel = 'No projects yet';
            } elseif ($lastMonthProjects === 0) {
                $projectTrend = null;
                $projectTrendLabel = $thisMonthProjects > 0 ? $thisMonthProjects . ' added this month' : 'No change';
            } else {
                $pctChange = round((($totalProjects - $lastMonthProjects) / $lastMonthProjects) * 100);
                $projectTrend = ($pctChange >= 0 ? '+' : '') . $pctChange . '%';
                $projectTrendLabel = 'from last month';
            }
            $stats = [
                [
                    'label' => 'Total Projects',
                    'value' => $totalProjects,
                    'icon' => 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10',
                    'color' => 'brand',
                    'trend' => $projectTrend,
                    'trendLabel' => $projectTrendLabel,
                    'sparkline' => true,
                ],
                [
                    'label' => 'Active Services',
                    'value' => \App\Models\Service::count(),
                    'icon' => 'M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z',
                    'color' => 'blue',
                    'trend' => 'All active',
                    'trendLabel' => 'operational',
                    'sparkline' => false,
                ],
                [
                    'label' => 'Contact Messages',
                    'value' => \App\Models\ContactMessage::where('status', 'New')->count(),
                    'icon' => 'M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z',
                    'color' => 'purple',
                    'trend' => 'Unread',
                    'trendLabel' => 'awaiting response',
                    'sparkline' => true,
                ],
                [
                    'label' => 'Job Applicants',
                    'value' => \App\Models\JobApplication::where('status', 'Received')->count(),
                    'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z',
                    'color' => 'green',
                    'trend' => 'Received',
                    'trendLabel' => 'next hiring Q3',
                    'sparkline' => false,
                ],
            ];
        @endphp

        @foreach($stats as $stat)
            @php
                $colorMap = [
                    'brand' => ['bg' => 'bg-brand-50', 'text' => 'text-brand-600', 'hover' => 'hover:bg-brand-600', 'iconHover' => 'group-hover:bg-brand-600'],
                    'blue' => ['bg' => 'bg-blue-50', 'text' => 'text-blue-600', 'hover' => 'hover:bg-blue-600', 'iconHover' => 'group-hover:bg-blue-600'],
                    'purple' => ['bg' => 'bg-purple-50', 'text' => 'text-purple-600', 'hover' => 'hover:bg-purple-600', 'iconHover' => 'group-hover:bg-purple-600'],
                    'green' => ['bg' => 'bg-green-50', 'text' => 'text-green-600', 'hover' => 'hover:bg-green-600', 'iconHover' => 'group-hover:bg-green-600'],
                ];
                $colors = $colorMap[$stat['color']] ?? $colorMap['brand'];
            @endphp
            <div class="bg-white rounded-xl border border-gray-100 p-5 transition-all duration-300 hover:shadow-lg hover:-translate-y-0.5 hover:border-gray-200 group animate-slide-up">
                <div class="flex items-start justify-between mb-3">
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ $stat['label'] }}</p>
                        <p class="text-2xl font-bold text-gray-900 mt-1.5 font-['Roboto_Slab']">{{ $stat['value'] }}</p>
                    </div>
                    <div class="w-11 h-11 rounded-xl {{ $colors['bg'] }} flex items-center justify-center {{ $colors['text'] }} {{ $colors['iconHover'] }} group-hover:text-white transition-all duration-300 flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $stat['icon'] }}"></path>
                        </svg>
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-1.5 text-xs">
                        @if($stat['trend'] && Str::contains($stat['trend'], '%'))
                            <span class="font-medium text-green-600 flex items-center gap-0.5">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                                {{ $stat['trend'] }}
                            </span>
                        @elseif($stat['trend'])
                            <span class="font-medium text-gray-600">{{ $stat['trend'] }}</span>
                        @endif
                        <span class="text-gray-400">{{ $stat['trendLabel'] }}</span>
                    </div>
                    @if($stat['sparkline'])
                        <div class="sparkline text-brand-500 group-hover:opacity-100 opacity-60 transition-opacity">
                            <div class="bar"></div>
                            <div class="bar"></div>
                            <div class="bar"></div>
                            <div class="bar"></div>
                            <div class="bar"></div>
                            <div class="bar"></div>
                            <div class="bar"></div>
                            <div class="bar"></div>
                            <div class="bar"></div>
                            <div class="bar"></div>
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    <!-- Recent Activity & Quick Actions -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Recent Projects (2/3 width) -->
        <div class="lg:col-span-2 bg-white rounded-xl border border-gray-100 overflow-hidden shadow-sm">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-gray-50/80">
                <div class="flex items-center gap-3">
                    <span class="w-2 h-2 rounded-full bg-brand-500"></span>
                    <h3 class="font-semibold text-gray-900 text-sm">Recent Projects</h3>
                    @php $projectCount = \App\Models\Project::count(); @endphp
                    <span class="text-[11px] font-mono text-gray-400 bg-gray-100 px-1.5 py-0.5 rounded">{{ $projectCount }} total</span>
                </div>
                <a href="{{ route('admin.projects.index') }}" class="inline-flex items-center gap-1.5 text-xs font-medium text-brand-600 hover:text-brand-700 transition-colors group">
                    View All
                    <svg class="w-3.5 h-3.5 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </a>
            </div>
            <div class="divide-y divide-gray-50">
                @forelse(\App\Models\Project::latest()->take(5)->get() as $project)
                    <div class="px-6 py-3.5 hover:bg-gray-50/80 transition-colors flex items-center justify-between group/item">
                        <div class="flex items-center gap-4 min-w-0 flex-1">
                            <div class="flex-shrink-0 w-9 h-9 bg-gray-100 rounded-lg flex items-center justify-center text-gray-400 group-hover/item:bg-brand-50 group-hover/item:text-brand-500 transition-all">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                            </div>
                            <div class="min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">{{ $project->title }}</p>
                                <p class="text-xs text-gray-500 truncate">{{ $project->client ?? 'Internal Project' }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 flex-shrink-0 ml-4">
                            <span class="px-2.5 py-1 text-[11px] font-medium rounded-full border 
                                {{ ($project->status ?? 'Draft') === 'Published' ? 'bg-green-50 text-green-700 border-green-200' : 'bg-yellow-50 text-yellow-700 border-yellow-200' }}">
                                {{ $project->status ?? 'Draft' }}
                            </span>
                            <span class="text-[11px] text-gray-400 font-mono hidden sm:inline">{{ $project->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                @empty
                    <div class="px-6 py-10 text-center">
                        <div class="w-14 h-14 mx-auto bg-gray-50 rounded-2xl flex items-center justify-center mb-4">
                            <svg class="w-7 h-7 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        </div>
                        <p class="text-sm font-medium text-gray-900 mb-1">No projects yet</p>
                        <p class="text-xs text-gray-500 mb-4">Let's build something great! Create your first project.</p>
                        <a href="{{ route('admin.projects.create') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-brand-500 text-white text-xs font-medium rounded-lg hover:bg-brand-600 transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Create Project
                        </a>
                    </div>
                @endforelse
            </div>
            @if(\App\Models\Project::count() > 0)
                <div class="px-6 py-3 bg-gray-50/50 border-t border-gray-50 flex items-center justify-between">
                    <span class="text-[11px] text-gray-400">
                        Showing recent {{ min(5, \App\Models\Project::count()) }} of {{ \App\Models\Project::count() }} projects
                    </span>
                    <a href="{{ route('admin.projects.index') }}" class="text-[11px] font-medium text-brand-600 hover:text-brand-700 transition-colors">
                        Manage Projects &rarr;
                    </a>
                </div>
            @endif
        </div>

        <!-- Quick Actions & Insights (1/3 width) -->
        <div class="flex flex-col gap-5">
            <!-- Quick Actions Card -->
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-100 flex items-center gap-2.5">
                    <span class="w-1.5 h-1.5 rounded-full bg-brand-400"></span>
                    <h3 class="font-semibold text-gray-900 text-sm">Quick Actions</h3>
                </div>
                <div class="p-4 space-y-2.5">
                    <a href="{{ route('admin.projects.create') }}" class="group flex items-center gap-3.5 p-3 rounded-xl border border-gray-100 hover:border-brand-200 hover:bg-brand-50/40 transition-all duration-200">
                        <div class="flex-shrink-0 w-9 h-9 bg-brand-100 text-brand-600 rounded-lg flex items-center justify-center group-hover:scale-110 group-hover:bg-brand-500 group-hover:text-white transition-all duration-200">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        </div>
                        <div class="min-w-0">
                            <p class="text-sm font-medium text-gray-900 group-hover:text-brand-600 transition-colors">Add New Project</p>
                            <p class="text-xs text-gray-400">Create a new portfolio entry</p>
                        </div>
                    </a>

                    <a href="{{ route('admin.services.create') }}" class="group flex items-center gap-3.5 p-3 rounded-xl border border-gray-100 hover:border-blue-200 hover:bg-blue-50/40 transition-all duration-200">
                        <div class="flex-shrink-0 w-9 h-9 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center group-hover:scale-110 group-hover:bg-blue-500 group-hover:text-white transition-all duration-200">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        </div>
                        <div class="min-w-0">
                            <p class="text-sm font-medium text-gray-900 group-hover:text-blue-600 transition-colors">Add New Service</p>
                            <p class="text-xs text-gray-400">Expand your company offerings</p>
                        </div>
                    </a>

                    <a href="{{ route('admin.messages.index') }}" class="group flex items-center gap-3.5 p-3 rounded-xl border border-gray-100 hover:border-purple-200 hover:bg-purple-50/40 transition-all duration-200">
                        <div class="flex-shrink-0 w-9 h-9 bg-purple-100 text-purple-600 rounded-lg flex items-center justify-center group-hover:scale-110 group-hover:bg-purple-500 group-hover:text-white transition-all duration-200">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                        </div>
                        <div class="min-w-0">
                            <p class="text-sm font-medium text-gray-900 group-hover:text-purple-600 transition-colors">View Messages</p>
                            <p class="text-xs text-gray-400">Check contact inquiries</p>
                        </div>
                    </a>

                    <a href="{{ route('admin.quotations.index') }}" class="group flex items-center gap-3.5 p-3 rounded-xl border border-gray-100 hover:border-amber-200 hover:bg-amber-50/40 transition-all duration-200">
                        <div class="flex-shrink-0 w-9 h-9 bg-amber-100 text-amber-600 rounded-lg flex items-center justify-center group-hover:scale-110 group-hover:bg-amber-500 group-hover:text-white transition-all duration-200">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                        <div class="min-w-0">
                            <p class="text-sm font-medium text-gray-900 group-hover:text-amber-600 transition-colors">Quotation Requests</p>
                            <p class="text-xs text-gray-400">Review pending quotes</p>
                        </div>
                    </a>
                </div>
            </div>

            <!-- System Status Card -->
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-100 flex items-center gap-2.5">
                    <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                    <h3 class="font-semibold text-gray-900 text-sm">System Status</h3>
                </div>
                <div class="p-4 space-y-3">
                    <div class="flex items-center justify-between py-2">
                        <span class="text-sm text-gray-600">Application</span>
                        <span class="inline-flex items-center gap-1.5 text-xs font-medium text-green-700 bg-green-50 px-2.5 py-1 rounded-full">
                            <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span>
                            Operational
                        </span>
                    </div>
                    <div class="flex items-center justify-between py-2 border-t border-gray-50">
                        <span class="text-sm text-gray-600">Database</span>
                        <span class="inline-flex items-center gap-1.5 text-xs font-medium text-green-700 bg-green-50 px-2.5 py-1 rounded-full">
                            <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span>
                            Connected
                        </span>
                    </div>
                    <div class="flex items-center justify-between py-2 border-t border-gray-50">
                        <span class="text-sm text-gray-600">Storage</span>
                        <span class="inline-flex items-center gap-1.5 text-xs font-medium text-green-700 bg-green-50 px-2.5 py-1 rounded-full">
                            <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span>
                            Available
                        </span>
                    </div>
                    <div class="flex items-center justify-between py-2 border-t border-gray-50">
                        <span class="text-sm text-gray-600">Last Backup</span>
                        <span class="text-xs font-mono text-gray-500">Today, 02:00 AM</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom Section: Services & Clients preview -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
        <!-- Services Summary -->
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-gray-50/80">
                <div class="flex items-center gap-3">
                    <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                    <h3 class="font-semibold text-gray-900 text-sm">Services</h3>
                    @php $serviceCount = \App\Models\Service::count(); @endphp
                    <span class="text-[11px] font-mono text-gray-400 bg-gray-100 px-1.5 py-0.5 rounded">{{ $serviceCount }} active</span>
                </div>
                <a href="{{ route('admin.services.index') }}" class="text-xs font-medium text-brand-600 hover:text-brand-700 transition-colors">
                    Manage &rarr;
                </a>
            </div>
            <div class="divide-y divide-gray-50">
                @forelse(\App\Models\Service::latest()->take(4)->get() as $service)
                    <div class="px-6 py-3.5 hover:bg-gray-50/80 transition-colors flex items-center justify-between">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="flex-shrink-0 w-8 h-8 bg-blue-50 rounded-lg flex items-center justify-center text-blue-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            </div>
                            <p class="text-sm font-medium text-gray-900 truncate">{{ $service->title }}</p>
                        </div>
                        <span class="text-[11px] text-gray-400">{{ $service->created_at->diffForHumans() }}</span>
                    </div>
                @empty
                    <div class="px-6 py-8 text-center">
                        <p class="text-sm text-gray-400">No services added yet.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Clients Summary -->
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-gray-50/80">
                <div class="flex items-center gap-3">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    <h3 class="font-semibold text-gray-900 text-sm">Clients & Partners</h3>
                    @php $clientCount = \App\Models\Client::count(); @endphp
                    <span class="text-[11px] font-mono text-gray-400 bg-gray-100 px-1.5 py-0.5 rounded">{{ $clientCount }} partners</span>
                </div>
                <a href="{{ route('admin.clients.index') }}" class="text-xs font-medium text-brand-600 hover:text-brand-700 transition-colors">
                    Manage &rarr;
                </a>
            </div>
            <div class="divide-y divide-gray-50">
                @forelse(\App\Models\Client::latest()->take(4)->get() as $client)
                    <div class="px-6 py-3.5 hover:bg-gray-50/80 transition-colors flex items-center justify-between">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="flex-shrink-0 w-8 h-8 bg-emerald-50 rounded-lg flex items-center justify-center text-emerald-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            </div>
                            <p class="text-sm font-medium text-gray-900 truncate">{{ $client->name }}</p>
                        </div>
                        <span class="text-[11px] text-gray-400">{{ $client->created_at->diffForHumans() }}</span>
                    </div>
                @empty
                    <div class="px-6 py-8 text-center">
                        <p class="text-sm text-gray-400">No clients added yet.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>