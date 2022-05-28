<?php

session_start();
include '../../config/connection.php';

if (!isset($_SESSION["username"])) {
    header('Location: login.php?status=restrictedaccess');
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

// WHERE status_donasi = 'Diterima'

// var_dump($programDonasi);die;
$programDonasi = query("SELECT *, SUM(t_donasi.nominal_donasi) AS dana_terkumpul_total, 
                    COUNT(id_user) 
                    AS jumlah_donatur 
                    FROM t_donasi 
                    RIGHT JOIN t_program_donasi 
                    ON t_program_donasi.id_program_donasi = t_donasi.id_program_donasi                 
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
                                        Filter
                                    </a>
                                    <div class="dropdown-menu green-drop" aria-labelledby="dropdownMenuLink">
                                        <a class="dropdown-item" href="status-berjalan.php">Berjalan</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button class="mr-5" onclick="location.href='input.php'">Input Program Donasi <span class="fas fa-plus-square"></span></button>

                    </div>
                    <div class="card-body card-body-req">
                        <div class="table-responsive">
                            <table width="100%">
                                <thead>
                                    <tr>
                                        <td class="text-center">Kode <br> Program</td>
                                        <td>Nama Program</td>
                                        <td>Jangka Waktu</td>
                                        <td>Dana Terkumpul</td>
                                        <td>Target Dana</td>
                                        <td class="text-center">Jumlah <br> Donatur</td>

                                        <td class="text-center">Status<br> Program</td>
                                        <td class="justify-content-center">Aksi</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($programDonasi as $row) : ?>
                                        <tr>
                                            <td class="text-center"><?= $row["id_program_donasi"]; ?></td>
                                            <td class="table-snipet1"><?= $row["nama_program_donasi"]; ?></td>
                                            <td>
                                                <?php
                                                if ($row['jangka_waktu'] == 0) {
                                                    echo 'Tidak Tetap';
                                                } else {
                                                    echo 'Tetap';
                                                } ?></td>
                                            </td>
                                            <td><?= rupiah($row['dana_terkumpul_total']) == 0 ? '0' : rupiah($row['dana_terkumpul_total']); ?></td>
                                            <td><?= rupiah($row["target_dana"]); ?></td>
                                            <td class="text-center"><?= $row["jumlah_donatur"]; ?></td>

                                            <td class="text-center">
                                                <?= $row["status_program_donasi"]; ?>
                                            </td>
                                            <td class="justify-content-between">
                                                <button type="button" class="btn btn-edit">
                                                    <a href="edit.php?id_program_donasi=<?= $row["id_program_donasi"]; ?>" class="fas fa-edit"></a>
                                                </button>

                                                <!-- <php if($row['status_program_donasi'] == 'Siap disalurkan' || $row['status_program_donasi'] == 'Selesai'){?>
                                                    <button type="button" class="btn btn-edit">
                                                        <a href="edit-program-donasi.php?id_program_donasi=<= $row["id_program_donasi"]; ?>" class="fa fa-upload"></a>
                                                    </button>
                                                    <php } ?> -->

                                                <button type="button" class="btn btn-delete ml-1">
                                                    <a href="../../hapus.php?type=pdonasi&id_program_donasi=<?= $row["id_program_donasi"]; ?>" class="far fa-trash-alt" onclick="return confirm('Anda yakin ingin menghapus program ini ?');"></a>
                                                </button>
                                            </td>
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