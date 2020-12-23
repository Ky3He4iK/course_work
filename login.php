<?php
$TITLE = "Вход";
include("php/head.php");
include("php/body_login.php");

$MAIL_ERR = "";
$PASS_ERR = "";
if($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once "php/db_connect.php";
    $MAIL = "mail";
    $IS_OK = true;
    if (!isset($_POST[$MAIL])) {
        $MAIL_ERR = "Введите почту";
        $IS_OK = false;
    } else {
        $mail = mysqli_real_escape_string($base, $_POST[$MAIL]);
    }
    $PASS = "password";
    if (!isset($_POST[$PASS])) {
        $PASS_ERR = "Введите пароль";
        $IS_OK = false;
    } else {
        $pass = mysqli_real_escape_string($base, $_POST[$PASS]);
    }

    if ($IS_OK) {
        $res_salt = mysqli_query($base, "SELECT $table_users_salt FROM $table_users_table WHERE $table_users_login='$mail'") or die(mysqli_error($base));
        $array = mysqli_fetch_array($res_salt);
        if ($array !== false) {
            $salt = $array[0];
            $res_pass = mysqli_query($base, "SELECT $table_users_password FROM $table_users_table WHERE $table_users_login='$mail' AND $table_users_password=SHA1(ENCRYPT('$pass', '$salt'))") or die(mysqli_error($base));
            $array = mysqli_fetch_array($res_pass);
            if ($array != false) {
                $secret = $array[0];
                setcookie($LOGIN_COOKIE, $mail, time() + 86400, '/');
                setcookie($LOGIN_SECRET_COOKIE, $secret, time() + 86400, '/');
                header("Location: index.php");
            } else {
                $PASS_ERR = "Неправильный логин или пароль";
            }
        } else {
            $MAIL_ERR = "Такого пользователя не существует";
        }
    }
}
?>
<div class="card-body">
    <form method="POST">
        <div class="form-group">
            <label class="small mb-1" for="mail">Почта</label>
            <input class="form-control py-4" id="mail" name="mail" type="email" placeholder="Почта" required/>
            <div class="small" style="color: red"><?php echo $MAIL_ERR ?></div>
        </div>
        <div class="form-group">
            <label class="small mb-1" for="password">Пароль</label>
            <input class="form-control py-4" id="password" name="password" type="password" placeholder="Пароль" required/>
            <div class="small" style="color: red"><?php echo $PASS_ERR ?></div>
        </div>
        <div class="form-group mt-4 mb-0">
            <input type="submit" class="btn btn-primary btn-block" value="Войти">
        </div>
    </form>
</div>
<div class="card-footer text-center">
    <div class="small"><a href="register.php">Регистрация</a></div>
</div>
<?php
include("php/footer_login.php");
?>
