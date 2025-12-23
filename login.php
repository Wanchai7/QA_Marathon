<?php
session_start();
require 'db_connect.php';
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            if ($user['role'] == 'admin') {
                header("Location: admin_list.php");
            } else {
                header("Location: index.php");
            }
            exit();
        } else {
            $error = "รหัสผ่านไม่ถูกต้อง";
        }
    } else {
        $error = "ไม่พบชื่อผู้ใช้นี้";
    }
}
?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <title>เข้าสู่ระบบ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f4f6f9;
            font-family: sans-serif;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
    </style>
</head>

<body>
    <?php include 'navbar.php'; ?>

    <div class="container mt-5 mb-5">
        <div class="card mx-auto shadow" style="max-width: 400px; border-radius: 15px;">
            <div class="card-body p-4">
                <h3 class="text-center fw-bold mb-4 text-primary">เข้าสู่ระบบ</h3>

                <?php
                if (isset($_GET['error']) && $_GET['error'] == 'please_login') {
                    echo '<div class="alert alert-warning text-center" role="alert">
                            <i class="bi bi-lock-fill"></i> กรุณาเข้าสู่ระบบก่อนทำการสมัครวิ่ง
                          </div>';
                }
                ?>

                <?php if (isset($_GET['registered']))
                    echo "<div class='alert alert-success'>สมัครสมาชิกสำเร็จ! กรุณาล็อคอิน</div>"; ?>
                <?php if ($error)
                    echo "<div class='alert alert-danger'>$error</div>"; ?>

                <form method="POST">
                    <div class="mb-3">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 py-2">Login</button>
                </form>
                <div class="text-center mt-3">
                    <a href="register_member.php">ยังไม่มีบัญชี? สมัครสมาชิก</a>
                </div>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>