# Sprint 3 — User Management

**Duration:** 5 Hari

**Goal:** Mengelola seluruh data guru dan siswa.

**Milestone:** Teacher & Student Management

---

## Task 3.1 — Teacher Entity

| Item              | Detail                                    |
|-------------------|-------------------------------------------|
| Description       | Migration + Model Teacher sesuai DDD      |
| Deliverables      | Migration, Model, Factory, Seeder         |
| Prompt Ref        | PROMPT 12, PROMPT 13                      |

**Files to Generate:**
- `database/migrations/xxxx_create_teachers_table.php`
- `app/Models/Teacher.php`
- `database/factories/TeacherFactory.php`
- `database/seeders/TeacherSeeder.php`

**Fields:**
| Column          | Type              | Notes                    |
|-----------------|-------------------|--------------------------|
| user_id         | BIGINT FK         | belongsTo User           |
| nip             | VARCHAR(50)       | UNIQUE                   |
| name            | VARCHAR(255)      |                          |
| gender          | ENUM(male,female) |                          |
| phone           | VARCHAR(30)       |                          |
| address         | TEXT              |                          |
| birth_date      | DATE              |                          |
| photo           | VARCHAR(255)      | nullable                 |
| status          | BOOLEAN           | default true             |

**Model Relationships:**
```php
class Teacher extends Model
{
    public function user(): BelongsTo
    public function courses(): HasMany
}
```

---

## Task 3.2 — Teacher Resource

| Item              | Detail                                    |
|-------------------|-------------------------------------------|
| Description       | Filament Resource untuk CRUD Guru         |
| Deliverables      | Resource + Relation Manager               |
| Prompt Ref        | PROMPT 14                                 |

**Files to Generate:**
- `app/Filament/Admin/Resources/TeacherResource.php`
- `app/Filament/Admin/Resources/TeacherResource/Pages/ListTeachers.php`
- `app/Filament/Admin/Resources/TeacherResource/Pages/CreateTeacher.php`
- `app/Filament/Admin/Resources/TeacherResource/Pages/EditTeacher.php`
- `app/Filament/Admin/Resources/TeacherResource/RelationManagers/CoursesRelationManager.php`

**Form:**
- Auto-create User (name, email, password = NIP default)
- NIP, name, email, phone, address, photo upload, gender select
- Status toggle

**Table:**
- NIP, name, email, phone, status badge
- Searchable: name, NIP, email
- Filters: active, inactive

**Header Actions:** Import Guru, Export Guru

---

## Task 3.3 — Teacher Service & Repository

| Item              | Detail                                    |
|-------------------|-------------------------------------------|
| Description       | Service + Repository layer untuk Teacher  |
| Deliverables      | Service, Repository, DTO                  |
| Prompt Ref        | PROMPT 15                                 |

**Files to Generate:**
- `app/Services/TeacherService.php`
- `app/Repositories/TeacherRepository.php`
- `app/DTOs/CreateTeacherDTO.php`
- `app/DTOs/UpdateTeacherDTO.php`
- `app/Http/Requests/StoreTeacherRequest.php`
- `app/Http/Requests/UpdateTeacherRequest.php`
- `app/Policies/TeacherPolicy.php`

**TeacherService Methods:**
```php
class TeacherService
{
    public function create(CreateTeacherDTO $dto): Teacher
    public function update(int $id, UpdateTeacherDTO $dto): Teacher
    public function delete(int $id): void
    public function findById(int $id): ?Teacher
    public function search(string $query): Collection
}
```

---

## Task 3.4 — Import Guru (Excel)

| Item              | Detail                                    |
|-------------------|-------------------------------------------|
| Description       | Import data guru dari file Excel          |
| Deliverables      | Import class + validation                 |
| Prompt Ref        | PROMPT 16                                 |

**Files to Generate:**
- `app/Imports/TeacherImport.php`
- `app/Exports/TeacherExport.php`

**Import Rules:**
- Template: NIP, Nama, Email, Phone, Gender
- Auto-create User account
- Validation: unique NIP, valid email, required fields
- Error report: baris gagal dengan alasan

---

## Task 4.1 — Student Entity

| Item              | Detail                                    |
|-------------------|-------------------------------------------|
| Description       | Migration + Model Student sesuai DDD      |
| Deliverables      | Migration, Model, Factory, Seeder         |
| Prompt Ref        | PROMPT 17, PROMPT 18                      |

**Files to Generate:**
- `database/migrations/xxxx_create_students_table.php`
- `app/Models/Student.php`
- `database/factories/StudentFactory.php`
- `database/seeders/StudentSeeder.php`

**Fields:**
| Column       | Type              | Notes                  |
|--------------|-------------------|------------------------|
| user_id      | BIGINT FK         | belongsTo User         |
| classroom_id | BIGINT FK         | belongsTo Classroom    |
| nis          | VARCHAR(50)       | UNIQUE                 |
| nisn         | VARCHAR(50)       |                        |
| name         | VARCHAR(255)      |                        |
| gender       | ENUM(male,female) |                        |
| phone        | VARCHAR(30)       |                        |
| address      | TEXT              |                        |
| birth_date   | DATE              |                        |
| photo        | VARCHAR(255)      | nullable               |
| status       | BOOLEAN           | default true           |

**Model Relationships:**
```php
class Student extends Model
{
    public function user(): BelongsTo
    public function classroom(): BelongsTo
    public function submissions(): HasMany
    public function quizAttempts(): HasMany
    public function attendances(): HasMany
    public function grades(): HasMany
}
```

---

## Task 4.2 — Student Resource

| Item              | Detail                                    |
|-------------------|-------------------------------------------|
| Description       | Filament Resource untuk CRUD Siswa        |
| Deliverables      | Resource + Relation Managers              |
| Prompt Ref        | PROMPT 19                                 |

**Files to Generate:**
- `app/Filament/Admin/Resources/StudentResource.php`
- `app/Filament/Admin/Resources/StudentResource/RelationManagers/GradesRelationManager.php`
- `app/Filament/Admin/Resources/StudentResource/RelationManagers/AttendanceRelationManager.php`
- `app/Filament/Admin/Resources/StudentResource/RelationManagers/SubmissionRelationManager.php`

**Form:**
- Auto-create User (name, email, password = NIS default)
- NIS, NISN, name, email, classroom select, gender, birth_date, phone, address
- Photo upload, status toggle

**Table:**
- NIS, name, classroom, gender, status badge
- Searchable: name, NIS, NISN
- Filters: classroom, major

**Header Actions:** Import Siswa, Export Siswa

---

## Task 4.3 — Student Service & Repository

| Item              | Detail                                    |
|-------------------|-------------------------------------------|
| Description       | Service + Repository layer untuk Student  |
| Deliverables      | Service, Repository, DTO                  |
| Prompt Ref        | PROMPT 20                                 |

**Files to Generate:**
- `app/Services/StudentService.php`
- `app/Repositories/StudentRepository.php`
- `app/DTOs/CreateStudentDTO.php`
- `app/DTOs/UpdateStudentDTO.php`
- `app/Http/Requests/StoreStudentRequest.php`
- `app/Http/Requests/UpdateStudentRequest.php`
- `app/Policies/StudentPolicy.php`

---

## Task 4.4 — Import & Export Student

| Item              | Detail                                    |
|-------------------|-------------------------------------------|
| Description       | Import/Export data siswa via Excel        |
| Deliverables      | Import + Export class                     |
| Prompt Ref        | PROMPT 21                                 |

**Files to Generate:**
- `app/Imports/StudentImport.php`
- `app/Exports/StudentExport.php`

**Import Rules:**
- Template: NIS, NISN, Nama, Email, Kelas, Gender, Phone
- Auto-create User account
- Auto-assign classroom based on name/level
- Validation: unique NIS, valid classroom, required fields

---

## Sprint 3 Checklist

- [ ] Teacher migration, model, factory, seeder
- [ ] Teacher Filament Resource (CRUD + search + filter)
- [ ] Teacher Service & Repository
- [ ] Teacher Policy
- [ ] Teacher Import (Excel)
- [ ] Teacher Export (Excel)
- [ ] Student migration, model, factory, seeder
- [ ] Student Filament Resource (CRUD + search + filter)
- [ ] Student Service & Repository
- [ ] Student Policy
- [ ] Student Import (Excel)
- [ ] Student Export (Excel)
- [ ] User Profile (avatar, edit, change password)

**Sprint Output:** Teacher & Student Management Complete ✅
