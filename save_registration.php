<?php
require 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $firstName = $_POST['ชื่อจริง'];
    $lastName = $_POST['นามสกุล'];
    $citizenId = $_POST['เลขบัตรประชาชน'];
    $birthDate = $_POST['วันเกิด'];
    $gender = $_POST['เพศ'];
    $phone = $_POST['เบอร์โทรศัพท์'];
    $email = $_POST['อีเมล'];
    $medical = $_POST['โรคประจำตัว']; // รับค่าใหม่

    $catId = $_POST['รหัสประเภท'];
    $runnerType = $_POST['ประเภทนักวิ่ง'];

    // Logic หาราคา (แบบย่อ)
    $priceId = 1;
    if ($runnerType == 'ผู้สูงอายุ')
        $priceId = 2;
    if ($runnerType == 'ผู้พิการ')
        $priceId = 3; // สมมติถ้ามี

    $shippingId = $_POST['รหัสขนส่ง'];
    $shirtSize = $_POST['ไซส์เสื้อ'];

    $conn->begin_transaction();

    try {
        // STEP A: บันทึกนักวิ่ง (เพิ่มโรคประจำตัว)
        $sql_runner = "INSERT INTO `นักวิ่ง` 
                       (`ชื่อจริง`, `นามสกุล`, `เลขบัตรประชาชน`, `วันเกิด`, `เพศ`, `เบอร์โทรศัพท์`, `อีเมล`, `โรคประจำตัว`) 
                       VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt1 = $conn->prepare($sql_runner);
        $stmt1->bind_param("ssssssss", $firstName, $lastName, $citizenId, $birthDate, $gender, $phone, $email, $medical);
        $stmt1->execute();
        $newRunnerId = $conn->insert_id;

        // STEP B: บันทึกใบสมัคร
        $sql_regis = "INSERT INTO `การลงทะเบียน` 
                      (`รหัสนักวิ่ง`, `รหัสประเภท`, `รหัสราคา`, `รหัสขนส่ง`, `ไซส์เสื้อ`, `สถานะ`) 
                      VALUES (?, ?, ?, ?, ?, 'รอชำระเงิน')";

        $stmt2 = $conn->prepare($sql_regis);
        $stmt2->bind_param("iiiis", $newRunnerId, $catId, $priceId, $shippingId, $shirtSize);
        $stmt2->execute();

        $conn->commit();

        echo "<div style='text-align:center; margin-top:50px; font-family: sans-serif;'>";
        echo "<h1 style='color:green;'>✅ ลงทะเบียนสำเร็จ!</h1>";
        echo "<p>โรคประจำตัว: " . htmlspecialchars($medical) . "</p>";
        echo "<a href='index.php'>กลับหน้าหลัก</a>";
        echo "</div>";

    } catch (Exception $e) {
        $conn->rollback();
        echo "ผิดพลาด: " . $e->getMessage();
    }
}
$conn->close();
?>