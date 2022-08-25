<?php

// ini_set("display_errors", "1");
// error_reporting(E_ALL);

include "config/connection.php";

function rupiah($angka)
{
    $hasil_rupiah = "Rp. " . number_format($angka, 0, '.', '.');
    return $hasil_rupiah;
}

//Kegiatan
function queryKegiatan($query)
{
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}
$kegiatan = queryKegiatan("SELECT *
                    FROM t_berita 
                    WHERE kategori_berita = 0 AND status_berita = 2
                    ORDER BY id_berita 
                    DESC
                    ");

//Berita
function queryBerita($query)
{
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}
$berita = queryBerita("SELECT *
                    FROM t_berita 
                    WHERE kategori_berita = 1 AND status_berita = 2
                    ORDER BY id_berita 
                    DESC
                    ");

//Donasi
function queryDonasi($query)
{
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

$programDonasi = queryDonasi("SELECT *, SUM(t_donasi.nominal_donasi) AS dana_terkumpul_total, 
                    COUNT(id_user) 
                    AS jumlah_donatur 
                    FROM t_donasi 
                    RIGHT JOIN t_program_donasi 
                    ON t_program_donasi.id_program_donasi = t_donasi.id_program_donasi    
                    WHERE status_program_donasi = 'Berjalan'             
                    GROUP BY t_program_donasi.id_program_donasi ORDER BY t_program_donasi.id_program_donasi DESC
                    ");
// var_dump($programDonasi);die;

//Relawan
function queryRelawan($query)
{
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}


$programRelawan = queryRelawan("SELECT *, SUM(t_relawan.relawan_jadi) AS jumlah_relawan 
                    FROM t_relawan 
                    RIGHT JOIN t_program_relawan 
                    ON t_program_relawan.id_program_relawan = t_relawan.id_program_relawan  
                    WHERE status_program_relawan = 'Berjalan'             
                    GROUP BY t_program_relawan.id_program_relawan ORDER BY t_program_relawan.id_program_relawan DESC
                    ");
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Icon Title -->
    <link rel="icon" href="img/YST-title.png">
    <title>YST - Beranda</title>
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

<body>
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
                            <li class="nav-item active  teks-biru">
                                <a class="nav-link current" href="index.php">Beranda</a>
                            </li>
                            <li class="nav-item dropdown">
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
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Program YST
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                    <a class="dropdown-item" href="donasi.php">Program Donasi</a>
                                    <a class="dropdown-item" href="relawan.php">Program Relawan</a>
                                    <a class="dropdown-item" href="view-donasi.php?id=7">PKBM Himmatul 'Aliyyah</a>
                                    <a class="dropdown-item" href="view-donasi.php?id=8">Bakti Bagi Negeri</a>
                                    <a class="dropdown-item" href="view-donasi.php?id=9">Donor Darah</a>
                                    <a class="dropdown-item" href="view-donasi.php?id=10">Beasiswa</a>
                                    <a class="dropdown-item" href="view-donasi.php?id=11">Program DPW</a>
                                </div>
                            </li>
                            <li class="nav-item dropdown">
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

            <!-- Header Container -->
            <div class="header-tkjb">
                <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner berbagi-banner">
                        <div class="carousel-item active">
                            <img class="d-block w-100" src="img/slide2.jpg" alt="First slide">
                            <div class="carousel-caption  d-md-block">
                                <center>
                                    <h3>BERBAGI MAKIN MUDAH</h3><br>
                                    <p>
                                        Berbagi bersama YST semakin mudah hanya dengan lewat smartphone
                                    </p><br>
                                    <a href="kontribusi.php" class="btn btn-link-slide py-2" role="button" aria-pressed="true">
                                        Simak Caranya
                                    </a>
                                </center>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
            <!-- End Header Container -->

            <div class="tkjb-card">
                <!-- 1ST BODY CONTAINER -->
                <div class="starter-template">
                    <h1 class="mb-2">Yayasan Sekar Telkom</h1><br>
                    <p class="teks-paragraf"><b>YST</b> (Yayasan Sekar Telkom) merupakan lembaga nirlaba yang telah berdiri sejak tahun 2007,
                        Serikat Karyawan Telkom (SEKAR TELKOM) melalui program "SEKAR PEDULI" bersama managemen TELKOM menggerakan seluruh karyawan TELKOM untuk mewujudkan kepedulian kepada masyarakat di lingkungannya.
                        Terutama kepada masyarakat yang terkena bencana dan masyarakat tidak mampu dengan tindakan nyata dalam bentuk program-program bantuan sosial dan pemberdayaan masyarakat.
                    </p>
                    <!-- 1:1 aspect ratio -->
                    <div class="embed-responsive embed-responsive-4by3 video-intro">
                        <iframe width="560" height="315" src="https://www.youtube.com/embed/_jusW-0G8-Y" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>
                </div>
                <!-- END 1st PARAGRAPH -->
            </div>

            <!-- Berita TERBARU -->
            <div class="tkjb-card2">
                <h2> Berita Terbaru </h2>
                <div class="row card-deck">
                    <?php foreach (array_slice($berita, 0, 3) as $row) : ?>
                        <div class="col-md-4">
                            <div class="card card-pilihan mb-4 shadow-sm">
                                <a href="">
                                    <img class="card-img-top berita-img" width="100%" src="img/<?= $row['gambar_berita']; ?>">
                                </a>
                                <div class="card-body">
                                    <div class="nama-program">
                                        <p>
                                        <h5 class="max-length2"><?= $row["judul_berita"]; ?></h5>
                                        </p>
                                    </div>
                                    <div class="d-flex justify-content-between dana-donatur-row-bottom mb-3">
                                        <div class="float-left waktu-tulis">Ditulis pada <?= date("d-m-Y", strtotime($row["tgl_penulisan"])); ?> </div>

                                    </div>
                                    <a class="btn btn-primary btn-lg btn-block mb-4 btn-kata-media" href="view-kegiatan.php?id=<?php echo $row['id_berita']; ?>">Lihat Kegiatan</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="mid-button">
                    <a href="berita.php" class="btn radius-50 py-1.5 px-5  btn-relawan" role="button" aria-pressed="true">
                        Selengkapnya >
                    </a>
                </div>
            </div>
            <!-- END KEGIATAN TERBARU -->

            <!-- Kegiatan TERBARU -->
            <div class="tkjb-card">
                <h2> Kegiatan Terbaru </h2>
                <div class="row card-deck">
                    <?php foreach (array_slice($kegiatan, 0, 3) as $row) : ?>
                        <div class="col-md-4">
                            <div class="card card-pilihan mb-4 shadow-sm">
                                <a href="">
                                    <img class="card-img-top berita-img" width="100%" src="img/<?= $row['gambar_berita']; ?>">
                                </a>
                                <div class="card-body">
                                    <div class="nama-program">
                                        <p>
                                        <h5 class="max-length2"><?= $row["judul_berita"]; ?></h5>
                                        </p>
                                    </div>
                                    <div class="d-flex justify-content-between dana-donatur-row-bottom mb-3">
                                        <div class="float-left waktu-tulis">Ditulis pada <?= date("d-m-Y", strtotime($row["tgl_penulisan"])); ?> </div>

                                    </div>
                                    <a class="btn btn-primary btn-lg btn-block mb-4 btn-kata-media" href="view-berita.php?id=<?php echo $row['id_berita']; ?>">Lihat Berita</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="mid-button">
                    <a href="kegiatan.php" class="btn radius-50 py-1.5 px-5  btn-relawan" role="button" aria-pressed="true">
                        Selengkapnya >
                    </a>
                </div>
            </div>
            <!-- END BERITA TERBARU -->

            <!-- PROGRAM DONASI -->
            <div class="tkjb-card2">
                <h2> Program Donasi </h2>
                <div class="row card-deck">
                    <?php foreach (array_slice($programDonasi, 0, 3) as $row) : ?>
                        <div class="col-md-4">
                            <div class="card card-pilihan mb-4 shadow-sm">
                                <a href="">
                                    <img class="card-img-top berita-img" width="100%" src="img/<?= $row['foto_p_donasi']; ?>">
                                </a>
                                <div class="card-body">
                                    <div class="nama-program">
                                        <p>
                                        <h5 class="max-length2"><?= $row["nama_program_donasi"]; ?></h5>
                                        </p>
                                    </div>
                                    <!-- <div class="d-flex justify-content-between dana-donatur-row-top mt-2">
                                        <div class="float-left">Terkumpul</div>
                                        <div>Donatur</div>
                                    </div> -->
                                    <!-- <div class="d-flex justify-content-between dana-donatur-row-bottom mb-3"> -->
                                    <!-- <div class="float-left">
                                            ?= rupiah($row['dana_terkumpul_total']) == 0 ? '0' : rupiah($row['dana_terkumpul_total']); ?> 
                                        </div>
                                        <div>?= $row["jumlah_donatur"]; ?></div>
                                    </div> -->
                                    <a class="btn btn-primary btn-lg btn-block mb-4 btn-kata-media" href="view-donasi.php?id=<?php echo $row['id_program_donasi']; ?>">Lihat Program</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="mid-button">
                    <a href="donasi.php" class="btn radius-50 py-1.5 px-5  btn-relawan" role="button" aria-pressed="true">
                        Selengkapnya >
                    </a>
                </div>
            </div>
            <!-- END PROGRAM DONASI -->

            <!-- PROGRAM RELAWAN -->
            <div class="tkjb-card">
                <h2> Program Relawan </h2>
                <div class="row card-deck">
                    <?php foreach (array_slice($programRelawan, 0, 3) as $row2) : ?>
                        <div class="col-md-4">
                            <div class="card card-pilihan mb-4 shadow-sm">
                                <a href="">
                                    <img class="card-img-top berita-img" width="100%" src="img/<?= $row2['foto_p_relawan']; ?>">
                                </a>
                                <div class="card-body">
                                    <div class="nama-program">
                                        <p>
                                        <h5 class="max-length2"><?= $row2["nama_program_relawan"]; ?></h5>
                                        </p>
                                    </div>
                                    <!-- <div class="d-flex justify-content-between dana-donatur-row-top mt-2">
                                        <div class="float-left">Jumlah Relawan</div>
                                        <div>Target Relawan</div>
                                    </div>
                                    <div class="d-flex justify-content-between dana-donatur-row-bottom mb-3">
                                        <div class="float-left">?= $row2['jumlah_relawan'] == 0 ? '0' : $row2['jumlah_relawan']; ?></div>
                                        <div>?= $row2["target_relawan"]; ?></div>
                                    </div> -->
                                    <a class="btn btn-primary btn-lg btn-block mb-4 btn-kata-media" href="view-relawan.php?id=<?php echo $row2['id_program_relawan']; ?>">Lihat Program</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="mid-button">
                    <a href="relawan.php" class="btn radius-50 py-1.5 px-5  btn-relawan" role="button" aria-pressed="true">
                        Selengkapnya >
                    </a>
                </div>
            </div>
            <!-- END PROGRAM RELAWAN -->
        </div>
        <!-- END OF BODY CONTAINER -->
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