<?php
include 'db.php';
session_start();
if (!isset($_SESSION['user_id'])) header("Location: login.php");

if (isset($_POST['add'])) {
    $stmt = $conn->prepare("INSERT INTO assignments (title, grade) VALUES (?, ?)");
    $stmt->execute([$_POST['title'], $_POST['grade']]);
}

if (isset($_POST['delete'])) {
    $stmt = $conn->prepare("DELETE FROM assignments WHERE id = ?");
    $stmt->execute([$_POST['delete']]);
}

if (isset($_POST['update'])) {
    $stmt = $conn->prepare("UPDATE assignments SET title=?, grade=? WHERE id=?");
    $stmt->execute([$_POST['title'], $_POST['grade'], $_POST['update_id']]);
}

$assignments = $conn->query("SELECT * FROM assignments")->fetchAll();
?>
<h2>Assignments Management</h2>
<form method="POST">
    Title: <input type="text" name="title" required>
    Grade: <input type="text" name="grade" required>
    <button name="add">Add Assignment</button>
</form>
<br>
<table border="1">
    <tr><th>ID</th><th>Title</th><th>Grade</th><th>Action</th></tr>
    <?php foreach ($assignments as $a): ?>
    <tr>
        <form method="POST">
        <td><?= $a['id'] ?></td>
        <td><input name="title" value="<?= $a['title'] ?>"></td>
        <td><input name="grade" value="<?= $a['grade'] ?>"></td>
        <td>
            <input type="hidden" name="update_id" value="<?= $a['id'] ?>">
            <button name="update">Update</button>
            <button name="delete" value="<?= $a['id'] ?>">Delete</button>
        </td>
        </form>
    </tr>
    <?php endforeach; ?>
</table>
<a href="home.php">Back</a>
