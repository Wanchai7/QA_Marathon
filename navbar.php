<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="index.php">
            <i class="bi bi-person-running"></i> CITY MARATHON
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item"><a class="nav-link" href="index.php">หน้าแรก</a></li>
                <li class="nav-item"><a class="nav-link" href="register.php">สมัครวิ่ง</a></li>
                <li class="nav-item"><a class="nav-link" href="check_status.php">เช็คสถานะ</a></li>

                <?php if (isset($_SESSION['user_id'])): ?>
                    <?php if ($_SESSION['role'] == 'admin'): ?>
                        <li class="nav-item">
                            <a class="nav-link text-warning fw-bold" href="admin_list.php">
                                <i class="bi bi-speedometer2"></i> แผงควบคุม (Admin)
                            </a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item"><a class="nav-link disabled" href="#">สวัสดี,
                                <?php echo htmlspecialchars($_SESSION['username']); ?></a></li>
                    <?php endif; ?>

                    <li class="nav-item ms-2">
                        <a class="btn btn-outline-danger btn-sm rounded-pill px-3" href="logout.php">ออกจากระบบ</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item ms-2">
                        <a class="btn btn-outline-light btn-sm rounded-pill px-3" href="login.php">เข้าสู่ระบบ</a>
                    </li>
                    <li class="nav-item ms-2">
                        <a class="btn btn-primary btn-sm rounded-pill px-3" href="register_member.php">สมัครสมาชิกเว็บ</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
<div style="height: 70px;"></div>