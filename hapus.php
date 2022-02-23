<?php
include "config/connection.php";

$type = $_GET['type'];





if ($type == 'pdonasi') {
    //ambil id program di URL
    $id_program_donasi = $_GET["id_program_donasi"];

    mysqli_query($conn, "DELETE FROM t_program_donasi
                        WHERE  	id_program_donasi = $id_program_donasi");

    header('Location: dashboard-admin.php?status=deletesuccess');
    exit();
} elseif ($type == 'prelawan') {
    //ambil id program di URL
    $id_program_relawan = $_GET["id_program_relawan"];

    mysqli_query($conn, "DELETE FROM t_program_relawan
                            WHERE  	id_program_relawan = $id_program_relawan");

    header('Location: kelola-p-relawan.php?status=deletesuccess');
    exit();
} elseif ($type == 'donasi') {
    //ambil id program di URL
    $id_donasi = $_GET["id_donasi"];

    mysqli_query($conn, "DELETE FROM t_donasi
                            WHERE  	id_donasi = $id_donasi");

    header('Location: kelola-donasi.php?status=deletesuccess');
    exit();
} elseif ($type == 'relawan') {
    //ambil id program di URL
    $id_relawan = $_GET["id_relawan"];

    mysqli_query($conn, "DELETE FROM t_relawan
                            WHERE  	id_relawan = $id_relawan");

    header('Location: kelola-relawan.php?status=deletesuccess');
    exit();
} elseif ($type == 'berita') {
    //ambil id program di URL
    $id_berita = $_GET["id_berita"];

    mysqli_query($conn, "DELETE FROM t_berita
                            WHERE  	id_berita = $id_berita");

    header('Location: kelola-berita.php?status=deletesuccess');
    exit();
} elseif ($type == 'katdonasi') {
    $id_kat_donasi = $_GET["id_kat_donasi"];
    mysqli_query($conn, "DELETE FROM t_kat_donasi
                            WHERE  	id_kat_donasi = $id_kat_donasi");

    header('Location: kelola-kat-donasi.php?status=deletesuccess');
    exit();
} elseif ($type == 'katrelawan') {
    $id_kat_relawan = $_GET["id_kat_relawan"];
    mysqli_query($conn, "DELETE FROM t_kat_relawan
                            WHERE  	id_kat_relawan = $id_kat_relawan");

    header('Location: kelola-kat-relawan.php?status=deletesuccess');
    exit();
} elseif ($type == 'manageuser') {
    $id_user = $_GET["id_user"];
    mysqli_query($conn, "DELETE FROM t_user
                            WHERE  	id_user = $id_user");

    header('Location: kelola-user.php?status=deletesuccess');
    exit();
}
