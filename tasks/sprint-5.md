# Sprint 5 — Assignment & Quiz

**Duration:** 7 Hari

**Goal:** Membangun sistem evaluasi pembelajaran (Tugas dan Kuis).

**Milestone:** Assessment & Reporting

---

## Task 7.1 — Assignment Entity

| Item              | Detail                                    |
|-------------------|-------------------------------------------|
| Description       | Migration + Model Assignment              |
| Deliverables      | Migration, Model, Factory                 |
| Prompt Ref        | PROMPT 31, PROMPT 33                      |

**Files to Generate:**
- `database/migrations/xxxx_create_assignments_table.php`
- `app/Models/Assignment.php`
- `database/factories/AssignmentFactory.php`

**Fields:**
| Column      | Type         | Notes                |
|-------------|--------------|----------------------|
| course_id   | BIGINT FK    | belongsTo Course     |
| title       | VARCHAR(255) |                      |
| description | LONGTEXT     | nullable             |
| attachment  | VARCHAR(255) | nullable             |
| deadline    | DATETIME     |                      |
| max_score   | INTEGER      | default 100          |
| status      | ENUM(draft, published, closed) | |

**Model Relationships:**
```php
class Assignment extends Model
{
    public function course(): BelongsTo
    public function submissions(): HasMany
}
```

---

## Task 7.2 — Submission Entity

| Item              | Detail                                    |
|-------------------|-------------------------------------------|
| Description       | Migration + Model AssignmentSubmission    |
| Deliverables      | Migration, Model, Factory                 |
| Prompt Ref        | PROMPT 32                                 |

**Files to Generate:**
- `database/migrations/xxxx_create_assignment_submissions_table.php`
- `app/Models/AssignmentSubmission.php`
- `database/factories/AssignmentSubmissionFactory.php`

**Fields:**
| Column        | Type          | Notes                     |
|---------------|---------------|---------------------------|
| assignment_id | BIGINT FK     | belongsTo Assignment      |
| student_id    | BIGINT FK     | belongsTo Student         |
| file_path     | VARCHAR(255)  |                           |
| note          | TEXT          | nullable                  |
| score         | DECIMAL(5,2)  | nullable (diisi guru)     |
| feedback      | TEXT          | nullable (diisi guru)     |
| submitted_at  | DATETIME      |                           |
| status        | ENUM(submitted, graded, late) |        |

**Indexes:** assignment_id, student_id

---

## Task 7.3 — Assignment Filament Resource

| Item              | Detail                                    |
|-------------------|-------------------------------------------|
| Description       | Filament Resource untuk Assignment (Admin + Teacher) |
| Deliverables      | Resource + Relation Manager               |
| Prompt Ref        | PROMPT 34                                 |

**Files to Generate:**
- `app/Filament/Admin/Resources/AssignmentResource.php`
- `app/Filament/Teacher/Resources/MyAssignmentResource.php`
- `app/Filament/Admin/Resources/AssignmentResource/RelationManagers/SubmissionsRelationManager.php`

**Form (Teacher):**
- Select course (owned only), title, description
- File attachment, deadline picker, max score
- Status toggle (draft/published)

**Table:**
- Title, course, deadline, total submission count, status badge

**Submission Relation Manager:**
- List students, submitted file, score input, feedback textarea
- Filter: submitted, graded, late

---

## Task 7.4 — Assignment Workflow

| Item              | Detail                                    |
|-------------------|-------------------------------------------|
| Description       | Complete assignment workflow               |
| Deliverables      | Service, Repository, DTO, Policy          |
| Prompt Ref        | PROMPT 34                                 |

**Files to Generate:**
- `app/Services/AssignmentService.php`
- `app/Services/SubmissionService.php`
- `app/Repositories/AssignmentRepository.php`
- `app/Repositories/SubmissionRepository.php`
- `app/DTOs/CreateAssignmentDTO.php`
- `app/DTOs/GradeSubmissionDTO.php`
- `app/Http/Requests/StoreAssignmentRequest.php`
- `app/Http/Requests/SubmitAssignmentRequest.php`
- `app/Http/Requests/GradeSubmissionRequest.php`
- `app/Policies/AssignmentPolicy.php`
- `app/Policies/SubmissionPolicy.php`

**Workflow:**
```
Teacher → Create Assignment → Publish
    ↓
Student → View Assignment → Upload Submission
    ↓
Teacher → Review → Input Score & Feedback
    ↓
Student → View Grade
```

**Late Submission Logic:**
- Jika submit_at > deadline → status = 'late'
- Guru dapat memberi nilai dengan penalti atau tetap

---

## Task 7.5 — Assignment Notification

| Item              | Detail                                    |
|-------------------|-------------------------------------------|
| Description       | Notifikasi saat tugas dibuat              |
| Deliverables      | Notification class                        |
| Prompt Ref        | PROMPT 35                                 |

**Files to Generate:**
- `app/Notifications/AssignmentCreated.php`
- `app/Notifications/SubmissionGraded.php`
- `app/Events/AssignmentCreated.php`
- `app/Listeners/SendAssignmentNotification.php`

**Events:**
- `AssignmentCreated` → notify students in course
- `SubmissionGraded` → notify student

---

## Task 8.1 — Quiz Migrations

| Item              | Detail                                    |
|-------------------|-------------------------------------------|
| Description       | 5 migrations untuk quiz system            |
| Deliverables      | 5 migration files                         |
| Prompt Ref        | PROMPT 36                                 |

**Files to Generate:**
- `database/migrations/xxxx_create_quizzes_table.php`
- `database/migrations/xxxx_create_quiz_questions_table.php`
- `database/migrations/xxxx_create_quiz_options_table.php`
- `database/migrations/xxxx_create_quiz_attempts_table.php`
- `database/migrations/xxxx_create_quiz_answers_table.php`

**Tables:**

| Table           | Key Fields                                         |
|-----------------|-----------------------------------------------------|
| quizzes         | course_id, title, description, duration, attempt_limit, passing_score, published |
| quiz_questions  | quiz_id, question, type (MC/essay), points          |
| quiz_options    | question_id, option_text, is_correct                |
| quiz_attempts   | quiz_id, student_id, started_at, finished_at, score, status |
| quiz_answers    | attempt_id, question_id, selected_option_id, essay_answer, score |

---

## Task 8.2 — Quiz Models & Relationships

| Item              | Detail                                    |
|-------------------|-------------------------------------------|
| Description       | Models + relationships untuk quiz module   |
| Deliverables      | 5 models                                   |
| Prompt Ref        | PROMPT 37                                 |

**Files to Generate:**
- `app/Models/Quiz.php`
- `app/Models/QuizQuestion.php`
- `app/Models/QuizOption.php`
- `app/Models/QuizAttempt.php`
- `app/Models/QuizAnswer.php`

**Relationships:**
```php
Quiz → hasMany Questions
Question → belongsTo Quiz → hasMany Options → hasMany Answers
Option → belongsTo Question
Attempt → belongsTo Quiz → belongsTo Student → hasMany Answers
Answer → belongsTo Attempt → belongsTo Question
```

---

## Task 8.3 — Quiz Builder (Filament)

| Item              | Detail                                    |
|-------------------|-------------------------------------------|
| Description       | Repeater-based quiz builder               |
| Deliverables      | Quiz Resource with nested questions       |
| Prompt Ref        | PROMPT 38                                 |

**Files to Generate:**
- `app/Filament/Admin/Resources/QuizResource.php`
- `app/Filament/Teacher/Resources/MyQuizResource.php`
- `app/Filament/Resources/QuizResource/RelationManagers/QuestionsRelationManager.php`

**Quiz Form:**
- Select course, title, description
- Duration (minutes), attempt limit, passing score
- Published toggle

**Questions Repeater:**
- Question text (textarea)
- Type select (multiple_choice / essay)
- Points (integer)
- If MC → Options sub-repeater with is_correct toggle

---

## Task 8.4 — Auto Grading (Multiple Choice)

| Item              | Detail                                    |
|-------------------|-------------------------------------------|
| Description       | Auto grading untuk soal multiple choice   |
| Deliverables      | Grading service                           |
| Prompt Ref        | PROMPT 39                                 |

**Files to Generate:**
- `app/Services/QuizAutoGradingService.php`
- `app/Services/QuizService.php`
- `app/Repositories/QuizRepository.php`
- `app/DTOs/SubmitQuizDTO.php`

**Logic:**
- Bandingkan `selected_option_id` dengan `quiz_option.is_correct`
- Jika benar → beri points sesuai question
- Jika salah → 0
- Total score = sum of all correct points
- Simpan score di `quiz_attempts.score`

---

## Task 8.5 — Manual Grading (Essay)

| Item              | Detail                                    |
|-------------------|-------------------------------------------|
| Description       | Manual review untuk soal essay            |
| Deliverables      | Manual grading interface                  |
| Prompt Ref        | PROMPT 40                                 |

**Files to Generate:**
- `app/Filament/Teacher/Resources/QuizAttemptResource.php` (view + grade)
- `app/Services/QuizManualGradingService.php`

**Teacher Flow:**
1. Lihat daftar student yang sudah submit quiz
2. Klik attempt → lihat jawaban essay
3. Input score per question
4. System menghitung total score otomatis

---

## Task 8.6 — Random Question Engine

| Item              | Detail                                    |
|-------------------|-------------------------------------------|
| Description       | Randomisasi soal dan opsi jawaban         |
| Deliverables      | Random engine service                     |
| Prompt Ref        | PROMPT 41                                 |

**Files to Generate:**
- `app/Services/QuizRandomizationService.php`

**Features:**
- Random order of questions
- Random order of answer options (MC only)
- Configured via quiz settings (toggle)
- Consistent for same attempt (once started, order is fixed)

---

## Sprint 5 Checklist

- [ ] Assignment migration, model
- [ ] Submission migration, model
- [ ] Assignment Filament Resource (Admin + Teacher)
- [ ] Submission Relation Manager
- [ ] Assignment Service, Repository, DTO, Policy
- [ ] Submission Service, Repository, Policy
- [ ] Assignment workflow (create → submit → grade)
- [ ] Late submission handling
- [ ] Assignment notification
- [ ] Submission graded notification
- [ ] 5 quiz migrations
- [ ] 5 quiz models
- [ ] Quiz Filament Resource
- [ ] Quiz question builder with repeater
- [ ] Quiz Service, Repository, Policy
- [ ] Auto grading (MC)
- [ ] Manual grading (essay)
- [ ] Quiz attempt tracking
- [ ] Random question engine
- [ ] Student quiz attempt page

**Sprint Output:** Assessment Module Complete ✅
