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
                      WHERE status_relawan = 'Diterima' 
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



                        </div>
                        <button class="mr-5" onclick="window.print();">Cetak Laporan <span class="fa fa-print"></span></button>

                    </div>
                    <div class="card-body card-body-req">
                        <div class="table-responsive">
                            <table width="100%">
                                <thead>
                                    <tr>
                                        <td>Kode Relawan</td>
                                        <td class="col-2">Nama Relawan</td>
                                        <td class="col-2">Program Pilihan</td>
                                        <td class="col-2">Tgl Pelaksanaan</td>
                                        <td class="col-2">Domisili</td>
                                        <td class="col-2">Nomor HP</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($result as $row) : ?>
                                        <tr>
                                            <td><?= $row["id_relawan"]; ?></td>
                                            <td class="col-2"><?= $row["nama_lengkap"]; ?></td>
                                            <td class="col-4"><?= $row["nama_program_relawan"]; ?></td>
                                            <td class="col-2"><?= date("d-m-Y", strtotime($row["tgl_pelaksanaan"])); ?></td>
                                            <td class="col-2"><?= $row["domisili"]; ?></td>
                                            <td class="col-2"><?= $row["no_hp"]; ?></td>

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