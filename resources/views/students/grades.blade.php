<x-layout>
    <div class="container py-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">My Grades</h5>
            </div>
            <div class="card-body">
                <!-- Filter Form -->
                <form action="{{ route('student.grades') }}" method="GET" class="mb-4">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label for="subject" class="form-label">Filter by Subject</label>
                            <select class="form-select" id="subject" name="subject">
                                <option value="">All Subjects</option>
                                <option value="Math" {{ request('subject') == 'Math' ? 'selected' : '' }}>Mathematics</option>
                                <option value="English" {{ request('subject') == 'English' ? 'selected' : '' }}>English</option>
                                <option value="Science" {{ request('subject') == 'Science' ? 'selected' : '' }}>Science</option>
                                <option value="History" {{ request('subject') == 'History' ? 'selected' : '' }}>History</option>
                            </select>
                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <div class="d-grid gap-2 d-md-block">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-search"></i> Filter
                                </button>
                                <a href="{{ route('student.grades') }}" class="btn btn-secondary">
                                    <i class="bi bi-x-circle"></i> Clear
                                </a>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- Grades Table -->
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>Subject</th>
                                <th>Grade</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse(auth()->user()->grades as $grade)
                                <tr>
                                    <td>{{ $grade->subject }}</td>
                                    <td>
                                        <span class="badge bg-{{ $grade->grade >= 4 ? 'success' : 'danger' }}" style="font-size: 1rem;">    
                                            {{ $grade->grade }}
                                        </span>
                                    </td>
                                    <td>{{ $grade->created_at->format('Y-m-d') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center py-4">No grades found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-layout>