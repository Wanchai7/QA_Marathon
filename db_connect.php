<?php
$servername = "localhost";
$username = "root"; // ปกติ XAMPP ใช้ root
$password = "";     // ปกติ XAMPP ไม่มีรหัสผ่าน
$dbname = "marathon"; // **แก้เป็นชื่อฐานข้อมูลที่คุณตั้ง**

// สร้างการเชื่อมต่อ
$conn = new mysqli($servername, $username, $password, $dbname);

// ตั้งค่าให้รองรับภาษาไทย
$conn->set_charset("utf8mb4");

// เช็คการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>