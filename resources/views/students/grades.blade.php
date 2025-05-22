<x-layout>
    <div class="container py-4">
        <div class="card mb-4">
            <div class="card-body">
                <form action="{{ route('student.grades') }}" method="GET" class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Subject</label>
                        <select name="subject" class="form-select">
                            <option value="">All Subjects</option>
                            @foreach($subjects as $subject)
                                <option value="{{ $subject }}" {{ request('subject') == $subject ? 'selected' : '' }}>
                                    {{ $subject }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="col-md-4">
                        <label class="form-label">Sort By Date</label>
                        <select name="sort" class="form-select">
                            <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Newest First</option>
                            <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>Oldest First</option>
                        </select>
                    </div>

                    <div class="col-md-4 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-search"></i> Filter
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">My Grades</h5>
            </div>
            <div class="card-body">
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