# Veritas CMS & Staff Portal

## Project Overview

**Veritas CMS** is a comprehensive content management and staff administration system built for Veritas University. It unifies academic management, staff operations, and website content management into a single, secure, and role-based portal.

Designed with a **unified dashboard approach**, it eliminates the need for separate administrative interfaces. Instead, the system dynamically adapts the user interface and available features based on the logged-in user's role (e.g., Super Admin, Editor, Management, Academic Staff).

---

## 📚 Table of Contents

- [Project Overview](#project-overview)
- [Key Features](#key-features)
- [Technical Architecture](#technical-architecture)
- [Prerequisites](#prerequisites)
- [Installation Guide](#installation-guide)
- [Configuration](#configuration)
- [Usage Guide](#usage-guide)
  - [Role-Based Access](#role-based-access)
  - [Content Management](#content-management)
- [Project Structure](#project-structure)
- [Contributing](#contributing)
- [License](#license)

---

## 🚀 Key Features

### 1. Unified Dashboard
- **Single Entry Point**: All staff members, administrators, and editors log in through the same Staff Portal.
- **Dynamic Widgets**: Dashboard widgets (Staff Stats, Page Stats, Student Counts, Academic Courses) appear conditionally based on permissions.
- **Responsive Layout**: Features a sticky sidebar and glassmorphism navbar for a modern, accessible user experience across devices.

### 2. Role-Based Access Control (RBAC)
- **Super Admin**: Full access to all modules (Academic, Staff, Students, CMS).
- **Editor**: Restricted access focused on Website Pages and Content Blocks.
- **Management**: Access to high-level reporting and oversight tools.
- **Academic Staff**: Access to course management, attendance, and personal profile.

### 3. Content Management System (CMS)
- **Page Management**: Create, edit, and delete website pages with SEO metadata support.
- **Content Blocks**: Modular content management (Hero sections, Text blocks, Features, CTAs) using JSON-based storage for flexibility.
- **Preview Capabilities**: View raw content structure directly from the admin interface.

### 4. Modern UI/UX
- **Bootstrap 5 Integration**: robust, responsive components for forms, tables, and cards.
- **Glassmorphism Header**: Stylish, semi-transparent sticky navbar.
- **Fixed Sidebar**: Independent scrolling for sidebar navigation to handle extensive menus.

---

## 🛠 Technical Architecture

### Backend
- **Framework**: Laravel 12.x
- **Language**: PHP 8.2+
- **Authentication**: Laravel Sanctum (Multi-guard support for Staff and Students)
- **Database**: MySQL

### Frontend
- **Templating**: Laravel Blade
- **Styling**: 
  - **Bootstrap 5** (Primary UI framework for Staff/CMS panels)
  - **TailwindCSS** (Configured for specific components/frontend views)
  - **FontAwesome** (Icons)
- **Build Tool**: Vite

### Key Libraries
- `laravel/framework`: Core application framework.
- `laravel/sanctum`: API token authentication.
- `bootstrap`: UI components.

---

## 📋 Prerequisites

Ensure your development environment meets the following requirements:

- **PHP**: >= 8.2
- **Composer**: Latest version
- **Node.js**: >= 18.x
- **MySQL**: >= 8.0 (or equivalent)
- **Web Server**: Apache/Nginx or Laravel Valet/Sail

---

## ⚙️ Installation Guide

1.  **Clone the Repository**
    ```bash
    git clone https://github.com/veritas-university/veritas-cms.git
    cd veritas-cms
    ```

2.  **Install PHP Dependencies**
    ```bash
    composer install
    ```

3.  **Install Node Dependencies**
    ```bash
    npm install
    ```

4.  **Environment Configuration**
    Copy the example environment file and configure your database credentials.
    ```bash
    cp .env.example .env
    ```
    Update `.env` with your DB details:
    ```ini
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=veritas_cms
    DB_USERNAME=root
    DB_PASSWORD=
    ```

5.  **Generate Application Key**
    ```bash
    php artisan key:generate
    ```

6.  **Run Migrations & Seeders**
    ```bash
    php artisan migrate --seed
    ```

7.  **Build Assets**
    ```bash
    npm run build
    ```

8.  **Start Local Server**
    ```bash
    php artisan serve
    ```

---

## 🔧 Configuration

### Middleware
The application uses custom middleware for role verification:
- `cms.auth`: Ensures the user is logged in as Staff and has appropriate permissions (Super Admin, Editor, or Management) to access CMS routes.

### Role Definitions
Roles are defined in the database and handled via the `Staff` model helper methods:
- `hasWebsiteRole('role-slug')`: Checks for specific website capabilities.
- `role` attribute: Legacy integer-based role check (e.g., `1` for Admin, `3` for Staff).

---

## 📖 Usage Guide

### Role-Based Access

| Role | Dashboard View | Permissions |
|------|---------------|-------------|
| **Super Admin** | Full Stats (Pages, Staff, Students), CMS Tools | Manage Pages, Blocks, Staff, Settings |
| **Editor** | Page Stats, CMS Tools | Manage Pages, Content Blocks |
| **Staff** | Academic Widgets (Courses, Attendance) | View Courses, Mark Attendance, Profile |
| **Management** | Overview Stats | View Reports, Staff Oversight |

### Content Management

1.  **Navigate to Pages**:
    - Log in as an Admin or Editor.
    - Click **Pages** in the "CMS Management" sidebar section.
2.  **Manage Pages**:
    - Click **Create New Page** to add a new route/page.
    - Use **Edit** to modify title, slug, or SEO meta tags.
3.  **Manage Content Blocks**:
    - Select a Page.
    - Click **Manage Blocks** (or the blocks icon).
    - Add modular blocks like *Hero*, *Text*, or *Features*.
    - Reorder blocks using the "Order" field.

---

## 📂 Project Structure

```
veritas-cms/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Dashboard/      # Unified Dashboard Controllers
│   │   │   │   ├── StaffDashboardController.php
│   │   │   │   ├── PageController.php
│   │   │   │   └── ContentBlockController.php
│   │   └── Middleware/         # Custom Middleware (CmsAuth)
│   └── Models/                 # Eloquent Models (Staff, Page, ContentBlock)
├── resources/
│   ├── css/                    # Tailwind/Custom CSS
│   └── views/
│       ├── dashboard/
│       │   ├── admin/          # CMS Views (Pages, Blocks)
│       │   └── staff/          # Staff Dashboard Views
│       ├── layouts/            # Master Layouts (staff.blade.php)
│       └── partials/           # Sidebar, Navbar
├── routes/
│   ├── web.php                 # Web Routes
│   └── api.php                 # API Routes
└── public/                     # Compiled Assets
```

---

## 🤝 Contributing

1.  Fork the repository.
2.  Create a feature branch (`git checkout -b feature/AmazingFeature`).
3.  Commit your changes (`git commit -m 'Add some AmazingFeature'`).
4.  Push to the branch (`git push origin feature/AmazingFeature`).
5.  Open a Pull Request.

---

## 📄 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
