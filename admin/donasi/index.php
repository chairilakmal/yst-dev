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
    $result = mysqli_query($conn, "SELECT * FROM t_donasi
                      LEFT JOIN t_program_donasi ON t_donasi.id_program_donasi = t_program_donasi.id_program_donasi
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
                    <a href="dashboard-admin.php">
                        <i class="nav-icon fas fa-home mr-1"></i>Dashboard admin</a> >
                    <a href="kelola-donasi.php">
                        <i class="nav-icon fas fa-donate mr-1"></i>Kelola donasi</a>
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
                                        <a class="dropdown-item" href="#">Tampilkan Semua</a>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="card-body card-body-req">
                        <div class="table-responsive">
                            <table width="100%" class="text-center">
                                <thead>
                                    <tr>
                                        <td>Kode<br>Donasi</td>
                                        <td>Nama Donatur</td>
                                        <td>Tgl Donasi</td>
                                        <td>Nominal</td>
                                        <td>Kode Program <br>Pilihan</td>
                                        <td>Status Donasi</td>
                                        <td class="justify-content-center">Aksi</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($result as $row) : ?>
                                        <tr>
                                            <td><?= $row["id_donasi"]; ?></td>
                                            <td><?= $row["nama_donatur"]; ?></td>
                                            <td><?= $row["tgl_donasi"]; ?></td>
                                            <td><?= rupiah($row["belum_dibayar"]); ?></td>
                                            <!-- <td class="table-snipet1"> -->
                                            <td class="text-center"><?= $row["id_program_donasi"]; ?></td>
                                            <td><?= $row["status_donasi"]; ?></td>
                                            <td class="justify-content-center">
                                                <button type="button" class="btn btn-edit">
                                                    <a href="edit.php?id_donasi=<?= $row["id_donasi"]; ?>" class="fas fa-edit"></a>
                                                </button>
                                                <button type="button" class="btn btn-delete ml-1">
                                                    <a href="../../hapus.php?type=donasi&id_donasi=<?= $row["id_donasi"]; ?>" class="far fa-trash-alt" onclick="return confirm('Anda yakin ingin menghapus donasi ini ?');"></a>
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