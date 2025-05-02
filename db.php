<?php
    $host = "localhost";
    $username = "root";
    $password = "";
    $dbname = "course_enrollment";

    try {
        $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    } catch (PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }
?>