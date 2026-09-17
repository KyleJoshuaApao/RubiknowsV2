<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Models\Project;
use App\Models\QuotationRequest;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $monthStart = now()->startOfMonth()->subMonths(6);
        $months = collect(range(0, 6))->map(fn (int $offset) => $monthStart->copy()->addMonths($offset));
        $projectCounts = Project::where('created_at', '>=', $monthStart)
            ->get(['created_at'])
            ->groupBy(fn (Project $project) => $project->created_at->format('Y-m'))
            ->map->count();

        $weekStart = now()->startOfWeek();
        $weekEnd = $weekStart->copy()->endOfWeek();
        $days = collect(range(0, 6))->map(fn (int $offset) => $weekStart->copy()->addDays($offset));
        $messages = ContactMessage::whereBetween('created_at', [$weekStart, $weekEnd])
            ->get(['created_at'])
            ->groupBy(fn (ContactMessage $message) => $message->created_at->format('Y-m-d'))
            ->map->count();
        $quotations = QuotationRequest::whereBetween('created_at', [$weekStart, $weekEnd])
            ->get(['created_at'])
            ->groupBy(fn (QuotationRequest $quotation) => $quotation->created_at->format('Y-m-d'))
            ->map->count();

        return view('dashboard', [
            'projectActivity' => [
                'labels' => $months->map(fn ($month) => $month->format('M'))->all(),
                'data' => $months->map(fn ($month) => $projectCounts->get($month->format('Y-m'), 0))->all(),
            ],
            'inquiriesOverview' => [
                'labels' => $days->map(fn ($day) => $day->format('D'))->all(),
                'messages' => $days->map(fn ($day) => $messages->get($day->format('Y-m-d'), 0))->all(),
                'quotations' => $days->map(fn ($day) => $quotations->get($day->format('Y-m-d'), 0))->all(),
            ],
        ]);
    }
}
