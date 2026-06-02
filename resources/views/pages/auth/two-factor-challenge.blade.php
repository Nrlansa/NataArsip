<x-layouts::auth :title="__('Two-factor authentication')">
    <div class="w-full max-w-sm rounded-2xl border border-white/10 bg-zinc-900/50 p-8 shadow-2xl backdrop-blur-md">

        <div class="flex flex-col gap-6">
            <div class="relative w-full h-auto" x-cloak x-data="{
                showRecoveryInput: @js($errors->has('recovery_code')),
                code: '',
                recovery_code: '',
                focusOtp() {
                    this.$nextTick(() => this.$refs.otp?.querySelector('input')?.focus());
                },
                init() {
                    if (!this.showRecoveryInput) {
                        this.focusOtp();
                    }
                },
                toggleInput() {
                    this.showRecoveryInput = !this.showRecoveryInput;
            
                    this.code = '';
                    this.recovery_code = '';
            
                    this.$nextTick(() => {
                        this.showRecoveryInput ?
                            this.$refs.recovery_code?.focus() :
                            this.focusOtp();
                    });
                },
            }">
                <div x-show="!showRecoveryInput" class="mb-6">
                    <h2 class="text-2xl font-bold tracking-tight text-white mb-1">
                        {{ __('Authentication Code') }}
                    </h2>
                    <p class="text-sm text-zinc-400 leading-relaxed">
                        {{ __('Enter the authentication code provided by your authenticator application.') }}
                    </p>
                </div>

                <div x-show="showRecoveryInput" class="mb-6">
                    <h2 class="text-2xl font-bold tracking-tight text-white mb-1">
                        {{ __('Recovery Code') }}
                    </h2>
                    <p class="text-sm text-zinc-400 leading-relaxed">
                        {{ __('Please confirm access to your account by entering one of your emergency recovery codes.') }}
                    </p>
                </div>

                <form method="POST" action="{{ route('two-factor.login.store') }}">
                    @csrf

                    <div class="space-y-5 text-center">
                        <div x-show="!showRecoveryInput">
                            <div class="flex items-center justify-center my-5" x-ref="otp">
                                <flux:otp x-model="code" length="6" name="code" label="OTP Code" label:sr-only
                                    class="mx-auto text-white! gap-2" />
                            </div>
                        </div>

                        <div x-show="showRecoveryInput">
                            <div class="my-5 flex flex-col gap-1.5 text-left">
                                <flux:label class="text-zinc-200! font-medium text-sm">
                                    {{ __('Emergency Recovery Key') }}</flux:label>
                                <flux:input type="text" name="recovery_code" x-ref="recovery_code"
                                    x-bind:required="showRecoveryInput" autocomplete="one-time-code"
                                    x-model="recovery_code" placeholder="abcdef-123456" icon="key"
                                    class="bg-zinc-950! border-white/10! text-white! placeholder-zinc-600! focus:border-blue-500!" />
                            </div>

                            @error('recovery_code')
                                <flux:text color="red" class="text-xs text-left block mt-1">
                                    {{ $message }}
                                </flux:text>
                            @enderror
                        </div>

                        <flux:button variant="primary" type="submit"
                            class="w-full cursor-pointer bg-linear-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold py-2.5 rounded-xl shadow-lg shadow-blue-500/10 transition-all duration-200 border-none!">
                            {{ __('Verify & Continue') }}
                        </flux:button>
                    </div>

                    <div class="mt-6 pt-4 border-t border-white/5 text-center text-sm">
                        <span class="text-zinc-500">{{ __('or you can') }}</span>
                        <div
                            class="inline font-medium text-blue-400 hover:text-blue-300 transition-colors cursor-pointer select-none ml-1">
                            <span x-show="!showRecoveryInput"
                                @click="toggleInput()">{{ __('login using a recovery code') }}</span>
                            <span x-show="showRecoveryInput"
                                @click="toggleInput()">{{ __('login using an authentication code') }}</span>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts::auth>
