<?php
include 'db.php';
session_start();
if (!isset($_SESSION['user_id'])) header("Location: login.php");

if (isset($_POST['add'])) {
    $stmt = $conn->prepare("INSERT INTO courses (course_name, instructor) VALUES (?, ?)");
    $stmt->execute([$_POST['course_name'], $_POST['instructor']]);
}

if (isset($_POST['delete'])) {
    $stmt = $conn->prepare("DELETE FROM courses WHERE id = ?");
    $stmt->execute([$_POST['delete']]);
}

if (isset($_POST['update'])) {
    $stmt = $conn->prepare("UPDATE courses SET course_name=?, instructor=? WHERE id=?");
    $stmt->execute([$_POST['course_name'], $_POST['instructor'], $_POST['update_id']]);
}

$courses = $conn->query("SELECT * FROM courses")->fetchAll();
?>
<h2>Course Management</h2>
<form method="POST">
    Course Name: <input type="text" name="course_name" required>
    Instructor: <input type="text" name="instructor" required>
    <button name="add">Add Course</button>
</form>
<br>
<table border="1">
    <tr><th>ID</th><th>Name</th><th>Instructor</th><th>Action</th></tr>
    <?php foreach ($courses as $c): ?>
    <tr>
        <form method="POST">
        <td><?= $c['id'] ?></td>
        <td><input name="course_name" value="<?= $c['course_name'] ?>"></td>
        <td><input name="instructor" value="<?= $c['instructor'] ?>"></td>
        <td>
            <input type="hidden" name="update_id" value="<?= $c['id'] ?>">
            <button name="update">Update</button>
            <button name="delete" value="<?= $c['id'] ?>">Delete</button>
        </td>
        </form>
    </tr>
    <?php endforeach; ?>
</table>
<a href="home.php">Back</a>
