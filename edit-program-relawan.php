<?php
session_start();
include 'config/connection.php';


if (!isset($_SESSION["username"])) {
    header('Location: login.php?status=restrictedaccess');
    exit;
}

$level_user = $_SESSION['level_user'];
//ambil id program di URL
$id_program_relawan = $_GET["id_program_relawan"];

function upload()
{
    //upload gambar
    $namaFile = $_FILES['image_uploads']['name'];
    $ukuranFile = $_FILES['image_uploads']['size'];
    $error = $_FILES['image_uploads']['error'];
    $tmpName = $_FILES['image_uploads']['tmp_name'];

    // if($error === 4){
    //     echo "
    //         <script>
    //             alert('gambar tidak ditemukan !');
    //         </script>
    //     ";
    //     return false;
    // }

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

function upload2()
{
    //upload gambar
    $namaFile2 = $_FILES['image_uploads2']['name'];
    $ukuranFile2 = $_FILES['image_uploads2']['size'];
    $error = $_FILES['image_uploads2']['error'];
    $tmpName2 = $_FILES['image_uploads2']['tmp_name'];

    //cek ekstensi gambar
    $ekstensiGambarValid2 = ['jpg', 'jpeg', 'png'];
    $ekstensiGambar2 = explode('.', $namaFile2);
    $ekstensiGambar2 = strtolower(end($ekstensiGambar2));

    //generate nama baru
    $namaFileBaru2 = uniqid();
    $namaFileBaru2 .= '.';
    $namaFileBaru2 .= $ekstensiGambar2;


    //lolos pengecekan
    move_uploaded_file($tmpName2, 'img/' . $namaFileBaru2);
    return $namaFileBaru2;
}

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

$programRelawan = query("SELECT * FROM t_program_relawan WHERE id_program_relawan = $id_program_relawan")[0];


//UPDATE
if (isset($_POST["submit"])) {

    $id_program_relawan         = $_POST["id_program_relawan"];

    $nama_program_relawan        = $_POST["tb_nama_program_relawan"];
    $nama_program_relawan        = htmlspecialchars($nama_program_relawan);

    $target_relawan              = $_POST["tb_target_relawan"];

    $lokasi_program              = $_POST["tb_lokasi_program"];
    $lokasi_program              = htmlspecialchars($lokasi_program);

    $tgl_pelaksanaan              = $_POST["tb_tgl_pelaksanaan"];

    $deskripsi_singkat_relawan   = $_POST["tb_deskripsi_relawan_singkat"];
    $deskripsi_singkat_relawan   = htmlspecialchars($deskripsi_singkat_relawan);

    $deskripsi_lengkap_relawan   = $_POST["tb_deskripsi_relawan_lengkap"];
    $deskripsi_lengkap_relawan   = htmlspecialchars($deskripsi_lengkap_relawan);

    $status_program_relawan      = $_POST["status_program_relawan"];

    $gambarLama                 = $_POST["gambarLama"];

    $gambarLama2                 = $_POST["gambarLama2"];

    $penanggung_jawab            = $_POST["tb_penanggung_jawab"];
    $penanggung_jawab            = htmlspecialchars($penanggung_jawab);

    $tenggat_waktu               = $_POST["tb_tenggat_waktu"];

    if ($_FILES['image_uploads']['error'] === 4) {
        $gambar = $gambarLama;
    } else {
        $gambar = upload();
    }

    if ($_FILES['image_uploads2']['error'] === 4) {
        $gambar2 = $gambarLama2;
    } else {
        $gambar2 = upload2();
    }


    $query = "UPDATE t_program_relawan SET
                nama_program_relawan         = '$nama_program_relawan',
                deskripsi_singkat_relawan    = '$deskripsi_singkat_relawan',
                target_relawan                 = '$target_relawan',
                tgl_pelaksanaan             = '$tgl_pelaksanaan',
                lokasi_program              = '$lokasi_program',
                deskripsi_lengkap_relawan    = '$deskripsi_lengkap_relawan',
                penanggung_jawab             = '$penanggung_jawab ',
                tenggat_waktu                = '$tenggat_waktu',
                bukti_pelaksanaan            = '$gambar2',
                foto_p_relawan               = '$gambar'
                WHERE id_program_relawan      = $id_program_relawan
                ";

    //SUPERADMIN UPDATE (DENGAN STATUS)
    if ($_SESSION['level_user'] == 1 || $_SESSION['level_user'] == 2) {
        $status_program_relawan    = $_POST["status_program_relawan"];

        $query = "UPDATE t_program_relawan SET
                    nama_program_relawan         = '$nama_program_relawan',
                    deskripsi_singkat_relawan    = '$deskripsi_singkat_relawan',
                    target_relawan                 = '$target_relawan',
                    tgl_pelaksanaan             = '$tgl_pelaksanaan',
                    lokasi_program              = '$lokasi_program',
                    deskripsi_lengkap_relawan    = '$deskripsi_lengkap_relawan',
                    status_program_relawan       = '$status_program_relawan',
                    penanggung_jawab             = '$penanggung_jawab ',
                    tenggat_waktu                = '$tenggat_waktu',
                    bukti_pelaksanaan            = '$gambar2',
                    foto_p_relawan               = '$gambar'
                    WHERE id_program_relawan      = $id_program_relawan
                    ";
    }


    mysqli_query($conn, $query);

    // var_dump($query);die;

    //cek keberhasilan
    if (mysqli_affected_rows($conn) > 0) {
        echo "
            <script>
                alert('Data berhasil diubah!');
                window.location.href = 'kelola-p-relawan.php'; 
            </script>
        ";
    } else {
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
    <title>YST - Edit Program Relawan</title>
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
                            <a href="dashboard-admin.php" class="nav-link side-icon  ">
                                <i class="nav-icon fas fa-cog"></i>
                                <p>
                                    Program Donasi
                                </p>
                            </a>
                        </li>

                        <li class="nav-item nav-item-sidebar ">
                            <a href="kelola-donasi.php" class="nav-link side-icon ">
                                <i class="nav-icon fas fa-donate"></i>
                                <p>
                                    Kelola Donasi
                                </p>
                            </a>
                        </li>

                        <li class="nav-item nav-item-sidebar menu-open">
                            <a href="kelola-p-relawan.php" class="nav-link side-icon active">
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
                    <a href="kelola-p-relawan.php">
                        <i class="nav-icon fas fa-cog mr-1"></i>Program relawan</a> >
                    <a href="input-program-relawan.php">
                        <i class="nav-icon fas fa-plus-square mr-1"></i>Edit program relawan</a>
                </div>
                <div class="form-profil">
                    <div class="mt-2 regis-title">
                        <h3>Edit Program Relawan</h3>
                    </div>
                    <form action="" enctype="multipart/form-data" method="POST">
                        <input type="hidden" name="id_program_relawan" value="<?= $programRelawan['id_program_relawan']; ?>">
                        <input type="hidden" name="gambarLama" value="<?= $programRelawan['foto_p_relawan']; ?>">
                        <input type="hidden" name="gambarLama2" value="<?= $programRelawan['bukti_pelaksanaan']; ?>">

                        <div class="form-group label-txt">
                            <div class="form-group mt-4 mb-3">
                                <label for="tb_nama_program_relawan" class="label-txt">Nama Program</label>
                                <input type="text" id="tb_nama_program_relawan" name="tb_nama_program_relawan" class="form-control" value="<?= $programRelawan["nama_program_relawan"]; ?>">
                            </div>
                            <div class="form-group mt-4 mb-3">
                                <label for="tb_nama_program_relawan" class="label-txt">Kategori Program Relawan</label>
                                <input type="text" id="tb_kategori" name="tb_kategori" class="form-control" value="<?= $programRelawan["kategori_relawan"]; ?>" readonly>
                            </div>
                            <div class="form-group mt-4 mb-3">
                                <label for="tb_penanggung_jawab" class="label-txt">Penanggung Jawab</label>
                                <input type="text" id="tb_penanggung_jawab" name="tb_penanggung_jawab" class="form-control" value="<?= $programRelawan["penanggung_jawab"]; ?>">
                            </div>
                            <div class="form-group mb-3">
                                <label for="tb_target_relawan" class="label-txt">Target Jumlah Relawan</label>
                                <input type="number" id="tb_target_relawan" name="tb_target_relawan" class="form-control" value="<?= $programRelawan["target_relawan"]; ?>">
                            </div>
                            <div class="form-group mt-4 mb-3">
                                <label for="tb_lokasi_program" class="label-txt">Lokasi Pelaksanaan Program</label>
                                <input type="text" id="tb_lokasi_program" name="tb_lokasi_program" class="form-control" value="<?= $programRelawan["lokasi_program"]; ?>">
                            </div>
                            <div class="form-group mt-4 mb-3">
                                <label for="tb_lokasi_program" class="label-txt">Lokasi Titik Kumpul</label>
                                <input type="text" id="tb_lokasi_awal" name="tb_lokasi_awal" class="form-control" value="<?= $programRelawan["lokasi_awal"]; ?>">
                            </div>
                            <div class="form-group mt-4 mb-3">
                                <label for="tb_tgl_pelaksanaan" class="label-txt">Tanggal Pelaksanaan Program</label>
                                <input type="date" id="tb_tgl_pelaksanaan" name="tb_tgl_pelaksanaan" class="form-control" value="<?= $programRelawan["tgl_pelaksanaan"]; ?>">
                            </div>
                            <div class="form-group mt-4 mb-3">
                                <label for="tb_tenggat_waktu" class="label-txt">Tenggat Waktu Pengumpulan Relawan</label>
                                <input type="date" id="tb_tenggat_waktu" name="tb_tenggat_waktu" class="form-control" value="<?= $programRelawan["tenggat_waktu"]; ?>">
                            </div>

                            <div class="form-group">
                                <label for="tb_deskripsi_relawan_singkat" class="label-txt">Deskripsi Singkat Program</label>
                                <textarea class="form-control" id="tb_deskripsi_relawan_singkat" name="tb_deskripsi_relawan_singkat" rows="2"><?= $programRelawan["deskripsi_singkat_relawan"]; ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="tb_deskripsi_relawan_lengkap" class="label-txt">Deskripsi Lengkap Program</label>
                                <textarea class="form-control" id="tb_deskripsi_relawan_lengkap" name="tb_deskripsi_relawan_lengkap" rows="6"><?= $programRelawan["deskripsi_lengkap_relawan"]; ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="image_uploads" class="label-txt">Foto Program</label><br>
                                <img src="img/<?= $programRelawan["foto_p_relawan"]; ?>" class="edit-img popup" alt="">
                                <div class="file-form">
                                    <input type="file" id="image_uploads" name="image_uploads" class="form-control">
                                </div>
                            </div>

                            <!-- Untuk upload bukti penyaluran -->
                            <?php if ($programRelawan['status_program_relawan'] == 'Siap dilaksanakan' || $programRelawan['status_program_relawan'] == 'Selesai') { ?>
                                <div class="second-bg">
                                    <div class="form-group upload-bukti">
                                        <h3 class="mt-4">Bukti Pelaksanaan Program Relawan</h3>
                                        <label for="image_uploads2" class="label-txt">Foto Bukti Pelaksanaan Program Relawan</label><br>
                                        <img src="img/<?= $programRelawan["bukti_pelaksanaan"]; ?>" class="edit-img popup " alt="">
                                        <div class="file-form">
                                            <input type="file" id="image_uploads2" name="image_uploads2" class="form-control ">
                                        </div>
                                    </div>

                                <?php } ?>
                                <!-- END Untuk upload bukti penyaluran -->


                                <?php if ($_SESSION['level_user'] == 1 || $_SESSION['level_user'] == 2) { ?>
                                    <div class="form-group mb-5 ">
                                        <label for="status_program_donasi" class="font-weight-bold"><span class="label-form-span">Status Program</span></label><br>
                                        <div class="radio-wrapper mt-1 bg-white">
                                            <div class="form-check form-check-inline">
                                                <input type="radio" id="status_program_relawan" name="status_program_relawan" class="form-check-input" value="Pending" <?php if ($programRelawan['status_program_relawan'] == 'Pending') echo 'checked' ?>>
                                                <label class="form-check-label" for="status_program_relawan">Pending</label>
                                            </div>
                                        </div>
                                        <div class="radio-wrapper mt-1 bg-white">
                                            <div class="form-check form-check-inline">
                                                <input type="radio" id="status_program_relawan" name="status_program_relawan" class="form-check-input" value="Berjalan" <?php if ($programRelawan['status_program_relawan'] == 'Berjalan') echo 'checked' ?>>
                                                <label class="form-check-label" for="status_program_relawan">Berjalan</label>
                                            </div>
                                        </div>
                                        <div class="radio-wrapper mt-1 bg-white">
                                            <div class="form-check form-check-inline">
                                                <input type="radio" id="status_program_relawan" name="status_program_relawan" class="form-check-input" value="Siap dilaksanakan" <?php if ($programRelawan['status_program_relawan'] == 'Siap dilaksanakan') echo 'checked' ?>>
                                                <label class="form-check-label" for="status_program_relawan">Siap dilaksanakan</label>
                                            </div>
                                        </div>
                                        <div class="radio-wrapper mt-1 bg-white">
                                            <div class="form-check form-check-inline ">
                                                <input type="radio" id="status_program_relawan" name="status_program_relawan" class="form-check-input" value="Selesai" <?php if ($programRelawan['status_program_relawan'] == 'Selesai') echo 'checked' ?>>
                                                <label class="form-check-label" for="status_program_relawan">Selesai</label>
                                            </div>
                                        </div>
                                        <div class="form-group mb-2"><br><br></div>
                                    </div>

                                <?php } ?>


                                </div>
                                <button type="submit" name="submit" value="Simpan" class="btn btn-lg btn-primary w-100 yst-login-btn border-0 mb-4">
                                    <span class="yst-login-btn-fs">Edit Program</span></button>
                    </form>
                </div>
                <!-- Modal -->
                <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropLabel">Foto Program </h5>
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
    <!-- Modal -->
    <script>
        $('.popup').click(function() {
            var src = $(this).attr('src');

            $('.modal').modal('show');
            $('#popup-img').attr('src', src);
        });
    </script>


</body>

</html>