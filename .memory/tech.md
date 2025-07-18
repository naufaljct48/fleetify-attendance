# Fleetify Attendance - Technical Specifications

## Technology Stack
- **Backend**: Laravel 11
- **Frontend**: Blade + Livewire v3 + Alpine.js
- **Database**: MySQL
- **UI Framework**: Tabler (Bootstrap-based)
- **Icons**: Tabler Icons
- **Tables**: DataTables
- **Notifications**: SweetAlert2
- **HTTP Client**: Axios

## Development Environment
- **OS**: Windows
- **Server**: Laragon
- **Path**: d:\laragon\www\fleetify-attendance

## Existing Assets to Preserve
- Tabler UI styling dan theme
- Layout structure (app.blade.php, dashboard.blade.php)
- Authentication system
- DataTables integration
- SweetAlert2 setup
- Axios configuration dengan CSRF

## New Dependencies to Install
- Livewire v3: `composer require livewire/livewire`
- Alpine.js: sudah included via CDN di Tabler

## File Structure Changes
```
app/
├── Http/Controllers/
│   ├── EmployeeController.php
│   ├── DepartmentController.php
│   └── AttendanceController.php
├── Http/Livewire/
│   ├── EmployeeTable.php
│   ├── DepartmentTable.php
│   └── AttendanceLog.php
├── Models/
│   ├── Employee.php
│   ├── Department.php
│   ├── Attendance.php
│   └── AttendanceHistory.php
resources/views/
├── livewire/
├── employees/
├── departments/
└── attendance/
```

## API Endpoints
- GET /employees, POST /employees, PUT /employees/{id}, DELETE /employees/{id}
- GET /departments, POST /departments, PUT /departments/{id}, DELETE /departments/{id}  
- POST /attendance/checkin, PUT /attendance/checkout
- GET /attendance/logs?date=&department=
