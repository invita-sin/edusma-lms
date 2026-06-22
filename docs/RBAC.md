# RBAC MATRIX

## EduSMA LMS

**Version:** 1.0

### Purpose

Dokumen ini mendefinisikan hak akses setiap role pada seluruh modul sistem.

---

## ROLES

| Role        | Keterangan                               |
|-------------|------------------------------------------|
| Super Admin | Hak akses penuh terhadap seluruh sistem  |
| Admin       | Mengelola operasional sekolah            |
| Guru        | Mengelola proses pembelajaran            |
| Siswa       | Mengakses proses pembelajaran            |

---

## PERMISSION LEGEND

| Kode | Keterangan     |
|------|----------------|
| C    | Create         |
| R    | Read           |
| U    | Update         |
| D    | Delete         |
| E    | Export         |
| A    | Approve        |
| S    | Self Only      |

---

## DASHBOARD

| Modul     | Super Admin | Admin | Guru | Siswa |
|-----------|-------------|-------|------|-------|
| Dashboard | CRUD        | CRUD  | CRUD | CRUD  |

---

## USER MANAGEMENT

### Users

| Aksi   | Super Admin | Admin | Guru | Siswa |
|--------|-------------|-------|------|-------|
| Create | ✓           | ✓     | -    | -     |
| Read   | ✓           | ✓     | -    | -     |
| Update | ✓           | ✓     | -    | -     |
| Delete | ✓           | ✓     | -    | -     |
| Export | ✓           | ✓     | -    | -     |

### Roles

| Aksi | Super Admin | Admin | Guru | Siswa |
|------|-------------|-------|------|-------|
| CRUD | ✓           | R     | -    | -     |

### Permissions

| Aksi | Super Admin | Admin | Guru | Siswa |
|------|-------------|-------|------|-------|
| CRUD | ✓           | R     | -    | -     |

---

## ACADEMIC MODULE

### Academic Years

| Aksi   | Super Admin | Admin | Guru | Siswa |
|--------|-------------|-------|------|-------|
| Create | ✓           | ✓     | -    | -     |
| Read   | ✓           | ✓     | R    | R     |
| Update | ✓           | ✓     | -    | -     |
| Delete | ✓           | ✓     | -    | -     |

### Semesters

| Aksi | Super Admin | Admin | Guru | Siswa |
|------|-------------|-------|------|-------|
| CRUD | ✓           | ✓     | R    | R     |

### Majors

| Aksi | Super Admin | Admin | Guru | Siswa |
|------|-------------|-------|------|-------|
| CRUD | ✓           | ✓     | R    | R     |

### Classrooms

| Aksi   | Super Admin | Admin | Guru | Siswa |
|--------|-------------|-------|------|-------|
| Create | ✓           | ✓     | -    | -     |
| Read   | ✓           | ✓     | R    | S     |
| Update | ✓           | ✓     | -    | -     |
| Delete | ✓           | ✓     | -    | -     |

### Subjects

| Aksi | Super Admin | Admin | Guru | Siswa |
|------|-------------|-------|------|-------|
| CRUD | ✓           | ✓     | R    | R     |

---

## TEACHER MANAGEMENT

### Teachers

| Aksi   | Super Admin | Admin | Guru | Siswa |
|--------|-------------|-------|------|-------|
| Create | ✓           | ✓     | -    | -     |
| Read   | ✓           | ✓     | S    | -     |
| Update | ✓           | ✓     | S    | -     |
| Delete | ✓           | ✓     | -    | -     |
| Export | ✓           | ✓     | -    | -     |

---

## STUDENT MANAGEMENT

### Students

| Aksi   | Super Admin | Admin | Guru | Siswa |
|--------|-------------|-------|------|-------|
| Create | ✓           | ✓     | -    | -     |
| Read   | ✓           | ✓     | R    | S     |
| Update | ✓           | ✓     | -    | S     |
| Delete | ✓           | ✓     | -    | -     |
| Export | ✓           | ✓     | -    | -     |

---

## COURSE MANAGEMENT

### Courses

| Aksi   | Super Admin | Admin | Guru | Siswa |
|--------|-------------|-------|------|-------|
| Create | ✓           | ✓     | ✓    | -     |
| Read   | ✓           | ✓     | ✓    | S     |
| Update | ✓           | ✓     | S    | -     |
| Delete | ✓           | ✓     | S    | -     |

---

## MATERIAL MANAGEMENT

### Materials

| Aksi     | Super Admin | Admin | Guru | Siswa |
|----------|-------------|-------|------|-------|
| Create   | ✓           | ✓     | ✓    | -     |
| Read     | ✓           | ✓     | ✓    | S     |
| Update   | ✓           | ✓     | S    | -     |
| Delete   | ✓           | ✓     | S    | -     |
| Download | ✓           | ✓     | ✓    | ✓     |

---

## ASSIGNMENT MODULE

### Assignments

| Aksi   | Super Admin | Admin | Guru | Siswa |
|--------|-------------|-------|------|-------|
| Create | ✓           | ✓     | ✓    | -     |
| Read   | ✓           | ✓     | ✓    | S     |
| Update | ✓           | ✓     | S    | -     |
| Delete | ✓           | ✓     | S    | -     |

### Assignment Submission

| Aksi          | Super Admin | Admin | Guru | Siswa |
|---------------|-------------|-------|------|-------|
| Submit        | -           | -     | -    | ✓     |
| Read          | ✓           | ✓     | ✓    | S     |
| Grade         | ✓           | ✓     | ✓    | -     |
| Update Grade  | ✓           | ✓     | ✓    | -     |

---

## QUIZ MODULE

### Quiz

| Aksi   | Super Admin | Admin | Guru | Siswa |
|--------|-------------|-------|------|-------|
| Create | ✓           | ✓     | ✓    | -     |
| Read   | ✓           | ✓     | ✓    | S     |
| Update | ✓           | ✓     | S    | -     |
| Delete | ✓           | ✓     | S    | -     |
| Publish| ✓           | ✓     | ✓    | -     |

### Quiz Attempt

| Aksi   | Super Admin | Admin | Guru | Siswa |
|--------|-------------|-------|------|-------|
| Start  | -           | -     | -    | ✓     |
| Submit | -           | -     | -    | ✓     |
| Read   | ✓           | ✓     | ✓    | S     |

---

## ATTENDANCE MODULE

### Attendance

| Aksi   | Super Admin | Admin | Guru | Siswa |
|--------|-------------|-------|------|-------|
| Create | ✓           | ✓     | ✓    | -     |
| Read   | ✓           | ✓     | ✓    | S     |
| Update | ✓           | ✓     | ✓    | -     |
| Delete | ✓           | ✓     | -    | -     |
| Export | ✓           | ✓     | ✓    | -     |

---

## GRADE MODULE

### Grades

| Aksi   | Super Admin | Admin | Guru | Siswa |
|--------|-------------|-------|------|-------|
| Create | ✓           | ✓     | ✓    | -     |
| Read   | ✓           | ✓     | ✓    | S     |
| Update | ✓           | ✓     | ✓    | -     |
| Delete | ✓           | ✓     | -    | -     |
| Export | ✓           | ✓     | ✓    | -     |

---

## REPORTING

### Reports

| Aksi         | Super Admin | Admin | Guru | Siswa |
|--------------|-------------|-------|------|-------|
| View         | ✓           | ✓     | ✓    | S     |
| Export PDF   | ✓           | ✓     | ✓    | -     |
| Export Excel | ✓           | ✓     | ✓    | -     |

---

## NOTIFICATIONS

### Notifications

| Aksi      | Super Admin | Admin | Guru | Siswa |
|-----------|-------------|-------|------|-------|
| View      | ✓           | ✓     | ✓    | ✓     |
| Mark Read | ✓           | ✓     | ✓    | ✓     |

---

## SETTINGS

### School Settings

| Aksi | Super Admin | Admin | Guru | Siswa |
|------|-------------|-------|------|-------|
| CRUD | ✓           | ✓     | -    | -     |

### Academic Settings

| Aksi | Super Admin | Admin | Guru | Siswa |
|------|-------------|-------|------|-------|
| CRUD | ✓           | ✓     | -    | -     |

---

## ACTIVITY LOGS

### Logs

| Aksi   | Super Admin | Admin | Guru | Siswa |
|--------|-------------|-------|------|-------|
| View   | ✓           | ✓     | -    | -     |
| Export | ✓           | ✓     | -    | -     |

---

## POLICY RULES

### Ownership Rule

Guru hanya dapat:

- Mengubah course miliknya
- Mengubah materi miliknya
- Mengubah tugas miliknya
- Mengubah quiz miliknya

### Student Rule

Siswa hanya dapat:

- Melihat data milik sendiri
- Mengubah profil sendiri
- Mengumpulkan tugas sendiri
- Mengikuti quiz sendiri
- Melihat nilai sendiri

### Admin Rule

Admin tidak dapat:

- Mengubah Super Admin
- Menghapus Super Admin

---

## RECOMMENDED SPATIE STRUCTURE

### Roles

- `super-admin`
- `admin`
- `teacher`
- `student`

### Permission Naming

```
view-academic-year
create-academic-year
update-academic-year
delete-academic-year

view-student
create-student
update-student
delete-student

view-course
create-course
update-course
delete-course
```

dan seterusnya untuk seluruh resource.

---

## SECURITY CHECKLIST

Policy wajib untuk:

- [x] Course
- [x] Material
- [x] Assignment
- [x] Assignment Submission
- [x] Quiz
- [x] Quiz Attempt
- [x] Attendance
- [x] Grade

**Tidak boleh mengandalkan middleware role saja.**
Semua akses data harus melalui **Policy**.
