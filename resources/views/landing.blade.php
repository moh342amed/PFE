<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>University Event Management - ElOued University</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { 
            font-family: 'Inter', sans-serif; 
            background: #0f172a !important; /* Solid fallback to prevent "green page" */
            margin: 0;
            padding: 0;
            color: #f8fafc;
        }
        .hero-section {
            position: relative;
            min-height: 550px;
            display: flex;
            align-items: center;
            overflow: hidden;
            background-color: transparent;
            color: white;
            border-bottom-left-radius: 50px;
            border-bottom-right-radius: 50px;
        }
        .video-container {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
            background-color: #000;
        }
        .hero-video-player {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: opacity 1.5s ease-in-out;
            opacity: 0;
        }
        .hero-video-player.active {
            opacity: 1;
        }
        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(rgba(15, 23, 42, 0.6), rgba(15, 23, 42, 0.8)); /* Slate Dark overlay */
            z-index: 2;
        }
        .hero-content {
            position: relative;
            z-index: 3;
            width: 100%;
        }
        .page-bg-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            z-index: -10;
            background-color: #000;
        }
        .page-video-player {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: opacity 2s ease-in-out;
            opacity: 0;
        }
        .page-video-player.active {
            opacity: 1;
        }
        .glass-section {
            background: transparent !important;
            backdrop-filter: none;
            -webkit-backdrop-filter: none;
            border-top: none;
        }
        .navbar-univ-landing {
            background: transparent;
            backdrop-filter: none;
            border-bottom: none;
        }
        .footer-glass {
            background: rgba(0, 0, 0, 0.5) !important;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }
        .btn-univ {
            background-color: #2e7d32;
            color: white;
            border-radius: 30px;
            padding: 12px 30px;
            font-weight: 700;
            border: none;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            transition: all 0.3s ease;
        }
        .btn-univ:hover {
            background-color: #1b5e20;
            color: white;
            transform: translateY(-3px);
        }
        .event-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(5px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            overflow: hidden;
            transition: all 0.3s ease;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        .event-card:hover {
            transform: translateY(-10px);
            background: rgba(255, 255, 255, 0.9);
            box-shadow: 0 15px 40px rgba(0,0,0,0.2);
        }
        .badge-type {
            position: absolute;
            top: 20px;
            right: 20px;
            background: rgba(255,255,255,0.9);
            color: #2e7d32;
            padding: 8px 15px;
            border-radius: 30px;
            font-weight: 700;
            font-size: 0.8rem;
        }
        .navbar-brand fw-bold { color: #2e7d32 !important; }
        
        @media (max-width: 768px) {
            .hero-section { min-height: 450px; border-radius: 0 0 30px 30px; }
            .display-3 { font-size: 2.2rem !important; }
            .hero-content p { font-size: 1rem !important; padding: 0 1rem !important; }
            .hero-content .d-flex { flex-direction: column; padding: 0 2rem; }
            .hero-content .btn { width: 100%; margin-bottom: 0.5rem; }
            .navbar-univ-landing img { height: 50px; }
        }
    </style>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <!-- Global Background Video (videos2) - Double Buffered -->
    <div class="page-bg-container">
        <video id="page-bg-video-1" class="page-video-player active" autoplay muted playsinline preload="auto">
            <source src="{{ asset('videos2/15298045_1920_1080_30fps.mp4') }}" type="video/mp4">
        </video>
        <video id="page-bg-video-2" class="page-video-player" muted playsinline preload="auto"></video>
    </div>

    <nav class="navbar navbar-expand-lg navbar-light py-3 navbar-univ-landing">
        <div class="container d-flex justify-content-between align-items-center">
            <a class="navbar-brand" href="/">
                <img src="https://www.univ-eloued.dz/wp-content/uploads/2024/03/logouef-png.avif" alt="University Logo" height="75">
            </a>
            <div class="d-flex align-items-center">
                @auth
                    <a href="{{ route('dashboard') }}" class="btn btn-univ btn-sm px-4">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-sm btn-outline-success border-2 rounded-pill px-3 me-2">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-univ btn-sm px-3">Register</a>
                @endauth
            </div>
        </div>
    </nav>

    <header class="hero-section text-center">
        <div class="video-container">
            <video id="hero-video-1" class="hero-video-player active" autoplay muted playsinline preload="auto">
                <source src="{{ asset('videos/12510397-hd_1920_1080_30fps.mp4') }}" type="video/mp4">
            </video>
            <video id="hero-video-2" class="hero-video-player" muted playsinline preload="auto"></video>
        </div>
        <div class="hero-overlay"></div>
        <div class="container hero-content">
            <h1 class="display-3 fw-bold mb-3">Empowering Academic Growth</h1>
            <p class="lead mb-5 px-md-5">Discover, Register, and Participate in world-class seminars, workshops, and conferences at University of El Oued.</p>
            <div class="d-flex justify-content-center gap-3">
                <a href="#events" class="btn btn-light btn-lg rounded-pill px-5 py-3 fw-bold text-success shadow">Browse Events</a>
                <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg rounded-pill px-5 py-3 fw-bold shadow-sm">Get Started</a>
            </div>
        </div>
    </header>

    <section id="events" class="py-5 glass-section">
        <div class="container pb-5">
            <div class="row align-items-end mb-5">
                <div class="col-12 col-md-8 mb-4 mb-md-0 text-center text-md-start">
                    <h2 class="fw-bold mb-0">Upcoming Events</h2>
                    <p class="text-muted">Don't miss out on these academic opportunities</p>
                </div>
                <div class="col-12 col-md-4 text-center text-md-end">
                     <div class="dropdown">
                        <button class="btn btn-white shadow-sm dropdown-toggle rounded-pill px-4 w-100 w-md-auto" type="button" id="filterType" data-bs-toggle="dropdown">
                            <i class="bi bi-filter me-2"></i> Filter by Type
                        </button>
                        <ul class="dropdown-menu border-0 shadow mt-2 w-100">
                             <li><a class="dropdown-item" href="#">Seminar</a></li>
                             <li><a class="dropdown-item" href="#">Workshop</a></li>
                             <li><a class="dropdown-item" href="#">Conference</a></li>
                        </ul>
                     </div>
                </div>
            </div>

            <div class="row g-4">
                @foreach(\App\Models\Event::where('date_time', '>', now())->get() as $event)
                    <div class="col-md-4">
                        <script>console.log('📦 Event Card Rendering: "{{ $event->title }}" - Media: {{ $event->background_type }}');</script>
                        <div class="card event-card h-100 pb-3 shadow-sm border-0" style="border-radius: 20px; overflow: hidden;">
                            <div class="position-relative" style="height: 220px; overflow: hidden; background-color: #f8f9fa;">
                                @if($event->background_path)
                                    @if($event->background_type == 'video')
                                        <video autoplay muted loop playsinline preload="none" class="w-100 h-100" style="object-fit: cover; position: absolute; top: 0; left: 0;">
                                            <source src="{{ asset('storage/' . $event->background_path) }}" type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                    @else
                                        <img src="{{ asset('storage/' . $event->background_path) }}" class="card-img-top h-100 w-100" alt="{{ $event->title }}" style="object-fit: cover;">
                                    @endif
                                @else
                                    <img src="https://images.unsplash.com/photo-1540575861501-7ad058bc382d?auto=format&fit=crop&q=80" class="card-img-top h-100 w-100" alt="Default Event Image" style="object-fit: cover;">
                                @endif
                                <div class="position-absolute top-0 start-0 w-100 h-100 shadow-inset" style="background: linear-gradient(rgba(0,0,0,0.1), rgba(0,0,0,0.4)); pointer-events: none;"></div>
                                <span class="badge-type shadow-sm">{{ $event->type }}</span>
                            </div>
                            <div class="card-body p-4">
                                <h5 class="card-title fw-bold" style="color: #2e7d32;">{{ $event->title }}</h5>
                                <p class="card-text text-muted small">{{ Str::limit($event->description, 120) }}</p>
                                <div class="d-flex flex-column gap-2 mb-4">
                                    <div class="small"><i class="bi bi-person-circle me-2 text-success"></i><strong>{{ $event->speaker_name }}</strong></div>
                                    <div class="small"><i class="bi bi-geo-alt me-2 text-success"></i>{{ $event->location }}</div>
                                    <div class="small"><i class="bi bi-calendar-check me-2 text-success"></i>{{ $event->date_time->format('M d, Y - h:i A') }}</div>
                                    <div class="small"><i class="bi bi-people me-2 {{ $event->available_seats < 10 ? 'text-danger' : 'text-success' }}"></i>{{ $event->available_seats }} Seats Remaining</div>
                                </div>
                                <div class="d-grid">
                                    @auth
                                        <form action="{{ route('events.register', $event) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-univ w-100 py-2" {{ $event->available_seats <= 0 ? 'disabled' : '' }}>
                                                {{ $event->available_seats <= 0 ? 'Fully Booked' : 'Register Now' }}
                                            </button>
                                        </form>
                                    @else
                                        <a href="{{ route('login') }}" class="btn btn-univ w-100 py-2">Login to Register</a>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <footer class="footer-glass text-white py-5 mt-5">
        <div class="container text-center">
            <h4 class="fw-bold mb-4">ElOued University</h4>
            <p class="text-muted">Academic Event Management System &copy; 2026. All Rights Reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Combined Infinite Playlist from videos and videos2
        const allVideos = [
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

        class VideoDoubleBuffer {
            constructor(playerIds, videoList, startOffset = 0) {
                this.players = playerIds.map(id => document.getElementById(id));
                this.videoList = videoList;
                this.activeIndex = 0;
                this.currentVideoIndex = startOffset % videoList.length;
                this.autoSwapTimer = null;
                
                this.setupPlayers();
            }

            setupPlayers() {
                this.players.forEach((player, index) => {
                    player.onended = () => this.swap();
                    player.onplay = () => this.preloadNext((index + 1) % this.players.length);
                });
            }

            preloadNext(nextPlayerIndex) {
                const nextPlayer = this.players[nextPlayerIndex];
                const nextVideoIdx = (this.currentVideoIndex + 1) % this.videoList.length;
                const nextSrc = this.videoList[nextVideoIdx];
                
                nextPlayer.src = nextSrc;
                nextPlayer.load();
                console.log(`[VideoBuffer] Preloading next video: ${nextSrc.split('/').pop()}`);
            }

            swap() {
                // Clear any existing timer to avoid double-swapping
                if (this.autoSwapTimer) clearInterval(this.autoSwapTimer);

                const prevIndex = this.activeIndex;
                this.activeIndex = (this.activeIndex + 1) % this.players.length;
                this.currentVideoIndex = (this.currentVideoIndex + 1) % this.videoList.length;

                const currentPlayer = this.players[this.activeIndex];
                const prevPlayer = this.players[prevIndex];

                console.log(`[VideoBuffer] Swapping to: ${this.videoList[this.currentVideoIndex].split('/').pop()}`);

                currentPlayer.classList.add('active');
                prevPlayer.classList.remove('active');

                currentPlayer.play().catch(e => {
                    console.error("Playback failed, skipping...", e);
                    this.swap();
                });

                // Start a new 5-second timer
                this.autoSwapTimer = setInterval(() => this.swap(), 5000);
            }

            init() {
                const firstPlayer = this.players[this.activeIndex];
                firstPlayer.src = this.videoList[this.currentVideoIndex];
                firstPlayer.play().catch(e => console.log("Initial playback prevented", e));
                
                // Start the 5-second rotation timer
                this.autoSwapTimer = setInterval(() => this.swap(), 5000);
            }
        }

        // Randomize the starting video for every refresh
        const randomStartHero = Math.floor(Math.random() * allVideos.length);
        const randomStartPage = Math.floor(Math.random() * allVideos.length);

        const heroBuffer = new VideoDoubleBuffer(['hero-video-1', 'hero-video-2'], allVideos, randomStartHero);
        const pageBuffer = new VideoDoubleBuffer(['page-bg-video-1', 'page-bg-video-2'], allVideos, randomStartPage);

        window.addEventListener('DOMContentLoaded', () => {
             heroBuffer.init();
             pageBuffer.init();
        });

        // Global Feedback Handler
        document.addEventListener('DOMContentLoaded', function() {
            const swalConfig = { confirmButtonColor: '#2e7d32', cancelButtonColor: '#d33' };
            @if (session('success')) Swal.fire({ ...swalConfig, icon: 'success', title: 'Success!', text: "{{ session('success') }}", showConfirmButton: false, timer: 3000 }); @endif
            @if (session('error')) Swal.fire({ ...swalConfig, icon: 'error', title: 'Error!', text: "{{ session('error') }}" }); @endif
            @if (session('info')) Swal.fire({ ...swalConfig, icon: 'info', title: 'Notice', text: "{{ session('info') }}" }); @endif
        });
    </script>
</body>
</html>
