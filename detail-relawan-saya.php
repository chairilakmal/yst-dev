<?php

    session_start();
    include 'config/connection.php';


    if(!isset($_SESSION["username"])) {
        header('Location: login.php?status=restrictedaccess');
        exit;
    }

    $id_relawan = $_GET["id_relawan"];
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

                        
    $result = query("SELECT * FROM t_relawan
                      LEFT JOIN t_program_relawan ON t_relawan.id_program_relawan = t_program_relawan.id_program_relawan
                      WHERE id_relawan = $id_relawan ")[0];
    // $result = query("SELECT * FROM t_relawan WHERE id_relawan = $id_relawan")[0];

    //UPDATE
    if(isset($_POST["submit"])) {

        $status_relawan      = $_POST["status_relawan"];
        $relawan_jadi        = '';

        if($status_donasi = "Segera Berjalan"){
            $relawan_jadi = 1;
        }

        $query = "UPDATE t_relawan SET
              
                    status_relawan      = '$status_relawan',
                    relawan_jadi        = '$relawan_jadi'
                  WHERE id_relawan      = $id_relawan

                ";
    
        mysqli_query($conn, $query);

        //cek keberhasilan
        if(mysqli_affected_rows($conn) > 0 ){
            echo "
            <script>
                alert('Data berhasil diubah!');
                window.location.href = 'kelola-donasi.php'; 
            </script>
        ";
        }else{
            echo "
                <script>
                    alert('Data gagal diubah!');
                </script>
            ";
        }

    }

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Icon Title -->
    <link rel="icon" href="img/logo-only.svg">
    <title>YST - Program Relawan Saya</title>
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
                        <li class="nav-item nav-item-sidebar">
                            <a href="dashboard-user.php" class="nav-link side-icon  ">
                                <i class="nav-icon fas fa-hand-holding-heart"></i>
                                <p>
                                    Donasi Saya
                                </p>
                            </a>
                        </li>
                        <li class="nav-item nav-item-sidebar menu-open">
                            <a href="program-relawan-saya.php" class="nav-link side-icon active">
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
                            <a href="dashboard-user.php">
                                <i class="nav-icon fas fa-home mr-1"></i>Dashboard user</a> > 
                            <a href="program-relawan-saya.php">
                                <i class="nav-icon fas fa-hand-holding-heart mr-1"></i>Program relawan</a> >
                            <a href="#" onclick="javascript:window.history.back(-1);return false;">
                                    <i class="nav-icon fas fa-info-circle mr-1"></i>Detail Program Relawan</a>
                        </div>
                </div>               
                <div class="form-profil halaman-view">
                    <div class="mt-2 regis-title"><h3>Kelola Relawan</h3></div>    
                        <form action="" enctype="multipart/form-data" method="POST">
                            <div class="form-group label-txt">
                                <input type="hidden" id="tb_relawan_pending" name="tb_relawan_pending" class="form-control" value="1">
                                <div class="form-group mt-4 mb-2">
                                    <label for="tb_nama_program_relawan" class="font-weight-bold" ><span class="label-form-span">Program Pilihan</span></label><br>
                                    <input type="text" id="tb_nama_program_relawan" name="tb_nama_program_relawan" class="form-control" value="<?php echo $result['nama_program_relawan']?>" readonly>
                                </div>
                                <div class="form-group mt-4 mb-3">
                                <label for="tb_tgl_pelaksanaan" class="font-weight-bold" ><span class="label-form-span">Tanggal Pelaksanaan</span></label><br>
                                    <input type="date" id="tb_tgl_pelaksanaan" name="tb_tgl_pelaksanaan" class="form-control" value="<?= $result["tgl_pelaksanaan"]; ?>" readonly>
                                </div>
                                 <div class="form-group mt-4 mb-2">
                                    <label for="tb_lokasi_program" class="font-weight-bold" ><span class="label-form-span">Lokasi Pelaksanaan</span></label><br>
                                    <input type="text" id="tb_lokasi_program" name="tb_lokasi_program" class="form-control" value="<?php echo $result['lokasi_program']?>" readonly>
                                </div>
                                 <div class="form-group mt-4 mb-2">
                                    <label for="tb_lokasi_awal" class="font-weight-bold" ><span class="label-form-span">Titik Kumpul</span></label><br>
                                    <input type="text" id="tb_lokasi_awal" name="tb_lokasi_awal" class="form-control" value="<?php echo $result['lokasi_awal']?>" readonly>
                                </div>
                                <div class="form-group mt-4 mb-2">
                                    <label for="tb_nama_lengkap" class="font-weight-bold" ><span class="label-form-span">Nama Relawan</span></label><br>
                                    <input type="text" id="tb_nama_lengkap" name="tb_nama_lengkap" class="form-control" value="<?php echo $result['nama_lengkap']?>" readonly>
                                </div>
                                <div class="form-group mt-4 mb-2">
                                    <label for="tb_no_hp" class="font-weight-bold" ><span class="label-form-span">Nomor Telepon</span></label><br>
                                    <input type="text" id="tb_no_hp" name="tb_no_hp" class="form-control" value="<?php echo $result['no_hp']?>" readonly>
                                </div>   
                                <div class="form-group mt-4 mb-2">
                                    <label for="tb_domisili" class="font-weight-bold" ><span class="label-form-span">Domisili</span></label><br>
                                    <input type="text" id="tb_domisili" name="tb_domisili" class="form-control" value="<?php echo $result['domisili']?>" readonly>
                                </div> 
                                <div class="form-group mt-4 mb-2">
                                    <label for="tb_domisili" class="font-weight-bold" ><span class="label-form-span">Status Relawan</span></label><br>
                                    <input type="text" id="tb_domisili" name="tb_domisili" class="form-control" value="<?php echo $result['status_relawan']?>" readonly>
                                </div> 
                                        
                            </div>
                            
                        </form>
                        <div class="garis-atas text-center">
                                <p>
                                    Pengurus Yayasan akan menghubungi nomor telepon anda untuk melakukan konfirmasi
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