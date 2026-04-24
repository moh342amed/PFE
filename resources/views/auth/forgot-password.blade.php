<x-guest-layout>
    <div class="card border-0 shadow-sm p-4">
        <div class="text-center mb-4">
            <h4 class="fw-bold brand-green">Forgot Password?</h4>
            <p class="text-muted small">No problem. Just let us know your email address and we will email you a password reset link.</p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <!-- Email Address -->
            <div class="mb-4">
                <label for="email" class="form-label fw-bold">{{ __('Email') }}</label>
                <input id="email" class="form-control rounded-3 py-2 @error('email') is-invalid @enderror" type="email" name="email" value="{{ old('email') }}" required autofocus />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-univ rounded-pill py-2 fw-bold shadow-sm">
                    {{ __('Email Password Reset Link') }}
                </button>
                <a href="{{ route('login') }}" class="btn btn-light rounded-pill py-2 text-muted small">
                    Back to Login
                </a>
            </div>
        </form>
    </div>
</x-guest-layout>
