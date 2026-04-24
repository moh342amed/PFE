<section>
    <header class="mb-4">
        <h3 class="h4 fw-bold text-dark mb-2">
            {{ __('Profile Information') }}
        </h3>

        <p class="text-muted small">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}">
        @csrf
        @method('patch')

        <div class="mb-4">
            <label for="name" class="form-label fw-semibold small text-uppercase text-muted">{{ __('Name') }}</label>
            <input id="name" name="name" type="text" class="form-control form-control-lg border-0 bg-light shadow-sm" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
            @if($errors->has('name'))
                <div class="text-danger small mt-1">{{ $errors->first('name') }}</div>
            @endif
        </div>

        <div class="mb-4">
            <label for="email" class="form-label fw-semibold small text-uppercase text-muted">{{ __('Email') }}</label>
            <input id="email" name="email" type="email" class="form-control form-control-lg border-0 bg-light shadow-sm" value="{{ old('email', $user->email) }}" required autocomplete="username">
            @if($errors->has('email'))
                <div class="text-danger small mt-1">{{ $errors->first('email') }}</div>
            @endif

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-3 p-3 bg-warning bg-opacity-10 border border-warning rounded-3">
                    <p class="small text-dark mb-2">
                        {{ __('Your email address is unverified.') }}
                    </p>
                    <button form="send-verification" class="btn btn-link btn-sm text-decoration-none fw-bold p-0">
                        {{ __('Click here to re-send the verification email.') }}
                    </button>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 text-success small fw-bold">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="d-flex align-items-center gap-3 mt-5">
            <button type="submit" class="btn btn-univ px-5 py-2 shadow-sm">{{ __('Save Changes') }}</button>

            @if (session('status') === 'profile-updated')
                <div 
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 3000)"
                    class="text-success small fw-bold d-flex align-items-center"
                >
                    <i class="bi bi-check-circle-fill me-2"></i> {{ __('Changes saved successfully.') }}
                </div>
            @endif
        </div>
    </form>
</section>
