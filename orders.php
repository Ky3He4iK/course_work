<?php
$TITLE = "Мои заказы";
include("php/head.php");
include("php/body.php");
?>
    <div class="container-fluid">
        <h1 class="mt-4">Мои заказы</h1>
        <div class="card mb-4">
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['isnew']) && $_GET['isnew'] == 1) {
                echo '<ol class="breadcrumb mb-4"><li class="breadcrumb-item">Заказ был составлен! Мы обязательно свяжемся по его поводу</li></ol>';
            }
            $was_any = false;
            $result = mysqli_query($base, "SELECT * FROM $table_orders_table WHERE $table_orders_user_id=$USER_ID") or die(mysqli_error($base));
            while ($row = mysqli_fetch_array($result)) {
                $was_any = true;
                ?>

                <div class="card-header">
                    <i class="fas fa-table mr-1"></i>
                    Заказ
                    № <?php echo $row[$table_orders_order_id] . ' суммарной стоимостью ' . $row[$table_orders_price] . ' будет доставлен по адресу ' . $row[$table_orders_delivery_address] . ' в городе ' . $row[$table_orders_city]; ?>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th>Количество</th>
                                <th>Модель</th>
                                <th>Производитель</th>
                                <th>Ёмкость (Гб)</th>
                                <th>Цена</th>
                                <th>Описание</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $result_d = mysqli_query($base, "SELECT $table_orders_details_disk_id, $table_orders_details_disk_count FROM $table_orders_details_table WHERE $table_orders_details_order_id='$row[$table_orders_order_id]'") or die(mysqli_error($base));
                            while ($disk = mysqli_fetch_array($result_d)) {
                                $res = mysqli_query($base, "SELECT * FROM $table_disks_table WHERE $table_disks_id='$disk[$table_orders_details_disk_id]'") or die(mysqli_error($base));
                                while ($row_d = mysqli_fetch_array($res)) {
                                    echo "<tr class='center'>
                                <td>$disk[$table_orders_details_disk_count]</td>
                                <td>$row_d[$table_disks_model]</td>
                                <td>$row_d[$table_disks_manufacturer]</td>
                                <td>$row_d[$table_disks_capacity]</td>
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
            if (!$was_any) {
                ?>
                <div class="card-body">
                    Вы ещё не заказали ни одного товара, но
                    <a href="new_order.php" class="page-link">всегда можете это сделать</a>
                </div>
                <?php
            } else {
                ?>
                <div class="row">
                    <a class="alert-link" href="new_order.php">Заказать ещё</a>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
<?php
include("php/footer.php");
