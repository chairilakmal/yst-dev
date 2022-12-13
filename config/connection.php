<?php

$host        = "localhost"; //localhost server
$db_user     = "root"; //database username
$db_password = ""; //database password
$db_name     = "yst"; //database name

global $conn;
$conn = mysqli_connect("$host", "$db_user", "$db_password", "$db_name");
date_default_timezone_set("Asia/Jakarta");

if (!$conn) {
    echo "tidak konek";
}
