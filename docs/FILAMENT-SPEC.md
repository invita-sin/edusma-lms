# FILAMENT RESOURCE SPECIFICATION

## EduSMA LMS

**Version:** 1.0

### Framework

- Laravel 13
- Filament v4
- Livewire

### Purpose

Dokumen ini mendefinisikan seluruh Filament Resource yang harus dibuat pada setiap panel.

---

## PANEL STRUCTURE

### Admin Panel

- **Namespace:** `App\Filament\Admin`
- **Path:** `/admin`

### Teacher Panel

- **Namespace:** `App\Filament\Teacher`
- **Path:** `/teacher`

### Student Panel

- **Namespace:** `App\Filament\Student`
- **Path:** `/student`

---

## ADMIN PANEL

### ACADEMIC YEAR

| Item             | Detail                          |
|------------------|---------------------------------|
| Resource         | `AcademicYearResource`          |
| Navigation Group | Akademik                        |
| Navigation Sort  | 1                               |

**Form Fields:** Name, Start Date, End Date, Active Toggle

**Validation:** Required, Unique Name

**Table Columns:** Name, Start Date, End Date, Active Badge, Created At

**Filters:** Active, Inactive

**Actions:** View, Edit, Delete

**Bulk Actions:** Delete, Activate

---

### SEMESTER

| Item             | Detail                   |
|------------------|--------------------------|
| Resource         | `SemesterResource`       |
| Navigation Group | Akademik                 |
| Navigation Sort  | 2                        |

**Form Fields:** Academic Year, Semester Name, Active

**Table Columns:** Name, Academic Year, Active

---

### MAJOR

| Item             | Detail              |
|------------------|---------------------|
| Resource         | `MajorResource`     |
| Navigation Group | Akademik            |
| Navigation Sort  | 3                   |

**Form Fields:** Code, Name

**Table Columns:** Code, Name

---

### CLASSROOM

| Item             | Detail                    |
|------------------|---------------------------|
| Resource         | `ClassroomResource`       |
| Navigation Group | Akademik                  |
| Navigation Sort  | 4                         |

**Form Fields:** Major, Name, Grade Level

**Relation Managers:** `StudentsRelationManager`, `CoursesRelationManager`

**Table Columns:** Name, Major, Grade Level, Total Students

---

### SUBJECT

| Item             | Detail               |
|------------------|----------------------|
| Resource         | `SubjectResource`    |
| Navigation Group | Akademik             |
| Navigation Sort  | 5                    |

**Form Fields:** Code, Name

**Table Columns:** Code, Name

---

### TEACHER

| Item             | Detail                              |
|------------------|-------------------------------------|
| Resource         | `TeacherResource`                   |
| Navigation Group | Pengguna                            |
| Navigation Sort  | 10                                  |

**Form Fields:** Employee Number, Name, Email, Phone, Address, Avatar

**Table Columns:** Employee Number, Name, Email, Phone

**Filters:** Active, Inactive

**Header Actions:** Import Teacher, Export Teacher

**Relation Managers:** `CoursesRelationManager`

---

### STUDENT

| Item             | Detail                                |
|------------------|---------------------------------------|
| Resource         | `StudentResource`                     |
| Navigation Group | Pengguna                              |
| Navigation Sort  | 11                                    |

**Form Fields:** Student Number, Name, Email, Classroom, Gender, Birth Date, Phone, Address

**Table Columns:** Student Number, Name, Classroom, Gender

**Filters:** Classroom, Major

**Header Actions:** Import Student, Export Student

**Relation Managers:** `GradesRelationManager`, `AttendanceRelationManager`, `SubmissionRelationManager`

---

### COURSE

| Item             | Detail                                      |
|------------------|---------------------------------------------|
| Resource         | `CourseResource`                            |
| Navigation Group | Pembelajaran                                |
| Navigation Sort  | 20                                          |

**Form Fields:** Teacher, Subject, Classroom, Semester, Title, Description

**Relation Managers:** `MaterialsRelationManager`, `AssignmentsRelationManager`, `QuizzesRelationManager`, `AttendanceRelationManager`, `GradesRelationManager`

**Table Columns:** Title, Teacher, Subject, Classroom, Semester

---

### MATERIAL

| Item             | Detail                                 |
|------------------|----------------------------------------|
| Resource         | `MaterialResource`                     |
| Navigation Group | Pembelajaran                           |
| Navigation Sort  | 21                                     |

**Form Fields:** Course, Title, Description, File Upload, Publish Date

**Allowed Files:** PDF, DOCX, PPTX, MP4

**Max Size:** 50 MB

**Table Columns:** Title, Course, File Type, Publish Date

---

### ASSIGNMENT

| Item             | Detail                                   |
|------------------|------------------------------------------|
| Resource         | `AssignmentResource`                     |
| Navigation Group | Pembelajaran                             |
| Navigation Sort  | 22                                       |

**Form Fields:** Course, Title, Description, Due Date, Max Score

**Relation Managers:** `SubmissionsRelationManager`

**Table Columns:** Title, Course, Due Date, Total Submission

---

### QUIZ

| Item             | Detail                                |
|------------------|---------------------------------------|
| Resource         | `QuizResource`                        |
| Navigation Group | Pembelajaran                          |
| Navigation Sort  | 23                                    |

**Form Fields:** Course, Title, Description, Duration, Publish Date

**Relation Managers:** `QuestionsRelationManager`, `AttemptsRelationManager`

**Table Columns:** Title, Course, Duration

---

### ATTENDANCE

| Item             | Detail                      |
|------------------|-----------------------------|
| Resource         | `AttendanceResource`        |
| Navigation Group | Kehadiran                   |
| Navigation Sort  | 30                          |

**Form Fields:** Course, Student, Attendance Date, Status, Notes

**Table Columns:** Student, Course, Date, Status

---

### GRADE

| Item             | Detail                                     |
|------------------|--------------------------------------------|
| Resource         | `GradeResource`                            |
| Navigation Group | Nilai                                      |
| Navigation Sort  | 40                                         |

**Form Fields:** Student, Course, Assignment Score, Quiz Score, Midterm Score, Final Exam Score

**Computed:** Final Score

**Table Columns:** Student, Course, Final Score

---

### SETTING

| Item             | Detail                  |
|------------------|-------------------------|
| Resource         | `SettingResource`       |
| Navigation Group | Pengaturan              |
| Navigation Sort  | 90                      |

**Form Fields:** Group, Key, Value

---

## TEACHER PANEL

### Pages

**Teacher Dashboard — Widgets:**
- Active Courses
- Pending Submissions
- Active Assignments
- Active Quizzes

### Resources

| Resource              | Description                  |
|-----------------------|------------------------------|
| `MyCourseResource`    | Only Owned Courses           |
| `MyMaterialResource`  | Only Owned Materials         |
| `MyAssignmentResource`| Only Owned Assignments       |
| `MyQuizResource`      | Only Owned Quizzes           |
| `MyAttendanceResource`| Only Teacher Classes         |
| `MyGradeResource`     | Only Teacher Classes         |

**Policy:** Teacher Ownership

---

## STUDENT PANEL

### Pages

| Page                    | Features                                |
|-------------------------|-----------------------------------------|
| Student Dashboard       | Upcoming Assignment, Active Quiz, Recent Grade, Attendance Rate |
| `MyCoursesPage`         | Course List, Course Detail              |
| `MyMaterialsPage`       | Read Material, Download Material        |
| `MyAssignmentsPage`     | View Assignment, Upload Submission      |
| `MyQuizPage`            | Start Quiz, Submit Quiz                 |
| `MyGradesPage`          | View Grades                             |
| `MyAttendancePage`      | View Attendance                         |

---

## GLOBAL COMPONENTS

### Notification Bell

- **Location:** Topbar
- **Features:** Unread Count, Read All

### User Menu

- **Features:** Profile, Change Password, Logout

---

## GLOBAL SEARCH

### Admin

**Searchable Models:** Teacher, Student, Classroom, Subject, Course

### Teacher

**Searchable Models:** Student, Assignment, Quiz

### Student

**Searchable Models:** Material, Assignment, Quiz

---

## WIDGET LIBRARY

### Admin

- Total Students
- Total Teachers
- Total Classes
- Total Subjects
- Recent Activities

### Teacher

- Active Courses
- Pending Submissions
- Attendance Summary

### Student

- Upcoming Assignments
- Attendance Percentage
- Latest Grades

---

## FILAMENT BEST PRACTICES

### All Resources Must Have

- [x] Policy
- [x] Validation
- [x] Soft Delete Support
- [x] Search
- [x] Filter
- [x] Sort

### All Tables Must Support

- [x] Pagination
- [x] Bulk Actions
- [x] Export

### All Forms Must Support

- [x] Validation
- [x] Placeholder
- [x] Helper Text

### All Resources Must Use

- [x] Service Layer
- [x] Repository Layer

**Never Access Business Logic Directly From Resource.**
