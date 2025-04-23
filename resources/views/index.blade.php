<x-layout>
    <div class="welcome-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1>Welcome to Le-Klase</h1>
                    <p class="lead">A digital platform for managing student grades and academic progress.</p>
                    <div class="mt-4">
                        @guest
                            <a href="{{ route('login') }}" class="btn btn-primary me-3">Get Started</a>
                        @endguest
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</x-layout>