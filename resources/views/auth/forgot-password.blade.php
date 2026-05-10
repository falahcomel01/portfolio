<x-guest-layout>
    <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-[0_20px_60px_rgba(15,23,42,0.08)]">
        <div class="bg-gradient-to-r from-slate-950 via-slate-900 to-indigo-900 px-6 py-7 text-white">
            <p class="mb-2 text-xs font-semibold uppercase tracking-[0.32em] text-indigo-200">Account Recovery</p>
            <h1 class="text-2xl font-semibold leading-tight">Reset your password</h1>
            <p class="mt-3 max-w-md text-sm leading-6 text-slate-200">
                Enter the email address connected to your admin account and we will generate a password reset link for you.
            </p>
        </div>

        <div class="px-6 py-6 sm:px-7">
            <div class="mb-5 rounded-2xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm leading-6 text-amber-900">
                Use the same email address that is registered in your portfolio admin account.
            </div>

            <x-auth-session-status class="mb-4 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800" :status="session('status')" />

            <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
                @csrf

                <div>
                    <x-input-label for="email" value="Email Address" class="text-sm font-semibold text-slate-700" />
                    <x-text-input
                        id="email"
                        class="mt-2 block w-full rounded-2xl border-slate-300 px-4 py-3 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        type="email"
                        name="email"
                        :value="old('email')"
                        placeholder="you@example.com"
                        required
                        autofocus
                    />
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-rose-600" />
                </div>

                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <a href="{{ route('login') }}" class="text-sm font-medium text-slate-500 transition hover:text-slate-900">
                        Back to login
                    </a>

                    <x-primary-button class="justify-center rounded-2xl bg-slate-950 px-5 py-3 text-[11px] tracking-[0.22em] hover:bg-slate-800 focus:bg-slate-800 active:bg-black">
                        Send Reset Link
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
