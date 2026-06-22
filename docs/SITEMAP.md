# SITEMAP & NAVIGATION FLOW

## EduSMA LMS

**Version:** 1.0

### Tech Stack

- Laravel 13
- Filament v4
- Livewire
- MySQL

---

## APPLICATION STRUCTURE

```
EduSMA LMS
├── Public Area
├── Authentication
├── Admin Portal
├── Teacher Portal
└── Student Portal
```

---

## PUBLIC AREA

**Accessible Without Login**

### Pages

- Landing Page
- Login
- Forgot Password
- Reset Password

---

### LANDING PAGE

**Path:** `/`

**Sections:** Hero Section, Features, Benefits, About School, Contact

**Actions:** Login, Learn More

---

## AUTHENTICATION

**Path:** `/login`

**Features:** Login, Remember Me, Forgot Password

**Redirect Rules:**

| Role        | Redirect     |
|-------------|--------------|
| Super Admin | `/admin`     |
| Admin       | `/admin`     |
| Guru        | `/teacher`   |
| Siswa       | `/student`   |

---

## ADMIN PORTAL

**Path:** `/admin`

**Purpose:** Mengelola seluruh sistem LMS.

### ADMIN DASHBOARD

**Path:** `/admin`

**Widgets:** Total Guru, Total Siswa, Total Kelas, Total Mata Pelajaran, Total Course, Aktivitas Terbaru

---

### MENU : AKADEMIK

**Parent Menu:** Akademik

#### Tahun Ajaran

**Path:** `/admin/academic-years`

**Features:** Create, Edit, Delete, Activate

#### Semester

**Path:** `/admin/semesters`

**Features:** CRUD

#### Jurusan

**Path:** `/admin/majors`

**Features:** CRUD

#### Kelas

**Path:** `/admin/classrooms`

**Features:** CRUD

#### Mata Pelajaran

**Path:** `/admin/subjects`

**Features:** CRUD

---

### MENU : PENGGUNA

**Parent Menu:** Pengguna

#### Guru

**Path:** `/admin/teachers`

**Features:** CRUD, Import, Export

#### Siswa

**Path:** `/admin/students`

**Features:** CRUD, Import, Export

#### User Accounts

**Path:** `/admin/users`

**Features:** Reset Password, Assign Role

---

### MENU : PEMBELAJARAN

**Parent Menu:** Pembelajaran

#### Course

**Path:** `/admin/courses`

**Features:** CRUD

#### Materi

**Path:** `/admin/materials`

**Features:** View All Materials

#### Tugas

**Path:** `/admin/assignments`

**Features:** Monitoring

#### Quiz

**Path:** `/admin/quizzes`

**Features:** Monitoring

---

### MENU : KEHADIRAN

**Parent Menu:** Kehadiran

#### Attendance

**Path:** `/admin/attendances`

**Features:** View Reports

---

### MENU : NILAI

**Parent Menu:** Nilai

#### Grades

**Path:** `/admin/grades`

**Features:** View Reports

---

### MENU : LAPORAN

**Parent Menu:** Laporan

| Submenu              | Path                        |
|----------------------|-----------------------------|
| Laporan Siswa        | `/admin/reports/students`   |
| Laporan Nilai        | `/admin/reports/grades`     |
| Laporan Kehadiran    | `/admin/reports/attendance` |

---

### MENU : PENGATURAN

**Parent Menu:** Pengaturan

| Submenu              | Path                         |
|----------------------|------------------------------|
| Profil Sekolah       | `/admin/settings/school`     |
| Pengaturan Akademik  | `/admin/settings/academic`   |
| Role & Permission    | `/admin/settings/roles`      |
| Activity Logs        | `/admin/activity-logs`       |

---

## TEACHER PORTAL

**Path:** `/teacher`

**Purpose:** Mengelola kegiatan belajar mengajar.

### TEACHER DASHBOARD

**Widgets:** Kelas Aktif, Tugas Aktif, Quiz Aktif, Submission Pending, Statistik Kehadiran

---

### MENU : KELAS SAYA

**Parent Menu:** Kelas Saya

**Path:** `/teacher/classes`

**Features:** View Students, View Schedule

---

### MENU : MATA PELAJARAN

**Parent Menu:** Mata Pelajaran

**Path:** `/teacher/courses`

**Features:** View Course

---

### MENU : MATERI

**Parent Menu:** Materi

**Path:** `/teacher/materials`

**Features:** Create, Edit, Delete, Publish

---

### MENU : TUGAS

**Parent Menu:** Tugas

#### Assignment Management

**Path:** `/teacher/assignments`

**Features:** Create Assignment, Review Submission, Grading

#### Submission Review

**Path:** `/teacher/submissions`

**Features:** Review, Grade

---

### MENU : QUIZ

**Parent Menu:** Quiz

#### Quiz Management

**Path:** `/teacher/quizzes`

**Features:** Create Quiz, Edit Quiz, Publish Quiz

#### Quiz Results

**Path:** `/teacher/quiz-results`

**Features:** View Scores, Manual Grading

---

### MENU : KEHADIRAN

**Parent Menu:** Kehadiran

**Path:** `/teacher/attendances`

**Features:** Input Attendance, Update Attendance

---

### MENU : NILAI

**Parent Menu:** Nilai

**Path:** `/teacher/grades`

**Features:** Input Grade, View Grade

---

### MENU : LAPORAN

**Parent Menu:** Laporan

| Submenu              | Path                            |
|----------------------|---------------------------------|
| Student Progress     | `/teacher/reports/students`     |
| Attendance Report    | `/teacher/reports/attendance`   |
| Grade Report         | `/teacher/reports/grades`       |

---

## STUDENT PORTAL

**Path:** `/student`

**Purpose:** Mengakses seluruh kegiatan pembelajaran.

### STUDENT DASHBOARD

**Widgets:** Jadwal Hari Ini, Tugas Mendatang, Quiz Aktif, Nilai Terbaru, Kehadiran

---

### MENU : PEMBELAJARAN

**Parent Menu:** Pembelajaran

#### Mata Pelajaran

**Path:** `/student/courses`

**Features:** View Courses

#### Materi

**Path:** `/student/materials`

**Features:** Read, Download

---

### MENU : TUGAS

**Parent Menu:** Tugas

#### Assignment List

**Path:** `/student/assignments`

**Features:** View Assignment, Submit Assignment

#### Riwayat Tugas

**Path:** `/student/submissions`

**Features:** View Submission Status

---

### MENU : QUIZ

**Parent Menu:** Quiz

#### Active Quiz

**Path:** `/student/quizzes`

**Features:** Start Quiz

#### Quiz History

**Path:** `/student/quiz-history`

**Features:** View Results

---

### MENU : NILAI

**Parent Menu:** Nilai

**Path:** `/student/grades`

**Features:** View Scores, View Final Grade

---

### MENU : KEHADIRAN

**Parent Menu:** Kehadiran

**Path:** `/student/attendances`

**Features:** View Attendance History

---

### MENU : PROFIL

**Parent Menu:** Profil

**Path:** `/student/profile`

**Features:** Update Profile, Change Password

---

## GLOBAL NAVIGATION

**Visible To All Roles**

### Notifications

**Path:** `/notifications`

**Features:** Read Notification, Mark as Read

### Profile Menu

**Features:** View Profile, Change Password, Logout

---

## BREADCRUMB STANDARD

**Example:**

```
Dashboard → Akademik → Kelas → Edit Kelas
```

---

## SEARCH STRATEGY

### Global Search

| Role    | Searchable Models                       |
|---------|-----------------------------------------|
| Admin   | Guru, Siswa, Kelas, Mata Pelajaran      |
| Teacher | Siswa, Tugas, Quiz                      |
| Student | Materi, Tugas, Quiz                     |

---

## QUICK ACTIONS

| Portal  | Actions                                    |
|---------|--------------------------------------------|
| Admin   | Tambah Guru, Tambah Siswa, Tambah Kelas    |
| Teacher | Buat Materi, Buat Tugas, Buat Quiz         |
| Student | Lihat Tugas, Mulai Quiz, Lihat Nilai       |

---

## FUTURE NAVIGATION

### Version 1.1

- Forum Diskusi
- Pengumuman

### Version 2.0

- Mobile Navigation
- Push Notification

### Version 3.0

- AI Assistant
- AI Tutor
