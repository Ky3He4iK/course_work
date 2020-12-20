<?php
require_once "db_connect.php";
$LOGIN_COOKIE = "login";
$LOGIN_SECRET_COOKIE = "login_secret";
if (isset($_COOKIE[$LOGIN_COOKIE]) && isset($_COOKIE[$LOGIN_SECRET_COOKIE])) {
    $LOGIN = "User";
    $login_esc = mysqli_real_escape_string($base, $_COOKIE[$LOGIN_COOKIE]);
    $login_secret_esc = mysqli_real_escape_string($base, $_COOKIE[$LOGIN_SECRET_COOKIE]);
    $result = mysqli_query($base, "SELECT $table_users_id FROM $table_users_table WHERE $table_users_login='$login_esc' and $table_users_password='$login_secret_esc'") or die(mysqli_error($base));
    $array = mysqli_fetch_array($result);
    if ($array !== false) {
        $LOGIN = $login_esc;
        $USER_ID = $array[0];
    }
}
if (!isset($LOGIN)) {
    header("Location: login.php");
    exit();
}
?>
<body class="sb-nav-fixed sb-sidenav-toggled">
<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <a class="navbar-brand" href="index.php">Жесткие диски</a>
    <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i>
    </button>
    <ul class="navbar-nav ml-auto ml-md-0">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown"
               aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                <div class="dropdown-item">
                    <?php echo $LOGIN ?>
                </div>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="login.php">Logout</a>
            </div>
        </li>
    </ul>
</nav>
<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
                <div class="nav">
                    <!-- todo: pages, links -->
                    <div class="sb-sidenav-menu-heading">Каталог товаров</div>
                    <a class="nav-link" href="disks.php">
                        <div class="sb-nav-link-icon"><i class="fas fa- fa-dot-circle"></i></div>
                        Жёсткие диски
                    </a>
                    <div class="sb-sidenav-menu-heading">Заказы</div>
                    <a class="nav-link" href="orders.php">
                        <div class="sb-nav-link-icon"><i class="fas fa- fa-shopping-cart"></i></div>
                        Мои заказы
                    </a>
                    <a class="nav-link" href="new_order.php">
                        <div class="sb-nav-link-icon"><i class="fas fa- fa-cart-plus"></i></div>
                        Сделать заказ
                    </a>
                    <div class="sb-sidenav-menu-heading">Admin</div>
                    <a class="nav-link" href="admin/index.php">
                        <div class="sb-nav-link-icon"><i class="fas fa- fa-user"></i></div>
                        Страница админа
                    </a>
                </div>
            </div>

            <div class="sb-sidenav-footer">
                <div class="small">Вход выполнен:</div>
                <?php echo $LOGIN ?>
                <a class="nav-link" href="login.php">
                    <div class="sb-nav-link-icon"><i class="fas fa- fa-sign-out-alt"></i></div>
                    Выход
                </a>
            </div>
        </nav>
    </div>
    <div id="layoutSidenav_content">
        <main>
