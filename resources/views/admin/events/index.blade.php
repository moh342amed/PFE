<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <span>{{ __('Manage Events') }}</span>
            <a href="{{ route('admin.events.create') }}" class="btn btn-univ btn-sm rounded-pill shadow-sm">
                <i class="bi bi-plus-lg me-2"></i> Add New Event
            </a>
        </div>
    </x-slot>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm mb-4">
            <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive border-0">
                <table class="table table-hover align-middle mb-0 responsive-card-table">
                    <thead class="bg-light d-none d-md-table-header-group">
                        <tr>
                            <th class="ps-4 py-3">Event Title</th>
                            <th class="py-3">Type</th>
                            <th class="py-3">Speaker</th>
                            <th class="py-3">Date & Time</th>
                            <th class="py-3 text-center">Seats</th>
                            <th class="py-3 text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($events as $event)
                            <tr class="border-bottom">
                                <td class="ps-4" data-label="Event Title">
                                    <div class="fw-bold text-success">{{ $event->title }}</div>
                                    <small class="text-muted"><i class="bi bi-geo-alt me-1"></i> {{ $event->location }}</small>
                                </td>
                                <td data-label="Type">
                                    <span class="badge border p-2 py-1 fw-bold small rounded-pill" 
                                          style="background-color: rgba(46, 125, 50, 0.1); color: #2e7d32;">
                                        {{ $event->type }}
                                    </span>
                                </td>
                                <td data-label="Speaker">{{ $event->speaker_name }}</td>
                                <td data-label="Date">
                                    <div class="fw-semibold">{{ $event->date_time->format('M d, Y') }}</div>
                                    <small class="text-muted">{{ $event->date_time->format('h:i A') }}</small>
                                </td>
                                <td class="text-center" data-label="Seat Progress">
                                    <div class="small mb-1 fw-bold">{{ $event->available_seats }} / {{ $event->total_seats }}</div>
                                    <div class="progress mt-1 mx-auto" style="height: 6px; width: 80px;">
                                        @php $perc = ($event->available_seats / $event->total_seats) * 100; @endphp
                                        <div class="progress-bar bg-success" role="progressbar" style="width: {{ $perc }}%"></div>
                                    </div>
                                </td>
                                <td class="text-end pe-4 no-label mt-3 mt-md-0 border-top pt-3 pt-md-0">
                                    <div class="btn-group shadow-sm rounded-pill overflow-hidden w-100 w-md-auto">
                                        <a href="{{ route('admin.events.export', $event) }}" class="btn btn-univ py-2" title="Export Attendance">
                                            <i class="bi bi-file-earmark-pdf"></i> <span class="d-md-none ms-1">Export</span>
                                        </a>
                                        <a href="{{ route('admin.events.edit', $event) }}" class="btn btn-univ border-start border-end border-white py-2">
                                            <i class="bi bi-pencil"></i> <span class="d-md-none ms-1">Edit</span>
                                        </a>
                                        <form action="{{ route('admin.events.destroy', $event) }}" method="POST" class="confirm-delete d-contents" data-confirm="Delete the event: '{{ $event->title }}'? This action cannot be undone.">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger py-2">
                                                <i class="bi bi-trash"></i> <span class="d-md-none ms-1">Delete</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="bi bi-calendar-x fs-1 opacity-25"></i>
                                    <p class="mt-3">No events found. Start by creating one!</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
