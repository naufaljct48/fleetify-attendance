# Fleetify Attendance

Fleetify Attendance adalah sistem absensi digital berbasis web yang dibangun menggunakan Laravel untuk mengelola kehadiran karyawan dengan aturan jam kerja per departemen.

## 🛠️ Teknologi yang Digunakan

-   **Laravel 11** (PHP Framework)
-   **MySQL** (Database)
-   **Tabler UI** (Frontend Styling)
-   **DataTables** (Frontend Styling)
-   **SweetAlert2** (Frontend Styling)
-   **Carbon** (Manipulasi Tanggal)
-   **Axios**

## 🚀 Instalasi

1. **Clone Repository**
    ```sh
    git clone https://github.com/naufaljct48/fleetify-attendance
    cd fleetify-attendance
    ```
2. **Install Dependencies**
    ```sh
    composer install
    npm install
    ```
3. **Konfigurasi Environment**

    ```sh
    cp .env.example .env
    php artisan key:generate
    ```

    Sesuaikan konfigurasi database di `.env`.

4. **Migrasi Database**

    ```sh
    php artisan migrate --seed
    ```

5. **Jalankan Server**
    ```sh
    php artisan serve
    ```
    Akses aplikasi di `http://127.0.0.1:8000`

## 🔑 Akun Default

**Admin User**

-   Email: `admin@fleetify.com`
-   Password: `password`

## 📌 Fitur Utama

-   🏠 **Autentikasi** (Login & Register)
-   👥 **Manajemen Karyawan** (Tambah, Edit, Hapus)
-   🏢 **Manajemen Departemen** (Tambah, Edit, Hapus dengan aturan jam kerja)
-   ⏰ **Sistem Absensi** (Check-in & Check-out)
-   📊 **Log Absensi** dengan status otomatis (On Time/Late/Early Leave)
-   🎯 **Dashboard** dengan statistik kehadiran
-   🔍 **Filter & Search** berdasarkan tanggal dan departemen
-   📱 **Responsive Design** dengan Tabler UI

## 📱 Responsive Design

-   **Mobile-first** approach dengan Tabler UI
-   **Dark/Light** theme support
-   **Touch-friendly** interface
-   **Progressive Web App** ready

## 📋 Database Schema

### Tables Structure

#### 1. departments

-   id (PK)
-   department_name (varchar, 255)
-   max_clock_in_time (time)
-   max_clock_out_time (time)
-   created_at, updated_at

#### 2. employee

-   id (PK)
-   employee_id (unique, varchar, 50)
-   department_id (FK to departments.id)
-   name (varchar, 255)
-   address (text)
-   created_at, updated_at

#### 3. attendance

-   id (PK)
-   employee_id (varchar, 50) - FK to employee.employee_id
-   attendance_id (varchar, 100) - unique identifier
-   clock_in (timestamp)
-   clock_out (timestamp, nullable)
-   created_at, updated_at

#### 4. attendance_history

-   id (PK)
-   employee_id (varchar, 50) - FK to employee.employee_id
-   attendance_id (varchar, 100) - FK to attendance.attendance_id
-   date_attendance (timestamp)
-   attendance_type (tinyint, 1) - 1=In, 2=Out
-   description (text)
-   created_at, updated_at

## 🎯 API Endpoints

### Employee Management

-   `GET /employees` → List semua karyawan
-   `POST /employees` → Tambah karyawan
-   `PUT /employees/{id}` → Edit karyawan
-   `DELETE /employees/{id}` → Hapus karyawan

### Department Management

-   `GET /departments` → List semua departemen
-   `POST /departments` → Tambah departemen
-   `PUT /departments/{id}` → Edit departemen
-   `DELETE /departments/{id}` → Hapus departemen

### Attendance System

-   `POST /attendance/checkin` → Input absen masuk
-   `PUT /attendance/checkout` → Update absen keluar
-   `GET /attendance/logs?date=&department=` → List log absensi dengan filter

### 📸 Screenshot a.k.a Showcase
**Login Page**
<img width="1873" height="949" alt="image" src="https://github.com/user-attachments/assets/a16053ee-c387-44dc-83fe-bd9ac530137b" />
**Dashboard**
<img width="1872" height="949" alt="image" src="https://github.com/user-attachments/assets/94cd85c7-7146-470b-b538-7a097a7c3d84" />
**Employees Page**
<img width="1871" height="949" alt="image" src="https://github.com/user-attachments/assets/07beb8f2-c58c-4eae-8d4d-fe3e9006389b" />
**Attendance Logs**
<img width="1869" height="947" alt="image" src="https://github.com/user-attachments/assets/44543a25-bf24-45d2-8258-f086d71dd050" />


## 🛠️ Troubleshooting

Jika terjadi error setelah migrasi, jalankan:

```sh
php artisan migrate:refresh --seed
php artisan cache:clear
php artisan config:clear
php artisan optimize:clear
composer dump-autoload
```

## 📜 Lisensi

Proyek ini dirilis di bawah lisensi MIT. Bebas digunakan dan dikembangkan! 🎉
