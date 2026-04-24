<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <span>{{ __('My Event Applications') }}</span>
        </div>
    </x-slot>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm mb-4">
            <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
        </div>
    @endif

    <div class="card border-0 shadow-sm overflow-hidden">
        <div class="card-header bg-brand-green py-3">
             <h5 class="fw-bold mb-0 text-white"><i class="bi bi-file-earmark-text me-2"></i> Submissions List</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive border-0">
                <table class="table table-hover align-middle mb-0 responsive-card-table">
                    <thead class="bg-light d-none d-md-table-header-group">
                        <tr>
                            <th class="ps-4">Event Title</th>
                            <th>Status</th>
                            <th>Submission Date</th>
                            <th class="pe-4 text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($registrations as $reg)
                            <tr class="border-bottom">
                                <td class="ps-4" data-label="Event Title">
                                    {{-- Desktop Version --}}
                                    <div class="d-none d-md-block">
                                        <div class="fw-bold">{{ $reg->event->title }}</div>
                                        <small class="text-muted"><i class="bi bi-person me-1"></i> {{ $reg->event->speaker_name }}</small>
                                    </div>
                                    {{-- Mobile Version --}}
                                    <div class="d-md-none text-end w-100">
                                        <div class="fw-bold">{{ $reg->event->title }}</div>
                                        <small class="text-muted"><i class="bi bi-person me-1"></i> {{ $reg->event->speaker_name }}</small>
                                    </div>
                                </td>
                                <td data-label="Status">
                                    <div class="d-flex justify-content-md-start justify-content-end w-100">
                                        @if($reg->status == 'pending')
                                            <div class="d-inline-block px-3 py-1 bg-warning bg-opacity-10 text-warning rounded-pill border border-warning small fw-bold">
                                                <i class="bi bi-clock-history me-1"></i> Pending approval
                                            </div>
                                        @elseif($reg->status == 'approved')
                                            <div class="d-inline-block px-3 py-1 bg-success bg-opacity-10 text-success rounded-pill border border-success small fw-bold">
                                                <i class="bi bi-check-circle me-1"></i> Approved
                                            </div>
                                        @else
                                            <div class="d-inline-block px-3 py-1 bg-danger bg-opacity-10 text-danger rounded-pill border border-danger small fw-bold">
                                                <i class="bi bi-x-circle me-1"></i> Rejected
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td data-label="Submitted" class="text-end text-md-start">{{ $reg->created_at->format('M d, Y') }}</td>
                                <td class="pe-4 text-end no-label">
                                    @if($reg->status == 'approved')
                                        <a href="{{ route('registrations.ticket', $reg) }}" class="btn btn-univ btn-sm rounded-pill px-3 shadow-sm w-100 w-md-auto">
                                            <i class="bi bi-qr-code me-1"></i> QR Ticket
                                        </a>
                                    @else
                                        <span class="text-muted small d-none d-md-inline">N/A</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-5 text-muted h6">
                                    <i class="bi bi-search fs-1 opacity-25"></i>
                                    <p class="mt-3 mb-0">You haven't applied for any events yet.</p>
                                    <a href="/" class="btn btn-link text-success">Browse Events Now</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
