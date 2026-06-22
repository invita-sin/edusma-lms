# Sprint 1 — Foundation System

**Duration:** 5 Hari

**Goal:** Membangun fondasi aplikasi meliputi project setup, authentication, RBAC, dan multi panel.

**Milestone:** Foundation System

---

## Task 1.1 — Project Setup

| Item              | Detail                                  |
|-------------------|-----------------------------------------|
| Description       | Install Laravel dan konfigurasi awal    |
| Deliverables      | Laravel installed, env configured, DB connected, Git initialized |
| Prompt Ref        | —                                       |
| Status            | Mandatory                               |

**Actions:**
- `laravel new edusma-lms`
- Config `.env` (DB, Redis, Mail, Queue)
- Setup Git repository
- Test database connection

---

## Task 1.2 — Install Dependencies

| Item              | Detail                                  |
|-------------------|-----------------------------------------|
| Description       | Install seluruh package yang diperlukan |
| Deliverables      | Semua package terinstal                 |
| Prompt Ref        | —                                       |

**Packages:**
- `filament/filament` — Admin panel
- `laravel/sanctum` — API authentication
- `spatie/laravel-permission` — RBAC
- `spatie/laravel-activitylog` — Activity logs
- `maatwebsite/laravel-excel` — Import/Export
- `barryvdh/laravel-dompdf` — PDF reports

**Actions:**
- `composer require` untuk setiap package
- Publish config files
- Jalankan migrasi awal

---

## Task 1.3 — Code Quality Setup

| Item              | Detail                                  |
|-------------------|-----------------------------------------|
| Description       | Setup coding standard dan static analysis |
| Deliverables      | Laravel Pint, PHPStan, Pest terkonfigurasi |
| Prompt Ref        | —                                       |

**Actions:**
- Install `laravel/pint` (built-in)
- Install `phpstan/phpstan`
- Install `pestphp/pest`
- Config `phpstan.neon` (level max)
- Create `composer.json` scripts:
  ```json
  "scripts": {
    "lint": "pint",
    "analyse": "phpstan analyse",
    "test": "pest"
  }
  ```

---

## Task 1.4 — Authentication

| Item              | Detail                                  |
|-------------------|-----------------------------------------|
| Description       | Setup login/logout/reset password untuk semua panel |
| Deliverables      | Filament auth working                   |
| Prompt Ref        | PROMPT 01, PROMPT 03                    |

**Files to Generate:**
- `database/migrations/xxxx_create_permission_tables.php` (Spatie)
- `database/seeders/RoleAndPermissionSeeder.php`
- `config/sanctum.php`

**Actions:**
- Install Filament panels
- Setup Filament auth (login, logout, forgot/reset password)
- Buat seeder untuk roles & permissions default
- Configure Sanctum untuk API auth

---

## Task 1.5 — Authorization

| Item              | Detail                                  |
|-------------------|-----------------------------------------|
| Description       | Setup RBAC dengan Spatie Permission     |
| Deliverables      | Full RBAC (4 roles + permissions)       |
| Prompt Ref        | PROMPT 01, PROMPT 02, PROMPT 05         |

**Files to Generate:**
- `app/Models/User.php`
- `database/migrations/xxxx_update_users_table.php` (role column)
- `database/seeders/RolePermissionSeeder.php`
- `app/Policies/UserPolicy.php`

**Roles:**
| Role         | Deskripsi                     |
|--------------|-------------------------------|
| super-admin  | Akses penuh seluruh sistem    |
| admin        | Mengelola operasional sekolah |
| teacher      | Mengelola pembelajaran        |
| student      | Mengakses pembelajaran        |

**Permissions Key:**
- `view_users`, `create_users`, `update_users`, `delete_users`
- `view_teachers`, `create_teachers`, `update_teachers`, `delete_teachers`
- `view_students`, `create_students`, `update_students`, `delete_students`
- `view_courses`, `create_courses`, `update_courses`, `delete_courses`
- `view_assignments`, `create_assignments`, `update_assignments`, `delete_assignments`
- `view_quizzes`, `create_quizzes`, `update_quizzes`, `delete_quizzes`
- `view_attendances`, `create_attendances`, `update_attendances`
- `view_grades`, `create_grades`, `update_grades`

**User Model:**
```php
class User extends Authenticatable
{
    use HasApiTokens, HasRoles;

    // Relationships
    public function teacher(): HasOne
    public function student(): HasOne
}
```

---

## Task 1.6 — Multi Panel Setup

| Item              | Detail                                  |
|-------------------|-----------------------------------------|
| Description       | Setup 3 Filament panels                 |
| Deliverables      | Admin, Teacher, Student panel siap      |
| Prompt Ref        | PROMPT 04                               |

**Files to Generate:**
- `app/Providers/Filament/AdminPanelProvider.php`
- `app/Providers/Filament/TeacherPanelProvider.php`
- `app/Providers/Filament/StudentPanelProvider.php`
- `app/Http/Middleware/RedirectIfAuthenticated.php`

**Panel Config:**

| Panel   | Path       | Middleware              |
|---------|------------|-------------------------|
| Admin   | `/admin`   | `auth`, `role:admin`    |
| Teacher | `/teacher` | `auth`, `role:teacher`  |
| Student | `/student` | `auth`, `role:student`  |

---

## Sprint 1 Checklist

- [ ] Laravel 13 installed and running
- [ ] Environment configured (DB, Redis, Mail)
- [ ] Git repository initialized
- [ ] All packages installed (Filament, Sanctum, Spatie, Excel, DomPDF, Activity Log)
- [ ] Laravel Pint configured
- [ ] PHPStan level max configured
- [ ] Pest configured
- [ ] User model with HasRoles and relationships
- [ ] Roles & permissions seeder (super-admin, admin, teacher, student)
- [ ] Login/Logout/Reset password working
- [ ] Sanctum configured for API
- [ ] Admin Panel (`/admin`)
- [ ] Teacher Panel (`/teacher`)
- [ ] Student Panel (`/student`)
- [ ] Panel middleware and providers

**Sprint Output:** Working Authentication System ✅
