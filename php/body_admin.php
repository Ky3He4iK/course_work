<?php
require_once "db_connect.php";
$LOGIN_COOKIE = "login";
$LOGIN_SECRET_COOKIE = "login_secret";
if (isset($_COOKIE[$LOGIN_COOKIE]) && isset($_COOKIE[$LOGIN_SECRET_COOKIE])) {
    $login_esc = mysqli_real_escape_string($base, $_COOKIE[$LOGIN_COOKIE]);
    $login_secret_esc = mysqli_real_escape_string($base, $_COOKIE[$LOGIN_SECRET_COOKIE]);
    $result = mysqli_query($base, "SELECT $table_users_id, $table_users_is_admin FROM $table_users_table WHERE $table_users_login='$login_esc' and $table_users_password='$login_secret_esc'") or die(mysqli_error($base));
    $array = mysqli_fetch_array($result);
    if ($array != false && $array[1] == 1) {
        $LOGIN = $login_esc;
        $USER_ID = $array[0];
        if ($USER_ID == false)
            $USER_ID = 0;
    }
}
if (!isset($LOGIN)) {
    header("Location: ../login.php");
    exit();
}
?>
<body class="sb-nav-fixed sb-sidenav-toggled">
<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <a class="navbar-brand" href="index.php">Панель управления</a>
    <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i>
    </button>
</nav>
<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
                <div class="nav">
                    <div class="sb-sidenav-menu-heading">Управление</div>
                    <a class="nav-link" href="disks.php">
                        <div class="sb-nav-link-icon"><i class="fas fa- fa-dot-circle"></i></div>
                        Каталог дисков
                        <a class="nav-link" href="orders.php">
                            <div class="sb-nav-link-icon"><i class="fas fa- fa-shopping-cart"></i></div>
                            Заказы
                        </a>
                        <a class="nav-link" href="users.php">
                            <div class="sb-nav-link-icon"><i class="fas fa- fa-user"></i></div>
                            Пользователи
                        </a>
                    </a>
                    <div class="sb-sidenav-menu-heading">Сайт</div>
                    <a class="nav-link" href="../index.php">
                        <div class="sb-nav-link-icon"><i class="fas fa- fa-sign-out-alt"></i></div>
                        Вернуться на сайт
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
