<?php require 'db_connect.php'; ?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <title>ตรวจสอบสถานะ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body {
            font-family: 'Sarabun', sans-serif;
            background: #f8f9fa;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
    </style>
</head>

<body>

    <?php include 'navbar.php'; ?>

    <div class="container mt-5 mb-5 flex-grow-1">
        <div class="card shadow-sm mx-auto" style="max-width: 600px;">
            <div class="card-body p-4">
                <h3 class="text-center mb-4">🔍 ตรวจสอบสถานะการสมัคร</h3>
                <form method="GET" action="">
                    <div class="input-group mb-3">
                        <input type="text" name="search" class="form-control" placeholder="กรอกเลขบัตรประชาชน" required>
                        <button class="btn btn-primary" type="submit">ค้นหา</button>
                    </div>
                </form>

                <?php
                if (isset($_GET['search'])) {
                    $search = $_GET['search'];
                    $sql = "SELECT * FROM `การลงทะเบียน` 
                        JOIN `นักวิ่ง` ON `การลงทะเบียน`.`รหัสนักวิ่ง` = `นักวิ่ง`.`รหัสนักวิ่ง`
                        JOIN `ประเภทการแข่งขัน` ON `การลงทะเบียน`.`รหัสประเภท` = `ประเภทการแข่งขัน`.`รหัสประเภท`
                        WHERE `นักวิ่ง`.`เลขบัตรประชาชน` = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("s", $search);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<div class='alert alert-success mt-3'>";
                            echo "<h5>คุณ " . $row['ชื่อจริง'] . " " . $row['นามสกุล'] . "</h5>";
                            echo "<p>รายการ: <strong>" . $row['ชื่อรายการ'] . "</strong></p>";
                            echo "<p>สถานะ: <span class='badge bg-warning text-dark'>" . $row['สถานะ'] . "</span></p>";
                            echo "</div>";
                        }
                    } else {
                        echo "<div class='alert alert-danger mt-3 text-center'>ไม่พบข้อมูลการสมัคร</div>";
                    }
                }
                ?>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>