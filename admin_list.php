<?php require 'db_connect.php'; ?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Sarabun', sans-serif;
        }
    </style>
</head>

<body>
    <div class="container mt-4">
        <h4>รายชื่อผู้สมัครทั้งหมด</h4>
        <a href="index.php" class="btn btn-secondary btn-sm mb-3">กลับหน้าหลัก</a>

        <table class="table table-bordered table-hover">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>วันที่สมัคร</th>
                    <th>ชื่อ-นามสกุล</th>
                    <th>โรคประจำตัว</th>
                    <th>ประเภทวิ่ง</th>
                    <th>สถานะ</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // แก้ SQL ให้ถูกต้อง
                $sql = "SELECT * FROM `การลงทะเบียน` 
                        JOIN `นักวิ่ง` ON `การลงทะเบียน`.`รหัสนักวิ่ง` = `นักวิ่ง`.`รหัสนักวิ่ง`
                        JOIN `ประเภทการแข่งขัน` ON `การลงทะเบียน`.`รหัสประเภท` = `ประเภทการแข่งขัน`.`รหัสประเภท`
                        ORDER BY `การลงทะเบียน`.`รหัสใบสมัคร` DESC";

                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['รหัสใบสมัคร'] . "</td>";
                        echo "<td>" . $row['วันที่สมัคร'] . "</td>";
                        echo "<td>" . $row['ชื่อจริง'] . " " . $row['นามสกุล'] . "</td>";

                        // แสดงโรคประจำตัว (ไฮไลท์สีแดงถ้ามี)
                        $med = $row['โรคประจำตัว'];
                        if ($med == '-' || $med == 'ไม่มี' || $med == '') {
                            echo "<td>-</td>";
                        } else {
                            echo "<td><span class='text-danger fw-bold'>" . $med . "</span></td>";
                        }

                        echo "<td>" . $row['ชื่อรายการ'] . "</td>";
                        echo "<td>" . $row['สถานะ'] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6' class='text-center'>ไม่มีข้อมูล</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>