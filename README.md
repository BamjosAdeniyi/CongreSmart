# CongreSmart - Church Membership Management System

[![Laravel](https://img.shields.io/badge/Laravel-12.x-red.svg)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.5-blue.svg)](https://php.net)
[![MySQL](https://img.shields.io/badge/MySQL-8.0-orange.svg)](https://mysql.com)

> A comprehensive church management system designed specifically for Seventh-day Adventist churches, enabling efficient management of members, attendance, finances, and disciplinary records.
 
---

## 📋 Table of Contents

- [Project Overview](#project-overview)
- [Academic Context](#academic-context)
- [Features](#features)
- [System Architecture](#system-architecture)
- [Technology Stack](#technology-stack)
- [Installation](#installation)
- [Database Schema](#database-schema)
- [User Roles & Permissions](#user-roles--permissions)
- [Usage Guide](#usage-guide)
- [Development Roadmap](#development-roadmap)
- [Testing](#testing)
- [Contributing](#contributing)
- [Team](#team)
- [License](#license)
- [Acknowledgments](#acknowledgments)

---

## 🎯 Project Overview

**CongreSmart** is a full-stack web application built to streamline church administration for Seventh-day Adventist congregations. The system addresses the challenges of manual record-keeping by providing a centralized, role-based platform for managing:

- **Member Information** - Comprehensive biodata, baptism records, and family tracking
- **Sabbath School Management** - Class organization, coordinator assignment, and member enrollment
- **Attendance Tracking** - Weekly Sabbath School attendance with automatic absence alerts
- **Financial Management** - Tithe, offerings, and contribution tracking with detailed reporting
- **Disciplinary Records** - Confidential tracking of church discipline processes
- **Transfer Management** - Seamless tracking of members transferring between churches
- **Reporting & Analytics** - Data-driven insights for church leadership

### Problem Statement

Many churches still rely on paper-based or spreadsheet systems for member management, leading to:
- ❌ Data inconsistency and loss
- ❌ Inefficient information retrieval
- ❌ Lack of role-based access control
- ❌ Difficulty generating reports
- ❌ No audit trail for sensitive operations

### Solution

CongreSmart provides a modern, secure, and user-friendly solution with:
- ✅ Centralized database with relational integrity
- ✅ Role-based access control (7 distinct user roles)
- ✅ Automated notifications and alerts
- ✅ Comprehensive reporting with PDF/Excel export
- ✅ Complete audit logging
- ✅ Mobile-responsive interface

---

## 🎓 Academic Context

### Course Information

- **Course Code**: SENG960
- **Course Title**: Software Development Studio
- **Institution**: Babcock University
- **Academic Year**: 2024/2025
- **Degree Program**: PhD in Computer Science (Software Engineering)

### Project Team

| Role | Name | Responsibilities |
|------|------|------------------|
| **Team Lead / Backend Developer** | Adeniyi Oluwabamise Joseph | System architecture, database design, backend development |
| **Frontend Developer / UI/UX** | Okorie Grace | User interface design, Blade templates, Tailwind styling, user experience |
| **Supervisor** | Professor Idowu Samuel | Project guidance, system architecture and design review, academic oversight |

### Learning Objectives

This project demonstrates proficiency in:

1. **Software Engineering Principles**
   - Requirements analysis and documentation
   - System design and architecture
   - Database modeling and normalization

2. **Full-Stack Development**
   - Backend development with Laravel 12
   - Frontend development with Blade & Tailwind CSS
   - Database management with MySQL 8
   - Authentication and authorization

3. **Project Management**
   - Agile development methodology
   - Version control with Git
   - Documentation best practices
   - Team collaboration

4. **Security & Best Practices**
   - Role-based access control (RBAC)
   - Data validation and sanitization
   - SQL injection prevention
   - Password hashing and secure authentication

---

## ✨ Features

### Core Modules (MVP)

#### 1. Member Management
- ✅ Complete member registration with biodata
- ✅ Family grouping and relationship tracking
- ✅ Baptism status and date tracking
- ✅ Membership status management (active/inactive/transferred/archived)
- ✅ Photo uploads
- ✅ Advanced search and filtering
- ✅ Member detail views with history

#### 2. Sabbath School Management
- ✅ Class creation and management
- ✅ Coordinator assignment
- ✅ Member-to-class assignment
- ✅ Age-range based class organization
- ✅ Class roster management

#### 3. Attendance Tracking
- ✅ Weekly Sabbath attendance recording (Saturdays only)
- ✅ Bulk attendance marking (Mark All Present/Absent)
- ✅ Individual attendance notes
- ✅ Attendance history per member
- ✅ Absence tracking and alerts
- ✅ Attendance reports by class and date range

#### 4. Financial Management
- ✅ Financial category management (Tithe, Offerings, Donations)
- ✅ Individual contribution recording
- ✅ Payment method tracking (Cash, Bank Transfer, Check, Mobile Money)
- ✅ Member contribution history
- ✅ Financial reports with date range filters
- ✅ Currency formatting (Nigerian Naira ₦)

#### 5. Reporting System
- ✅ Member directory reports
- ✅ Birthday reports
- ✅ Attendance summaries
- ✅ Financial reports (by category, member, date range)
- ✅ Export capabilities (PDF/Excel) - *Phase 2*

#### 6. User Management & Security
- ✅ Role-based authentication
- ✅ Seven distinct user roles with granular permissions
- ✅ User account management (ICT Admin only)
- ✅ Password reset functionality
- ✅ Session management
- ✅ Activity logging and audit trails

### Advanced Features (Phase 2)

- 🔄 Transfer Management (to/from other churches)
- 🔄 Disciplinary Records Management
- 🔄 Automated Notifications System
- 🔄 Dashboard Analytics with Charts
- 🔄 Bulk Contribution Entry (Grid View)
- 🔄 Email Notifications
- 🔄 Advanced Reporting with Data Visualization
- 🔄 Permission Configuration UI

---

## 🏗️ System Architecture

### High-Level Architecture

```
┌─────────────────────────────────────────────────────────────┐
│                     Presentation Layer                       │
│  ┌──────────────────────────────────────────────────────┐  │
│  │  Blade Templates + Tailwind CSS + Alpine.js/Livewire│  │
│  └──────────────────────────────────────────────────────┘  │
└─────────────────────────────────────────────────────────────┘
                              │
                              ▼
┌─────────────────────────────────────────────────────────────┐
│                     Application Layer                        │
│  ┌──────────────┬──────────────┬──────────────────────────┐│
│  │ Controllers  │ Middleware   │  Form Requests          ││
│  └──────────────┴──────────────┴──────────────────────────┘│
│  ┌──────────────┬──────────────┬──────────────────────────┐│
│  │ Services     │ Repositories │  Business Logic         ││
│  └──────────────┴──────────────┴──────────────────────────┘│
└─────────────────────────────────────────────────────────────┘
                              │
                              ▼
┌─────────────────────────────────────────────────────────────┐
│                        Data Layer                            │
│  ┌──────────────────────────────────────────────────────┐  │
│  │  Eloquent ORM + Models + Relationships               │  │
│  └──────────────────────────────────────────────────────┘  │
└─────────────────────────────────────────────────────────────┘
                              │
                              ▼
┌─────────────────────────────────────────────────────────────┐
│                     Database Layer                           │
│  ┌──────────────────────────────────────────────────────┐  │
│  │        MySQL 8 Database (Relational)                 │  │
│  └──────────────────────────────────────────────────────┘  │
└─────────────────────────────────────────────────────────────┘
```

### Design Patterns Used

- **MVC (Model-View-Controller)** - Core Laravel architecture
- **Repository Pattern** - Data access abstraction (planned for Phase 2)
- **Service Layer Pattern** - Business logic encapsulation
- **Observer Pattern** - Model events for audit logging
- **Factory Pattern** - Database seeding and testing
- **Middleware Pattern** - Authentication and authorization

### Database Design Principles

- **Normalization** - 3NF compliance for data integrity
- **UUID Primary Keys** - Distributed system ready
- **Soft Deletes** - Data preservation through status flags
- **Audit Trails** - Created/updated by tracking
- **Foreign Key Constraints** - Referential integrity
- **Proper Indexing** - Optimized query performance

---

## 🛠️ Technology Stack

### Backend

| Technology | Version | Purpose |
|------------|---------|---------|
| **PHP** | 8.5 | Server-side scripting |
| **Laravel** | 12.x | Backend framework |
| **Laravel Breeze** | Latest | Authentication scaffolding |
| **Eloquent ORM** | Built-in | Database abstraction |
| **Laravel Sanctum** | Latest | API authentication (future) |

### Frontend

| Technology | Version | Purpose |
|------------|---------|---------|
| **Blade** | Built-in | Templating engine |
| **Tailwind CSS** | 3.x | Utility-first CSS framework |
| **Alpine.js** | 3.x | Minimal JavaScript framework (optional) |
| **Livewire** | 3.x | Dynamic UI components (optional) |
| **Lucide Icons** | Latest | Icon library |

### Database

| Technology | Version | Purpose |
|------------|---------|---------|
| **MySQL** | 8.0+ | Primary database |
| **phpMyAdmin** | Latest | Database management (optional) |

### Development Tools

| Tool | Purpose |
|------|---------|
| **Composer** | PHP dependency management |
| **NPM/Yarn** | Frontend asset management |
| **Git** | Version control |
| **VS Code** | Code editor |
| **Laravel Tinker** | REPL for testing |
| **Laravel Debugbar** | Development debugging (optional) |

### Deployment (Future)

- **Server**: Apache/Nginx
- **SSL**: Let's Encrypt
- **Hosting**: Shared hosting, VPS, or cloud (AWS, DigitalOcean)

---

## 📦 Installation

### Prerequisites

Ensure you have the following installed:

- **PHP** >= 8.5
- **Composer** >= 2.0
- **Node.js** >= 18.x & NPM >= 9.x
- **MySQL** >= 8.0
- **Git**

### Step-by-Step Installation

#### 1. Clone the Repository

```bash
git clone https://github.com/yourusername/congresmart.git
cd congresmart
```

#### 2. Install PHP Dependencies

```bash
composer install
```

#### 3. Install Frontend Dependencies

```bash
npm install
```

#### 4. Environment Configuration

```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

#### 5. Configure Database

Edit `.env` file:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=congresmart
DB_USERNAME=root
DB_PASSWORD=your_password
```

Create the database:

```bash
mysql -u root -p -e "CREATE DATABASE congresmart CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
```

#### 6. Run Migrations

```bash
php artisan migrate
```

#### 7. Seed Database with Default Data

```bash
php artisan db:seed
```

This creates:
- Default ICT Administrator account
- Role permissions for all 7 roles
- Default financial categories
- Test users for each role (optional)
- Sample members, classes, and data (optional)

#### 8. Build Frontend Assets

```bash
npm run build
```

For development with hot reload:

```bash
npm run dev
```

#### 9. Start Development Server

```bash
php artisan serve
```

Visit: `http://localhost:8000`

#### 10. Login with Default Credentials

```
Email: ict@church.com
Password: password123
Role: ICT Administrator
```

⚠️ **IMPORTANT**: Change default passwords immediately after first login.

---

## 🗄️ Database Schema

### Entity Relationship Diagram

```
┌─────────────┐       ┌──────────────────┐       ┌─────────────────┐
│    Users    │──────▶│     Members      │──────▶│  Contributions  │
└─────────────┘       └──────────────────┘       └─────────────────┘
      │                       │                            │
      │                       │                            ▼
      │                       │                   ┌─────────────────┐
      │                       │                   │Financial Category│
      │                       │                   └─────────────────┘
      │                       │
      │                       ▼
      │               ┌──────────────────┐
      │               │Sabbath School    │
      └──────────────▶│    Classes       │
                      └──────────────────┘
                              │
                              ▼
                      ┌──────────────────┐
                      │Attendance Records│
                      └──────────────────┘
```

### Core Tables

#### `users` (System Users)
- **Primary Key**: `id` (UUID)
- **Key Fields**: name, email, role, password, active, last_login
- **Relationships**: 
  - Has one: coordinatedClass
  - Has many: createdMembers, recordedContributions, markedAttendance

#### `members` (Church Members)
- **Primary Key**: `id` (UUID)
- **Key Fields**: first_name, last_name, family_name, gender, phone, email, date_of_birth, membership_status, baptism_status
- **Relationships**:
  - Belongs to: sabbathSchoolClass, creator, updater
  - Has many: contributions, attendanceRecords

#### `sabbath_school_classes` (Sabbath School Classes)
- **Primary Key**: `id` (UUID)
- **Key Fields**: name, coordinator_id, age_range, active
- **Relationships**:
  - Belongs to: coordinator (User)
  - Has many: members, attendanceRecords

#### `attendance_records` (Attendance Tracking)
- **Primary Key**: `id` (UUID)
- **Key Fields**: member_id, class_id, date, present, notes
- **Unique Constraint**: (member_id, class_id, date)
- **Relationships**:
  - Belongs to: member, sabbathSchoolClass, marker (User)

#### `financial_categories` (Contribution Types)
- **Primary Key**: `id` (UUID)
- **Key Fields**: name, description, category_type, active
- **Relationships**:
  - Has many: contributions

#### `contributions` (Financial Records)
- **Primary Key**: `id` (UUID)
- **Key Fields**: member_id, category_id, amount, date, payment_method
- **Relationships**:
  - Belongs to: member, category, recorder (User)

#### `role_permissions` (Access Control)
- **Primary Key**: `id` (UUID)
- **Key Fields**: role (unique), members_view, members_add, finance_record, etc.
- **Purpose**: Defines granular permissions for each role

### Database Indexes

Optimized for common query patterns:

- `members`: (first_name, last_name), membership_status, family_name
- `attendance_records`: (class_id, date), member_id
- `contributions`: (date, category_id), member_id
- `users`: email, role

---

## 👥 User Roles & Permissions

CongreSmart implements a robust role-based access control (RBAC) system with 7 distinct roles:

### Role Matrix

| Role | Members | Sabbath School | Finance | Reports | Settings | Users |
|------|---------|----------------|---------|---------|----------|-------|
| **Pastor** | View | View | View + Reports | View + Export | View | View |
| **Church Clerk** | Full CRUD | - | - | View + Export | View | - |
| **Welfare Director** | View | View | - | View | - | - |
| **SS Superintendent** | View | Full Manage | - | View + Export | - | - |
| **Class Coordinator** | View | Own Class Only | - | View | - | - |
| **Financial Secretary** | View | - | Full Manage | View + Export | - | - |
| **ICT Administrator** | ALL | ALL | ALL | ALL | ALL | ALL |

### Role Descriptions

#### 1. Pastor
**Purpose**: Read-only oversight of all church operations

**Access**:
- ✅ View all member information
- ✅ View Sabbath School attendance
- ✅ View financial summaries
- ✅ Access all reports
- ✅ Export reports

**Cannot**:
- ❌ Add/Edit/Delete records
- ❌ Record contributions
- ❌ Manage users

#### 2. Church Clerk
**Purpose**: Primary member data management

**Access**:
- ✅ Full CRUD operations on members
- ✅ Manage membership transfers
- ✅ Track birthdays and absences
- ✅ Generate member reports
- ✅ Export member data

**Special Features**:
- Transfer Management Module (exclusive)
- Member biodata management

#### 3. Welfare Director
**Purpose**: Member care and outreach

**Access**:
- ✅ View member contact information
- ✅ View attendance records
- ✅ Access member directory
- ✅ Generate welfare reports

**Use Cases**:
- Follow up with absent members
- Birthday visits
- Member care coordination

#### 4. Sabbath School Superintendent
**Purpose**: Manage all Sabbath School operations

**Access**:
- ✅ Create and manage all SS classes
- ✅ Assign coordinators to classes
- ✅ Assign members to classes
- ✅ View all attendance records
- ✅ Generate attendance reports

**Responsibilities**:
- Class organization
- Coordinator oversight
- Attendance monitoring

#### 5. Class Coordinator
**Purpose**: Manage assigned Sabbath School class

**Access**:
- ✅ Mark attendance for assigned class only
- ✅ View own class roster
- ✅ Add attendance notes
- ✅ View class attendance reports

**Restrictions**:
- Can only access their assigned class
- Cannot manage other classes

#### 6. Financial Secretary
**Purpose**: Manage church finances

**Access**:
- ✅ Record individual contributions
- ✅ Manage financial categories
- ✅ View contribution history
- ✅ Generate financial reports
- ✅ Export financial data

**Responsibilities**:
- Weekly contribution recording
- Category management
- Financial reporting

#### 7. ICT Administrator
**Purpose**: System administration and user management

**Access**:
- ✅ **ALL PERMISSIONS** (unrestricted)
- ✅ Create/manage user accounts
- ✅ Configure role permissions
- ✅ View activity logs
- ✅ System settings

**Exclusive Features**:
- User Management Module
- Permissions Configuration
- Activity Log Access
- System Health Monitoring

---

## 📖 Usage Guide

### First-Time Setup

1. **Login as ICT Administrator**
   ```
   Email: ict@church.com
   Password: password123
   ```

2. **Change Default Password**
   - Navigate to Profile → Change Password

3. **Create User Accounts**
   - Go to Administration → Manage Users
   - Click "Add User"
   - Assign appropriate roles

4. **Set Up Sabbath School Classes**
   - Superintendent creates classes
   - Assigns coordinators to each class

5. **Add Members**
   - Clerk adds church members
   - Assigns members to SS classes

6. **Start Recording Data**
   - Coordinators mark weekly attendance
   - Financial Secretary records contributions

### Common Workflows

#### Add a New Member (Church Clerk)

1. Login as Church Clerk
2. Navigate to **Members** → **Add Member**
3. Fill in required information:
   - Personal details (name, DOB, contact)
   - Membership details (status, baptism)
   - Optional: Photo, SS class
4. Click **Save Member**
5. Member appears in member list

#### Mark Weekly Attendance (Coordinator)

1. Login as Class Coordinator
2. Navigate to **Sabbath School** → **Mark Attendance**
3. Select date (defaults to recent Saturday)
4. Mark members present/absent (checkboxes)
5. Add notes if needed
6. Click **Save Attendance**

#### Record Contributions (Financial Secretary)

1. Login as Financial Secretary
2. Navigate to **Finance** → **Record Contributions**
3. Option A: Individual Entry
   - Go to member detail page
   - Click "Add Contribution"
   - Fill form and save
4. Option B: Bulk Entry (Phase 2)
   - Use grid view for multiple members

#### Generate Reports

1. Navigate to **Reports**
2. Select report type:
   - Member Reports
   - Attendance Reports
   - Financial Reports
3. Configure filters (date range, category, etc.)
4. Click **Generate Report**
5. Review data
6. Click **Export** (PDF/Excel) if needed

---

## 🗺️ Development Roadmap

### Phase 0: Foundation ✅ (Complete)
- [x] Laravel 12 installation
- [x] Database schema design
- [x] Eloquent models with relationships
- [x] UUID primary keys implementation
- [x] Seeders for default data

### Phase 1: Authentication & Authorization ✅ (Complete)
- [x] Laravel Breeze setup
- [x] Role-based middleware
- [x] Permission gates
- [x] Basic dashboards for all roles

### Phase 2: Member Management ✅ (Complete)
- [x] Member list with search/filter
- [x] Member detail view
- [x] Add member form with validation
- [x] Edit member functionality
- [x] Archive member (soft delete)

### Phase 3: Sabbath School Management ✅ (Complete)
- [x] Class management (CRUD)
- [x] Assign members to classes
- [x] Attendance marking interface
- [x] Attendance reports

### Phase 4: Financial Management ✅ (Complete)
- [x] Financial categories management
- [x] Individual contribution entry
- [x] Contribution list and filtering
- [x] Financial reports

### Phase 5: Basic Reporting ✅ (Complete)
- [x] Member directory report
- [x] Birthday report
- [x] Attendance summary
- [x] Financial summary

### Phase 6: UI/UX Polish ✅ (Complete)
- [x] Dashboard enhancements with metrics
- [x] Responsive mobile design
- [x] Toast notifications
- [x] Loading states

### Phase 7: Testing & Deployment (In Progress)
- [x] Feature testing
- [x] Bug fixes
- [ ] User acceptance testing (UAT)
- [ ] Production deployment

### Phase 2 (Post-MVP) (In Progress)
- [x] Transfer management
- [x] Disciplinary records
- [x] Automated notifications
- [x] PDF/Excel export
- [x] Bulk contribution entry (grid)
- [x] Dashboard analytics with charts
- [x] Permission configuration UI
- [x] Activity logs interface
- [ ] Email notifications

---

## 🧪 Testing

### Running Tests

```bash
# Run all tests
php artisan test

# Run specific test suite
php artisan test --testsuite=Feature

# Run with coverage
php artisan test --coverage
```

### Test Structure

```
tests/
├── Feature/           # Feature tests
│   ├── Auth/
│   ├── Members/
│   ├── SabbathSchool/
│   └── Finance/
└── Unit/             # Unit tests
    ├── Models/
    └── Services/
```

### Testing Strategy

- **Unit Tests**: Model methods, business logic
- **Feature Tests**: HTTP requests, CRUD operations
- **Database Tests**: Migrations, seeders, relationships
- **Browser Tests**: User workflows (Dusk - future)

---

## 🤝 Contributing

### Development Workflow

1. **Fork the repository**
2. **Create a feature branch**
   ```bash
   git checkout -b feature/your-feature-name
   ```
3. **Make your changes**
4. **Follow coding standards**
   - PSR-12 for PHP
   - Laravel best practices
   - Meaningful commit messages
5. **Write tests for new features**
6. **Submit a pull request**

### Coding Standards

- **PHP**: PSR-12 compliance
- **Laravel**: Follow framework conventions
- **Database**: Use migrations, never modify database directly
- **Comments**: Document complex logic
- **Naming**: Descriptive variable/method names

### Branch Strategy

- `main` - Production-ready code
- `develop` - Integration branch
- `feature/*` - New features
- `bugfix/*` - Bug fixes
- `hotfix/*` - Urgent production fixes

---

## 👨‍💻 Team

### Project Contributors

#### Lead Developer & Backend Engineer
**[Your Full Name]**
- Email: your.email@university.edu
- GitHub: [@yourusername](https://github.com/yourusername)
- Role: System architecture, database design, backend development

**Responsibilities**:
- Requirements analysis and documentation
- Database schema design and implementation
- Laravel backend development
- API design and implementation
- Security and authentication

#### Frontend Developer & UI/UX Designer
**[Teammate Full Name]**
- Email: teammate.email@university.edu
- GitHub: [@teammateusername](https://github.com/teammateusername)
- Role: User interface design, frontend development

**Responsibilities**:
- User experience design
- Blade template development
- Tailwind CSS styling
- Responsive design implementation
- User flow optimization

### Academic Supervision

#### Course Supervisor
**[Professor Full Name], PhD**
- Title: Professor of Software Engineering
- Department: Computer Science
- Email: professor.email@university.edu

**Guidance Provided**:
- Project concept approval
- Technical architecture review
- Code quality assessment
- Academic milestone evaluation

---

## 📄 License

This project is developed as part of academic coursework for SENG960: Software Development Studio.

### Academic Use License

Copyright (c) 2024 [Your Name] & [Teammate Name]

**Terms**:
- ✅ Free to view and reference for educational purposes
- ✅ May be used as a portfolio project
- ⚠️ Commercial use requires permission
- ⚠️ Attribution required for academic citations

**Citation Format**:
```
[Your Name] & [Teammate Name]. (2024). CongreSmart: Church Membership Management System. 
SENG960 Software Development Studio, [University Name].
```

For commercial licensing inquiries, contact: [your.email@university.edu]

---

## 🙏 Acknowledgments

### Academic Acknowledgments

- **[Professor Name]** - Course supervision and technical guidance
- **[University Name]** - Academic resources and infrastructure
- **SENG960 Cohort** - Peer feedback and collaboration

### Technical Acknowledgments

- **Laravel Community** - Framework and documentation
- **Seventh-day Adventist Church** - Domain requirements and use case
- **Pioneer SDA Church** - Beta testing and user feedback

### Open Source Libraries

This project builds upon excellent open-source software:

- [Laravel Framework](https://laravel.com) - PHP web application framework
- [Tailwind CSS](https://tailwindcss.com) - Utility-first CSS framework
- [Alpine.js](https://alpinejs.dev) - Lightweight JavaScript framework
- [Lucide Icons](https://lucide.dev) - Beautiful icon library
- [MySQL](https://mysql.com) - Open-source database

---

## 📞 Support & Contact

### For Academic Inquiries

**Course-Related Questions**:
- Contact: [Professor Email]
- Office Hours: [Days/Times]

### For Technical Issues

**Bug Reports & Feature Requests**:
- GitHub Issues: [Repository URL]/issues
- Email: your.email@university.edu

### For Collaboration

**Interested in Contributing?**:
- Read [CONTRIBUTING.md](CONTRIBUTING.md)
- Join discussions in GitHub Discussions
- Fork the repo and submit PRs

---

## 📚 Documentation

### Additional Documentation

- [API Documentation](docs/API.md) - API endpoints and usage
- [Database Schema](docs/DATABASE.md) - Detailed schema documentation
- [User Manual](docs/USER_MANUAL.md) - End-user guide
- [Deployment Guide](docs/DEPLOYMENT.md) - Production deployment
- [Testing Guide](docs/TESTING.md) - Testing strategies

### Design Documents

- [System Architecture](docs/ARCHITECTURE.md)
- [User Flows](docs/USER_FLOWS.md)
- [UI/UX Design](docs/DESIGN.md)
- [Security Model](docs/SECURITY.md)

---

## 🎯 Project Status

### Current Phase
**Phase 2: Member Management** (Week 2 of 7)

### Progress Tracker

| Module | Status         | Completion |
|--------|----------------|------------|
| Foundation | ✅ Complete     | 100%       |
| Authentication | ✅ Complete     | 100%       |
| Member Management | ✅ Complete     | 100%       |
| Sabbath School | ✅ Complete     | 100%       |
| Financial Management | ✅ Complete     | 100%       |
| Reporting | ✅ Complete     | 100%       |
| UI/UX Polish | ✅ Complete     | 100%       |
| Testing | 🔄 In Progress | 75%        |

**Legend**: ✅ Complete | 🔄 In Progress | ⏳ Pending | ❌ Blocked

### Upcoming Milestones

- **Week 3**: Complete Sabbath School Management
- **Week 4**: Complete Financial Management
- **Week 5**: Complete Reporting & UI Polish
- **Week 6**: Testing & Bug Fixes
- **Week 7**: MVP Deployment

---

## 🔐 Security

### Security Measures Implemented

- ✅ Password hashing (bcrypt)
- ✅ CSRF protection (Laravel built-in)
- ✅ SQL injection prevention (Eloquent ORM)
- ✅ XSS protection (Blade escaping)
- ✅ Role-based access control (RBAC)
- ✅ Session management
- ✅ Input validation (Form Requests)

### Security Best Practices

- Change default passwords immediately
- Use strong passwords (min 8 characters)
- Enable HTTPS in production
- Regular database backups
- Keep Laravel and dependencies updated
- Review activity logs regularly

### Reporting Security Issues

If you discover a security vulnerability:
1. **DO NOT** open a public issue
2. Email: security@congresmart.com (or your.email@university.edu)
3. Provide detailed description
4. Allow 48 hours for response

---

## 📊 System Requirements

### Minimum Requirements

- **PHP**: 8.5+
- **MySQL**: 8.0+
- **RAM**: 2GB
- **Storage**: 10GB
- **Browser**: Modern browser (Chrome 90+, Firefox 88+, Safari 14+)

### Recommended Requirements

- **PHP**: 8.5+
- **MySQL**: 8.0+
- **RAM**: 4GB
- **
