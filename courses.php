<?php
include 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add'])) {
        $stmt = $conn->prepare("INSERT INTO courses (course_name, instructor) VALUES (?, ?)");
        $stmt->execute([$_POST['course_name'], $_POST['instructor']]);
    }

    if (isset($_POST['update'])) {
        $stmt = $conn->prepare("UPDATE courses SET course_name = ?, instructor = ? WHERE id = ?");
        $stmt->execute([$_POST['course_name'], $_POST['instructor'], $_POST['id']]);
    }

    if (isset($_POST['delete'])) {
        $stmt = $conn->prepare("DELETE FROM courses WHERE id = ?");
        $stmt->execute([$_POST['id']]);
    }
}

$courses = $conn->query("SELECT * FROM courses")->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Courses</title>
    <style>
        body { font-family: Arial; padding: 30px; background: #f5f5f5; }
        h2 { color: #333; }
        form, .list { background: #fff; padding: 20px; border-radius: 10px; margin-bottom: 30px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        input, button { padding: 10px; margin: 5px 0; width: 100%; }
        button { background: #007BFF; color: white; border: none; border-radius: 5px; }
        button:hover { background: #0056b3; }
        .back { margin-top: 20px; }
        a.back-btn { display: inline-block; padding: 10px 20px; background: #6c757d; color: white; text-decoration: none; border-radius: 5px; }
    </style>
</head>
<body>

<h2>Manage Courses</h2>

<form method="post">
    ID (for update/delete): <input type="text" name="id">
    Course Name: <input type="text" name="course_name" required>
    Instructor: <input type="text" name="instructor" required>
    <button name="add">Add Course</button>
    <button name="update">Update Course</button>
    <button name="delete">Delete Course</button>
</form>

<div class="list">
    <h3>All Courses</h3>
    <?php
        $courses = $conn->query("SELECT * FROM courses")->fetchAll();
        foreach ($courses as $course) {
            echo $course['id'] . " - " . $course['course_name'] . " - " . $course['instructor'] . "<br>";
        }
    ?>
</div>

<div class="back">
    <a href="index.php" class="back-btn">⬅ Back to Home</a>
</div>

</body>
</html>

<h3>All Courses</h3>
<?php foreach ($courses as $course): ?>
    <?= $course['id'] ?> - <?= $course['course_name'] ?> - <?= $course['instructor'] ?><br>
<?php endforeach; ?>
