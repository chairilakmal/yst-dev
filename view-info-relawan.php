<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Icon Title -->
    <link rel="icon" href="img/YST-title.png">
    <title>YST - Info Relawan</title>
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
                            <li class="nav-item active  teks-biru">
                                <a class="nav-link " href="kontribusi.php">Informasi</a>
                            </li>
                            <li class="nav-item dropdown ">
                                <a class="nav-link current dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
                                <button class="btn radius-50 py-1.5 px-4 ml-3 btn-donasi " onclick="window.location.href='#'">Beri Bantuan</button>
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
                    <h1 class="mb-1 mt-4 mb-4">Informasi Bidang Relawan</h1><br>
                    <div class="mb-4 ">

                        <h2> 1. Bidang Charity & Community
                        </h2>
                        <img class="card-img-top bidang-relawan-vector" src="img/relawan1.jpg">
                        <span class="teks-paragraf">
                            <b>Deskripsi</b> : bidang yang membawahi kegiatan amal & komunitas, diprioritaskan untuk internal pegawai maupun pensiunan Telkom Group seperti :
                        </span>

                        <ul class="bidang-relawan-list mt-3 ml-4">
                            <li><b>Sahabat Sekar Berbagi</b> : kegiatan Sahabat YST terhadap komunitas yang Peduli pada lingkungan hidup (penghijauan, pengelolaan sampah), kesehatan (anak2 berkebutuhan khusus, penderita kanker/penyakit tidak menular), misal: komunitas wali pohon, komunitas sampah organik, komunitas orang tua anak berkebutuhan khusus (autis, down syndrome), komunitas penderita kanker, komunitas penderita katarak, komunitas sunatan masal, dll. </li>
                            <li><b>Sekar Fun</b> : kegiatan komunitas yang bersifat Fun terhadap hobby/passion, misal: komunitas lari (Fun Run), komunitas gowes/sepeda (Fun Bike), komunitas fotografi, komunitas paduan suara/karawitan/keroncong, dll. </li>
                            <li><b>Rumah Sekar Kreatif</b> : kegiatan komunitas yang bersifat Kreatif terhadap kebutuhan tempat tinggal, ekonomi, sosial, misal: komunitas rumah tinggal buat pensiunan yang tidak memiliki tempat tinggal layak, komunitas kewirausahaan bagi pegawai maupun pensiunan yang ingin berwirausaha, dll. </li>
                        </ul>
                    </div>
                    <div class="mb-4 ">

                        <h2> 2. Bidang Bencana
                        </h2>
                        <img class="card-img-top bidang-relawan-vector" src="img/relawan2.jpg">
                        <span class="teks-paragraf">
                            <b>Deskripsi</b>: bidang yang membawahi kegiatan jika ada bencana yang bersifat insidentil maupun emergency, yang meliputi kegiatan penyelamatan dan evakuasi korban, harta benda, pemenuhan kebutuhan dasar, perlindungan, pengurusan pengungsi, serta pemulihan sarana dan prasaran, diperuntukkan untuk internal maupun eksternal Telkom Group, dalam hal di luar bencana dapat dilakukan penyuluhan/training terhadap kesiapan menghadapi bencana yang kemungkinan akan terjadi, seperti:
                        </span>

                        <ul class="bidang-relawan-list mt-3 ml-4">
                            <li><b>Sekar Rescue</b> : kegiatan yang bersifat bantuan gerak cepat ketika terjadi bencana (Telkom Sekar Rescue dihidupkan lagi). </li>
                            <li><b>Sekar Healing</b> : kegiatan yang bersifat penyembuhan/penyuluhan trauma pasca bencana, misal: mendatangkan tim trauma healing. </li>
                            <li><b>Sekar Tanggap Bencana</b> : kegiatan yang bersifat bantuan terhadap bencana yang belum terjadi, bagaimana menghadapi kebakaran, gempa, banjir, tanah longsor, dll. </li>
                        </ul>
                    </div>
                    <div class="mb-4 ">
                        <h2> 3. Bidang Society

                        </h2>
                        <img class="card-img-top bidang-relawan-vector" src="img/relawan3.jpg">
                        <span class="teks-paragraf">
                            <b>Deskripsi</b> : bidang yang membawahi kegiatan sosial kemasyarakatan, diperuntukkan untuk eksternal Telkom Group, namun tidak tertutup kemungkinan bisa untuk pegawai maupun pensiunan Telkom Group, seperti:
                        </span>

                        <ul class="bidang-relawan-list mt-3 ml-4">
                            <li><b>PKBM (Pusat Kegiatan Belajar Masyarakat) Himmatul`Aliyyah</b> :<br>
                                Saat ini sudah ada Himatul Aliyah yaitu :
                                <ul class="ml-3">
                                    <li>PAUD</li>
                                    <li>Penitipan Anak/Day Care</li>
                                    <li>Pengajian TPQ : menyediakan tempat saja, membantu transportasi Guru Ngaji 300rb</li>
                                    <li>Kesetaraan : kejar (kelompok belajar) paket SD/SMP/SMA A,B,C</li>
                                    <li>Majelis Taklim</li>
                                    <li>Keterampilan PKK</li>
                                </ul>
                            </li>
                            <li><b>Bakti Bagi Negeri (BBN)</b> : Saat ini sudah ada BBN yang bergerak dalam pembagian buku2 pendidikan ke pelosok negeri & pengajaran ke anak2. Ini sudah berjalan sejak kpn, pengurusnya siapa saja. </li>
                            <li><b>Penyuluhan & Pemeriksaan Kesehatan Masyarakat</b> : Saat ini belum ada kegiatan ini. Misal: ada kegiatan posyandu/penimbangan/imunisasi wajib bayi di bawah 2 tahun, kegiatan home visit pegawai maupun pensiunan yang sedang sakit, kegiatan fogging, dll. </li>
                        </ul>
                    </div>
                </div>
                <!-- END PROFIL-->

                <div class="starter-template mb-5" id="profil-yst">
                    <h1 class="mb-1 mt-4 mb-4">Informasi Pendaftaran Relawan</h1><br>
                    <img class="card-img-top visi-misi-img" width="100%" src="img/dpw-jabar2.jpeg"><br>
                    <span class="teks-paragraf">
                        Proses pendaftaran relawan dilakukan di dalam website Yayasan Sekar Telkom. Sebelum mendaftar
                        kita harus <a href="register.php">registrasi akun</a> terlebih dahulu untuk dapat memilih <a href="relawan.php" target="_blank">program relawan</a> dan mengisi formulir pendaftaran.
                    </span>


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
                        <a href="#" target="_blank"><i class="fa fa-phone-square-alt"></i></a>
                        <a href="#" target="_blank"><i class="fas fa-envelope-square"></i></a>
                        <a href="#" target="_blank"><i class="fa fa-facebook-square"></i></a>
                        <a href="#" target="_blank"><i class="fa fa-instagram"></i></a>
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