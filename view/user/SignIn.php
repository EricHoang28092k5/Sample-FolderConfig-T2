<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
<link rel="stylesheet" href="css/SignIn.css"/>
<link
      rel="shortcut icon"
      href="../img/DMTD-Food-Logo.jpg"
      type="image/x-icon"
    />
    <title>DMTD FOOD</title>
</head>

<body>
<div class="container">
<h2>ĐĂNG NHẬP</h2>
<form action="/web/inc/user/SignInInc.php" method="post" style="max-width:500px;margin:auto">

  <div class="input-container">
    <i class="fa fa-user icon"></i>
    <input class="input-field" type="text" placeholder="Tên đăng nhập" name="tenDangNhap" required>
  </div>
  
  <div class="input-container">
    <i class="fa fa-key icon"></i>
    <input class="input-field" type="password" placeholder="Mật khẩu" name="password" required>
  </div>
  <input type="submit" value="Đăng nhập" name="signIn">
  <div class="links">
    <p> Chưa có tài khoản? </p>
    <a href="SignUp.php">Đăng ký</a>
  </div>

  <a href="/web/index.php" class="back">Quay lại</a>
</form>
</div>

<?php 
// ==== HIỂN THỊ MODAL KHI CÓ THAM SỐ ERROR TRÊN URL ====
if (isset($_GET['error'])) {
    $errorType = $_GET['error'];
    echo '<script>
        document.addEventListener("DOMContentLoaded", function() {';
    
    switch ($errorType) {
        case 'wrong-user-or-pass':
            echo 'showSignInErrorModal("Tên đăng nhập hoặc mật khẩu không đúng. Vui lòng thử lại!");';
            break;

        case 'block-user':
            echo 'showSignInErrorModal("Tài khoản của bạn đã bị khóa. Vui lòng liên hệ quản trị viên!");';
            break;
    }

    echo '});
    </script>';
}
?>

<script>
// === MODAL THÔNG BÁO LỖI ĐĂNG NHẬP ===
function showSignInErrorModal(message) {
  createModal(message, "SignIn.php", "Thử lại");
}

// === HÀM TẠO MODAL DÙNG CHUNG ===
function createModal(message, linkHref, linkText) {
  const modalContainer = document.createElement("div");
  modalContainer.id = "modal-container";

  modalContainer.innerHTML = `
    <div class="modal" id="modal-demo">
      <div class="modal_header">
        <h3>Thông báo</h3>
        <button id="btn-close"><i class="fa-solid fa-xmark"></i></button>
      </div>
      <div class="modal_body">
        <p>${message}</p>
        <a href="${linkHref}">${linkText}</a>
      </div>
    </div>
  `;

  document.body.appendChild(modalContainer);

  const btnClose = document.getElementById("btn-close");
  const modalDemo = document.getElementById("modal-demo");

  modalContainer.classList.add("show");

  btnClose.addEventListener("click", function () {
    modalContainer.classList.remove("show");
    setTimeout(() => document.body.removeChild(modalContainer), 300);
  });

  modalContainer.addEventListener("click", function (e) {
    if (!modalDemo.contains(e.target)) btnClose.click();
  });

  // === THÊM CSS CHO MODAL (nếu chưa có) ===
  if (!document.getElementById("modal-style")) {
    const style = document.createElement("style");
    style.id = "modal-style";
    style.textContent = `
      * { box-sizing: border-box; }
      body { font-family: Arial, Helvetica, sans-serif; line-height: 1.3; }

      #modal-container {
        height: 100vh;
        background-color: rgba(0, 0, 0, 0.5);
        position: fixed;
        top: 0; left: 0;
        width: 100%;
        opacity: 0;
        pointer-events: none;
        z-index: 1000;
      }
      #modal-container.show { opacity: 1; pointer-events: all; }

      .modal {
        background-color: #fff;
        max-width: 500px;
        position: relative;
        left: 50%; top: 100px;
        transform: translateX(-50%);
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
      }

      .modal .modal_header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 20px;
        border-bottom: 1px solid gray;
      }

      .modal_header h3 {
        margin: 0;
        text-align: center;
        flex-grow: 1;
      }

      button#btn-close {
        width: 30px; height: 30px;
        border: none;
        font-size: 20px;
        color: white;
        background-color: #f37319;
        border-radius: 20px;
        cursor: pointer;
        position: absolute;
        top: -5px; right: -5px;
      }

      .modal .modal_body { padding: 10px 20px 15px; }

      .modal_body p { text-align: center; }

      .modal_body a {
        text-decoration: none;
        background: #f37319;
        color: #fff;
        display: block;
        padding: 5px 15px;
        text-align: center;
        margin: 10px auto;
        width: fit-content;
        border-radius: 10px;
      }
    `;
    document.head.appendChild(style);
  }
}
</script>

</body>
</html>