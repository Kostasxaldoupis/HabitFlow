
<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-[#0B1020] px-4 py-10">
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

                <h2 class="text-2xl font-bold text-white">Create your account</h2>
                <p class="mt-2 text-gray-400">
                    Start building better habits today.
                </p>
            </div>

            <div class="bg-[#151C30] border border-gray-800 rounded-2xl p-8 shadow-xl">

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div>
                        <x-input-label for="name" :value="__('Full name')" class="!text-gray-300" />

                        <x-text-input
                            id="name"
                            class="block mt-2 w-full !bg-[#0B1020] !border-gray-700 !text-white focus:!border-indigo-500"
                            type="text"
                            name="name"
                            :value="old('name')"
                            required
                            autofocus
                            autocomplete="name"
                        />

                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="mt-5">
                        <x-input-label for="email" :value="__('Email address')" class="!text-gray-300" />

                        <x-text-input
                            id="email"
                            class="block mt-2 w-full !bg-[#0B1020] !border-gray-700 !text-white focus:!border-indigo-500"
                            type="email"
                            name="email"
                            :value="old('email')"
                            required
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
                            autocomplete="new-password"
                        />

                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div class="mt-5">
                        <x-input-label for="password_confirmation" :value="__('Confirm password')" class="!text-gray-300" />

                        <x-text-input
                            id="password_confirmation"
                            class="block mt-2 w-full !bg-[#0B1020] !border-gray-700 !text-white focus:!border-indigo-500"
                            type="password"
                            name="password_confirmation"
                            required
                            autocomplete="new-password"
                        />

                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <div class="mt-6">
                        <x-primary-button class="w-full justify-center !bg-indigo-600 hover:!bg-indigo-500 !py-3">
                            {{ __('Create account') }}
                        </x-primary-button>
                    </div>
                </form>

                <div class="mt-6 text-center text-sm text-gray-400">
                    Already have an account?
                    <a href="{{ route('login') }}" class="text-indigo-400 hover:text-indigo-300 font-semibold">
                        Sign in
                    </a>
                </div>

            </div>

            <p class="text-center text-xs text-gray-600">
                Build better habits. One day at a time.
            </p>

        </div>
    </div>
</x-guest-layout>
