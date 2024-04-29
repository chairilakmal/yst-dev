<?php

session_start();
include '../../config/connection.php';

if (!isset($_SESSION["username"])) {
    header('Location: ../../login.php?status=restrictedaccess');
    exit;
}

if ($_SESSION["level_user"] == 4){
    header('Location: ../../user/dashboard-donasi/dashboard-user.php');
    exit;
}




function rupiah($angka)
{
    $hasil_rupiah = "Rp. " . number_format($angka, 0, '.', '.');
    return $hasil_rupiah;
}



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

$userAktif = query("SELECT COUNT(is_die) AS aktif FROM t_users WHERE is_die='n'");

$userMeninggal = query("SELECT COUNT(is_die) AS meninggal FROM t_users WHERE is_die='y'");

$pemasukan = query("SELECT SUM(nominal) AS pemasukan FROM t_lap_keuangan WHERE status='0'");

$pengeluaran = query("SELECT SUM(nominal) AS pengeluaran FROM t_lap_keuangan WHERE status='1'");

$terpublikasi = query("SELECT COUNT(status_berita) AS terpublikasi FROM t_berita WHERE status_berita='2'");

$pending = query("SELECT COUNT(status_berita) AS pending FROM t_berita WHERE status_berita='1'");

$donasiBerjalan = query("SELECT COUNT(status_program_donasi) AS Berjalan FROM t_program_donasi WHERE status_program_donasi='Berjalan'");

$donasiPending = query("SELECT COUNT(status_program_donasi) AS Pending FROM t_program_donasi WHERE status_program_donasi='Pending'");

$relawanBerjalan = query ("SELECT COUNT(status_program_relawan) AS Berjalan FROM t_program_relawan WHERE status_program_relawan='Berjalan'");

$relawanPending = query ("SELECT COUNT(status_program_relawan) AS Pending FROM t_program_relawan WHERE status_program_relawan='Pending'");


?>
<?php include '../../component/admin/header.php'; ?>
<?php include '../../component/admin/sidebar.php'; ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <main>
        <div class="request-data">
            <div class="projects">
                <div class="page-title-link ml-4 mb-4">
                    <a href="../dashboard-statistik/index.php">
                        <i class="nav-icon fas fa-home mr-1"></i>Dashboard admin</a> >
                    <a href="index.php">
                        <i class="nav-icon fa fa-database mr-1"></i>Statistik</a>
                </div>

                <div class="card card-request-data">
                    <div class="card-header-req">
                        
 
                

                    </div>
                    <div class="card-body card-body-req">

                        <tbody>
              

                    <div class="row justify-content-around">
                        <div class="card col-sm-5">
                            <div class="row no-gutters">
                                <div class="card-block">
                                <div class="col my-4 mx-5 card-body">
                                <a href="../kelola-user/">
                                    <i class="fa fa-user fa-6x"></i></a>
                                </div>
                                </div>
                                <div class="col my-4">
                                <div class="card-body">
                                    <a href="../kelola-user/" class="card-title"><h5><b>Pengurus Terdaftar</b></h5></a>
                                    <p class="card-text"></p>
                                    <?php foreach ($userAktif as $row) : ?>
                                    <a href="../kelola-user/" class="card-text"><b class="text-muted">Aktif	&nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp; : </b><b><?= $row["aktif"]; ?> Orang</b></a>
                                    <?php endforeach; ?>
                                    <p class="card-text"></p>
                                    <?php foreach ($userMeninggal as $row) : ?>
                                    <a href="../kelola-user/" class="card-text"><b class="text-muted">Meninggal	&nbsp; : </b><b><?= $row["meninggal"]; ?> Orang</b></a>
                                    <?php endforeach; ?>
                                </div>
                                </div>
                            </div>
                            </div>
                            <div class="card col-sm-5">
                            <div class="row no-gutters">
                                <div class="card-block">
                                <div class="col my-4 mx-5 card-body">
                                <a href="../laporan/laporan-bulanan.php">
                                    <i class="fa fa-money fa-6x"></i></a>
                                </div>
                                </div>
                                <div class="col my-4">
                                <div class="card-body">
                                    <a href="../laporan/laporan-bulanan.php" class="card-title"><h5><b>Transaksi Bulan Ini</b></h5></a>
                                    <p class="card-text"></p>
                                    <?php foreach ($pemasukan as $row) : ?>
                                    <a href="../laporan/filter-pemasukan.php" class="card-text"><b class="text-muted">Pemasukan	&nbsp;	&nbsp; : </b><b><?= rupiah($row["pemasukan"]); ?></b></a>
                                    <?php endforeach; ?>
                                    <p class="card-text"></p>
                                    <?php foreach ($pengeluaran as $row) : ?>
                                    <a href="../laporan/filter-pengeluaran.php" class="card-text"><b class="text-muted">Pengeluaran	&nbsp; : </b><b><?= rupiah($row["pengeluaran"]); ?></b></a>
                                    <?php endforeach; ?>
                                </div>
                                </div>
                            </div>
                            </div>
                            <div class="card col-sm-5 my-4" >
                            <div class="row no-gutters">
                                <div class="card-block">
                                <div class="col my-4 mx-5 card-body">
                                <a href="../berita/">
                                    <i class="fa fa-newspaper-o fa-6x"></i></a>
                                </div>
                                </div>
                                <div class="col my-4">
                                <div class="card-body">
                                    <a href="../berita/" class="card-title"><h5><b>Berita</b></h5></a>
                                    <p class="card-text"></p>
                                    <?php foreach ($terpublikasi as $row) : ?>
                                    <a href="../berita/" class="card-text"><b class="text-muted">Terpublikasi&nbsp;&nbsp; : </b><b><?= $row["terpublikasi"]; ?> Berita</b></a>
                                    <?php endforeach; ?>
                                    <p class="card-text"></p>
                                    <?php foreach ($pending as $row) : ?>
                                    <a href="../berita/" class="card-text"><b class="text-muted">Pending&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : </b><b><?= $row["pending"]; ?> Berita</b></a>
                                    <?php endforeach; ?>
                                </div>
                                </div>
                            </div>
                            </div>
                        <div class="card col-sm-5 my-4" >
                            <div class="row no-gutters">
                                <div class="card-block">
                                <div class="col my-4 mx-5 card-body">
                                <a href="../program-donasi/">
                                    <i class="fa fa-donate fa-6x"></i></a>
                                </div>
                                </div>
                                <div class="col my-4">
                                <div class="card-body">
                                    <a href="../program-donasi/" class="card-title"><h5><b>Program Donasi</b></h5></a>
                                    <p class="card-text"></p>
                                    <?php foreach ($donasiBerjalan as $row) : ?>
                                    <a href="../program-donasi/" class="card-text"><b><?= $row["Berjalan"]; ?> </b><b class="text-muted">Program Aktif</b></a>
                                    <?php endforeach; ?>
                                    <p class="card-text"></p>
                                    <?php foreach ($donasiPending as $row) : ?>
                                    <a href="../program-donasi/" class="card-text"><b><?= $row["Pending"]; ?> </b><b class="text-muted">Program Pending</b></a>
                                    <?php endforeach; ?>
                                </div>
                                </div>
                            </div>
                            </div>
                            <div class="card col-sm-5 my-4" >
                            <div class="row no-gutters">
                                <div class="card-block">
                                <div class="col my-4 mx-5 card-body">
                                <a href="../program-relawan/">
                                    <i class="fa fa-user-plus fa-6x"></i></a>
                                </div>
                                </div>
                                <div class="col my-4">
                                <div class="card-body">
                                    <a href="../program-relawan/" class="card-title"><h5><b>Program Relawan</b></h5></a>
                                    <p class="card-text"></p>
                                    <?php foreach ($relawanBerjalan as $row) : ?>
                                    <a href="../program-relawan/" class="card-text"><b><?= $row["Berjalan"]; ?> </b><b class="text-muted">Program Aktif</b></a>
                                    <?php endforeach; ?>
                                    <p class="card-text"></p>
                                    <?php foreach ($relawanPending as $row) : ?>
                                    <a href="../program-relawan/" class="card-text"><b><?= $row["Pending"]; ?> </b><b class="text-muted">Program Pending</b></a>
                                    <?php endforeach; ?>
                                </div>
                                </div>
                            </div>
                            </div>
                            </div>
                        </div>
                                

                           
                        </tbody>   
                        </div>
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
<?php include '../../component/admin/footer.php'; ?>