<?php
$TITLE = "Управление";
include("../php/head_admin.php");
include("../php/body_admin.php");
?>
    <div class="container-fluid">
        <h1 class="mt-4">Панель управления сайтом</h1>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table mr-1"></i>
                Статистика
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th><a class="alert-link" href="users.php">Пользователи</a></th>
                            <th><a class="alert-link" href="disks.php">Диски</a></th>
                            <th><a class="alert-link" href="orders.php">Заказы</a></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="center">
                            <?php
                            $result = mysqli_query($base, "SELECT count(*) FROM $table_users_table") or die(mysqli_error($base));
                            $row = mysqli_fetch_array($result);
                            echo '<td>';
                            if ($row != false)
                                echo $row[0] . ' пользователей';
                            else
                                echo "Не получается загрузить количество пользователей";
                            echo '</td>';
                            echo '<td>';
                            $result = mysqli_query($base, "SELECT count(*) FROM $table_disks_table") or die(mysqli_error($base));
                            $row = mysqli_fetch_array($result);
                            if ($row != false)
                                echo $row[0] . ' дисков';
                            else
                                echo "Не получается загрузить количество дисков";
                            echo '</td>';
                            echo '<td>';
                            $result = mysqli_query($base, "SELECT count(*) FROM $table_orders_table") or die(mysqli_error($base));
                            $row = mysqli_fetch_array($result);
                            if ($row != false)
                                echo $row[0] . ' заказов';
                            else
                                echo "Не получается загрузить количество заказов";
                            echo '</td>';
                            ?>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                <a href="../index.php" class="alert-link">Вернуться на сайт</a>
            </div>
        </div>
    </div>
<?php
include("../php/footer_admin.php");
