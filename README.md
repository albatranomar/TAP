# Task Allocator Pro (TAP)
![PHP](https://img.shields.io/badge/PHP-8.2%2B-blue) ![MySQL](https://img.shields.io/badge/MySQL-8.0%2B-orange) ![HTML5](https://img.shields.io/badge/HTML5-E34F26?logo=html5&logoColor=white) ![CSS3](https://img.shields.io/badge/CSS3-1572B6?logo=css3&logoColor=white)

Task Allocator Pro (TAP) is a web-based task management system designed to facilitate efficient task allocation and monitoring for small teams. The system enables managers to assign tasks, monitor progress, and review task completion, while team members can view and update their assigned tasks.

---

## Table of Contents

1. [Features](#features)
2. [Technologies Used](#technologies-used)
3. [Installation](#installation)

---

## Features
### Manager
- Add projects and save project details to the database.
- Allocate team leaders to projects.

### Project Leader
- Create tasks and assign them to team members.
- Allocate team members to tasks with roles and contribution percentages.

### Team Member
- Accept or reject task assignments.
- Search and update task progress using an interactive range slider.

### All Users
- User registration and login/logout functionality.
- Search functionality for tasks based on filters.
- View task details.

---

## Technologies Used

- **Frontend**: HTML, CSS (Flexbox/Grid), JavaScript
- **Backend**: PHP (PDO for database interaction)
- **Database**: MySQL
- **Web Server**: Apache (localhost compatible)
---

## Installation

### Prerequisites

- PHP 7.4 or higher
- MySQL 5.7 or higher
- Apache Web Server
- Composer (optional, for dependency management)

### Steps

1. **Clone the Repository**
   ```bash
   git clone https://github.com/albatranomar/TAP.git
   cd TAP
   ```

2. **Set Up the Database**
   - Import the SQL schema into your MySQL database (`dbschema_1221344.sql`)
   - Update the `db.php.inc` file with your database credentials:
     ```php
     <?php
     $host = 'FILL';
     $dbname = 'FILL';
     $username = 'FILL';
     $password = 'FILL';

     try {
         $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
         $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
     } catch (PDOException $e) {
         die("Database connection failed: " . $e->getMessage());
     }
     ?>
     ```

3. **Run the Application**
   - Place the project folder in your web server's root directory (e.g., `htdocs` for XAMPP).
   - Access the application via:
     ```
     http://localhost/TAP/
     ```
