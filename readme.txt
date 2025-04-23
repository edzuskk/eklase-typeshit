password - test@test.test
            1234567890
        teach - test@test.com
                1234567890

migration

-- Insert teachers into users table
INSERT INTO users (name, email, password, role, created_at, updated_at) VALUES
('John Smith', 'john.smith@school.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'teacher', NOW(), NOW()),
('Mary Johnson', 'mary.johnson@school.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'teacher', NOW(), NOW());

-- Insert teacher profiles
INSERT INTO teachers (user_id, subject) VALUES
(LAST_INSERT_ID()-1, 'Mathematics'),
(LAST_INSERT_ID(), 'English');

-- Insert students into users table
INSERT INTO users (name, email, password, role, created_at, updated_at) VALUES
('Student 1', 'student1@school.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', NOW(), NOW()),
('Student 2', 'student2@school.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', NOW(), NOW()),
('Student 3', 'student3@school.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', NOW(), NOW()),
('Student 4', 'student4@school.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', NOW(), NOW()),
('Student 5', 'student5@school.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', NOW(), NOW()),
('Student 6', 'student6@school.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', NOW(), NOW()),
('Student 7', 'student7@school.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', NOW(), NOW()),
('Student 8', 'student8@school.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', NOW(), NOW()),
('Student 9', 'student9@school.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', NOW(), NOW()),
('Student 10', 'student10@school.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', NOW(), NOW()),
('Student 11', 'student11@school.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', NOW(), NOW()),
('Student 12', 'student12@school.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', NOW(), NOW()),
('Student 13', 'student13@school.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', NOW(), NOW()),
('Student 14', 'student14@school.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', NOW(), NOW()),
('Student 15', 'student15@school.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', NOW(), NOW());

-- Insert student profiles (with class assignments)
INSERT INTO students (user_id, class) VALUES
(LAST_INSERT_ID()-14, '10A'),
(LAST_INSERT_ID()-13, '10A'),
(LAST_INSERT_ID()-12, '10A'),
(LAST_INSERT_ID()-11, '10A'),
(LAST_INSERT_ID()-10, '10A'),
(LAST_INSERT_ID()-9, '10B'),
(LAST_INSERT_ID()-8, '10B'),
(LAST_INSERT_ID()-7, '10B'),
(LAST_INSERT_ID()-6, '10B'),
(LAST_INSERT_ID()-5, '10B'),
(LAST_INSERT_ID()-4, '10C'),
(LAST_INSERT_ID()-3, '10C'),
(LAST_INSERT_ID()-2, '10C'),
(LAST_INSERT_ID()-1, '10C'),
(LAST_INSERT_ID(), '10C');

-- Insert grades for students (sample grades for each subject)
INSERT INTO grades (student_id, subject, value, comments, created_at, updated_at) VALUES
-- Mathematics grades
(1, 'Mathematics', 85.5, 'Good understanding of algebra', NOW(), NOW()),
(2, 'Mathematics', 90.0, 'Excellent work in geometry', NOW(), NOW()),
-- English grades
(1, 'English', 88.0, 'Strong writing skills', NOW(), NOW()),
(2, 'English', 92.5, 'Excellent comprehension', NOW(), NOW()),
-- Science grades
(1, 'Science', 87.5, 'Good lab work', NOW(), NOW()),
(2, 'Science', 89.0, 'Excellent project', NOW(), NOW()),
-- History grades
(1, 'History', 91.0, 'Great research paper', NOW(), NOW()),
(2, 'History', 88.5, 'Good class participation', NOW(), NOW()),
-- Physical Education grades
(1, 'Physical Education', 95.0, 'Excellent participation', NOW(), NOW()),
(2, 'Physical Education', 93.0, 'Good team player', NOW(), NOW());

