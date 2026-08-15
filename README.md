# MSR Admin

**Laravel Admin Starter Kit** is a modern, scalable, and customizable admin panel starter kit built with **Laravel 13**, providing a solid foundation for managing users, roles, permissions, settings, blog content, categories, and other essential administrative features.


---

## Features

### Admin Panel
- Admin authentication
- Dashboard
- Blog CRUD
- Blog Category
- User management
- User details
- Role management
- Permission management
- Profile management
- Application settings
- Secure admin routes
- Responsive admin interface

### Roles & Permissions
- Create and manage roles
- Create and manage permissions
- Assign permissions to roles
- Assign roles to users
- Restrict access to protected admin features
- Middleware-based authorization

### Search & Dynamic Features
- Dynamic data searching
- Server-side filtering
- Pagination
- Dynamic sorting
- Search by multiple fields
- AJAX-based dynamic operations
- Reusable query/filter logic

### Database & Seeders
- Laravel migrations
- Database seeders
- Factory support
- Default admin/user seeding
- Role and permission seeding
- Application configuration seeding

### Security
- Laravel authentication
- Password hashing
- CSRF protection
- Authentication middleware
- Authorization middleware
- Form request validation
- Mass-assignment protection
- Secure session handling

---

## Tech Stack

| Technology       | Version     |
|------------------|-------------|
| Laravel          | 13          |
| PHP              | 8.3+        |
| Database         | MySQL       |
| Frontend         | Blade       |
| CSS Framework    | Bootstrap   |
| JavaScript       | JavaScript  |
| Package Manager  | Composer    |

---

## Requirements

Make sure the following are installed on your system:

- PHP >= 8.3
- Composer
- MySQL
- Git

Check versions:

```bash
php -v
composer -V
```

---

## Installation

Follow the steps below carefully to install the project.

### Step 1: Clone the Repository

```bash
git clone https://github.com/mdsohelrana71/laravel-admin-starter-kit.git
cd laravel-admin-starter-kit
```

### Step 2: Install Composer Dependencies

```bash
composer install
```

### Step 3: Setup Environment File

```bash
cp .env.example .env
php artisan key:generate
```

### Step 4: Configure Database

Open the `.env` file and update the database settings:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=msr_admin
DB_USERNAME=root
DB_PASSWORD=your_password
```

Then create the database in MySQL:

```sql
CREATE DATABASE msr_admin;
```

### Step 5: Run Migration and Seeder

```bash
php artisan migrate --seed
```

This command will:
- Create all database tables
- Insert default admin user
- Insert default roles and permissions

### Step 6: Start the Server

```bash
php artisan serve
```

Now open your browser and go to:

```
http://127.0.0.1:8000
```

---

## Default Admin Login

| Field    | Value               |
|----------|---------------------|
| Email    | admin@gmail.com   |
| Password | 12345678            |

> **Important:** Change the default password after first login.

---