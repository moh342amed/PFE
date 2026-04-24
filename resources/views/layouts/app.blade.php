<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} - ElOued University</title>
        
        <!-- Favicon / Branding -->
        <link rel="shortcut icon" href="{{ asset('idGvXOVIAG_logos.jpeg') }}" type="image/jpeg">
        <link rel="icon" href="{{ asset('idGvXOVIAG_logos.jpeg') }}" type="image/jpeg">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
        
        <!-- SweetAlert2 -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        
        <!-- Bootstrap 5 -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

        <style>
            :root {
                --brand-dark: #0f172a; /* Slate 900 */
                --brand-accent: #2e7d32; /* Keeping university green for accents */
                --brand-hover: #1e293b; /* Slate 800 */
            }
            body {
                font-family: 'Inter', sans-serif;
                background-color: #1a202c; /* Lighter Midnight Blue for better visibility */
                color: #f1f5f9;
                min-height: 100vh;
                position: relative;
            }
            .page-video-container {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                z-index: -2;
                pointer-events: none;
            }
            .page-video-bg {
                width: 100%;
                height: 100%;
                object-fit: cover;
                opacity: 0.6;
            }
            .page-kernel-overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: radial-gradient(circle at center, rgba(15, 23, 42, 0.1) 0%, rgba(15, 23, 42, 0.45) 100%);
                backdrop-filter: blur(8px);
                z-index: -1;
            }
            .navbar-univ {
                background: transparent !important;
                border-bottom: 1px solid rgba(255,255,255,0.1);
                padding: 0.8rem 0;
                position: relative;
                overflow: visible !important; /* Allow dropdowns to show */
                z-index: 1050; /* Stay above everything else */
            }
            .navbar-video-container {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                z-index: -1;
                pointer-events: none;
            }
            .navbar-video-bg {
                width: 100%;
                height: 100%;
                object-fit: cover;
                opacity: 0.5; /* Reduced for better contrast */
            }
            .navbar-kernel-overlay {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: linear-gradient(to right, 
                    rgba(15, 23, 42, 0.98) 0%, 
                    rgba(15, 23, 42, 0.85) 50%, 
                    rgba(15, 23, 42, 0.98) 100%);
                backdrop-filter: blur(10px); /* Increased blur */
                z-index: 0;
            }
            .navbar-univ .container {
                position: relative;
                z-index: 1;
            }
            .page-video-container {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                z-index: -10; /* Deepest layer */
                pointer-events: none;
            }
            .page-video-bg {
                width: 100%;
                height: 100%;
                object-fit: cover;
                opacity: 0.5; /* Atmospheric balance */
            }
            .page-kernel-overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: radial-gradient(circle at center, rgba(15, 23, 42, 0.75) 0%, rgba(15, 23, 42, 0.99) 100%);
                backdrop-filter: blur(15px);
                z-index: -5; /* Middle layer (covers & blurs the video) */
            }
            .navbar-univ .nav-link {
                color: #ffffff !important; /* Pure white for max contrast */
                font-weight: 600;
                padding: 0.5rem 1.2rem !important;
                border-radius: 50px;
                transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
                text-shadow: 0 1px 3px rgba(0,0,0,0.5); /* Added text-shadow for readability */
            }
            .navbar-univ .nav-link:hover {
                color: white !important;
                background: rgba(255,255,255,0.15);
            }
            .navbar-univ .nav-link.active {
                color: white !important;
                background: var(--brand-accent) !important;
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.4);
            }
            .navbar-brand img {
                transition: transform 0.3s ease;
            }
            .navbar-brand:hover img {
                transform: scale(1.05);
            }
            .dropdown-menu {
                border: none;
                box-shadow: 0 10px 40px rgba(0,0,0,0.12);
                border-radius: 12px;
                padding: 0.75rem;
            }
            .dropdown-item {
                border-radius: 8px;
                padding: 0.6rem 1rem;
                transition: all 0.2s ease;
            }
            .dropdown-item:hover {
                background-color: #f1f5f9;
                color: var(--brand-accent);
            }
            .card {
                border: 1px solid rgba(255, 255, 255, 0.12);
                border-radius: 20px;
                background: rgba(255, 255, 255, 0.7); /* More transparent Glass */
                backdrop-filter: blur(20px) saturate(180%);
                box-shadow: 0 8px 32px rgba(0,0,0,0.3);
                color: #1e293b;
            }
            .card-header {
                background: rgba(255, 255, 255, 0.4) !important;
                border-bottom: 1px solid rgba(255, 255, 255, 0.1);
                backdrop-filter: blur(10px);
            }
            .table {
                background: transparent !important;
                --bs-table-bg: transparent !important;
                --bs-table-hover-bg: rgba(255, 255, 255, 0.2) !important;
                color: inherit !important;
            }
            .table-hover tbody tr:hover {
                background-color: rgba(255, 255, 255, 0.2) !important;
                transition: background-color 0.2s ease;
            }
            .bg-light {
                background: rgba(255, 255, 255, 0.3) !important;
                backdrop-filter: blur(5px);
            }
            .bg-brand-green-glass {
                background: rgba(46, 125, 50, 0.8) !important;
                backdrop-filter: blur(15px);
                color: white !important;
                border: 1px solid rgba(255,255,255,0.2) !important;
            }
            .bg-brand-green-header {
                background: rgba(46, 125, 50, 0.85) !important;
                color: white !important;
            }
            .brand-green { color: var(--brand-accent); }
            .bg-brand-green { background-color: var(--brand-accent); }
            .btn-univ {
                background-color: var(--brand-accent);
                color: white;
                border-radius: 50px;
                padding: 0.6rem 1.5rem;
                font-weight: 600;
                transition: all 0.3s ease;
            }
            .btn-univ:hover {
                background-color: #1b5e20;
                transform: translateY(-2px);
                box-shadow: 0 5px 15px rgba(27, 94, 32, 0.3);
            }

            /* Notification Item Style */
            .notification-item {
                border: 1px solid transparent;
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            }
            .notification-item:hover {
                background: rgba(255, 255, 255, 0.5);
                border-color: rgba(255, 255, 255, 0.2);
                transform: translateX(5px);
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            }

            /* --- Responsive Utilities --- */
            @media (max-width: 768px) {
                h2 { font-size: 1.5rem !important; }
                .card { border-radius: 12px; }
                .container-fluid { padding-left: 1rem; padding-right: 1rem; }
            }

            /* Smart Table-to-Card Transformation */
            @media (max-width: 767px) {
                .responsive-card-table thead { display: none; }
                .responsive-card-table tr { 
                    display: block; 
                    margin-bottom: 1.25rem; 
                    border: 1px solid rgba(255, 255, 255, 0.1); 
                    border-radius: 20px; 
                    padding: 1.5rem;
                    background: rgba(255, 255, 255, 0.7); /* Glassy rows on mobile */
                    backdrop-filter: blur(15px);
                    box-shadow: 0 8px 32px rgba(0,0,0,0.1);
                }
                .responsive-card-table td { 
                    display: flex; 
                    justify-content: space-between; 
                    align-items: flex-start; 
                    padding: 0.85rem 0 !important;
                    border-bottom: 1px solid rgba(0, 0, 0, 0.05) !important;
                    text-align: right;
                }
                .responsive-card-table td:last-child { border-bottom: none !important; }
                .responsive-card-table td::before {
                    content: attr(data-label);
                    font-weight: 700;
                    text-align: left;
                    color: #64748b;
                    font-size: 0.7rem;
                    text-transform: uppercase;
                    min-width: 110px;
                    margin-right: 1rem;
                    padding-top: 0.2rem;
                }
                .responsive-card-table td.no-label::before { content: none; }
                .responsive-card-table td.no-label { 
                    display: block;
                    justify-content: center; 
                    width: 100%; 
                    text-align: center !important;
                    background: rgba(255, 255, 255, 0.3); /* Subtler glassy inner card */
                    margin-top: 1rem;
                    border-radius: 12px;
                    border: none !important;
                    padding: 1rem !important;
                }
            }
        </style>
    </head>
    <body class="antialiased">
        <!-- Cinematic Video Background (Visible on all devices) -->
        <div class="page-video-container" style="background: linear-gradient(rgba(15, 23, 42, 0.7), rgba(15, 23, 42, 0.9)), url('{{ asset('idGvXOVIAG_logos.jpeg') }}') center/cover no-repeat;">
            <video id="pageVideo" class="page-video-bg" muted playsinline loop preload="metadata" poster="{{ asset('idGvXOVIAG_logos.jpeg') }}"></video>
            <div class="page-kernel-overlay"></div>
        </div>

        @include('layouts.navigation')

        <div class="container-fluid">
            <div class="row">
                <!-- Main Content -->
                <main class="col-md-11 mx-auto py-4">
                    <!-- Page Heading -->
                    @isset($header)
                        <div class="mb-5 text-center text-md-start">
                            <div class="glass-header-pill">
                                <h2 class="fw-bold h4 mb-0">
                                    {{ $header }}
                                </h2>
                            </div>
                        </div>
                    @endisset

                    <!-- Global Feedback handled by SweetAlert2 JS at bottom -->

                    {{ $slot }}
                </main>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Sequential Video Playlist (videos + videos2)
                const videos = [
                    "{{ asset('videos/9569478-uhd_4096_2160_25fps.mp4') }}",
                    "{{ asset('videos/14771471_3840_2160_60fps.mp4') }}",
                    "{{ asset('videos/7989528-hd_1920_1080_25fps.mp4') }}",
                    "{{ asset('videos/14901858_1920_1080_30fps.mp4') }}",
                    "{{ asset('videos/5449933-uhd_3840_2160_30fps.mp4') }}",
                    "{{ asset('videos/8197039-hd_1920_1080_25fps.mp4') }}",
                    "{{ asset('videos/14493926_1920_1080_60fps.mp4') }}",
                    "{{ asset('videos/8165469-uhd_3840_2160_25fps.mp4') }}",
                    "{{ asset('videos/15642984-hd_1920_1080_30fps.mp4') }}",
                    "{{ asset('videos/4122166-hd_1920_1080_30fps.mp4') }}",
                    "{{ asset('videos/7792020-hd_1920_1080_25fps.mp4') }}",
                    "{{ asset('videos/12510397-hd_1920_1080_30fps.mp4') }}",
                    "{{ asset('videos2/4463352-uhd_3840_2160_25fps.mp4') }}",
                    "{{ asset('videos2/6787194-uhd_3840_2160_30fps.mp4') }}",
                    "{{ asset('videos2/5881529-uhd_4096_2160_25fps.mp4') }}",
                    "{{ asset('videos2/5190556-uhd_4096_2160_25fps.mp4') }}",
                    "{{ asset('videos2/6787190-uhd_3840_2160_30fps.mp4') }}",
                    "{{ asset('videos2/7791922-hd_1920_1080_25fps.mp4') }}",
                    "{{ asset('videos2/8472460-hd_1920_1080_25fps.mp4') }}",
                    "{{ asset('videos2/5190551-uhd_4096_2160_25fps.mp4') }}",
                    "{{ asset('videos2/3944843-uhd_4096_2160_25fps.mp4') }}",
                    "{{ asset('videos2/15298045_1920_1080_30fps.mp4') }}",
                    "{{ asset('videos2/6176544-uhd_4096_2160_30fps.mp4') }}",
                    "{{ asset('videos2/6177017-uhd_4096_2160_30fps.mp4') }}",
                    "{{ asset('videos2/6787195-uhd_3840_2160_30fps.mp4') }}",
                    "{{ asset('videos2/3945141-uhd_4096_2160_25fps.mp4') }}"
                ];

                const pageVideo = document.getElementById('pageVideo');
                const navVideo = document.getElementById('navVideo');
                let currentIdx = Math.floor(Math.random() * videos.length);
                
                function playNextVideo(element) {
                    if (!element) return;
                    currentIdx = (currentIdx + 1) % videos.length;
                    element.src = videos[currentIdx];
                    element.play().catch(e => console.log('Playback error', e));
                }

                // Initial playback
                if (pageVideo) {
                    pageVideo.src = videos[currentIdx];
                    pageVideo.play().catch(e => console.log('Autoplay failed', e));
                    pageVideo.addEventListener('ended', () => playNextVideo(pageVideo));
                }
                
                if (navVideo) {
                    navVideo.src = videos[currentIdx];
                    navVideo.play().catch(e => console.log('Autoplay failed', e));
                    navVideo.addEventListener('ended', () => playNextVideo(navVideo));
                }

                // 5-Second Rotation Timer for Global Background
                setInterval(() => {
                    playNextVideo(pageVideo);
                    playNextVideo(navVideo);
                }, 5000);

                const swalConfig = {
                    confirmButtonColor: '#2e7d32', // Matches brand-accent
                    cancelButtonColor: '#d33'
                };

                @if (session('success'))
                    Swal.fire({
                        ...swalConfig,
                        icon: 'success',
                        title: 'Success!',
                        text: "{{ session('success') }}",
                        showConfirmButton: false,
                        timer: 3000
                    });
                @endif

                @if (session('error'))
                    Swal.fire({
                        ...swalConfig,
                        icon: 'error',
                        title: 'Error!',
                        text: "{{ session('error') }}",
                    });
                @endif

                @if (session('info'))
                    Swal.fire({
                        ...swalConfig,
                        icon: 'info',
                        title: 'Notice',
                        text: "{{ session('info') }}",
                    });
                @endif

                @if ($errors->any())
                    @php
                        $errorList = '<ul>';
                        foreach ($errors->all() as $error) {
                            $errorList .= '<li>' . addslashes($error) . '</li>';
                        }
                        $errorList .= '</ul>';
                    @endphp
                    Swal.fire({
                        ...swalConfig,
                        icon: 'error',
                        title: 'Validation Failed',
                        html: '{!! $errorList !!}',
                        confirmButtonText: 'Fix Errors'
                    });
                @endif

                // Global Delete Confirmation
                document.querySelectorAll('form.confirm-delete').forEach(form => {
                    form.addEventListener('submit', function(e) {
                        e.preventDefault();
                        const message = this.getAttribute('data-confirm') || 'Are you sure you want to delete this?';
                        
                        Swal.fire({
                            ...swalConfig,
                            title: 'Are you sure?',
                            text: message,
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Yes, delete it!',
                            cancelButtonText: 'No, cancel',
                            reverseButtons: true
                        }).then((result) => {
                            if (result.isConfirmed) {
                                this.submit();
                            }
                        });
                    });
                });
            });
        </script>
        @stack('modals')
    </body>
</html>
