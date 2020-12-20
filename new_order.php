<?php
$TITLE = "Создать заказ";
include("php/head.php");
include("php/body.php");

$CITY_ERR = '';
$ADDRESS_ERR = '';
$DISK_ID_ERR = '';
$NUMBER_ERR = '';
$COMMENT_ERR = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $city = 'city';
    $address = 'address';
    $disk_id = 'disk_id';
    $count = 'count';
    $comment = 'comment';
    $IS_OK = true;
    if (isset($_POST[$city])) {
        $CITY = mysqli_real_escape_string($base, $_POST[$city]);
        if (strlen($CITY) > 29) {
            $IS_OK = false;
            $CITY_ERR = 'Слишком длинное название города';
        }
    } else {
        $IS_OK = false;
        $CITY_ERR = 'Нужно указать город';
    }
    if (isset($_POST[$address])) {
        $ADDRESS = mysqli_real_escape_string($base, $_POST[$address]);
        if (strlen($ADDRESS) > 300) {
            $IS_OK = false;
            $ADDRESS_ERR = 'Слишком длинный адрес';
        }
    } else {
        $IS_OK = false;
        $ADDRESS_ERR = 'Нужно указать адрес';
    }
    if (isset($_POST[$disk_id])) {
        $DISK_ID = filter_input(INPUT_POST, $disk_id, FILTER_VALIDATE_INT);
        if ($DISK_ID === false || $DISK_ID < 0) {
            $IS_OK = false;
            $DISK_ID_ERR = 'Неправильный диск';
        } else {
            $result = mysqli_query($base, "SELECT $table_disks_price FROM $table_disks_table WHERE $table_disks_id=$DISK_ID") or die(mysqli_error($base));
            $row = mysqli_fetch_array($result);
            if ($row == false) {
                $DISK_ID_ERR = 'Данный диск не найден!';
                $IS_OK = false;
            } else
                $DISK_PRICE = $row[0];
        }
    } else {
        $IS_OK = false;
        $DISK_ID_ERR = 'Нужно указать диск';
    }
    if (isset($_POST[$count])) {
        $COUNT = filter_input(INPUT_POST, $count, FILTER_VALIDATE_INT);
        if ($COUNT === false || $COUNT < 1) {
            $IS_OK = false;
            $NUMBER_ERR = 'Неправильное количество дисков';
        } else if ($COUNT > 1000) {
            $IS_OK = false;
            $NUMBER_ERR = 'Слишком много дисков';
        }
    } else {
        $IS_OK = false;
        $NUMBER_ERR = 'Нужно указать количество';
    }
    if (isset($_POST[$comment])) {
        $COMMENT = mysqli_real_escape_string($base, $_POST[$comment]);
        if (strlen($COMMENT) > 1000) {
            $IS_OK = false;
            $CITY_ERR = 'Слишком длинный комментарий';
        }
    } else {
        $COMMENT = '';
    }

    if ($IS_OK) {
        $PRICE = $DISK_PRICE * $COUNT;
        $result = mysqli_query($base, "INSERT INTO $table_orders_table ($table_orders_user_id, $table_orders_price, $table_orders_delivery_address, 
                   $table_orders_additional_info, $table_orders_city) VALUE ($USER_ID, $PRICE, '$ADDRESS', '$COMMENT', '$CITY')") or die(mysqli_error($base));
        $ORDER_ID = mysqli_insert_id($base);
        $result = mysqli_query($base, "INSERT INTO $table_orders_details_table ($table_orders_details_order_id, $table_orders_details_disk_id, $table_orders_details_disk_count) VALUE 
                    ($ORDER_ID, $DISK_ID, $COUNT)") or die(mysqli_error($base));
        header("Location: orders.php?isnew=1");
        exit();
    }
}
?>
    <div class="container-fluid">
        <h1 class="mt-4">Создать заказ</h1>
        <div class="card mb-4">
            <form method="POST">
                <div class="form-group">
                    <label class="small mb-1" for="city">Город доставки</label>
                    <input class="form-control py-4" id="city" name="city" type="text" placeholder="Адрес доставки"
                           required/>
                    <div class="small" style="color: red"><?php echo $CITY_ERR ?></div>
                </div>
                <div class="form-group">
                    <label class="small mb-1" for="address">Адрес доставки</label>
                    <input class="form-control py-4" id="address" name="address" type="text"
                           placeholder="Адрес доставки" required/>
                    <div class="small" style="color: red"><?php echo $ADDRESS_ERR ?></div>
                </div>
                <div class="form-group">
                    <label class="small mb-1" for="disk_id">Выберите диск</label>
                    <select class="form-control" id="disk_id" name="disk_id" type="text" required>
                        <?php
                        $result = mysqli_query($base, "SELECT * FROM $table_disks_table") or die(mysqli_error($base));
                        while ($row = mysqli_fetch_array($result)) {
                            echo '<option value="' . $row[$table_disks_id] . '">' . "$row[$table_disks_model] $row[$table_disks_manufacturer] ($row[$table_disks_capacity] ГБ) - $row[$table_disks_price]" . '</option>';
                        }
                        ?>
                    </select>
                    <div class="small" style="color: red"><?php echo $DISK_ID_ERR ?></div>
                </div>
                <div class="form-group">
                    <label class="small mb-1" for="count">Количество</label>
                    <input class="form-control py-4" id="count" name="count" type="number"
                           value="1" min="1" max="1000" required/>
                    <div class="small" style="color: red"><?php echo $NUMBER_ERR ?></div>
                </div>
                <div class="form-group">
                    <label class="small mb-1" for="comment">Комментарий</label>
                    <input class="form-control py-4" id="comment" name="comment" type="text"
                           placeholder="Выразите дополнительные пожелания здесь"/>
                    <div class="small" style="color: red"><?php echo $COMMENT_ERR ?></div>
                </div>
                <input type="submit" class="btn btn-primary btn-block" value="Отправить заказ"/>
            </form>
        </div>
        <div class="card mb-4">
            <div class="row">
                <a class="alert-link" href="new_order.php">Каталог дисков</a>
            </div>
            <div class="row">
                <a class="alert-link" href="new_order.php">Посмотреть уже заказанные товары</a>
            </div>
        </div>
    </div>
<?php
include("php/footer.php");
