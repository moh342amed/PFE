<x-guest-layout>
    <div class="card border-0 shadow-sm p-4">
        <div class="text-center mb-4 text-brand-green">
            <h4 class="fw-bold">Reset Password</h4>
            <p class="text-muted small">Enter your new credentials below.</p>
        </div>

        <form method="POST" action="{{ route('password.store') }}">
            @csrf

            <!-- Password Reset Token -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <!-- Email Address -->
            <div class="mb-3">
                <label for="email" class="form-label small fw-bold">{{ __('Email Address') }}</label>
                <input id="email" class="form-control rounded-3 py-2 @error('email') is-invalid @enderror" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mb-3">
                <label for="password" class="form-label small fw-bold">{{ __('New Password') }}</label>
                <input id="password" class="form-control rounded-3 py-2 @error('password') is-invalid @enderror" type="password" name="password" required />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="mb-4">
                <label for="password_confirmation" class="form-label small fw-bold">{{ __('Confirm Password') }}</label>
                <input id="password_confirmation" class="form-control rounded-3 py-2 @error('password_confirmation') is-invalid @enderror" type="password" name="password_confirmation" required />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-univ rounded-pill py-2 fw-bold shadow-sm">
                    {{ __('Reset Password') }}
                </button>
            </div>
        </form>
    </div>
</x-guest-layout>
