<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "race_db";

// สร้างการเชื่อมต่อ
$conn = new mysqli($servername, $username, $password, $dbname);

// ตั้งค่าภาษาไทย
$conn->set_charset("utf8mb4");

// เช็คการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>