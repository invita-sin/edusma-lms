# TESTING STRATEGY DOCUMENT

## EduSMA LMS

**Version:** 1.0

### Purpose

Menentukan standar pengujian aplikasi agar seluruh fitur LMS berjalan stabil, aman, dan siap digunakan dalam lingkungan produksi.

---

## TESTING OBJECTIVES

Tujuan utama:

- Memastikan seluruh fitur berjalan sesuai PRD
- Memastikan keamanan authorization
- Mencegah regression bug
- Menjaga kualitas kode
- Menjamin stabilitas sebelum deployment

---

## TESTING PYRAMID

```
            E2E TEST
               ▲
               │
         FEATURE TEST
               ▲
               │
          UNIT TEST
```

### Target Komposisi

| Level         | Target |
|---------------|--------|
| Unit Test     | 70%    |
| Feature Test  | 25%    |
| E2E Test      | 5%     |

---

## TESTING STACK

| Komponen            | Detail                     |
|---------------------|----------------------------|
| Framework           | Pest PHP                   |
| Laravel Testing     | Built-in Laravel Testing   |
| Mocking             | Mockery                    |
| Database Testing    | RefreshDatabase            |
| Coverage Tool       | Xdebug atau PCOV           |

---

## COVERAGE TARGET

| Metric              | Target |
|---------------------|--------|
| Minimum Coverage    | 80%    |
| Target Coverage     | 90%    |
| Critical Module     | 100%   |

---

## CRITICAL MODULES

Wajib memiliki coverage penuh:

- Authentication
- Authorization
- Assignment Submission
- Quiz Attempt
- Grade Calculation
- Attendance
- Reporting

---

## UNIT TEST STRATEGY

**Target:** Business Logic

### Services — Wajib Unit Test

- AcademicYearService
- SemesterService
- TeacherService
- StudentService
- CourseService
- MaterialService
- AssignmentService
- QuizService
- AttendanceService
- GradeService
- NotificationService
- ReportService

### Repositories — Wajib Unit Test

- TeacherRepository
- StudentRepository
- CourseRepository
- AssignmentRepository
- QuizRepository
- AttendanceRepository
- GradeRepository

### Calculation Tests

**Grade Formula:**
```
Final Score
= Assignment × 20%
+ Quiz × 20%
+ Midterm × 30%
+ Final Exam × 30%
```

**Test Cases:** Normal Score, Minimum Score, Maximum Score, Decimal Score, Null Value

---

## FEATURE TEST STRATEGY

### Authentication

**Test Cases:** Login Success, Login Invalid Password, Login Inactive User, Logout, Forgot Password, Reset Password

### Authorization

**Test Cases:** Admin Access, Teacher Access, Student Access, Unauthorized Access, Cross Role Access, Policy Ownership

### Academic Module

**Test Cases:** Create Academic Year, Update Academic Year, Delete Academic Year, Activate Academic Year

### Teacher Module

**Test Cases:** Create Teacher, Update Teacher, Delete Teacher, Import Teacher, Export Teacher

### Student Module

**Test Cases:** Create Student, Update Student, Delete Student, Import Student, Export Student

### Course Module

**Test Cases:** Create Course, Assign Teacher, Assign Subject, Assign Classroom, Delete Course

### Material Module

**Test Cases:** Upload Material, Update Material, Delete Material, Download Material, Preview Material

### Assignment Module

**Test Cases:** Create Assignment, Edit Assignment, Delete Assignment, Submit Assignment, Late Submission, Grade Submission

### Quiz Module

**Test Cases:** Create Quiz, Publish Quiz, Start Quiz, Submit Quiz, Auto Grading, Essay Grading, Random Question

### Attendance Module

**Test Cases:** Create Attendance, Update Attendance, Attendance Report

### Grade Module

**Test Cases:** Create Grade, Update Grade, Calculate Grade, Export Grade

### Reporting Module

**Test Cases:** Generate PDF, Generate Excel, Attendance Report, Student Report, Grade Report

---

## SECURITY TESTING

### Policy Test

**Verify:**
- Teacher Cannot Edit Other Teacher Course
- Teacher Cannot Delete Other Teacher Material
- Student Cannot Access Other Student Grade
- Student Cannot Access Other Student Submission

### Permission Test

**Verify:**
- Role Based Access
- Permission Based Access

### File Security Test

**Verify:**
- Invalid File Type
- Large File Upload
- Virus Scan Hook
- Unauthorized Download

---

## API TESTING

| Aspek          | Detail                |
|----------------|-----------------------|
| Authentication | Bearer Token Required |
| Authorization  | Policy Check          |
| Validation     | Required Fields, Invalid Data, Boundary Values |

**Rate Limiting:**

| Role          | Limit        |
|---------------|--------------|
| Guest         | 60/minute    |
| Authenticated | 120/minute   |
| Admin         | 300/minute   |

---

## PERFORMANCE TESTING

### Database

**Verify:** N+1 Queries, Index Usage, Query Time

**Target:** < 100 ms per critical query

### Page Load

| Dashboard          | Target        |
|--------------------|---------------|
| Admin Dashboard    | < 2 seconds   |
| Teacher Dashboard  | < 2 seconds   |
| Student Dashboard  | < 2 seconds   |

### Report Generation

| Format   | Target      |
|----------|-------------|
| PDF      | < 5 seconds |
| Excel    | < 5 seconds |

---

## UAT STRATEGY

**User Acceptance Testing**

**Participants:** Admin Sekolah, Guru, Siswa

**Scenario Count:** Minimum 50 Scenarios

### Admin UAT

Create Teacher, Create Student, Create Classroom, Generate Reports, Manage Settings

### Teacher UAT

Create Material, Create Assignment, Create Quiz, Input Attendance, Input Grade

### Student UAT

View Material, Submit Assignment, Take Quiz, View Grades, View Attendance

---

## REGRESSION TESTING

**Run Before:** Every Release

**Modules:** Authentication, Assignment, Quiz, Attendance, Grades, Reports

---

## AUTOMATION STRATEGY

### GitHub Actions Pipeline

```
Push
  ↓
Test
  ↓
Coverage
  ↓
Build
  ↓
Deploy
```

### Build Blocker Rules

| Condition               | Action |
|-------------------------|--------|
| Coverage < 80%          | Fail   |
| Feature Test Fail       | Fail   |
| Policy Test Fail        | Fail   |

---

## TEST DATA STRATEGY

| Data           | Count   |
|----------------|---------|
| Teachers       | 50      |
| Students       | 1000    |
| Courses        | 100     |
| Assignments    | 1000    |
| Quiz Attempts  | 10000   |

**Purpose:** Stress Testing

---

## BUG SEVERITY

| Level    | Description                  |
|----------|------------------------------|
| Critical | System Cannot Operate        |
| High     | Core Feature Broken          |
| Medium   | Feature Works With Issue     |
| Low      | UI Issue                     |

---

## RELEASE CRITERIA

Release Allowed Only If:

- [ ] All Tests Pass
- [ ] Coverage ≥ 80%
- [ ] No Critical Bugs
- [ ] No High Severity Bugs
- [ ] Performance Targets Met
- [ ] Security Tests Passed
- [ ] UAT Approved

---

## QUALITY GATES

```
Development
  ↓
Code Review
  ↓
Unit Test
  ↓
Feature Test
  ↓
Security Test
  ↓
UAT
  ↓
Production Release
```

---

## SUCCESS METRICS

| Metric                | Target         |
|-----------------------|----------------|
| Coverage              | ≥ 80%          |
| Critical Bugs         | 0              |
| High Bugs             | 0              |
| Failed Deployments    | < 1%           |
| User Reported Bugs    | < 5 per month  |
