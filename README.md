# Veritas CMS

A robust, custom-built Content Management System for managing the Veritas University website. This system is designed for ease of use, performance, and flexibility, allowing staff to manage content without touching the source code.

## 🚀 Features

### **Content Management**
*   **Pages:** Create, edit, and manage dynamic pages with a block-based editor.
*   **News & Events:** Publish news articles and schedule upcoming events.
*   **Personnel:** Manage staff profiles and directories.
*   **Student Groups:** handle student organizations and groups.
*   **Courses & Programs:** Manage academic offerings.
*   **Research Groups & Publications:** Showcase research outputs and teams.
*   **Mass Schedules:** Handle large-scale scheduling data.
*   **FAQs & A-Z Index:** Manage help resources and directory indices.

### **System Features**
*   **Role-Based Access Control (RBAC):** Granular permissions for Super Admins, Editors, and standard Staff.
*   **Media Management:** Secure file uploads and image handling.
*   **Rich Text Editing:** User-friendly WYSIWYG editors for content blocks.
*   **Responsive Design:** Fully responsive dashboard built with Bootstrap 5.
*   **Secure Authentication:** Multi-guard authentication for Staff and Students.

## 🛠 Installation

1.  **Clone the repository**
    ```bash
    git clone https://github.com/veritas-ict/veritas-cms.git
    cd veritas-cms
    ```

2.  **Install Dependencies**
    ```bash
    composer install
    npm install
    ```

3.  **Environment Setup**
    Copy the example environment file and configure your database credentials.
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

4.  **Database Migration**
    Run the migrations to set up the database schema.
    *Note: Use standard migrations. Avoid `migrate:fresh` in production.*
    ```bash
    php artisan migrate
    ```

5.  **Serve the Application**
    ```bash
    php artisan serve
    npm run dev
    ```

## 📚 Usage Guide

### **Logging In**
Access the CMS via `/staff/login`. Use your staff credentials.

### **Dashboard Overview**
*   **Super Admins:** Have full access to all modules, including Role Assignment.
*   **Editors:** Can manage content (News, Pages, Events) but cannot assign roles.
*   **Staff (No Role):** Can view the dashboard and access the **Help Center** to learn how to request access.

### **Managing Content**
Navigate to the "Website Content" section in the sidebar. Select the module you wish to edit (e.g., News).
*   **Create:** Click "Add New" to create an entry.
*   **Edit:** Click the edit icon on any row to modify content.
*   **Delete:** Remove outdated content (requires confirmation).

### **Role Assignment (Super Admin)**
Navigate to **Administration > Role Assignment**.
1.  Search for a staff member by name or email.
2.  Select their name from the dropdown.
3.  Choose a role (e.g., Editor, Super Admin).
4.  Click "Assign".

## 🆘 Support

For technical issues or to request CMS access, please contact the ICT Department.
Visit the **Help Center** within the dashboard for a detailed walkthrough and interactive demo.
