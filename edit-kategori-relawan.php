<?php
session_start();
include 'config/connection.php';


if (!isset($_SESSION["username"])) {
    header('Location: login.php?status=restrictedaccess');
    exit;
}


//ambil id program di URL
$id_kat_relawan = $_GET["id_kat_relawan"];

//fungsi GET Array
function query($query)
{
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

$kategoriRelawan = query("SELECT * FROM t_kat_relawan WHERE id_kat_relawan = $id_kat_relawan")[0];

//UPDATE
if (isset($_POST["submit"])) {

    $kategori_relawan      = $_POST["tb_kategori_relawan"];
    $ket_kategori_relawan      = $_POST["tb_ket_kategori_relawan"];

    // GLOBAL UPDATE
    $query = "UPDATE t_kat_relawan SET
                    kategori_relawan         = '$kategori_relawan',
                    ket_kategori_relawan     = '$ket_kategori_relawan'
                  WHERE id_kat_relawan       = $id_kat_relawan
                ";


    mysqli_query($conn, $query);


    //cek keberhasilan
    if (mysqli_affected_rows($conn) > 0) {
        echo "
            <script>
                alert('Data berhasil diubah!');
                window.location.href = 'kelola-kat-relawan.php'; 
            </script>
        ";
    } else {
        echo "
                <script>
                    alert('Tidak ada perubahan data');
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
    <title>YST - Edit Kategori relawan</title>
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
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@600&display=swap" rel="stylesheet">
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
                            <a href="dashboard-admin.php" class="nav-link side-icon ">
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
                            <a href="kelola-berita.php" class="nav-link side-icon">
                                <i class="nav-icon fas fa-newspaper"></i>
                                <p>
                                    Kelola Berita
                                </p>
                            </a>
                        </li>
                        <li class="nav-item nav-item-sidebar">
                            <a href="laporan-program-donasi.php" class="nav-link side-icon">
                                <i class="nav-icon fas fa-calendar-check"></i>
                                <p>
                                    Lp. Program Donasi
                                </p>
                            </a>
                        </li>
                        <li class="nav-item nav-item-sidebar">
                            <a href="laporan-donasi.php" class="nav-link side-icon">
                                <i class="nav-icon fas fa-file-invoice-dollar"></i>
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
                        <li class="nav-item nav-item-sidebar ">
                            <a href="laporan-relawan.php" class="nav-link side-icon ">
                                <i class="nav-icon fas fa-address-book"></i>
                                <p>
                                    Lp. Relawan
                                </p>
                            </a>
                        </li>
                        <!-- Hanya muncul jika level user = 3 / super admin -->
                        <?php if ($_SESSION['level_user'] == 1 || $_SESSION['level_user'] == 2) { ?>
                            <li class="nav-item dropdown nav-item-sidebar menu-open ">
                                <a class="nav-link active  dropdown-toggle side-icon" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="nav-icon fa fa-star"></i>
                                    Menu Master
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                    <a class="dropdown-item " href="kelola-kat-donasi.php">Kategori Donasi</a>
                                    <a class="dropdown-item active" href="kelola-kat-relawan.php">Kategori Relawan</a>
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
                <div class="page-title-link ml-4 mb-4">
                    <a href="kelola-kat-relawan.php">
                        <i class="nav-icon fas fa-home mr-1"></i>Kategori relawan</a> >
                    <a href="input-kategori-relawan.php">
                        <i class="nav-icon fas fa-cog mr-1"></i>Edit Kategori relawan</a>
                </div>
                <div class="form-profil">
                    <div class="mt-2 regis-title">
                        <h3>Edit Kategori relawan</h3>
                    </div>
                    <form action="" enctype="multipart/form-data" method="POST">
                        <div class="form-group label-txt">
                            <div class="form-group mt-4 mb-3">
                                <label for="tb_kategori_relawan" class="label-txt">Nama Kategori Program relawan<span class="red-star">*</span></label>
                                <input type="text" id="tb_kategori_relawan" name="tb_kategori_relawan" class="form-control" placeholder="Nama kategori relawan" value="<?= $kategoriRelawan["kategori_relawan"]; ?>" Required>
                            </div>
                            <div class="form-group">
                                <label for="tb_ket_kategori_relawan" class="label-txt">Keterangan Kategori</label>
                                <textarea class="form-control" id="tb_ket_kategori_relawan" name="tb_ket_kategori_relawan" rows="6" placeholder="Keterangan Kategori relawan"><?= $kategoriRelawan["ket_kategori_relawan"]; ?></textarea>
                            </div>
                        </div>
                        <button type="submit" name="submit" value="Simpan" class="btn btn-lg btn-primary w-100 yst-login-btn border-0 mt-4 mb-4">
                            <span class="yst-login-btn-fs">Edit Kategori</span>
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


</body>

</html>