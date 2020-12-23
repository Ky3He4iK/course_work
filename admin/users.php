<?php
$TITLE = "Пользователи";
include("../php/head_admin.php");
include("../php/body_admin.php");

$user_id = 'user_id';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = 'login';
    $user_name = 'user_name';
    $password = 'password';
    $is_admin = 'is_admin';
    if (!isset($_POST[$user_name]) || !isset($_POST[$is_admin]) || !isset($_POST[$login])) {
        if (isset($_POST[$user_id])) {
            $USER_ID = mysqli_real_escape_string($base, $_POST[$user_id]);
            $result = mysqli_query($base, "SELECT $table_users_salt FROM $table_users_table WHERE $table_users_id=$USER_ID");
            if (!$result)
                $ERROR = mysqli_error($base);
            else {
                $row = mysqli_fetch_array($result);
                if ($row == false) {
                    $ERROR = "Пользователь не найден!";
                } else {
                    $SALT = $row[$table_users_salt];
                    if (isset($_POST[$password])) {
                        $PASSWORD = mysqli_real_escape_string($base, $_POST[$password]);
                        $result = mysqli_query($base, "UPDATE $table_users_table SET $table_users_password=SHA1(ENCRYPT('$PASSWORD', '$SALT')) WHERE $table_users_id=$USER_ID");
                        if ($result)
                            $INFO = 'Пароль изменен успешно';
                        else
                            $ERROR = mysqli_error($base);
                    } else {
                        $result = mysqli_query($base, "DELETE FROM $table_users_table WHERE $table_users_id=$USER_ID");
                        if ($result)
                            $INFO = 'Пользователь удален успешно';
                        else
                            $ERROR = mysqli_error($base);
                    }
                }
            }
        } else
            $ERROR = "Нужно передать: почта пользователя, имя пользователя, администратор";
    } else {
        $LOGIN = mysqli_real_escape_string($base, $_POST[$login]);
        $USER_NAME = mysqli_real_escape_string($base, $_POST[$user_name]);
        $IS_ADMIN = filter_input(INPUT_POST, $is_admin, FILTER_VALIDATE_INT);

        if ($IS_ADMIN === false || $IS_ADMIN < 0 || $IS_ADMIN > 1) {
            $ERROR = 'Неправильный формат данных';
        } else {
            if ($IS_ADMIN != 1)
                $IS_ADMIN = 0;
            $USER_ID = false;
            if (isset($_POST[$user_id])) {
                $USER_ID = filter_input(INPUT_POST, $user_id, FILTER_VALIDATE_INT);
                if ($USER_ID == false || $USER_ID < 0)
                    $USER_ID = false;
            }
            if ($USER_ID !== false) {
                $query = "UPDATE $table_users_table SET $table_users_login='$LOGIN', $table_users_name='$USER_NAME',
                 $table_users_is_admin=$IS_ADMIN WHERE $table_users_id=$USER_ID";
                $result = mysqli_query($base, $query);
                if ($result)
                    $INFO = 'Пользователь обновлен успешно';
                else
                    $ERROR = mysqli_error($base);
            } else {
                $SALT = base64_encode(random_bytes(28));
                $PASSWORD = base64_encode(random_bytes(28));
                $query = "INSERT INTO $table_users_table ($table_users_login, $table_users_name, $table_users_password, $table_users_salt, $table_users_is_admin) 
                   VALUE ('$LOGIN', '$USER_NAME', SHA1(ENCRYPT('$PASSWORD', '$SALT')), '$SALT', $IS_ADMIN)";
                $result = mysqli_query($base, $query);
                if ($result)
                    $INFO = 'Пользователь добавлен успешно. Теперь требуется поставить ему пароль';
                else
                    $ERROR = mysqli_error($base);
            }
        }
    }
}
?>
    <div class="container-fluid">
        <?php
        if (isset($ERROR)) {
            echo '<div class="breadcrumb"><div class="breadcrumb-item" style="color: red">' . $ERROR . '</div></div>';
        }
        if (isset($INFO)) {
            echo '<div class="breadcrumb"><div class="breadcrumb-item">' . $INFO . '</div></div>';
        }
        ?>
        <div class="card mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>Id</th>
                            <th>Почта</th>
                            <th>Имя</th>
                            <th>Администратор?</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $result = mysqli_query($base, "SELECT * FROM $table_users_table");
                        while ($row = mysqli_fetch_array($result)) {
                            echo '<tr class="center">' .
                                "<td><b>$row[$table_users_id]</b></td>
                                <td>$row[$table_users_login]</td>
                                <td>$row[$table_users_name]</td>";
                            if ($row[$table_users_is_admin])
                                echo "<td>Да</td></tr>";
                            else
                                echo "<td></td></tr>";
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="card-body">
            <h1 class="mt-4">Удалить пользователя</h1>
            <form method="POST">
                <div class="form-group">
                    <label class="small mb-1" for="user_id">Id пользователя</label>
                    <input class="form-control py-4" id="user_id" name="user_id" type="number" min="0" required/>
                </div>
                <div class="form-group mt-4 mb-0">
                    <input type="submit" class="btn btn-primary btn-block" value="Добавить/обновить">
                </div>
            </form>
        </div>
        <div class="card-body">
            <h1 class="mt-4">Добавить/обновить пользователя</h1>
            <form method="POST">
                <div class="form-group">
                    <label class="small mb-1" for="user_id">Id пользователя (только для изменения существующего
                        пользователя)</label>
                    <input class="form-control py-4" id="user_id" name="user_id" type="number" min="-1"/>
                </div>
                <div class="form-group">
                    <label class="small mb-1" for="login">Почта</label>
                    <input class="form-control py-4" id="login" name="login" type="text" required/>
                </div>
                <div class="form-group">
                    <label class="small mb-1" for="user_name">Имя и фамилия</label>
                    <input class="form-control py-4" id="user_name" name="user_name" type="text" required/>
                </div>
                <div class="form-group">
                    <label class="small mb-1" for="is_admin">Администратор?</label>
                    <select class="form-control" id="is_admin" name="is_admin" type="text" required>
                        <option value="0" selected="selected">Нет</option>
                        <option value="1">Да</option>
                    </select>
                </div>
                <div class="form-group mt-4 mb-0">
                    <input type="submit" class="btn btn-primary btn-block" value="Добавить/обновить">
                </div>
            </form>
        </div>
        <div class="card-body">
            <h1 class="mt-4">Обновить пароль</h1>
            <form method="POST">
                <div class="form-group">
                    <label class="small mb-1" for="user_id">Id пользователя</label>
                    <input class="form-control py-4" id="user_id" name="user_id" type="number" min="1" required/>
                </div>
                <div class="form-group">
                    <label class="small mb-1" for="password">Пароль</label>
                    <input class="form-control py-4" id="password" name="password" type="password" required/>
                </div>
                <div class="form-group mt-4 mb-0">
                    <input type="submit" class="btn btn-primary btn-block" value="Обновить">
                </div>
            </form>
        </div>
    </div>
<?php
include("../php/footer_admin.php");
