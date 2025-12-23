<?php
require 'db_connect.php';
$msg = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = ($username == 'admin') ? 'admin' : 'user';

    try {
        $sql = "INSERT INTO users (username, password, role) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $username, $password, $role);
        $stmt->execute();
        header("Location: login.php?registered=1");
    } catch (Exception $e) {
        $msg = "Username นี้มีคนใช้แล้ว";
    }
}
?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <title>สมัครสมาชิก</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f4f6f9;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
    </style>
</head>

<body>
    <?php include 'navbar.php'; ?>
    <div class="container mt-5 mb-5">
        <div class="card mx-auto shadow-sm" style="max-width: 400px;">
            <div class="card-body p-4">
                <h3 class="text-center mb-4">สมัครสมาชิก</h3>
                <?php if ($msg)
                    echo "<div class='alert alert-danger'>$msg</div>"; ?>
                <form method="POST">
                    <div class="mb-3"><label>Username</label><input type="text" name="username" class="form-control"
                            required></div>
                    <div class="mb-3"><label>Password</label><input type="password" name="password" class="form-control"
                            required></div>
                    <button type="submit" class="btn btn-primary w-100">ยืนยัน</button>
                </form>
            </div>
        </div>
    </div>
    <?php include 'footer.php'; ?>