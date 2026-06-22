# Sprint 6 — Attendance, Grading, Dashboard & Reporting

**Duration:** 6 Hari

**Goal:** Menyelesaikan seluruh sistem akademik (presensi, nilai, dashboard, laporan, notifikasi, pengaturan, logging, testing, deployment) dan rilis MVP.

**Milestone:** Production Release

---

## Task 9.1 — Attendance Entity

| Item              | Detail                                    |
|-------------------|-------------------------------------------|
| Description       | Migration + Model Attendance              |
| Deliverables      | Migration, Model, Factory                 |
| Prompt Ref        | PROMPT 42                                 |

**Files to Generate:**
- `database/migrations/xxxx_create_attendances_table.php`
- `app/Models/Attendance.php`

**Fields:**
| Column          | Type                               | Notes              |
|-----------------|------------------------------------|--------------------|
| student_id      | BIGINT FK                          | belongsTo Student  |
| course_id       | BIGINT FK                          | belongsTo Course   |
| attendance_date | DATE                               |                    |
| status          | ENUM(present, sick, excused, absent)|                   |
| note            | TEXT                               | nullable           |

**Indexes:** student_id, course_id, attendance_date

---

## Task 9.2 — Attendance Resource

| Item              | Detail                                    |
|-------------------|-------------------------------------------|
| Description       | Filament Resource untuk Attendance        |
| Deliverables      | Resource                                  |
| Prompt Ref        | PROMPT 43                                 |

**Files to Generate:**
- `app/Filament/Admin/Resources/AttendanceResource.php`
- `app/Filament/Teacher/Resources/MyAttendanceResource.php`

**Form (Teacher):**
- Select course (owned), select student (from course classroom)
- Attendance date, status, note

**Table:**
- Student name, course, date, status badge

---

## Task 9.3 — Attendance Service & Report

| Item              | Detail                                    |
|-------------------|-------------------------------------------|
| Description       | Service + report untuk absensi            |
| Deliverables      | Service, Repository, Report               |
| Prompt Ref        | PROMPT 44                                 |

**Files to Generate:**
- `app/Services/AttendanceService.php`
- `app/Repositories/AttendanceRepository.php`
- `app/DTOs/CreateAttendanceDTO.php`
- `app/Http/Requests/StoreAttendanceRequest.php`
- `app/Policies/AttendancePolicy.php`

**Report Features:**
- Summary per student (total hadir, sakit, izin, alpha)
- Summary per course per date
- Export to PDF/Excel

---

## Task 10.1 — Grade Entity

| Item              | Detail                                    |
|-------------------|-------------------------------------------|
| Description       | Migration + Model Grade                   |
| Deliverables      | Migration, Model                          |
| Prompt Ref        | PROMPT 45                                 |

**Files to Generate:**
- `database/migrations/xxxx_create_grades_table.php`
- `app/Models/Grade.php`

**Fields:**
| Column           | Type          | Notes              |
|------------------|---------------|--------------------|
| student_id       | BIGINT FK     | belongsTo Student  |
| course_id        | BIGINT FK     | belongsTo Course   |
| assignment_score | DECIMAL(5,2)  | nullable           |
| quiz_score       | DECIMAL(5,2)  | nullable           |
| midterm_score    | DECIMAL(5,2)  | nullable           |
| final_exam_score | DECIMAL(5,2)  | nullable           |
| final_score      | DECIMAL(5,2)  | computed           |
| grade_letter     | VARCHAR(2)    | computed (A,B,C,D,E) |

---

## Task 10.2 — Grade Calculation

| Item              | Detail                                    |
|-------------------|-------------------------------------------|
| Description       | Auto-calculate final score                |
| Deliverables      | Calculation service                       |
| Prompt Ref        | PROMPT 46                                 |

**Files to Generate:**
- `app/Services/GradeCalculationService.php`
- `app/Services/GradeService.php`
- `app/Repositories/GradeRepository.php`
- `app/DTOs/CreateGradeDTO.php`
- `app/Http/Requests/StoreGradeRequest.php`
- `app/Policies/GradePolicy.php`

**Formula:**
```
Final Score = (Assignment × 20%) + (Quiz × 20%) + (Midterm × 30%) + (Final Exam × 30%)
```

**Grade Letter:**
| Score Range  | Letter |
|--------------|--------|
| 85-100       | A      |
| 70-84        | B      |
| 55-69        | C      |
| 40-54        | D      |
| 0-39         | E      |

---

## Task 10.3 — Grade Resource & Report

| Item              | Detail                                    |
|-------------------|-------------------------------------------|
| Description       | Filament Resource + report nilai          |
| Deliverables      | Resource, Report service                  |
| Prompt Ref        | PROMPT 47                                 |

**Files to Generate:**
- `app/Filament/Admin/Resources/GradeResource.php`
- `app/Filament/Teacher/Resources/MyGradeResource.php`

**Form:**
- Select student, select course
- Input: assignment, quiz, midterm, final exam scores
- Computed: final score, grade letter (readonly)

**Table:**
- Student name, course, final score, grade letter

---

## Task 11.1 — Admin Dashboard

| Item              | Detail                                    |
|-------------------|-------------------------------------------|
| Description       | Dashboard widgets for Admin               |
| Deliverables      | Widget classes                            |
| Prompt Ref        | PROMPT 48                                 |

**Files to Generate:**
- `app/Filament/Admin/Widgets/TotalStudentsWidget.php`
- `app/Filament/Admin/Widgets/TotalTeachersWidget.php`
- `app/Filament/Admin/Widgets/TotalClassesWidget.php`
- `app/Filament/Admin/Widgets/TotalSubjectsWidget.php`
- `app/Filament/Admin/Widgets/RecentActivitiesWidget.php`

**Widgets:**
- Total Guru (stat card)
- Total Siswa (stat card)
- Total Kelas (stat card)
- Total Mata Pelajaran (stat card)
- Aktivitas Terbaru (table)

---

## Task 11.2 — Teacher Dashboard

| Item              | Detail                                    |
|-------------------|-------------------------------------------|
| Description       | Dashboard widgets for Teacher             |
| Deliverables      | Widget classes                            |
| Prompt Ref        | PROMPT 49                                 |

**Files to Generate:**
- `app/Filament/Teacher/Widgets/ActiveCoursesWidget.php`
- `app/Filament/Teacher/Widgets/ActiveAssignmentsWidget.php`
- `app/Filament/Teacher/Widgets/ActiveQuizzesWidget.php`
- `app/Filament/Teacher/Widgets/PendingSubmissionsWidget.php`
- `app/Filament/Teacher/Widgets/AttendanceSummaryWidget.php`

---

## Task 11.3 — Student Dashboard

| Item              | Detail                                    |
|-------------------|-------------------------------------------|
| Description       | Dashboard widgets for Student             |
| Deliverables      | Widget classes + pages                    |
| Prompt Ref        | PROMPT 50                                 |

**Files to Generate:**
- `app/Filament/Student/Widgets/UpcomingAssignmentsWidget.php`
- `app/Filament/Student/Widgets/ActiveQuizzesWidget.php`
- `app/Filament/Student/Widgets/LatestGradesWidget.php`
- `app/Filament/Student/Widgets/AttendanceRateWidget.php`

---

## Task 12.1 — PDF Reporting

| Item              | Detail                                    |
|-------------------|-------------------------------------------|
| Description       | PDF report generation                     |
| Deliverables      | PDF service                               |
| Prompt Ref        | PROMPT 51, PROMPT 53, PROMPT 54           |

**Files to Generate:**
- `app/Services/PdfReportService.php`
- `resources/views/reports/student-report.blade.php`
- `resources/views/reports/grade-report.blade.php`
- `resources/views/reports/attendance-report.blade.php`

**Reports:**
- Student Report (profile, grades, attendance)
- Grade Report (per class, per course)
- Attendance Report (per student, per class, per date range)

---

## Task 12.2 — Excel Export

| Item              | Detail                                    |
|-------------------|-------------------------------------------|
| Description       | Excel export services                     |
| Deliverables      | Export classes                            |
| Prompt Ref        | PROMPT 52, PROMPT 53, PROMPT 54           |

**Files to Generate:**
- `app/Exports/StudentGradeExport.php`
- `app/Exports/AttendanceExport.php`
- `app/Exports/CourseReportExport.php`

---

## Task 13.1 — Database Notifications

| Item              | Detail                                    |
|-------------------|-------------------------------------------|
| Description       | In-app notification system                |
| Deliverables      | Notification classes                      |
| Prompt Ref        | PROMPT 55                                 |

**Files to Generate:**
- `app/Notifications/QuizCreated.php`
- `app/Notifications/GradePublished.php`
- `app/Notifications/AttendanceRecorded.php`
- `app/Filament/Widgets/NotificationBell.php`

**Notification Types:**
- New assignment
- New quiz
- Grade published
- Attendance recorded
- General announcement

---

## Task 13.2 — Email Notifications

| Item              | Detail                                    |
|-------------------|-------------------------------------------|
| Description       | Email notification channel                |
| Deliverables      | Mailables + config                        |
| Prompt Ref        | PROMPT 56                                 |

**Files to Generate:**
- `app/Mail/AssignmentReminder.php`
- `app/Mail/QuizReminder.php`
- `resources/views/emails/assignment-reminder.blade.php`
- `resources/views/emails/quiz-reminder.blade.php`

---

## Task 14.1 — School Settings

| Item              | Detail                                    |
|-------------------|-------------------------------------------|
| Description       | School profile settings                   |
| Deliverables      | Migration, Resource                       |
| Prompt Ref        | PROMPT 57, PROMPT 58                      |

**Files to Generate:**
- `database/migrations/xxxx_create_settings_table.php`
- `app/Models/Setting.php`
- `app/Filament/Admin/Resources/SchoolSettingResource.php`
- `app/Services/SettingsService.php`

**Fields:**
- school_name, school_address, school_logo
- school_phone, school_email
- principal_name, operator_name

---

## Task 14.2 — Academic Settings

| Item              | Detail                                    |
|-------------------|-------------------------------------------|
| Description       | Academic configuration settings           |
| Deliverables      | Resource                                  |
| Prompt Ref        | PROMPT 59                                 |

**Files to Generate:**
- `app/Filament/Admin/Resources/AcademicSettingResource.php`

**Settings:**
- Active academic year
- Active semester
- Grade formula configuration
- Passing grade

---

## Task 15.1 — Activity Log

| Item              | Detail                                    |
|-------------------|-------------------------------------------|
| Description       | Activity logging with Spatie Activity Log |
| Deliverables      | Implementation + resource                 |
| Prompt Ref        | PROMPT 60                                 |

**Files to Generate:**
- `app/Filament/Admin/Resources/ActivityLogResource.php`

**Tracked Events:**
- Login, Logout
- Create, update, delete semua resource
- Grade changes
- Quiz submissions

---

## Task 16.1 — Unit Tests

| Item              | Detail                                    |
|-------------------|-------------------------------------------|
| Description       | Pest unit test untuk service layer        |
| Deliverables      | Test files                                |
| Prompt Ref        | PROMPT 61                                 |

**Files to Generate:**
- `tests/Unit/Services/TeacherServiceTest.php`
- `tests/Unit/Services/StudentServiceTest.php`
- `tests/Unit/Services/CourseServiceTest.php`
- `tests/Unit/Services/AssignmentServiceTest.php`
- `tests/Unit/Services/QuizServiceTest.php`
- `tests/Unit/Services/AttendanceServiceTest.php`
- `tests/Unit/Services/GradeCalculationServiceTest.php`

---

## Task 16.2 — Feature Tests

| Item              | Detail                                    |
|-------------------|-------------------------------------------|
| Description       | Pest feature test untuk modul inti        |
| Deliverables      | Test files                                |
| Prompt Ref        | PROMPT 62, PROMPT 63, PROMPT 64, PROMPT 65 |

**Files to Generate:**
- `tests/Feature/AuthenticationTest.php`
- `tests/Feature/AssignmentModuleTest.php`
- `tests/Feature/QuizModuleTest.php`
- `tests/Feature/AttendanceModuleTest.php`
- `tests/Feature/PermissionTest.php`

---

## Pre-Release — Hardening

| Task              | Detail                                    |
|-------------------|-------------------------------------------|
| Security Review   | Policy check, permission check, route protection, validation review |
| Performance Review | Database indexing, query optimization, cache setup (Redis) |
| Testing           | All tests pass, coverage ≥ 80%            |

---

## Task 17.1 — Deployment

| Item              | Detail                                    |
|-------------------|-------------------------------------------|
| Description       | Production deployment setup               |
| Deliverables      | Config files + workflow                   |
| Prompt Ref        | PROMPT 66, PROMPT 67, PROMPT 68, PROMPT 69, PROMPT 70 |

**Files to Generate:**
- `.github/workflows/ci.yml` — GitHub Actions
- `deploy/nginx.conf` — Nginx config
- `deploy/supervisor.conf` — Queue worker
- `deploy/production-checklist.md`

**CI/CD Pipeline:**
```
Push → GitHub Actions → Install deps → Lint → PHPStan → Pest → Build assets → Deploy
```

**Deployment Steps:**
1. Ubuntu 24.04 setup (PHP 8.4, Nginx, MySQL 8, Redis)
2. Nginx config with security headers
3. Supervisor for queue workers
4. Zero-downtime deployment

---

## Final — Audit

| Item              | Detail                                    |
|-------------------|-------------------------------------------|
| Description       | Audit final terhadap seluruh project      |
| Deliverables      | Audit report                              |
| Prompt Ref        | PROMPT 71                                 |

**Audit Checklist:**
- [ ] PRD compliance
- [ ] SAD compliance
- [ ] DDD compliance (database structure)
- [ ] TBS compliance (all tasks done)
- [ ] Bug check
- [ ] Security check
- [ ] Performance check
- [ ] Authorization check
- [ ] Database optimization check

---

## Sprint 6 Checklist

- [ ] Attendance migration, model
- [ ] Attendance Resource (Admin + Teacher)
- [ ] Attendance Service, Repository, Policy
- [ ] Grade migration, model
- [ ] Grade calculation service
- [ ] Grade Resource (Admin + Teacher)
- [ ] Grade Service, Repository, Policy
- [ ] Admin Dashboard widgets
- [ ] Teacher Dashboard widgets
- [ ] Student Dashboard widgets
- [ ] PDF report service (student, grade, attendance)
- [ ] Excel export (grade, attendance)
- [ ] Database notification module
- [ ] Email notification module
- [ ] School settings
- [ ] Academic settings
- [ ] Activity log implementation
- [ ] Unit tests (services)
- [ ] Feature tests (auth, assignment, quiz, attendance)
- [ ] Permission tests
- [ ] GitHub Actions workflow
- [ ] Nginx configuration
- [ ] Supervisor configuration
- [ ] Production checklist
- [ ] Final audit

**Sprint Output:** MVP Complete 🎉
