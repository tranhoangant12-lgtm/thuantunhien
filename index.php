<?php
require_once __DIR__ . '/connect/config.php';

function laySanPhamNoiBat($conn)
{
    $sql = "SELECT * FROM san_pham ORDER BY id LIMIT 3";
    $result = $conn->query($sql);

    return $result ? $result->fetchAll(PDO::FETCH_ASSOC) : [];
}

$laySanPhamNoiBat = isset($conn) ? laySanPhamNoiBat($conn) : [];

?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang chủ - Thuần Tự Nhiên</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>

<body>
    <header>
        <div class="dau"><a class="logo" href="index.php">THUẦN TỰ NHIÊN</a>
            <form class="tim" action="san-pham.php"><input name="tim" placeholder="Tìm tên nông sản...">
               <a href="gio-hang.html" id="gio-hang" class="nut"> Giỏ hàng (<span id="so-luong-gio">0</span>)</a>
            </form>
        </div>
        <nav>
            <a href="index.php" class="chon">Trang chủ
            </a>
            <a href="gioi-thieu.html" class="">Giới thiệu</a>
            <a href="san-pham.php" class="">Sản phẩm
            </a>
            <a href="lien-he.html" class="">Liên hệ</a>
        </nav>
    </header>
    <main>
        <h1>Về Thuần Tự Nhiên</h1>


        <section class="hang">
            <div class="banner">
                <img src="images/anh1.png" class="banner-img active">
                <img src="images/anh2.png" class="banner-img">
                <img src="images/anh3.png" class="banner-img">

                <button class="arrow prev" onclick="chuyenAnh(-1)">
                    <i class="fa-solid fa-chevron-left"></i>
                </button>

                <button class="arrow next" onclick="chuyenAnh(1)">
                    <i class="fa-solid fa-chevron-right"></i>
                </button>
            </div>

            <div>
                <h2>Câu chuyện thương hiệu</h2>
                <p>[Giới thiệu cửa hàng, mục tiêu phục vụ và thông tin hoạt
                    động đã được xác minh.]</p>

                <div class="nhom-nut">
                    <a class="nut" href="san-pham.php">Xem sản phẩm</a>
                    <a class="nut nut-phu" href="lien-he.html">Liên hệ</a>
                </div>
            </div>
        </section>

        <section>
            <h2>Danh Mục Sản Phẩm</h2>
            <div class="danh-muc">
                <a href="san-pham.php?danh_muc=rau-cu">Rau Củ</a>
                <a href="san-pham.php?danh_muc=trai-cay">Trái Cây</a>
                <a href="san-pham.php?danh_muc=gao">Gạo</a>
                <a href="san-pham.php?danh_muc=khac">Nông Sản Khác</a>
            </div>
        </section>
         <section>
            <h2>Sản Phẩm Nổi Bật</h2>
            <div class="san-pham">
                <?php foreach ($laySanPhamNoiBat as $row):
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
        </section>
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