<x-layout>
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Dashboard</h5>
                    </div>

                    <div class="card-body">
                        <h2 class="mb-4">Welcome, {{ auth()->user()->name }}!</h2>
                        
                        @if(auth()->user()->isStudent())
                            <div class="alert alert-info">
                                <h4 class="alert-heading">Student Access</h4>
                                <p class="mb-0">You are logged in as a student</p>
                                @if(auth()->user()->student)
                                    <p class="mb-0">Class: {{ auth()->user()->student->class }}</p>
                                @endif
                            </div>
                            
                            <div class="mt-4">
                                <h5>Quick Actions</h5>
                                <div class="list-group">
                                    <a href="{{ route('student.grades') }}" class="list-group-item list-group-item-action">
                                        View My Grades
                                    </a>
                                </div>
                            </div>
                        @elseif(auth()->user()->isTeacher())
                            <div class="alert alert-primary">
                                <h4 class="alert-heading">Teacher Access</h4>
                                <p class="mb-0">You are logged in as a teacher</p>
                                @if(auth()->user()->teacher)
                                    <p class="mb-0">Subject: {{ auth()->user()->teacher->subject }}</p>
                                @endif
                            </div>

                            <div class="mt-4">
                                <h5>Quick Actions</h5>
                                <div class="list-group">
                                    <a href="{{ route('teacher.students.index') }}" class="list-group-item list-group-item-action">
                                        Manage Students
                                    </a>
                                    <a href="{{ route('teacher.grades.index') }}" class="list-group-item list-group-item-action">
                                        Manage Grades
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>