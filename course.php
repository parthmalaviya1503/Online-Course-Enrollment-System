<?php
    include 'db.php';
    session_start();
    if (!isset($_SESSION['user_id']))
        header("Location: login.php");

    if (isset($_POST['add'])) {
        $course_name = $_POST['course_name'];
        $instructor = $_POST['instructor'];

        $certificate_name = null;
        if (!empty($_FILES['certificate_file']['name'])) {
            $target_dir = "uploads/certificates/";
            if (!is_dir($target_dir))
                mkdir($target_dir, 0777, true);
            $certificate_name = basename($_FILES['certificate_file']['name']);
            $target_file = $target_dir . $certificate_name;
            move_uploaded_file($_FILES['certificate_file']['tmp_name'], $target_file);
        }

        $stmt = $conn->prepare("INSERT INTO courses (course_name, instructor, certificate) VALUES (?, ?, ?)");
        $stmt->execute([$course_name, $instructor, $certificate_name]);

        echo "Course added successfully.";
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

<form method="POST" enctype="multipart/form-data">
    Course Name: <input type="text" name="course_name" required><br>
    Instructor: <input type="text" name="instructor" required><br>
    Certificate (optional): <input type="file" name="certificate_file"><br>
    <button name="add">Add Course</button>
</form>

<br>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Instructor</th>
        <th>Certificate</th>
        <th>Action</th>
    </tr>

    <?php foreach ($courses as $c): ?>
        <tr>
            <form method="POST">
                <td><?= $c['id'] ?></td>
                <td><input name="course_name" value="<?= $c['course_name'] ?>"></td>
                <td><input name="instructor" value="<?= $c['instructor'] ?>"></td>
                <td>
                    <?php if ($c['certificate']): ?>
                        <a href="uploads/certificates/<?= htmlspecialchars($c['certificate']) ?>" target="_blank">View
                            Certificate</a>
                    <?php else: ?>
                        No Certificate
                    <?php endif; ?>
                </td>

                <td>
                    <input type="hidden" name="update_id" value="<?= $c['id'] ?>">
                    <button name="update">Update</button>
                    <button name="delete" value="<?= $c['id'] ?>">Delete</button>
                </td>
            </form>
        </tr>
    <?php endforeach; ?>
</table>

<br>
<a href="home.php">Back to home page</a>