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

$laporanKeuangan = query("SELECT *
                    FROM t_lap_keuangan WHERE status ='1'
                    ");

?>
<?php include '../../component/admin/header.php'; ?>
<?php include '../../component/admin/sidebar.php'; ?>

<div class="content-wrapper">
    <main>
        <div class="request-data">
            <div class="projects">
                <div class="page-title-link ml-4 mb-4">
                    <a href="laporan-bulanan.php">
                        <i class="nav-icon fas fa-home mr-1"></i>Dashboard admin</a> >
                    <a href="laporan-bulanan.php">
                        <i class="nav-icon fas fa-donate mr-1"></i>Laporan bulanan</a>
                </div>

                <div class="card card-request-data">
                    <div class="card-header-req">

                            <div class="col ">
                                <div class="dropdown show ">
                                    <a class="btn btn-info  filter-btn dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Filter
                                    </a>
                                    <div class="dropdown-menu green-drop" aria-labelledby="dropdownMenuLink">
                                        <a class="dropdown-item" href="filter-bulan.php">Bulan</a>
                                        <a class="dropdown-item" href="filter-pemasukan.php">Pemasukan</a>
                                        <a class="dropdown-item" href="filter-pengeluaran.php">Pengeluaran</a>
                                    </div>
                              
                            </div>
                        </div>
                        <button class="mr-2" onclick="location.href='input-pemasukan.php'">Pemasukan <span class="fas fa-plus-square"></span></button>
                        <button class="btn bg-transparent" onclick="location.href='input-pengeluaran.php'">Pengeluaran <span class="fas fa-plus-square"></span></button>

                </div>
                
                <div class="card-body card-body-req">
                        <div class="table-responsive">
                            <table width="100%">
                                <thead>
                                <tr>
                                        <td>Tanggal</td>
                                        <td>Nominal</td>
                                        <td>Sumber Dana</td>
                                        <td>Status</td>
                                        <td class="justify-content-center">Aksi</td>
                                </tr>
                                </thead>

                                <tbody>
                                <?php foreach ($laporanKeuangan as $row) : ?>
                                        <tr>
                                            <td><?= date("d F Y", strtotime($row["tanggal"])); ?></td>
                                            <td><?= rupiah($row["nominal"]); ?></td>
                                            <td><?= $row["sumber"]; ?></td>
                                            <td><?php
                                                if ($row['status'] == 0) {
                                                    echo 'Pemasukan';
                                                } else {
                                                    echo 'Pengeluaran';
                                                } ?></td>

                                            <td class="justify-content-center">
                                                <button type="button" class="btn btn-edit">
                                                    <a href="edit.php?id_lap_keuangan=<?= $row["id_lap_keuangan"]; ?>" class="fas fa-edit"></a>
                                                </button>
                                                <button type="button" class="btn btn-delete ml-1">
                                                    <a href="../../hapus.php?type=laporanbulanan&id_lap_keuangan=<?= $row["id_lap_keuangan"]; ?>" class="far fa-trash-alt" onclick="return confirm('Anda yakin ingin menghapus data ini ?');"></a>
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