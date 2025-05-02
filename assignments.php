<?php
    include 'db.php';
    session_start();
    if (!isset($_SESSION['user_id']))
        header("Location: login.php");

    if (isset($_POST['add'])) {
        $title = $_POST['title'];
        $grade = $_POST['grade'];

        // Handle file upload
        $target_dir = "uploads/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir);
        }
        $file_name = basename($_FILES["assignment_file"]["name"]);
        $target_file = $target_dir . $file_name;

        if (move_uploaded_file($_FILES["assignment_file"]["tmp_name"], $target_file)) {
            $stmt = $conn->prepare("INSERT INTO assignments (title, grade, file_path) VALUES (?, ?, ?)");
            $stmt->execute([$title, $grade, $target_file]);
            echo "Assignment uploaded successfully.";
        } else {
            echo "Error uploading file.";
        }
    }

    if (isset($_POST['delete'])) {
        $stmt = $conn->prepare("DELETE FROM assignments WHERE id = ?");
        $stmt->execute([$_POST['delete']]);
    }

    if (isset($_POST['update'])) {
        $stmt = $conn->prepare("UPDATE assignments SET title=?, grade=? WHERE id=?");
        $stmt->execute([$_POST['title'], $_POST['grade'], $_POST['update_id']]);
        echo "Assignment updated.";
    }

    $assignments = $conn->query("SELECT * FROM assignments")->fetchAll();
?>

<h2>Assignments Management</h2>

<form method="POST" enctype="multipart/form-data">
    Title : <input type="text" name="title" required><br>
    Grade : <input type="text" name="grade"><br>
    Assignment : <input type="file" name="assignment_file" required><br>
    <button name="add">Add Assignment</button>
</form>

<br>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Title</th>
        <th>Grade</th>
        <th>Action</th>
    </tr>
    <?php foreach ($assignments as $a): ?>
        <tr>
            <form method="POST">
                <td><?= $a['id'] ?></td>
                <td><input name="title" value="<?= $a['title'] ?>"></td>
                <td><input name="grade" value="<?= $a['grade'] ?>"></td>
                <td>
                    <?php if ($a['file_path']): ?>
                        <a href="<?= $a['file_path'] ?>" target="_blank">View File</a>
                    <?php else: ?>
                        No file
                    <?php endif; ?>
                </td>
                <td>
                    <input type="hidden" name="update_id" value="<?= $a['id'] ?>">
                    <button name="update" name="update">Update</button>
                    <button name="delete" value="<?= $a['id'] ?>">Delete</button>
                </td>
            </form>
        </tr>
    <?php endforeach; ?>
</table>

<br>
<a href="home.php">Back to home page</a>