<div class="flex items-start max-md:flex-col gap-8 w-full">

    <div class="w-full md:w-65 shrink-0">
        <div
            class="rounded-2xl border border-zinc-200 bg-white p-3 shadow-xs sticky top-8 dark:border-white/10 dark:bg-zinc-900/50 dark:shadow-xl dark:backdrop-blur-md">
            <flux:navlist aria-label="{{ __('Settings') }}" class="space-y-1">
                <flux:navlist.item icon="user" :href="route('profile.edit')" wire:navigate
                    class="text-zinc-600 hover:text-zinc-900 dark:text-zinc-300! dark:hover:text-white! dark:hover:bg-white/5!">
                    {{ __('Profile') }}
                </flux:navlist.item>
                <flux:navlist.item icon="shield-check" :href="route('security.edit')" wire:navigate
                    class="text-zinc-600 hover:text-zinc-900 dark:text-zinc-300! dark:hover:text-white! dark:hover:bg-white/5!">
                    {{ __('Security') }}
                </flux:navlist.item>
                <flux:navlist.item icon="paint-brush" :href="route('appearance.edit')" wire:navigate
                    class="text-zinc-600 hover:text-zinc-900 dark:text-zinc-300! dark:hover:text-white! dark:hover:bg-white/5!">
                    {{ __('Appearance') }}
                </flux:navlist.item>
            </flux:navlist>
        </div>
    </div>

    <flux:separator class="md:hidden border-zinc-200 dark:border-white/10" />

    <div class="flex-1 self-stretch max-md:pt-6">

        <div class="mb-8 border-b border-zinc-200 pb-5 dark:border-white/5">
            <h2 class="text-2xl font-bold tracking-tight text-zinc-900 dark:text-white">
                {{ $heading ?? 'Settings' }}
            </h2>
            <p class="text-sm text-zinc-500 mt-1 dark:text-zinc-400">
                {{ $subheading ?? 'Manage your account configurations.' }}
            </p>
        </div>

        <div class="w-full max-w-4xl">
            {{ $slot }}
        </div>

    </div>
</div>
