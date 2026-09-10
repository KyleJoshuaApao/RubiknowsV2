<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-black uppercase tracking-tighter text-3xl text-richblack-900 leading-tight">
                {{ __('Dashboard') }}
            </h2>
            <span class="hidden sm:inline-flex text-xs font-bold uppercase tracking-widest text-brand-500 bg-brand-50 px-3 py-1 border border-brand-200">
                {{ date('l, F j, Y') }}
            </span>
        </div>
    </x-slot>

    <!-- Welcome Section -->
    <div class="mb-10 relative overflow-hidden border-l-4 border-brand-500 bg-white shadow-[0_4px_20px_rgba(0,0,0,0.03)]">
        <div class="relative z-10 p-8 sm:p-12">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6">
                <div class="space-y-3">
                    <h3 class="text-3xl sm:text-5xl font-black text-richblack-900 tracking-tight">
                        Welcome, {{ Auth::user()->name }}
                    </h3>
                    <p class="text-gray-500 max-w-xl text-lg font-medium leading-relaxed">
                        Overview of your current projects and firm inquiries.
                    </p>
                </div>
                <div class="flex-shrink-0 flex items-center gap-4">
                    <a href="{{ route('admin.projects.create') }}" class="px-6 py-3 bg-brand-500 hover:bg-brand-600 text-white font-bold uppercase tracking-widest text-xs transition-colors">
                        + New Project
                    </a>
                    <a href="{{ url('/') }}" target="_blank" class="px-6 py-3 bg-richblack-950 hover:bg-richblack-900 text-white font-bold uppercase tracking-widest text-xs transition-colors">
                        View Live Site
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
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
                    'color' => 'border-brand-500',
                    'text' => 'text-brand-500',
                    'trend' => $projectTrend,
                    'trendLabel' => $projectTrendLabel,
                ],
                [
                    'label' => 'Active Services',
                    'value' => \App\Models\Service::count(),
                    'icon' => 'M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z',
                    'color' => 'border-richblack-900',
                    'text' => 'text-richblack-900',
                    'trend' => 'All active',
                    'trendLabel' => 'operational',
                ],
                [
                    'label' => 'Messages',
                    'value' => \App\Models\ContactMessage::where('status', 'New')->count(),
                    'icon' => 'M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z',
                    'color' => 'border-brand-500',
                    'text' => 'text-brand-500',
                    'trend' => 'Unread',
                    'trendLabel' => 'awaiting response',
                ],
                [
                    'label' => 'Applicants',
                    'value' => \App\Models\JobApplication::where('status', 'Received')->count(),
                    'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z',
                    'color' => 'border-richblack-900',
                    'text' => 'text-richblack-900',
                    'trend' => 'Received',
                    'trendLabel' => 'pending review',
                ],
            ];
        @endphp

        @foreach($stats as $stat)
            <div class="bg-white border-t-4 border-b border-x border-gray-200 {{ $stat['color'] }} p-6 hover:shadow-[0_8px_30px_rgba(0,0,0,0.06)] transition-all group">
                <div class="flex items-start justify-between mb-6">
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-[0.2em]">{{ $stat['label'] }}</p>
                        <!-- Alpine Counter -->
                        <p class="text-5xl font-black text-richblack-900 mt-3" x-data="{ count: 0, target: {{ $stat['value'] }} }" x-init="
                            let start = 0;
                            const duration = 1500;
                            const starttime = performance.now();
                            const animate = (time) => {
                                let progress = (time - starttime) / duration;
                                if (progress < 1) {
                                    count = Math.floor(target * progress);
                                    requestAnimationFrame(animate);
                                } else {
                                    count = target;
                                }
                            };
                            requestAnimationFrame(animate);
                        " x-text="count"></p>
                    </div>
                    <div class="w-12 h-12 flex items-center justify-center {{ $stat['text'] }} flex-shrink-0">
                        <svg class="w-8 h-8 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $stat['icon'] }}"></path>
                        </svg>
                    </div>
                </div>
                <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-gray-500">
                    @if($stat['trend'])
                        <span class="{{ $stat['text'] }}">{{ $stat['trend'] }}</span>
                    @endif
                    <span>{{ $stat['trendLabel'] }}</span>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
        <div class="bg-white border border-gray-200 p-8">
            <h3 class="font-black uppercase tracking-widest text-richblack-900 text-sm mb-6 border-b border-gray-200 pb-4">Project Activity</h3>
            <div class="relative h-[300px] w-full">
                <canvas id="activityChart"></canvas>
            </div>
        </div>
        <div class="bg-white border border-gray-200 p-8">
            <h3 class="font-black uppercase tracking-widest text-richblack-900 text-sm mb-6 border-b border-gray-200 pb-4">Inquiries Overview</h3>
            <div class="relative h-[300px] w-full">
                <canvas id="inquiriesChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Recent Activity & Quick Actions -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Recent Projects (2/3 width) -->
        <div class="lg:col-span-2 bg-white border border-gray-200">
            <div class="px-8 py-6 border-b border-gray-200 flex items-center justify-between">
                <h3 class="font-black uppercase tracking-widest text-richblack-900 text-sm">Recent Projects</h3>
                <a href="{{ route('admin.projects.index') }}" class="text-xs font-bold uppercase tracking-widest text-brand-500 hover:text-brand-700 transition-colors">
                    View All &rarr;
                </a>
            </div>
            <div class="divide-y divide-gray-100">
                @forelse(\App\Models\Project::latest()->take(5)->get() as $project)
                    <div class="px-8 py-5 hover:bg-gray-50 transition-colors flex items-center justify-between group">
                        <div class="flex items-center gap-4 min-w-0 flex-1">
                            <div class="min-w-0">
                                <p class="text-base font-bold text-richblack-900 truncate">{{ $project->title }}</p>
                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider truncate mt-1">{{ $project->client ?? 'Internal Project' }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4 flex-shrink-0 ml-4">
                            <span class="px-3 py-1 border border-gray-200 text-[10px] font-bold uppercase tracking-widest text-gray-600">
                                {{ $project->status ?? 'Draft' }}
                            </span>
                            <span class="text-xs font-bold text-gray-400 hidden sm:inline">{{ $project->created_at->format('M d, Y') }}</span>
                        </div>
                    </div>
                @empty
                    <div class="px-8 py-12 text-center">
                        <p class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-4">No projects yet</p>
                        <a href="{{ route('admin.projects.create') }}" class="px-6 py-3 bg-brand-500 hover:bg-brand-600 text-white font-bold uppercase tracking-widest text-xs transition-colors">
                            Create Project
                        </a>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- System Status & Quick Actions -->
        <div class="flex flex-col gap-8">
            <!-- System Status -->
            <div class="bg-white border border-gray-200">
                <div class="px-6 py-5 border-b border-gray-200">
                    <h3 class="font-black uppercase tracking-widest text-richblack-900 text-sm">System Status</h3>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold uppercase tracking-widest text-gray-500">Platform</span>
                        <span class="text-xs font-bold text-green-600">Online</span>
                    </div>
                    <div class="flex items-center justify-between border-t border-gray-100 pt-4">
                        <span class="text-xs font-bold uppercase tracking-widest text-gray-500">Database</span>
                        <span class="text-xs font-bold text-green-600">Connected</span>
                    </div>
                    <div class="flex items-center justify-between border-t border-gray-100 pt-4">
                        <span class="text-xs font-bold uppercase tracking-widest text-gray-500">Storage</span>
                        <span class="text-xs font-bold text-green-600">Available</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart.js Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx1 = document.getElementById('activityChart').getContext('2d');
            new Chart(ctx1, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
                    datasets: [{
                        label: 'Projects Created',
                        data: [0, 0, 0, 0, 0, 0, 0], 
                        borderColor: '#E07B2A',
                        backgroundColor: 'transparent',
                        borderWidth: 3,
                        pointBackgroundColor: '#E07B2A',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        fill: false,
                        tension: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { beginAtZero: true, suggestedMax: 10, grid: { color: '#f3f4f6' }, ticks: { font: { family: 'Inter', weight: 'bold' } } },
                        x: { grid: { display: false }, ticks: { font: { family: 'Inter', weight: 'bold' } } }
                    }
                }
            });

            const ctx2 = document.getElementById('inquiriesChart').getContext('2d');
            new Chart(ctx2, {
                type: 'bar',
                data: {
                    labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                    datasets: [{
                        label: 'Contact Messages',
                        data: [0, 0, 0, 0, 0, 0, 0],
                        backgroundColor: '#0A0A0A',
                        borderRadius: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { beginAtZero: true, suggestedMax: 10, grid: { color: '#f3f4f6' }, ticks: { font: { family: 'Inter', weight: 'bold' } } },
                        x: { grid: { display: false }, ticks: { font: { family: 'Inter', weight: 'bold' } } }
                    }
                }
            });
        });
    </script>
</x-app-layout>
@push('extra-head-scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush
