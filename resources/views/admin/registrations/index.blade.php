<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <span>{{ __('Manage Registrations') }}</span>
        </div>
    </x-slot>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm mb-4">
            <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
        </div>
    @endif

    <div class="row g-3 mb-4">
        <div class="col-6 col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary bg-opacity-10 p-2 rounded-3 me-3">
                            <i class="bi bi-person-plus text-primary fs-5"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-0 small uppercase fw-bold" style="font-size: 0.6rem;">Total Applications</h6>
                            <h4 class="fw-bold mb-0 text-dark">{{ $registrations->count() }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-4">
            <div class="card border-0 shadow-sm border-start border-warning border-4">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center">
                        <div class="bg-warning bg-opacity-10 p-2 rounded-3 me-3">
                            <i class="bi bi-hourglass-split text-warning fs-5"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-0 small uppercase fw-bold" style="font-size: 0.6rem;">Awaiting Action</h6>
                            <h4 class="fw-bold mb-0 text-warning">{{ $registrations->where('status', 'pending')->count() }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card border-0 shadow-sm border-start border-success border-4">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center">
                        <div class="bg-success bg-opacity-10 p-2 rounded-3 me-3">
                            <i class="bi bi-check-all text-success fs-5"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-0 small uppercase fw-bold" style="font-size: 0.6rem;">Approved Seats</h6>
                            <h4 class="fw-bold mb-0 text-success">{{ $registrations->where('status', 'approved')->count() }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive border-0">
                <table class="table table-hover align-middle mb-0 responsive-card-table">
                    <thead class="bg-light d-none d-md-table-header-group">
                        <tr>
                            <th class="ps-4 py-3">User Details</th>
                            <th class="py-3">Event</th>
                            <th class="py-3">Status</th>
                            <th class="py-3">Date Applied</th>
                            <th class="py-3 text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($registrations as $reg)
                            <tr class="border-bottom transition-all">
                                <td class="ps-4" data-label="User">
                                    {{-- Desktop Version --}}
                                    <div class="d-none d-md-block">
                                        <div class="fw-bold text-dark">{{ $reg->user->name }}</div>
                                        <div class="small text-muted">{{ $reg->user->email }}</div>
                                        <span class="badge bg-secondary bg-opacity-10 text-secondary border-0 p-1 px-2 small mt-1" style="font-size: 0.6rem;">{{ strtoupper($reg->user->role) }}</span>
                                    </div>
                                    {{-- Mobile Version --}}
                                    <div class="d-md-none text-end w-100">
                                        <div class="fw-bold text-dark">{{ $reg->user->name }}</div>
                                        <div class="small text-muted">{{ $reg->user->email }}</div>
                                        <span class="badge bg-secondary bg-opacity-10 text-secondary border-0 p-1 px-2 small mt-1" style="font-size: 0.6rem;">{{ strtoupper($reg->user->role) }}</span>
                                    </div>
                                </td>
                                <td data-label="Event">
                                    {{-- Desktop Version --}}
                                    <div class="d-none d-md-block">
                                        <div class="fw-semibold text-success">{{ $reg->event->title }}</div>
                                        <small class="text-muted"><i class="bi bi-geo-alt me-1"></i> {{ $reg->event->location }}</small>
                                    </div>
                                    {{-- Mobile Version --}}
                                    <div class="d-md-none text-end w-100">
                                        <div class="fw-semibold text-success">{{ $reg->event->title }}</div>
                                        <small class="text-muted"><i class="bi bi-geo-alt me-1"></i> {{ $reg->event->location }}</small>
                                    </div>
                                </td>
                                <td data-label="Status">
                                    @if($reg->status == 'pending')
                                        <span class="badge bg-warning bg-opacity-10 text-warning border-0 p-2 py-1 fw-bold">
                                            <i class="bi bi-clock-history me-1"></i> Pending
                                        </span>
                                    @elseif($reg->status == 'approved')
                                        <span class="badge bg-success bg-opacity-10 text-success border-0 p-2 py-1 fw-bold">
                                            <i class="bi bi-check-circle me-1"></i> Approved
                                        </span>
                                    @else
                                        <span class="badge bg-danger bg-opacity-10 text-danger border-0 p-2 py-1 fw-bold">
                                            <i class="bi bi-x-circle me-1"></i> Rejected
                                        </span>
                                    @endif
                                </td>
                                <td data-label="Applied" class="text-muted small fw-semibold">
                                    {{ $reg->created_at->format('M d, Y') }}
                                </td>
                                <td class="text-end pe-4 no-label">
                                    @if($reg->status == 'pending')
                                        <button type="button" class="btn btn-sm btn-univ rounded-pill px-4 shadow-sm w-100 w-md-auto fw-bold" data-bs-toggle="modal" data-bs-target="#actionModal{{ $reg->id }}">
                                            Process Request <i class="bi bi-arrow-right-short ms-1"></i>
                                        </button>
                                    @else
                                        <div class="py-2 px-3 text-muted small fw-bold">
                                            <i class="bi bi-shield-check me-1"></i> Registration Processed
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <div class="py-4">
                                        <i class="bi bi-inbox-fill display-1 text-muted opacity-10"></i>
                                        <h5 class="mt-3 fw-bold text-muted">No Registration Requests</h5>
                                        <p class="text-muted small">New applications will appear here once submitted by students.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Push Modals to the root @stack in app.blade.php to prevent z-index/overflow issues --}}
    @push('modals')
        @foreach($registrations as $reg)
            @if($reg->status == 'pending')
                <div class="modal fade" id="actionModal{{ $reg->id }}" tabindex="-1" aria-labelledby="actionModalLabel{{ $reg->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content card border-0 shadow-lg text-start">
                            <div class="modal-header bg-brand-green-header border-0 py-3">
                                <h5 class="modal-title fw-bold text-white" id="actionModalLabel{{ $reg->id }}">
                                    <i class="bi bi-shield-check me-2"></i> Process Registration
                                </h5>
                                <button type="button" class="btn-close btn-close-white shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body p-4">
                                <div class="d-flex align-items-center mb-4">
                                    <div class="bg-success bg-opacity-10 p-3 rounded-circle me-3">
                                        <i class="bi bi-person text-success fs-4"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0 fw-bold text-dark">{{ $reg->user->name }}</h6>
                                        <small class="text-muted">{{ $reg->event->title }}</small>
                                    </div>
                                </div>
                                
                                <p class="text-muted small mb-4">Review this application and decide whether to approve or reject the student's seat in this event.</p>
                                
                                <div class="row g-2">
                                    <div class="col-6">
                                        <form action="{{ route('admin.registrations.update', $reg) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="approved">
                                            <button type="submit" class="btn btn-success w-100 py-3 rounded-4 shadow-sm border-0 fw-bold">
                                                <i class="bi bi-check-lg me-1"></i> Approve
                                            </button>
                                        </form>
                                    </div>
                                    <div class="col-6">
                                        <form action="{{ route('admin.registrations.update', $reg) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="rejected">
                                            <button type="submit" class="btn btn-outline-danger w-100 py-3 rounded-4 border-2 fw-bold">
                                                <i class="bi bi-x-lg me-1"></i> Reject
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    @endpush

    <style>
        .transition-all { transition: all 0.2s ease-in-out; }
    </style>
</x-app-layout>
