<x-app-layout>
    <x-slot name="header">
        {{ __('Admin Analytics Dashboard') }}
    </x-slot>

    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body p-3 p-md-4">
                    <div class="d-flex align-items-center flex-column flex-md-row text-center text-md-start">
                        <div class="bg-primary bg-opacity-10 p-2 p-md-3 rounded-3 mb-2 mb-md-0 me-md-3">
                            <i class="bi bi-calendar-event text-primary fs-5 fs-md-4"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-0 uppercase fw-bold" style="font-size: 0.65rem;">Events</h6>
                            <h4 class="fw-bold mb-0">{{ $stats['total_events'] }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body p-3 p-md-4">
                    <div class="d-flex align-items-center flex-column flex-md-row text-center text-md-start">
                        <div class="bg-success bg-opacity-10 p-2 p-md-3 rounded-3 mb-2 mb-md-0 me-md-3">
                            <i class="bi bi-person-check text-success fs-5 fs-md-4"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-0 uppercase fw-bold" style="font-size: 0.65rem;">Registrations</h6>
                            <h4 class="fw-bold mb-0">{{ $stats['total_registrations'] }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body p-3 p-md-4">
                    <div class="d-flex align-items-center flex-column flex-md-row text-center text-md-start">
                        <div class="bg-warning bg-opacity-10 p-2 p-md-3 rounded-3 mb-2 mb-md-0 me-md-3">
                            <i class="bi bi-hourglass-split text-warning fs-5 fs-md-4"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-0 uppercase fw-bold" style="font-size: 0.65rem;">Pending</h6>
                            <h4 class="fw-bold mb-0">{{ $stats['pending_requests'] }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body p-3 p-md-4">
                    <div class="d-flex align-items-center flex-column flex-md-row text-center text-md-start">
                        <div class="bg-info bg-opacity-10 p-2 p-md-3 rounded-3 mb-2 mb-md-0 me-md-3">
                            <i class="bi bi-people text-info fs-5 fs-md-4"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-0 uppercase fw-bold" style="font-size: 0.65rem;">Users</h6>
                            <h4 class="fw-bold mb-0">{{ $stats['active_users'] }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3 border-0">
                    <h5 class="fw-bold mb-0">Registration Trends</h5>
                </div>
                <div class="card-body py-4">
                    <canvas id="registrationChart" style="max-height: 320px;"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100 overflow-hidden">
                <div class="card-header bg-brand-green-header py-3">
                    <h5 class="fw-bold mb-0 text-white"><i class="bi bi-fire me-2"></i> Popular Events</h5>
                </div>
                <div class="card-body p-0">
                    <div class="p-3">
                        @foreach($popularEvents as $index => $event)
                            <div class="notification-item p-3 mb-2 rounded-4 transition-all">
                                <div class="d-flex align-items-center">
                                    <div class="bg-{{ $index == 0 ? 'warning' : 'light' }} bg-opacity-10 p-2 rounded-circle me-3 border border-{{ $index == 0 ? 'warning' : 'secondary' }} border-opacity-25 text-center" style="width: 40px; height: 40px;">
                                        @if($index == 0)
                                            <i class="bi bi-trophy-fill text-warning"></i>
                                        @else
                                            <span class="small fw-bold text-muted">#{{ $index + 1 }}</span>
                                        @endif
                                    </div>
                                    <div class="flex-grow-1 overflow-hidden">
                                        <h6 class="mb-0 text-dark small fw-bold text-truncate">{{ $event->title }}</h6>
                                        <div class="d-flex justify-content-between align-items-center mt-1">
                                            <span class="badge bg-light text-muted border-0 p-1 px-2" style="font-size: 0.6rem;">{{ $event->type }}</span>
                                            <small class="fw-bold text-success" style="font-size: 0.75rem;">
                                                <i class="bi bi-people-fill me-1"></i> {{ $event->registrations_count }}
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('registrationChart').getContext('2d');
            
            // Premium Gradient
            const gradient = ctx.createLinearGradient(0, 0, 0, 400);
            gradient.addColorStop(0, 'rgba(46, 125, 50, 0.4)');
            gradient.addColorStop(1, 'rgba(46, 125, 50, 0)');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($trends['labels']) !!},
                    datasets: [{
                        label: 'Registrations',
                        data: {!! json_encode($trends['data']) !!},
                        borderColor: '#2e7d32',
                        backgroundColor: gradient,
                        fill: true,
                        tension: 0.4,
                        borderWidth: 3,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#2e7d32',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { precision: 0, color: '#94a3b8' },
                            grid: { color: 'rgba(148, 163, 184, 0.1)' }
                        },
                        x: {
                            ticks: { color: '#94a3b8' },
                            grid: { display: false }
                        }
                    }
                }
            });
        });
    </script>
</x-app-layout>
