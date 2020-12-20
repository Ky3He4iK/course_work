<?php
$TITLE = "Заказы";
include("../php/head_admin.php");
include("../php/body_admin.php");

$order_id = 'order_id';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = 'user';
    $price = 'price';
    $delivery_address = 'delivery_address';
    $additional_info = 'additional_info';
    $city = 'city';
    $disk_id = 'disk_id';
    $count = 'count';
    if (!isset($_POST[$user]) || !isset($_POST[$delivery_address]) || !isset($_POST[$additional_info])
        || !isset($_POST[$city]) || !isset($_POST[$disk_id]) || !isset($_POST[$count])) {
        if (isset($_POST[$order_id])) {
            $ORDER_ID = mysqli_real_escape_string($base, $_POST[$order_id]);
            mysqli_query($base, "DELETE FROM $table_orders_details_table WHERE $table_orders_details_order_id=$ORDER_ID") or die(mysqli_error($base));
            mysqli_query($base, "DELETE FROM $table_orders_table WHERE $table_orders_order_id=$ORDER_ID") or die(mysqli_error($base));
            $INFO = 'Заказ удален успешно';
        } else
            $ERROR = "Нужно передать: пользователь, адрес доставки, город, id диска, количество дисков";
    } else {
        $USER = mysqli_real_escape_string($base, $_POST[$user]);
        $DELIVERY_ADDRESS = mysqli_real_escape_string($base, $_POST[$delivery_address]);
        $ADDITIONAL_INFO = mysqli_real_escape_string($base, $_POST[$additional_info]);
        $CITY = mysqli_real_escape_string($base, $_POST[$city]);

        $DISK_ID = filter_input(INPUT_POST, $disk_id, FILTER_VALIDATE_INT);
        $COUNT = filter_input(INPUT_POST, $count, FILTER_VALIDATE_INT);

        $result = mysqli_query($base, "SELECT $table_users_id FROM $table_users_table WHERE $table_users_login='$USER'") or die(mysqli_error($base));
        $row = mysqli_fetch_array($result);
        if ($row == false)
            $ERROR = 'Неизвестный пользователь';
        else if ($DISK_ID === false || $DISK_ID < 1 || $COUNT === false || $COUNT < 1) {
            $ERROR = 'Неправильный формат данных';
        } else {
            $USER_ID = $row[0];
            $result = mysqli_query($base, "SELECT $table_disks_price FROM $table_disks_table WHERE $table_disks_id=$DISK_ID");
            if (!$result) {
                $ERROR = mysqli_error($base);
            } else {
                $row = mysqli_fetch_array($result);
                if ($row == false) {
                    $ERROR = 'Данный диск не найден!';
                } else {
                    $DISK_PRICE = $row[0];
                    $PRICE = $DISK_PRICE * $COUNT;
                    $ORDER_ID = false;
                    if (isset($_POST[$order_id])) {
                        $ORDER_ID = filter_input(INPUT_POST, $order_id, FILTER_VALIDATE_INT);
                        if ($ORDER_ID == false || $ORDER_ID < 0)
                            $ORDER_ID = false;
                    }
                    if ($ORDER_ID !== false) {
                        $result = mysqli_query($base, "UPDATE $table_orders_table SET $table_orders_user_id=$USER_ID, $table_orders_price=$PRICE,
                     $table_orders_delivery_address='$DELIVERY_ADDRESS', $table_orders_additional_info='$ADDITIONAL_INFO', $table_orders_city='$CITY' 
                     WHERE $table_orders_order_id=$ORDER_ID");
                        if ($result) {
                            $result = mysqli_query($base, "DELETE FROM $table_orders_details_table WHERE $table_orders_order_id=$ORDER_ID");
                            if ($result) {
                                $result = mysqli_query($base, "INSERT INTO $table_orders_details_table ($table_orders_details_order_id, $table_orders_details_disk_id, $table_orders_details_disk_count) VALUE 
                    ($ORDER_ID, $DISK_ID, $COUNT)");
                                if ($result)
                                    $INFO = 'Заказ обновлен успешно';
                                else
                                    $ERROR = mysqli_error($base);
                            } else
                                $ERROR = mysqli_error($base);
                        } else
                            $ERROR = mysqli_error($base);
                    } else {
                        $result = mysqli_query($base, "INSERT INTO $table_orders_table ($table_orders_user_id, $table_orders_price,
                     $table_orders_delivery_address, $table_orders_additional_info, $table_orders_city) 
                   VALUE ($USER_ID, $PRICE, '$DELIVERY_ADDRESS', '$ADDITIONAL_INFO', '$CITY')");
                        if ($result) {
                            $ORDER_ID = mysqli_insert_id($base);
                            $result = mysqli_query($base, "INSERT INTO $table_orders_details_table ($table_orders_details_order_id, $table_orders_details_disk_id, $table_orders_details_disk_count) VALUE 
                    ($ORDER_ID, $DISK_ID, $COUNT)");
                            if ($result)
                                $INFO = 'Заказ добавлен успешно';
                            else {
                                $ERROR = mysqli_error($base);
                            }
                        } else
                            $ERROR = mysqli_error($base);
                    }
                }
            }
        }
    }
}
?>
    <div class="container-fluid">
        <h1 class="mt-4">Все заказы</h1>
        <?php
        if (isset($ERROR)) {
            echo '<div class="breadcrumb"><div class="breadcrumb-item" style="color: red">' . $ERROR . '</div></div>';
        }
        if (isset($INFO)) {
            echo '<div class="breadcrumb"><div class="breadcrumb-item">' . $INFO . '</div></div>';
        }
        ?>
        <div class="card mb-4">
            <?php
            $query = "SELECT * FROM $table_orders_table";
            $result = mysqli_query($base, $query) or die(mysqli_error($base));
            while ($row = mysqli_fetch_array($result)) {
                $was_any = true;
                ?>
                <div class="card-header">
                    <i class="fas fa-table mr-1"></i>
                    <?php
                    $res_u = mysqli_query($base, "SELECT $table_users_login FROM $table_users_table WHERE $table_users_id=$row[$table_orders_user_id]") or die(mysqli_error($base));
                    $r_u = mysqli_fetch_array($res_u);
                    echo "Заказ пользователя $r_u[0] №" . $row[$table_orders_order_id] . ' суммарной стоимостью ' . $row[$table_orders_price] . ' будет доставлен по адресу ' . $row[$table_orders_delivery_address] . ' в городе ' . $row[$table_orders_city]
                        . '<br/>Комментарий к заказу: ' . $row[$tableorders_additional_info]; ?>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th>Количество</th>
                                <th>№</th>
                                <th>Модель</th>
                                <th>Производитель</th>
                                <th>Ёмкость (Гб)</th>
                                <th>Скорость передачи данных (Мб/с)</th>
                                <th>Интерфейс</th>
                                <th>Цена</th>
                                <th>Описание</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>Количество</th>
                                <th>№</th>
                                <th>Модель</th>
                                <th>Производитель</th>
                                <th>Ёмкость (Гб)</th>
                                <th>Скорость передачи данных (Мб/с)</th>
                                <th>Интерфейс</th>
                                <th>Цена</th>
                                <th>Описание</th>
                            </tr>
                            </tfoot>
                            <tbody>
                            <?php
                            $query = "SELECT $table_orders_details_disk_id, $table_orders_details_disk_count FROM $table_orders_details_table WHERE $table_orders_details_order_id=$row[$table_orders_order_id]";
                            $result_d = mysqli_query($base, $query) or die(mysqli_error($base));
                            while ($disk = mysqli_fetch_array($result_d)) {
                                $res = mysqli_query($base, "SELECT * FROM $table_disks_table WHERE $table_disks_id='$disk[$table_orders_details_disk_id]'") or die(mysqli_error($base));
                                while ($row_d = mysqli_fetch_array($res)) {
                                    echo "<tr class='center'>
                                <td>$disk[$table_orders_details_disk_count]</td>
                                <td>$row_d[$table_disks_id]</td>
                                <td>$row_d[$table_disks_model]</td>
                                <td>$row_d[$table_disks_manufacturer]</td>
                                <td>$row_d[$table_disks_capacity]</td>
                                <td>$row_d[$table_disks_transfer_rate]</td>
                                <td>$row_d[$table_disks_interface]</td>
                                <td>$row_d[$table_disks_price]</td>
                                <td>$row_d[$table_disks_description]</td></tr>";
                                }
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
        <div class="card-body">
            <h1 class="mt-4">Удалить заказ</h1>
            <form method="POST">
                <div class="form-group">
                    <label class="small mb-1" for="disk_id">№ заказа</label>
                    <input class="form-control py-4" id="disk_id" name="order_id" type="number" min="0" required/>
                </div>
                <div class="form-group mt-4 mb-0">
                    <input type="submit" class="btn btn-primary btn-block" value="Удалить">
                </div>
            </form>
        </div>
        <div class="card-body">
            <h1 class="mt-4">Добавить/обновить заказ</h1>
            <form method="POST">
                <div class="form-group">
                    <label class="small mb-1" for="order_id">№ заказа (только для изменения существующего
                        заказа)</label>
                    <input class="form-control py-4" id="order_id" name="order_id" type="number" min="-1"/>
                </div>
                <div class="form-group">
                    <label class="small mb-1" for="user">Пользователь, сделавший заказ</label>
                    <input class="form-control py-4" id="user" name="user" type="email" required/>
                </div>
                <div class="form-group">
                    <label class="small mb-1" for="city">Город доставки</label>
                    <input class="form-control py-4" id="city" name="city" type="text" required/>
                </div>
                <div class="form-group">
                    <label class="small mb-1" for="delivery_address">Адрес доставки</label>
                    <input class="form-control py-4" id="delivery_address" name="delivery_address" type="text"
                           required/>
                </div>
                <div class="form-group">
                    <label class="small mb-1" for="additional_info">Комментарий к заказу</label>
                    <input class="form-control py-4" id="additional_info" name="additional_info" type="text"/>
                </div>
                <div class="form-group">
                    <label class="small mb-1" for="disk_id">Id диска</label>
                    <input class="form-control py-4" id="disk_id" name="disk_id" type="text" required/>
                </div>
                <div class="form-group">
                    <label class="small mb-1" for="count">Количество дисков</label>
                    <input class="form-control py-4" id="count" name="count" type="number" min="1" required/>
                </div>
                <div class="form-group mt-4 mb-0">
                    <input type="submit" class="btn btn-primary btn-block" value="Добавить/обновить">
                </div>
            </form>
        </div>
    </div>
<?php
include("../php/footer_admin.php");
