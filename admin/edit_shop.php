<?php
session_start();
require '../myadd.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

$id = intval($_GET['id']);

$shop = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM shops WHERE id = $id"));
$categories = mysqli_query($connect, "SELECT * FROM categories");
$images = mysqli_query($connect, "SELECT * FROM shop_images WHERE shop_id = $id ORDER BY id ASC");
?>

<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<title>แก้ไขร้านอาหาร</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>

<?php include "../navbar.php"; ?>

<body class="bg-light">
<div class="container my-5">

<h3 class="fw-bold mb-4">✏️ แก้ไขร้านอาหาร</h3>

<form action="update_shop.php" method="post" enctype="multipart/form-data">
<input type="hidden" name="id" value="<?= $id ?>">

<div class="row g-4">

    <!-- ข้อมูลร้าน -->
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-body">

                <label class="form-label fw-semibold">ชื่อร้าน</label>
                <input type="text" name="shop_name" class="form-control mb-3"
                       value="<?= htmlspecialchars($shop['shop_name']) ?>" required>

                <label class="form-label fw-semibold">หมวดหมู่</label>
                <select name="category_id" class="form-select mb-3">
                    <?php while ($c = mysqli_fetch_assoc($categories)) { ?>
                        <option value="<?= $c['id'] ?>"
                            <?= $c['id'] == $shop['category_id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($c['category_name']) ?>
                        </option>
                    <?php } ?>
                </select>

                <label class="form-label fw-semibold">ที่อยู่</label>
                <textarea name="address" class="form-control mb-3"><?= htmlspecialchars($shop['address']) ?></textarea>

                <label class="form-label fw-semibold">Google Map</label>
                <input type="url" name="map_link" class="form-control mb-3"
                       value="<?= htmlspecialchars($shop['map_link']) ?>">

                <label class="form-label fw-semibold">รายละเอียด</label>
                <textarea name="description" rows="4"
                          class="form-control"><?= htmlspecialchars($shop['description']) ?></textarea>

            </div>
        </div>
    </div>

    <!-- รูปภาพ -->
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-body">

                <!-- รูปปก -->
                <h6 class="fw-bold mb-2">🖼️ รูปหน้าปก</h6>
                <img src="../uploads/<?= htmlspecialchars($shop['image'] ?: 'noimg.png') ?>"
                     class="img-fluid rounded mb-2"
                     style="height:120px; width:100%; object-fit:cover;"
                     id="coverPreview">
                <label class="form-label">เปลี่ยนรูปปก</label>
                <input type="file" name="image" class="form-control mb-4"
                       accept="image/*" id="coverInput">

                <hr>

                <!-- รูปเพิ่มเติมที่มีอยู่ -->
                <h6 class="fw-bold mb-2">📷 รูปภาพเพิ่มเติม</h6>

                <?php
                $img_count = mysqli_num_rows($images);
                if ($img_count == 0): ?>
                    <p class="text-muted small">ยังไม่มีรูปเพิ่มเติม</p>
                <?php else: ?>
                    <div class="row g-2 mb-3">
                    <?php while ($img = mysqli_fetch_assoc($images)): ?>
                        <div class="col-4 text-center" id="img-<?= $img['id'] ?>">
                            <img src="../uploads/<?= htmlspecialchars($img['image']) ?>"
                                 class="img-fluid rounded mb-1"
                                 style="height:80px; width:100%; object-fit:cover;">
                            <!-- ลบรูปแบบ AJAX ไม่ต้อง reload หน้า -->
                            <button type="button"
                                    class="btn btn-sm btn-danger w-100"
                                    onclick="deleteImage(<?= $img['id'] ?>, <?= $id ?>)">
                                🗑️ ลบ
                            </button>
                        </div>
                    <?php endwhile; ?>
                    </div>
                <?php endif; ?>

                <!-- เพิ่มรูปใหม่ -->
                <label class="form-label fw-semibold">เพิ่มรูปใหม่ (เลือกได้หลายรูป)</label>
                <input type="file" name="images[]" class="form-control"
                       accept="image/*" multiple id="extraInput">

                <!-- Preview รูปที่จะเพิ่ม -->
                <div id="extraPreview" class="d-flex flex-wrap gap-2 mt-2"></div>

            </div>
        </div>
    </div>

</div>

<div class="mt-4 d-flex gap-2">
    <a href="shopmanage.php" class="btn btn btn-primary">กลับ</a>
    <button class="btn btn-success flex-fill">💾 บันทึกการแก้ไข</button>
</div>

</form>
</div>

<script>
// Preview รูปปกใหม่
document.getElementById('coverInput').addEventListener('change', function () {
    if (this.files && this.files[0]) {
        document.getElementById('coverPreview').src = URL.createObjectURL(this.files[0]);
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
        img.style = 'height:80px; width:80px; object-fit:cover;';
        container.appendChild(img);
    });
});

// ลบรูปแบบ AJAX (ไม่ต้อง reload หน้า)
function deleteImage(imgId, shopId) {
    if (!confirm('ลบรูปนี้?')) return;

    fetch('delete_image.php?id=' + imgId + '&shop_id=' + shopId + '&ajax=1')
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                const el = document.getElementById('img-' + imgId);
                if (el) el.remove();
            } else {
                alert('ลบไม่สำเร็จ: ' + (data.message || ''));
            }
        })
        .catch(() => alert('เกิดข้อผิดพลาด'));
}
</script>

</body>
</html>