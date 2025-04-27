<x-layout>
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Teacher Profile</h5>
                    </div>

                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <form action="{{ route('teacher.profile.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            
                            <div class="mb-3">
                                <label class="form-label">Profile Picture</label>
                                <div class="d-flex align-items-center">
                                    <img src="{{ auth()->user()->profile_picture 
                                        ? Storage::url(auth()->user()->profile_picture) 
                                        : asset('images/default-avatar.png') }}" 
                                        class="rounded-circle me-3" 
                                        style="width: 100px; height: 100px; object-fit: cover;"
                                        alt="Profile Picture">
                                    <div>
                                        <input type="file" 
                                            class="form-control @error('profile_picture') is-invalid @enderror" 
                                            id="profile_picture" 
                                            name="profile_picture"
                                            accept="image/*">
                                        @error('profile_picture')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            

                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" 
                                    class="form-control @error('name') is-invalid @enderror" 
                                    id="name" 
                                    name="name" 
                                    value="{{ old('name', $teacher->name) }}" 
                                    required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" 
                                    class="form-control @error('email') is-invalid @enderror" 
                                    id="email" 
                                    name="email" 
                                    value="{{ old('email', $teacher->email) }}" 
                                    required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="subject" class="form-label">Subject</label>
                                <input type="text" 
                                    class="form-control @error('subject') is-invalid @enderror" 
                                    id="subject" 
                                    name="subject" 
                                    value="{{ old('subject', $teacher->teacher->subject) }}" 
                                    required>
                                @error('subject')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <hr class="my-4">

                            <h6>Change Password</h6>

                            <div class="mb-3">
                                <label for="current_password" class="form-label">Current Password</label>
                                <input type="password" 
                                    class="form-control @error('current_password') is-invalid @enderror" 
                                    id="current_password" 
                                    name="current_password">
                                @error('current_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">New Password</label>
                                <input type="password" 
                                    class="form-control @error('password') is-invalid @enderror" 
                                    id="password" 
                                    name="password">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Confirm New Password</label>
                                <input type="password" 
                                    class="form-control" 
                                    id="password_confirmation" 
                                    name="password_confirmation">
                            </div>
                            <div class="d-grid gap-3">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-lg"></i> Update Profile
                                </button>
                                
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
    <script>
        document.getElementById('profile_picture').addEventListener('change', function(e) {
            if (e.target.files && e.target.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.querySelector('img').setAttribute('src', e.target.result);
                };
                reader.readAsDataURL(e.target.files[0]);
            }
        });
    </script>
    @endpush
</x-layout>