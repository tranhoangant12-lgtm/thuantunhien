<?php
// Kết nối cơ sở dữ liệu
require_once __DIR__ . '/connect/config.php';
function laySanPhamNoiBat($conn)
{
    $sql = "SELECT * FROM san_pham LIMIT 10";
    $result = $conn->query($sql);

    return $result ? $result->fetchAll(PDO::FETCH_ASSOC) : [];
}
function laySanPhamTheoDanhMuc($conn, $danhMuc)
{
    $sql = "SELECT * FROM san_pham WHERE danh_muc = :danhMuc ORDER BY id LIMIT 10";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':danhMuc', $danhMuc, PDO::PARAM_STR);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$danhMuc = $_GET['danh_muc'] ?? '';
$sanPham = [];

if (isset($conn)) {
    if (is_string($danhMuc) && $danhMuc !== '') {
        $sanPham = laySanPhamTheoDanhMuc($conn, $danhMuc);
    } else {
        $sanPham = laySanPhamNoiBat($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sản phẩm - Thuần Tự Nhiên</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header>
        <div class="dau"><a class="logo" href="index.php">THUẦN TỰ NHIÊN</a>
            <form class="tim" action="san-pham.php"><input name="tim" placeholder="Tìm tên nông sản...">
                <button type="submit">Tìm</button>
                <a href="gio-hang.html" id="gio-hang" class="nut"> Giỏ hàng (<span id="so-luong-gio">0</span>)</a>
            </form>
        </div>
        <nav>
            <a href="index.php" class="">Trang chủ</a>
            <a href="gioi-thieu.html" class="">Giới thiệu</a>
            <a href="san-pham.php" class="chon">Sản phẩm</a>
            <a href="lien-he.html" class="">Liên hệ</a>
        </nav>
    </header>
    <main>
        <h1>Sản phẩm</h1>
        <div class="hang">
            <aside class="cot-trai">
                <h3>Danh mục</h3>
                <a href="san-pham.php">Tất cả</a>
                <a href="san-pham.php?danh_muc=rau-cu">Rau củ</a>
                <a href="san-pham.php?danh_muc=trai-cay">Trái cây</a>
                <a href="san-pham.php?danh_muc=gao">Gạo</a>
                <a href="san-pham.php?danh_muc=khac">Nông sản khác</a>
            </aside>
            <div>
                <form class="tim" action="san-pham.php">
                    <input name="tim" placeholder="Tên sản phẩm"> <button>Tìm</button>
                    <a href="san-pham.php" class="nut nut-phu">Xóa lọc</a>
                </form>
                <div class="san-pham">
                    <?php
                    foreach ($sanPham as $row):
                        $ten = htmlspecialchars($row['ten_san_pham'], ENT_QUOTES, 'UTF-8');
                        $gia = (float) $row['gia'];
                        $donVi = htmlspecialchars($row['don_vi'], ENT_QUOTES, 'UTF-8');
                        $hinhAnh = htmlspecialchars($row['hinh_anh'], ENT_QUOTES, 'UTF-8');
                    ?>
                        <article class="the">
                            <img class="anh" src="<?= $hinhAnh ?>" alt="<?= $ten ?>">
                            <h3><?= $ten ?></h3>
                            <p><?= number_format($gia, 0, ',', '.') ?>đ / <?= $donVi ?></p>
                            <button href="#">Xem chi tiết</button>
                            <button class="them-gio" type="button"> Thêm vào giỏ </button>
                        </article>
                    <?php endforeach; ?>
                </div>
            </div>
    </main>

</body>
<footer>
    <div class="footer-thong-tin">
        <h2>THUẦN TỰ NHIÊN</h2>
        <p>Thông tin cửa hàng đã được xác nhận</p>
    </div>

    <div class="footer-menu">
        <a href="gioi-thieu.html">Giới thiệu</a>
        <a href="chinh-sach.html">Chính Sách</a>
        <a href="lien-he.html">Liên Hệ</a>
        <span>Mạng xã hội</span>
    </div>
</footer>
<script src="js/script.js"></script>

</html>