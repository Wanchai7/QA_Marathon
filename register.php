<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php?error=please_login");
    exit();
}
?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ลงทะเบียนวิ่ง</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;600;800&display=swap');

        body {
            font-family: 'Sarabun', sans-serif;
            background-color: #f4f6f9;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .hero-header {
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('https://images.unsplash.com/photo-1533560906234-54cb6264e97e?q=80&w=2070');
            background-size: cover;
            background-position: center;
            height: 400px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
        }

        .main-form-container {
            max-width: 900px;
            margin: -60px auto 50px;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            padding: 50px;
            border-radius: 20px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.2);
            position: relative;
            z-index: 10;
        }

        .section-title {
            border-bottom: 2px solid #0d6efd;
            padding-bottom: 15px;
            margin-bottom: 30px;
            margin-top: 20px;
            color: #0d6efd;
            font-weight: 700;
        }

        .total-price-sticky {
            background: linear-gradient(135deg, #0d6efd, #0043a8);
            color: white;
            padding: 20px;
            border-radius: 15px;
            text-align: center;
        }
    </style>
</head>

<body>

    <?php include 'navbar.php'; ?>

    <header class="hero-header">
        <div class="container">
            <h1>CITY MARATHON 2025</h1>
            <p class="fs-4"><i class="bi bi-calendar2-check"></i> 15 ธันวาคม 2568</p>
        </div>
    </header>

    <div class="container">
        <div class="main-form-container">
            <h2 class="text-center mb-4 fw-bold text-dark">📝 แบบฟอร์มลงทะเบียน</h2>
            <form id="regisForm" action="save_registration.php" method="POST">
                <h4 class="section-title">1. ข้อมูลนักวิ่ง</h4>
                <div class="row g-3">
                    <div class="col-md-6"><label class="form-label">ชื่อจริง <span
                                class="text-danger">*</span></label><input type="text" class="form-control"
                            name="ชื่อจริง" required></div>
                    <div class="col-md-6"><label class="form-label">นามสกุล <span
                                class="text-danger">*</span></label><input type="text" class="form-control"
                            name="นามสกุล" required></div>
                    <div class="col-md-6"><label class="form-label">เลขบัตรประชาชน <span
                                class="text-danger">*</span></label><input type="text" class="form-control"
                            name="เลขบัตรประชาชน" maxlength="13" required></div>
                    <div class="col-md-6">
                        <label class="form-label">วันเกิด <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="birthDate" name="วันเกิด" onchange="checkAge()"
                            required>
                        <small id="ageDisplay" class="text-primary fw-bold mt-1 d-block"></small>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">เพศ <span class="text-danger">*</span></label>
                        <select class="form-select" name="เพศ" required>
                            <option value="ชาย">ชาย</option>
                            <option value="หญิง">หญิง</option>
                            <option value="อื่นๆ">อื่นๆ</option>
                        </select>
                    </div>
                    <div class="col-md-6"><label class="form-label">เบอร์โทรศัพท์</label><input type="tel"
                            class="form-control" name="เบอร์โทรศัพท์"></div>
                    <div class="col-md-12"><label class="form-label">อีเมล <span
                                class="text-danger">*</span></label><input type="email" class="form-control"
                            name="อีเมล" required></div>

                    <div class="col-md-12 mt-4">
                        <div class="card bg-light border-0">
                            <div class="card-body">
                                <label class="form-label fw-bold text-danger">ข้อมูลทางการแพทย์ (โรคประจำตัว)</label>
                                <div class="d-flex gap-4 mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="med_option" id="medNo"
                                            value="no" checked onchange="toggleMedInput()">
                                        <label class="form-check-label" for="medNo">ไม่มี</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="med_option" id="medYes"
                                            value="yes" onchange="toggleMedInput()">
                                        <label class="form-check-label" for="medYes">มีโรคประจำตัว</label>
                                    </div>
                                </div>
                                <input type="text" class="form-control" id="medInput" name="โรคประจำตัว" value="ไม่มี"
                                    readonly placeholder="โปรดระบุโรคประจำตัว...">
                            </div>
                        </div>
                    </div>
                </div>

                <h4 class="section-title">2. เลือกระยะทาง</h4>
                <div class="row g-4 align-items-center">
                    <div class="col-md-8">
                        <label class="form-label">ระยะทางวิ่ง <span class="text-danger">*</span></label>
                        <select class="form-select form-select-lg" id="raceCategory" name="รหัสประเภท"
                            onchange="calculatePrice()" required>
                            <option value="" data-price="0" selected disabled>-- กรุณาเลือก --</option>
                            <option value="1" data-price="1200">Full Marathon (42 km) - 1,200 บ.</option>
                            <option value="2" data-price="900">Half Marathon (21 km) - 900 บ.</option>
                            <option value="3" data-price="600">Mini Marathon (10.5 km) - 600 บ.</option>
                            <option value="4" data-price="400">Fun Run (5 km) - 400 บ.</option>
                        </select>
                        <label class="form-label mt-3">ประเภทผู้สมัคร</label>
                        <select class="form-select" id="runnerType" name="ประเภทนักวิ่ง" onchange="calculatePrice()">
                            <option value="บุคคลทั่วไป" data-discount="0">บุคคลทั่วไป</option>
                            <option value="ผู้สูงอายุ" data-discount="200" id="optionSenior">ผู้สูงอายุ 60+ (ลด 200 บ.)
                            </option>
                            <option value="ผู้พิการ" data-discount="500">ผู้พิการ (ลด 500 บ.)</option>
                        </select>
                        <small id="ageWarning" class="text-danger" style="display:none;">* อายุไม่ถึง 60 ปี
                            ไม่สามารถเลือกเรทผู้สูงอายุได้</small>
                    </div>
                    <div class="col-md-4"><label class="form-label">ไซส์เสื้อ</label><select class="form-select"
                            name="ไซส์เสื้อ">
                            <option value="S">S</option>
                            <option value="M">M</option>
                            <option value="L">L</option>
                            <option value="XL">XL</option>
                        </select></div>
                </div>

                <h4 class="section-title">3. การจัดส่ง & ชำระเงิน</h4>
                <div class="row">
                    <div class="col-md-7">
                        <div class="list-group">
                            <label class="list-group-item"><input class="form-check-input me-1" type="radio"
                                    name="รหัสขนส่ง" value="1" data-cost="0" onchange="syncShipping(this)" checked>
                                รับเองหน้างาน (ฟรี)</label>
                            <label class="list-group-item"><input class="form-check-input me-1" type="radio"
                                    name="รหัสขนส่ง" value="2" data-cost="60" onchange="syncShipping(this)"> EMS (+60
                                บาท)</label>
                            <select id="shippingOption" style="display:none;">
                                <option value="1" data-cost="0"></option>
                                <option value="2" data-cost="60"></option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="total-price-sticky mt-3 mt-md-0">
                            <span class="fs-5 opacity-75">ยอดสุทธิ</span>
                            <h1 class="display-4 fw-bold my-2"><span id="totalDisplay">0</span> <span
                                    class="fs-4">฿</span></h1>
                            <input type="hidden" id="totalAmount" name="ยอดรวม" value="0">
                            <button type="submit"
                                class="btn btn-light text-primary fw-bold w-100 mt-2 rounded-pill py-2 shadow-sm">ยืนยันการสมัคร</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        function syncShipping(radio) { document.getElementById('shippingOption').value = radio.value; calculatePrice(); }
        function toggleMedInput() {
            const isYes = document.getElementById('medYes').checked; const input = document.getElementById('medInput');
            if (isYes) { input.readOnly = false; input.value = ""; input.focus(); input.style.backgroundColor = "white"; }
            else { input.readOnly = true; input.value = "ไม่มี"; input.style.backgroundColor = "#e9ecef"; }
        }
        function checkAge() {
            const bd = document.getElementById('birthDate').value;
            if (bd) {
                const today = new Date(); const birthDate = new Date(bd);
                let age = today.getFullYear() - birthDate.getFullYear();
                const m = today.getMonth() - birthDate.getMonth();
                if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) age--;
                document.getElementById('ageDisplay').innerText = "อายุ: " + age + " ปี";
                const seniorOpt = document.getElementById('optionSenior');
                if (age < 60) {
                    seniorOpt.disabled = true;
                    if (document.getElementById('runnerType').value === 'ผู้สูงอายุ') {
                        document.getElementById('runnerType').value = 'บุคคลทั่วไป';
                        document.getElementById('ageWarning').style.display = 'block';
                        calculatePrice();
                    }
                } else { seniorOpt.disabled = false; document.getElementById('ageWarning').style.display = 'none'; }
            }
        }
        function calculatePrice() {
            const raceSelect = document.getElementById('raceCategory');
            const basePrice = parseFloat(raceSelect.options[raceSelect.selectedIndex].getAttribute('data-price')) || 0;
            const typeSelect = document.getElementById('runnerType');
            const discount = parseFloat(typeSelect.options[typeSelect.selectedIndex].getAttribute('data-discount')) || 0;
            const shipSelect = document.getElementById('shippingOption');
            const shippingCost = parseFloat(shipSelect.options[shipSelect.selectedIndex].getAttribute('data-cost')) || 0;
            let total = (basePrice - discount) + shippingCost;
            if (total < 0) total = 0;
            document.getElementById('totalDisplay').innerText = total.toLocaleString();
            document.getElementById('totalAmount').value = total;
        }
    </script>
    <?php include 'footer.php'; ?>