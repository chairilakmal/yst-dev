<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include('config/PHPMailer-master/PHPMailer-master/src/Exception.php');
include('config/PHPMailer-master/PHPMailer-master/src/PHPMailer.php');
include('config/PHPMailer-master/PHPMailer-master/src/SMTP.php');

session_start();
include 'config/connection.php';

$level_user = $_SESSION['level_user'];

function rupiah($angka)
{
    $hasil_rupiah = "Rp. " . number_format($angka, 0, '.', '.');
    return $hasil_rupiah;
}

if (!isset($_SESSION["username"])) {
    header('Location: login.php?status=restrictedaccess');
    exit;
}

$id_donasi = $_GET["id_donasi"];
// var_dump($id_donasi);die;

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



$result = query("SELECT * FROM t_donasi WHERE id_donasi = $id_donasi")[0];

//UPDATE
if (isset($_POST["submit"])) {

    $status_donasi          = $_POST["status_donasi"];
    $nominal_donasi         = '';
    $email_penerima         = $_POST["tb_email"];
    $nama_program_donasi    = $_POST["tb_nama_program_donasi"];
    $nama_donatur           = $_POST["tb_nama_donatur"];
    $tgl_donasi             = $_POST["tb_tgl_donasi"];

    if ($status_donasi == 'Diterima') {
        $nominal_donasi = $_POST["belum_dibayar"];
    }

    $query = "UPDATE t_donasi SET
              
                    status_donasi       = '$status_donasi',
                    nominal_donasi      = '$nominal_donasi'
                  WHERE id_donasi             = $id_donasi

                ";
    // if($status_donasi = "Diterima"){
    // $nominal_donasi = $_POST["belum_dibayar"];
    // $query = "UPDATE t_donasi SET
    //         status_donasi               = '$status_donasi'
    //         nominal_donasi              = '$nominal_donasi'
    //         WHERE id_donasi             = $id_donasi
    //         ";

    // }


    mysqli_query($conn, $query);

    //cek keberhasilan
    if (mysqli_affected_rows($conn) > 0) {
        echo "
            <script>
                alert('Data berhasil diubah!');
                
            </script>
            ";

        if ($status_donasi == 'Diterima') {
            $nominal_donasi = $_POST["belum_dibayar"];

            //PHPMailer
            $email_pengirim = 'vchoze@gmail.com';
            $nama_pengirim = 'Yayasan Sekar Telkom';

            $subjek = '[Yayasan Sekar Telkom] Donasi Untuk ' . $nama_program_donasi . ' Sudah Diterima';

            $pesan = '<h2>Donasi atas nama ' . $nama_donatur . ' sejumlah ' . rupiah($nominal_donasi) . ' telah kami terima, kami ucapkan terima kasih. Semoga Anda mendapat berkah selalu dalam kehidupan.</h2>

                        <p>
                            <strong>Rincian donasi :</strong>
                        </p>
                        <table>
                            <tr>
                                <td>Tanggal pembuatan donasi</td>
                                <td>:</td>
                                <td>' . $tgl_donasi . '</td>
                            </tr>
                            <tr>
                                <td>Program pilihan</td>
                                <td>:</td>
                                <td>' . $nama_program_donasi . '</td>
                            </tr>
                            <tr>
                                <td>Donasi atas nama</td>
                                <td>:</td>
                                <td>' . $nama_donatur . '</td>
                            </tr>
                            <tr>
                                <td>Nominal donasi</td>
                                <td>:</td>
                                <td><strong>' . rupiah($nominal_donasi) . '</strong></td>
                            </tr> 
                        </table>
                        ';

            // $pesan = 'Halo '.$email_penerima.', ikut test PHPMailer ya !';

            $mail = new PHPMailer;
            $mail->isSMTP();

            $mail->Host = 'smtp.gmail.com';
            $mail->Username = $email_pengirim;
            $mail->Password = 'xzwuieypdcbmmcyp';
            $mail->Port = 465;
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = 'ssl';
            $mail->SMTPDebug = 2;

            $mail->setFrom($email_pengirim, $nama_pengirim);
            $mail->addAddress($email_penerima);
            $mail->isHTML(true);
            $mail->Subject = $subjek;
            $mail->Body = $pesan;

            $send = $mail->send();

            if ($send) {
                echo "
                <script>
                    alert('Email Terkirim !');
                    window.location.href = 'kelola-donasi.php'; 
                </script>
                ";
            } else {
                echo "
                <script>
                    alert('Email Gagal Terkirim !');
                    
                </script>
                ";
            }
        }
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
    <title>YST - Edit Donasi</title>
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

                        <li class="nav-item nav-item-sidebar menu-open">
                            <a href="kelola-donasi.php" class="nav-link side-icon active">
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
                    <a href="kelola-donasi.php">
                        <i class="nav-icon fas fa-home mr-1"></i>Dashboard admin</a> >
                    <a href="kelola-donasi.php">
                        <i class="nav-icon fas fa-cog mr-1"></i>Program donasi</a> >
                    <a href="kelola-donasi.php">
                        <i class="nav-icon fas fa-plus-square mr-1"></i>Edit donasi</a>
                </div>
                <div class="form-profil halaman-view">
                    <div class="mt-2 regis-title">
                        <h3>ID Donasi :<?php echo $result['id_donasi'] ?></h3>
                    </div>
                    <form action="" enctype="multipart/form-data" method="POST">
                        <div class="form-group label-txt">
                            <input type="hidden" id="tb_email" name="tb_email" class="form-control" value="<?= $result["email"]; ?>" readonly>
                            <div class="form-group mt-2 mb-2" id="tb_tgl_donasi">
                                <label for="tb_tgl_donasi" class="font-weight-bold"><span class="label-form-span">Tanggal Donasi</span></label><br>
                                <input type="date" id="tb_tgl_donasi" name="tb_tgl_donasi" class="form-control" value="<?= $result["tgl_donasi"]; ?>" readonly>
                            </div>
                            <div class="form-group mt-2 mb-2">
                                <label for="tb_nama_program_donasi" class="font-weight-bold"><span class="label-form-span">Program Donasi Pilihan</span></label><br>
                                <input type="text" id="tb_nama_program_donasi" name="tb_nama_program_donasi" class="form-control" value="<?php echo $result['nama_program_donasi'] ?>" readonly>
                            </div>
                            <div class="form-group mt-2 mb-2" id="buatNominal">
                                <label for="belum_dibayar" class="font-weight-bold"><span class="label-form-span">Nominal Donasi</span></label><br>
                                <input type="number" id="belum_dibayar" name="belum_dibayar" class="form-control" value="<?php echo $result['belum_dibayar'] ?>" readonly>
                            </div>
                            <div class="form-group mt-3 mb-2">
                                <label for="nama_donatur" class="font-weight-bold"><span class="label-form-span">Nama Donatur</span></label><br>
                                <input type="text" id="tb_nama_donatur" name="tb_nama_donatur" class="form-control" value="<?php echo $result['nama_donatur'] ?>" readonly>
                            </div>

                            <!-- Hanya muncul jika level user = 3 / super admin / approver -->
                            <?php if ($_SESSION['level_user'] == 1 || $_SESSION['level_user'] == 2) { ?>
                                <div class="form-group mb-5 ">
                                    <label for="status_donasi" class="font-weight-bold"><span class="label-form-span">Status Donasi</span></label><br>
                                    <div class="radio-wrapper mt-1">
                                        <div class="form-check form-check-inline">
                                            <input type="radio" id="status_donasi" name="status_donasi" class="form-check-input" value="Menunggu Verifikasi" <?php if ($result['status_donasi'] == 'Menunggu Verifikasi') echo 'checked' ?>>
                                            <label class="form-check-label" for="status_donasi">Menunggu Verifikasi</label>
                                        </div>
                                    </div>
                                    <div class="radio-wrapper2 mt-1">
                                        <div class="form-check form-check-inline">
                                            <input type="radio" id="status_donasi" name="status_donasi" class="form-check-input" value="Diterima" <?php if ($result['status_donasi'] == 'Diterima') echo 'checked' ?>>
                                            <label class="form-check-label" for="status_donasi">Diterima</label>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>


                        </div>

                        <?php if ($_SESSION['level_user'] == 1 || $_SESSION['level_user'] == 2) { ?>
                            <button type="submit" name="submit" value="Simpan" class="btn btn-lg btn-primary w-100 yst-login-btn border-0 mt-4 mb-4">
                                <span class="yst-login-btn-fs">Kirim</span>
                            </button>
                        <?php } ?>
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