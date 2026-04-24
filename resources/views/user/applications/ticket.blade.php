<x-app-layout>
    <x-slot name="header">
        <div class="d-flex align-items-center">
            <a href="{{ route('my.applications') }}" class="btn btn-outline-secondary btn-sm me-3 border-0 rounded-circle">
                <i class="bi bi-arrow-left fs-5"></i>
            </a>
            <span>{{ __('Your Event Ticket') }}</span>
        </div>
    </x-slot>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <!-- Pro Ticket Container -->
                <div id="eventTicket" class="ticket-pro shadow-lg overflow-hidden mx-auto bg-white">
                    <!-- Ticket Header / Branding -->
                    <div class="ticket-header bg-brand-green p-4 text-white text-center position-relative">
                        <div class="bg-white d-inline-block p-2 rounded-3 mb-3 shadow-sm">
                            <img src="https://www.univ-eloued.dz/wp-content/uploads/2024/03/logouef-png.avif" alt="University Logo" height="60">
                        </div>
                        <h4 class="fw-bold mb-0 ls-1">OFFICIAL EVENT PASS</h4>
                        <div class="ticket-serial">#{{ str_pad($registration->id, 6, '0', STR_PAD_LEFT) }}-{{ strtoupper(substr($registration->user->name, 0, 2)) }}</div>
                    </div>

                    <!-- Ticket Main Body -->
                    <div class="ticket-body p-4 p-md-5">
                        <div class="row align-items-center mb-4">
                            <div class="col-12 text-center text-md-start">
                                <h1 class="display-6 fw-black text-brand-green mb-1 text-uppercase">{{ $registration->event->title }}</h1>
                                <span class="badge rounded-pill px-3 py-2 bg-success bg-opacity-10 text-success border border-success fw-bold">
                                    <i class="bi bi-patch-check-fill me-1"></i> VERIFIED ATTENDEE
                                </span>
                            </div>
                        </div>

                        <div class="row g-4 text-start">
                            <div class="col-12 col-md-6">
                                <label class="text-muted small fw-bold text-uppercase mb-1 ls-1">Attendee Name</label>
                                <div class="h5 fw-bold text-dark mb-0">{{ $registration->user->name }}</div>
                                <div class="small text-muted">{{ $registration->user->university_id }}</div>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="text-muted small fw-bold text-uppercase mb-1 ls-1">University Role</label>
                                <div class="h5 fw-bold text-success text-capitalize mb-0">{{ $registration->user->role }}</div>
                            </div>
                            <div class="col-12">
                                <label class="text-muted small fw-bold text-uppercase mb-1 ls-1">Venue Location</label>
                                <div class="fw-bold text-dark"><i class="bi bi-geo-alt-fill text-danger me-1"></i> {{ $registration->event->location }}</div>
                            </div>
                            <div class="col-12">
                                <label class="text-muted small fw-bold text-uppercase mb-1 ls-1">Event Schedule</label>
                                <div class="d-flex align-items-center">
                                    <div class="fw-bold text-dark me-3"><i class="bi bi-calendar3 text-primary me-1"></i> {{ $registration->event->date_time->format('M d, Y') }}</div>
                                    <div class="fw-bold text-muted small"><i class="bi bi-clock text-primary me-1"></i> {{ $registration->event->date_time->format('h:i A') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Perforation / Stub Divider -->
                    <div class="ticket-perforation">
                        <div class="punch-hole left"></div>
                        <div class="perforation-dashed"></div>
                        <div class="punch-hole right"></div>
                    </div>

                    <!-- Ticket Stub (The Validating Part) -->
                    <div class="ticket-stub p-4 bg-light text-center">
                        <div class="qr-container bg-white p-2 d-inline-block rounded-3 shadow-sm border mb-3">
                            {!! $qrCode !!}
                        </div>
                        <div class="px-4">
                            <div class="text-muted x-small fw-bold mb-3 ls-1">SCAN FOR OFFICIAL ENTRY</div>
                            <p class="text-muted mb-3" style="font-size: 0.7rem; line-height: 1.4;">This ticket is electronically generated and verified via the Official University Event Management System.</p>
                            <div class="d-flex align-items-center justify-content-center text-dark small fw-bold mb-2">
                                <i class="bi bi-shield-check-fill text-success me-2 fs-5"></i> 
                                VALID FOR ONE ENTRY ONLY
                            </div>
                            <div class="text-muted border-top pt-2" style="font-size: 0.6rem;">Issued: {{ now()->format('Y-m-d H:i') }}</div>
                        </div>
                    </div>
                </div>

                <!-- Action Controls (Hidden on Print) -->
                <div class="mt-5 text-center action-btns">
                    <div class="d-flex flex-column flex-md-row justify-content-center gap-3">
                        <button onclick="window.print()" class="btn btn-univ btn-lg rounded-pill px-5 shadow">
                            <i class="bi bi-printer me-2"></i> Print to PDF
                        </button>
                        <button onclick="saveTicketAsImage()" class="btn btn-outline-success btn-lg border-2 rounded-pill px-5">
                            <i class="bi bi-download me-2"></i> Save as Image
                        </button>
                    </div>
                    <p class="text-muted mt-4 small"><i class="bi bi-info-circle me-2"></i> Please present this QR code at the entrance for verification.</p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script>
        function saveTicketAsImage() {
            const ticket = document.getElementById('eventTicket');
            const btn = event.currentTarget;
            
            // Visual feedback
            const originalContent = btn.innerHTML;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Generating...';
            btn.disabled = true;

            // Prepare for capture (temp remove shadows)
            ticket.classList.remove('shadow-lg');

            html2canvas(ticket, {
                useCORS: true,
                scale: 3, // Premium ultra-high quality
                backgroundColor: '#ffffff',
                logging: false,
            }).then(canvas => {
                const link = document.createElement('a');
                link.download = `Ticket-{{ $registration->id }}-{{ Str::slug($registration->event->title) }}.png`;
                link.href = canvas.toDataURL('image/png');
                link.click();
                
                // Restore
                ticket.classList.add('shadow-lg');
                btn.innerHTML = originalContent;
                btn.disabled = false;
            }).catch(err => {
                console.error("Screenshot failed", err);
                ticket.classList.add('shadow-lg');
                btn.innerHTML = '<i class="bi bi-exclamation-triangle me-2"></i> Failed';
                setTimeout(() => {
                    btn.innerHTML = originalContent;
                    btn.disabled = false;
                }, 2000);
            });
        }
    </script>

    <style>
        .ticket-pro {
            min-height: 500px;
            border-radius: 24px;
            border: 1px solid rgba(0,0,0,0.05);
            max-width: 500px; /* Slimmer for better ticket feel */
            word-wrap: break-word;
        }
        .ticket-serial {
            background: rgba(0,0,0,0.2);
            display: inline-block;
            padding: 2px 12px;
            border-radius: 5px;
            font-family: 'Courier New', Courier, monospace;
            font-weight: bold;
            margin-top: 10px;
            font-size: 0.8rem;
        }
        .text-brand-green { color: #2e7d32; }
        .fw-black { font-weight: 900; }
        .ls-1 { letter-spacing: 1px; }
        .x-small { font-size: 0.65rem; }

        /* Perforation Styling */
        .ticket-perforation {
            display: flex;
            align-items: center;
            position: relative;
            height: 40px;
            background: #ffffff;
        }
        .perforation-dashed {
            flex-grow: 1;
            border-top: 2px dashed #ddd;
            margin: 0 5px;
        }
        .punch-hole {
            width: 30px;
            height: 30px;
            background: #f8fafc; /* Matches body background */
            border-radius: 50%;
            position: absolute;
            box-shadow: inset 0 3px 6px rgba(0,0,0,0.05);
        }
        .punch-hole.left { left: -15px; }
        .punch-hole.right { right: -15px; }

        /* Print Settings */
        @@media print {
            /* Hide UI Elements */
            body * { visibility: hidden; background: white !important; }
            .navbar-univ, .action-btns, .footer, .btn, .page-video-container { display: none !important; }
            
            /* Show only Ticket */
            #eventTicket, #eventTicket * { visibility: visible; }
            #eventTicket { 
                position: absolute; 
                left: 50%; 
                top: 50%; 
                transform: translate(-50%, -50%); 
                width: 100%;
                max-width: 600px;
                box-shadow: none !important; 
                border: 1px solid #000 !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            .ticket-header { background: #2e7d32 !important; color: white !important; }
            .punch-hole { border: 1px solid #ddd; background: white !important; }
            .row { display: flex !important; flex-wrap: wrap !important; }
            .col-6 { width: 50% !important; }
            .col-12 { width: 100% !important; }
            @@page { margin: 0; size: auto; }
        }
    </style>
</x-app-layout>
