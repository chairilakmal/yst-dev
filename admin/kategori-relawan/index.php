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

$kategoriRelawan = query("SELECT * FROM t_kat_relawan
                    ORDER BY id_kat_relawan
                    
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
                        <i class="nav-icon fas fa-home mr-1"></i>Dashboard admin</a> >
                    <a href="index.php">
                        <i class="nav-icon fas fa-cog mr-1"></i>Kategori Relawan</a>
                </div>

                <div class="card card-request-data">
                    <div class="card-header-req">
                        <div class="row ml-1 ">
                            <div class="col ">

                            </div>
                        </div>
                        <button class="mr-5" onclick="location.href='input.php'">Input Kategori Relawan <span class="fas fa-plus-square"></span></button>

                    </div>
                    <div class="card-body card-body-req">
                        <div class="table-responsive">
                            <table width="100%">
                                <thead>
                                    <tr>
                                        <td class="text-center">Kode <br> Kategori</td>
                                        <td>Nama Kategori</td>
                                        <td></td>
                                        <td></td>
                                        <td class="justify-content-center">Aksi</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($kategoriRelawan as $row) : ?>
                                        <tr>
                                            <td class="text-center"><?= $row["id_kat_relawan"]; ?></td>
                                            <td class="table-snipet1"><?= $row["kategori_relawan"]; ?></td>
                                            <td></td>
                                            <td></td>
                                            <td class="justify-content-center">
                                                <button type="button" class="btn btn-edit">
                                                    <a href="edit.php?id_kat_relawan=<?= $row["id_kat_relawan"]; ?>" class="fas fa-edit"></a>
                                                </button>
                                                <button type="button" class="btn btn-delete ml-1">
                                                    <a href="../../hapus.php?type=katrelawan&id_kat_relawan=<?= $row["id_kat_relawan"]; ?>" class="far fa-trash-alt" onclick="return confirm('Anda yakin ingin menghapus kategori ini ?');"></a>
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