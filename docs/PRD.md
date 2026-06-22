# PRODUCT REQUIREMENTS DOCUMENT (PRD)

## Project Name

EduSMA LMS

## Version

1.0

## Author

Akbar Sinyo

---

## Overview

EduSMA LMS adalah platform Learning Management System (LMS) berbasis web yang ditujukan untuk sekolah tingkat SMA. Sistem menyediakan dua portal utama:

1. Portal Guru
2. Portal Siswa

Sistem memungkinkan guru mengelola materi pembelajaran, tugas, kuis, nilai, dan absensi, sedangkan siswa dapat mengakses materi, mengerjakan tugas, mengikuti ujian online, dan melihat progres belajar.

Target utama adalah menyediakan platform pembelajaran digital yang modern, ringan, mobile-friendly, dan mudah digunakan oleh sekolah menengah atas.

---

## Objectives

### Business Objectives

- Digitalisasi proses pembelajaran SMA
- Mengurangi penggunaan kertas
- Sentralisasi data pembelajaran
- Monitoring perkembangan siswa secara real-time
- Menyediakan portal akademik yang dapat diakses kapan saja

### User Objectives

**Guru:** Mengunggah materi pelajaran, memberikan tugas dan kuis, melakukan penilaian, memantau aktivitas siswa

**Siswa:** Mengakses materi pelajaran, mengumpulkan tugas, mengikuti kuis dan ujian, melihat nilai dan progres belajar

---

## User Roles

### Administrator

**Hak Akses:** Kelola sekolah, kelola guru, kelola siswa, kelola kelas, kelola mata pelajaran, kelola tahun ajaran, kelola pengaturan sistem

### Guru

**Hak Akses:** Dashboard guru, kelola materi, kelola tugas, kelola kuis, kelola absensi, input nilai, melihat laporan kelas

### Siswa

**Hak Akses:** Dashboard siswa, akses materi, kirim tugas, ikut kuis, lihat nilai, lihat absensi, lihat progres belajar

---

## Technology Stack

| Komponen       | Teknologi                      |
|----------------|--------------------------------|
| Backend        | Laravel 13, PHP 8.4+, Filament v4 |
| Frontend       | Filament Panels, Livewire, AlpineJS, TailwindCSS |
| Database       | MySQL 8                        |
| Storage        | Local Storage, S3 Compatible   |
| Authentication | Laravel Sanctum, Filament Auth |
| Deployment     | Ubuntu Server, Nginx, PHP-FPM, MySQL |

---

## Core Modules

### Module 1 — Authentication

**Features:** Login, Logout, Forgot Password, Reset Password, Role Based Access Control

**User Stories:**
- Sebagai guru saya ingin login agar dapat mengelola kelas
- Sebagai siswa saya ingin login agar dapat mengakses materi dan tugas

### Module 2 — Academic Structure

**Features:** Tahun Ajaran, Semester, Kelas, Jurusan, Mata Pelajaran

**Data Fields — Academic Year:** id, name, start_date, end_date, is_active

**Data Fields — Class:** id, name, major, level

### Module 3 — Student Management

**Features:** CRUD siswa, Import Excel, Export Excel, Status aktif/nonaktif

**Data Fields:** NIS, NISN, Nama Lengkap, Email, Nomor HP, Alamat, Tanggal Lahir, Jenis Kelamin, Kelas

### Module 4 — Teacher Management

**Features:** CRUD Guru, Import Guru, Assign Mata Pelajaran

**Data Fields:** NIP, Nama, Email, Nomor HP, Mata Pelajaran

### Module 5 — Course Management

**Features:** Buat Mata Pelajaran, Atur Guru Pengajar, Atur Kelas

**Data Fields:** Nama Pelajaran, Deskripsi, Guru, Kelas, Semester

### Module 6 — Learning Materials

**Features:** Upload PDF, Upload PPT, Upload Video, Embed Youtube, Download Materi

**Status:** Draft, Published

**Data Fields:** Judul, Deskripsi, Lampiran, Tanggal Publish

### Module 7 — Assignments

**Features:** Buat Tugas, Deadline, Upload Jawaban, Penilaian

**Data Fields:** Judul, Deskripsi, Deadline, Nilai Maksimal

**Workflow:**
```
Guru Membuat Tugas → Siswa Mengumpulkan → Guru Menilai → Nilai Tersimpan
```

### Module 8 — Quiz System

**Features:** Multiple Choice, Essay, Auto Grading, Manual Grading

**Quiz Settings:** Durasi, Batas Percobaan, Random Soal, Random Jawaban

**Types:** Quiz Harian, UTS, UAS

### Module 9 — Attendance System

**Features:** Presensi Guru, Presensi Siswa, Rekap Kehadiran

**Status:** Hadir, Izin, Sakit, Alpha

### Module 10 — Grading System

**Features:** Input Nilai, Perhitungan Otomatis, Rekap Nilai

**Components:** Tugas, Kuis, UTS, UAS

**Formula:**
```
Final Score = (Tugas × 20%) + (Quiz × 20%) + (UTS × 30%) + (UAS × 30%)
```

### Module 11 — Student Dashboard

**Widgets:** Jadwal Hari Ini, Tugas Mendatang, Nilai Terbaru, Progress Belajar, Kehadiran

### Module 12 — Teacher Dashboard

**Widgets:** Jumlah Kelas, Jumlah Siswa, Tugas Aktif, Quiz Aktif, Statistik Kehadiran

### Module 13 — Reports

**Reports:** Nilai Siswa, Nilai Kelas, Kehadiran, Aktivitas Belajar

**Export:** PDF, Excel

### Module 14 — Notification Center

**Features:** Notifikasi Tugas, Notifikasi Quiz, Notifikasi Nilai, Pengumuman Sekolah

**Delivery:** In-App Notification, Email Notification

---

## Non Functional Requirements

### Performance

- Response < 2 detik
- Mendukung 1.000+ pengguna aktif

### Security

- CSRF Protection
- XSS Protection
- SQL Injection Protection
- Rate Limiting

### Backup

- Backup Database Harian
- Backup File Mingguan

### Logging

- Activity Log
- Error Log
- Login Log

---

## Database Entities

- users, roles, permissions
- students, teachers
- academic_years, semesters
- classes, subjects
- courses
- materials
- assignments, assignment_submissions
- quizzes, quiz_questions, quiz_answers, quiz_attempts
- attendances
- grades
- notifications
- activity_logs

---

## MVP Scope

- [x] Login
- [x] Dashboard
- [x] Manajemen Guru
- [x] Manajemen Siswa
- [x] Mata Pelajaran
- [x] Materi
- [x] Tugas
- [x] Kuis
- [x] Nilai
- [x] Absensi
- [x] Laporan

---

## Future Roadmap

### Phase 2

- Mobile App Android
- Mobile App iOS
- Video Conference
- Forum Diskusi
- Chat Guru dan Siswa

### Phase 3

- AI Learning Assistant
- AI Quiz Generator
- AI Essay Scoring
- AI Recommendation Learning

---

## Success Metrics

| Metric              | Target         |
|---------------------|----------------|
| Adoption            | 90% siswa aktif bulanan |
| Performance         | Uptime 99.9%   |
| Academic            | 100% tugas dikumpulkan melalui sistem |
| User Satisfaction   | Rating minimal 4.5/5 |
