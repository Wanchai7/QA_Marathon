<?php
require 'db_connect.php'; // เรียกใช้ไฟล์เชื่อมต่อ

// ตรวจสอบว่ามีการกดปุ่ม Submit มาหรือไม่
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // 1. รับค่าจากฟอร์ม HTML (ตามชื่อ name="..." ใน input)
    $firstName = $_POST['ชื่อจริง'];
    $lastName = $_POST['นามสกุล'];
    $citizenId = $_POST['เลขบัตรประชาชน'];
    $birthDate = $_POST['วันเกิด'];
    $gender = $_POST['เพศ'];
    $phone = $_POST['เบอร์โทรศัพท์'];
    $email = "test@example.com"; // ในฟอร์มไม่มีช่องอีเมล ขอสมมติไว้ก่อน หรือต้องไปเพิ่มใน HTML

    $catId = $_POST['รหัสประเภท'];
    // หมายเหตุ: ใน HTML dropdown value ต้องตรงกับ ID ใน database
    // แต่เพื่อความง่าย ผมจะสมมติค่า Price ID และ Shipping ID ให้ทำงานได้ไปก่อน
    $priceId = 1; // สมมติเลือกราคาปกติ
    $shippingId = $_POST['รหัสขนส่ง'];
    $shirtSize = $_POST['ไซส์เสื้อ'];

    // เริ่มการทำงานแบบ Transaction (เพื่อให้บันทึก 2 ตารางพร้อมกัน ถ้าพลาดให้ยกเลิกหมด)
    $conn->begin_transaction();

    try {
        // --- STEP A: บันทึกลงตาราง 'นักวิ่ง' ---
        $sql_runner = "INSERT INTO `นักวิ่ง` 
                       (`ชื่อจริง`, `นามสกุล`, `เลขบัตรประชาชน`, `วันเกิด`, `เพศ`, `เบอร์โทรศัพท์`, `อีเมล`) 
                       VALUES (?, ?, ?, ?, ?, ?, ?)";

        $stmt1 = $conn->prepare($sql_runner);
        $stmt1->bind_param("sssssss", $firstName, $lastName, $citizenId, $birthDate, $gender, $phone, $email);
        $stmt1->execute();

        // หา ID ของนักวิ่งที่เพิ่งเพิ่มเข้าไป
        $newRunnerId = $conn->insert_id;

        // --- STEP B: บันทึกลงตาราง 'การลงทะเบียน' ---
        $sql_regis = "INSERT INTO `การลงทะเบียน` 
                      (`รหัสนักวิ่ง`, `รหัสประเภท`, `รหัสราคา`, `รหัสขนส่ง`, `ไซส์เสื้อ`, `สถานะ`) 
                      VALUES (?, ?, ?, ?, ?, 'รอชำระเงิน')";

        $stmt2 = $conn->prepare($sql_regis);
        $stmt2->bind_param("iiiis", $newRunnerId, $catId, $priceId, $shippingId, $shirtSize);
        $stmt2->execute();

        // ยืนยันการบันทึกข้อมูล
        $conn->commit();

        echo "<div style='text-align:center; margin-top:50px;'>";
        echo "<h1>✅ ลงทะเบียนสำเร็จ!</h1>";
        echo "<p>รหัสนักวิ่งของคุณคือ: <strong>" . $newRunnerId . "</strong></p>";
        echo "<a href='register.html'>กลับหน้าหลัก</a>";
        echo "</div>";

    } catch (Exception $e) {
        // ถ้ามี error ให้ยกเลิกการบันทึกทั้งหมด
        $conn->rollback();
        echo "ผิดพลาด: " . $e->getMessage();
    }

    $stmt1->close();
    $stmt2->close();
}

$conn->close();
?>