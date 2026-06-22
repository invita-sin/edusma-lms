# Sprint 2 — Academic Structure

**Duration:** 5 Hari

**Goal:** Membangun struktur akademik sekolah (Tahun Ajaran, Semester, Jurusan, Kelas, Mata Pelajaran).

**Milestone:** Academic Management

---

## Task 2.1 — Academic Year

| Item              | Detail                                    |
|-------------------|-------------------------------------------|
| Description       | CRUD Tahun Ajaran + aktivasi              |
| Deliverables      | Migration, Model, Factory, Seeder, Resource |
| Prompt Ref        | PROMPT 06, PROMPT 07                      |

**Files to Generate:**
- `database/migrations/xxxx_create_academic_years_table.php`
- `app/Models/AcademicYear.php`
- `database/factories/AcademicYearFactory.php`
- `database/seeders/AcademicYearSeeder.php`
- `app/Filament/Admin/Resources/AcademicYearResource.php`
- `app/DTOs/CreateAcademicYearDTO.php`
- `app/DTOs/UpdateAcademicYearDTO.php`
- `app/Services/AcademicYearService.php`
- `app/Repositories/AcademicYearRepository.php`

**Fields:**
| Column      | Type        | Notes                |
|-------------|-------------|----------------------|
| name        | VARCHAR(50) | e.g. "2025/2026"     |
| start_date  | DATE        |                      |
| end_date    | DATE        |                      |
| is_active   | BOOLEAN     | Hanya 1 yang aktif   |

**Resource Features:**
- Form: name, start_date, end_date, active toggle
- Table: name, start_date, end_date, active badge, created_at
- Filters: active, inactive
- Actions: view, edit, delete
- Bulk: activate

---

## Task 2.2 — Semester

| Item              | Detail                                    |
|-------------------|-------------------------------------------|
| Description       | CRUD Semester + aktivasi                  |
| Deliverables      | Migration, Model, Resource                |
| Prompt Ref        | PROMPT 08                                 |

**Files to Generate:**
- `database/migrations/xxxx_create_semesters_table.php`
- `app/Models/Semester.php`
- `app/Filament/Admin/Resources/SemesterResource.php`
- `app/Services/SemesterService.php`
- `app/Repositories/SemesterRepository.php`

**Fields:**
| Column           | Type        | Notes                    |
|------------------|-------------|--------------------------|
| academic_year_id | BIGINT FK   | belongsTo AcademicYear   |
| name             | VARCHAR(50) | e.g. "Ganjil", "Genap"   |
| is_active        | BOOLEAN     |                          |

**Resource Features:**
- Form: select academic year, name, active toggle
- Table: name, academic year, active badge

---

## Task 2.3 — Major (Jurusan)

| Item              | Detail                                    |
|-------------------|-------------------------------------------|
| Description       | CRUD Jurusan                              |
| Deliverables      | Migration, Model, Resource                |
| Prompt Ref        | PROMPT 09                                 |

**Files to Generate:**
- `database/migrations/xxxx_create_majors_table.php`
- `app/Models/Major.php`
- `app/Filament/Admin/Resources/MajorResource.php`

**Fields:**
| Column | Type         | Notes                |
|--------|--------------|----------------------|
| code   | VARCHAR(20)  | e.g. "IPA", "IPS"    |
| name   | VARCHAR(100) | e.g. "Ilmu Pengetahuan Alam" |

**Default Seed Data:** IPA, IPS, Bahasa

---

## Task 2.4 — Classroom (Kelas)

| Item              | Detail                                    |
|-------------------|-------------------------------------------|
| Description       | CRUD Kelas + assign jurusan               |
| Deliverables      | Migration, Model, Resource, RelationManager |
| Prompt Ref        | PROMPT 10                                 |

**Files to Generate:**
- `database/migrations/xxxx_create_classrooms_table.php`
- `app/Models/Classroom.php`
- `app/Filament/Admin/Resources/ClassroomResource.php`
- `app/Filament/Admin/Resources/ClassroomResource/RelationManagers/StudentsRelationManager.php`
- `app/Filament/Admin/Resources/ClassroomResource/RelationManagers/CoursesRelationManager.php`

**Fields:**
| Column    | Type           | Notes                  |
|-----------|----------------|------------------------|
| major_id  | BIGINT FK      | belongsTo Major        |
| name      | VARCHAR(100)   | e.g. "X IPA 1"         |
| level     | ENUM(10,11,12) |                        |
| capacity  | INTEGER        |                        |

**Resource Features:**
- Form: select major, name, grade level, capacity
- Table: name, major, level, student count
- Relation Managers: Students, Courses

---

## Task 2.5 — Subject (Mata Pelajaran)

| Item              | Detail                                    |
|-------------------|-------------------------------------------|
| Description       | CRUD Mata Pelajaran                       |
| Deliverables      | Migration, Model, Resource                |
| Prompt Ref        | PROMPT 11                                 |

**Files to Generate:**
- `database/migrations/xxxx_create_subjects_table.php`
- `app/Models/Subject.php`
- `app/Filament/Admin/Resources/SubjectResource.php`

**Fields:**
| Column | Type         | Notes                       |
|--------|--------------|-----------------------------|
| code   | VARCHAR(50)  | e.g. "MTK", "BIN"           |
| name   | VARCHAR(255) | e.g. "Matematika Wajib"     |

**Default Seed Data:**
- Matematika, Bahasa Indonesia, Bahasa Inggris
- Fisika, Kimia, Biologi
- Sejarah, Geografi, Ekonomi
- Informatika, PKN, Agama, Seni Budaya, Penjasorkes

---

## Sprint 2 Checklist

- [ ] AcademicYear migration, model, factory, seeder
- [ ] AcademicYear Filament Resource (CRUD + activate)
- [ ] AcademicYear Service & Repository
- [ ] Semester migration, model
- [ ] Semester Filament Resource
- [ ] Semester Service & Repository
- [ ] Major migration, model
- [ ] Major Filament Resource
- [ ] Major default seeder (IPA, IPS, Bahasa)
- [ ] Classroom migration, model
- [ ] Classroom Filament Resource with level & major
- [ ] Classroom RelationManagers (Students, Courses)
- [ ] Subject migration, model
- [ ] Subject Filament Resource
- [ ] Subject default seeder (10+ subjects)

**Sprint Output:** Academic Master Data Complete ✅
