<x-layout>
    <div class="welcome-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1>Welcome to E-Diary</h1>
                    <p class="lead">A digital platform for managing student grades and academic progress.</p>
                    <div class="mt-4">
                        @guest
                            <a href="{{ route('register') }}" class="btn btn-primary me-3">Get Started</a>
                            <a href="{{ route('login') }}" class="btn btn-outline-primary">Login</a>
                        @endguest
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5>Features</h5>
                        </div>
                        <div class="card-body">
                            <ul class="feature-list">
                                <li>Easy grade management for teachers</li>
                                <li>Real-time grade viewing for students</li>
                                <li>Secure and reliable platform</li>
                                <li>Track academic progress</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</x-layout>