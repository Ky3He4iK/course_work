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
            <form method="GET">
                <tr>
                    <th></th>
                    <th><input type="text" name="model"/></th>
                    <th><input type="text" name="manufacturer"/></th>
                    <th><input type="number" name="capacity"/></th>
                    <th><input type="number" name="transfer_rate"/></th>
                    <th><input type="text" name="interface"/></th>
                    <th><input type="number" name="price"/></th>
                    <th><input type="submit" value="Фильтровать"/></th>
                </tr>
            </form>
            </tfoot>
            <tbody>
            <?php
            if (!isset($filter))
                $filter = "1=1";
            $result = mysqli_query($base, "SELECT * FROM $table_disks_table WHERE " . $filter);
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
