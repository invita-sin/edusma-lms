# ENTITY RELATIONSHIP DIAGRAM SPECIFICATION

## EduSMA LMS

**Version:** 1.0

### Database

MySQL 8

### Naming Convention

- snake_case
- plural table names
- foreign key convention

**Format:** `{table}_id`

**Examples:** `student_id`, `teacher_id`, `course_id`

---

## CORE ENTITY OVERVIEW

```
users
├── teachers
├── students
│
├── roles
├── permissions
│
└── notifications
```

```
academic_years
└── semesters
    └── courses
```

```
majors
└── classrooms
    └── students
```

```
subjects
└── courses
```

```
teachers
└── courses
```

```
courses
├── materials
├── assignments
├── quizzes
├── attendances
└── grades
```

```
assignments
└── assignment_submissions
```

```
quizzes
├── quiz_questions
├── quiz_attempts
└── quiz_answers
```

---

## AUTHENTICATION DOMAIN

### users

| Item          | Detail                         |
|---------------|--------------------------------|
| **PK**        | `id`                           |
| **Fields**    | name, email, password, email_verified_at, avatar, status |
| **Relations** | hasOne teacher, hasOne student, belongsToMany roles, belongsToMany permissions |

### roles

| Item          | Detail                                 |
|---------------|----------------------------------------|
| **PK**        | `id`                                   |
| **Relations** | belongsToMany permissions, belongsToMany users |

### permissions

| Item          | Detail                                 |
|---------------|----------------------------------------|
| **PK**        | `id`                                   |
| **Relations** | belongsToMany roles, belongsToMany users |

---

## ACADEMIC DOMAIN

### academic_years

| Item          | Detail                                               |
|---------------|------------------------------------------------------|
| **PK**        | `id`                                                 |
| **Fields**    | name, start_date, end_date, is_active                |
| **Relations** | hasMany semesters, hasMany courses                   |

### semesters

| Item          | Detail                                  |
|---------------|-----------------------------------------|
| **PK**        | `id`                                    |
| **FK**        | `academic_year_id`                      |
| **Relations** | belongsTo academic_year, hasMany courses |

### majors

| Item          | Detail                    |
|---------------|---------------------------|
| **PK**        | `id`                      |
| **Fields**    | code, name                |
| **Relations** | hasMany classrooms        |

### classrooms

| Item          | Detail                                           |
|---------------|--------------------------------------------------|
| **PK**        | `id`                                             |
| **FK**        | `major_id`                                       |
| **Fields**    | name, grade_level                                |
| **Relations** | belongsTo major, hasMany students, hasMany courses |

### subjects

| Item          | Detail                     |
|---------------|----------------------------|
| **PK**        | `id`                       |
| **Fields**    | code, name                 |
| **Relations** | hasMany courses            |

---

## HUMAN RESOURCE DOMAIN

### teachers

| Item          | Detail                                       |
|---------------|----------------------------------------------|
| **PK**        | `id`                                         |
| **FK**        | `user_id`                                    |
| **Fields**    | employee_number, phone, address              |
| **Relations** | belongsTo user, hasMany courses              |

### students

| Item          | Detail                                                       |
|---------------|--------------------------------------------------------------|
| **PK**        | `id`                                                         |
| **FK**        | `user_id`, `classroom_id`                                    |
| **Fields**    | student_number, gender, birth_date, phone, address           |
| **Relations** | belongsTo user, belongsTo classroom, hasMany submissions, hasMany quiz_attempts, hasMany attendances, hasMany grades |

---

## LEARNING DOMAIN

### courses

| Item          | Detail                                                                      |
|---------------|-----------------------------------------------------------------------------|
| **PK**        | `id`                                                                        |
| **FK**        | `teacher_id`, `subject_id`, `classroom_id`, `semester_id`                   |
| **Fields**    | title, description, status                                                  |
| **Relations** | belongsTo teacher, belongsTo subject, belongsTo classroom, belongsTo semester, hasMany materials, hasMany assignments, hasMany quizzes, hasMany attendances, hasMany grades |

### materials

| Item          | Detail                                                   |
|---------------|----------------------------------------------------------|
| **PK**        | `id`                                                     |
| **FK**        | `course_id`                                              |
| **Fields**    | title, description, file_path, file_type, file_size, published_at |
| **Relations** | belongsTo course                                         |

---

## ASSIGNMENT DOMAIN

### assignments

| Item          | Detail                                             |
|---------------|----------------------------------------------------|
| **PK**        | `id`                                               |
| **FK**        | `course_id`                                        |
| **Fields**    | title, description, due_date, max_score            |
| **Relations** | belongsTo course, hasMany assignment_submissions   |

### assignment_submissions

| Item          | Detail                                                         |
|---------------|----------------------------------------------------------------|
| **PK**        | `id`                                                           |
| **FK**        | `assignment_id`, `student_id`                                  |
| **Fields**    | file_path, note, score, feedback, submitted_at                 |
| **Relations** | belongsTo assignment, belongsTo student                        |

---

## QUIZ DOMAIN

### quizzes

| Item          | Detail                                                      |
|---------------|-------------------------------------------------------------|
| **PK**        | `id`                                                        |
| **FK**        | `course_id`                                                 |
| **Fields**    | title, description, duration, total_score, published_at     |
| **Relations** | belongsTo course, hasMany questions, hasMany attempts       |

### quiz_questions

| Item          | Detail                                               |
|---------------|------------------------------------------------------|
| **PK**        | `id`                                                 |
| **FK**        | `quiz_id`                                            |
| **Fields**    | question, type, score                                |
| **Relations** | belongsTo quiz, hasMany options, hasMany answers     |

### quiz_options

| Item          | Detail                                            |
|---------------|---------------------------------------------------|
| **PK**        | `id`                                              |
| **FK**        | `quiz_question_id`                                |
| **Fields**    | option_text, is_correct                           |
| **Relations** | belongsTo question                                |

### quiz_attempts

| Item          | Detail                                               |
|---------------|------------------------------------------------------|
| **PK**        | `id`                                                 |
| **FK**        | `quiz_id`, `student_id`                              |
| **Fields**    | score, started_at, submitted_at                      |
| **Relations** | belongsTo quiz, belongsTo student, hasMany answers   |

### quiz_answers

| Item          | Detail                                               |
|---------------|------------------------------------------------------|
| **PK**        | `id`                                                 |
| **FK**        | `quiz_attempt_id`, `quiz_question_id`               |
| **Fields**    | answer, score                                        |
| **Relations** | belongsTo attempt, belongsTo question               |

---

## ATTENDANCE DOMAIN

### attendances

| Item          | Detail                                        |
|---------------|-----------------------------------------------|
| **PK**        | `id`                                          |
| **FK**        | `student_id`, `course_id`                     |
| **Fields**    | attendance_date, status, notes                |
| **Relations** | belongsTo student, belongsTo course           |

---

## GRADING DOMAIN

### grades

| Item          | Detail                                                      |
|---------------|-------------------------------------------------------------|
| **PK**        | `id`                                                        |
| **FK**        | `student_id`, `course_id`                                   |
| **Fields**    | assignment_score, quiz_score, midterm_score, final_exam_score, final_score |
| **Relations** | belongsTo student, belongsTo course                         |

---

## NOTIFICATION DOMAIN

### notifications

| Item          | Detail                           |
|---------------|----------------------------------|
| **PK**        | `id`                             |
| **FK**        | `user_id`                        |
| **Fields**    | title, message, read_at          |
| **Relations** | belongsTo user                   |

---

## SYSTEM DOMAIN

### settings

| Item          | Detail                |
|---------------|-----------------------|
| **PK**        | `id`                  |
| **Fields**    | group, key, value     |

### activity_logs

| Item          | Detail                                               |
|---------------|------------------------------------------------------|
| **PK**        | `id`                                                 |
| **Fields**    | log_name, description, subject_type, subject_id, causer_type, causer_id |

---

## RELATIONSHIP CARDINALITY

| Entity A          | Cardinality | Entity B              |
|-------------------|-------------|-----------------------|
| users             | 1 → 1       | teachers              |
| users             | 1 → 1       | students              |
| major             | 1 → N       | classrooms            |
| classroom         | 1 → N       | students              |
| teacher           | 1 → N       | courses               |
| subject           | 1 → N       | courses               |
| course            | 1 → N       | materials             |
| course            | 1 → N       | assignments           |
| course            | 1 → N       | quizzes               |
| assignment        | 1 → N       | submissions           |
| quiz              | 1 → N       | questions             |
| question          | 1 → N       | options               |
| quiz              | 1 → N       | attempts              |
| attempt           | 1 → N       | answers               |
| student           | 1 → N       | grades                |
| student           | 1 → N       | attendances           |
| course            | 1 → N       | grades                |
| course            | 1 → N       | attendances           |

---

## INDEXING STRATEGY

### Required Index

| Table       | Columns                     |
|-------------|-----------------------------|
| students    | student_number, classroom_id |
| teachers    | employee_number             |
| courses     | teacher_id, classroom_id, semester_id |
| assignments | due_date                    |
| quizzes     | published_at                |
| attendances | attendance_date             |
| grades      | student_id, course_id       |

---

## SOFT DELETE TABLES

Enable Soft Deletes on:

- teachers
- students
- courses
- materials
- assignments
- quizzes
- classrooms
- subjects

**Reason:** Auditability, Data Recovery

---

## CASCADE STRATEGY

| Delete Entity | Cascade                               |
|---------------|---------------------------------------|
| Course        | materials, assignments, quizzes       |
| Assignment    | submissions                           |
| Quiz          | questions, options, attempts, answers |

---

## DATABASE SIZE ESTIMATION

| Metric                  | Value            |
|-------------------------|------------------|
| Students                | 1,000            |
| Teachers                | 50               |
| Classes                 | 40               |
| Subjects                | 20               |
| Academic Years          | 5                |

### Estimated Records

| Table           | Records       |
|-----------------|---------------|
| Assignments     | 50,000+       |
| Submissions     | 200,000+      |
| Quiz Answers    | 500,000+      |

**Target Database Size:** < 5 GB
