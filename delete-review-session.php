<?php
    //Hapus Session
    unset($_SESSION["nama_program_donasi"]);
    unset($_SESSION["nominal"]);
    unset($_SESSION["nama_donatur"]);
    header("Location: dashboard-user.php");
    exit;
?>