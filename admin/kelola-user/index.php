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


$wilayahQuery = query("SELECT
                tu.*,tw.nama_wilayah,torg.nama_jabatan
                FROM
                t_users tu
                LEFT JOIN t_wilayah tw ON tu.wilayah_id = tw.id_wilayah
                LEFT JOIN t_organigram torg ON tu.id_user = torg.user_id
                WHERE tu.level_user != 1
                ORDER BY
                tu.id_user");

// print_r($wilayahQuery);exit;

// var_dump($wilayahQuery);die;


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
                        <i class="nav-icon fas fa-cog mr-1"></i>Kelola User</a>
                </div>

                <div class="card card-request-data">
                    <div class="card-header-req">
                        <div class="row ml-1 ">
                            <div class="col ">

                            </div>
                        </div>
                    </div>
                    <div class="card-body card-body-req">
                        <div class="table-responsive">
                            <table width="100%">
                                <thead>
                                    <tr>
                                        <td class="text-center">No</td>
                                        <td>Nama Lengkap</td>
                                        <!-- <td>Username</td> -->
                                        <td>Jabatan</td>

                                        <td>Wilayah</td>

                                        <td class="justify-content-center">Aksi</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    foreach ($wilayahQuery as $row) : ?>
                                        <tr>
                                            <td class="text-center"><?= $i++ ?></td>
                                            <td class="table-snipet1"><?= $row["nama"]; ?></td>
                                            <td><?= 
                                            $row["nama_jabatan"] ? $row["nama_jabatan"] : '-' ?></td>
                                            <td><?= $row["nama_wilayah"]; ?></td>

                                            <td class="justify-content-center">
                                                <button type="button" class="btn btn-edit">
                                                    <a href="edit.php?id_user=<?= $row["id_user"]; ?>" class="fas fa-edit"></a>
                                                </button>
                                                <button type="button" class="btn btn-delete ml-1">
                                                    <a href="../../hapus.php?type=manageuser&id_user=<?= $row["id_user"]; ?>" class="far fa-trash-alt" onclick="return confirm('Anda yakin ingin menghapus user ini ?');"></a>
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