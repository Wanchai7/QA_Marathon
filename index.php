<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <title>Marathon 2025</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;600;800&display=swap');

        body {
            font-family: 'Sarabun', sans-serif;
        }

        .hero {
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('https://images.unsplash.com/photo-1552674605-5d2178b64978?q=80&w=2070');
            background-size: cover;
            background-position: center;
            height: 80vh;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="index.php">MARATHON 2025</a>
            <div class="ms-auto">
                <a class="btn btn-outline-light btn-sm" href="admin_list.php">ผู้ดูแลระบบ</a>
            </div>
        </div>
    </nav>

    <section class="hero">
        <div>
            <h1 class="display-1 fw-bold">MARATHON 2025</h1>
            <p class="fs-3">วิ่งเปลี่ยนชีวิต พิชิตเส้นชัย</p>
            <a href="register.html" class="btn btn-primary btn-lg px-5 py-3 rounded-pill fw-bold mt-3">สมัครวิ่งเลย!</a>
            <a href="check_status.php"
                class="btn btn-outline-light btn-lg px-5 py-3 rounded-pill mt-3 ms-2">เช็คสถานะ</a>
        </div>
    </section>
</body>

</html>