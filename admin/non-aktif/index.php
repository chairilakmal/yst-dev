<?php

session_start();
include '../../config/connection.php';


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

$currentWilayah = $_SESSION["wilayah_id"];

if ($_SESSION["level_user"] == '1' || $_SESSION["level_user"] == '2a' || $_SESSION["level_user"] == '2b') {
    $userQuery = query("SELECT * FROM t_meninggal ORDER BY id_meninggal DESC");
} else {
    $userQuery = query("SELECT * FROM t_meninggal WHERE wilayah_id = $currentWilayah ORDER BY id_meninggal DESC");
}

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
                        <i class="nav-icon fas fa-cog mr-1"></i>Kelola Data Meninggal</a>
                </div>

                <div class="card card-request-data">
                    <div class="card-header-req">
                        <div class="row ml-1 ">
                        </div>
                        <?php if ($_SESSION['level_user'] == 1 || $_SESSION['level_user'] == '2b' || $_SESSION['level_user'] == 3) { ?>
                            <button class="mr-5" onclick="location.href='input.php'">Tambah Data <span class="fas fa-plus-square"></span></button>
                        <?php } ?>
                    </div>
                    <div class="card-body card-body-req">
                        <div class="table-responsive">
                            <table width="100%">
                                <thead>
                                    <tr>
                                        <td>NIK</td>
                                        <td>Nama</td>
                                        <td>Tanggal Meninggal</td>
                                        <!-- <td>Penyebab</td> -->
                                        <td class="justify-content-center">Aksi</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($userQuery as $row) : ?>
                                        <tr>
                                            <td class="table-snipet1"><?= $row["nik"]; ?></td>
                                            <td class=""><?= $row["nama"]; ?></td>
                                            <td>
                                                <?php echo date("d-m-Y", strtotime($row['tgl_meninggal'])) ?>
                                            </td>

                                            <td class="justify-content-center">
                                                <?php if ($_SESSION['level_user'] == 1 || $_SESSION['level_user'] == '2b' || $_SESSION['level_user'] == 3) { ?>
                                                    <button type="button" class="btn btn-edit">
                                                        <a href="edit.php?id_meninggal=<?= $row["id_meninggal"]; ?>" class="fas fa-edit"></a>
                                                    </button>
                                                <?php } ?>
                                                <button type="button" class="btn btn-delete ml-1">
                                                    <a href="../../hapus.php?type=nonaktif&id_meninggal=<?= $row["id_meninggal"]; ?>" class="far fa-trash-alt" onclick="return confirm('Anda yakin ingin menghapus user ini ?');"></a>
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