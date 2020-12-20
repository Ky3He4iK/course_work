<?php
$TITLE = "Регистрация";
include("php/head.php");
include("php/body_login.php");

$NAME_ERR = "";
$SURNAME_ERR = "";
$MAIL_ERR = "";
$PASS_ERR = "";
$PASS_CONF_ERR = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once "php/db_connect.php";
    $IS_OK = true;
    $NAME = "first_name";
    if (!isset($_POST[$NAME])) {
        $NAME_ERR = "Введите имя";
        $IS_OK = false;
    } else {
        $name = mysqli_real_escape_string($base, $_POST[$NAME]);
        if (strlen($name) < 2 || strlen($name) > 39) {
            $NAME_ERR = "Неправильное имя";
            $IS_OK = false;
        }
    }
    $SURNAME = "second_name";
    if (!isset($_POST[$SURNAME])) {
        $SURNAME_ERR = "Введите фамилию";
        $IS_OK = false;
    } else {
        $surname = mysqli_real_escape_string($base, $_POST[$SURNAME]);
        if (strlen($surname) < 2 || strlen($surname) > 39) {
            $SURNAME_ERR = "Неправильная фамилия";
            $IS_OK = false;
        } else
            $surname = $_POST[$SURNAME];
    }
    $MAIL = "mail";
    if (!isset($_POST[$MAIL])) {
        $MAIL_ERR = "Введите почту";
        $IS_OK = false;
    } else if (strlen($_POST[$MAIL]) > 39) {
        $MAIL_ERR = "Почта слишком длинная";
        $IS_OK = false;
    } else {
        $r = preg_match("/^*+@*+$/", $_POST[$MAIL]);
        if ($r == 0) {
            $MAIL_ERR = "Неправильный формат почты";
            $IS_OK = false;
        } else {
            $mail = mysqli_real_escape_string($base, $_POST[$MAIL]);
            if (strlen($mail) > 39) {
                $MAIL_ERR = 'слишком длинная почта';
                $IS_OK = false;
            }
        }
    }
    $PASS = "password";
    if (!isset($_POST[$PASS])) {
        $PASS_ERR = "Введите пароль";
        $IS_OK = false;
    } else {
        $r = preg_match("/^[\\w\\d_]{8,65}$/", $_POST[$PASS]);
        if ($r == 0) {
            $PASS_ERR = "Пароль должен содержать от 8 до 65 символов и должен состоять из английских букв, цифр и знака `_`";
            $IS_OK = false;
        } else
            $pass = mysqli_real_escape_string($base, $_POST[$PASS]);
    }
    $PASS_CONF = "confirm_password";
    if (!isset($_POST[$PASS_CONF])) {
        $PASS_CONF_ERR = "Введите подтверждение пароля";
        $IS_OK = false;
    } else {
        $r = preg_match("/^[\\w\\d]{8,65}$/", $_POST[$PASS_CONF]);
        if ($r == 0) {
            $PASS_CONF_ERR = "Неправильное подтвеждение пароля";
            $IS_OK = false;
        } else
            $pass_conf = $_POST[$PASS_CONF];
    }
    if (isset($pass) && isset($pass_conf) && strcmp($pass, $pass_conf) !== 0) {
        $PASS_CONF_ERR = "Пароль и подтверждение не совпадают";
        $IS_OK = false;
    }
    if (isset($mail)) {
        $result = mysqli_query($base, "SELECT * FROM $table_users_table WHERE $table_users_login='$mail'") or die(mysqli_error($base));
        $rowcount = mysqli_num_rows($result);
        if ($rowcount > 0) {
            $MAIL_ERR = "Эта почта уже занята";
            $IS_OK = false;
        }
    }
    if ($IS_OK) {
        try {
            $salt = base64_encode(random_bytes(28));
        } catch (Exception $e) {
            die("Ошибка добавления пользователя");
        }
        $query = "INSERT INTO $table_users_table ($table_users_login, $table_users_name, $table_users_password, $table_users_salt) " .
            "VALUE ('$mail', '$name $surname', SHA1(ENCRYPT('$pass', '$salt')), '$salt')";
        $res = mysqli_query($base, $query) or die(mysqli_error($base));
        if (!isset($res))
            $NAME_ERR = "Can't create this user!";
        else {
            header("Location: login.php");
        }
    }
}
?>
<div class="card-body">
    <form method="POST">
        <div class="form-row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="small mb-1" for="first_name">Имя</label>
                    <input class="form-control py-4" id="first_name" name="first_name" type="text" placeholder="Имя"
                           required/>
                    <div class="small" style="color: red"><?php echo $NAME_ERR ?></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="small mb-1" for="second_name">Фамилия</label>
                    <input class="form-control py-4" id="second_name" name="second_name" type="text"
                           placeholder="Фамилия" required/>
                    <div class="small" style="color: red"><?php echo $SURNAME_ERR ?></div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="small mb-1" for="mail">Почта</label>
            <input class="form-control py-4" id="mail" name="mail" type="email" aria-describedby="emailHelp"
                   placeholder="Почта" required/>
            <div class="small" style="color: red"><?php echo $MAIL_ERR ?></div>
        </div>
        <div class="form-row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="small mb-1" for="password">Пароль</label>
                    <input class="form-control py-4" id="password" name="password" type="password" placeholder="Пароль"
                           required/>
                    <div class="small" style="color: red"><?php echo $PASS_ERR ?></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="small mb-1" for="confirm_password">Подтверждение пароля</label>
                    <input class="form-control py-4" id="confirm_password" name="confirm_password" type="password"
                           placeholder="Подтверждение пароля" required/>
                    <div class="small" style="color: red"><?php echo $PASS_CONF_ERR ?></div>
                </div>
            </div>
        </div>
        <div class="form-group mt-4 mb-0">
            <input type="submit" class="btn btn-primary btn-block" value="Зарегистрироваться">
        </div>
    </form>
</div>
<div class="card-footer text-center">
    <div class="small"><a href="login.php">Вход в систему</a></div>
</div>
<?php
include("php/footer_login.php");
?>
