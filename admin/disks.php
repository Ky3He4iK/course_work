<?php
$TITLE = "Каталог дисков";
include("../php/head_admin.php");
include("../php/body_admin.php");

$disk_id = 'disk_id';
include("../php/disks_filter.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $description = 'description';
    if (!isset($_POST[$manufacturer]) || !isset($_POST[$model]) || !isset($_POST[$capacity])
        || !isset($_POST[$price]) || !isset($_POST[$transfer_rate]) || !isset($_POST[$interface])) {
        if (isset($_POST[$disk_id]) && strlen($_POST[$disk_id]) > 0) {
            $DISK_ID = mysqli_real_escape_string($base, $_POST[$disk_id]);
            $query = "DELETE FROM $table_disks_table WHERE $table_disks_id=$DISK_ID";
            $result = mysqli_query($base, $query);
            if (!$result)
                $ERROR = mysqli_error($base);
            else
                $INFO = 'Диск удален успешно';
        } else
            $ERROR = "Нужно передать: производитель, модель диска, описание, ёкость, цена, скорость передачи данных, интерфейс";
    } else {
        $MANUFACTURER = mysqli_real_escape_string($base, $_POST[$manufacturer]);
        $MODEL = mysqli_real_escape_string($base, $_POST[$model]);
        $DESCRIPTION = mysqli_real_escape_string($base, $_POST[$description]);
        $INTERFACE = mysqli_real_escape_string($base, $_POST[$interface]);

        $CAPACITY = filter_input(INPUT_POST, $capacity, FILTER_VALIDATE_INT);
        $PRICE = filter_input(INPUT_POST, $price, FILTER_VALIDATE_INT);
        $TRANSFER_RATE = filter_input(INPUT_POST, $transfer_rate, FILTER_VALIDATE_INT);

        if ($CAPACITY === false || $CAPACITY < 1 || $PRICE === false || $PRICE < 1 || $TRANSFER_RATE === false || $TRANSFER_RATE < 1) {
            $ERROR = 'Неправильный формат данных';
        } else {
            $DISK_ID = false;
            if (isset($_POST[$disk_id])) {
                $DISK_ID = filter_input(INPUT_POST, $disk_id, FILTER_VALIDATE_INT);
                if ($DISK_ID == false || $DISK_ID < 0)
                    $DISK_ID = false;
            }
            if ($DISK_ID !== false) {
                $query = "UPDATE $table_disks_table SET $table_disks_manufacturer='$MANUFACTURER', $table_disks_model='$MODEL', 
                $table_disks_description='$DESCRIPTION', $table_disks_capacity=$CAPACITY, $table_disks_price=$PRICE, $table_disks_transfer_rate=$TRANSFER_RATE,
                $table_disks_interface='$INTERFACE' WHERE $table_disks_id=$DISK_ID";
            } else {
                $query = "INSERT INTO $table_disks_table ($table_disks_manufacturer, $table_disks_model, $table_disks_description, 
                   $table_disks_capacity, $table_disks_price, $table_disks_transfer_rate, $table_disks_interface) 
                   VALUE ('$MANUFACTURER', '$MODEL', '$DESCRIPTION', $CAPACITY, $PRICE, $TRANSFER_RATE, '$INTERFACE')";
            }
            $result = mysqli_query($base, $query);
            if ($result)
                $INFO = 'Диск добавлен успешно';
            else
                $ERROR = mysqli_error($base);
        }
    }
} else if ($_SERVER["REQUEST_METHOD"] == "DELETE") {
    if (isset($_GET[$disk_id])) {
        $DISK_ID = mysqli_real_escape_string($base, $_GET[$disk_id]);
        $query = "DELETE FROM $table_disks_table WHERE $table_disks_disk_id=$DISK_ID";
        $result = mysqli_query($base, $query);
        if ($result)
            $INFO = 'Диск удален успешно';
        else
            $ERROR = mysqli_error($base);
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
            <?php
            include("../php/disks_table.php")
            ?>
        </div>
        <div class="card-body">
            <h1 class="mt-4">Удалить диск</h1>
            <form method="POST">
                <div class="form-group">
                    <label class="small mb-1" for="disk_id">Id диска</label>
                    <input class="form-control py-4" id="disk_id" name="disk_id" type="number" min="0" required/>
                </div>
                <div class="form-group mt-4 mb-0">
                    <input type="submit" class="btn btn-primary btn-block" value="Удалить">
                </div>
            </form>
        </div>
        <div class="card-body">
            <h1 class="mt-4">Добавить/обновить диск</h1>
            <form method="POST">
                <div class="form-group">
                    <label class="small mb-1" for="disk_id">Id диска (только для изменения существующего диска)</label>
                    <input class="form-control py-4" id="disk_id" name="disk_id" type="number" min="-1"/>
                </div>
                <div class="form-group">
                    <label class="small mb-1" for="model">Модель</label>
                    <input class="form-control py-4" id="model" name="model" type="text" required/>
                </div>
                <div class="form-group">
                    <label class="small mb-1" for="manufacturer">Производитель</label>
                    <input class="form-control py-4" id="manufacturer" name="manufacturer" type="text" required/>
                </div>
                <div class="form-group">
                    <label class="small mb-1" for="capacity">Ёмкость (Гб)</label>
                    <input class="form-control py-4" id="capacity" name="capacity" type="number" min="1" required/>
                </div>
                <div class="form-group">
                    <label class="small mb-1" for="transfer_rate">Скорость передачи данных (Мб/с)</label>
                    <input class="form-control py-4" id="transfer_rate" name="transfer_rate" type="number" min="1"
                           required/>
                </div>
                <div class="form-group">
                    <label class="small mb-1" for="interface">Интерфейс</label>
                    <input class="form-control py-4" id="interface" name="interface" type="text" required/>
                </div>
                <div class="form-group">
                    <label class="small mb-1" for="price">Цена</label>
                    <input class="form-control py-4" id="price" name="price" type="number" min="1" required/>
                </div>
                <div class="form-group">
                    <label class="small mb-1" for="description">Описание</label>
                    <input class="form-control py-4" id="description" name="description" type="text"/>
                </div>
                <div class="form-group mt-4 mb-0">
                    <input type="submit" class="btn btn-primary btn-block" value="Добавить/обновить">
                </div>
            </form>
        </div>
    </div>
<?php
include("../php/footer_admin.php");
