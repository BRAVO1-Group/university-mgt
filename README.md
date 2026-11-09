# Student Management System

## 1. Installation and Database Setup

### 1.1 Prerequisites

Before installing the application, ensure that you have the following installed:

- PHP
- Composer
- Laravel-compatible database (SQLite)
- Node.js and npm
- blade
- Git

### 1.2 Installation

Follow the steps below to set up the project locally.

**Step 1: Clone the repository**

```bash
git clone <repository-url>
```

**Step 2: Navigate into the project directory**

```bash
cd university-mgt
```

**Step 3: Install PHP dependencies**

```bash
composer install
```

**Step 4: Install frontend dependencies**

```bash
npm install
```

**Step 5: Create the environment file**

```bash
cp .env.example .env
```

**Step 6: Generate the application key**

```bash
php artisan key:generate
```

### 1.3 Database Setup

The application uses SQLite as its database.

1. Create the SQLite database file if it does not already exist:

```bash
touch database/database.sqlite
```

2. Configure the database connection in the `.env` file:

```env
DB_CONNECTION=sqlite
```

3. Run the database migrations and seeders:

```bash
php artisan migrate --seed
```

This creates the required database tables and populates the database with sample records.

### 1.4 Running the Application

Start the Laravel development server:

```bash
php artisan serve
```

In another terminal, start the frontend development server:

```bash
npm run dev
```

Open the application in your browser using:

```text
http://127.0.0.1:8000
```

## 2. User Roles and Sample Login Credentials

The system implements three user roles:

### Administrator

- Manages student records.
- Manages academic courses.
- Manages course registrations.
- Manages user access.

### Lecturer

- Views assigned courses.
- Views students registered for assigned courses.

### Student

- Views available courses.
- Views their own course registrations.

### Sample Login Credentials

The following table provides the sample accounts created through the database seeders.

| User Role     | Email              | Password    |
| ------------- | ------------------ | ----------- |
| Administrator | admin@gmail.com    | Admin123    |
| Lecturer      | lecturer@gmail.com | Lecturer123 |
| Student       | student@gmail.com  | Student123  |

## 3. Application Screenshots

This section contains screenshots demonstrating the working application.

### 3.1 Login Page

![Login Page](assets/img/Login.png)

### 3.2 Administrator Dashboard

![Administrator Dashboard](assets/img/Admindashboard.png)

### 3.3 Student Management

![Student Management](assets/img/studentmanagment.png)

### 3.4 Course Management

![Course Managment](assets/img/coursemanagement.png)

### 3.5 Course Registration

![Course Registration](assets/img/coursemanagement.png)

### 3.6 Lecturer View

![Lecturer View](assets/img/lecturerview.png)

### 3.7 Student View

![Student View](assets/img/studentview.png)
