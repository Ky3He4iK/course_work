<?php
if (isset($_ENV["db_hostname"]))
    $hostname = $_ENV["db_hostname"];
else
    $hostname = "localhost";
if (isset($_ENV["db_username"]))
    $hostname = $_ENV["db_username"];
else
    $username = "disks_user_142";
if (isset($_ENV["db_password"]))
    $hostname = $_ENV["db_password"];
else
    $password = "mysecret_password_956";
if (isset($_ENV["db_dbname"]))
    $hostname = $_ENV["db_dbname"];
else
    $dbName = "disks_db_736";

$base = mysqli_connect($hostname, $username, $password) or die("Ошибка соединения с базой данных");
mysqli_select_db($base, $dbName) or die(mysqli_error($base));
mysqli_set_charset($base, 'utf8');

$table_users_table = 'USERS';
$table_users_id = 'id';
$table_users_login = 'login';
$table_users_name = 'user_name';
$table_users_password = 'password';
$table_users_salt = 'salt';
$table_users_is_admin = 'is_admin';

$table_disks_table = 'DISKS';
$table_disks_id = 'id';
$table_disks_manufacturer = 'manufacturer';
$table_disks_model = 'model';
$table_disks_description = 'description';
$table_disks_capacity = 'capacity';
$table_disks_price = 'price';
$table_disks_transfer_rate = 'transfer_rate';
$table_disks_interface = 'interface';

$table_orders_table = 'ORDERS';
$table_orders_order_id = 'order_id';
$table_orders_user_id = 'user_id';
$table_orders_price = 'price';
$table_orders_delivery_address = 'delivery_address';
$table_orders_additional_info = 'additional_info';
$table_orders_city = 'city';

$table_orders_details_table = 'ORDER_DETAILS';
$table_orders_details_order_id = 'order_id';
$table_orders_details_disk_id = 'disk_id';
$table_orders_details_disk_count = 'disk_count';
