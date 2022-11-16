<?php
session_start();
include '../../config/connection.php';

// var_dump($_SESSION["wilayah_id"]);die;

if (!isset($_SESSION["username"])) {
    header('Location: ../../login.php?status=restrictedaccess');
    exit;
}


if ($_SESSION["level_user"] == 4) {
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
function rupiah($angka)
{
    $hasil_rupiah = "Rp. " . number_format($angka, 0, '.', '.');
    return $hasil_rupiah;
}

$currentWilayah = $_SESSION["wilayah_id"];

if ($_SESSION["level_user"] == '2a' || $_SESSION["level_user"] == '2b') {
    $getBeasiswa = query("SELECT * FROM t_beasiswa
                   LEFT JOIN t_meninggal ON t_beasiswa.user_nik = t_meninggal.nik      
                   ORDER BY t_beasiswa.is_approve ASC     
                    ");
} else {
    $getBeasiswa = query("SELECT * FROM t_beasiswa
                   LEFT JOIN t_meninggal ON t_beasiswa.user_nik = t_meninggal.nik        
                   WHERE wilayah_id = $currentWilayah    
                   ORDER BY t_beasiswa.is_approve ASC        
                    ");
}

// var_dump($getBeasiswa);
// die;
// $getBeasiswa = query("SELECT * FROM t_beasiswa");



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
                    <a href="index.php">
                        <i class="nav-icon fas fa-cog mr-1"></i>Kelola Beasiswa</a>
                </div>

                <div class="card card-request-data">
                    <div class="card-header-req">
                        <div class="row ml-1 ">
                            <!-- <div class="col ">
                                            <div class="dropdown show ">
                                            <a class="btn btn-info  filter-btn dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Filter
                                            </a>
                                            <div class="dropdown-menu green-drop" aria-labelledby="dropdownMenuLink">
                                                <a class="dropdown-item" href="status-berjalan.php">Berjalan</a>
                                            </div>
                                        </div>
                                    </div> -->
                        </div>
                        <button class="mr-5" onclick="location.href='input.php'">Input Beasiswa <span class="fas fa-plus-square"></span></button>

                    </div>
                    <div class="card-body card-body-req">
                        <div class="table-responsive">
                            <table width="100%">
                                <thead>
                                    <tr>
                                        <td class="text-center">No</td>
                                        <td>Penerima</td>
                                        <td>Tanggal Pengajuan</td>
                                        <td>Nominal</td>
                                        <td>Status</td>

                                        <td class="justify-content-center">Aksi</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    foreach ($getBeasiswa as $row) : ?>
                                        <tr>
                                            <td class="text-center"><?= $i++ ?></td>
                                            <td class="table-snipet1"><?= $row["nama"]; ?></td>
                                            <td><?= $row["tgl"]; ?></td>
                                            <td><?= rupiah($row["total_nominal"]); ?></td>
                                            <td>
                                                <?php
                                                if ($row['is_approve'] == 1) {
                                                    echo 'Approved';
                                                } else {
                                                    echo 'Menunggu Approval';
                                                } ?></td>
                                            </td>

                                            <td class="justify-content-center">
                                                <?php if ($_SESSION['level_user'] == '2a' || $_SESSION['level_user'] == '1') { ?>
                                                    <button type="button" class="btn btn-edit">
                                                        <a href="edit.php?id_beasiswa=<?= $row["id_beasiswa"]; ?>" class="fas fa-edit"></a>
                                                    </button>
                                                <?php } ?>
                                                <?php if ($_SESSION['level_user'] == '2b') { ?>
                                                    <button type="button" class="btn btn-edit">
                                                        <a href="form-approved.php?id_beasiswa=<?= $row["id_beasiswa"]; ?>" class="fas fa-edit"></a>
                                                    </button>
                                                <?php } ?>
                                                <button type="button" class="btn btn-delete ml-1">
                                                    <a href="../../hapus.php?type=beasiswa&id_beasiswa=<?= $row["id_beasiswa"]; ?>" class="far fa-trash-alt" onclick="return confirm('Anda yakin ingin menghapus data ini ?');"></a>
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