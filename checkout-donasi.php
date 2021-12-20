<?php

    session_start();
    include 'config/connection.php';


    if(!isset($_SESSION["username"])) {
        header('Location: login.php?status=restrictedaccess');
        exit;
    }

    function rupiah($angka){
        $hasil_rupiah = "Rp. ".number_format($angka,0,'.','.');
        return $hasil_rupiah;
    }
  

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Icon Title -->
    <link rel="icon" href="img/logo-only.svg">
    <title>YST - Buat Donasi</title>
    <!-- Font Awesome
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css"> -->
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/b41ecad032.js" crossorigin="anonymous"></script>
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <link rel="stylesheet" type="text/css" href="css/dashboard-yst.css">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@400;600;700&family=Roboto:wght@500&display=swap" rel="stylesheet"> 

</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>
            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto user-wrapper"> 
                <img src="img/user-default.jpg" width="30px" height="30px" alt="">
                <li class="nav-item dropdown user-dropdown">  
                    <a class="nav-link dropdown-toggle pr-4" href="#" id="navbarDropdownMenuLink" 
                    role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?php echo("{$_SESSION['username']}");?>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">      
                        <a class="dropdown-item" href="logout.php">Logout</a>
                    </div>                   
                </li>
            </ul>
        </nav>
        <!-- /.Navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-background elevation-4">
            <!-- Brand Logo -->

            <a href="dashboard-user.php" class="brand-link">
                <img src="img/logo-only.svg"  class="brand-image mt-1">
                <span class="brand-text font-weight-bold mt-2"><i>Dashboard User</i></span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
           <!-- Sidebar Menu -->
                <nav class="mt-4">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
                        with font-awesome or any other icon font library -->
                        <li class="nav-item nav-item-sidebar menu-open">
                            <a href="dashboard-user.php" class="nav-link side-icon active ">
                                <i class="nav-icon fas fa-hand-holding-heart"></i>
                                <p>
                                    Donasi Saya
                                </p>
                            </a>
                        </li>
                        <li class="nav-item nav-item-sidebar">
                            <a href="program-relawan-saya.php" class="nav-link side-icon">
                                <i class="nav-icon fas fa-user-clock"></i>
                                <p>
                                    Program Relawan
                                </p>
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
        <main>
            <div class="page-title-link ml-4 mb-4">     
                        <div class="page-title-link ml-4 mb-4">     
                            <div class="page-title-link ml-4 mb-4">     
                                <a href="dashboard-user.php">
                                    <i class="nav-icon fas fa-home mr-1"></i>Dashboard user</a> > 
                                <a href="dashboard-user.php">
                                    <i class="nav-icon fas fa-user-cog mr-1"></i>Donasi saya</a> >
                                <a href="pilih-donasi.php">
                                    <i class="nav-icon fas fa-hand-holding-heart mr-1"></i>Buat Donasi</a> >
                                <a href="#" onclick="javascript:window.history.back(-1);return false;">
                                    <i class="nav-icon fas fa-info-circle mr-1"></i>Detail Donasi</a>
                            </div>
                        </div>  
                </div>               
                <div class="form-profil halaman-view">
                    <div class="mt-2 regis-title"><h3>Review Donasi</h3></div>    
                        <form action="" enctype="multipart/form-data" method="POST">
                            <div class="form-group label-txt">
                                <div class="mt-4">                                 
                                        <h5>Donasi berhasil dibuat ! Dengan rincian sebagai berikut : </h5>
                                </div>   
                                
                                <div class="form-group mt-4 mb-2">
                                    <label for="tb_nama_program_donasi" class="font-weight-bold" ><span class="label-form-span">Nama Program Donasi Pilihan</span></label><br>
                                    <input type="text" id="tb_nama_program_donasi" name="tb_nama_program_donasi" class="form-control" value="<?php echo $_SESSION['nama_program_donasi']?>" readonly>
                                </div>

                                <div class="form-group mt-3 mb-2">
                                    <label for="tb_nominal_program_donasi" class="font-weight-bold" ><span class="label-form-span">Nominal Donasi</span></label><br>
                                    <input type="text" id="tb_nominal_program_donasi" name="tb_nominal_program_donasi" class="form-control" value="<?php echo rupiah($_SESSION['nominal'])?>" readonly>
                                </div>
                                <div class="form-group mt-3 mb-2">
                                    <label for="nama_donatur" class="font-weight-bold" ><span class="label-form-span">Nama Donatur</span></label><br>
                                    <input type="text" id="tb_nama_donatur" name="tb_nama_donatur" class="form-control" value="<?php echo $_SESSION['nama_donatur']?>" readonly>
                                </div>    
                                <div class="mt-4">                                 
                                        Transfer ke nomor rekening berikut : Bank MANDIRI <strong>131-00-0458589-1</strong> (an. Yayasan Sekar Telkom)              
                                </div> 
                                <div class="mt-4">                                 
                                        <strong>PENTING :</strong> Mohon transfer tepat sampai 3 angka terakhir nominal donasi agar donasi Anda dapat diproses. Kode unik akan didonasikan.
                                        Anda akan menerima notifikasi ketika transaksi sudah kami terima.   
                                        
                                        <br><br>Anda juga dapat melihat tagihan donasi ini pada menu "Donasi Saya" atau pada email yang telah kami kirim kepada email Anda.
                                </div>       
                            </div>
          
                            <button type="submit" name="submit" value="Simpan" 
                            class="btn btn-lg btn-primary w-100 yst-login-btn border-0 mt-4 mb-4"
                            onclick="javascript:window.location.href='delete-review-session.php'; return false;"> 
                           
                                <span class="yst-login-btn-fs">OK</span>
                            </button>
                        </form>
                    </div>  
        </main>
        </div>
        <!-- /.container-fluid -->
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    
    <footer class="main-footer">
        <center><strong> &copy; YST 2021.</strong> Yayasan Sekar Telkom </center>
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>

    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- overlayScrollbars -->
    <script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.js"></script>
    <script type="text/javascript" src="js/buat-donasi.js"></script>


</body>

</html>