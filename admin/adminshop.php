<?php
session_start();
require_once __DIR__ . '/../myadd.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../home.php");
    exit();
}

$categories = mysqli_query($connect, "SELECT * FROM categories");
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<?php include "../navbar.php"; ?>

<div class="container my-5" style="max-width: 850px;">

    <div class="mb-4 text-center">
        <h2 class="fw-bold">เพิ่มร้านอาหาร</h2>
        <p class="text-muted">กรอกข้อมูลร้านอาหารให้ครบถ้วน</p>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-4">

            <form action="saveshop.php" method="post" enctype="multipart/form-data">

                <!-- ชื่อร้าน -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">ชื่อร้านอาหาร</label>
                    <input type="text" name="shop_name" class="form-control form-control-lg" required>
                </div>

                <!-- ที่อยู่ -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">ที่อยู่ร้าน</label>
                    <textarea name="address" class="form-control" rows="2" required></textarea>
                </div>

                <!-- Google Map -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">ลิงก์ Google Map</label>
                    <input type="url" name="map_link" class="form-control"
                           placeholder="https://maps.google.com/..." required>
                </div>

                <!-- หมวดหมู่ -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">หมวดหมู่อาหาร</label>
                    <select name="category_id" class="form-select" required>
                        <option value="">-- เลือกหมวดหมู่ --</option>
                        <?php while ($c = mysqli_fetch_assoc($categories)) { ?>
                            <option value="<?= $c['id'] ?>">
                                <?= htmlspecialchars($c['category_name']) ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <!-- รายละเอียด -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">รายละเอียดร้าน</label>
                    <textarea name="description" class="form-control" rows="4"
                              placeholder="อธิบายจุดเด่น บรรยากาศ หรือเมนูแนะนำ"></textarea>
                </div>

                <!-- รูปหน้าปก -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">รูปหน้าปกร้าน</label>
                    <input type="file" name="image" class="form-control" accept="image/*" id="coverInput">
                    <div class="form-text text-muted">แนะนำขนาด 1200x600 px</div>
                    <!-- Preview รูปปก -->
                    <img id="coverPreview" src="#" class="mt-2 rounded d-none"
                         style="height:150px; object-fit:cover; width:100%;">
                </div>

                <!-- =============== รูปเพิ่มเติม (ใหม่) =============== -->
                <div class="mb-4">
                    <label class="form-label fw-semibold">รูปภาพเพิ่มเติม (เลือกได้หลายรูป)</label>
                    <input type="file" name="extra_images[]" class="form-control"
                           accept="image/*" multiple id="extraInput">
                    <div class="form-text text-muted">เลือกได้หลายรูปพร้อมกัน</div>

                    <!-- Preview รูปเพิ่มเติม -->
                    <div id="extraPreview" class="d-flex flex-wrap gap-2 mt-2"></div>
                </div>

                <!-- ปุ่ม -->
                <div class="d-flex justify-content-between">
                    <a href="dashboard.php" class="btn btn-outline-secondary">⬅ กลับ</a>
                    <button class="btn btn-success px-4">💾 บันทึกร้านอาหาร</button>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
// Preview รูปปก
document.getElementById('coverInput').addEventListener('change', function () {
    const preview = document.getElementById('coverPreview');
    if (this.files && this.files[0]) {
        preview.src = URL.createObjectURL(this.files[0]);
        preview.classList.remove('d-none');
    }
});

// Preview รูปเพิ่มเติม
document.getElementById('extraInput').addEventListener('change', function () {
    const container = document.getElementById('extraPreview');
    container.innerHTML = '';
    Array.from(this.files).forEach(file => {
        const img = document.createElement('img');
        img.src = URL.createObjectURL(file);
        img.className = 'rounded';
        img.style = 'height:90px; width:90px; object-fit:cover;';
        container.appendChild(img);
    });
});
</script>