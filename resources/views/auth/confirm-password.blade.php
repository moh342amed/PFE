<x-guest-layout>
    <div class="card border-0 shadow-sm p-4">
        <div class="text-center mb-4 text-brand-green">
            <h4 class="fw-bold">Confirm Password</h4>
            <div class="text-muted small">
                {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
            </div>
        </div>

        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf

            <!-- Password -->
            <div class="mb-4">
                <label for="password" class="form-label small fw-bold">{{ __('Password') }}</label>
                <input id="password" class="form-control rounded-3 py-2 @error('password') is-invalid @enderror"
                                type="password"
                                name="password"
                                required autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-univ rounded-pill py-2 fw-bold shadow-sm">
                    {{ __('Confirm') }}
                </button>
            </div>
        </form>
    </div>
</x-guest-layout>
