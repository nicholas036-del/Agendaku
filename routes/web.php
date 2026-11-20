<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\CouncilController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TeacherController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Agendaku
|--------------------------------------------------------------------------
*/

// Handler sementara untuk fitur yang belum dibuat
$notImplemented = fn (string $message) => fn () => abort(501, $message);

/*
|--------------------------------------------------------------------------
| Public
|--------------------------------------------------------------------------
*/
Route::get('/', fn () => redirect()->route('login'));

Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'loginView')->name('login');
    Route::post('/login', 'loginPost')->name('login-post');
    Route::get('/register', 'registerView')->name('register-view');
    Route::post('/register', 'registerPost')->name('register-post');
});

/*
|--------------------------------------------------------------------------
| API Kalender (tugas + acara, dikelompokkan per tanggal)
| GET /api/calendar/month?month=YYYY-MM
|--------------------------------------------------------------------------
| TEMPORARY: middleware auth dimatikan hanya untuk tes JSON.
| Sebelum commit, ganti jadi ->middleware('auth').
*/
Route::get('/api/calendar/month', [CalendarController::class, 'month'])
    // ->middleware('auth')
    ->name('calendar.month');

/*
|--------------------------------------------------------------------------
| Semua user yang sudah login
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () use ($notImplemented) {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    /*
    |----------------------------------------------------------------------
    | Student (role: student, admin)
    |----------------------------------------------------------------------
    */
    Route::middleware('role:student,admin')->group(function () {
        Route::get('/students', [StudentController::class, 'index'])->name('students.index');

        Route::controller(TaskController::class)
            ->prefix('tasks')->as('tasks.')
            ->group(function () {
                Route::post('/', 'store')->name('store');
                Route::put('/{task}', 'update')->name('update');
                Route::patch('/{task}/toggle', 'toggle')->name('toggle');
                Route::delete('/{task}', 'destroy')->name('destroy');
            });
    });

    /*
    |----------------------------------------------------------------------
    | Teacher (role: teacher, admin)
    |----------------------------------------------------------------------
    */
    Route::middleware('role:teacher,admin')
        ->prefix('teacher')->as('teachers.')
        ->group(function () use ($notImplemented) {
            Route::get('/', [TeacherController::class, 'index'])->name('index');
            Route::post('/tasks', $notImplemented('Penerbitan tugas guru belum diimplementasikan.'))->name('tasks.store');
            Route::post('/announcements', $notImplemented('Pengumuman belum diimplementasikan.'))->name('announcements.store');
        });

    /*
    |----------------------------------------------------------------------
    | Council / OSIS (role: council, admin)
    |----------------------------------------------------------------------
    */
    Route::middleware('role:council,admin')->group(function () use ($notImplemented) {
        Route::get('/council', [CouncilController::class, 'index'])->name('council.index');

        Route::prefix('school-events')->as('school-events.')->group(function () use ($notImplemented) {
            Route::post('/', $notImplemented('Acara sekolah belum diimplementasikan.'))->name('store');
            Route::put('/{schoolEvent}', $notImplemented('Pembaruan acara belum diimplementasikan.'))->name('update');
            Route::delete('/{schoolEvent}', $notImplemented('Penghapusan acara belum diimplementasikan.'))->name('destroy');
        });
    });

    /*
    |----------------------------------------------------------------------
    | Admin (role: admin)
    |----------------------------------------------------------------------
    */
    Route::middleware('role:admin')
        ->prefix('admin')->as('admin.')
        ->group(function () use ($notImplemented) {
            Route::get('/', [AdminController::class, 'index'])->name('index');

            Route::prefix('users')->as('users.')->group(function () use ($notImplemented) {
                Route::post('/', $notImplemented('Manajemen pengguna belum diimplementasikan.'))->name('store');
                Route::put('/{user}', $notImplemented('Pembaruan pengguna belum diimplementasikan.'))->name('update');
                Route::delete('/{user}', $notImplemented('Penghapusan pengguna belum diimplementasikan.'))->name('destroy');
            });
        });
});