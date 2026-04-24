<nav class="navbar navbar-expand-lg navbar-dark navbar-univ shadow-sm">
    <div class="navbar-video-container d-none d-lg-block">
        <video id="navVideo" class="navbar-video-bg" autoplay muted playsinline loop></video>
        <div class="navbar-kernel-overlay"></div>
    </div>
    <div class="container py-1">
        <a class="navbar-brand d-flex align-items-center" href="{{ route('dashboard') }}">
            <img src="https://www.univ-eloued.dz/wp-content/uploads/2024/03/logouef-png.avif" alt="University Logo" height="65" class="d-inline-block align-top">
        </a>
        <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <i class="bi bi-list fs-1 text-white"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-lg-center pt-3 pt-lg-0">
                <li class="nav-item mb-2 mb-lg-0">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                        <i class="bi bi-speedometer2 me-1"></i> {{ __('Dashboard') }}
                    </a>
                </li>
                @if(Auth::user()->isAdmin())
                    <li class="nav-item mb-2 mb-lg-0">
                        <a class="nav-link {{ request()->routeIs('admin.events.*') ? 'active' : '' }}" href="{{ route('admin.events.index') }}">
                            <i class="bi bi-calendar-event me-1"></i> Events
                        </a>
                    </li>
                    <li class="nav-item mb-2 mb-lg-0">
                        <a class="nav-link {{ request()->routeIs('admin.registrations.*') ? 'active' : '' }}" href="{{ route('admin.registrations.index') }}">
                            <i class="bi bi-people me-1"></i> Registrations
                        </a>
                    </li>
                    <li class="nav-item mb-2 mb-lg-0">
                        <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                            <i class="bi bi-person-gear me-1"></i> Users
                        </a>
                    </li>
                @else
                    <li class="nav-item mb-2 mb-lg-0">
                        <a class="nav-link {{ request()->routeIs('landing') ? 'active' : '' }}" href="{{ route('landing') }}#events">
                            <i class="bi bi-calendar-check me-1"></i> Browse
                        </a>
                    </li>
                    <li class="nav-item mb-2 mb-lg-0">
                        <a class="nav-link {{ request()->routeIs('my.applications') ? 'active' : '' }}" href="{{ route('my.applications') }}">
                            <i class="bi bi-file-earmark-text me-1"></i> Applications
                        </a>
                    </li>
                @endif
                
                {{-- User Profile Dropdown --}}
                <li class="nav-item dropdown ms-lg-3 mt-3 mt-lg-0 border-top border-secondary pt-3 pt-lg-0">
                    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="p-1 rounded-circle me-2 text-center d-none d-lg-block" style="width: 32px; height: 32px; background: rgba(255,255,255,0.1);">
                            <i class="bi bi-person text-white"></i>
                        </div>
                        <span class="me-2">{{ Auth::user()->name }}</span>
                        <span class="badge bg-white text-dark small text-uppercase py-1" style="font-size: 0.6rem;">{{ Auth::user()->role }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item py-2" href="{{ route('profile.edit') }}"><i class="bi bi-person me-2"></i> {{ __('Profile') }}</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger d-flex align-items-center py-2">
                                    <i class="bi bi-box-arrow-right me-2"></i> {{ __('Log Out') }}
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
