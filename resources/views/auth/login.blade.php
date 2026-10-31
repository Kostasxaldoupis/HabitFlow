
<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-[#0B1020] px-4">
        <div class="w-full max-w-md space-y-8">

            <div class="text-center">
                <div class="flex justify-center items-center gap-2 mb-6">
                    <div class="bg-indigo-600 p-3 rounded-xl">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 12a8 8 0 1016 0 8 8 0 00-16 0zm4-1l3 3 5-6"/>
                        </svg>
                    </div>
                    <h1 class="text-3xl font-bold text-white">HabitFlow</h1>
                </div>

                <h2 class="text-2xl font-bold text-white">Welcome back</h2>
                <p class="mt-2 text-gray-400">
                    Sign in to continue building better habits.
                </p>
            </div>

            <div class="bg-[#151C30] border border-gray-800 rounded-2xl p-8 shadow-xl">

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div>
                        <x-input-label for="email" :value="__('Email address')" class="!text-gray-300" />

                        <x-text-input
                            id="email"
                            class="block mt-2 w-full !bg-[#0B1020] !border-gray-700 !text-white focus:!border-indigo-500"
                            type="email"
                            name="email"
                            :value="old('email')"
                            required
                            autofocus
                            autocomplete="username"
                        />

                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="mt-5">
                        <x-input-label for="password" :value="__('Password')" class="!text-gray-300" />

                        <x-text-input
                            id="password"
                            class="block mt-2 w-full !bg-[#0B1020] !border-gray-700 !text-white focus:!border-indigo-500"
                            type="password"
                            name="password"
                            required
                            autocomplete="current-password"
                        />

                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div class="block mt-5">
                        <label for="remember_me" class="inline-flex items-center">
                            <input
                                id="remember_me"
                                type="checkbox"
                                class="rounded border-gray-600 bg-[#0B1020] text-indigo-600 shadow-sm focus:ring-indigo-500"
                                name="remember"
                            >
                            <span class="ms-2 text-sm text-gray-400">
                                Remember me
                            </span>
                        </label>
                    </div>

                    <div class="mt-6">
                        <x-primary-button class="w-full justify-center !bg-indigo-600 hover:!bg-indigo-500 !py-3">
                            {{ __('Sign in') }}
                        </x-primary-button>
                    </div>
                </form>

                <div class="mt-6 text-center text-sm text-gray-400">
                    Don't have an account?
                    <a href="{{ route('register') }}" class="text-indigo-400 hover:text-indigo-300 font-semibold">
                        Sign up
                    </a>
                </div>

            </div>

            <p class="text-center text-xs text-gray-600">
                Build better habits. One day at a time.
            </p>

        </div>
    </div>
</x-guest-layout>