# Fleetify Attendance - System Architecture

## Database Schema (ERD)

### Tables Structure

#### 1. departments
- id (PK)
- department_name (varchar, 255)
- max_clock_in_time (time)
- max_clock_out_time (time)
- created_at, updated_at

#### 2. employee  
- id (PK)
- employee_id (unique, varchar, 50)
- department_id (FK to departments.id)
- name (varchar, 255)
- address (text)
- created_at, updated_at

#### 3. attendance
- id (PK) 
- employee_id (varchar, 50) - FK to employee.employee_id
- attendance_id (varchar, 100) - unique identifier
- clock_in (timestamp)
- clock_out (timestamp, nullable)
- created_at, updated_at

#### 4. attendance_history
- id (PK)
- employee_id (varchar, 50) - FK to employee.employee_id  
- attendance_id (varchar, 100) - FK to attendance.attendance_id
- date_attendance (timestamp)
- attendance_type (tinyint, 1) - 1=In, 2=Out
- description (text)
- created_at, updated_at

## Application Architecture

### Controllers
- EmployeeController (CRUD employees)
- DepartmentController (CRUD departments)
- AttendanceController (check-in/out, logs)
- DashboardController (statistics, overview)

### Livewire Components
- EmployeeTable (with modals)
- DepartmentTable (with modals) 
- AttendanceLog (with filters)
- AttendanceForm (check-in/out)

### Models & Relationships
- Employee belongsTo Department
- Department hasMany Employee
- Employee hasMany Attendance
- Attendance hasMany AttendanceHistory
