<?php

$host        = "localhost"; //localhost server
$db_user     = "root"; //database username
$db_password = "root"; //database password
$db_name     = "yst1022"; //database name

global $conn;
$conn = mysqli_connect("$host", "$db_user", "$db_password", "$db_name");
date_default_timezone_set("Asia/Jakarta");

if (!$conn) {
    echo "Connection has failed";
}
