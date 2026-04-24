<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <span>{{ __('User Management') }}</span>
        </div>
    </x-slot>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm mb-4">
            <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger border-0 shadow-sm mb-4">
            <i class="bi bi-exclamation-triangle me-2"></i> {{ session('error') }}
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive border-0">
                <table class="table table-hover align-middle mb-0 responsive-card-table">
                    <thead class="bg-light d-none d-md-table-header-group">
                        <tr>
                            <th class="ps-4 py-3">User</th>
                            <th class="py-3">Role</th>
                            <th class="py-3">University ID</th>
                            <th class="py-3">Joined Date</th>
                            <th class="py-3 text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr class="border-bottom">
                                <td class="ps-4" data-label="User">
                                    {{-- Desktop Version --}}
                                    <div class="d-none d-md-block">
                                        <div class="fw-bold text-dark">{{ $user->name }}</div>
                                        <div class="small text-muted">{{ $user->email }}</div>
                                    </div>
                                    {{-- Mobile Version --}}
                                    <div class="d-md-none text-end w-100">
                                        <div class="fw-bold text-dark">{{ $user->name }}</div>
                                        <div class="small text-muted">{{ $user->email }}</div>
                                    </div>
                                </td>
                                <td data-label="Role">
                                    <div class="d-flex justify-content-md-start justify-content-end w-100">
                                        <span class="badge border p-2 py-1 fw-bold small rounded-pill" 
                                              style="background-color: {{ $user->role == 'admin' ? 'rgba(220, 53, 69, 0.1)' : 'rgba(13, 110, 253, 0.1)' }}; 
                                                     color: {{ $user->role == 'admin' ? '#dc3545' : '#0d6efd' }};">
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    </div>
                                </td>
                                <td data-label="ID" class="text-end text-md-start"><code class="text-dark">{{ $user->university_id }}</code></td>
                                <td data-label="Joined" class="text-end text-md-start">{{ $user->created_at->format('M d, Y') }}</td>
                                <td class="text-end pe-4 no-label">
                                    <div class="d-flex justify-content-md-end justify-content-center w-100 mt-2 mt-md-0">
                                        @if($user->id !== auth()->id() && $user->role !== 'admin')
                                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="confirm-delete d-contents" data-confirm="Are you sure you want to delete the user: '{{ $user->name }}'? All their registrations will also be removed.">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger rounded-pill px-4 w-100 w-md-auto shadow-sm">
                                                    <i class="bi bi-trash me-1"></i> Delete User
                                                </button>
                                            </form>
                                        @else
                                            <div class="badge bg-light text-muted py-2 px-3 rounded-pill border w-100 w-md-auto">
                                                <i class="bi bi-shield-lock me-1"></i> System Protected
                                            </div>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white py-3 border-0">
            {{ $users->links() }}
        </div>
    </div>
</x-app-layout>
