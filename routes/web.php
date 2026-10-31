<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HabitController;
use Illuminate\Support\Facades\Auth;

// Route::get('/', function () {
//     return view('welcome');
// });



Route::get('/dashboard', function () {
    /** @var \App\Models\User $user */
    $user = Auth::user();

    $weekStart = \Illuminate\Support\Carbon::parse(
        request('week', now()->startOfWeek()->toDateString())
    )->startOfWeek();

    $days = collect(range(0, 6))->map(
        fn ($i) => $weekStart->copy()->addDays($i)
    );

    $habits = $user->habits()
        ->with('completions')
        ->get();

    return view('dashboard', compact('habits', 'days', 'weekStart'));
})->middleware('auth')->name('dashboard');




Route::middleware('auth')->group(function () {

    // HABITS ROUTES
    Route::post('/habits/{habit}/toggle', [HabitController::class, 'toggle'])
        ->name('habits.toggle');

    Route::delete('/habits/{habit}', [HabitController::class, 'destroy'])
        ->name('habits.destroy');

    Route::post('/habits', [HabitController::class, 'store'])->name('habits.store');


    // PROFILE
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

require __DIR__ . '/auth.php';
