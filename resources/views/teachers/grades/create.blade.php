<x-layout>
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Add Grade for {{ $student->name }}</h5>
                        <a href="{{ route('teacher.students.index') }}" class="btn btn-secondary btn-sm">
                            <i class="bi bi-arrow-left"></i> Back to List
                        </a>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('teacher.students.grades.store', $student) }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="subject" class="form-label">Subject</label>
                                <select class="form-select @error('subject') is-invalid @enderror" 
                                    id="subject" 
                                    name="subject" 
                                    required>
                                    <option value="">Select Subject</option>
                                    <option value="Math">Mathematics</option>
                                    <option value="English">English</option>
                                    <option value="Science">Science</option>
                                    <option value="History">History</option>
                                    <!-- Add more subjects as needed -->
                                </select>
                                @error('subject')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="grade" class="form-label">Grade</label>
                                <input type="number" 
                                    class="form-control @error('grade') is-invalid @enderror" 
                                    id="grade" 
                                    name="grade"
                                    min="1"
                                    max="10"
                                    step="1"
                                    required>
                                @error('grade')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="comment" class="form-label">Comment (Optional)</label>
                                <textarea 
                                    class="form-control" 
                                    id="comment" 
                                    name="comment"
                                    rows="3"></textarea>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save"></i> Save Grade
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>