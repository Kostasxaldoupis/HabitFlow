<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HabitController;
use Illuminate\Support\Facades\Auth;

// direct user either to dashboard or login
Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }

    return redirect()->route('login');
});




Route::get('/dashboard', function () {
    /** @var \App\Models\User $user */
    $user = Auth::user();

    // Calculate the selected week's Monday
    $weekStart = \Illuminate\Support\Carbon::parse(
        request('week', now()->toDateString())
    )->startOfWeek(\Illuminate\Support\Carbon::MONDAY);

    // Prevent navigation into future weeks
    $currentWeek = now()->startOfWeek(\Illuminate\Support\Carbon::MONDAY);

    if ($weekStart->greaterThan($currentWeek)) {
        $weekStart = $currentWeek;
    }

    // Generate Monday through Sunday
    $days = collect(range(0, 6))->map(
        fn($i) => $weekStart->copy()->addDays($i)
    );

    // Load habits and their completion records
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

    Route::put('/habits/{habit}', [HabitController::class, 'update'])
        ->name('habits.update');


    // PROFILE
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

require __DIR__ . '/auth.php';
