<?php

namespace App\Http\Controllers;

use App\Models\SchoolEvent;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    // === SESUAIKAN dengan nama kolom di migrasi kamu ===
    private const TASK_DATE_COLUMN  = 'deadline';    // kolom tanggal di tabel tasks
    private const EVENT_DATE_COLUMN = 'event_date';  // kolom tanggal di tabel school_events

    /**
     * GET /api/calendar/month?month=YYYY-MM
     * Mengembalikan tugas + acara bulan tersebut, dikelompokkan per tanggal.
     */
    public function month(Request $request): JsonResponse
    {
        $request->validate([
            'month' => ['nullable', 'date_format:Y-m'],
        ]);

        $month = Carbon::createFromFormat('Y-m-d', ($request->query('month') ?? now()->format('Y-m')) . '-01');
        $start = $month->copy()->startOfMonth()->toDateString();
        $end   = $month->copy()->endOfMonth()->toDateString();

        $tasks = Task::whereDate(self::TASK_DATE_COLUMN, '>=', $start)
            ->whereDate(self::TASK_DATE_COLUMN, '<=', $end)
            ->get()
            ->map(fn ($task) => [
                'id'    => $task->id,
                'type'  => 'task',
                'title' => $task->title,
                'date'  => Carbon::parse($task->{self::TASK_DATE_COLUMN})->toDateString(),
            ]);

        $events = SchoolEvent::whereDate(self::EVENT_DATE_COLUMN, '>=', $start)
            ->whereDate(self::EVENT_DATE_COLUMN, '<=', $end)
            ->get()
            ->map(fn ($event) => [
                'id'    => $event->id,
                'type'  => 'event',
                'title' => $event->title,
                'date'  => Carbon::parse($event->{self::EVENT_DATE_COLUMN})->toDateString(),
            ]);

        $agenda = $tasks->concat($events)
            ->sortBy('date')
            ->groupBy('date')
            ->map(fn ($items) => $items->values());

        return response()->json([
            'month'  => $month->format('Y-m'),
            'agenda' => $agenda,
        ]);
    }
}