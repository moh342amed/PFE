<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <span>{{ __('Student Dashboard') }}</span>
            <span class="badge bg-brand-green p-2 px-3 rounded-pill fw-bold" style="font-size: 0.8rem;">
                <i class="bi bi-mortarboard me-1"></i> ID: {{ Auth::user()->university_id }}
            </span>
        </div>
    </x-slot>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm mb-4">
            <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
        </div>
    @endif

    @if(session('info'))
        <div class="alert alert-info border-0 shadow-sm mb-4">
            <i class="bi bi-info-circle me-2"></i> {{ session('info') }}
        </div>
    @endif

    <div class="row g-4 mb-4">
        <div class="col-12 col-md-6">
            <div class="card border-0 shadow-sm h-100 overflow-hidden">
                <div class="card-header bg-brand-green-header py-3">
                    <h5 class="fw-bold mb-0 text-white"><i class="bi bi-clock-history me-2"></i> My Application Summary</h5>
                </div>
                <div class="card-body py-4">
                    <div class="row text-center">
                        <div class="col-6 border-end">
                            <h2 class="fw-bold brand-green mb-0">{{ Auth::user()->registrations()->count() }}</h2>
                            <p class="text-muted small mb-0 uppercase fw-bold" style="font-size: 0.65rem;">Total Applied</p>
                        </div>
                        <div class="col-6">
                            <h2 class="fw-bold text-success mb-0">{{ Auth::user()->registrations()->where('status', 'approved')->count() }}</h2>
                            <p class="text-muted small mb-0 uppercase fw-bold" style="font-size: 0.65rem;">Approved</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 text-white text-center text-md-start">
            <div class="card border-0 shadow-sm h-100 bg-brand-green-glass">
                <div class="card-body p-4 d-flex align-items-center justify-content-between flex-column flex-md-row text-center text-md-start">
                    <div>
                        <h4 class="fw-bold mb-1">Welcome, {{ Auth::user()->name }}!</h4>
                        <p class="mb-0 opacity-75 small">Ready to discover new academic events today?</p>
                        <a href="/" class="btn btn-light btn-sm mt-3 rounded-pill px-4 fw-bold text-success border-0 shadow-sm">Explore Events <i class="bi bi-arrow-right ms-1"></i></a>
                    </div>
                    <i class="bi bi-rocket-takeoff display-3 opacity-25 mt-3 mt-md-0 d-none d-sm-block"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3 border-0">
                    <h5 class="fw-bold mb-0">Upcoming Schedule (Accepted)</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive border-0">
                       <table class="table table-hover align-middle mb-0 responsive-card-table">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4">Event</th>
                                    <th>Date</th>
                                    <th>Location</th>
                                    <th class="text-end pe-4">Ticket</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse(Auth::user()->registrations()->where('status', 'approved')->with('event')->get() as $reg)
                                    <tr class="border-bottom">
                                        <td class="ps-4" data-label="Event">
                                            {{-- Desktop Version --}}
                                            <div class="d-none d-md-block">
                                                <div class="fw-bold text-success">{{ $reg->event->title }}</div>
                                                <span class="badge bg-opacity-10 text-dark border p-1 fw-normal" style="font-size: 0.65rem;">{{ $reg->event->type }}</span>
                                            </div>
                                            {{-- Mobile Version --}}
                                            <div class="d-md-none text-end w-100">
                                                <div class="fw-bold text-success">{{ $reg->event->title }}</div>
                                                <span class="badge bg-opacity-10 text-dark border p-1 fw-normal" style="font-size: 0.65rem;">{{ $reg->event->type }}</span>
                                            </div>
                                        </td>
                                        <td data-label="Date" class="text-end text-md-start">
                                            <div class="small fw-semibold">{{ $reg->event->date_time->format('D, M d') }}</div>
                                            <div class="small text-muted">{{ $reg->event->date_time->format('h:i A') }}</div>
                                        </td>
                                        <td class="small text-end text-md-start" data-label="Location">{{ $reg->event->location }}</td>
                                        <td class="text-end pe-4 no-label">
                                            <div class="d-flex justify-content-md-end justify-content-center w-100 mt-2 mt-md-0">
                                                <a href="{{ route('registrations.ticket', $reg) }}" class="btn btn-sm btn-outline-success rounded-pill px-4 fw-bold w-100 w-md-auto">
                                                    <i class="bi bi-qr-code me-1"></i> View Ticket
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-5 text-muted">
                                            <p class="mb-0 small">No upcoming approved events yet.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100 overflow-hidden">
                <div class="card-header bg-brand-green-header py-3">
                    <h5 class="fw-bold mb-0 text-white"><i class="bi bi-bell-fill me-2"></i> Activity Feed</h5>
                </div>
                <div class="card-body p-0">
                     <div class="p-3">
                         @forelse(Auth::user()->notifications()->latest()->take(10)->get() as $notification)
                            <div class="notification-item p-3 mb-2 rounded-4 transition-all {{ $notification->read_at ? 'opacity-75' : 'bg-white shadow-sm border-start border-4 border-' . ($notification->data['type'] ?? 'primary') }}">
                                <div class="d-flex align-items-center">
                                    <div class="bg-{{ $notification->data['type'] ?? 'primary' }} bg-opacity-10 p-3 rounded-circle me-3 border border-{{ $notification->data['type'] ?? 'primary' }} border-opacity-25">
                                        <i class="bi {{ $notification->data['icon'] ?? 'bi-bell' }} text-{{ $notification->data['type'] ?? 'primary' }} fs-4"></i>
                                    </div>
                                    <div class="flex-grow-1 overflow-hidden">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <h6 class="mb-0 text-dark small fw-bold">
                                                @if(!$notification->read_at)
                                                    <span class="badge bg-danger p-1 rounded-circle me-1" style="width: 8px; height: 8px; display: inline-block;"> </span>
                                                @endif
                                                {{ $notification->data['status'] === 'approved' ? 'Registration Accepted' : 'Registration Rejected' }}
                                            </h6>
                                            <small class="text-muted italic" style="font-size: 0.65rem;">{{ $notification->created_at->diffForHumans() }}</small>
                                        </div>
                                        <p class="mb-0 text-muted small text-truncate">{{ $notification->data['message'] }}</p>
                                    </div>
                                </div>
                            </div>
                         @empty
                            <div class="py-5 text-center text-muted">
                                <i class="bi bi-bell-slash fs-1 opacity-25"></i>
                                <p class="mt-2 mb-0 small">No recent activity found.</p>
                            </div>
                         @endforelse
                     </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
