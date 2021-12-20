<?php
    include "config/connection.php";



    // WHERE status_donasi = 'Diterima'
    

    // var_dump($programDonasi);die;
//    $programDonasi = query("SELECT *, SUM(t_donasi.nominal_donasi) AS nominal_total, 
//                     COUNT(id_user) 
//                     AS jumlah_donatur 
//                     FROM t_donasi 
//                     LEFT JOIN t_program_donasi 
//                     ON t_program_donasi.id_program_donasi = t_donasi.id_program_donasi                 
//                     GROUP BY t_program_donasi.id_program_donasi ORDER BY t_program_donasi.id_program_donasi DESC
//                     ");

    function query($query){
       global $conn;
        $result = mysqli_query($conn, "SELECT * FROM t_program_donasi ORDER BY id_program_donasi "); 
        $rows = [];
        while($row = mysqli_fetch_assoc($result)){
            $rows[] = $row;
        }
        return $rows;
   }


   $programDonasi = query("SELECT * FROM t_program_donasi ");
    
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Icon Title -->
    <link rel="icon" href="img/logo-only.svg">
    <title>YST - Kelola Program Donasi</title>
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
                    Username
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="profil-saya.php">Edit Profil</a>
                        <a class="dropdown-item" href="login.php">Logout</a>
                    </div>                   
                </li>
            </ul>
        </nav>
        <!-- /.Navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-background elevation-4">
            <!-- Brand Logo -->

            <a href="dashboard-admin.php" class="brand-link">
                <img src="img/logo-only.svg"  class="brand-image mt-1">
                <span class="brand-text font-weight-bold mt-2"><i>Dashboard Admin</i></span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
           <!-- Sidebar Menu -->
                <nav class="mt-4">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
                        with font-awesome or any other icon font library -->
                        <li class="nav-item nav-item-sidebar menu-open">
                            <a href="dashboard-admin.php" class="nav-link side-icon active ">
                                <i class="nav-icon fas fa-cog"></i>
                                <p>
                                    Program Donasi
                                </p>
                            </a>
                        </li>

                        <li class="nav-item nav-item-sidebar">
                            <a href="kelola-donasi.php" class="nav-link side-icon">
                                <i class="nav-icon fas fa-donate"></i>
                                <p>
                                    Kelola Donasi
                                </p>
                            </a>
                        </li>

                        <li class="nav-item nav-item-sidebar">
                            <a href="kelola-p-relawan.php" class="nav-link side-icon">
                                <i class="nav-icon fas fa-cog"></i>
                                <p>
                                    Program Relawan
                                </p>
                            </a>
                        </li>
                        <li class="nav-item nav-item-sidebar">
                            <a href="kelola-relawan.php" class="nav-link side-icon">
                                <i class="nav-icon fas fa-user-cog"></i>
                                <p>
                                    Kelola Relawan
                                </p>
                            </a>
                        </li>
                        <li class="nav-item nav-item-sidebar">
                            <a href="laporan-program.php" class="nav-link side-icon">
                                <i class="nav-icon fas fa-calendar-check"></i>
                                <p>
                                    Laporan  Program
                                </p>
                            </a>
                        </li>
                        <li class="nav-item nav-item-sidebar">
                            <a href="laporan-donasi.php" class="nav-link side-icon">
                                <i class="nav-icon fas fa-file-invoice-dollar"></i>
                                <p>
                                    Laporan  Donasi
                                </p>
                            </a>
                        </li>
                        <li class="nav-item nav-item-sidebar">
                            <a href="laporan-relawan.php" class="nav-link side-icon">
                                <i class="nav-icon fas fa-address-book"></i>
                                <p>
                                    Laporan  Relawan
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
            <div class="request-data">
                    <div class="projects">
                        <div class="page-title-link ml-4 mb-4">     
                            <a href="dashboard-admin.php">
                                <i class="nav-icon fas fa-home mr-1"></i>Dashboard admin</a> > 
                            <a href="dashboard-admin.php">
                                <i class="nav-icon fas fa-cog mr-1"></i>Program donasi</a>
                        </div>

                        <div class="card card-request-data">
                            <div class="card-header-req">
                                <div class="row ml-1 ">
                                    <div class="col ">
                                      <div class="dropdown show ">
                                        <a class="btn btn-info  filter-btn dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                          Tampilkan Semua
                                        </a>
                                        <div class="dropdown-menu green-drop" aria-labelledby="dropdownMenuLink">
                                          <a class="dropdown-item" href="program-donasi-berjalan.php">Mengumpulkan Donasi</a>
                                      </div>
                                    </div>
                                    </div>
                              </div>
                              <button class="mr-5" onclick="location.href='input-program-donasi.php'">Input Program Donasi <span class="fas fa-plus-square"></span></button>
    
                            </div>
                            <div class="card-body card-body-req">
                                <div class="table-responsive">
                                    <table width="100%">
                                        <thead>
                                            <tr>
                                                <td>ID</td>
                                                <td>Nama Program</td>
                                               
                                                <td>Target Dana</td>
                                               
                                                <td>Status Program</td>
                                                <td class="justify-content-center" >Aksi</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach($programDonasi as $row):?>
                                            <tr>
                                                <td><?= $row["id_program_donasi"]; ?></td>
                                                <td class="table-snipet1"><?= $row["nama_program_donasi"]; ?></td>
                                                
                                                <td>Rp. <?= $row["target_dana"]; ?></td>
                                               
                                                <td>
                                                    <?= $row["status_program_donasi"]; ?>
                                                </td>
                                                <td class="justify-content-center">
                                                    <button type="button" class="btn btn-edit">
                                                        <a href="edit-program-donasi.php?id_program_donasi=<?= $row["id_program_donasi"]; ?>" class="fas fa-edit"></a>
                                                    </button>
                                                    <button type="button" class="btn btn-delete ml-1">
                                                        <a href="hapus.php?type=pdonasi&id_program_donasi=<?=$row["id_program_donasi"];?>" 
                                                        class="far fa-trash-alt" onclick="return confirm('Anda yakin ingin menghapus program ini ?');"></a>
                                                    </button>
                                                  </td>
                                            </tr>
                                        <?php endforeach;?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
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