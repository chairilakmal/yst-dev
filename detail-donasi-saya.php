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

    $id_donasi = $_GET["id_donasi"];
    // var_dump($id_donasi);die;

    //fungsi GET Array
    function query($query){
        global $conn;
         $result = mysqli_query($conn, $query); 
         $rows = [];
         while($row = mysqli_fetch_assoc($result)){
             $rows[] = $row;
         }
         return $rows;
    }

    $result = query("SELECT * FROM t_donasi WHERE id_donasi = $id_donasi")[0];

    // var_dump($programDonasi);die;

    // $query      = mysqli_query($conn, "SELECT * FROM t_program_donasi WHERE id_program_donasi = $id_program_donasi");
    // $result     = mysqli_fetch_array($query);

    //  if(isset($_POST["submit"])) {
        
    //     $id_program_donasi        = $_GET["id"];
    //     $status_donasi            = "Menunggu Verifikasi";
    //     $nama_program_donasi      = $_POST["tb_nama_program_donasi"]; 
    //     $tgl_donasi               = date ('Y-m-d', time());
    //     $nominal1                 = $_POST["nominal1"]; 
    //     $nominal2                 = $_POST["nominal2"]; 
    //     $totalNominal             = $nominal1 + $nominal2;
    //     $nama_donatur             = $_POST["tb_nama_donatur"]; 
    //     $id_user                  = $_SESSION['id_user'];
        

    //     // var_dump($id_user);die;
        
    //     $query = "INSERT INTO t_donasi
    //                 VALUES 
    //               ('','$status_donasi','$nama_donatur','$totalNominal ','$id_user','$id_program_donasi',' $nama_program_donasi  ','$tgl_donasi')  
    //                 ";
     
    //     mysqli_query($conn,$query);
    //     // var_dump($query);die;

    //     //cek keberhasilan
    //     if(mysqli_affected_rows($conn) > 0 ){
    //         echo "
    //         <script>
    //             alert('Data berhasil ditambahkan!');
    //         </script>
    //         ";
    //     }else{
    //         echo "
    //             <script>
    //                 alert('Data gagal ditambahkan!');
    //             </script>
    //         ";
    //     }

    // }

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
                                <a href="#" onclick="javascript:window.history.back(-1);return false;">
                                    <i class="nav-icon fas fa-info-circle mr-1"></i>Detail Donasi</a>
                            </div>
                        </div>  
                </div>               
                <div class="form-profil halaman-view">
                    <div class="mt-2 regis-title"><h3>ID Donasi :<?php echo $result['id_donasi']?></h3></div>    
                        <form action="" enctype="multipart/form-data" method="POST">
                            <div class="form-group label-txt">
                                <div class="form-group mt-2 mb-2" id="tb_tgl_donasi">
                                <label for="tb_tgl_donasi" class="font-weight-bold" ><span class="label-form-span">Tanggal Donasi</span></label><br>
                                    <input type="date" id="tb_tgl_donasi" name="tb_tgl_donasi" class="form-control" value="<?= $result["tgl_donasi"]; ?>" readonly>
                                </div>
                                <div class="form-group mt-2 mb-2">
                                    <label for="tb_nama_program_donasi" class="font-weight-bold" ><span class="label-form-span">Program Donasi Pilihan</span></label><br>
                                    <input type="text" id="tb_nama_program_donasi" name="tb_nama_program_donasi" class="form-control" 
                                    value="<?php echo $result['nama_program_donasi']?>" readonly>
                                </div>   
                                <div class="form-group mt-2 mb-2" id="buatNominal">
                                    <label for="nominal2" class="font-weight-bold" ><span class="label-form-span">Nominal Donasi</span></label><br>
                                    <input type="text" id="nominal2" name="nominal2" class="form-control" 
                                    value="<?php echo rupiah($result['belum_dibayar'])?>" readonly>
                                </div>
                                <div class="form-group mt-3 mb-2">
                                    <label for="nama_donatur" class="font-weight-bold" ><span class="label-form-span">Nama Donatur</span></label><br>
                                    <input type="text" id="tb_nama_donatur" name="tb_nama_donatur" class="form-control" 
                                    value="<?php echo $result['nama_donatur']?>" readonly>
                                </div> 
                                <div class="form-group mt-3 mb-2">
                                    <label for="tb_status_donasi" class="font-weight-bold" ><span class="label-form-span">Status Donasi</span></label><br>
                                    <input type="text" id="tb_status_donasi" name="tb_status_donasi" class="form-control" 
                                    value="<?php echo $result['status_donasi']?>" readonly>
                                </div>           
                            </div>

                        </form>
                        <div class="garis-atas">
                                <p>
                                    Mohon transfer <b>tepat</b> sebesar nominal donasi ke rekening berikut :
                                </p>
                                <p>
                                    <b>BANK MANDIRI 131-00-0458589-1 : a/n YAYASAN SEKAR TELKOM</b>
                                </p>
                            </div>
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



</body>

</html>