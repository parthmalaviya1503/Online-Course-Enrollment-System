<?php
include 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Create student
    if (isset($_POST['add'])) {
        $stmt = $conn->prepare("INSERT INTO students (name, email) VALUES (?, ?)");
        $stmt->execute([$_POST['name'], $_POST['email']]);
    }

    // Update student
    if (isset($_POST['update'])) {
        $stmt = $conn->prepare("UPDATE students SET name = ?, email = ? WHERE id = ?");
        $stmt->execute([$_POST['name'], $_POST['email'], $_POST['id']]);
    }

    // Delete student
    if (isset($_POST['delete'])) {
        $stmt = $conn->prepare("DELETE FROM students WHERE id = ?");
        $stmt->execute([$_POST['id']]);
    }
}

// Fetch all students
$students = $conn->query("SELECT * FROM students")->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Students</title>
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

<h2>Manage Students</h2>

<form method="post">
    ID (for update/delete): <input type="text" name="id">
    Name: <input type="text" name="name" required>
    Email: <input type="email" name="email" required>
    <button name="add">Add Student</button>
    <button name="update">Update Student</button>
    <button name="delete">Delete Student</button>
</form>

<div class="list">
    <h3>All Students</h3>
    <?php
        $students = $conn->query("SELECT * FROM students")->fetchAll();
        foreach ($students as $student) {
            echo $student['id'] . " - " . $student['name'] . " - " . $student['email'] . "<br>";
        }
    ?>
</div>

<div class="back">
    <a href="index.php" class="back-btn">⬅ Back to Home</a>
</div>

</body>
</html>

<h3>All Students</h3>
<?php foreach ($students as $student): ?>
    <?= $student['id'] ?> - <?= $student['name'] ?> - <?= $student['email'] ?><br>
<?php endforeach; ?>
