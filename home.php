<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>
<h2>Welcome to Home Page</h2>
<ul>
    <li><a href="course.php">Course</a></li>
    <li><a href="assignments.php">Assignments</a></li>
    <li><a href="projects.php">Projects</a></li>
    <li><a href="logout.php">Logout</a></li>
</ul>
