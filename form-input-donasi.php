<?php

    session_start();
    include 'config/connection.php';


    if(!isset($_SESSION["username"])) {
        header('Location: login.php?status=restrictedaccess');
        exit;
    }
    $id_program_donasi = $_GET["id"];

    $query      = mysqli_query($conn, "SELECT * FROM t_program_donasi WHERE id_program_donasi = $id_program_donasi");
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
                            <button class="btn radius-50 py-1.5 px-4 ml-3 btn-donasi " onclick="window.location.href=#'">Beri Bantuan</button>                       
                            <button class="btn radius-50 py-1.5 px-5 ml-3 btn-relawan " onclick="window.location.href='login.php'">Login</button>
                            
                        </ul>
                    <!-- END Navbar First Layer -->
                    <!-- Navbar Second Layer -->
                    <div class="navbar-tkjb-navigation col px-0 collapse navbar-collapse" id="navbarTogglerDemo02">
                        <!-- Navbar Menu -->
                        <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                            <li class="nav-item   ">
                                <a class="nav-link current" href="index.php">Beranda</a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link " href="berita.php">Berita</a>
                            </li>
                            <li class="nav-item active teks-biru">
                                <a class="nav-link " href="donasi.php">Donasi</a>
                            </li>  
                            <li class="nav-item ">
                                <a class="nav-link " href="relawan.php">Relawan</a>
                            </li> 
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Tentang YST
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <a class="dropdown-item" href="#" target="_blank">Profil</a>
                                <a class="dropdown-item" href="#">Visi Misi</a>
                                <a class="dropdown-item" href="#">Kontak</a>
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
            <div class="halaman-view mt-5 ">
                <div class="mt-4 regis-title"><h3>Daftar Akun</h3></div>
                <form action="" enctype="multipart/form-data" method="POST">
                    <div class="form-group">
                        
                        <div class="form-group mt-4 mb-2">
                             <label for="gender" class="font-weight-bold" ><span class="label-form-span">Pilih Nominal Donasi</span></label><br>
                            <input type="text" id="tb_nama_user" name="tb_nama_user" class="form-control" placeholder="Nama Program Donasi">
                        </div>

                        <div class="form-group mt-3 mb-5 ">
                            <label for="gender" class="font-weight-bold" ><span class="label-form-span">Pilih Nominal Donasi</span></label><br>
                            <div class="radio-wrapper mt-1">
                                <div class="form-check form-check-inline">
                                    <input type="radio" id="gender" name="gender" value="Pria" class="form-check-input" checked>
                                    <label class="form-check-label" for="gender">Rp. 10.000</label>
                                </div>
                            </div>
                            <div class="radio-wrapper mt-1">
                                <div class="form-check form-check-inline">
                                    <input type="radio" id="gender" name="gender" value="Pria" class="form-check-input" checked>
                                    <label class="form-check-label" for="gender">Rp. 20.000</label>
                                </div>
                            </div>
                            <div class="radio-wrapper2 mt-1">
                                <div class="form-check form-check-inline">
                                    <input type="radio" id="gender" name="gender" value="Wanita" class="form-check-input">
                                    <label class="form-check-label" for="gender">Rp. 50.000</label>
                                </div>
                            </div>
                            <div class="radio-wrapper mt-1">
                                <div class="form-check form-check-inline">
                                    <input type="radio" id="gender" name="gender" value="Pria" class="form-check-input" checked>
                                    <label class="form-check-label" for="gender">Rp. 100.000</label>
                                </div>
                            </div>
                            <div class="form-group mt-3 mb-2">
                            <label for="gender" class="font-weight-bold" ><span class="label-form-span">Pilih Nominal Donasi</span></label><br>
                            <input type="number" id="num_nomer_hp" name="num_nomer_hp" class="form-control" placeholder="Nomor telepon">
                            </div>
                            <div class="form-group mt-3 mb-2">
                                <label for="gender" class="font-weight-bold" ><span class="label-form-span">Nama Donatur</span></label><br>
                                <input type="text" id="tb_nama_user" name="tb_nama_user" class="form-control" placeholder="Nama Donatur">
                            </div>
                        </div>

                    </div>
                    <a class="btn btn-primary btn-lg btn-block mb-4 btn-kata-media" href="">Buat Donasi</a>
                </form>   
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
                    <a href="#" target="_blank"><i class="fa fa-phone-square-alt"></i></a> 
                    <a href="#" target="_blank"><i class="fas fa-envelope-square"></i></a> 
                    <a href="#" target="_blank"><i class="fa fa-facebook-square"></i></a> 
                    <a href="#" target="_blank"><i class="fa fa-instagram"></i></a>
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