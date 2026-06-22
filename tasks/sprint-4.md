# Sprint 4 — Course & Learning

**Duration:** 7 Hari

**Goal:** Membangun sistem pembelajaran (Course, Material, Upload, Preview).

**Milestone:** Learning Management

---

## Task 5.1 — Course Entity

| Item              | Detail                                    |
|-------------------|-------------------------------------------|
| Description       | Migration + Model Course (mapping guru, kelas, mapel) |
| Deliverables      | Migration, Model, Factory, Seeder         |
| Prompt Ref        | PROMPT 22, PROMPT 23                      |

**Files to Generate:**
- `database/migrations/xxxx_create_courses_table.php`
- `app/Models/Course.php`
- `database/factories/CourseFactory.php`
- `database/seeders/CourseSeeder.php`

**Fields:**
| Column       | Type        | Notes                   |
|--------------|-------------|-------------------------|
| teacher_id   | BIGINT FK   | belongsTo Teacher       |
| subject_id   | BIGINT FK   | belongsTo Subject       |
| classroom_id | BIGINT FK   | belongsTo Classroom     |
| semester_id  | BIGINT FK   | belongsTo Semester      |
| title        | VARCHAR(255)|                          |
| description  | TEXT        | nullable                |
| status       | ENUM(draft, active, archived) | default draft |

**Indexes:** teacher_id, subject_id, classroom_id, semester_id

**Model Relationships:**
```php
class Course extends Model
{
    public function teacher(): BelongsTo
    public function subject(): BelongsTo
    public function classroom(): BelongsTo
    public function semester(): BelongsTo
    public function materials(): HasMany
    public function assignments(): HasMany
    public function quizzes(): HasMany
    public function attendances(): HasMany
    public function grades(): HasMany
}
```

---

## Task 5.2 — Course Resource

| Item              | Detail                                    |
|-------------------|-------------------------------------------|
| Description       | Filament Resource untuk Course            |
| Deliverables      | Resource + Relation Managers              |
| Prompt Ref        | PROMPT 24                                 |

**Files to Generate:**
- `app/Filament/Admin/Resources/CourseResource.php`
- `app/Filament/Admin/Resources/CourseResource/RelationManagers/MaterialsRelationManager.php`
- `app/Filament/Admin/Resources/CourseResource/RelationManagers/AssignmentsRelationManager.php`
- `app/Filament/Admin/Resources/CourseResource/RelationManagers/QuizzesRelationManager.php`
- `app/Filament/Admin/Resources/CourseResource/RelationManagers/AttendanceRelationManager.php`
- `app/Filament/Admin/Resources/CourseResource/RelationManagers/GradesRelationManager.php`

**Form:**
- Select: Teacher, Subject, Classroom, Semester
- Input: Title, Description
- Status toggle (draft/active)

**Table:**
- Title, teacher, subject, classroom, semester, status badge
- Searchable & filterable

---

## Task 5.3 — Course Service

| Item              | Detail                                    |
|-------------------|-------------------------------------------|
| Description       | Service layer untuk assignment course     |
| Deliverables      | Service, Repository, DTO, Policy          |
| Prompt Ref        | PROMPT 25                                 |

**Files to Generate:**
- `app/Services/CourseService.php`
- `app/Repositories/CourseRepository.php`
- `app/DTOs/CreateCourseDTO.php`
- `app/DTOs/UpdateCourseDTO.php`
- `app/Http/Requests/StoreCourseRequest.php`
- `app/Http/Requests/UpdateCourseRequest.php`
- `app/Policies/CoursePolicy.php`

**Teacher Panel Version:**
- `app/Filament/Teacher/Resources/MyCourseResource.php` — filtered by ownership

---

## Task 6.1 — Material Entity

| Item              | Detail                                    |
|-------------------|-------------------------------------------|
| Description       | Migration + Model Material                |
| Deliverables      | Migration, Model, Factory                 |
| Prompt Ref        | PROMPT 26, PROMPT 27                      |

**Files to Generate:**
- `database/migrations/xxxx_create_materials_table.php`
- `app/Models/Material.php`
- `database/factories/MaterialFactory.php`

**Fields:**
| Column       | Type         | Notes                |
|--------------|--------------|----------------------|
| course_id    | BIGINT FK    | belongsTo Course     |
| title        | VARCHAR(255) |                      |
| description  | LONGTEXT     | nullable             |
| file_path    | VARCHAR(255) |                      |
| file_type    | VARCHAR(50)  | pdf, docx, pptx, mp4 |
| file_size    | INTEGER      | bytes                |
| published_at | DATETIME     | nullable             |

**Allowed File Types:** PDF, DOCX, PPTX, MP4
**Max Size:** 50 MB

---

## Task 6.2 — Material Resource

| Item              | Detail                                    |
|-------------------|-------------------------------------------|
| Description       | Filament Resource untuk Material          |
| Deliverables      | Resource                                  |
| Prompt Ref        | PROMPT 28                                 |

**Files to Generate:**
- `app/Filament/Admin/Resources/MaterialResource.php`
- `app/Filament/Teacher/Resources/MyMaterialResource.php`

**Form:**
- Select course, title, description
- File upload (validation: mime types, max size)
- Publish date picker

**Table:**
- Title, course, file type icon, publish date, download action

---

## Task 6.3 — Upload Service

| Item              | Detail                                    |
|-------------------|-------------------------------------------|
| Description       | File upload service dengan Laravel Storage |
| Deliverables      | Upload service, validation                |
| Prompt Ref        | PROMPT 29                                 |

**Files to Generate:**
- `app/Services/FileUploadService.php`
- `app/Http/Requests/UploadMaterialRequest.php`

**Service Methods:**
```php
class FileUploadService
{
    public function upload(UploadedFile $file, string $path): string
    public function delete(string $path): bool
    public function getUrl(string $path): string
}
```

**Storage Structure:**
```
storage/
  materials/
    {course_id}/
      {filename}
```

---

## Task 6.4 — Material Preview & Download

| Item              | Detail                                    |
|-------------------|-------------------------------------------|
| Description       | Preview PDF dan download module           |
| Deliverables      | Preview page, download route              |
| Prompt Ref        | PROMPT 30                                 |

**Files to Generate:**
- `app/Http/Controllers/MaterialController.php`
- `routes/web.php` — download route with auth + policy

**Features:**
- Preview PDF (inline viewer)
- Download file with authorization check
- Track download activity

---

## Sprint 4 Checklist

- [ ] Course migration, model, factory, seeder
- [ ] Course Filament Resource
- [ ] Course Relation Managers (Materials, Assignments, Quizzes, Attendance, Grades)
- [ ] Course Service, Repository, DTO, Policy
- [ ] Teacher Panel: MyCourseResource (ownership filter)
- [ ] Material migration, model, factory
- [ ] Material Filament Resource (Admin)
- [ ] Teacher Panel: MyMaterialResource
- [ ] File upload service (Laravel Storage)
- [ ] File validation (mime types, max 50MB)
- [ ] PDF preview
- [ ] Download route with auth & policy
- [ ] New Material notification

**Sprint Output:** Learning Module Complete ✅
