<?php

session_start();
include '../../config/connection.php';

function rupiah($angka)
{
    $hasil_rupiah = "Rp. " . number_format($angka, 0, '.', '.');
    return $hasil_rupiah;
}

if (!isset($_SESSION["username"])) {
    header('Location: ../../login.php?status=restrictedaccess');
    exit;
}

if ($_SESSION["level_user"] == 4){
    header('Location: ../../user/dashboard-donasi/dashboard-user.php');
    exit;
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

// WHERE status_donasi = 'Selesai'

// var_dump($programDonasi);die;
$programDonasi = query("SELECT *, SUM(t_donasi.nominal_donasi) AS dana_terkumpul_total, 
                    COUNT(id_user) 
                    AS jumlah_donatur 
                    FROM t_donasi 
                    RIGHT JOIN t_program_donasi
                    ON t_program_donasi.id_program_donasi = t_donasi.id_program_donasi 
                    WHERE status_program_donasi = 'Selesai'                 
                    GROUP BY t_program_donasi.id_program_donasi ORDER BY t_program_donasi.id_program_donasi DESC
                    ");

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
                        <i class="nav-icon fas fa-home mr-1"></i>Dashboard user</a> >
                    <a href="laporan-program-donasi.php">
                        <i class="nav-icon fas fa-user-cog mr-1"></i>Laporan Program Donasi</a>
                </div>

                <div class="card card-request-data">
                    <div class="card-header-req">
                        <div class="row ml-1 ">
                            <div class="col ">
                                <div class="dropdown show ">

                                    <div class="dropdown-menu green-drop" aria-labelledby="dropdownMenuLink">
                                        <a class="dropdown-item" href="#">Terbaru</a>
                                        <a class="dropdown-item" href="#">Perlu Verifikasi</a>
                                        <a class="dropdown-item" href="#">Selesai</a>
                                        <a class="dropdown-item" href="#">Bermasalah</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button class="mr-5" onclick="window.print();">Cetak Laporan <span class="fa fa-print"></span></button>

                    </div>
                    <div class="card-body card-body-req">
                        <div class="table-responsive">
                            <table width="100%">
                                <thead>
                                    <tr>
                                        <td>Kode<br> Program</td>
                                        <td class="col-2">Nama Program Donasi</td>
                                        <td class="col-2">Dana Disalurkan</td>
                                        <td class="col-2">Tanggal Disalurkan</td>
                                        <td class="col-2">Penerima Donasi</td>
                                        <td class="col-2">Penanggung Jawab</td>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($programDonasi as $row) : ?>
                                        <tr>
                                            <td><?= $row["id_program_donasi"]; ?></td>
                                            <td class="col-2"><?= $row["nama_program_donasi"]; ?></td>
                                            <td class="col-2"><?= rupiah($row['dana_terkumpul_total']) == 0 ? '0' : rupiah($row['dana_terkumpul_total']); ?></td>
                                            <td class="col-2"><?= date("d-m-Y", strtotime($row["tgl_penyaluran"])); ?></td>
                                            <td class="col-2"><?= $row["penerima_donasi"]; ?></td>
                                            <td class="col-2"><?= $row["penanggung_jawab"]; ?></td>
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