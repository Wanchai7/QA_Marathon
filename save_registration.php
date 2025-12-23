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
    $medical = $_POST['โรคประจำตัว'];

    $catId = $_POST['รหัสประเภท'];
    $runnerType = $_POST['ประเภทนักวิ่ง'];

    $priceId = 1;
    if ($runnerType == 'ผู้สูงอายุ')
        $priceId = 2;
    if ($runnerType == 'ผู้พิการ')
        $priceId = 3;

    $shippingId = isset($_POST['รหัสขนส่ง']) ? $_POST['รหัสขนส่ง'] : 1;
    $shirtSize = $_POST['ไซส์เสื้อ'];

    $conn->begin_transaction();
    try {
        $sql_runner = "INSERT INTO `นักวิ่ง` (`ชื่อจริง`, `นามสกุล`, `เลขบัตรประชาชน`, `วันเกิด`, `เพศ`, `เบอร์โทรศัพท์`, `อีเมล`, `โรคประจำตัว`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt1 = $conn->prepare($sql_runner);
        $stmt1->bind_param("ssssssss", $firstName, $lastName, $citizenId, $birthDate, $gender, $phone, $email, $medical);
        $stmt1->execute();
        $newRunnerId = $conn->insert_id;

        $sql_regis = "INSERT INTO `การลงทะเบียน` (`รหัสนักวิ่ง`, `รหัสประเภท`, `รหัสราคา`, `รหัสขนส่ง`, `ไซส์เสื้อ`, `สถานะ`) VALUES (?, ?, ?, ?, ?, 'รอชำระเงิน')";
        $stmt2 = $conn->prepare($sql_regis);
        $stmt2->bind_param("iiiis", $newRunnerId, $catId, $priceId, $shippingId, $shirtSize);
        $stmt2->execute();

        $conn->commit();
        echo "<script>alert('ลงทะเบียนสำเร็จ!'); window.location.href='index.php';</script>";
    } catch (Exception $e) {
        $conn->rollback();
        echo "Error: " . $e->getMessage();
    }
}
?>