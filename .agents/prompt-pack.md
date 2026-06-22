# OPENCODE PROMPT PACK

## EduSMA LMS

**Version:** 1.0

### Purpose

Dokumen ini digunakan sebagai kumpulan prompt standar untuk OpenCode AI agar dapat mengembangkan LMS secara bertahap tanpa kehilangan konteks arsitektur.

---

## MASTER CONTEXT PROMPT

Gunakan prompt ini pada awal setiap sesi OpenCode.

> "Anda adalah Senior Laravel Architect yang bertugas membangun EduSMA LMS menggunakan Laravel 13, Filament v4, Livewire, TailwindCSS, MySQL, Sanctum, Redis, dan Spatie Permission.
>
> Ikuti seluruh aturan berikut:
>
> - Gunakan PSR-12
> - Gunakan SOLID Principle
> - Gunakan Service Layer
> - Gunakan Repository Pattern
> - Gunakan Filament Resource
> - Gunakan Form Request Validation
> - Gunakan Eloquent Relationship
> - Gunakan Migration First Development
> - Gunakan Pest Testing
> - Jangan membuat kode duplikat
> - Berikan kode produksi yang siap digunakan
>
> Sebelum menghasilkan kode, selalu tampilkan:
>
> 1. Tujuan task
> 2. File yang dibuat
> 3. Dependency yang diperlukan
>
> Kemudian hasilkan kode lengkap."

---

## PHASE 1 — FOUNDATION

### PROMPT 01

Generate seluruh migration dan seeder untuk:

- roles
- permissions

menggunakan Spatie Permission.

### PROMPT 02

Generate User model lengkap dengan:

- role
- policy
- relationship

sesuai DDD.

### PROMPT 03

Generate konfigurasi Laravel Sanctum lengkap.

### PROMPT 04

Generate konfigurasi multi panel Filament:

- Admin
- Teacher
- Student

beserta middleware dan provider.

### PROMPT 05

Generate seluruh policy untuk:

- Admin
- Teacher
- Student

---

## PHASE 2 — ACADEMIC MODULE

### PROMPT 06

Generate migration, model, factory dan seeder untuk AcademicYear.

### PROMPT 07

Generate Filament Resource AcademicYear.

### PROMPT 08

Generate migration, model dan resource Semester.

### PROMPT 09

Generate migration, model dan resource Major.

### PROMPT 10

Generate migration, model dan resource Classroom.

### PROMPT 11

Generate migration, model dan resource Subject.

---

## PHASE 3 — TEACHER MODULE

### PROMPT 12

Generate migration Teacher sesuai DDD.

### PROMPT 13

Generate Teacher model lengkap dengan relationship.

### PROMPT 14

Generate Teacher Filament Resource.

### PROMPT 15

Generate Teacher Service dan Repository.

### PROMPT 16

Generate Import Guru menggunakan Laravel Excel.

---

## PHASE 4 — STUDENT MODULE

### PROMPT 17

Generate migration Student sesuai DDD.

### PROMPT 18

Generate Student model lengkap dengan relationship.

### PROMPT 19

Generate Student Resource Filament.

### PROMPT 20

Generate Student Service dan Repository.

### PROMPT 21

Generate Import dan Export Student menggunakan Laravel Excel.

---

## PHASE 5 — COURSE MODULE

### PROMPT 22

Generate migration Course sesuai DDD.

### PROMPT 23

Generate model Course lengkap dengan relationship.

### PROMPT 24

Generate Course Resource Filament.

### PROMPT 25

Generate Service Course Assignment: Teacher, Classroom, Subject.

---

## PHASE 6 — MATERIAL MODULE

### PROMPT 26

Generate migration Material.

### PROMPT 27

Generate Material model.

### PROMPT 28

Generate Material Resource Filament.

### PROMPT 29

Generate upload file service menggunakan Laravel Storage.

### PROMPT 30

Generate PDF preview dan download module.

---

## PHASE 7 — ASSIGNMENT MODULE

### PROMPT 31

Generate migration Assignment.

### PROMPT 32

Generate migration AssignmentSubmission.

### PROMPT 33

Generate model Assignment lengkap.

### PROMPT 34

Generate workflow: Guru membuat tugas. Siswa submit tugas. Guru memberi nilai.

### PROMPT 35

Generate notification ketika tugas dibuat.

---

## PHASE 8 — QUIZ MODULE

### PROMPT 36

Generate migration: quizzes, quiz_questions, quiz_options, quiz_attempts, quiz_answers.

### PROMPT 37

Generate model dan relationship seluruh quiz module.

### PROMPT 38

Generate quiz builder Filament.

### PROMPT 39

Generate auto grading multiple choice.

### PROMPT 40

Generate manual grading essay.

### PROMPT 41

Generate random question engine.

---

## PHASE 9 — ATTENDANCE MODULE

### PROMPT 42

Generate migration Attendance.

### PROMPT 43

Generate Attendance Resource.

### PROMPT 44

Generate attendance report service.

---

## PHASE 10 — GRADE MODULE

### PROMPT 45

Generate migration Grade.

### PROMPT 46

Generate grade calculation service.

**Formula:** Assignment 20% + Quiz 20% + Midterm 30% + Final Exam 30%

### PROMPT 47

Generate grade report service.

---

## PHASE 11 — DASHBOARD

### PROMPT 48

Generate Admin Dashboard Widgets.

### PROMPT 49

Generate Teacher Dashboard Widgets.

### PROMPT 50

Generate Student Dashboard Widgets.

---

## PHASE 12 — REPORTING

### PROMPT 51

Generate PDF reporting service.

### PROMPT 52

Generate Excel export service.

### PROMPT 53

Generate attendance export.

### PROMPT 54

Generate student report export.

---

## PHASE 13 — NOTIFICATION

### PROMPT 55

Generate database notification module.

### PROMPT 56

Generate email notification module.

---

## PHASE 14 — SETTINGS

### PROMPT 57

Generate migration Setting.

### PROMPT 58

Generate School Settings Resource.

### PROMPT 59

Generate Academic Settings Resource.

---

## PHASE 15 — LOGGING

### PROMPT 60

Generate Activity Log implementation menggunakan Spatie Activity Log.

---

## PHASE 16 — TESTING

### PROMPT 61

Generate Pest Unit Test untuk seluruh Service Layer.

### PROMPT 62

Generate Pest Feature Test untuk Authentication.

### PROMPT 63

Generate Pest Feature Test untuk Assignment Module.

### PROMPT 64

Generate Pest Feature Test untuk Quiz Module.

### PROMPT 65

Generate Pest Feature Test untuk Attendance Module.

---

## PHASE 17 — DEPLOYMENT

### PROMPT 66

Generate GitHub Actions Workflow: Test, Build, Deploy.

### PROMPT 67

Generate deployment guide Ubuntu 24.04.

### PROMPT 68

Generate Nginx Configuration.

### PROMPT 69

Generate Supervisor Configuration.

### PROMPT 70

Generate Production Checklist.

---

## FINAL PROMPT

### PROMPT 71

Audit seluruh project terhadap PRD, SAD, DDD, TBS.

Kemudian:

1. Cari bug potensial
2. Cari security issue
3. Cari performance issue
4. Cari database issue
5. Cari authorization issue
6. Berikan solusi terbaik

dan hasilkan laporan audit lengkap.
