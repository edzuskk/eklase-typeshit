<x-layout>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5>Create New Account</h5>
                    </div>
                    <div class="card-body p-4">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            
                            <div class="mb-3">
                                <label for="name" class="form-label">Full Name</label>
                                <input type="text" 
                                    class="form-control @error('name') is-invalid @enderror" 
                                    id="name" 
                                    name="name" 
                                    value="{{ old('name') }}" 
                                    required 
                                    {{-- Updated pattern to include full Unicode ranges for letters --}}
                                    pattern="[\p{L}\s]+"
                                    title="Name can only contain letters (including Latvian) and spaces">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" 
                                    class="form-control @error('email') is-invalid @enderror" 
                                    id="email" 
                                    name="email" 
                                    value="{{ old('email') }}" 
                                    placeholder="Enter your email"
                                    required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="role" class="form-label">Role</label>
                                <select name="role" id="role" class="form-control" required>
                                    <option value="">Select role</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role }}" {{ old('role') == $role ? 'selected' : '' }}>
                                            {{ ucfirst($role) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3" id="class-field" style="display: none;">
                                <label for="class" class="form-label">Class</label>
                                <select class="form-select @error('class') is-invalid @enderror" 
                                        id="class" 
                                        name="class">
                                    <option value="">-- Select Class --</option>
                                    @foreach(['10A', '10B', '10C'] as $class)
                                        <option value="{{ $class }}" {{ old('class') == $class ? 'selected' : '' }}>
                                            {{ $class }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('class')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3" id="subject-field" style="display: none;">
                                <label for="subject" class="form-label">Subject</label>
                                <select class="form-select @error('subject') is-invalid @enderror" 
                                        id="subject" 
                                        name="subject">
                                    <option value="">-- Select Subject --</option>
                                    @foreach($subjects as $subject)
                                        <option value="{{ $subject }}" {{ old('subject') == $subject ? 'selected' : '' }}>
                                            {{ $subject }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('subject')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" 
                                    class="form-control @error('password') is-invalid @enderror" 
                                    id="password" 
                                    name="password" 
                                    placeholder="Create a password"
                                    required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="password_confirmation" class="form-label">Confirm Password</label>
                                <input type="password" 
                                    class="form-control" 
                                    id="password_confirmation" 
                                    name="password_confirmation" 
                                    placeholder="Confirm your password"
                                    required>
                            </div>

                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-primary">Create Account</button>
                            </div>

                            <div class="text-center">
                                <p class="mb-0">Already have an account? 
                                    <a href="{{ route('login') }}" class="text-decoration-none">Login here</a>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.getElementById('role').addEventListener('change', function() {
        const classField = document.getElementById('class-field');
        const subjectField = document.getElementById('subject-field');
        
        if (this.value === 'student') {
            classField.style.display = 'block';
            subjectField.style.display = 'none';
        } else if (this.value === 'teacher') {
            classField.style.display = 'none';
            subjectField.style.display = 'block';
        } else {
            classField.style.display = 'none';
            subjectField.style.display = 'none';
        }
    });

    // Set initial state based on old input
    window.addEventListener('load', function() {
        const role = document.getElementById('role').value;
        if (role === 'student') {
            document.getElementById('class-field').style.display = 'block';
        } else if (role === 'teacher') {
            document.getElementById('subject-field').style.display = 'block';
        }
    });
    </script>
</x-layout>