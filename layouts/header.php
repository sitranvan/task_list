<?php
if (!isLogin()) {
    navigate('?module=auth&action=login');
} else {
    $userLogin = getUserLogin();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" href="<?= _WEB_HOST_ROOT ?>/public/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= _WEB_HOST_ROOT ?>/public/css/myStyle.css?v1=<? rand() ?>">
    <title>Task List</title>
</head>

<body>
    <nav class="navbar nav-bg">
        <div class="container">
            <a class="navbar-brand p-0 me-0 me-lg-2 d-flex align-items-center" href="/" aria-label="Bootstrap">
                <svg xmlns="http://www.w3.org/2000/svg" width="45" height="37" class="d-block my-1" viewBox="0 0 118 94" role="img">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M24.509 0c-6.733 0-11.715 5.893-11.492 12.284.214 6.14-.064 14.092-2.066 20.577C8.943 39.365 5.547 43.485 0 44.014v5.972c5.547.529 8.943 4.649 10.951 11.153 2.002 6.485 2.28 14.437 2.066 20.577C12.794 88.106 17.776 94 24.51 94H93.5c6.733 0 11.714-5.893 11.491-12.284-.214-6.14.064-14.092 2.066-20.577 2.009-6.504 5.396-10.624 10.943-11.153v-5.972c-5.547-.529-8.934-4.649-10.943-11.153-2.002-6.484-2.28-14.437-2.066-20.577C105.214 5.894 100.233 0 93.5 0H24.508zM80 57.863C80 66.663 73.436 72 62.543 72H44a2 2 0 01-2-2V24a2 2 0 012-2h18.437c9.083 0 15.044 4.92 15.044 12.474 0 5.302-4.01 10.049-9.119 10.88v.277C75.317 46.394 80 51.21 80 57.863zM60.521 28.34H49.948v14.934h8.905c6.884 0 10.68-2.772 10.68-7.727 0-4.643-3.264-7.207-9.012-7.207zM49.948 49.2v16.458H60.91c7.167 0 10.964-2.876 10.964-8.281 0-5.406-3.903-8.178-11.425-8.178H49.948z" fill="#ffff"></path>
                </svg>
                <span style="letter-spacing: 2px;" class="fw-bold text-white ms-2 text-uppercase">Task List</span>
            </a>
            <div class="dropdown">
                <div class="dropdown-toggle text-white d-flex align-items-center gap-2" data-bs-toggle="dropdown">
                    <i class="fa-solid fa-user"></i>
                    <?= $userLogin['username'] ?? false ?>
                </div>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">Hồ sơ</a></li>
                    <li><a class="dropdown-item" href="?module=auth&action=change_pass">Đổi mật khẩu</a></li>
                    <li><a class="dropdown-item" href="?module=auth&action=logout">Đăng xuất</a></li>
                </ul>
            </div>
        </div>
    </nav>