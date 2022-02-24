<?php

include "config/connection.php";
$id_program_donasi = $_GET["id"];

$id_program_relawan = $_GET["id"];

$query      = mysqli_query($conn, "SELECT *, (SELECT SUM(relawan_jadi) 
                FROM t_relawan WHERE id_program_relawan = $id_program_relawan) 
                AS jumlah_relawan FROM t_program_relawan
                WHERE id_program_relawan = $id_program_relawan");
$result     = mysqli_fetch_array($query);


// var_dump($result);die;

?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Icon Title -->
    <link rel="icon" href="img/YST-title.png">
    <title>YST - Program Relawan</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/konten-yst.css">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500&family=Roboto:wght@500&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/b41ecad032.js" crossorigin="anonymous"></script>
</head>

<body style="background-color:#ebedf3;">
    <div class="informational">
        <div class="informational-container">
            <!-- Navbar Container-->
            <div class="navbar-tkjb fixed-top">
                <!-- Navbar -->
                <nav class="flex-wrap navpadd navbar navbar-expand-lg navbar-light ">
                    <!-- Navbar First Layer -->
                    <!-- Logo Holder -->
                    <a class="navbar-brand" href="index.php">
                        <img id="logo-tkjb-navbar" src="img/YST-logo.png">
                    </a>
                    <!-- Menu Toogler -->
                    <button class="navbar-toggler custom-toggler hamburger-menu" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon "></span>
                    </button>
                    <!-- Button & Link Action -->
                    <ul class="ml-auto d-none d-lg-block navbar-nav">
                        <!-- <button class="btn radius-50 py-1.5 px-4 ml-3 btn-donasi " onclick="window.location.href=#'">Beri Bantuan</button>                        -->
                        <button class="btn radius-50 py-1.5 px-5 ml-3 btn-relawan " onclick="window.location.href='login.php'">Login</button>

                    </ul>
                    <!-- END Navbar First Layer -->
                    <!-- Navbar Second Layer -->
                    <div class="navbar-tkjb-navigation col px-0 collapse navbar-collapse" id="navbarTogglerDemo02">
                        <!-- Navbar Menu -->
                        <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                            <li class="nav-item ">
                                <a class="nav-link current" href="index.php">Beranda</a>
                            </li>
                            <li class="nav-item dropdown ">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Artikel
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                    <a class="dropdown-item" href="kegiatan.php">Kegiatan</a>
                                    <a class="dropdown-item" href="berita.php">Berita</a>
                                </div>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link " href="kontribusi.php">Informasi</a>
                            </li>
                            <li class="nav-item dropdown active  teks-biru">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Program YST
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                    <a class="dropdown-item " href="donasi.php">Program Donasi</a>
                                    <a class="dropdown-item" href="relawan.php">Program Relawan</a>
                                    <a class="dropdown-item" href="view-donasi.php?id=7">PKBM Himmatul 'Aliyyah</a>
                                    <a class="dropdown-item" href="view-donasi.php?id=8">Bakti Bagi Negeri</a>
                                    <a class="dropdown-item" href="view-donasi.php?id=9">Donor Darah</a>
                                    <a class="dropdown-item" href="view-donasi.php?id=10">Beasiswa</a>
                                    <a class="dropdown-item" href="view-donasi.php?id=11">Program DPW</a>
                                </div>
                            </li>
                            <li class="nav-item dropdown ">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Tentang YST
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                    <a class="dropdown-item" href="profil.php#profil-yst">Profil</a>
                                    <a class="dropdown-item" href="profil.php#visimisi">Visi Misi</a>
                                    <a class="dropdown-item" href="profil.php#kontak-yst">Kontak</a>
                                </div>
                            </li>
                        </ul>
                        <!-- END Navbar Menu -->
                        <!-- Navbar Button & Link Action Mobile Version-->
                        <div class="d-flex d-lg-none p-3 mobile-act-button">
                            <div class="row-mid">
                                <button class="btn radius-50 py-1.5 px-4 ml-3 btn-donasi " onclick="window.location.href='kontribusi.php'">Beri Bantuan</button>
                            </div>
                            <div class="row-mid d-none d-md-block">
                                <p>

                                </p>
                            </div>
                            <div class="row-mid">
                                <button class="btn radius-50 py-1.5 px-5 ml-3 btn-relawan " onclick="window.location.href='login.php'">Login</button>
                            </div>
                        </div>
                        <!-- END Navbar Button & Link Action Mobile Version-->
                    </div>
                    <!-- END Navbar Second Layer -->
                </nav>
                <!-- END Navbar -->
            </div>
            <!-- END Navbar Container -->
            <div class="halaman-view mt-5 ">
                <img class="card-img-top halaman-view-img" width="100%" src="img/<?= $result['foto_p_relawan']; ?>">
                <div class="view-desc-singkat mt-2">
                    <h2 class="mt-4"><?php echo $result['nama_program_relawan'] ?></h2>
                    <p>
                        <?php echo $result['deskripsi_singkat_relawan'] ?>
                    </p>
                    <!-- <div class="d-flex view-kumpulan  mb-3">
                        <div class="float-left ">
                            <span class="value-penting">?php echo $result['jumlah_relawan'] == 0 ? '0' : $result['jumlah_relawan'] ?>
                            </span>
                            Relawan telah mendaftar dari total kebutuhan
                            <span class="value-penting">
                                ?php echo $result['target_relawan'] ?>
                            </span>
                            Relawan
                        </div>
                    </div> -->
                    <div class="d-flex view-kumpulan  mb-3">
                        <div class="float-left">Kegiatan relawan akan dilaksanakan di <b><?php echo $result['lokasi_program'] ?></b>
                            pada tanggal
                            <b><?php echo date("d-m-Y", strtotime($result['tgl_pelaksanaan'])); ?></b>
                        </div>
                    </div>

                </div>
                <div class="view-desc-lengkap mt-4">
                    <h4 class="mt-4"> Infomasi Program</h4>
                    <p>
                        <?php echo $result['deskripsi_lengkap_relawan'] ?>
                    </p>
                    <a class="btn btn-primary btn-lg btn-block mb-4 btn-kata-media" href="login.php?status=restrictedaccess">Daftar Sekarang</a>
                </div>
            </div>



        </div>
    </div>

    <!-- Footer -->
    <section id="footer">
        <div class="row">
            <div class="blogo col-xs-12 col-sm-12 col-md-12 col-lg-4">
                <a href="#"><img src="img/YST-logo.png" id="footer-logo"></a>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 cr-tkjb">
                <div class="cpt text-light text-center">
                    <p>© 2021 - Yayasan Sekar Telkom</p>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                <div class="ftaw text-light text-center">
                    <a href="#"><i class="fa fa-phone-square-alt"></i></a>
                    <a href="#"><i class="fas fa-envelope-square"></i></a>
                    <a href="#"><i class="fa fa-facebook-square"></i></a>
                    <a href="#"><i class="fa fa-instagram"></i></a>
                </div>
            </div>
        </div>
    </section>
    <!-- End Footer -->

    <!-- Bootstrap JS & JQuery -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>