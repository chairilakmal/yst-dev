<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Icon Title -->
    <link rel="icon" href="img/YST-title.png">
    <title>YST - Tentang Kami</title>
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
                                <a class="nav-link " href="index.php">Beranda</a>
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
                            <li class="nav-item dropdown">
                                <a class="nav-link current dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
                            <li class="nav-item dropdown  active  teks-biru ">
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



            <div class="halaman-about-top">
                <!-- PROFIL -->
                <div class="starter-template mt-5 py-5 " id="profil-yst">
                    <h1 class="mb-2">Yayasan Sekar Telkom</h1><br>
                    <img class="card-img-top visi-misi-img" width="100%" src="img/anggotayst.jpg"><br>


                    <p class="teks-paragraf"> <b>Yayasan Sekar Telkom (YST)</b> merupakan lembaga Nirlaba yang telah berdiri sejak tahun 2007, Bermula dari bencana nasional yang terjadi di aceh dan sumatera utara yang menggerakan semua potensi dan kepedulian yang tinggi terhadap sesama anak bangsa yang terkena musibah, termasuk didalamnya insan TELKOM.

                        Serikat Karyawan Telkom (SEKAR TELKOM) melalui program "SEKAR PEDULI" bersama managemen TELKOM menggerakan seluruh karyawan TELKOM untuk berpatisipasi dan berempati terhadap korban bencana nasional tersebut, dan karyawan telkom melalui program tersebut telah memperlihatkan kepedulian sosial yang begitu tinggi. Kepedulian tersebut kemudian dilanjutkan sampai sekarang dengan dibuatkan lembaga "Yayasan Sekar Telkom".
                    </p>

                </div>
                <!-- END PROFIL-->
            </div>
            <div class="halaman-about ">
                <!-- VISIMISI -->
                <div class="starter-template" id="visimisi">
                    <h1 class="mb-2">Visi Misi YST</h1><br>

                    <ol class="teks-paragraf mb-5">
                        <li>Melakukan identifikasi sasaran bantuan sosial kemanusiaan khususnya di Indonesia.</li>
                        <li>Menggalang partisipasi masyarakat baik individu, kelompok maupun Lembaga, untuk ikut membantu.
                            meringankan beban sosial masyarakat baik akibat berencana ataupun masyakarat tidak mampu.</li>
                        <li>Menggalang aksi bantuan cepat untuk korban bencana alam dan sosial, khususnya korban di daerah pengungsian.</li>
                        <li>Mengembankan pembangunan komunitas partisipatif untuk meningkatkan kemandirian korban bencana.
                            alam dan sosial dan masyakarat tidak mampu sehingga tercipta komunitas responsif.</li>
                    </ol>

                </div>
            </div>
            <!-- END VISIMISI -->

            <div class="halaman-about">
                <!-- STRUKTUR ORGANISASI -->
                <div class="starter-template">
                    <h1 class="mb-2">Struktur Organisasi YST</h1><br>
                    <!-- 1:1 aspect ratio -->

                    <!-- 1:1 aspect ratio -->
                    <img class="card-img-top struktur-organisasi-img edit-img popup" width="100%" src="img/struktur-yst.jpg"><br>
                </div>
                <!-- END STRUKTUR ORGANISASI-->
            </div>

            <div class="halaman-about">

                <div class="starter-template">
                    <h1 class="mt-3 mb-2 " id="kontak-yst">Kontak YST</h1><br>

                    <ul class="teks-paragraf mb-3 mt-3">
                        <li>Telp : +62 813-8940-0804</li>
                        <li>Email : sek.yst@gmail.com</li>
                        <li>Alamat : Jl. Wangsareja no.5 Paledang, Kec. Lengkong, Kota Bandung 40261</li>

                    </ul>

                </div>

                <div class="mb-5">

                    <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d7921.435187184181!2d107.6156629356318!3d-6.924322881932383!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68e62bdf7b7a5f%3A0xd23e535bae5370ed!2sYayasan%20Sekar%20Telkom!5e0!3m2!1sid!2sid!4v1636639668574!5m2!1sid!2sid" width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy"></iframe>

                </div>
            </div>







            <!-- Modal -->
            <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">Struktur Organisasi YST </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <img src="" id="popup-img" alt="image" class="w-100">
                        </div>
                    </div>
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


    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


    <script>
        $('.popup').click(function() {
            var src = $(this).attr('src');

            $('.modal').modal('show');
            $('#popup-img').attr('src', src);
        });
    </script>
</body>

</html>