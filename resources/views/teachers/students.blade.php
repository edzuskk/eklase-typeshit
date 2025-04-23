<x-layout>
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0">Students Management</h1>
            <a href="{{ route('teacher.students.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg"></i> Add New Student
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Add Filter Form -->
        <div class="card mb-4">
            <div class="card-body">
                <form action="{{ route('teacher.students.index') }}" method="GET" class="row g-3">
                    <div class="col-md-4">
                        <label for="search" class="form-label">Search by Name/Email</label>
                        <input type="text" class="form-control" id="search" name="search" 
                            value="{{ request('search') }}" placeholder="Enter name or email">
                    </div>
                    <div class="col-md-3">
                        <label for="class" class="form-label">Filter by Class</label>
                        <select class="form-select" id="class" name="class">
                            <option value="">All Classes</option>
                            <option value="10A" {{ request('class') == '10A' ? 'selected' : '' }}>10A</option>
                            <option value="10B" {{ request('class') == '10B' ? 'selected' : '' }}>10B</option>
                            <option value="10C" {{ request('class') == '10C' ? 'selected' : '' }}>10C</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="subject" class="form-label">Filter by Subject</label>
                        <select class="form-select" id="subject" name="subject">
                            <option value="">All Subjects</option>
                            <option value="Math" {{ request('subject') == 'Math' ? 'selected' : '' }}>Mathematics</option>
                            <option value="English" {{ request('subject') == 'English' ? 'selected' : '' }}>English</option>
                            <option value="Science" {{ request('subject') == 'Science' ? 'selected' : '' }}>Science</option>
                            <option value="History" {{ request('subject') == 'History' ? 'selected' : '' }}>History</option>
                        </select>
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <div class="d-grid gap-2 d-md-block">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-search"></i> Search
                            </button>
                            <a href="{{ route('teacher.students.index') }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle"></i> Clear
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th style="width: 60px">Photo</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Class</th>
                                <th>Grades</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($students as $student)
                                <tr>
                                    <td>
                                        <img src="{{ $student->profile_picture ? Storage::url($student->profile_picture) : asset('images/default-avatar.png') }}" 
                                             alt="Profile Picture" 
                                             class="rounded-circle"
                                             style="width: 40px; height: 40px; object-fit: cover;">
                                    </td>
                                    <td>{{ $student->name }}</td>
                                    <td>{{ $student->email }}</td>
                                    <td>{{ $student->student->class ?? 'Not assigned' }}</td>
                                    <td>
                                        @forelse($student->grades as $grade)
                                            <span class="badge bg-primary me-1" title="{{ $grade->created_at->format('Y-m-d') }}">
                                                {{ $grade->subject }}: {{ $grade->grade }}
                                            </span>
                                        @empty
                                            <span class="text-muted">No grades yet</span>
                                        @endforelse
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('teacher.students.edit', $student) }}" 
                                               class="btn btn-sm btn-primary">
                                                <i class="bi bi-pencil"></i> Edit
                                            </a>
                                            <button type="button" 
                                                class="btn btn-sm btn-success add-grade-btn" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#addGradeModal"
                                                data-student-id="{{ $student->id }}"
                                                data-student-name="{{ $student->name }}">
                                                <i class="bi bi-plus-circle"></i> Add Grade
                                            </button>
                                            <form action="{{ route('teacher.students.destroy', $student) }}" 
                                                  method="POST" 
                                                  class="d-inline"
                                                  onsubmit="return confirm('Are you sure you want to delete this student?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="bi bi-trash"></i> Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">
                                        <div class="text-muted">
                                            No students found
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($students->hasPages())
                    <div class="mt-4">
                        {{ $students->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Grade Modal -->
    <div class="modal fade" id="addGradeModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Grade</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="gradeForm" action="" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="subject" class="form-label">Subject</label>
                            <select class="form-select" id="subject" name="subject" required>
                                <option value="">Select Subject</option>
                                <option value="Math">Mathematics</option>
                                <option value="English">English</option>
                                <option value="Science">Science</option>
                                <option value="History">History</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="grade" class="form-label">Grade</label>
                            <input type="number" class="form-control" id="grade" name="grade"
                                min="1" max="10" step="1" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Grade</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('addGradeModal');
        const form = document.getElementById('gradeForm');
        
        // Clear previous errors when modal opens
        modal.addEventListener('show.bs.modal', function(event) {
            clearErrors();
            const button = event.relatedTarget;
            const studentId = button.getAttribute('data-student-id');
            form.action = `/teacher/students/${studentId}/grades`;
        });

        // Handle form submission
        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            clearErrors();

            try {
                const response = await fetch(this.action, {
                    method: 'POST',
                    body: new FormData(this),
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                });

                const data = await response.json();

                if (response.ok) {
                    const modalInstance = bootstrap.Modal.getInstance(modal);
                    modalInstance.hide();
                    showAlert('success', data.message);
                    setTimeout(() => location.reload(), 1500);
                } else if (response.status === 422) {
                    // Show validation errors
                    Object.keys(data.errors).forEach(field => {
                        const input = form.querySelector(`[name="${field}"]`);
                        if (input) {
                            input.classList.add('is-invalid');
                            const feedback = document.createElement('div');
                            feedback.className = 'invalid-feedback';
                            feedback.textContent = data.errors[field][0];
                            input.parentNode.appendChild(feedback);
                        }
                    });
                } else {
                    throw new Error(data.message || 'An error occurred');
                }
            } catch (error) {
                showAlert('danger', error.message);
            }
        });

        function clearErrors() {
            form.querySelectorAll('.is-invalid').forEach(input => {
                input.classList.remove('is-invalid');
            });
            form.querySelectorAll('.invalid-feedback').forEach(feedback => {
                feedback.remove();
            });
        }

        function showAlert(type, message) {
            const alert = document.createElement('div');
            alert.className = `alert alert-${type} alert-dismissible fade show`;
            alert.innerHTML = `
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            document.querySelector('.container').insertAdjacentElement('afterbegin', alert);
        }
    });
    </script>
    @endpush
</x-layout>