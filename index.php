<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marathon 2025</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;600;800&display=swap');

        body {
            font-family: 'Sarabun', sans-serif;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
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
    <?php include 'navbar.php'; ?>
    <section class="hero">
        <div class="container">
            <h1 class="display-1 fw-bold">MARATHON 2025</h1>
            <p class="fs-3">วิ่งเปลี่ยนชีวิต พิชิตเส้นชัย</p>
            <a href="register.php" class="btn btn-primary btn-lg px-5 py-3 rounded-pill fw-bold mt-3">สมัครวิ่งเลย!</a>
            <a href="check_status.php"
                class="btn btn-outline-light btn-lg px-5 py-3 rounded-pill mt-3 ms-2">เช็คสถานะ</a>
        </div>
    </section>
    <?php include 'footer.php'; ?>