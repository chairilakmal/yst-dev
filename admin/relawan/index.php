<?php

session_start();
include '../../config/connection.php';


if (!isset($_SESSION["username"])) {
    header('Location: login.php?status=restrictedaccess');
    exit;
}

function query($query)
{
    global $conn;
    $result = mysqli_query($conn, "SELECT * FROM t_relawan
                      LEFT JOIN t_program_relawan ON t_relawan.id_program_relawan = t_program_relawan.id_program_relawan
                      ORDER BY id_relawan DESC
                        ");
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}


$result = query("SELECT * FROM t_relawan");
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
                    <a href="kelola-relawan.php">
                        <i class="nav-icon fas fa-user-cog mr-1"></i>Kelola relawan</a>
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
                            <table width="100%">
                                <thead>
                                    <tr>
                                        <td>Kode<br> Relawan</td>
                                        <td>Nama Relawan</td>
                                        <td class="text-center">Kode Program Relawan</td>
                                        <td>Tgl Pelaksanaan</td>
                                        <td>Status Relawan</td>
                                        <td class="justify-content-center">Aksi</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($result as $row) : ?>
                                        <tr>
                                            <td><?= $row["id_relawan"]; ?></td>
                                            <td class="table-snipet2"><?= $row["nama_lengkap"]; ?></td>
                                            <td class="table-snipet2 text-center"><?= $row["id_program_relawan"]; ?></td>
                                            <td><?= $row["tgl_pelaksanaan"]; ?></td>
                                            <td><?= $row["status_relawan"]; ?></td>
                                            <td class="justify-content-center">
                                                <button type="button" class="btn btn-edit">
                                                    <a href="edit.php?id_relawan=<?= $row["id_relawan"]; ?>" class="fas fa-edit"></a>
                                                </button>
                                                <button type="button" class="btn btn-delete ml-1">
                                                    <a href="../../hapus.php?type=relawan&id_relawan=<?= $row["id_relawan"]; ?>" class="far fa-trash-alt" onclick="return confirm('Anda yakin ingin menghapus relawan ini ?');"></a>
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