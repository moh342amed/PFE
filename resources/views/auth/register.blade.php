<x-guest-layout>
    <div class="mb-4 text-center">
        <h3 class="fw-bold">Create Account</h3>
        <p class="text-muted">Join the University Event Management System</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div class="mb-3">
            <label for="name" class="form-label fw-semibold">Full Name</label>
            <input id="name" type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="John Doe">
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Email Address -->
        <div class="mb-3">
            <label for="email" class="form-label fw-semibold">Email Address</label>
            <input id="email" type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required autocomplete="username" placeholder="name@example.com">
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Role -->
        <div class="mb-3">
            <label for="role" class="form-label fw-semibold">University Role</label>
            <select id="role" name="role" class="form-select @error('role') is-invalid @enderror" required>
                <option value="" disabled selected>Select your role</option>
                <option value="student" {{ old('role') == 'student' ? 'selected' : '' }}>Student</option>
                <option value="professor" {{ old('role') == 'professor' ? 'selected' : '' }}>Professor</option>
                <option value="staff" {{ old('role') == 'staff' ? 'selected' : '' }}>Staff</option>
            </select>
            @error('role')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- University ID -->
        <div class="mb-3">
            <label for="university_id" class="form-label fw-semibold">University ID / Registration Number</label>
            <input id="university_id" type="text" name="university_id" class="form-control @error('university_id') is-invalid @enderror" value="{{ old('university_id') }}" required placeholder="e.g. 20230001">
            @error('university_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Password -->
        <div class="mb-3">
            <label for="password" class="form-label fw-semibold">Password</label>
            <div class="input-group overflow-hidden rounded-3">
                <span class="input-group-text bg-light border-0"><i class="bi bi-shield-lock"></i></span>
                <input id="password" type="password" name="password" class="form-control @error('password') is-invalid @enderror border-0 bg-light" required autocomplete="new-password">
            </div>
            <div class="form-text text-muted x-small mt-1">
                <i class="bi bi-info-circle me-1"></i> Min. 8 characters, must include uppercase, number, and symbol.
            </div>
            @error('password')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="mb-4">
            <label for="password_confirmation" class="form-label fw-semibold">Confirm Password</label>
            <div class="input-group overflow-hidden rounded-3">
                <span class="input-group-text bg-light border-0"><i class="bi bi-shield-check"></i></span>
                <input id="password_confirmation" type="password" name="password_confirmation" class="form-control border-0 bg-light" required autocomplete="new-password">
            </div>
        </div>

        <!-- Terms and Conditions -->
        <div class="mb-4">
            <div class="form-check">
                <input class="form-check-input @error('terms') is-invalid @enderror" type="checkbox" name="terms" id="terms" required>
                <label class="form-check-label ps-1 text-muted small" for="terms">
                    I agree to the <a href="#" class="brand-color text-decoration-none fw-bold">Terms of Service</a> and <a href="#" class="brand-color text-decoration-none fw-bold">Privacy Policy</a>
                </label>
                @error('terms')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-univ py-2 fw-bold shadow-sm">
                {{ __('Create My Account') }}
            </button>
        </div>

        <div class="mt-4 text-center">
            <p class="mb-0">Already registered? <a href="{{ route('login') }}" class="text-decoration-none brand-color fw-semibold">Login here</a></p>
        </div>
    </form>
</x-guest-layout>
