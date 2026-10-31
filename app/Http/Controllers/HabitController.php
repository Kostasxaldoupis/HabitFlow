<?php

namespace App\Http\Controllers;

use App\Models\Habit;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class HabitController extends Controller
{
    // Create a habit
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'color' => ['required', 'regex:/^#[0-9A-Fa-f]{6}$/'],
        ]);

        $request->user()->habits()->create($validated);

        return redirect()->route('dashboard', [
            'week' => request('week', now()->startOfWeek(Carbon::MONDAY)->toDateString()),
        ])->with('success', 'Habit created successfully!');
    }

    public function update(Request $request, Habit $habit)
    {
        // make sure the habit belongs to the loggedin user
        abort_unless($habit->user_id === $request->user()->id, 403);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'color' => ['required', 'regex:/^#[0-9A-Fa-f]{6}$/'],
        ]);

        $habit->update($validated);

        return redirect()->route('dashboard', [
            'week' => $request->input('week', now()->startOfWeek()->toDateString()),
        ])->with('success', 'Habit updated successfully!');
    }

    // Toggle a habit completion
    public function toggle(Request $request, Habit $habit)
    {
        abort_unless($habit->user_id === $request->user()->id, 403);

        $validated = $request->validate([
            'date' => ['required', 'date_format:Y-m-d'],
        ]);

        $date = Carbon::createFromFormat('!Y-m-d', $validated['date']);

        abort_if($date->isFuture(), 403, 'Future dates cannot be completed.');

        $completion = $habit->completions()
            ->whereDate('completed_on', $date->toDateString())
            ->first();

        if ($completion) {
            $completion->delete();
        } else {
            $habit->completions()->create([
                'completed_on' => $date->toDateString(),
            ]);
        }

        return redirect()->route('dashboard', [
            'week' => $date->copy()->startOfWeek()->toDateString(),
        ]);
    }

    // Delete a habit
    public function destroy(Request $request, Habit $habit)
    {
        abort_unless($habit->user_id === $request->user()->id, 403);

        $habit->delete();

        return redirect()->route('dashboard', [
            'week' => request('week', now()->startOfWeek(Carbon::MONDAY)->toDateString()),
        ])->with('success', 'Habit deleted successfully!');
    }
}