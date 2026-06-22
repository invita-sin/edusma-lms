# DEVOPS & DEPLOYMENT SPECIFICATION

## EduSMA LMS

**Version:** 1.0

### Environment

- Development
- Staging
- Production

### Infrastructure Type

Cloud VPS

### Deployment Strategy

CI/CD Automated Deployment

---

## INFRASTRUCTURE OVERVIEW

```
Internet
    ↓
Cloudflare
    ↓
Nginx
    ↓
Laravel Application
    ↓
Redis
    ↓
MySQL
    ↓
Storage
```

---

## SERVER SPECIFICATION

### Development

| Komponen | Spesifikasi |
|----------|-------------|
| CPU      | 2 Core      |
| RAM      | 4 GB        |
| Storage  | 50 GB SSD   |

### Staging

| Komponen | Spesifikasi |
|----------|-------------|
| CPU      | 2 Core      |
| RAM      | 4 GB        |
| Storage  | 50 GB SSD   |

### Production

#### Small School

| Komponen | Spesifikasi |
|----------|-------------|
| CPU      | 4 Core      |
| RAM      | 8 GB        |
| Storage  | 100 GB SSD  |

#### Medium School

| Komponen | Spesifikasi |
|----------|-------------|
| CPU      | 8 Core      |
| RAM      | 16 GB       |
| Storage  | 250 GB SSD  |

#### Large School

| Komponen | Spesifikasi |
|----------|-------------|
| CPU      | 16 Core     |
| RAM      | 32 GB       |
| Storage  | 500 GB SSD  |

---

## OPERATING SYSTEM

| Komponen   | Versi        |
|------------|--------------|
| Ubuntu Server | 24.04 LTS |

---

## APPLICATION STACK

| Komponen   | Versi          |
|------------|----------------|
| PHP        | 8.4            |
| Laravel    | 13             |
| Nginx      | Latest Stable  |
| MySQL      | 8              |
| Redis      | Latest Stable  |
| Supervisor | Latest Stable  |

---

## DOMAIN STRUCTURE

| Environment  | Domain                     |
|--------------|----------------------------|
| Production   | `lms.school.sch.id`        |
| Staging      | `staging.lms.school.sch.id` |
| Development  | `dev.lms.school.sch.id`    |

---

## SSL CONFIGURATION

| Komponen          | Detail                    |
|-------------------|---------------------------|
| Provider          | Let's Encrypt / Cloudflare SSL |
| Requirements      | Force HTTPS, HSTS Enabled, TLS 1.2+ |

---

## NGINX STRUCTURE

| Komponen          | Detail          |
|-------------------|-----------------|
| Public Directory  | `/public`       |
| PHP-FPM           | `php8.4-fpm`    |

### Security Headers

| Header                   | Value          |
|--------------------------|----------------|
| X-Frame-Options          | DENY           |
| X-Content-Type-Options   | nosniff        |
| Referrer-Policy          | strict-origin  |

---

## STORAGE ARCHITECTURE

| Type             | Path                  |
|------------------|-----------------------|
| Local Storage    | `storage/app`         |
| Public Storage   | `storage/app/public`  |

### Future Option — Object Storage

- AWS S3
- Cloudflare R2
- MinIO

### File Storage Rules

| Tipe        | Max Size   |
|-------------|------------|
| Materials   | 50 MB      |
| Assignments | 20 MB      |
| Images      | 5 MB       |

### Allowed Extensions

`PDF`, `DOCX`, `PPTX`, `PNG`, `JPG`, `JPEG`, `MP4`

---

## DATABASE CONFIGURATION

| Komponen   | Detail                |
|------------|-----------------------|
| Engine     | InnoDB                |
| Charset    | `utf8mb4`             |
| Collation  | `utf8mb4_unicode_ci`  |

### Database Indexing (Required)

- `students.student_number`
- `teachers.employee_number`
- `courses.teacher_id`
- `courses.classroom_id`
- `grades.student_id`
- `attendances.attendance_date`

### Database Backup

| Komponen      | Detail          |
|---------------|-----------------|
| Frequency     | Daily           |
| Retention     | 30 Days         |

**Backup Types:** Database, Files, Configuration

**Storage Targets:** Local, Remote Backup, Cloud Storage

---

## CACHE STRATEGY

| Komponen            | Provider |
|---------------------|----------|
| Application Cache   | Redis    |
| Session             | Redis    |
| Queue               | Redis    |

---

## QUEUE CONFIGURATION

| Komponen       | Detail     |
|----------------|------------|
| Driver         | Redis      |
| Workers (Prod) | 4          |
| Supervisor     | Yes        |

---

## SCHEDULED TASKS

- Notification Dispatch
- Expired Assignment Check
- Expired Quiz Check
- Attendance Reminder
- Database Cleanup
- Log Cleanup
- Backup Trigger

---

## LOGGING STRATEGY

| Komponen   | Detail     |
|------------|------------|
| Driver     | Daily      |
| Retention  | 30 Days    |

### Log Levels

Emergency, Alert, Critical, Error, Warning, Notice, Info, Debug

---

## MONITORING

### Application Monitoring

- Laravel Pulse
- Optional: Laravel Nightwatch

### Server Monitoring

CPU, RAM, Disk, Network

### Alerts

Email, Telegram, Discord

---

## SECURITY HARDENING

### Application Security

| Setting                     | Value       |
|-----------------------------|-------------|
| `APP_DEBUG`                 | `false`     |
| `APP_ENV`                   | `production`|
| `SESSION_SECURE_COOKIE`     | `true`      |
| `SANCTUM_STATEFUL_DOMAINS`  | Configured  |

### Server Security

| Komponen            | Detail                  |
|---------------------|-------------------------|
| Firewall            | UFW                     |
| Allowed Ports       | 22, 80, 443             |
| SSH                 | Key Authentication Only |
| Password Login      | Disabled                |

### Database Security

- Remote Access: Disabled
- Strong Passwords: Required
- Least Privilege User: Required

---

## CI/CD PIPELINE

```
GitHub
  ↓
Pull Request
  ↓
Code Review
  ↓
Automated Test
  ↓
Build
  ↓
Deploy Staging
  ↓
Manual Approval
  ↓
Deploy Production
```

### GitHub Actions

**Workflow:** `ci.yml`

**Steps:**

1. Install Dependencies
2. Run Pint
3. Run PHPStan
4. Run Pest
5. Generate Coverage
6. Build Assets
7. Deploy

---

## DEPLOYMENT STRATEGY

| Komponen     | Detail                   |
|--------------|--------------------------|
| Method       | Zero Downtime Deployment |
| Tools        | Deployer / Envoy         |

### Deployment Flow

1. Maintenance Off
2. Pull Latest Code
3. Install Dependencies
4. Build Assets
5. Run Migration
6. Restart Queue
7. Clear Cache
8. Health Check
9. Deployment Complete

---

## ROLLBACK STRATEGY

| Komponen          | Detail                |
|-------------------|-----------------------|
| Trigger           | Deployment Failure    |
| Rollback Steps    | Previous Release Restore, Database Rollback, Restart Services, Health Check |

---

## OBSERVABILITY

| Metric          | Target      |
|-----------------|-------------|
| Availability    | ≥ 99%       |
| API Response    | < 500ms     |
| Dashboard Load  | < 2 seconds |

---

## DISASTER RECOVERY

| Metric                    | Target   |
|---------------------------|----------|
| Recovery Point Objective  | 24 Hours |
| Recovery Time Objective   | 4 Hours  |
| Backup Validation         | Weekly   |

**Disaster Scenarios:** Server Failure, Database Corruption, Storage Failure, Deployment Failure

---

## MAINTENANCE PLAN

| Period      | Tasks                                                  |
|-------------|--------------------------------------------------------|
| Weekly      | Review Logs, Check Backups, Update Dependencies        |
| Monthly     | Security Audit, Performance Audit, Backup Recovery Test|
| Quarterly   | Infrastructure Review, Capacity Planning               |

---

## PRODUCTION CHECKLIST (Before Launch)

- [x] SSL Active
- [x] Backups Active
- [x] Monitoring Active
- [x] `APP_DEBUG` False
- [x] Queue Running
- [x] Scheduler Running
- [x] Security Headers Active
- [x] Firewall Active
- [x] Load Test Passed
- [x] UAT Approved
- [x] Documentation Complete

---

## SUCCESS CRITERIA

| Metric            | Target |
|-------------------|--------|
| Uptime            | ≥ 99%  |
| Backup Success    | 100%   |
| Failed Deployment | < 1%   |
| Critical Incident | 0      |
| Data Loss         | 0      |
