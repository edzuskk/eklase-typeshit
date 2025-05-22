<x-layout>

    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0">Teachers List</h1>
            @if(auth()->user()->role === 'admin')
                <a href="{{ route('teachers.create') }}" class="btn btn-primary">
                    Add New Teacher
                </a>
            @endif
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <form action="{{ route('teacher.grades.index') }}" method="GET">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Student Name</label>
                            <input type="text" name="student_name" class="form-control" value="{{ request('student_name') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Subject</label>
                            <select name="subject" class="form-select">
                                <option value="">All Subjects</option>
                                @foreach($subjects as $id => $name)
                                    <option value="{{ $id }}" {{ request('subject') == $id ? 'selected' : '' }}>
                                        {{ $name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Sort By Date</label>
                            <select name="sort" class="form-select">
                                <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Newest First</option>
                                <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>Oldest First</option>
                            </select>
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-search"></i> Search
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Subjects</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($teachers as $teacher)
                            <tr>
                                <td>{{ $teacher->name }}</td>
                                <td>{{ $teacher->email }}</td>
                                <td>{{ $teacher->subjects ?? 'Not assigned' }}</td>
                                <td>
                                    @if(auth()->user()->role === 'admin')
                                    <a href="{{ route('teachers.edit', $teacher->id) }}" class="btn btn-sm btn-primary">
                                        Edit Student
                                    </a>
                                    <form action="{{ route('teachers.destroy', $teacher->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                            Delete
                                        </button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($teachers->hasPages())
                    <div class="mt-4">
                        <nav aria-label="Page navigation">
                            <ul class="pagination justify-content-center">
                                {{-- Previous Page Link --}}
                                @if ($teachers->onFirstPage())
                                    <li class="page-item disabled">
                                        <span class="page-link">
                                            <i class="bi bi-chevron-left"></i>
                                        </span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $teachers->previousPageUrl() }}">
                                            <i class="bi bi-chevron-left"></i>
                                        </a>
                                    </li>
                                @endif

                                {{-- Pagination Numbers --}}
                                @foreach ($teachers->getUrlRange(1, $teachers->lastPage()) as $page => $url)
                                    <li class="page-item {{ $page == $teachers->currentPage() ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endforeach

                                {{-- Next Page Link --}}
                                @if ($teachers->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $teachers->nextPageUrl() }}">
                                            <i class="bi bi-chevron-right"></i>
                                        </a>
                                    </li>
                                @else
                                    <li class="page-item disabled">
                                        <span class="page-link">
                                            <i class="bi bi-chevron-right"></i>
                                        </span>
                                    </li>
                                @endif
                            </ul>
                        </nav>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-layout>