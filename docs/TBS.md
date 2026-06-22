# TASK BREAKDOWN STRUCTURE (TBS)

## EduSMA LMS

**Version:** 1.0

### Project Type

Learning Management System (LMS) SMA

### Tech Stack

- Laravel 13
- Filament v4
- Livewire
- TailwindCSS
- MySQL 8
- Redis
- Sanctum

### Development Method

Feature-Based Development

---

## PHASE 0 — PROJECT INITIALIZATION

### T0.1 Create Laravel Project

**Tasks:** Install Laravel, Configure Environment, Configure MySQL, Configure Storage, Configure Queue, Configure Cache

**Deliverables:** Laravel Installed, Database Connected

### T0.2 Install Dependencies

**Tasks:** Install Filament, Sanctum, Spatie Permission, Laravel Excel, DomPDF, Activity Log

**Deliverables:** All Packages Installed

### T0.3 Configure Code Quality

**Tasks:** Laravel Pint, PHPStan, Pest

**Deliverables:** Coding Standard Ready

---

## PHASE 1 — CORE SYSTEM

### T1.1 User Authentication

**Tasks:** Login, Logout, Reset Password, Session Management

**Deliverables:** Authentication Working

### T1.2 Role & Permission System

**Tasks:**

- Create Roles: Super Admin, Admin, Guru, Siswa
- Create Permissions: manage_users, manage_students, manage_teachers, manage_courses, manage_assignments, manage_quizzes, manage_attendance, manage_grades

**Deliverables:** RBAC Ready

### T1.3 Multi Panel Filament

**Tasks:** Create Admin Panel, Teacher Panel, Student Panel

**Deliverables:** Three Panels Ready

---

## PHASE 2 — MASTER DATA

### T2.1 Academic Year Module

**Tasks:** Create Migration, Model, Resource

**Fields:** name, start_date, end_date, active

### T2.2 Semester Module

**Tasks:** CRUD Semester

### T2.3 Major Module

**Tasks:** CRUD Jurusan (IPA, IPS, Bahasa)

### T2.4 Classroom Module

**Tasks:** CRUD Kelas, Assign Jurusan (X IPA 1, XI IPS 2)

### T2.5 Subject Module

**Tasks:** CRUD Mata Pelajaran

**Deliverables:** Subject Management Complete

---

## PHASE 3 — TEACHER MANAGEMENT

### T3.1 Teacher Entity

**Tasks:** Create Migration, Model, Factory, Seeder

**Fields:** NIP, Name, Email, Phone

### T3.2 Teacher Resource

**Tasks:** CRUD Guru, Search, Filter

### T3.3 Teacher Assignment

**Tasks:** Assign Mata Pelajaran, Kelas

---

## PHASE 4 — STUDENT MANAGEMENT

### T4.1 Student Entity

**Tasks:** Create Migration, Model, Factory, Seeder

**Fields:** NIS, NISN, Name, Email, Gender, Birth Date

### T4.2 Student Resource

**Tasks:** CRUD, Search, Filter

### T4.3 Import Student

**Tasks:** Import Excel, Validation, Error Report

### T4.4 Export Student

**Tasks:** Export Excel, Export PDF

---

## PHASE 5 — COURSE MANAGEMENT

### T5.1 Course Entity

**Tasks:** Create Mapping — Teacher, Subject, Class

### T5.2 Course Resource

**Tasks:** CRUD, Filter

### T5.3 Student Enrollment

**Tasks:** Enroll Student to Course

---

## PHASE 6 — LEARNING MATERIALS

### T6.1 Material Module

**Tasks:** Create Migration, Model, Resource

**Fields:** Title, Description, Attachment, Publish Date

### T6.2 Upload System

**Tasks:** Support PDF, DOCX, PPTX, Video

### T6.3 Material Viewer

**Tasks:** Preview PDF, Download File

---

## PHASE 7 — ASSIGNMENT MANAGEMENT

### T7.1 Assignment Entity

**Tasks:** Create Assignment Table

**Fields:** Title, Description, Deadline, Max Score

### T7.2 Submission Entity

**Tasks:** Create Submission Table

**Fields:** Student, Assignment, File

### T7.3 Assignment Workflow

**Tasks:** Guru Create Assignment → Siswa Submit → Guru Review & Grade

### T7.4 Assignment Notification

**Tasks:** Notify Students

---

## PHASE 8 — QUIZ SYSTEM

### T8.1 Quiz Module

**Tasks:** Create Quiz, Question, Answer

### T8.2 Multiple Choice

**Tasks:** Single Answer, Auto Grading

### T8.3 Essay Questions

**Tasks:** Essay Submission, Manual Review

### T8.4 Quiz Attempt

**Tasks:** Store Start Time, End Time, Score

### T8.5 Quiz Randomization

**Tasks:** Random Questions, Random Answers

---

## PHASE 9 — ATTENDANCE SYSTEM

### T9.1 Attendance Entity

**Tasks:** Create Attendance Table

### T9.2 Student Attendance

**Tasks:** Status — Present, Sick, Excused, Absent

### T9.3 Attendance Report

**Tasks:** Generate Summary

---

## PHASE 10 — GRADING SYSTEM

### T10.1 Grade Entity

**Tasks:** Create Grade Table

### T10.2 Grade Calculation

**Formula:** Final Score = (Tugas × 20%) + (Quiz × 20%) + (UTS × 30%) + (UAS × 30%)

### T10.3 Grade Report

**Tasks:** Per Student, Per Class

---

## PHASE 11 — DASHBOARD

### T11.1 Admin Dashboard

**Widgets:** Total Students, Total Teachers, Total Courses

### T11.2 Teacher Dashboard

**Widgets:** Active Classes, Active Assignments, Pending Reviews

### T11.3 Student Dashboard

**Widgets:** Today's Schedule, Upcoming Tasks, Latest Scores

---

## PHASE 12 — NOTIFICATIONS

### T12.1 Database Notification

**Events:** Assignment, Quiz, Grades

### T12.2 Email Notification

**Events:** New Assignment, Quiz Reminder

---

## PHASE 13 — REPORTING

### T13.1 Student Report

**Outputs:** PDF, Excel

### T13.2 Attendance Report

**Outputs:** PDF, Excel

### T13.3 Academic Report

**Outputs:** PDF, Excel

---

## PHASE 14 — SYSTEM SETTINGS

### T14.1 School Profile

**Fields:** School Name, Address, Logo, Contact

### T14.2 Academic Settings

**Tasks:** Active Semester, Active Academic Year

---

## PHASE 15 — AUDIT & LOGGING

### T15.1 Activity Log

**Track:** Login, Logout, CRUD

### T15.2 Audit Trail

**Store:** User, Action, Timestamp

---

## PHASE 16 — TESTING

### T16.1 Unit Testing

**Coverage:** Services, Repositories

### T16.2 Feature Testing

**Coverage:** Login, Assignment, Quiz, Attendance

### T16.3 Permission Testing

**Coverage:** Admin, Guru, Siswa

---

## PHASE 17 — DEPLOYMENT

### T17.1 Server Setup

**Install:** Nginx, PHP 8.4, MySQL, Redis

### T17.2 CI/CD

**Workflow:** Push → Test → Build → Deploy (GitHub Actions)

---

## PHASE 18 — MVP RELEASE

### Acceptance Criteria

- [x] Login
- [x] Dashboard
- [x] Guru Management
- [x] Student Management
- [x] Academic Structure
- [x] Materials
- [x] Assignments
- [x] Quiz
- [x] Attendance
- [x] Grades
- [x] Reports

---

## ESTIMATION

| Phase       | Duration  |
|-------------|-----------|
| Phase 0-1   | 3 Hari    |
| Phase 2-4   | 5 Hari    |
| Phase 5-8   | 7 Hari    |
| Phase 9-13  | 5 Hari    |
| Phase 14-18 | 3 Hari    |
| **Total**   | **≈ 23 Hari Development** |
