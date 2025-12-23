<?php require 'db_connect.php'; ?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <title>ตรวจสอบสถานะ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Sarabun', sans-serif;
            background: #f8f9fa;
        }
    </style>
</head>

<body>
    <div class="container mt-5 text-center">
        <h3>🔍 ตรวจสอบสถานะการสมัคร</h3>
        <form method="GET" action="" class="mt-4" style="max-width: 500px; margin: auto;">
            <div class="input-group">
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
                    echo "<div class='alert alert-success mt-3' style='max-width: 500px; margin: 20px auto;'>";
                    echo "<h5>คุณ " . $row['ชื่อจริง'] . "</h5>";
                    echo "<p>รายการ: " . $row['ชื่อรายการ'] . "</p>";
                    echo "<p>สถานะ: <strong>" . $row['สถานะ'] . "</strong></p>";
                    echo "</div>";
                }
            } else {
                echo "<div class='alert alert-danger mt-3' style='max-width: 500px; margin: 20px auto;'>ไม่พบข้อมูล</div>";
            }
        }
        ?>
        <a href="index.php" class="btn btn-link mt-3">กลับหน้าหลัก</a>
    </div>
</body>

</html>