<?php
include 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['enroll'])) {
        $stmt = $conn->prepare("INSERT INTO enrollments (student_id, course_id, enrolled_on) VALUES (?, ?, ?)");
        $stmt->execute([$_POST['student_id'], $_POST['course_id'], $_POST['enrolled_on']]);
    }

    if (isset($_POST['update'])) {
        $stmt = $conn->prepare("UPDATE enrollments SET student_id = ?, course_id = ?, enrolled_on = ? WHERE id = ?");
        $stmt->execute([$_POST['student_id'], $_POST['course_id'], $_POST['enrolled_on'], $_POST['id']]);
    }

    if (isset($_POST['delete'])) {
        $stmt = $conn->prepare("DELETE FROM enrollments WHERE id = ?");
        $stmt->execute([$_POST['id']]);
    }
}

$enrollments = $conn->query("
    SELECT enrollments.id, students.name AS student_name, courses.course_name, enrolled_on 
    FROM enrollments 
    JOIN students ON enrollments.student_id = students.id 
    JOIN courses ON enrollments.course_id = courses.id
")->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Enrollments</title>
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

<h2>Manage Enrollments</h2>

<form method="post">
    ID (for update/delete): <input type="text" name="id">
    Student ID: <input type="number" name="student_id" required>
    Course ID: <input type="number" name="course_id" required>
    Enrolled On: <input type="date" name="enrolled_on" required>
    <button name="enroll">Enroll Student</button>
    <button name="update">Update Enrollment</button>
    <button name="delete">Remove Enrollment</button>
</form>

<div class="list">
    <h3>All Enrollments</h3>
    <?php
        $enrollments = $conn->query("
            SELECT enrollments.id, students.name AS student_name, courses.course_name, enrolled_on 
            FROM enrollments 
            JOIN students ON enrollments.student_id = students.id 
            JOIN courses ON enrollments.course_id = courses.id
        ")->fetchAll();

        foreach ($enrollments as $e) {
            echo $e['id'] . " - " . $e['student_name'] . " → " . $e['course_name'] . " on " . $e['enrolled_on'] . "<br>";
        }
    ?>
</div>

<div class="back">
    <a href="index.php" class="back-btn">⬅ Back to Home</a>
</div>

</body>
</html>


<h3>All Enrollments</h3>
<?php foreach ($enrollments as $e): ?>
    <?= $e['id'] ?> - <?= $e['student_name'] ?> enrolled in <?= $e['course_name'] ?> on <?= $e['enrolled_on'] ?><br>
<?php endforeach; ?>
