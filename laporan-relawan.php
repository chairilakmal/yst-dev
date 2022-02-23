<?php

session_start();
include 'config/connection.php';


if (!isset($_SESSION["username"])) {
    header('Location: login.php?status=restrictedaccess');
    exit;
}

function query($query)
{
    global $conn;
    $result = mysqli_query($conn, "SELECT * FROM t_relawan
                      LEFT JOIN t_program_relawan ON t_relawan.id_program_relawan = t_program_relawan.id_program_relawan
                      WHERE status_relawan = 'Diterima' 
                      ORDER BY id_relawan DESC
                        ");
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}


$result = query("SELECT * FROM t_relawan");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Icon Title -->
    <link rel="icon" href="img/logo-only.svg">
    <title>YST - Laporan Relawan</title>
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
                    <a class="nav-link dropdown-toggle pr-4" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php echo ("{$_SESSION['username']}"); ?>
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

            <a href="dashboard-admin.php" class="brand-link">
                <img src="img/logo-only.svg" class="brand-image mt-1">
                <span class="brand-text font-weight-bold mt-2"><i>Dashboard Admin</i></span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar Menu -->
                <nav class="mt-4">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
                        with font-awesome or any other icon font library -->
                        <li class="nav-item nav-item-sidebar ">
                            <a href="dashboard-admin.php" class="nav-link side-icon  ">
                                <i class="nav-icon fas fa-cog"></i>
                                <p>
                                    Program Donasi
                                </p>
                            </a>
                        </li>

                        <li class="nav-item nav-item-sidebar ">
                            <a href="kelola-donasi.php" class="nav-link side-icon ">
                                <i class="nav-icon fas fa-donate""></i>
                                <p>
                                    Kelola Donasi
                                </p>
                            </a>
                        </li>

                        <li class=" nav-item nav-item-sidebar ">
                            <a href=" kelola-p-relawan.php" class="nav-link side-icon ">
                                    <i class="nav-icon fas fa-cog"></i>
                                    <p>
                                        Program Relawan
                                    </p>
                            </a>
                        </li>
                        <li class="nav-item nav-item-sidebar ">
                            <a href="kelola-relawan.php" class="nav-link side-icon ">
                                <i class="nav-icon fas fa-user-cog"></i>
                                <p>
                                    Kelola Relawan
                                </p>
                            </a>
                        </li>
                        <li class="nav-item nav-item-sidebar">
                            <a href="kelola-berita.php" class="nav-link side-icon">
                                <i class="nav-icon fas fa-newspaper"></i>
                                <p>
                                    Kelola Berita
                                </p>
                            </a>
                        </li>
                        <li class="nav-item nav-item-sidebar ">
                            <a href="laporan-program-donasi.php" class="nav-link side-icon ">
                                <i class="nav-icon fas fa-calendar-check"></i>
                                <p>
                                    Lp. Program Donasi
                                </p>
                            </a>
                        </li>
                        <li class="nav-item nav-item-sidebar ">
                            <a href="laporan-donasi.php" class="nav-link side-icon ">
                                <i class="nav-icon fas fa-file-invoice-dollar "></i>
                                <p>
                                    Lp. Donasi
                                </p>
                            </a>
                        </li>
                        <li class="nav-item nav-item-sidebar">
                            <a href="laporan-program-relawan.php" class="nav-link side-icon">
                                <i class="nav-icon fas fa-calendar-check"></i>
                                <p>
                                    Lp. Program Relawan
                                </p>
                            </a>
                        </li>
                        <li class="nav-item nav-item-sidebar menu-open">
                            <a href="laporan-relawan.php" class="nav-link side-icon active">
                                <i class="nav-icon fas fa-address-book"></i>
                                <p>
                                    Lp. Relawan
                                </p>
                            </a>
                        </li>
                        <!-- Hanya muncul jika level user = 3 / super admin -->
                        <?php if ($_SESSION['level_user'] == 1 || $_SESSION['level_user'] == 2) { ?>
                            <li class="nav-item dropdown nav-item-sidebar menu-open ">
                                <a class="nav-link  dropdown-toggle side-icon" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="nav-icon fa fa-star"></i>
                                    Menu Master
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                    <a class="dropdown-item " href="kelola-kat-donasi.php">Kategori Donasi</a>
                                    <a class="dropdown-item " href="kelola-kat-relawan.php">Kategori Relawan</a>
                                    <?php if ($_SESSION['level_user'] == 1) { ?>
                                        <a class="dropdown-item " href="kelola-user.php">Kelola User</a>
                                    <?php } ?>
                                </div>
                            </li>
                        <?php } ?>

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
                            <a href="kelola-relawan.php">
                                <i class="nav-icon fas fa-user-cog mr-1"></i>Kelola relawan</a>
                        </div>

                        <div class="card card-request-data">
                            <div class="card-header-req">
                                <div class="row ml-1 ">



                                </div>
                                <button class="mr-5" onclick="window.print();">Cetak Laporan <span class="fa fa-print"></span></button>

                            </div>
                            <div class="card-body card-body-req">
                                <div class="table-responsive">
                                    <table width="100%">
                                        <thead>
                                            <tr>
                                                <td>Kode Relawan</td>
                                                <td class="col-2">Nama Relawan</td>
                                                <td class="col-2">Program Pilihan</td>
                                                <td class="col-2">Tgl Pelaksanaan</td>
                                                <td class="col-2">Domisili</td>
                                                <td class="col-2">Nomor HP</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($result as $row) : ?>
                                                <tr>
                                                    <td><?= $row["id_relawan"]; ?></td>
                                                    <td class="col-2"><?= $row["nama_lengkap"]; ?></td>
                                                    <td class="col-4"><?= $row["nama_program_relawan"]; ?></td>
                                                    <td class="col-2"><?= date("d-m-Y", strtotime($row["tgl_pelaksanaan"])); ?></td>
                                                    <td class="col-2"><?= $row["domisili"]; ?></td>
                                                    <td class="col-2"><?= $row["no_hp"]; ?></td>

                                                </tr>
                                            <?php endforeach; ?>
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
    <!-- Print Landscape -->
    <script>
        var css = '@page { size: landscape; }',
            head = document.head || document.getElementsByTagName('head')[0],
            style = document.createElement('style');

        style.type = 'text/css';
        style.media = 'print';

        if (style.styleSheet) {
            style.styleSheet.cssText = css;
        } else {
            style.appendChild(document.createTextNode(css));
        }

        head.appendChild(style);
    </script>


</body>

</html>