# DATABASE DESIGN DOCUMENT (DDD)

## EduSMA LMS

**Version:** 1.0

### Database Engine

MySQL 8+

### ORM

Laravel Eloquent

### Naming Convention

| Aspek    | Aturan              |
|----------|---------------------|
| Table    | snake_case plural   |
| Column   | snake_case          |
| Foreign Key | `{table_singular}_id` |

---

## DATABASE OVERVIEW

### Total Core Tables

**Authentication:** users, roles, permissions, model_has_roles, model_has_permissions, role_has_permissions

**Academic:** academic_years, semesters, majors, classrooms, subjects, courses

**Master Data:** teachers, students

**Learning:** materials, assignments, assignment_submissions

**Assessment:** quizzes, quiz_questions, quiz_options, quiz_attempts, quiz_answers

**Attendance:** attendances

**Grading:** grades

**System:** notifications, activity_logs, settings

---

## TABLE : users

**Purpose:** Authentication User

| Column           | Type            | Constraints       |
|------------------|-----------------|-------------------|
| id               | BIGINT          | PK                |
| name             | VARCHAR(255)    |                   |
| email            | VARCHAR(255)    | UNIQUE            |
| email_verified_at| TIMESTAMP       | NULL              |
| password         | VARCHAR(255)    |                   |
| role             | ENUM(super_admin, admin, teacher, student) | |
| remember_token   | VARCHAR(100)    |                   |
| created_at       | TIMESTAMP       |                   |
| updated_at       | TIMESTAMP       |                   |

**Indexes:** PRIMARY(id), UNIQUE(email), INDEX(role)

**Relationships:**
- User hasOne Teacher
- User hasOne Student

---

## TABLE : teachers

**Purpose:** Data Guru

| Column       | Type            | Constraints |
|--------------|-----------------|-------------|
| id           | BIGINT          | PK          |
| user_id      | BIGINT          | FK          |
| nip          | VARCHAR(50)     | UNIQUE      |
| name         | VARCHAR(255)    |             |
| gender       | ENUM(male,female)|            |
| phone        | VARCHAR(30)     |             |
| address      | TEXT            |             |
| birth_date   | DATE            |             |
| photo        | VARCHAR(255)    |             |
| status       | BOOLEAN         |             |
| created_at   | TIMESTAMP       |             |
| updated_at   | TIMESTAMP       |             |

**Indexes:** INDEX(user_id), INDEX(nip)

**Relationships:**
- Teacher belongsTo User
- Teacher hasMany Courses

---

## TABLE : students

**Purpose:** Data Siswa

| Column       | Type            | Constraints |
|--------------|-----------------|-------------|
| id           | BIGINT          | PK          |
| user_id      | BIGINT          | FK          |
| classroom_id | BIGINT          | FK          |
| nis          | VARCHAR(50)     |             |
| nisn         | VARCHAR(50)     |             |
| name         | VARCHAR(255)    |             |
| gender       | ENUM(male,female)|            |
| phone        | VARCHAR(30)     |             |
| address      | TEXT            |             |
| birth_date   | DATE            |             |
| photo        | VARCHAR(255)    |             |
| status       | BOOLEAN         |             |
| created_at   | TIMESTAMP       |             |
| updated_at   | TIMESTAMP       |             |

**Indexes:** INDEX(classroom_id), INDEX(user_id), INDEX(nis), INDEX(nisn)

**Relationships:**
- Student belongsTo User
- Student belongsTo Classroom
- Student hasMany AssignmentSubmissions
- Student hasMany QuizAttempts
- Student hasMany Grades

---

## TABLE : academic_years

| Column     | Type         | Constraints |
|------------|--------------|-------------|
| id         | BIGINT       | PK          |
| name       | VARCHAR(50)  |             |
| start_date | DATE         |             |
| end_date   | DATE         |             |
| is_active  | BOOLEAN      |             |
| created_at | TIMESTAMP    |             |
| updated_at | TIMESTAMP    |             |

---

## TABLE : semesters

| Column           | Type        | Constraints |
|------------------|-------------|-------------|
| id               | BIGINT      | PK          |
| academic_year_id | BIGINT      | FK          |
| name             | VARCHAR(50) |             |
| is_active        | BOOLEAN     |             |
| created_at       | TIMESTAMP   |             |
| updated_at       | TIMESTAMP   |             |

**Relationships:** Semester belongsTo AcademicYear

---

## TABLE : majors

| Column      | Type         | Constraints |
|-------------|--------------|-------------|
| id          | BIGINT       | PK          |
| name        | VARCHAR(100) |             |
| description | TEXT         |             |
| created_at  | TIMESTAMP    |             |
| updated_at  | TIMESTAMP    |             |

**Examples:** IPA, IPS, Bahasa

---

## TABLE : classrooms

| Column    | Type              | Constraints |
|-----------|-------------------|-------------|
| id        | BIGINT            | PK          |
| major_id  | BIGINT            | FK          |
| name      | VARCHAR(100)      |             |
| level     | ENUM(10,11,12)    |             |
| capacity  | INTEGER           |             |
| created_at| TIMESTAMP         |             |
| updated_at| TIMESTAMP         |             |

**Relationships:**
- Classroom belongsTo Major
- Classroom hasMany Students

---

## TABLE : subjects

| Column      | Type         | Constraints |
|-------------|--------------|-------------|
| id          | BIGINT       | PK          |
| name        | VARCHAR(255) |             |
| code        | VARCHAR(50)  |             |
| description | TEXT         |             |
| created_at  | TIMESTAMP    |             |
| updated_at  | TIMESTAMP    |             |

**Relationships:** Subject hasMany Courses

---

## TABLE : courses

**Purpose:** Mapping Guru + Kelas + Mata Pelajaran

| Column       | Type         | Constraints |
|--------------|--------------|-------------|
| id           | BIGINT       | PK          |
| teacher_id   | BIGINT       | FK          |
| subject_id   | BIGINT       | FK          |
| classroom_id | BIGINT       | FK          |
| semester_id  | BIGINT       | FK          |
| created_at   | TIMESTAMP    |             |
| updated_at   | TIMESTAMP    |             |

**Indexes:** teacher_id, subject_id, classroom_id, semester_id

**Relationships:**
- Course belongsTo Teacher
- Course belongsTo Subject
- Course belongsTo Classroom
- Course belongsTo Semester
- Course hasMany Materials
- Course hasMany Assignments
- Course hasMany Quizzes

---

## TABLE : materials

| Column       | Type         | Constraints |
|--------------|--------------|-------------|
| id           | BIGINT       | PK          |
| course_id    | BIGINT       | FK          |
| title        | VARCHAR(255) |             |
| description  | LONGTEXT     |             |
| file_path    | VARCHAR(255) |             |
| published_at | DATETIME     |             |
| created_at   | TIMESTAMP    |             |
| updated_at   | TIMESTAMP    |             |

**Relationships:** Material belongsTo Course

---

## TABLE : assignments

| Column      | Type         | Constraints |
|-------------|--------------|-------------|
| id          | BIGINT       | PK          |
| course_id   | BIGINT       | FK          |
| title       | VARCHAR(255) |             |
| description | LONGTEXT     |             |
| attachment  | VARCHAR(255) |             |
| deadline    | DATETIME     |             |
| max_score   | INTEGER      |             |
| created_at  | TIMESTAMP    |             |
| updated_at  | TIMESTAMP    |             |

**Relationships:**
- Assignment belongsTo Course
- Assignment hasMany AssignmentSubmissions

---

## TABLE : assignment_submissions

| Column        | Type          | Constraints |
|---------------|---------------|-------------|
| id            | BIGINT        | PK          |
| assignment_id | BIGINT        | FK          |
| student_id    | BIGINT        | FK          |
| file_path     | VARCHAR(255)  |             |
| submitted_at  | DATETIME      |             |
| score         | DECIMAL(5,2)  |             |
| feedback      | TEXT          |             |
| created_at    | TIMESTAMP     |             |
| updated_at    | TIMESTAMP     |             |

**Indexes:** assignment_id, student_id

**Relationships:**
- Submission belongsTo Assignment
- Submission belongsTo Student

---

## TABLE : quizzes

| Column         | Type          | Constraints |
|----------------|---------------|-------------|
| id             | BIGINT        | PK          |
| course_id      | BIGINT        | FK          |
| title          | VARCHAR(255)  |             |
| description    | TEXT          |             |
| duration       | INTEGER       |             |
| attempt_limit  | INTEGER       |             |
| passing_score  | INTEGER       |             |
| published      | BOOLEAN       |             |
| created_at     | TIMESTAMP     |             |
| updated_at     | TIMESTAMP     |             |

**Relationships:**
- Quiz belongsTo Course
- Quiz hasMany Questions

---

## TABLE : quiz_questions

| Column    | Type                            | Constraints |
|-----------|---------------------------------|-------------|
| id        | BIGINT                          | PK          |
| quiz_id   | BIGINT                          | FK          |
| question  | TEXT                            |             |
| type      | ENUM(multiple_choice, essay)    |             |
| points    | INTEGER                         |             |
| created_at| TIMESTAMP                       |             |
| updated_at| TIMESTAMP                       |             |

**Relationships:**
- Question belongsTo Quiz
- Question hasMany Options

---

## TABLE : quiz_options

| Column       | Type      | Constraints |
|--------------|-----------|-------------|
| id           | BIGINT    | PK          |
| question_id  | BIGINT    | FK          |
| option_text  | TEXT      |             |
| is_correct   | BOOLEAN   |             |
| created_at   | TIMESTAMP |             |
| updated_at   | TIMESTAMP |             |

**Relationships:** Option belongsTo Question

---

## TABLE : quiz_attempts

| Column      | Type                          | Constraints |
|-------------|-------------------------------|-------------|
| id          | BIGINT                        | PK          |
| quiz_id     | BIGINT                        | FK          |
| student_id  | BIGINT                        | FK          |
| started_at  | DATETIME                      |             |
| finished_at | DATETIME                      |             |
| score       | DECIMAL(5,2)                  |             |
| status      | ENUM(in_progress, completed)  |             |
| created_at  | TIMESTAMP                     |             |
| updated_at  | TIMESTAMP                     |             |

**Relationships:**
- Attempt belongsTo Quiz
- Attempt belongsTo Student
- Attempt hasMany Answers

---

## TABLE : quiz_answers

| Column             | Type          | Constraints |
|--------------------|---------------|-------------|
| id                 | BIGINT        | PK          |
| attempt_id         | BIGINT        | FK          |
| question_id        | BIGINT        | FK          |
| selected_option_id | BIGINT        | NULL        |
| essay_answer       | LONGTEXT      | NULL        |
| score              | DECIMAL(5,2)  |             |
| created_at         | TIMESTAMP     |             |
| updated_at         | TIMESTAMP     |             |

**Relationships:**
- Answer belongsTo Attempt
- Answer belongsTo Question

---

## TABLE : attendances

| Column          | Type                               | Constraints |
|-----------------|------------------------------------|-------------|
| id              | BIGINT                             | PK          |
| student_id      | BIGINT                             | FK          |
| course_id       | BIGINT                             | FK          |
| attendance_date | DATE                               |             |
| status          | ENUM(present, sick, excused, absent)|            |
| note            | TEXT                               |             |
| created_at      | TIMESTAMP                          |             |
| updated_at      | TIMESTAMP                          |             |

**Indexes:** student_id, course_id, attendance_date

**Relationships:**
- Attendance belongsTo Student
- Attendance belongsTo Course

---

## TABLE : grades

| Column           | Type          | Constraints |
|------------------|---------------|-------------|
| id               | BIGINT        | PK          |
| student_id       | BIGINT        | FK          |
| course_id        | BIGINT        | FK          |
| assignment_score | DECIMAL(5,2)  |             |
| quiz_score       | DECIMAL(5,2)  |             |
| midterm_score    | DECIMAL(5,2)  |             |
| final_exam_score | DECIMAL(5,2)  |             |
| final_score      | DECIMAL(5,2)  |             |
| grade_letter     | VARCHAR(2)    |             |
| created_at       | TIMESTAMP     |             |
| updated_at       | TIMESTAMP     |             |

**Relationships:**
- Grade belongsTo Student
- Grade belongsTo Course

---

## TABLE : notifications

| Column          | Type         | Constraints |
|-----------------|--------------|-------------|
| id              | UUID         | PK          |
| type            | VARCHAR(255) |             |
| notifiable_type | VARCHAR(255) |             |
| notifiable_id   | BIGINT       |             |
| data            | JSON         |             |
| read_at         | TIMESTAMP    | NULL        |
| created_at      | TIMESTAMP    |             |
| updated_at      | TIMESTAMP    |             |

---

## TABLE : activity_logs

| Column        | Type         | Constraints |
|---------------|--------------|-------------|
| id            | BIGINT       | PK          |
| log_name      | VARCHAR(255) |             |
| description   | TEXT         |             |
| subject_type  | VARCHAR(255) |             |
| subject_id    | BIGINT       |             |
| causer_type   | VARCHAR(255) |             |
| causer_id     | BIGINT       |             |
| properties    | JSON         |             |
| created_at    | TIMESTAMP    |             |

**Indexes:** causer_id, subject_id

---

## TABLE : settings

| Column     | Type         | Constraints |
|------------|--------------|-------------|
| id         | BIGINT       | PK          |
| key        | VARCHAR(255) |             |
| value      | LONGTEXT     |             |
| type       | VARCHAR(50)  |             |
| created_at | TIMESTAMP    |             |
| updated_at | TIMESTAMP    |             |

**Examples:** school_name, school_logo, school_address, academic_year, semester

---

## FOREIGN KEY RULES

| FK                           | References                  |
|------------------------------|-----------------------------|
| teacher.user_id              | users.id                    |
| student.user_id              | users.id                    |
| student.classroom_id         | classrooms.id               |
| semester.academic_year_id    | academic_years.id           |
| classroom.major_id           | majors.id                   |
| course.teacher_id            | teachers.id                 |
| course.subject_id            | subjects.id                 |
| course.classroom_id          | classrooms.id               |
| course.semester_id           | semesters.id                |
| material.course_id           | courses.id                  |
| assignment.course_id         | courses.id                  |
| submission.assignment_id     | assignments.id              |
| submission.student_id        | students.id                 |
| quiz.course_id               | courses.id                  |
| question.quiz_id             | quizzes.id                  |
| option.question_id           | quiz_questions.id           |
| attempt.quiz_id              | quizzes.id                  |
| attempt.student_id           | students.id                 |
| answer.attempt_id            | quiz_attempts.id            |
| answer.question_id           | quiz_questions.id           |
| attendance.student_id        | students.id                 |
| attendance.course_id         | courses.id                  |
| grade.student_id             | students.id                 |
| grade.course_id              | courses.id                  |

---

## INDEX STRATEGY

### High Priority Indexes

| Table              | Column(s)           |
|--------------------|---------------------|
| users              | email               |
| teachers           | nip                 |
| students           | nis, nisn           |
| assignments        | deadline            |
| quizzes            | published           |
| attendances        | attendance_date     |
| grades             | final_score         |
| activity_logs      | causer_id, subject_id |

---

## SOFT DELETE STRATEGY

Enable Soft Delete on:

- teachers
- students
- materials
- assignments
- quizzes
- courses
- subjects
- classrooms

---

## SEEDER STRATEGY

### Default Roles

- Super Admin
- Admin
- Guru
- Siswa

### Default Academic Year

- Tahun Ajaran Aktif

### Default Subjects

- Matematika
- Bahasa Indonesia
- Bahasa Inggris
- Fisika
- Kimia
- Biologi
- Sejarah
- Geografi
- Ekonomi
- Informatika

### Demo Data

- 10 Guru
- 100 Siswa
- 10 Kelas
- 20 Course
