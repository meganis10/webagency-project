# 🌐 WebPro Italy

<div align="center">

![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-005C84?style=for-the-badge&logo=mysql&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black)
![jQuery](https://img.shields.io/badge/jQuery-0769AD?style=for-the-badge&logo=jquery&logoColor=white)
![HTML5](https://img.shields.io/badge/HTML5-E34F26?style=for-the-badge&logo=html5&logoColor=white)
![CSS3](https://img.shields.io/badge/CSS3-1572B6?style=for-the-badge&logo=css3&logoColor=white)

### Web Design Agency Platform — Web Programming Exam Project

*A full-stack web application for a professional web design agency*

</div>

---

## 📋 Table of Contents
- [Introduction](#-introduction)
- [Features](#-features)
- [Tech Stack](#-tech-stack)
- [Installation](#-installation)
- [Database Setup](#-database-setup)
- [API Endpoints](#-api-endpoints)
- [Security](#-security)
- [Project Structure](#-project-structure)
- [Future Scope](#-future-scope)
- [Author](#-author)

---

## 📖 Introduction

**WebPro Italy** is a complete full-stack web application that simulates a professional web design agency platform. It allows visitors to browse services, register accounts and contact the agency. A dedicated admin panel provides full control over all website content.

The platform was built entirely from scratch using PHP, MySQL, HTML, CSS and JavaScript with jQuery — with a strong focus on security best practices.

---

## ✨ Features

### 🎯 Core Objectives

| Objective | Description |
|-----------|-------------|
| 🔐 **Security** | SQL injection prevention, password hashing, session validation |
| 👥 **User Management** | Full registration, login and profile system |
| ⚙️ **Admin Control** | Complete content management through admin panel |
| 🔌 **API Ready** | RESTful PHP API endpoints returning JSON |

### 🔑 Key Modules

#### 🔐 Admin Module
- 📊 **Dashboard** — live statistics (total users, messages, services)
- ⚙️ **Services Management** — add and delete services shown on homepage
- 📧 **Messages** — view full contact messages from visitors
- 👥 **Users** — view and delete registered users
- 🛡️ **Admins** — manage admin accounts (cannot delete own account)

#### 🧑 User Module
- 📝 **Registration** — with duplicate email check and validation
- 🔐 **Login/Logout** — secure session-based authentication
- 👤 **Profile** — view personal info and delete account
- 📬 **Contact** — send messages to the agency
- 🌐 **Browse** — view agency services and about page

---

## 🛠️ Tech Stack

| Layer | Technology |
|-------|-----------|
| 🎨 **Frontend** | HTML5, CSS3, JavaScript, jQuery 3.6.0 |
| ⚙️ **Backend** | PHP 8.x |
| 🗄️ **Database** | MySQL 8.x |
| 🔌 **DB Connection** | PDO with prepared statements |
| 🖥️ **Server** | Apache via XAMPP |

---

## 💻 Installation

### Prerequisites
- 🖥️ XAMPP (Apache + MySQL)
- 🌐 Modern web browser
- 📦 PHP 7.4 or higher
- 🗄️ MySQL 5.7 or higher

### Steps

1. **Clone the repository**
   ```bash
   git clone https://github.com/meganis10/webagency-project.git
   ```

2. **Move to server directory**
   ```bash
   move webagency-project C:/xampp/htdocs/webagency
   ```

3. **Start XAMPP**
   - Open XAMPP Control Panel
   - Start **Apache** and **MySQL**

4. **Import the database**
   - Open phpMyAdmin at http://localhost/phpmyadmin
   - Create a new database named `webagency_db`
   - Import the `webagency_db.sql` file from the project root

5. **Access the application**
   ```
   http://localhost/webagency
   ```

6. **Create admin account**
   ```
   http://localhost/webagency/admin/register.php
   ```

---

## 🗄️ Database Setup

Database name: `webagency_db`

| Table | Description |
|-------|-------------|
| 👥 `users` | Registered website users (name, email, password, dob, country, city) |
| 🔐 `admins` | Administrator accounts |
| 📧 `messages` | Contact form submissions |
| ⚙️ `services` | Agency services displayed on homepage |

---

## 🔌 API Endpoints

| Endpoint | Method | Description |
|----------|--------|-------------|
| `api/services.php` | GET | Returns all services as JSON |
| `api/register.php` | POST | Register a new user |
| `api/login.php` | POST | Authenticate a user |
| `api/users.php?admin_key=webpro2025` | GET | Get all users (admin key required) |

### Example API Response
```json
{
    "status": "success",
    "count": 3,
    "data": [
        {
            "id": "a3f8c2d19e4b7a6f",
            "title": "Web Design",
            "description": "Beautiful modern websites",
            "icon": "fa-laptop-code"
        }
    ]
}
```

---

## 🔒 Security

| Feature | Implementation |
|---------|---------------|
| 🛡️ **SQL Injection** | PDO prepared statements with ? placeholders |
| 🔑 **Password Hashing** | password_hash() with BCRYPT algorithm |
| 🧹 **XSS Prevention** | filter_var() with FILTER_SANITIZE_STRING |
| 🔐 **Session Validation** | Database check on every admin page load |
| 🎲 **Random IDs** | random_bytes(16) converted to hex |
| 🗝️ **API Key** | Admin key required for sensitive endpoints |
| 🚫 **Access Control** | Admin cannot delete own account |

---

## 📁 Project Structure

```
webagency/
├── index.php              # Homepage with services
├── register.php           # User registration
├── login.php              # User login
├── logout.php             # Session destroy
├── profile.php            # User profile and delete account
├── about.php              # About page
├── services.php           # Public services page
├── contact.php            # Contact form
├── webagency_db.sql       # Database export
│
├── admin/
│   ├── dashboard.php      # Admin dashboard with stats
│   ├── services.php       # Manage services
│   ├── messages.php       # View messages
│   ├── users.php          # Manage users
│   ├── admins.php         # Manage admin accounts
│   ├── login.php          # Admin login
│   ├── register.php       # Admin registration
│   └── logout.php         # Admin logout
│
├── api/
│   ├── services.php       # GET services as JSON
│   ├── register.php       # POST register user
│   ├── login.php          # POST login user
│   └── users.php          # GET users (admin only)
│
├── components/
│   ├── connect.php        # Database connection + unique_id()
│   ├── header.php         # Navigation header
│   ├── footer.php         # Page footer
│   └── admin_header.php   # Admin header with access control
│
├── css/
│   ├── style.css          # Main stylesheet
│   └── admin.css          # Admin panel styles
│
└── js/
    └── script.js          # jQuery animations and interactions
```

---

## 🚀 Future Scope

| Feature | Description |
|---------|-------------|
| ✏️ **Edit Services** | Allow admin to edit existing services not just add/delete |
| 📧 **Email Notifications** | Send email when new contact message arrives |
| 📱 **Mobile Responsive** | Improve layout for mobile devices |
| 🖼️ **Image Upload** | Allow admin to upload service images |
| 🌍 **Multi-language** | Italian and English language support |

---

## 👨‍💻 Author

**Yasin Bargahi**
- 🐙 GitHub: [meganis10](https://github.com/meganis10)
- 📚 Exam: Web Programming
- 🗓️ Year: 2026

---

<div align="center">

*Built with ❤️ for the Web Programming exam*

</div>
