let viTri = 0; // 0 = anh1.png , 1 = anh2.png, 2 = anh3.png
let danhSachAnh = document.querySelectorAll(".banner-img");

function chuyenAnh(buoc) {
    danhSachAnh[viTri].classList.remove("active");

    viTri = viTri + buoc;

    if (viTri >= danhSachAnh.length) { // phải
        viTri = 0;
    }

    if (viTri < 0) { // trái
        viTri = danhSachAnh.length - 1;
    }

    danhSachAnh[viTri].classList.add("active");
}


/// giỏ hàng
function layGio() {
    let chu = localStorage.getItem("gio");
    if (chu === null) {
        return [];
    }
    return JSON.parse(chu);
}

// 
function luuGio(gio) {
    localStorage.setItem("gio", JSON.stringify(gio));
}

//sl trên nút Giỏ hàng
function hienSoLuong() {
    let soGio = document.getElementById("so-luong-gio");
    if (soGio !== null) {
        soGio.textContent = layGio().length;
    }
}

// Thêm 1 
function themVaoGio(the) {
    let ten = the.querySelector("h3").textContent;
    let anh = the.querySelector(".anh").getAttribute("src");
    let gia = Number(the.getAttribute("data-gia"));

    let gio = layGio();
    let daCo = false;

    for (let j = 0; j < gio.length; j++) {
        if (gio[j].ten === ten) {
            gio[j].soLuong = gio[j].soLuong + 1;
            daCo = true;
        }
    }

    if (daCo === false) {
        gio.push({ ten: ten, gia: gia, anh: anh, soLuong: 1 });
    }

    luuGio(gio);
    hienSoLuong();
}


// thêm giỏ
let gioHang = document.querySelector("#gio-hang");
let nutThem = document.querySelectorAll(".them-gio");

function themGio(nut) {
    let the = nut.closest(".the");
    let anh = the.querySelector(".anh");
    let anhBay = anh.cloneNode(true);

    let batDau = anh.getBoundingClientRect(); // điểm đầu
    let gio = gioHang.getBoundingClientRect(); // điểm cuối

    anhBay.classList.add("anh-bay");

    // Điểm đầu
    anhBay.style.left = batDau.left + "px";
    anhBay.style.top = batDau.top + "px";
    anhBay.style.width = batDau.width + "px";
    anhBay.style.height = batDau.height + "px";
    anhBay.style.opacity = "1";

    document.body.appendChild(anhBay);

    // Điểm cuối
    setTimeout(function () {
        anhBay.style.left = gio.left + "px";
        anhBay.style.top = gio.top + "px";
        anhBay.style.width = gio.width + "px";
        anhBay.style.height = gio.height + "px";
        anhBay.style.opacity = "0";
    }, 100);

    // xong thì xóa ảnh bay và LƯU
    setTimeout(function () {
        anhBay.remove();
        themVaoGio(the);
    }, 900);
}

for (let i = 0; i < nutThem.length; i++) {
    nutThem[i].onclick = function () {
        themGio(nutThem[i]);
    };
}


// page Cart
function hienGioHang() {
    let bang = document.getElementById("danh-sach-gio"); 
    if (bang === null) {
        return;
    }
    /// khởi tạo biến
    let gio = layGio();
    let noiDung = "";
    let tong = 0;
    /// lặp tạo dòng trong giỏ hàng
    for (let i = 0; i < gio.length; i++) {
        let thanhTien = gio[i].gia * gio[i].soLuong; /// thành tiền = giá x số lượng
        tong = tong + thanhTien; // cộng dồn
        /// TẠO SP bằng data sản phẩm
        noiDung = noiDung + "<tr>";
        noiDung = noiDung + "<td><img src='" + gio[i].anh + "' width='60'> " + gio[i].ten + "</td>"; // dùng data sản phẩm index & sp để tạo 
        noiDung = noiDung + "<td>" + gio[i].gia + "đ</td>";
        noiDung = noiDung + "<td>";
        noiDung = noiDung + "<button class='giam'>-</button> "; // class .giam
        noiDung = noiDung + gio[i].soLuong; // i bằng 0 + thêm 1 - 1
        noiDung = noiDung + " <button class='tang'>+</button>"; // class .tang
        noiDung = noiDung + "</td>";
        noiDung = noiDung + "<td>" + thanhTien + "đ</td>";
        noiDung = noiDung + "<td><button class='xoa'>Xóa</button></td>";
        noiDung = noiDung + "</tr>";
    }

    bang.innerHTML = noiDung; // đưa noiDung -> danh-sach-gio để tạo bảng Sp

    let phi = 0;
    if (gio.length > 0) {
        phi = 25000; // phí = 0 nếu giỏ trống nếu > 0 = 25k
    }

    document.getElementById("tam-tinh").textContent = tong + "đ"; // trả kết quả TONG
    document.getElementById("phi-giao").textContent = phi + "đ"; // TRẢ KẾT QUẢ PHÍ GH TRONG GIỎ
    document.getElementById("tong-tien").textContent = (tong + phi) + "đ"; // TIỀN ĐƠN + PHÍ GH

    // nút tăng giảm

    let nutTang = document.querySelectorAll(".tang");
    let nutGiam = document.querySelectorAll(".giam");

    for (let i = 0; i < nutTang.length; i++) {
        // nút +
        nutTang[i].onclick = function () {
            gio[i].soLuong = gio[i].soLuong + 1;
            luuGio(gio);
            hienGioHang();
            hienSoLuong();
        };

        // nút -
        nutGiam[i].onclick = function () {
            if (gio[i].soLuong > 1) {
                gio[i].soLuong = gio[i].soLuong - 1;
            } else {
                gio.splice(i, 1); // còn 1 mà bấm - thì xóa luôn
            }
            luuGio(gio);
            hienGioHang();
            hienSoLuong();
        };
    }


    // nút xóa
    let nutXoa = document.querySelectorAll(".xoa");

    for (let i = 0; i < nutXoa.length; i++) {
        nutXoa[i].onclick = function () {
            gio.splice(i, 1); // xóa sp
            luuGio(gio);
            hienGioHang(); // vẽ lại
            hienSoLuong();
        };
    }
}

hienSoLuong();
hienGioHang();