<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} - University of El Oued</title>
        
        <!-- Favicon / Branding -->
        <link rel="shortcut icon" href="{{ asset('idGvXOVIAG_logos.jpeg') }}" type="image/jpeg">
        <link rel="icon" href="{{ asset('idGvXOVIAG_logos.jpeg') }}" type="image/jpeg">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
        
        <!-- Bootstrap 5 -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

        <style>
            body {
                font-family: 'Inter', sans-serif;
                margin: 0;
                padding: 0;
                overflow-x: hidden;
                background-color: #000;
            }
            .auth-video-bg {
                position: fixed;
                top: 0;
                left: 0;
                width: 100vw;
                height: 100vh;
                object-fit: cover;
                z-index: -2;
                background-color: #000; /* Prevent flash */
            }
            .auth-video-overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100vw;
                height: 100vh;
                background: linear-gradient(rgba(15, 23, 42, 0.4), rgba(15, 23, 42, 0.55)); /* Much more transparent */
                z-index: -1;
            }
            .auth-card {
                max-width: 500px;
                margin: 50px auto;
                border: none;
                border-radius: 15px;
                box-shadow: 0 10px 30px rgba(0,0,0,0.3);
                z-index: 10;
                background: rgba(255, 255, 255, 0.95);
                backdrop-filter: blur(10px);
            }
            .brand-color {
                color: #2e7d32; /* ElOued Green */
            }
            .btn-univ {
                background-color: #2e7d32;
                color: white;
                border-radius: 8px;
                padding: 10px 20px;
                font-weight: 600;
                transition: all 0.3s ease;
            }
            .btn-univ:hover {
                background-color: #1b5e20;
                color: white;
                transform: translateY(-2px);
            }
            .form-control:focus {
                border-color: #2e7d32;
                box-shadow: 0 0 0 0.25rem rgba(46, 125, 50, 0.25);
            }
        </style>
    </head>
    <body class="bg-dark">
        <!-- Video Background (Preload Metadata & Poster for Speed) -->
        <div class="auth-video-bg-container" style="position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background: linear-gradient(rgba(15, 23, 42, 0.7), rgba(15, 23, 42, 0.9)), url('{{ asset('idGvXOVIAG_logos.jpeg') }}') center/cover no-repeat; z-index: -2;">
            <video id="auth-video" class="auth-video-bg" muted playsinline preload="metadata" poster="{{ asset('idGvXOVIAG_logos.jpeg') }}">
                <source src="{{ asset('videos2/15298045_1920_1080_30fps.mp4') }}" type="video/mp4">
            </video>
        </div>
        <div class="auth-video-overlay"></div>

        <div class="container py-5">
            <div class="text-center mb-4">
                <a href="/">
                    <img src="https://www.univ-eloued.dz/wp-content/uploads/2024/03/logouef-png.avif" alt="University Logo" height="100">
                </a>
            </div>

            <div class="card auth-card shadow">
                <div class="card-body p-4">
                    {{ $slot }}
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            const authVideo = document.getElementById('auth-video');
            // High-Performance Video Selection (Only small 4MB-8MB files)
            const videos = [
                "{{ asset('videos2/8472460-hd_1920_1080_25fps.mp4') }}", // 4.9MB
                "{{ asset('videos2/7791922-hd_1920_1080_25fps.mp4') }}"  // 8.2MB
            ];

            function getNextRandomVideo() {
                const randomIndex = Math.floor(Math.random() * (videos.length));
                return videos[randomIndex];
            }

            if (authVideo) {
                // Delayed initialization to prioritize Login/Register form loading
                setTimeout(() => {
                    const initialSrc = getNextRandomVideo();
                    authVideo.src = initialSrc;
                    authVideo.load();
                    
                    authVideo.onended = function() {
                        authVideo.src = getNextRandomVideo();
                        authVideo.load();
                        authVideo.play();
                    };

                    authVideo.play().catch(e => console.log("Auto-play prevented", e));
                }, 1500);
            }
        </script>
    </body>
</html>
