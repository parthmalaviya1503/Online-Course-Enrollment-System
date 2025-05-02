<?php
    include 'db.php';
    session_start();
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
    }

    if (isset($_POST['add'])) {
        $project_title = $_POST['project_title'];
        $description = $_POST['description'];

        $project_file_name = null;
        if (!empty($_FILES['project_file']['name'])) {
            $target_dir = "uploads/projects/";
            if (!is_dir($target_dir))
                mkdir($target_dir, 0777, true);
            $project_file_name = basename($_FILES['project_file']['name']);
            $target_file = $target_dir . $project_file_name;
            move_uploaded_file($_FILES['project_file']['tmp_name'], $target_file);
        }

        $stmt = $conn->prepare("INSERT INTO projects (project_title, description, project_file) VALUES (?, ?, ?)");
        $stmt->execute([$project_title, $description, $project_file_name]);

        echo "Project added successfully.";
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

<form method="POST" enctype="multipart/form-data">
    Project Title: <input type="text" name="project_title" required><br>
    Description: <input type="text" name="description"><br>
    Project File (optional): <input type="file" name="project_file"><br>
    <button name="add">Add Project</button>
</form>

<br>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Title</th>
        <th>Description</th>
        <th>File</th>
        <th>Action</th>
    </tr>
    <?php foreach ($projects as $p): ?>
        <tr>
            <form method="POST">
                <td><?= $p['id'] ?></td>
                <td><input name="title" value="<?= $p['title'] ?>"></td>
                <td><input name="description" value="<?= $p['description'] ?>"></td>
                <td>
                    <?php if ($p['project_file']): ?>
                        <a href="uploads/projects/<?= htmlspecialchars($p['project_file']) ?>" target="_blank">View File</a>
                    <?php else: ?>
                        No File
                    <?php endif; ?>
                </td>
                <td>
                    <input type="hidden" name="update_id" value="<?= $p['id'] ?>">
                    <button name="update">Update</button>
                    <button name="delete" value="<?= $p['id'] ?>">Delete</button>
                </td>
            </form>
        </tr>
    <?php endforeach; ?>
</table>

<br>
<a href="home.php">Back to home page</a>