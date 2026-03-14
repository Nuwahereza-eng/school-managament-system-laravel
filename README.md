<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>


# School Management System (Laravel)

## 📋 Project Overview

School Management System is a comprehensive web application that manages students, teachers, classes, subjects, and more. The system provides full CRUD functionality with enhanced features including status tracking, search/filter capabilities, and detailed reporting through an interactive dashboard.

### Key Features:
- **Student Management**: Add, edit, delete, view students with status tracking (active, inactive, graduated, transferred, suspended)
- **Teacher Management**: Full teacher profiles with qualification, specialization, hire date, and status tracking
- **Classroom Management**: Manage classrooms with capacity tracking and status monitoring
- **Subject Management**: Assign subjects to classrooms and teachers with credit hours and semester tracking
- **Interactive Dashboard**: Real-time statistics, charts, and quick action buttons
- **Search & Filter**: Advanced search and filter functionality across all modules
- **Status Tracking**: Comprehensive status management for all entities

---

## 🚀 Test 2 Improvements (From Test 1 Feedback)

### 1. Enhanced Database Schema
**New Migration**: `2026_03_11_064534_add_status_fields_to_students_and_teachers.php`

| Entity | New Fields Added |
|--------|-----------------|
| Students | `status` (enum), `notes` (text) |
| Teachers | `status` (enum), `hire_date`, `qualification`, `specialization` |
| Classrooms | `capacity` (integer), `status` (enum) |
| Subjects | `credits` (integer), `status` (enum) |

### 2. Enhanced Entity Relationships
All models now have improved relationships with the database:

**Student Model**:
- `belongsTo` Classroom
- `hasManyThrough` Subjects (via Classroom)

**Teacher Model**:
- `hasMany` Subjects
- `belongsToMany` Classrooms (through subjects)

**Classroom Model**:
- `hasMany` Students
- `hasMany` Subjects
- `belongsToMany` Teachers (through subjects)

**Subject Model**:
- `belongsTo` Classroom
- `belongsTo` Teacher

### 3. Search and Filter Functionality
All modules now support:
- **Text Search**: Search by name, number, code, email, phone
- **Filter by Status**: Active, Inactive, and entity-specific statuses
- **Filter by Related Entity**: e.g., Students by Classroom, Subjects by Teacher
- **Sortable Columns**: Click column headers to sort ascending/descending

### 4. Improved UI/UX
- **Status Badges**: Color-coded status indicators throughout the application
- **Statistics Cards**: Quick overview of key metrics on the dashboard
- **Interactive Charts**: Visual representation of data distribution
- **Quick Action Buttons**: Fast access to common tasks
- **Detail Views**: Dedicated show pages for each entity
- **Responsive Tables**: Better mobile experience

### 5. Enhanced Data Validation
Form Request classes updated with:
- Custom validation messages in user-friendly language
- Phone number format validation (Uganda format: 07XXXXXXXX or 256XXXXXXXX)
- Name validation (letters, spaces, hyphens, apostrophes only)
- Conditional validation rules (e.g., photo required only on create)
- Proper attribute naming for error messages

### 6. Dashboard with Statistics
New `DashboardController` provides:
- Total counts for all entities
- Active entity counts
- Status distribution data for charts
- Students per classroom statistics
- Recent records quick view
- Gender distribution data

### 7. Code Quality Improvements
- **Named Routes**: All routes now have proper names for easier maintenance
- **Query Scopes**: Reusable query methods in models (e.g., `scopeActive`, `scopeSearch`)
- **Constants**: Status options defined as class constants
- **Accessor Methods**: `getFullNameAttribute()` for consistent name display
- **Error Handling**: Proper try-catch blocks with user-friendly error messages
- **Flash Messages**: Success/error notifications for all operations

---

## 📊 Database Structure

### Entity Relationship Diagram

```
┌──────────────┐     ┌──────────────┐     ┌──────────────┐
│   TEACHERS   │────<│   SUBJECTS   │>────│  CLASSROOMS  │
│              │     │              │     │              │
│ - id         │     │ - id         │     │ - id         │
│ - number     │     │ - code       │     │ - number     │
│ - name       │     │ - name       │     │ - name       │
│ - email      │     │ - semester   │     │ - capacity   │
│ - phone      │     │ - credits    │     │ - status     │
│ - gender     │     │ - status     │     └──────────────┘
│ - status     │     │ - teacher_id │            │
│ - hire_date  │     │ - class_id   │            │
│ - qual...    │     └──────────────┘            │
│ - special... │                                 │
│ - photo      │                                 ▼
└──────────────┘                         ┌──────────────┐
                                         │   STUDENTS   │
                                         │              │
                                         │ - id         │
                                         │ - number     │
                                         │ - f_name     │
                                         │ - l_name     │
                                         │ - gender     │
                                         │ - dob        │
                                         │ - class_id   │
                                         │ - status     │
                                         │ - notes      │
                                         └──────────────┘
```

---

## 🛠️ Technology Stack

| Component | Technology |
|-----------|------------|
| Backend | Laravel 9.x (PHP 8.x) |
| Database | MySQL 8.x |
| Frontend | Bootstrap 5, Themify Icons |
| Charts | Chart.js |
| IDE | PhpStorm / VS Code |

---

## 📥 Installation & Setup

### Prerequisites
- PHP 8.0 or higher
- Composer
- MySQL 8.0 or higher
- Node.js (optional, for frontend assets)

### Installation Steps

1. **Clone the repository**
   ```bash
   git clone https://github.com/Nuwahereza-eng/school-managament-system-laravel.git
   cd school-managament-system-laravel
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Environment Setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Configure Database**
   Edit `.env` file with your database credentials:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=school_management
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

5. **Run Migrations and Seeders**
   ```bash
   php artisan migrate:fresh --seed
   ```

6. **Start Development Server**
   ```bash
   php artisan serve
   ```

7. **Access the Application**
   Open `http://localhost:8000` in your browser

---

## 📱 System Modules

### 1. Authentication System
- Secure login with email/password validation
- Session management
- Protected routes with middleware

### 2. Dashboard
- Real-time statistics overview
- Interactive charts (Student Status, Teacher Status, Students per Classroom)
- Quick action buttons
- Recent records display

### 3. Student Management
- Full CRUD operations
- Status tracking (Active, Inactive, Graduated, Transferred, Suspended)
- Search by name, student number
- Filter by classroom, status, gender
- Sortable columns
- Detail view with enrolled subjects

### 4. Teacher Management
- Full CRUD operations
- Profile photo upload
- Status tracking (Active, Inactive, On Leave, Terminated)
- Professional details (qualification, specialization, hire date)
- Search by name, teacher number, email
- Filter by status, gender

### 5. Classroom Management
- Full CRUD operations
- Capacity tracking
- Status management
- View enrolled students and assigned subjects
- Search and filter capabilities

### 6. Subject Management
- Full CRUD operations
- Credit hours tracking
- Semester assignment
- Teacher and classroom assignment
- Status management

### 7. User Management
- Admin account management
- Role-based access (managers only)

---

## 📸 Screenshots

### Dashboard
*(Add updated dashboard screenshot here)*

### Student List with Search/Filter
*(Add student list screenshot here)*

### Student Detail View
*(Add student detail screenshot here)*

### Teacher Management
*(Add teacher management screenshot here)*

---

## 📝 Status Options

### Student Status
| Status | Description |
|--------|-------------|
| Active | Currently enrolled and attending |
| Inactive | Temporarily not attending |
| Graduated | Completed studies |
| Transferred | Moved to another school |
| Suspended | Disciplinary suspension |

### Teacher Status
| Status | Description |
|--------|-------------|
| Active | Currently employed and teaching |
| Inactive | Not currently teaching |
| On Leave | Temporary leave of absence |
| Terminated | Employment ended |

### Classroom/Subject Status
| Status | Description |
|--------|-------------|
| Active | Currently in use |
| Inactive | Not currently active |

---

## 🔧 API Endpoints

All routes are protected by authentication middleware.

| Method | Route | Controller@Method | Description |
|--------|-------|-------------------|-------------|
| GET | /dashboard | DashboardController@index | Dashboard view |
| GET | /students | StudentController@index | List students |
| POST | /students | StudentController@store | Create student |
| GET | /students/{id} | StudentController@show | View student |
| PUT | /students/{id} | StudentController@update | Update student |
| DELETE | /students/{id} | StudentController@destroy | Delete student |
| GET | /teachers | TeacherController@index | List teachers |
| POST | /teachers | TeacherController@store | Create teacher |
| GET | /teachers/{id} | TeacherController@show | View teacher |
| PUT | /teachers/{id} | TeacherController@update | Update teacher |
| DELETE | /teachers/{id} | TeacherController@destroy | Delete teacher |
| GET | /classrooms | ClassroomController@index | List classrooms |
| POST | /classrooms | ClassroomController@store | Create classroom |
| GET | /classrooms/{id} | ClassroomController@show | View classroom |
| PUT | /classrooms/{id} | ClassroomController@update | Update classroom |
| DELETE | /classrooms/{id} | ClassroomController@destroy | Delete classroom |
| GET | /subjects | SubjectController@index | List subjects |
| POST | /subjects | SubjectController@store | Create subject |
| GET | /subjects/{id} | SubjectController@show | View subject |
| PUT | /subjects/{id} | SubjectController@update | Update subject |
| DELETE | /subjects/{id} | SubjectController@destroy | Delete subject |

---

## 📁 Project Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── DashboardController.php    # NEW: Statistics dashboard
│   │   ├── StudentController.php      # ENHANCED: Search, filter, show
│   │   ├── TeacherController.php      # ENHANCED: Search, filter, show
│   │   ├── ClassroomController.php    # ENHANCED: Search, filter, show
│   │   └── SubjectController.php      # ENHANCED: Search, filter, show
│   └── Requests/
│       ├── StudentAddUpdateRequest.php # ENHANCED: Better validation
│       └── TeacherAddUpdateRequest.php # ENHANCED: Better validation
├── Models/
│   ├── Student.php    # ENHANCED: Scopes, accessors, constants
│   ├── Teacher.php    # ENHANCED: Scopes, accessors, constants
│   ├── Classroom.php  # ENHANCED: Relationships, scopes
│   └── Subject.php    # ENHANCED: Relationships, scopes
└── ...

database/
└── migrations/
    └── 2026_03_11_064534_add_status_fields_to_students_and_teachers.php # NEW

resources/views/
├── dashboard.blade.php       # ENHANCED: Statistics, charts
├── student/
│   ├── index.blade.php      # ENHANCED: Search, filter, badges
│   ├── view.blade.php       # ENHANCED: Status fields
│   └── show.blade.php       # NEW: Detail view
├── teacher/
│   ├── index.blade.php      # ENHANCED: Search, filter, badges
│   └── show.blade.php       # NEW: Detail view
└── ...
```

---

## ✅ Test 2 Checklist

- [x] **New Feature**: Dashboard with statistics and charts
- [x] **New Feature**: Search and filter functionality across all modules
- [x] **New Feature**: Status tracking for all entities
- [x] **New Feature**: Detail (show) views for students and teachers
- [x] **Code Improvement**: Named routes for maintainability
- [x] **Code Improvement**: Query scopes in models
- [x] **Code Improvement**: Enhanced validation with custom messages
- [x] **Code Improvement**: Better error handling
- [x] **UI Improvement**: Status badges with colors
- [x] **UI Improvement**: Quick action buttons
- [x] **UI Improvement**: Interactive charts
- [x] **UI Improvement**: Responsive design improvements
- [x] **Database Change**: New status fields
- [x] **Database Change**: New teacher professional fields
- [x] **Database Change**: Classroom capacity field
- [x] **Database Change**: Subject credits field
- [x] **Removed**: node_modules from submission package

---

## 📜 License

This project is licensed under the terms of the MIT license.

---

## 👤 Author

* Original repo by [Omar Kadish](https://github.com/OmarKadish)
* Enhanced by Peter for Test 2 submission

---

*Last Updated: March 2026*

