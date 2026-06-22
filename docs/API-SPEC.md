# API SPECIFICATION

## EduSMA LMS

**Version:** 1.0

### Architecture

REST API

### Authentication

Laravel Sanctum

### Base URL

`/api/v1`

### Response Format

JSON

---

## API STANDARDS

### Success Response

```json
{
  "success": true,
  "message": "Data retrieved successfully",
  "data": {}
}
```

### Error Response

```json
{
  "success": false,
  "message": "Validation failed",
  "errors": {}
}
```

### Pagination Response

```json
{
  "success": true,
  "data": [],
  "meta": {
    "current_page": 1,
    "per_page": 15,
    "total": 100,
    "last_page": 7
  }
}
```

---

## AUTHENTICATION

### Login

```
POST /api/v1/auth/login
```

**Request:**
```json
{
  "email": "guru@school.com",
  "password": "password"
}
```

**Response:**
```json
{
  "success": true,
  "token": "sanctum_token",
  "user": {}
}
```

### Logout

```
POST /api/v1/auth/logout
```

*Authentication: Required*

### Profile

```
GET /api/v1/auth/profile
```

*Authentication: Required*

### Update Profile

```
PUT /api/v1/auth/profile
```

*Authentication: Required*

### Change Password

```
PUT /api/v1/auth/change-password
```

*Authentication: Required*

---

## DASHBOARD

### Dashboard Summary

```
GET /api/v1/dashboard
```

**Authentication:** Required

**Role:** Admin, Teacher, Student

**Response:**
```json
{
  "cards": [],
  "statistics": []
}
```

---

## ACADEMIC YEAR

| Method   | Endpoint                                  |
|----------|-------------------------------------------|
| GET      | /api/v1/academic-years                    |
| POST     | /api/v1/academic-years                    |
| GET      | /api/v1/academic-years/{id}               |
| PUT      | /api/v1/academic-years/{id}               |
| DELETE   | /api/v1/academic-years/{id}               |
| POST     | /api/v1/academic-years/{id}/activate      |

---

## SEMESTERS

| Method   | Endpoint                        |
|----------|---------------------------------|
| GET      | /api/v1/semesters               |
| POST     | /api/v1/semesters               |
| GET      | /api/v1/semesters/{id}          |
| PUT      | /api/v1/semesters/{id}          |
| DELETE   | /api/v1/semesters/{id}          |

---

## MAJORS

| Method   | Endpoint                        |
|----------|---------------------------------|
| GET      | /api/v1/majors                  |
| POST     | /api/v1/majors                  |
| GET      | /api/v1/majors/{id}             |
| PUT      | /api/v1/majors/{id}             |
| DELETE   | /api/v1/majors/{id}             |

---

## CLASSROOMS

| Method   | Endpoint                        |
|----------|---------------------------------|
| GET      | /api/v1/classrooms              |
| POST     | /api/v1/classrooms              |
| GET      | /api/v1/classrooms/{id}         |
| PUT      | /api/v1/classrooms/{id}         |
| DELETE   | /api/v1/classrooms/{id}         |

---

## SUBJECTS

| Method   | Endpoint                        |
|----------|---------------------------------|
| GET      | /api/v1/subjects                |
| POST     | /api/v1/subjects                |
| GET      | /api/v1/subjects/{id}           |
| PUT      | /api/v1/subjects/{id}           |
| DELETE   | /api/v1/subjects/{id}           |

---

## TEACHERS

| Method   | Endpoint                           |
|----------|------------------------------------|
| GET      | /api/v1/teachers                   |
| POST     | /api/v1/teachers                   |
| GET      | /api/v1/teachers/{id}              |
| PUT      | /api/v1/teachers/{id}              |
| DELETE   | /api/v1/teachers/{id}              |
| POST     | /api/v1/teachers/import            |
| GET      | /api/v1/teachers/export            |

**List Teachers** — Query Parameters: `search`, `page`, `per_page`

**Import Teachers** — Content-Type: `multipart/form-data` (File: xlsx)

---

## STUDENTS

| Method   | Endpoint                           |
|----------|------------------------------------|
| GET      | /api/v1/students                   |
| POST     | /api/v1/students                   |
| GET      | /api/v1/students/{id}              |
| PUT      | /api/v1/students/{id}              |
| DELETE   | /api/v1/students/{id}              |
| POST     | /api/v1/students/import            |
| GET      | /api/v1/students/export            |

---

## COURSES

| Method   | Endpoint                           |
|----------|------------------------------------|
| GET      | /api/v1/courses                    |
| POST     | /api/v1/courses                    |
| GET      | /api/v1/courses/{id}               |
| PUT      | /api/v1/courses/{id}               |
| DELETE   | /api/v1/courses/{id}               |

**Filters:** `teacher_id`, `classroom_id`, `subject_id`

---

## MATERIALS

| Method   | Endpoint                           |
|----------|------------------------------------|
| GET      | /api/v1/materials                  |
| POST     | /api/v1/materials                  |
| GET      | /api/v1/materials/{id}             |
| PUT      | /api/v1/materials/{id}             |
| DELETE   | /api/v1/materials/{id}             |
| GET      | /api/v1/materials/{id}/download    |

**Upload Material:** Content-Type: `multipart/form-data`

**Fields:** `title`, `description`, `file`

---

## ASSIGNMENTS

| Method   | Endpoint                           |
|----------|------------------------------------|
| GET      | /api/v1/assignments                |
| POST     | /api/v1/assignments                |
| GET      | /api/v1/assignments/{id}           |
| PUT      | /api/v1/assignments/{id}           |
| DELETE   | /api/v1/assignments/{id}           |

---

## ASSIGNMENT SUBMISSION

| Method   | Endpoint                                       |
|----------|-------------------------------------------------|
| POST     | /api/v1/assignments/{id}/submit                 |
| GET      | /api/v1/submissions/{id}                        |
| POST     | /api/v1/submissions/{id}/grade                  |

**Submit Fields:** `file`, `note`

**Grade Fields:** `score`, `feedback`

---

## QUIZZES

| Method   | Endpoint                           |
|----------|------------------------------------|
| GET      | /api/v1/quizzes                    |
| POST     | /api/v1/quizzes                    |
| GET      | /api/v1/quizzes/{id}               |
| PUT      | /api/v1/quizzes/{id}               |
| DELETE   | /api/v1/quizzes/{id}               |
| POST     | /api/v1/quizzes/{id}/publish       |

---

## QUIZ ATTEMPTS

| Method   | Endpoint                           |
|----------|------------------------------------|
| POST     | /api/v1/quizzes/{id}/start         |
| POST     | /api/v1/quizzes/{id}/submit        |
| GET      | /api/v1/quizzes/{id}/result        |

**Submit Request:**
```json
{
  "answers": []
}
```

---

## ATTENDANCE

| Method   | Endpoint                           |
|----------|------------------------------------|
| GET      | /api/v1/attendances                |
| POST     | /api/v1/attendances                |
| PUT      | /api/v1/attendances/{id}           |

**Record Attendance Request:**
```json
{
  "student_id": 1,
  "course_id": 1,
  "status": "present"
}
```

---

## GRADES

| Method   | Endpoint                           |
|----------|------------------------------------|
| GET      | /api/v1/grades                     |
| POST     | /api/v1/grades                     |
| PUT      | /api/v1/grades/{id}                |
| GET      | /api/v1/grades/report              |

---

## REPORTING

| Method   | Endpoint                               |
|----------|----------------------------------------|
| GET      | /api/v1/reports/students               |
| GET      | /api/v1/reports/attendance             |
| GET      | /api/v1/reports/grades                 |
| GET      | /api/v1/reports/export/pdf             |
| GET      | /api/v1/reports/export/excel           |

---

## NOTIFICATIONS

| Method   | Endpoint                               |
|----------|----------------------------------------|
| GET      | /api/v1/notifications                  |
| POST     | /api/v1/notifications/{id}/read        |
| POST     | /api/v1/notifications/read-all         |

---

## SETTINGS

| Method   | Endpoint                               |
|----------|----------------------------------------|
| GET      | /api/v1/settings/school                |
| PUT      | /api/v1/settings/school                |
| GET      | /api/v1/settings/academic              |
| PUT      | /api/v1/settings/academic              |

---

## ACTIVITY LOGS

| Method   | Endpoint                               |
|----------|----------------------------------------|
| GET      | /api/v1/activity-logs                  |

**Role:** Super Admin, Admin

---

## API SECURITY

| Komponen        | Detail                            |
|-----------------|-----------------------------------|
| Authentication  | Laravel Sanctum                   |
| Authorization   | Laravel Policies + Spatie Permission |

### Rate Limiting

| Role          | Limit            |
|---------------|------------------|
| Guest         | 60 requests/min  |
| Authenticated | 120 requests/min |
| Admin         | 300 requests/min |

---

## API VERSIONING

| Aspek                  | Detail                     |
|------------------------|----------------------------|
| Current                | `/api/v1`                  |
| Future                 | `/api/v2`                  |
| Backward Compatibility | Minimal 12 months support  |

---

## OPENAPI READY

Seluruh endpoint harus dapat diekspor ke:

- Swagger
- OpenAPI 3.0
- Postman Collection

menggunakan package:

- Dedoc Scramble
- atau Laravel OpenAPI
