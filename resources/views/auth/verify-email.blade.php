<x-guest-layout>
    <div class="card border-0 shadow-sm p-4">
        <div class="text-center mb-4 text-brand-green">
            <h4 class="fw-bold">Verify Your Email</h4>
            <div class="text-muted small">
                {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
            </div>
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="alert alert-success border-0 shadow-sm text-sm mb-4">
                {{ __('A new verification link has been sent to the email address you provided during registration.') }}
            </div>
        @endif

        <div class="mt-4">
            <form method="POST" action="{{ route('verification.send') }}" class="d-grid mb-3">
                @csrf
                <button type="submit" class="btn btn-univ rounded-pill py-2 fw-bold shadow-sm">
                    {{ __('Resend Verification Email') }}
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}" class="text-center">
                @csrf
                <button type="submit" class="btn btn-link text-muted small text-decoration-none">
                    {{ __('Log Out') }}
                </button>
            </form>
        </div>
    </div>
</x-guest-layout>
