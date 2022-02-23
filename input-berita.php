<?php
session_start();
include 'config/connection.php';


if (!isset($_SESSION["username"])) {
    header('Location: login.php?status=restrictedaccess');
    exit;
}

function upload()
{
    //upload gambar
    $namaFile = $_FILES['image_uploads']['name'];
    $ukuranFile = $_FILES['image_uploads']['size'];
    $error = $_FILES['image_uploads']['error'];
    $tmpName = $_FILES['image_uploads']['tmp_name'];

    //  if($error === 4){
    //      echo "
    //          <script>
    //              alert('gambar tidak ditemukan !');
    //          </script>
    //      ";
    //      return false;
    //  }

    //cek ekstensi gambar
    $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
    $ekstensiGambar = explode('.', $namaFile);
    $ekstensiGambar = strtolower(end($ekstensiGambar));

    if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
        echo "
                     <script>
                         alert('kesalahan pada format gambar !');
                     </script>
                 ";
        return false;
    }

    //generate nama baru
    $namaFileBaru = uniqid();
    $namaFileBaru .= '.';
    $namaFileBaru .= $ekstensiGambar;


    //lolos pengecekan
    move_uploaded_file($tmpName, 'img/' . $namaFileBaru);

    return $namaFileBaru;
}


if (isset($_POST["submit"])) {

    $judul_berita               = $_POST["tb_judul_berita"];
    $judul_berita               = htmlspecialchars($judul_berita);

    $tgl_kejadian               = $_POST["tb_tgl_kejadian"];

    $isi_berita                 = $_POST["tb_isi_berita"];
    $isi_berita                 = htmlspecialchars($isi_berita);

    $gambar                     = upload();

    $tgl_penulisan              = date('Y-m-d', time());

    $kategori_berita            = $_POST["tb_kategori_berita"];

    $status_berita              = 1;


    $query = "INSERT INTO t_berita (judul_berita, tgl_kejadian, isi_berita,gambar_berita,tgl_penulisan,kategori_berita,status_berita)
                VALUES ('$judul_berita', '$tgl_kejadian', '$isi_berita','$gambar','$tgl_penulisan','$kategori_berita','$status_berita')";


    mysqli_query($conn, $query);
    // var_dump($query);
    // die;

    //cek keberhasilan
    if (mysqli_affected_rows($conn) > 0) {
        echo "
            <script>
                alert('Data berhasil ditambahkan!');
            </script>
            ";
    } else {
        echo "
                <script>
                    alert('Data gagal ditambahkan!');
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
    <title>YST - Input Berita</title>
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
                        <li class="nav-item nav-item-sidebar  menu-open">
                            <a href="kelola-berita.php" class="nav-link side-icon active">
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
                <div class="page-title-link ml-4 mb-4">
                    <a href="dashboard-admin.php">
                        <i class="nav-icon fas fa-home mr-1"></i>Dashboard admin</a> >
                    <a href="kelola-berita.php">
                        <i class="nav-icon fas fa-cog mr-1"></i>Kelola Berita</a> >
                    <a href="input-berita.php">
                        <i class="nav-icon fas fa-plus-square mr-1"></i>Input Berita</a>
                </div>
                <div class="form-profil">
                    <div class="mt-2 regis-title">
                        <h3>Input Berita</h3>
                    </div>
                    <form action="" enctype="multipart/form-data" method="POST">
                        <div class="form-group label-txt">
                            <div class="form-group mt-4 mb-3">
                                <label for="tb_judul_berita" class="label-txt">Judul Berita<span class="red-star">*</span></label>
                                <input type="text" id="tb_judul_berita" name="tb_judul_berita" class="form-control" placeholder="Judul Berita" Required>
                            </div>
                            <div class="form-group mt-4 mb-3">
                                <label for="tb_kategori_berita">Kategori</label>
                                <select class="form-control" id="tb_kategori_berita" name="tb_kategori_berita">
                                    <option value="0">Kegiatan</option>
                                    <option value="1">Berita</option>
                                </select>
                            </div>
                            <div class="form-group mt-4 mb-3">
                                <label for="tb_tgl_kejadian" class="label-txt">Tanggal Kejadian<span class="red-star">*</span></label>
                                <input type="date" id="tb_tgl_kejadian" name="tb_tgl_kejadian" class="form-control" Required>
                            </div>
                            <div class="form-group">
                                <label for="tb_isi_berita" class="label-txt">Isi Berita<span class="red-star">*</span></label>
                                <textarea class="form-control" id="tb_isi_berita" name="tb_isi_berita" rows="6" placeholder="Isi Berita" Required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="image_uploads" class="label-txt">Foto Berita<span class="red-star">*</span></label>
                                <div class="file-form">
                                    <input type="file" id="image_uploads" name="image_uploads" class="form-control" Required>
                                </div>
                            </div>
                        </div>
                        <button type="submit" name="submit" value="Simpan" class="btn btn-lg btn-primary w-100 yst-login-btn border-0 mt-4 mb-4">
                            <span class="yst-login-btn-fs">Posting Berita</span>
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