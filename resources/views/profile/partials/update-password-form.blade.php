<section>
    <header class="mb-4">
        <h3 class="h4 fw-bold text-dark mb-2">
            {{ __('Update Password') }}
        </h3>

        <p class="text-muted small">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}">
        @csrf
        @method('put')

        <div class="mb-4">
            <label for="update_password_current_password" class="form-label fw-semibold small text-uppercase text-muted">{{ __('Current Password') }}</label>
            <input id="update_password_current_password" name="current_password" type="password" class="form-control form-control-lg border-0 bg-light shadow-sm" autocomplete="current-password">
            @if($errors->updatePassword->has('current_password'))
                <div class="text-danger small mt-1">{{ $errors->updatePassword->first('current_password') }}</div>
            @endif
        </div>

        <div class="mb-4">
            <label for="update_password_password" class="form-label fw-semibold small text-uppercase text-muted">{{ __('New Password') }}</label>
            <input id="update_password_password" name="password" type="password" class="form-control form-control-lg border-0 bg-light shadow-sm" autocomplete="new-password">
            @if($errors->updatePassword->has('password'))
                <div class="text-danger small mt-1">{{ $errors->updatePassword->first('password') }}</div>
            @endif
        </div>

        <div class="mb-4">
            <label for="update_password_password_confirmation" class="form-label fw-semibold small text-uppercase text-muted">{{ __('Confirm Password') }}</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="form-control form-control-lg border-0 bg-light shadow-sm" autocomplete="new-password">
            @if($errors->updatePassword->has('password_confirmation'))
                <div class="text-danger small mt-1">{{ $errors->updatePassword->first('password_confirmation') }}</div>
            @endif
        </div>

        <div class="d-flex align-items-center gap-3 mt-5">
            <button type="submit" class="btn btn-univ px-5 py-2 shadow-sm">{{ __('Update Password') }}</button>

            @if (session('status') === 'password-updated')
                <div 
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 3000)"
                    class="text-success small fw-bold d-flex align-items-center"
                >
                    <i class="bi bi-shield-check me-2"></i> {{ __('Password updated successfully.') }}
                </div>
            @endif
        </div>
    </form>
</section>
