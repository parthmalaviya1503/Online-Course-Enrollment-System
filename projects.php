<?php
include 'db.php';
session_start();
if (!isset($_SESSION['user_id'])) header("Location: login.php");

if (isset($_POST['add'])) {
    $stmt = $conn->prepare("INSERT INTO projects (title, description) VALUES (?, ?)");
    $stmt->execute([$_POST['title'], $_POST['description']]);
}

if (isset($_POST['delete'])) {
    $stmt = $conn->prepare("DELETE FROM projects WHERE id = ?");
    $stmt->execute([$_POST['delete']]);
}

if (isset($_POST['update'])) {
    $stmt = $conn->prepare("UPDATE projects SET title=?, description=? WHERE id=?");
    $stmt->execute([$_POST['title'], $_POST['description'], $_POST['update_id']]);
}

$projects = $conn->query("SELECT * FROM projects")->fetchAll();
?>
<h2>Projects Management</h2>
<form method="POST">
    Title: <input type="text" name="title" required>
    Description: <input type="text" name="description" required>
    <button name="add">Add Project</button>
</form>
<br>
<table border="1">
    <tr><th>ID</th><th>Title</th><th>Description</th><th>Action</th></tr>
    <?php foreach ($projects as $p): ?>
    <tr>
        <form method="POST">
        <td><?= $p['id'] ?></td>
        <td><input name="title" value="<?= $p['title'] ?>"></td>
        <td><input name="description" value="<?= $p['description'] ?>"></td>
        <td>
            <input type="hidden" name="update_id" value="<?= $p['id'] ?>">
            <button name="update">Update</button>
            <button name="delete" value="<?= $p['id'] ?>">Delete</button>
        </td>
        </form>
    </tr>
    <?php endforeach; ?>
</table>
<a href="home.php">Back</a>
