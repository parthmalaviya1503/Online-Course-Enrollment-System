<?php
include 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add'])) {
        $stmt = $conn->prepare("INSERT INTO assignments (enrollment_id, title, grade) VALUES (?, ?, ?)");
        $stmt->execute([$_POST['enrollment_id'], $_POST['title'], $_POST['grade']]);
    }

    if (isset($_POST['update'])) {
        $stmt = $conn->prepare("UPDATE assignments SET enrollment_id = ?, title = ?, grade = ? WHERE id = ?");
        $stmt->execute([$_POST['enrollment_id'], $_POST['title'], $_POST['grade'], $_POST['id']]);
    }

    if (isset($_POST['delete'])) {
        $stmt = $conn->prepare("DELETE FROM assignments WHERE id = ?");
        $stmt->execute([$_POST['id']]);
    }
}

$assignments = $conn->query("
    SELECT assignments.id, students.name AS student_name, courses.course_name, title, grade
    FROM assignments
    JOIN enrollments ON assignments.enrollment_id = enrollments.id
    JOIN students ON enrollments.student_id = students.id
    JOIN courses ON enrollments.course_id = courses.id
")->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Assignments</title>
    <style>
        body { font-family: Arial; padding: 30px; background: #f5f5f5; }
        form, .list { background: #fff; padding: 20px; border-radius: 10px; margin-bottom: 30px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        input, button { padding: 10px; margin: 5px 0; width: 100%; }
        button { background: #007BFF; color: white; border: none; border-radius: 5px; }
        .back { margin-top: 20px; }
        a.back-btn { padding: 10px 20px; background: #6c757d; color: white; text-decoration: none; border-radius: 5px; }
    </style>
</head>
<body>

<h2>Manage Assignments</h2>

<form method="post">
    ID (for update/delete): <input type="text" name="id">
    Enrollment ID: <input type="number" name="enrollment_id" required>
    Title: <input type="text" name="title" required>
    Grade: <input type="text" name="grade">
    <button name="add">Add Assignment</button>
    <button name="update">Update Assignment</button>
    <button name="delete">Delete Assignment</button>
</form>

<div class="list">
    <h3>All Assignments</h3>
    <?php
        $assignments = $conn->query("
            SELECT assignments.id, students.name AS student_name, courses.course_name, title, grade
            FROM assignments
            JOIN enrollments ON assignments.enrollment_id = enrollments.id
            JOIN students ON enrollments.student_id = students.id
            JOIN courses ON enrollments.course_id = courses.id
        ")->fetchAll();

        foreach ($assignments as $a) {
            echo $a['id'] . " - " . $a['student_name'] . " / " . $a['course_name'] . " - " . $a['title'] . " → Grade: " . $a['grade'] . "<br>";
        }
    ?>
</div>

<div class="back">
    <a href="index.php" class="back-btn">⬅ Back to Home</a>
</div>

</body>
</html>


<h3>All Assignments</h3>
<?php foreach ($assignments as $a): ?>
    <?= $a['id'] ?> - <?= $a['student_name'] ?> / <?= $a['course_name'] ?> - <?= $a['title'] ?> - Grade: <?= $a['grade'] ?><br>
<?php endforeach; ?>
