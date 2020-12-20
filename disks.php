<?php
$TITLE = "Каталог дисков";
include("php/head.php");
include("php/body.php");
include("php/disks_filter.php");
?>
    <div class="container-fluid">
        <h1 class="mt-4">Каталог дисков</h1>
        <div class="card mb-4">
            <!--            <div class="card-header">-->
            <!--                <i class="fas fa-table mr-1"></i>-->
            <!--            </div>-->
            <?php
            include("php/disks_table.php")
            ?>
            <div class="row">
                Выбрали себе диск? &nbsp; <a class="alert-link" href="new_order.php">Закажите его!</a>
            </div>
        </div>
    </div>
<?php
include("php/footer.php");
