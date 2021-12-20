<?php
    //Hapus Session
    unset($_SESSION["nama_program_relawan"]);
    unset($_SESSION["tgl_pelaksanaan"]);
    unset($_SESSION["lokasi"]);
    unset($_SESSION["titik_kumpul"]);
    unset($_SESSION["nama_lengkap"]);
    unset($_SESSION["no_hp"]);
    unset($_SESSION["email"]);
    unset($_SESSION["domisili"]);
    header("Location: program-relawan-saya.php");
    exit;

?>