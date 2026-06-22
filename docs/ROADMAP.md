# IMPLEMENTATION ROADMAP

## EduSMA LMS

**Version:** 1.0

### Tech Stack

- Laravel 13
- Filament v4
- Livewire
- TailwindCSS
- MySQL 8
- Redis
- Sanctum
- Spatie Permission

### Development Method

- Vibe Coding
- AI Assisted Development
- Feature Driven Development

### Estimated Duration

6 Sprint (≈ 6 Minggu)

---

## PROJECT MILESTONE

| Milestone | Description                     |
|-----------|---------------------------------|
| 1         | Foundation System               |
| 2         | Academic Management             |
| 3         | Teacher & Student Management    |
| 4         | Learning Management             |
| 5         | Assessment & Reporting          |
| 6         | Production Release              |

---

## SPRINT 1 — FOUNDATION SYSTEM

**Duration:** 5 Hari

**Goal:** Membangun fondasi aplikasi.

### Task 1.1 — Project Setup

**Deliverables:** Laravel Installed, Git Repository, Environment Configured, Database Connected

**Status:** Mandatory

### Task 1.2 — Package Installation

**Packages:** Filament, Sanctum, Spatie Permission, Activity Log, Laravel Excel, DomPDF

**Deliverables:** Packages Installed

### Task 1.3 — Code Quality Setup

**Deliverables:** Laravel Pint, PHPStan, Pest

### Task 1.4 — Authentication

**Deliverables:** Login, Logout, Reset Password

### Task 1.5 — Authorization

**Deliverables:**

- **Roles:** Super Admin, Admin, Guru, Siswa
- **Permissions:** Full RBAC

### Task 1.6 — Multi Panel Setup

**Deliverables:** Admin Panel, Teacher Panel, Student Panel

**Sprint Output:** Working Authentication System

---

## SPRINT 2 — ACADEMIC STRUCTURE

**Duration:** 5 Hari

**Goal:** Membangun struktur akademik sekolah.

| Module      | Features                     |
|-------------|------------------------------|
| Academic Year | CRUD, Active Academic Year |
| Semester    | CRUD, Active Semester        |
| Major       | CRUD (IPA, IPS, Bahasa)      |
| Classroom   | CRUD, Assign Major           |
| Subject     | CRUD                         |

**Sprint Output:** Academic Master Data Complete

---

## SPRINT 3 — USER MANAGEMENT

**Duration:** 5 Hari

**Goal:** Mengelola seluruh data guru dan siswa.

| Module             | Features                                      |
|--------------------|-----------------------------------------------|
| Teacher Management | CRUD Guru, Search, Filter, Import             |
| Student Management | CRUD Siswa, Search, Filter, Import Excel, Export Excel |
| User Profile       | Avatar, Profile Update, Change Password       |

**Sprint Output:** Teacher & Student Management Complete

---

## SPRINT 4 — COURSE & LEARNING

**Duration:** 7 Hari

**Goal:** Membangun sistem pembelajaran.

| Module           | Features                                    |
|------------------|---------------------------------------------|
| Course Module    | Mapping Guru, Mapping Kelas, Mapping Mata Pelajaran |
| Material Module  | Upload PDF, Upload DOCX, Upload PPTX, Upload Video |
| Material Viewer  | Preview, Download                           |
| Notifications    | New Material Notification                   |

**Sprint Output:** Learning Module Complete

---

## SPRINT 5 — ASSIGNMENT & QUIZ

**Duration:** 7 Hari

**Goal:** Membangun sistem evaluasi pembelajaran.

| Module              | Features                                           |
|---------------------|----------------------------------------------------|
| Assignment Module   | Create Assignment, Deadline, Submission, Grading    |
| Quiz Module         | Multiple Choice, Essay, Auto Grading, Manual Review |
| Quiz Randomization  | Random Questions, Random Answers                   |
| Student Dashboard   | Upcoming Assignments, Active Quiz                  |

**Sprint Output:** Assessment Module Complete

---

## SPRINT 6 — ATTENDANCE, GRADING & REPORTING

**Duration:** 6 Hari

**Goal:** Menyelesaikan sistem akademik.

### Attendance Module

**Features:** Student Attendance, Attendance Report

### Grade Module

**Features:** Grade Calculation, Final Score

**Formula:**
```
Final Score = (Assignment × 20%) + (Quiz × 20%) + (Midterm × 30%) + (Final Exam × 30%)
```

### Reporting Module

**Features:** Student Report, Attendance Report, Academic Report

**Formats:** PDF, Excel

### Dashboard Analytics

**Dashboards:** Admin Dashboard, Teacher Dashboard, Student Dashboard

**Sprint Output:** MVP Complete

---

## PRE RELEASE

**Duration:** 3 Hari

**Goal:** Hardening System

### Security Review

**Checklist:** Policy Check, Permission Check, Route Protection, Validation Review

### Performance Review

**Checklist:** Database Indexing, Query Optimization, Cache Setup

### Testing

**Checklist:** Unit Test, Feature Test, Permission Test

---

## RELEASE 1.0

| Komponen       | Detail             |
|----------------|--------------------|
| Deployment     | Ubuntu 24.04       |
| Stack          | Nginx, PHP 8.4, MySQL 8, Redis |

### CI/CD Pipeline

```
GitHub → GitHub Actions → Testing → Build → Deploy → Production
```

---

## POST RELEASE ROADMAP

### VERSION 1.1

**Features:** Discussion Forum, Announcements, Better Notifications

**Estimated:** 2 Minggu

### VERSION 1.2

**Features:** Mobile Responsive Optimization, PWA Support, Offline Cache

**Estimated:** 2 Minggu

### VERSION 2.0

**Features:** Android App, iOS App, Push Notification

**Estimated:** 1 Bulan

### VERSION 3.0

**Features:** AI Quiz Generator, AI Essay Scoring, AI Learning Assistant, AI Study Recommendations

**Estimated:** 2 Bulan

---

## SUCCESS CRITERIA

### Technical

- Test Coverage ≥ 80%
- Uptime ≥ 99%
- Response Time ≤ 2 Seconds

### Business

- 100% Guru Menggunakan Sistem
- 90% Siswa Aktif Bulanan

### Academic

- Seluruh Materi Digital
- Seluruh Tugas Dikirim Melalui LMS

---

## MVP DEFINITION

MVP dianggap selesai apabila:

- [x] Login
- [x] RBAC
- [x] Multi Panel
- [x] Guru Management
- [x] Student Management
- [x] Academic Structure
- [x] Course Management
- [x] Material Management
- [x] Assignment System
- [x] Quiz System
- [x] Attendance System
- [x] Grading System
- [x] Reporting System
- [x] Dashboard Analytics
- [x] Deployment Production
