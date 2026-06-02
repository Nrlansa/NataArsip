<?php

use App\Concerns\PasswordValidationRules;
use Flux\Flux;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Actions\DisableTwoFactorAuthentication;
use Laravel\Fortify\Features;
use Laravel\Fortify\Fortify;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Title('Security settings')] class extends Component {
    use PasswordValidationRules;

    public string $current_password = '';
    public string $password = '';
    public string $password_confirmation = '';

    public bool $canManageTwoFactor;

    public bool $twoFactorEnabled;

    public bool $requiresConfirmation;

    /**
     * Mount the component.
     */
    public function mount(DisableTwoFactorAuthentication $disableTwoFactorAuthentication): void
    {
        $this->canManageTwoFactor = Features::canManageTwoFactorAuthentication();

        if ($this->canManageTwoFactor) {
            if (Fortify::confirmsTwoFactorAuthentication() && is_null(auth()->user()->two_factor_confirmed_at)) {
                $disableTwoFactorAuthentication(auth()->user());
            }

            $this->twoFactorEnabled = auth()->user()->hasEnabledTwoFactorAuthentication();
            $this->requiresConfirmation = Features::optionEnabled(Features::twoFactorAuthentication(), 'confirm');
        }
    }

    /**
     * Update the password for the currently authenticated user.
     */
    public function updatePassword(): void
    {
        try {
            $validated = $this->validate([
                'current_password' => $this->currentPasswordRules(),
                'password' => $this->passwordRules(),
            ]);
        } catch (ValidationException $e) {
            $this->reset('current_password', 'password', 'password_confirmation');

            throw $e;
        }

        Auth::user()->update([
            'password' => $validated['password'],
        ]);

        $this->reset('current_password', 'password', 'password_confirmation');

        Flux::toast(variant: 'success', text: __('Password updated.'));
    }

    /**
     * Handle the two-factor authentication enabled event.
     */
    #[On('two-factor-enabled')]
    public function onTwoFactorEnabled(): void
    {
        $this->twoFactorEnabled = true;
    }

    /**
     * Disable two-factor authentication for the user.
     */
    public function disable(DisableTwoFactorAuthentication $disableTwoFactorAuthentication): void
    {
        $disableTwoFactorAuthentication(auth()->user());

        $this->twoFactorEnabled = false;
    }
}; ?>

<section class="w-full space-y-8">
    @include('partials.settings-heading')

    <flux:heading class="sr-only">{{ __('Security settings') }}</flux:heading>

    <div class="rounded-xl border border-zinc-200 bg-white p-6 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">

        <div class="mb-6 flex flex-col gap-1 border-b border-zinc-100 pb-5 dark:border-zinc-800">
            <h3 class="text-lg font-bold text-zinc-900 dark:text-white flex items-center gap-2">
                <flux:icon.key class="size-5 text-blue-500" />
                {{ __('Update Password') }}
            </h3>
            <p class="text-xs text-zinc-500 dark:text-zinc-400">
                {{ __('Ensure your account is using a long, random password to stay secure against unauthorized access.') }}
            </p>
        </div>

        <form method="POST" wire:submit="updatePassword" class="space-y-6">
            <flux:input wire:model="current_password" :label="__('Current Password')" type="password" required
                autocomplete="current-password" viewable icon="lock-closed" />
            <flux:input wire:model="password" :label="__('New Password')" type="password" required
                autocomplete="new-password" viewable icon="shield-exclamation" />
            <flux:input wire:model="password_confirmation" :label="__('Confirm Password')" type="password" required
                autocomplete="new-password" viewable icon="shield-check" />

            <div class="flex justify-end pt-3">
                <flux:button variant="primary" type="submit"
                    class="px-6 rounded-lg bg-blue-600 hover:bg-blue-700 text-white dark:bg-indigo-600 dark:hover:bg-indigo-700">
                    {{ __('Save Password') }}
                </flux:button>
            </div>
        </form>
    </div>

    @if ($canManageTwoFactor)
        <div class="rounded-xl border border-zinc-200 bg-white p-6 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">

            <div class="mb-6 flex flex-col gap-1 border-b border-zinc-100 pb-5 dark:border-zinc-800">
                <h3 class="text-lg font-bold text-zinc-900 dark:text-white flex items-center gap-2">
                    <flux:icon.shield-check class="size-5 text-emerald-500" />
                    {{ __('Two-Factor Authentication') }}
                </h3>
                <p class="text-xs text-zinc-500 dark:text-zinc-400">
                    {{ __('Manage your 2FA settings to add an impenetrable layer of security to your document vault.') }}
                </p>
            </div>

            <div class="w-full mx-auto text-sm space-y-6" wire:cloak>
                @if ($twoFactorEnabled)
                    <div
                        class="inline-flex items-center gap-1.5 rounded-full border border-emerald-500/30 bg-emerald-50 px-3 py-1 text-xs font-semibold tracking-wide text-emerald-600 uppercase dark:bg-emerald-500/10 dark:text-emerald-400">
                        <span class="h-2 w-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        {{ __('Security Vault Protected') }}
                    </div>

                    <p class="text-zinc-600 dark:text-zinc-300">
                        {{ __('You will be prompted for a secure, random pin during login, which you can retrieve from the TOTP-supported application on your phone.') }}
                    </p>

                    <div
                        class="rounded-lg bg-zinc-50 border border-zinc-200 p-5 dark:bg-zinc-950 dark:border-zinc-800 text-zinc-800 dark:text-zinc-200">
                        <livewire:pages::settings.two-factor.recovery-codes :$requiresConfirmation />
                    </div>

                    <div class="pt-5 flex justify-start border-t border-zinc-100 dark:border-zinc-800">
                        <flux:button variant="danger" wire:click="disable"
                            class="rounded-lg px-5 text-white-600 bg-red-50 hover:bg-red-100 dark:text-white-500 dark:bg-red-500/10 dark:hover:bg-red-500/20">
                            {{ __('Disable 2FA Protection') }}
                        </flux:button>
                    </div>
                @else
                    <p class="text-zinc-600 dark:text-zinc-400">
                        {{ __('When you enable two-factor authentication, you will be prompted for a secure pin during login. This pin can be retrieved from a TOTP-supported application on your phone.') }}
                    </p>

                    <div class="pt-2">
                        <flux:modal.trigger name="two-factor-setup-modal">
                            <flux:button variant="primary" wire:click="$dispatch('start-two-factor-setup')"
                                class="rounded-lg px-6 bg-emerald-600 hover:bg-emerald-700 text-white dark:bg-emerald-500 dark:hover:bg-emerald-600">
                                {{ __('Enable 2FA Protection') }}
                            </flux:button>
                        </flux:modal.trigger>
                    </div>

                    <livewire:pages::settings.two-factor-setup-modal :requires-confirmation="$requiresConfirmation" />
                @endif
            </div>
        </div>
    @endif
</section>
