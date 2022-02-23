<?php

session_start();
include 'config/connection.php';

if (!isset($_SESSION["username"])) {
    header('Location: login.php?status=restrictedaccess');
    exit;
}

function rupiah($angka)
{
    $hasil_rupiah = "Rp. " . number_format($angka, 0, '.', '.');
    return $hasil_rupiah;
}



$id_program_donasi = $_GET["id"];


// var_dump($status_program_donasi);die;


$query      = mysqli_query($conn, "SELECT *, (SELECT SUM(nominal_donasi) 
                FROM t_donasi WHERE id_program_donasi = $id_program_donasi) 
                AS dana_terkumpul_total 
                FROM t_program_donasi 
                WHERE id_program_donasi = $id_program_donasi");
$result     = mysqli_fetch_array($query);

//  $programDonasi = query("SELECT *, SUM(t_donasi.nominal_donasi) AS nominal_total, 
//                 COUNT(konstan) 
//                 AS jumlah_donatur 
//                 FROM t_donasi 
//                 LEFT JOIN t_program_donasi 
//                 ON t_program_donasi.id_program_donasi = t_donasi.id_program_donasi                 
//                 GROUP BY t_program_donasi.id_program_donasi ORDER BY t_program_donasi.id_program_donasi DESC
//                 ");

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

            <a href="dashboard-user.php" class="brand-link">
                <img src="img/logo-only.svg" class="brand-image mt-1">
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
                        <a href="dashboard-user.php">
                            <i class="nav-icon fas fa-home mr-1"></i>Dashboard user</a> >
                        <a href="dashboard-user.php">
                            <i class="nav-icon fas fa-user-cog mr-1"></i>Donasi saya</a> >
                        <a href="pilih-donasi.php">
                            <i class="nav-icon fas fa-hand-holding-heart mr-1"></i>Buat Donasi</a> >
                        <a href="view-donasi-dashboard.php?id=<?php echo $row['id_program_donasi']; ?>">
                            <i class="nav-icon fas fa-info-circle mr-1"></i>Detail Donasi</a>
                    </div>
                </div>
                <div class="form-profil halaman-view">
                    <div class="row card-deck ">
                        <div class="halaman-view mt-5 w-100">
                            <input type="hidden" data-target="status_program_donasi" id="status_program_donasi" name="status_program_donasi" class="form-control" value="Siap disalurkan" readonly>
                            <input type="hidden" data-target="id_program_donasi" id="id_program_donasi" name="id_program_donasi" class="form-control" value="<?php echo $result["id_program_donasi"]; ?>" readonly>

                            <img class="card-img-top halaman-view-img" width="100%" src="img/<?= $result['foto_p_donasi']; ?>">
                            <div class="view-desc-singkat mt-2">
                                <h2 class="mt-4"><?php echo $result['nama_program_donasi'] ?></h2>
                                <p>
                                    <?php echo $result['deskripsi_singkat_donasi'] ?>
                                </p>
                                <!-- <div class="d-flex view-kumpulan  mb-3">
                                    <div class="float-left">
                                        <span class="value-penting">
                                            ?php echo rupiah($result['dana_terkumpul_total']) == 0 ? '0' : rupiah($result['dana_terkumpul_total']) ?>
                                        </span>
                                        terkumpul dari
                                        <span class="value-penting">
                                            ?php echo rupiah($result['target_dana']) ?>
                                        </span>
                                    </div>
                                </div> -->
                                <div class="d-flex view-kumpulan  mb-3">
                                    <div class="float-left">Bantuan akan disalurkan kepada <b><?php echo $result['penerima_donasi'] ?></b>
                                        pada
                                        <?php echo date("d-m-Y", strtotime($result['tgl_selesai'])); ?>
                                    </div>
                                    <div class="ml-2 d-none"><b><?php echo $result['tgl_selesai'] ?></b></div>
                                </div>
                                <?php if ($result['jangka_waktu'] == 0) { ?>
                                    <div class="d-flex view-kumpulan  mb-3">

                                        <div class="float-left" id="teks">
                                            Sisa Waktu
                                            <script>
                                                //Countdown
                                                // var id_program_donasi = "?php echo $id_program_donasi; ?>";
                                                // var status_program_donasi = "?php echo $status_program_donasi; ?>";

                                                var dateStringFromDP = '<?php echo $result['tgl_selesai'] ?>';
                                                const tanggalTujuan = new Date(dateStringFromDP).getTime();
                                                const hitungMundur = setInterval(function() {
                                                    const sekarang = new Date().getTime();
                                                    const selisih = tanggalTujuan - sekarang;
                                                    const hari = Math.floor(selisih / (1000 * 60 * 60 * 24));
                                                    const jam = Math.floor(selisih % (1000 * 60 * 60 * 24) / (1000 * 60 * 60));
                                                    const menit = Math.floor(selisih % (1000 * 60 * 60) / (1000 * 60));
                                                    const detik = Math.floor(selisih % (1000 * 60) / 1000);
                                                    const teks = document.getElementById('teks');
                                                    teks.innerHTML = 'Sisa Waktu : ' + hari + ' hari ' + jam + ' jam ' + menit + ' menit ' + detik + ' detik lagi ! ';

                                                    if (selisih < 0) {
                                                        clearInterval(hitungMundur);
                                                        teks.innerHTML = 'Waktu program telah habis !';

                                                        //Get Variable
                                                        var id_program_donasi = $('#id_program_donasi').val();
                                                        var status_program_donasi = $('#status_program_donasi').val();

                                                        console.log(id_program_donasi);


                                                        //Update value
                                                        $.ajax({
                                                            url: 'update-ajax.php',
                                                            type: 'POST',

                                                            data: {
                                                                status_program_donasi: status_program_donasi,
                                                                id_program_donasi: id_program_donasi
                                                            },
                                                            success: function(response) {
                                                                // alert('success, server says '+output);
                                                                console.log(response);
                                                            },
                                                            error: function() {
                                                                alert('something went wrong, rating failed');
                                                            }
                                                        });
                                                        // console.log(statusProgram);

                                                    }

                                                }, 1000);
                                            </script>
                                        </div>

                                    </div>
                                <?php } ?>
                            </div>
                            <div class="view-desc-lengkap mt-4">
                                <h4 class="mt-4"> Informasi Program</h4>
                                <p>
                                    <?php echo $result['deskripsi_lengkap_donasi'] ?>
                                </p>
                                <a class="btn btn-primary btn-lg btn-block mb-4 btn-kata-media" id="tombolDonasi" href="buat-donasi.php?id=<?php echo $result['id_program_donasi']; ?>">Donasi Sekarang</a>
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