# 🎓 Online Course Enrollment System

A simple web-based application built with **PHP** and **MySQL** that allows students to register, login, enroll in courses, upload assignments, submit course certificates, and manage projects.

## 🚀 Features

- Student Registration & Login
- Course Management (CRUD) with optional certificate upload
- Project Management (CRUD) with optional project file upload
- Assignment upload and management
- Session-based authentication
- File uploads with secure storage
- Simple UI with HTML + CSS

## 🗃️ Database Schema

**students**
- id (INT, PK)
- name (VARCHAR)
- email (VARCHAR, UNIQUE)
- contact (VARCHAR)
- password (VARCHAR)

**courses**
- id (INT, PK)
- course_name (VARCHAR)
- instructor (VARCHAR)
- certificate (VARCHAR, nullable)

**projects**
- id (INT, PK)
- project_title (VARCHAR)
- description (TEXT)
- project_file (VARCHAR, nullable)

**assignments**
- id (INT, PK)
- student_id (FK → students.id)
- course_id (FK → courses.id)
- assignment_file (VARCHAR)

## 📂 Folder Structure

/Online_Course_Enrollment_System/
├── db.php
├── index.php
├── login.php
├── register.php
├── home.php
├── courses.php
├── projects.php
├── assignments.php
├── uploads/
│ ├── certificates/
│ ├── projects/
│ └── assignments/
└── README.md


## 🏃‍♂️ How to Run

1. Install **XAMPP**
2. Clone or download this repository
3. Move the project folder to `htdocs` (XAMPP)
4. Import `database.sql` into **phpMyAdmin**
5. Start **Apache** and **MySQL** from XAMPP
6. Visit [http://localhost/Online_Course_Enrollment_System](http://localhost/Online_Course_Enrollment_System)

## 🔐 Login

Register a new user using `register.php` → then log in.

## 🎨 Future Improvements

- Admin panel
- Search & filter functionality
- Responsive UI with Bootstrap
- Better error handling

## 💻 Contributing

Feel free to fork this repository and contribute!

## 📄 License

This project is open-source under the MIT License.