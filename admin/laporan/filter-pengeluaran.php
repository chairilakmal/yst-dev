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



$laporanKeuangan = query("SELECT * FROM t_lap_keuangan WHERE status ='1'");

$totalNominal = query("SELECT SUM(nominal) AS total_nominal FROM t_lap_keuangan WHERE status='1'");






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
                                        Status
                                    </a>

                                    <div class="dropdown-menu green-drop" aria-labelledby="dropdownMenuLink">
                                        <a class="dropdown-item" href="filter-pemasukan.php">Pemasukan</a>
                                        <a class="dropdown-item" href="filter-pengeluaran.php">Pengeluaran</a>
                                    </div>
                                    <style>
                                    .dropdown {
                                    position: relative;
                                    display: inline-block;
                                    }

                                    .dropdown-content {
                                    display: none;
                                    position: absolute;
                                    min-width: 160px;
                                    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
                                    padding: 12px 16px;
                                    z-index: 1;
                                    }

                                    .dropdown:hover .dropdown-content {
                                    display: block;
                                    }
                                    </style>
                                    <div class="dropdown">
                                    <a class="btn btn-info  filter-btn dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown">
                                        Bulan
                                    </a>

                                    <div class="dropdown-menu green-drop" aria-labelledby="dropdownMenuLink">
                                        <a class="dropdown-item" href="../filter-bulan-laporan-bulanan/Januari.php">Januari</a>
                                        <a class="dropdown-item" href="../filter-bulan-laporan-bulanan/Ferbuari.php">Ferbuari</a>
                                        <a class="dropdown-item" href="../filter-bulan-laporan-bulanan/Maret.php">Maret</a>
                                        <a class="dropdown-item" href="../filter-bulan-laporan-bulanan/April.php">April</a>
                                        <a class="dropdown-item" href="../filter-bulan-laporan-bulanann/Mei.php">Mei</a>
                                        <a class="dropdown-item" href="../filter-bulan-laporan-bulanan/Juni.php">Juni</a>
                                        <a class="dropdown-item" href="../filter-bulan-laporan-bulanan/Juli.php">Juli</a>
                                        <a class="dropdown-item" href="../filter-bulan-laporan-bulanan/Agustus.php">Agustus</a>
                                        <a class="dropdown-item" href="../filter-bulan-laporan-bulanan/September.php">September</a>
                                        <a class="dropdown-item" href="../filter-bulan-laporan-bulanann/Oktober.php">Oktober</a>
                                        <a class="dropdown-item" href="../filter-bulan-laporan-bulanan/November.php">November</a>
                                        <a class="dropdown-item" href="../filter-bulan-laporan-bulanan/Desember.php">Desember</a>

                                    </div>
                        </div>
                            </div>
                        </div>
                        <div>
                        <button class="mr-2" onclick="location.href='input-pemasukan.php'">Pemasukan <span class="fas fa-plus-square"></span></button>
                        <button class="btn bg-transparent" onclick="location.href='input-pengeluaran.php'">Pengeluaran <span class="fas fa-plus-square"></span></button>
                        </div>
                </div>

                <div class="card-body card-body-req">
                        <div class="table-responsive">
                            <table width="100%">
                                <thead>
                                <tr>
                                        <td>No. Referensi</td>
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
                                            <td><?= $row["nomor_referensi"] ?></td>
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

                                <thead>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td class="justify-content-center">Total Nominal</td>
                                    </tr>
                                </thead>
                                <tbody>
                                 <?php foreach ($totalNominal as $row) : ?>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td class="justify-content-center"><?= rupiah($row["total_nominal"]); ?></td>
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
