<x-layouts::auth :title="__('Log in')">
    <div class="w-full max-w-sm rounded-2xl border border-white/10 bg-zinc-900/50 p-8 shadow-2xl backdrop-blur-md">

        <div class="flex flex-col gap-1 mb-8">
            <h2 class="text-2xl font-bold tracking-tight text-white">
                {{ __('Welcome Back') }}
            </h2>
            <p class="text-sm text-zinc-400">
                {{ __('Log in to your corporate account again.') }}
            </p>
        </div>

        <x-auth-session-status class="mb-6 text-center text-sm font-medium" :status="session('status')" />

        <form method="POST" action="{{ route('login.store') }}" class="flex flex-col gap-5">
            @csrf

            <div class="flex flex-col gap-1.5">
                <flux:label class="text-zinc-200! font-medium text-sm">{{ __('Corporate Email') }}</flux:label>
                <flux:input name="email" :value="old('email')" type="email" required autofocus autocomplete="email"
                    placeholder="name@company.com" icon="envelope"
                    class="bg-zinc-950! border-white/10! text-white! placeholder-zinc-600! focus:border-blue-500!" />
            </div>

            <div class="flex flex-col gap-1.5 relative">
                <div class="flex justify-between items-center">
                    <flux:label class="text-zinc-200! font-medium text-sm">{{ __('Password') }}</flux:label>
                    @if (Route::has('password.request'))
                        <flux:link class="text-xs font-medium text-blue-400 hover:text-blue-300 transition-colors"
                            :href="route('password.request')" wire:navigate>
                            {{ __('Forgot?') }}
                        </flux:link>
                    @endif
                </div>
                <flux:input name="password" type="password" required autocomplete="current-password"
                    placeholder="••••••••" viewable icon="key"
                    class="bg-zinc-950! border-white/10! text-white! placeholder-zinc-600! focus:border-blue-500!" />
            </div>

            <div class="flex items-center gap-2 py-1">
                <flux:checkbox name="remember" :checked="old('remember')" class="border-white/20!" />
                <span class="text-sm font-medium text-zinc-300 select-none">{{ __('Keep me logged in') }}</span>
            </div>

            <div class="mt-2">
                <flux:button variant="primary" type="submit"
                    class="w-full cursor-pointer bg-linear-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold py-2.5 rounded-xl shadow-lg shadow-blue-500/10 transition-all duration-200 border-none!"
                    data-test="login-button">
                    {{ __('Authenticate Access') }}
                </flux:button>
            </div>
        </form>

        @if (Route::has('register'))
            <div class="mt-6 pt-5 border-t border-white/5 text-center">
                <flux:link :href="route('register')" wire:navigate
                    class="text-xs font-medium text-zinc-500 hover:text-zinc-300 transition-colors">
                    {{ __('Need a new corporate tenant?') }}
                </flux:link>
            </div>
        @endif
    </div>
</x-layouts::auth>
