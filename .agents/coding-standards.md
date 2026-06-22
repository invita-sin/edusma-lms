# CODING STANDARDS & OPENCODE AI RULES

## EduSMA LMS

**Version:** 1.0

### Purpose

Dokumen ini mendefinisikan standar pengembangan yang wajib dipatuhi oleh seluruh developer dan AI coding assistant selama pengembangan EduSMA LMS.

---

## CORE PRINCIPLES

Prioritas utama:

1. Readability
2. Maintainability
3. Testability
4. Security
5. Performance

---

## DEVELOPMENT RULES

Seluruh implementasi wajib:

- SOLID Principles
- Clean Architecture
- Service Layer
- Repository Pattern
- Dependency Injection
- Laravel Best Practices

### Dilarang:

- Fat Controller
- Business Logic di Resource
- Business Logic di Model
- Query kompleks di View
- Hardcoded Values

---

## TECHNOLOGY STACK

| Komponen      | Teknologi       |
|---------------|-----------------|
| **Backend**   | Laravel 13      |
| **Admin Panel**| Filament v4    |
| **Frontend**  | Livewire, TailwindCSS |
| **Database**  | MySQL 8         |
| **Cache**     | Redis           |
| **Auth**      | Laravel Sanctum |
| **Authorization** | Spatie Permission, Laravel Policy |
| **Testing**   | Pest            |

---

## PROJECT STRUCTURE

```
app
├── Actions
├── Domains
├── Services
├── Repositories
├── DTOs
├── Policies
├── Jobs
├── Notifications
├── Exceptions
├── Filament
└── Support
```

---

## NAMING CONVENTIONS

| Elemen           | Case              | Contoh                          |
|------------------|-------------------|----------------------------------|
| Class            | PascalCase        | `TeacherService`, `StudentRepository`, `CreateAssignmentAction` |
| Method           | camelCase         | `createTeacher()`, `publishQuiz()`, `calculateFinalScore()` |
| Variables        | camelCase         | `studentScore`, `assignmentCount`, `teacherName` |
| Database Tables  | plural_snake_case | `students`, `teachers`, `assignment_submissions`, `quiz_attempts` |
| Columns          | snake_case        | `student_id`, `final_score`, `created_at` |

---

## CONTROLLER RULES

### Maximum Responsibility

- Request Validation
- Call Service
- Return Response

**Bad Example:**
```php
public function store(Request $request)
{
    $teacher = Teacher::create($request->all());

    Mail::to($teacher)->send(...);

    return redirect();
}
```

**Good Example:**
```php
public function store(StoreTeacherRequest $request)
{
    $this->teacherService->create(
        $request->validated()
    );

    return response()->json();
}
```

---

## SERVICE LAYER RULES

All business logic belongs here.

**Examples:** TeacherService, StudentService, CourseService, AssignmentService, QuizService, AttendanceService, GradeService, ReportService

Services must:

- Be stateless
- Be injectable
- Be testable

---

## REPOSITORY RULES

Repository responsible only for:

- Query
- Persistence

**Forbidden:** Business Logic, Validation, Authorization

**Example:** TeacherRepository, StudentRepository, CourseRepository

---

## DTO RULES

Every complex create/update operation must use DTO.

**Example:** `CreateStudentDTO`, `UpdateCourseDTO`, `CreateQuizDTO`

DTO is **Immutable**.

---

## MODEL RULES

Models should only contain:

- Relationships
- Scopes
- Casts

**Forbidden:** Business Logic, Notification Logic, Grade Calculation

**Allowed:**
```php
public function classroom()
{
    return $this->belongsTo(Classroom::class);
}
```

---

## QUERY RULES

Always use eager loading.

**Good:** `Course::with('teacher')->get();`

**Bad:** `Course::all();`

**N+1 Queries:** Forbidden

---

## VALIDATION RULES

Use FormRequest (100% required).

**Examples:** `StoreStudentRequest`, `UpdateStudentRequest`, `StoreAssignmentRequest`

**Forbidden:** Inline validation in Controller.

---

## AUTHORIZATION RULES

Every resource must have a **Policy**.

**Examples:** StudentPolicy, TeacherPolicy, CoursePolicy, AssignmentPolicy, QuizPolicy

**Forbidden:** Role checks inside Controller (`if(auth()->user()->role == 'admin')`)

**Use:** `$this->authorize('update', $course);`

---

## FILAMENT RULES

### Resource Responsibilities

- UI
- Form
- Table

**Forbidden:** Business Logic in Resource

Resource must call **Service Layer**.

**Bad:** `Teacher::create($data);`

**Good:** `$teacherService->create($dto);`

---

## LIVEWIRE RULES

Components must:

- Remain lightweight
- Delegate business logic

**Forbidden:** Complex database queries

---

## FILE UPLOAD RULES

- **Storage:** Public Disk or S3 Compatible
- **Validate:** Mime Type, File Size
- **Virus Scan Hook:** Prepared

---

## NOTIFICATION RULES

Use **Laravel Notifications**.

**Channels:** Database, Email

**Future:** WhatsApp, Push Notification

---

## EVENT DRIVEN RULES

Use Events.

**Examples:** `StudentCreated`, `AssignmentSubmitted`, `QuizCompleted`

**Listeners:** `SendNotification`, `GenerateActivityLog`

---

## QUEUE RULES

Heavy Process must use Queue.

**Examples:** PDF Generation, Excel Export, Bulk Import, Notification Sending

---

## TESTING RULES

New Feature **cannot be merged without tests**.

**Required:** Unit Test, Feature Test

**Coverage:** Minimum 80%

---

## CODE STYLE RULES

- **Formatter:** Laravel Pint
- **Run Before Commit:** `vendor/bin/pint`

---

## STATIC ANALYSIS

- **Tool:** PHPStan
- **Level:** Max
- **Run:** `vendor/bin/phpstan analyse`

---

## GIT WORKFLOW

| Branch            | Usage            |
|-------------------|------------------|
| `main`            | Main branch      |
| `develop`         | Development      |
| `feature/*`       | Feature branch   |

**Examples:** `feature/student-management`, `feature/quiz-module`, `feature/attendance`

---

## COMMIT CONVENTION

**Format:** `type(scope): message`

**Examples:**
- `feat(student): create student resource`
- `fix(quiz): scoring calculation`
- `refactor(course): improve repository`
- `test(attendance): add feature tests`

---

## PULL REQUEST RULES

**Must Include:** Purpose, Screenshot, Testing Result, Checklist

**Cannot Merge If:** Tests Fail, Coverage Drop, Code Review Rejected

---

## PERFORMANCE RULES

| Area              | Target           |
|-------------------|------------------|
| Response Time     | < 500 ms         |
| Dashboard         | < 2 seconds      |
| Report Generation | < 5 seconds      |

---

## SECURITY RULES

**Never Commit:** `.env`, API Keys, Secrets, Passwords

**Use:** Environment Variables

**Sanitize:** User Input

**Escape:** Output

---

## DATABASE RULES

- Every FK **Indexed**
- Every table: `timestamps()`
- Soft Delete where required

---

## LOGGING RULES

- Use Activity Logs
- **Never Log:** Passwords, Tokens, Sensitive Data

---

## DOCUMENTATION RULES

- Every Service: PHPDoc
- Complex Logic: Comment Required
- API: Swagger/OpenAPI

---

## OPENCODE AI MANDATORY RULES

When generating code, **Always**:

1. Create Migration
2. Create Model
3. Create DTO
4. Create Repository
5. Create Service
6. Create Policy
7. Create Request Validation
8. Create Tests

**Never** Skip Tests, Skip Policies, Put Business Logic In Resources, Put Business Logic In Controllers, or Generate Untested Features.

---

## DEFINITION OF DONE

Feature considered complete only if:

- [x] Migration Created
- [x] Model Created
- [x] Repository Created
- [x] Service Created
- [x] Policy Created
- [x] Validation Created
- [x] Tests Created
- [x] Documentation Updated
- [x] CI Passed
- [x] Code Review Approved

---

## FINAL PRINCIPLE

> "Simple code today is cheaper than clever code tomorrow."

Prioritaskan kode yang mudah dipahami, mudah diuji, dan mudah dirawat dibandingkan kode yang terlalu kompleks.
