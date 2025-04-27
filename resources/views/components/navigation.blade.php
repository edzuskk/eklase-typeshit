<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('dashboard') }}">
            <i class="bi bi-book"></i> LeKlase
        </a>
        
        @auth
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" 
                           href="{{ route('dashboard') }}">
                            <i class="bi bi-speedometer2"></i> Dashboard
                        </a>
                    </li>
                    @if(auth()->user()->role === 'teacher')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('teacher.students.*') ? 'active' : '' }}" 
                               href="{{ route('teacher.students.index') }}">
                                <i class="bi bi-people"></i> Students
                            </a>
                        </li>
                    @endif
                </ul>
                
                <div class="d-flex align-items-center">
                    <div class="dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" 
                           href="#" 
                           role="button" 
                           data-bs-toggle="dropdown"
                           aria-expanded="false">
                            <div class="position-relative">
                                <img src="{{ auth()->user()->profile_picture ? Storage::url(auth()->user()->profile_picture) : asset('images/default-avatar.png') }}" 
                                     alt="Profile" 
                                     class="rounded-circle me-2 border border-2 border-light"
                                     width="32" 
                                     height="32" 
                                     style="object-fit: cover;">
                                <span class="position-absolute bottom-0 end-0 bg-success rounded-circle border border-light" 
                                      style="width: 10px; height: 10px;">
                                </span>
                            </div>
                            <span class="text-white">{{ auth()->user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-2">
                            <li>
                                <a class="dropdown-item py-2" href="{{ route(auth()->user()->role.'.profile') }}">
                                    <i class="bi bi-person me-2"></i> Profile
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item py-2 text-danger">
                                        <i class="bi bi-box-arrow-right me-2"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        @endauth
    </div>
</nav>