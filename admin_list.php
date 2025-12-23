<?php
require 'db_connect.php';
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body {
            font-family: 'Sarabun';
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
    </style>
</head>

<body>
    <?php include 'navbar.php'; ?>
    <div class="container mt-4 mb-5">
        <h4><i class="bi bi-people-fill"></i> รายชื่อผู้สมัครทั้งหมด</h4>
        <table class="table table-bordered table-hover mt-3">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>ชื่อ-นามสกุล</th>
                    <th>โรคประจำตัว</th>
                    <th>ระยะทาง</th>
                    <th>สถานะ</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM `การลงทะเบียน` 
                        JOIN `นักวิ่ง` ON `การลงทะเบียน`.`รหัสนักวิ่ง` = `นักวิ่ง`.`รหัสนักวิ่ง`
                        JOIN `ประเภทการแข่งขัน` ON `การลงทะเบียน`.`รหัสประเภท` = `ประเภทการแข่งขัน`.`รหัสประเภท`
                        ORDER BY `การลงทะเบียน`.`รหัสใบสมัคร` DESC";
                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()) {
                    $med = $row['โรคประจำตัว'];
                    $medDisplay = ($med == 'ไม่มี' || $med == '-') ? '-' : "<span class='text-danger fw-bold'>$med</span>";
                    echo "<tr>
                        <td>{$row['รหัสใบสมัคร']}</td>
                        <td>{$row['ชื่อจริง']} {$row['นามสกุล']}</td>
                        <td>$medDisplay</td>
                        <td>{$row['ชื่อรายการ']}</td>
                        <td>{$row['สถานะ']}</td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <?php include 'footer.php'; ?>