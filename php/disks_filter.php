<?php

$filter = '1=1 ';
$disk_id = 'disk_id';
$manufacturer = 'manufacturer';
$model = 'model';
$capacity = 'capacity';
$price = 'price';
$transfer_rate = 'transfer_rate';
$interface = 'interface';

if (isset($_GET[$manufacturer]) && strlen($_GET[$manufacturer]) > 0) {
    $MANUFACTURER = mysqli_real_escape_string($base, $_GET[$manufacturer]);
    $filter = $filter . " and " . $table_disks_manufacturer . "='" . $MANUFACTURER . "' ";
}
if (isset($_GET[$model]) && strlen($_GET[$model]) > 0) {
    $MODEL = mysqli_real_escape_string($base, $_GET[$model]);
    $filter = $filter . " and " . $table_disks_model . "='" . $MODEL . "' ";
}
if (isset($_GET[$interface]) && strlen($_GET[$interface]) > 0) {
    $INTERFACE = mysqli_real_escape_string($base, $_GET[$interface]);
    $filter = $filter . " and " . $table_disks_interface . "='" . $INTERFACE . "' ";
}
if (isset($_GET[$capacity]) && strlen($_GET[$capacity]) > 0) {
    $CAPACITY = mysqli_real_escape_string($base, $_GET[$capacity]);
    $filter = $filter . " and " . $table_disks_capacity . "='" . $CAPACITY . "' ";
}
if (isset($_GET[$price]) && strlen($_GET[$price]) > 0) {
    $PRICE = mysqli_real_escape_string($base, $_GET[$price]);
    $filter = $filter . " and " . $table_disks_price . "='" . $PRICE . "' ";
}
if (isset($_GET[$transfer_rate]) && strlen($_GET[$transfer_rate]) > 0) {
    $TRANSFER_RATE = mysqli_real_escape_string($base, $_GET[$transfer_rate]);
    $filter = $filter . " and " . $table_disks_transfer_rate . "='" . $TRANSFER_RATE . "' ";
}
