# 🚗 DriveHub — Car Showroom Management System

![DriveHub](https://via.placeholder.com/1200x400.png?text=DriveHub+Car+Showroom+Management+System) <!-- Replace with actual banner if available -->

**DriveHub** is a comprehensive Car Showroom Management System built as a group project for the CSC 3215 Web Technologies course. It provides a robust, multi-role web platform for managing vehicle inventory, customer inquiries, test drives, and showroom sales.

Built entirely from scratch using a custom **Model-View-Controller (MVC)** architecture without relying on external frameworks.

---

## ✨ Features

The system supports three distinct user roles, each with specialized capabilities:

### 👨‍💼 Administrator
- **Inventory Management**: Add, update, and remove vehicles from the showroom.
- **Employee Management**: Register new employees, manage their accounts, and oversee performance.
- **Reporting**: View comprehensive showroom reports, including sales data and inventory status.
- **Profile Management**: Update personal admin profile and security settings.

### 👔 Employee
- **Sales Processing**: Handle and record vehicle sales.
- **Customer Interaction**: Manage customer inquiries and schedule test drives.
- **Inventory Access**: View available vehicles and their details to assist customers.

### 👤 Customer
- **Vehicle Browsing**: Explore the showroom inventory with detailed car specifications.
- **Test Drives**: Request and schedule test drives for specific vehicles.
- **Inquiries**: Send questions and interact with showroom staff.
- **Account Management**: Register, log in, and manage personal profile and password recovery.

---

## 🛠️ Tech Stack

- **Frontend**: HTML5, CSS3, Vanilla JavaScript
- **Backend**: PHP (Core)
- **Database**: MySQL (in 3NF design)
- **Architecture**: Custom MVC (Model-View-Controller)

---

## 📁 Project Structure (MVC)

The codebase is organized following a strict MVC pattern to separate concerns, making it scalable and easy to maintain.

```text
Drive_Hub/
├── index.php              # Application entry point (redirects to landing page)
├── database/              
│   └── dh.sql             # SQL dump containing database schema and sample data
├── models/                # Database interaction logic (No HTML allowed here)
│   ├── dbConnect.php      # Database connection settings
│   └── *Model.php         # Table-specific queries (e.g., usersModel, carsModel)
├── controllers/           # Business logic, form validation, and routing
│   └── *Controls.php      # Handles POST requests and coordinates with Models
└── views/                 # Presentation layer (HTML + PHP templates)
    ├── css/               # Stylesheets (e.g., auth.css, style.css)
    ├── js/                # Client-side scripts (e.g., validation, UI interactions)
    ├── partials/          # Reusable UI components (Navbars, Sidebars)
    ├── uploads/           # Directory for uploaded vehicle images
    └── *.php              # User-facing pages
```

**Data Flow:** `VIEW (Form Submit)` ➔ `CONTROLLER (Validate & Logic)` ➔ `MODEL (Database Queries)` ➔ `CONTROLLER (Redirect)` ➔ `VIEW (Render Output)`

---

## 🚀 Setup & Installation (Windows / XAMPP)

Follow these steps to run DriveHub locally on your machine:

1. **Install XAMPP**: Download and install [XAMPP](https://www.apachefriends.org/index.html).
2. **Start Services**: Open the XAMPP Control Panel and start both **Apache** and **MySQL**.
3. **Clone/Copy Project**: 
   - Place the entire `Drive_Hub` project folder inside the `htdocs` directory.
   - Path should be: `C:\xampp\htdocs\Drive_Hub`
4. **Database Setup**:
   - Open your browser and go to `http://localhost/phpmyadmin`
   - Click on the **Import** tab at the top (ensure no specific database is selected on the left sidebar).
   - Click **Choose File** and select `database/dh.sql` from the project folder.
   - Click **Import** (or **Go**) at the bottom. This will create the database (`drivehub`) and populate the sample data.
5. **Configuration**:
   - Database connection settings can be modified in `models/dbConnect.php` if you have a custom MySQL password.
6. **Launch Application**:
   - Open your browser and navigate to: `http://localhost/Drive_Hub`

---

## 🔑 Test Credentials

Use the following sample accounts to explore the different roles within the system:

| Role       | Email Address           | Password       |
|------------|-------------------------|----------------|
| **Admin**  | `admin@drivehub.com`    | `Admin@123`    |
| **Employee**| `employee@drivehub.com`| `Employee@123` |
| **Customer**| `customer@drivehub.com`| `Customer@123` |

> 🔒 **Security Questions**: The answers for password recovery are all lowercase: `buddy`, `malmo`, `dune`.

---

## 🗄️ Database Architecture

The database is highly optimized and normalized to the **3rd Normal Form (3NF)** to ensure data integrity and eliminate redundancy.

| Table | Description | Relationships |
|-------|-------------|---------------|
| `users` | Stores all accounts (Admins, Employees, Customers) differentiated by a `role` column. | — |
| `cars` | The central vehicle inventory containing details like make, model, price, and images. | — |
| `test_drives` | Records of customer test drive requests. | Linked to `users` and `cars` |
| `inquiries` | Customer questions and messages. | Linked to `users` and `cars` |
| `sales` | Records of completed vehicle purchases. | Linked to `users` (Customer & Employee) and `cars` |

---
