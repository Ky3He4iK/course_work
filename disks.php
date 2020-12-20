<?php
$TITLE = "Каталог дисков";
include("php/head.php");
include("php/body.php");
?>
    <div class="container-fluid">
        <h1 class="mt-4">Каталог дисков</h1>
        <div class="card mb-4">
<!--            <div class="card-header">-->
<!--                <i class="fas fa-table mr-1"></i>-->
<!--            </div>-->
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
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
                        $result = mysqli_query($base, "SELECT * FROM $table_disks_table");
                        while ($row = mysqli_fetch_array($result)) {
                            echo "<tr class='center'>
                                <td><b>$row[$table_disks_id]</b></td>
                                <td>$row[$table_disks_model]</td>
                                <td>$row[$table_disks_manufacturer]</td>
                                <td>$row[$table_disks_capacity]</td>
                                <td>$row[$table_disks_transfer_rate]</td>
                                <td>$row[$table_disks_interface]</td>
                                <td>$row[$table_disks_price]</td>
                                <td>$row[$table_disks_description]</td></tr>";
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                Выбрали себе диск? &nbsp; <a class="alert-link" href="new_order.php">Закажите его!</a>
            </div>
        </div>
    </div>
<?php
include("php/footer.php");
