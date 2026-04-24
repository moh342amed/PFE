<section>
    <header class="mb-4">
        <h3 class="h4 fw-bold text-danger mb-2">
            {{ __('Delete Account') }}
        </h3>

        <p class="text-muted small">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <button 
        type="button" 
        class="btn btn-danger px-4 py-2 shadow-sm fw-bold"
        data-bs-toggle="modal" 
        data-bs-target="#confirmUserDeletionModal"
    >
        {{ __('Delete Account') }}
    </button>

    <!-- Bootstrap 5 Modal -->
    <div class="modal fade" id="confirmUserDeletionModal" tabindex="-1" aria-labelledby="confirmUserDeletionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <form method="post" action="{{ route('profile.destroy') }}" class="p-4">
                    @csrf
                    @method('delete')

                    <div class="modal-header border-0 pb-0">
                        <h4 class="modal-title fw-bold text-dark" id="confirmUserDeletionModalLabel">{{ __('Are you sure?') }}</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body pt-3">
                        <p class="text-muted small mb-4">
                            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                        </p>

                        <div class="mb-3">
                            <label for="password" class="form-label fw-semibold small text-uppercase text-muted">{{ __('Password') }}</label>
                            <input 
                                id="password" 
                                name="password" 
                                type="password" 
                                class="form-control form-control-lg border-0 bg-light shadow-sm" 
                                placeholder="{{ __('Enter password to confirm') }}"
                                required
                            >
                            @if($errors->userDeletion->has('password'))
                                <div class="text-danger small mt-1">{{ $errors->userDeletion->first('password') }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="modal-footer border-0 pt-0 gap-2">
                        <button type="button" class="btn btn-light px-4 py-2 fw-semibold" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                        <button type="submit" class="btn btn-danger px-4 py-2 shadow-sm fw-bold">{{ __('Permanently Delete Account') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
