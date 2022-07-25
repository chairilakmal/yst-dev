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
    $result = mysqli_query($conn, "SELECT * FROM t_donasi
                      LEFT JOIN t_program_donasi ON t_donasi.id_program_donasi = t_program_donasi.id_program_donasi
                      WHERE status_donasi = 'Diterima'      
                      ORDER BY id_donasi DESC
                        ");
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}


$result = query("SELECT * FROM t_donasi");

//    var_dump($donasiSaya);die;

?>
<?php include '../../component/admin/header.php'; ?>
<?php include '../../component/admin/sidebar.php'; ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <main>
        <div class="request-data">
            <div class="projects">
                <div class="page-title-link ml-4 mb-4">
                    <a href="../berita/index.php">
                        <i class="nav-icon fas fa-home mr-1"></i>Dashboard admin</a> >
                    <a href="laporan-donasi.php">
                        <i class="nav-icon fas fa-donate mr-1"></i>Laporan donasi</a>
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
                                        <td>Kode Donasi</td>
                                        <td>Tgl Donasi</td>
                                        <td>Nama Donatur</td>

                                        <td>Nominal</td>
                                        <td>Program Pilihan</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($result as $row) : ?>
                                        <tr>
                                            <td class="col-2"><?= $row["id_donasi"]; ?></td>
                                            <td class="col-2 "><?= date("d-m-Y", strtotime($row["tgl_donasi"])); ?></td>
                                            <td class="col-2 "><?= $row["nama_donatur"]; ?></td>

                                            <td class="col-2 "><?= rupiah($row["nominal_donasi"]); ?></td>
                                            <!-- <td class="table-snipet1"> -->
                                            <td class="col-6"><?= $row["nama_program_donasi"]; ?></td>


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
<?php include '../../component/admin/footer.php'; ?>