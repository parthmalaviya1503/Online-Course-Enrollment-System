<?php
include 'db.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (name, email, contact, password) VALUES (?, ?, ?, ?)");
    $stmt->execute([$name, $email, $contact, $password]);
    header("Location: index.php");
}
?>
<form method="POST">
    Name: <input type="text" name="name" required><br>
    Email: <input type="email" name="email" required><br>
    Contact: <input type="text" name="contact" required><br>
    Password: <input type="password" name="password" required><br>
    <button type="submit">Submit</button>
</form>
<a href="index.php">Back</a>
