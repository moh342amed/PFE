<x-guest-layout>
    <div class="mb-4 text-center">
        <h3 class="fw-bold">Welcome Back</h3>
        <p class="text-muted">Login to your university account</p>
    </div>

    <!-- Session Status -->
    @if (session('status'))
        <div class="alert alert-success mb-4 border-0 shadow-sm rounded-3" role="alert">
            <i class="bi bi-info-circle me-2"></i> {{ session('status') }}
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success mb-4 border-0 shadow-sm rounded-3" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div class="mb-3">
            <label for="email" class="form-label fw-semibold">Email Address</label>
            <input id="email" type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="name@example.com">
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Password -->
        <div class="mb-3">
            <div class="d-flex justify-content-between">
                <label for="password" class="form-label fw-semibold">Password</label>
                @if (Route::has('password.request'))
                    <a class="text-decoration-none brand-color small" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif
            </div>
            <input id="password" type="password" name="password" class="form-control @error('password') is-invalid @enderror" required autocomplete="current-password">
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Remember Me -->
        <div class="mb-4">
            <div class="form-check">
                <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                <label for="remember_me" class="form-check-label text-muted">
                    {{ __('Remember me') }}
                </label>
            </div>
        </div>

        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-univ">
                {{ __('Log in') }}
            </button>
        </div>

        <div class="mt-4 text-center">
            <p class="mb-0">Don't have an account? <a href="{{ route('register') }}" class="text-decoration-none brand-color fw-semibold">Register now</a></p>
        </div>
    </form>
</x-guest-layout>
