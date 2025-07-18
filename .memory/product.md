# Fleetify Attendance - Product Requirements

## Problem Statement
Perusahaan membutuhkan sistem absensi digital untuk mengelola kehadiran karyawan dengan aturan jam kerja per departemen.

## Solution
Sistem absensi berbasis web dengan fitur:

### Core Features
1. **Employee Management**
   - CRUD karyawan dengan departemen
   - Relasi employee -> department

2. **Department Management** 
   - CRUD departemen
   - Setting max_clock_in_time dan max_clock_out_time per departemen

3. **Attendance System**
   - Check-in/Check-out dengan timestamp
   - Auto-generate attendance_id unik
   - Validasi berdasarkan aturan departemen

4. **Attendance Logs**
   - History absensi dengan status otomatis
   - Filter by date dan department
   - Status: On Time / Late / Early Leave

## UX Goals
- Interface yang intuitif dan responsive
- Real-time feedback untuk status absensi
- Dashboard informatif dengan statistik
- Modal forms untuk CRUD operations
- Filter dan search yang mudah digunakan

## Technical Stack
- Laravel 11 + Livewire v3
- MySQL dengan ERD yang sudah ditentukan
- Tabler UI framework
- Alpine.js untuk interaktivity
