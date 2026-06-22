# SOFTWARE ARCHITECTURE DOCUMENT (SAD)

## EduSMA LMS

**Version:** 1.0

**Author:** Akbar Sinyo

### Technology Stack

- Laravel 13
- Filament v4
- Livewire
- TailwindCSS
- MySQL 8
- Laravel Sanctum

---

## 1. System Overview

EduSMA LMS merupakan sistem Learning Management System berbasis web untuk tingkat SMA yang menyediakan:

- Portal Administrator
- Portal Guru
- Portal Siswa

Sistem dibangun menggunakan pendekatan **Modular Monolith** agar mudah dikembangkan dan dikelola oleh tim kecil maupun individu.

---

## 2. Architecture Style

**Pattern:** Modular Monolith

**Alasan:**
- Mudah dikembangkan
- Lebih sederhana dibanding microservices
- Cocok untuk LMS sekolah
- Performa lebih baik
- Deployment lebih mudah

---

## 3. High Level Architecture

```
┌─────────────────────────┐
│ Browser / Mobile Browser │
└─────────────┬───────────┘
              │
              ▼
┌─────────────────────────┐
│ Nginx Reverse Proxy     │
└─────────────┬───────────┘
              │
              ▼
┌─────────────────────────┐
│ Laravel Application     │
│                         │
│ Filament Panel          │
│ Livewire Components     │
│ Business Services       │
│ Repositories            │
└─────────────┬───────────┘
              │
              ▼
┌─────────────────────────┐
│ MySQL Database          │
└─────────────────────────┘
```

---

## 4. Application Layers

### Presentation Layer

**Teknologi:** Filament, Livewire, TailwindCSS

**Tanggung Jawab:** User Interface, Form Input, Validation, Dashboard, Reports

### Application Layer

**Tanggung Jawab:** Business Rules, Workflow, Use Cases, Authorization

**Folder:** `app/Services`

**Contoh:** AssignmentService, AttendanceService, QuizService, GradeService

### Domain Layer

**Tanggung Jawab:** Entity Logic, Business Logic

**Folder:** `app/Domains`

**Contoh:** Student, Teacher, Assignment, Quiz

### Infrastructure Layer

**Tanggung Jawab:** Database, Storage, Email, Notification

**Folder:** `app/Repositories`

---

## 5. Module Architecture

### Authentication Module

**Responsibilities:** Login, Logout, Password Reset, RBAC

**Dependencies:** User Module, Permission Module

### User Management Module

**Responsibilities:** CRUD User, Assign Role, Profile Management

**Roles:** Admin, Guru, Siswa

### Academic Module

**Responsibilities:** Tahun Ajaran, Semester, Jurusan, Kelas, Mata Pelajaran

**Entities:** AcademicYear, Semester, Major, ClassRoom, Subject

### Student Module

**Responsibilities:** Data Siswa, Import Excel, Kelas Siswa

**Entities:** Student

### Teacher Module

**Responsibilities:** Data Guru, Mata Pelajaran Guru

**Entities:** Teacher

### Course Module

**Responsibilities:** Mapping Guru, Mapping Kelas, Mapping Mata Pelajaran

**Entities:** Course

### Material Module

**Responsibilities:** Upload Materi, Download Materi, Embed Video

**Entities:** Material

### Assignment Module

**Responsibilities:** Buat Tugas, Pengumpulan Tugas, Penilaian

**Entities:** Assignment, Submission

### Quiz Module

**Responsibilities:** Quiz, Soal, Jawaban, Attempt

**Entities:** Quiz, Question, Answer, Attempt

### Attendance Module

**Responsibilities:** Presensi, Rekap Kehadiran

**Entities:** Attendance

### Grade Module

**Responsibilities:** Rekap Nilai, Nilai Akhir

**Entities:** Grade

### Notification Module

**Responsibilities:** Email, In App Notification

**Entities:** Notification

---

## 6. Panel Architecture

### Admin Panel

- **Path:** `/admin`
- **Features:** User Management, Academic Management, Reports, Settings
- **Filament Panel ID:** `admin`

### Teacher Panel

- **Path:** `/teacher`
- **Features:** Course Management, Assignment Management, Quiz Management, Attendance
- **Filament Panel ID:** `teacher`

### Student Panel

- **Path:** `/student`
- **Features:** Learning Dashboard, Materials, Assignment Submission, Quiz
- **Filament Panel ID:** `student`

---

## 7. Folder Structure

```
app/
├── Domains/
├── Services/
├── Repositories/
├── Policies/
├── Actions/
├── Jobs/
├── Notifications/
├── Models/
├── Filament/
│   ├── Admin/
│   ├── Teacher/
│   └── Student/
├── Http/
└── Providers/
```

---

## 8. Database Architecture

### Core Tables

- **Authentication:** users, roles, permissions
- **Master Data:** students, teachers
- **Academic:** academic_years, semesters, majors, classrooms
- **Learning:** subjects, courses, materials
- **Assessment:** assignments, assignment_submissions, quizzes, quiz_questions, quiz_answers, quiz_attempts
- **Records:** attendances, grades
- **System:** notifications, activity_logs

---

## 9. Authentication Architecture

| Komponen      | Detail                            |
|---------------|-----------------------------------|
| Authentication| Laravel Sanctum                   |
| Authorization | spatie/laravel-permission         |
| Roles         | Super Admin, Admin, Guru, Siswa   |
| Middleware    | `role:admin`, `role:guru`, `role:siswa` |

---

## 10. File Storage Architecture

**Storage Driver:** Default (`local`), Production (`S3 Compatible`)

**Folder Structure:**
```
storage/
  materials/
  assignments/
  submissions/
  avatars/
  exports/
```

---

## 11. Notification Architecture

**Trigger:** Assignment Created → Notification Service → Database Notification → Email Notification

**Supported Channels:** Database, Email

**Future:** WhatsApp, Telegram

---

## 12. Reporting Architecture

**Reports:** Nilai, Kehadiran, Aktivitas Belajar

**Export Format:** PDF, Excel

**Libraries:** Laravel Excel, DomPDF

---

## 13. Security Architecture

| Aspek          | Detail                    |
|----------------|---------------------------|
| Authentication | Laravel Sanctum           |
| Authorization  | Policies, Gates, Permissions |
| Protection     | CSRF, XSS, SQL Injection, Rate Limiting |
| Password       | bcrypt                    |

---

## 14. Caching Architecture

| Komponen     | Detail                |
|--------------|-----------------------|
| Driver       | Redis                 |
| Cache Targets| Dashboard Widgets, Statistics, Reports |
| TTL          | 5 - 30 menit          |

---

## 15. Queue Architecture

| Komponen     | Detail                |
|--------------|-----------------------|
| Driver       | database              |
| Jobs         | Send Email, Generate Reports, Export Excel |
| Future       | Redis Queue           |

---

## 16. Logging Architecture

| Komponen         | Detail                     |
|------------------|----------------------------|
| Laravel Log      | Channels: daily, stack     |
| Activity Log     | spatie/laravel-activitylog |
| Tracked Events   | Login, Logout, Create, Update, Delete |

---

## 17. Deployment Architecture

**Server:** Ubuntu 24.04

**Software:** Nginx, PHP 8.4, MySQL 8, Redis

**Deployment Flow:** GitHub → GitHub Actions → SSH Deployment → Production Server

---

## 18. Scalability Plan

| Phase  | Capacity           |
|--------|--------------------|
| Phase 1 | 1 School, 1.000 Users |
| Phase 2 | 10 Schools, 10.000 Users |
| Phase 3 | Multi School SaaS, 50.000+ Users |

---

## 19. Future Architecture

### Phase 2

- Mobile Apps
- Push Notification
- Discussion Forum

### Phase 3

- AI Quiz Generator
- AI Essay Checker
- AI Learning Assistant

### Phase 4

- Multi Tenant LMS
- SaaS Platform
- Subscription Billing

---

## 20. OpenCode AI Development Rules

### Architecture Principles

1. Service Layer First
2. Thin Controllers
3. Repository Pattern
4. SOLID Principles
5. Feature Based Modules
6. Policy Based Authorization
7. Filament Resource Driven Development
8. Migration First Development
9. Type Safe Validation
10. Automated Testing

### Coding Standards

- PSR-12
- Laravel Pint
- PHPStan Level 8
- Pest Testing

### Target Coverage

Minimum 80%
