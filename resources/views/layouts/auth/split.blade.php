<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
</head>

<body class="min-h-screen antialiased bg-zinc-950 text-zinc-50 select-none">
    <div class="relative grid h-dvh grid-cols-1 lg:grid-cols-2 overflow-hidden">

        <div class="absolute inset-0 z-0 pointer-events-none overflow-hidden">
            <div class="absolute -top-40 -left-40 h-150 w-150 rounded-full bg-blue-500/10 blur-[140px]"></div>
            <div class="absolute -bottom-40 -right-40 h-125 w-125 rounded-full bg-indigo-500/5 blur-[120px]"></div>

            <div
                class="absolute inset-0 bg-[linear-gradient(to_right,#3f3f46_1px,transparent_1px),linear-gradient(to_bottom,#3f3f46_1px,transparent_1px)] bg-size-[4rem_4rem] mask-[radial-gradient(ellipse_60%_50%_at_50%_0%,#000_70%,transparent_100%)] opacity-45">
            </div>
        </div>

        <div
            class="relative hidden h-full flex-col p-12 text-white lg:flex justify-between border-e border-zinc-900 bg-linear-to-b from-slate-950/20 to-zinc-950/20 z-10">

            <a href="{{ route('home') }}" class="relative z-20 flex items-center gap-3 text-lg font-black tracking-tight"
                wire:navigate>
                <div
                    class="flex h-10 w-10 items-center justify-center rounded-xl bg-linear-to-tr from-blue-600 to-indigo-600 shadow-lg shadow-blue-500/30">
                    <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <span>Lara<span class="text-blue-500">DMS</span></span>
            </a>

            <div
                class="relative z-20 max-w-md rounded-2xl border border-white/5 bg-white/2 p-6 backdrop-blur-md shadow-2xl">
                <blockquote class="space-y-4">
                    <p class="text-lg font-medium leading-relaxed text-zinc-200">
                        {{ __('Secure, centralized, and compliant. Manage your organization\'s entire document lifecycle and approval workflows from a single secure vault.') }}
                    </p>
                    <div class="flex items-center gap-3">
                        <div class="h-px w-6 bg-blue-500"></div>
                        <p class="text-sm font-semibold tracking-wide text-zinc-400 uppercase">
                            {{ __('LaraDMS Core Compliance Engine') }}
                        </p>
                    </div>
                </blockquote>
            </div>
        </div>

        <div
            class="relative flex h-full items-center justify-center p-6 sm:p-12 bg-linear-to-b from-zinc-950 via-slate-950 to-zinc-950 z-10">
            <div class="relative w-full max-w-sm z-20">

                <a href="{{ route('home') }}" class="mb-8 flex flex-col items-center gap-2 font-medium lg:hidden"
                    wire:navigate>
                    <div
                        class="flex h-11 w-11 items-center justify-center rounded-xl bg-linear-to-tr from-blue-600 to-indigo-600 shadow-lg">
                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                </a>

                {{ $slot }}

            </div>
        </div>
    </div>

    @persist('toast')
        <flux:toast.group>
            <flux:toast />
        </flux:toast.group>
    @endpersist
    @fluxScripts
</body>

</html>
