# WebPro Italy

A web platform for a digital agency built with PHP and MySQL for the Web Programming exam.

**Student:** Yasin Bargahi | **GitHub:** meganis10 | **2026**

---

## What is this project?

I built a website for a web design agency called WebPro Italy. The idea is simple — a business website where potential clients can see what services the agency offers, create an account, and send messages. The agency owner (admin) can log in to a separate panel and manage everything.

I chose this topic because I wanted to build something that looks like a real business website, not just a demo project.

---

## Technologies

- **PHP** — backend, form handling, database queries, API endpoints
- **MySQL** — stores users, admins, services and messages  
- **PDO** — secure database connection with prepared statements
- **HTML + CSS** — all pages styled from scratch, no frameworks
- **JavaScript + jQuery** — fade animations, active nav highlighting
- **XAMPP** — local Apache + MySQL server for development

---

## Pages

**Public side:**
- Homepage — shows agency services loaded from database
- About — agency info and stats
- Services — full services listing
- Contact — form that saves message to database
- Register — new user account with validation
- Login / Logout
- Profile — shows user info, option to delete account

**Admin panel** (`/admin`):
- Dashboard — total users, messages, services count
- Manage Services — add or delete services on homepage
- Messages — read full contact messages
- Users — view and delete registered users
- Admins — add or remove admin accounts

**API** (`/api`):
- `services.php` — GET — returns services as JSON
- `register.php` — POST — creates new user
- `login.php` — POST — authenticates user
- `users.php` — GET — returns users list (requires admin key)

---

## Database

Name: `webagency_db` — 4 tables:

- `users` — id, name, email, password, dob, country, city, created_at
- `admins` — id, name, email, password
- `messages` — id, name, email, subject, message, created_at
- `services` — id, title, description, icon

---

## Security features I implemented

- PDO prepared statements — prevents SQL injection
- password_hash() with BCRYPT — passwords never stored as plain text
- filter_var() on all inputs — removes dangerous characters
- Session + database check on every admin page — if admin deleted while logged in, they get kicked out immediately
- random_bytes(16) for IDs — impossible to guess record IDs
- Admin cannot delete their own account
- API key required for users endpoint

---

## How to run

1. Install XAMPP and start Apache + MySQL
2. Clone repo into `C:/xampp/htdocs/webagency`
3. Open phpMyAdmin, create database `webagency_db`
4. Import `webagency_db.sql`
5. Go to `http://localhost/webagency`
6. Create admin at `http://localhost/webagency/admin/register.php`

---

## What I would add with more time

- Edit services (not just add/delete)
- Email notification when contact message arrives
- Better mobile layout
- Profile picture upload
