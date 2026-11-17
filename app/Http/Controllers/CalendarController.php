<?php

namespace App\Http\Controllers;

use App\Models\SchoolEvent;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class CalendarController extends Controller
{
    private const MONTH_NAMES = [
        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
        5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
        9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
    ];

    public function month(Request $request): JsonResponse
    {
        $data = $request->validate([
            'year'  => ['nullable', 'integer', 'between:2000,2100'],
            'month' => ['nullable', 'integer', 'between:1,12'],
        ]);

        $year  = (int) ($data['year'] ?? now()->year);
        $month = (int) ($data['month'] ?? now()->month);

        $start = Carbon::create($year, $month, 1)->startOfDay();
        $range = [$start->toDateString(), $start->copy()->endOfMonth()->toDateString()];

        $items = $this->taskItems($request, $range)
            ->concat($this->eventItems($range));

        $agendas = $items
            ->sortBy(fn ($i) => $i['date'].' '.($i['time'] ?? '00:00'))
            ->groupBy('date')
            ->map(fn ($group) => $group->values());

        return response()->json([
            'year'              => $year,
            'month'             => $month,
            'month_name'        => self::MONTH_NAMES[$month],
            'first_day_of_week' => $start->dayOfWeek, // 0 = Minggu
            'days_in_month'     => $start->daysInMonth,
            'today_date'        => now()->toDateString(),
            'agendas'           => $agendas->isEmpty() ? (object) [] : $agendas,
        ]);
    }

    private function taskItems(Request $request, array $range)
    {
        $table   = (new Task)->getTable();
        $dateCol = $this->kolom($table, ['due_date', 'deadline', 'date', 'tanggal', 'due_at']);

        if (! $dateCol) {
            return collect();
        }

        $query = Task::whereBetween($dateCol, $range);

        if (Schema::hasColumn($table, 'user_id') && $request->user()) {
            $query->where('user_id', $request->user()->id);
        }

        $titleCol = $this->kolom($table, ['title', 'name', 'judul']);
        $typeCol  = $this->kolom($table, ['category', 'type', 'kategori']);
        $doneCol  = $this->kolom($table, ['is_completed', 'completed', 'is_done', 'selesai']);
        $prioCol  = $this->kolom($table, ['priority', 'prioritas']);

        return $query->get()->map(fn ($t) => [
            'id'           => $t->id,
            'source'       => 'task',
            'title'        => $titleCol ? $t->{$titleCol} : '(tanpa judul)',
            'type'         => $typeCol ? $t->{$typeCol} : 'sekolah',
            'priority'     => $prioCol ? $t->{$prioCol} : null,
            'is_completed' => $doneCol ? (bool) $t->{$doneCol} : false,
            'date'         => Carbon::parse($t->{$dateCol})->toDateString(),
            'time'         => null,
        ]);
    }

    private function eventItems(array $range)
    {
        $table   = (new SchoolEvent)->getTable();
        $dateCol = $this->kolom($table, ['event_date', 'date', 'tanggal', 'start_date', 'starts_at']);

        if (! $dateCol) {
            return collect();
        }

        $titleCol = $this->kolom($table, ['title', 'name', 'judul']);
        $typeCol  = $this->kolom($table, ['type', 'category', 'kategori']);

        return SchoolEvent::whereBetween($dateCol, $range)->get()->map(fn ($e) => [
            'id'           => $e->id,
            'source'       => 'event',
            'title'        => $titleCol ? $e->{$titleCol} : '(tanpa judul)',
            'type'         => ($typeCol && in_array($e->{$typeCol}, ['osis', 'council'], true)) ? 'osis' : 'sekolah',
            'priority'     => null,
            'is_completed' => false,
            'date'         => Carbon::parse($e->{$dateCol})->toDateString(),
            'time'         => null,
        ]);
    }

    /** Pilih nama kolom pertama yang benar-benar ada di tabel. */
    private function kolom(string $table, array $kandidat): ?string
    {
        foreach ($kandidat as $nama) {
            if (Schema::hasColumn($table, $nama)) {
                return $nama;
            }
        }

        return null;
    }
}