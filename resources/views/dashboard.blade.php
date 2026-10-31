<x-app-layout>
    <div class="min-h-screen bg-[#0B1020] text-white">

        <!-- Sidebar and main content -->
        <div class="flex min-h-screen">

            <!-- Sidebar -->
            <aside class="hidden md:flex w-64 flex-col border-r border-gray-800 bg-[#0F172A] p-6">

                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 mb-12">
                    <div class="bg-indigo-600 p-2 rounded-xl">
                        <span class="text-xl">✦</span>
                    </div>
                    <span class="text-xl font-bold">HabitFlow</span>
                </a>

                <p class="text-xs uppercase tracking-wider text-gray-500 mb-4">
                    Menu
                </p>

                <nav class="space-y-2">
                    <a href="{{ route('dashboard') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl bg-indigo-600/15 text-indigo-400">
                        <span>▦</span>
                        Dashboard
                    </a>

                    <!-- <a href="#"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-400 hover:bg-gray-800 hover:text-white">
                        <span>◷</span>
                        Statistics
                    </a> -->

                    <a href="{{ route('profile.edit') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-400 hover:bg-gray-800 hover:text-white">
                        <span>⚙</span>
                        Settings
                    </a>
                </nav>

                <div class="mt-auto">
                    <div class="border-t border-gray-800 pt-5">
                        <p class="text-sm font-semibold">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-500 mt-1">{{ Auth::user()->email }}</p>
                    </div>
                </div>

            </aside>

            <!-- Main content -->
            <main class="flex-1 min-w-0 p-6 lg:p-10">

                @if (session('success'))
                    <div class="mb-6 rounded-xl border border-green-500/30 bg-green-500/10 p-4 text-green-400">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-6 rounded-xl border border-red-500/30 bg-red-500/10 p-4 text-red-400">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <!-- Header -->
                <header class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-10">
                    <div>
                        <p class="text-sm text-gray-500">Your personal workspace</p>
                        <h1 class="text-3xl font-bold mt-1">
                            Welcome back, {{ Auth::user()->name }}!
                        </h1>
                        <p class="text-gray-400 mt-2">
                            Let's make today count.
                        </p>
                    </div>

                    <div class="flex flex-wrap items-center gap-3">
                        <div class="text-sm text-gray-400 bg-[#151C30] border border-gray-800 rounded-xl px-4 py-3">
                            {{ now()->format('l, d F Y') }}
                        </div>

                        <form action="{{ route('habits.store') }}" method="POST"
                            class="flex flex-wrap items-center gap-2">
                            @csrf

                            <input type="text" name="name" placeholder="New habit..." required maxlength="255"
                                class="w-36 rounded-lg border border-gray-700 bg-[#151C30] px-3 py-2 text-white placeholder-gray-500 focus:border-indigo-500 focus:outline-none">

                            <input type="color" name="color" value="#6366F1"
                                class="h-10 w-10 cursor-pointer rounded-lg border-0 bg-transparent"
                                title="Choose habit color">

                            <button type="submit"
                                class="rounded-lg bg-indigo-600 px-4 py-2 font-medium text-white hover:bg-indigo-500">
                                + Add
                            </button>
                        </form>
                    </div>

                </header>

                @php
                    $today = now()->toDateString();

                    $totalHabits = $habits->count();

                    $completedToday = $habits->filter(function ($habit) use ($today) {
                        return $habit->completions->contains(function ($completion) use ($today) {
                            return $completion->completed_on->toDateString() === $today;
                        });
                    })->count();

                    $progress = $totalHabits > 0
                        ? round(($completedToday / $totalHabits) * 100)
                        : 0;
                @endphp

                <!-- Statistics -->
                <section class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-10">

                    <div class="bg-[#151C30] border border-gray-800 rounded-2xl p-6">
                        <p class="text-sm text-gray-400">Total habits</p>
                        <h2 class="text-3xl font-bold mt-3">{{ $totalHabits }}</h2>
                        <p class="text-xs text-gray-500 mt-2">Active habits</p>
                    </div>

                    <div class="bg-[#151C30] border border-gray-800 rounded-2xl p-6">
                        <p class="text-sm text-gray-400">Completed today</p>
                        <h2 class="text-3xl font-bold text-green-400 mt-3">
                            {{ $completedToday }} / {{ $totalHabits }}
                        </h2>
                        <p class="text-xs text-gray-500 mt-2">
                            {{ $completedToday === $totalHabits && $totalHabits > 0 ? 'All done — great job!' : 'Keep going!' }}
                        </p>
                    </div>

                    <div class="bg-[#151C30] border border-gray-800 rounded-2xl p-6">
                        <p class="text-sm text-gray-400">Today's progress</p>
                        <h2 class="text-3xl font-bold text-indigo-400 mt-3">{{ $progress }}%</h2>
                        <div class="w-full h-2 bg-gray-700 rounded-full mt-4 overflow-hidden">
                            <div class="h-full bg-indigo-500 rounded-full" style="width: {{ $progress }}%"></div>
                        </div>
                    </div>

                </section>

                <!-- Habit matrix -->
                <section class="bg-[#151C30] border border-gray-800 rounded-2xl p-6">

                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
                        <div>
                            <h2 class="text-xl font-bold">Habit matrix</h2>
                            <p class="text-sm text-gray-400 mt-1">
                                Your weekly activity overview.
                            </p>
                        </div>

                        <div class="flex items-center gap-3">
                            <!-- Previous week -->
                            <a href="{{ route('dashboard', ['week' => $weekStart->copy()->subWeek()->toDateString()]) }}"
                                class="px-3 py-2 rounded-lg bg-gray-800 text-gray-300 hover:bg-gray-700 transition">
                                ←
                            </a>

                            <!-- Selected week -->
                            <span class="text-sm font-medium text-gray-300">
                                {{ $weekStart->format('d M') }}
                                -
                                {{ $weekStart->copy()->addDays(6)->format('d M Y') }}
                            </span>
                            <!-- Next week -->
                            @if($weekStart->copy()->addWeek()->lte($currentWeek ?? now()->startOfWeek(\Illuminate\Support\Carbon::MONDAY)))
                                <a href="{{ route('dashboard', ['week' => $weekStart->copy()->addWeek()->toDateString()]) }}"
                                    class="px-3 py-2 rounded-lg bg-gray-800 text-gray-300 hover:bg-gray-700 transition">
                                    →
                                </a>
                            @else
                                <span class="px-3 py-2 rounded-lg bg-gray-800 text-gray-600 opacity-40 cursor-not-allowed">
                                    →
                                </span>
                            @endif
                            <a href="{{ route('dashboard') }}"
                                class="px-3 py-2 rounded-lg bg-indigo-600 hover:bg-indigo-500 text-white text-sm transition">
                                Today
                            </a>

                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <div class="min-w-[600px]">

                            <!-- Days -->
                            <div class="grid grid-cols-[180px_repeat(7,minmax(0,1fr))] gap-3 mb-5">
                                <div class="text-xs text-gray-500">HABIT</div>
                                @foreach($days as $day)
                                    <div class="text-center">
                                        <p class="text-xs text-gray-500">{{ $day->format('D') }}</p>
                                        <p class="text-sm text-gray-300 mt-1">{{ $day->format('d') }}</p>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Habit rows -->
                            <!-- Habit rows -->
                            @forelse($habits as $habit)
                                <div class="grid grid-cols-[180px_repeat(7,minmax(0,1fr))] gap-3 items-center mb-4">

                                    <!-- Habit name and delete button -->
                                    <div class="flex items-center justify-between gap-2">
                                        <span class="text-sm font-medium text-gray-200">
                                            {{ $habit->name }}
                                        </span>

                                        <form action="{{ route('habits.destroy', $habit) }}" method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this habit?')">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="text-red-400 hover:text-red-300"
                                                title="Delete habit">
                                                🗑
                                            </button>
                                        </form>
                                    </div>

                                    <!-- Daily completion buttons -->
                                    @foreach($days as $day)
                                        @php
                                            $completed = $habit->completions->contains(
                                                fn($completion) => $completion->completed_on->toDateString() === $day->toDateString()
                                            );

                                            $isFuture = $day->toDateString() > now()->toDateString();
                                        @endphp

                                        <div class="flex justify-center">
                                            @if(!$isFuture)
                                                <form action="{{ route('habits.toggle', $habit) }}" method="POST">
                                                    @csrf

                                                    <input type="hidden" name="date" value="{{ $day->toDateString() }}">

                                                    <button type="submit"
                                                        class="w-8 h-8 rounded-lg transition
                                                                                                                    {{ $completed ? 'bg-green-500 hover:bg-green-400' : 'bg-gray-700 hover:bg-gray-600' }}"
                                                        title="{{ $completed ? 'Mark incomplete' : 'Mark complete' }}">
                                                        @if($completed)
                                                            ✓
                                                        @endif
                                                    </button>
                                                </form>
                                            @else
                                                <div class="w-8 h-8 rounded-lg bg-gray-800 opacity-40"></div>
                                            @endif
                                        </div>
                                    @endforeach

                                </div>
                            @empty
                                <p class="py-10 text-center text-gray-400">
                                    You haven't added any habits yet. Create your first habit above!
                                </p>
                            @endforelse

                        </div>
                    </div>

                    <div class="flex items-center justify-between mt-8 pt-5 border-t border-gray-800">
                        <div class="flex items-center gap-4 text-xs text-gray-400">
                            <span class="flex items-center gap-2">
                                <span class="w-3 h-3 rounded bg-green-500"></span>
                                Completed
                            </span>

                            <span class="flex items-center gap-2">
                                <span class="w-3 h-3 rounded bg-gray-700"></span>
                                Not completed
                            </span>
                        </div>
                    </div>

                </section>

            </main>
        </div>
    </div>
</x-app-layout>