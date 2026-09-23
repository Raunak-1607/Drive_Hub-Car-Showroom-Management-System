# DriveHub — Car Showroom Management System

CSC 3215 Web Technologies — group project.
Built with **HTML, CSS, Vanilla JavaScript, PHP and MySQL only**.

---

## Setup (XAMPP, Windows)

1. Start **Apache** and **MySQL** in the XAMPP Control Panel.
2. Copy this folder to `C:\xampp\htdocs\drivehub`
3. Go to `http://localhost/phpmyadmin` → **Import** tab (make sure **no database is
   selected** on the left) → choose `database/drivehub.sql` → **Go**.
4. Open `http://localhost/drivehub`

Database settings live in `models/dbConnect.php`.

## Test logins

| Email                   | Password            | Role
|------------------------ |---------------------| ------------------ 
|   admin@drivehub.com    |   Admin@123         | Admin
|   employee@drivehub.com |   Employee@123      | Employee
|   customer@drivehub.com |   Customer@123      | Customer

Security answers (lowercase): `buddy`, `malmo`, `dune`.

## 2. How the project is organised (MVC)

```
drivehub/
├── index.php              sends the visitor to the login page
├── database/
│   └── drivehub.sql       the whole database + sample data
├── models/                talk to MySQL. No HTML in here.
├── controllers/           receive forms, validate, decide where to go next
└── views/                 the pages the user actually sees
```

Flow is always: **VIEW (form) → CONTROLLER (validate, decide) → MODEL (SQL) → redirect back to a VIEW.**


### Why each folder exists

| Folder | What it does |
|---|---|
| `models/` | One file per database table. Each function runs one SQL query and returns rows or true/false. |
| `controllers/` | One file per feature. Reads `$_POST`, validates it, calls a model function, then redirects. |
| `views/` | HTML + PHP in the same file, exactly as the faculty samples do. |
| `views/partials/` | The navigation bar and the sidebar, so 25 pages don't repeat the same markup. |
| `views/css/` | `style.css` is shared by everything. `auth.css` is the login screens. `customer.css` is the car cards and details. |
| `views/js/` | `registerValidation.js` (JavaScript validation) and `main.js` (show password, delete confirm). |
| `views/uploads/` | Where vehicle pictures are saved when the admin uploads one. |


### The 5 database tables

| Table | Holds | Linked to |
|---|---|---|
| `users` | customers, employees and admins together, separated by the `role` column | — |
| `cars` | the showroom inventory | — |
| `test_drives` | one row per test drive request | `users`, `cars` |
| `inquiries` | one row per customer question | `users`, `cars` |
| `sales` | one row per sale | `users` (customer), `users` (employee), `cars` |

This is in 3NF: every fact lives in exactly one table, and the activity tables only
store foreign keys instead of repeating names and prices.

---

