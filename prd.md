## 🧠 **Prompt Development Laravel Fullstack Developer Challenge Test (SSR Style + Livewire)**

### ⚙️ **Stack & Tools**

-   **Backend**: Laravel 11 (latest)
-   **Frontend**: Laravel Blade + [Livewire v3](https://livewire.laravel.com/) (SSR reactive)
-   **Database**: MySQL
-   **ORM**: Eloquent
-   **Auth**: Laravel Breeze (biar ringan & bisa Livewire ready langsung)
-   **Modal Library**: Livewire + [Alpine.js](https://alpinejs.dev/) (buat modal interaktif)

---

## ✅ Fitur & Endpoint

### 🔧 Karyawan (Employee)

-   `GET /employees` → List semua karyawan
-   `POST /employees` → Tambah karyawan
-   `PUT /employees/{id}` → Edit karyawan
-   `DELETE /employees/{id}` → Hapus karyawan

### 🔧 Departemen

-   `GET /departments`
-   `POST /departments`
-   `PUT /departments/{id}`
-   `DELETE /departments/{id}`

### 🕒 Absensi

-   `POST /attendance/checkin` → Input absen masuk
-   `PUT /attendance/checkout` → Update absen keluar
-   `GET /attendance/logs?date=&department=`
    → List log absensi + tampilkan status "Tepat Waktu / Terlambat / Pulang Cepat"

---

## 🧩 Livewire UX Flow (Frontend)

### 1. **Dashboard Log Absensi**

-   Tampilkan tabel log absensi karyawan
-   Filter by **Tanggal** & **Departemen**
-   Status (On Time / Late / Early Leave) ditampilkan otomatis berdasarkan aturan max_in dan max_out per departemen

### 2. **Detail Row Modal (Livewire + Alpine.js)**

-   Klik "Detail" ➝ tampilkan modal berisi:

    -   Nama, Departemen, Jam Masuk, Jam Keluar, Status Ketepatan
    -   Kalau bisa: tambahkan badge warna untuk status

### 3. **CRUD Forms**

-   Tambah/Edit Employee ➝ Modal dengan form Livewire
-   Tambah/Edit Departemen ➝ Sama

---

## 📄 Dokumentasi

Di repo lo, jangan lupa tambahkan:

-   `README.md` berisi:

    -   Setup Project
    -   Struktur DB (atau import dari file SQL)
    -   Petunjuk Testing
    -   Link Demo (jika deploy)

-   Tambahkan `.env.example`
-   Folder `docs/` buat naruh screenshot & ERD/Flowchart yang diadaptasi

---
