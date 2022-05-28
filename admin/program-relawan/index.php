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
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

// WHERE status_donasi = 'Diterima'
//    COUNT(id_user) AS jumlah_relawan
// var_dump($programDonasi);die;
$programRelawan = query("SELECT *, SUM(t_relawan.relawan_jadi) AS jumlah_relawan
                    FROM t_relawan
                    RIGHT JOIN t_program_relawan
                    ON t_program_relawan.id_program_relawan = t_relawan.id_program_relawan                 
                    GROUP BY t_program_relawan.id_program_relawan ORDER BY t_program_relawan.id_program_relawan DESC
                    ");

//    function query($query){
//        global $conn;
//         $result = mysqli_query($conn, "SELECT * FROM t_program_relawan"); 
//         $rows = [];
//         while($row = mysqli_fetch_assoc($result)){
//             $rows[] = $row;
//         }
//         return $rows;
//    }



//    $programRelawan = query("SELECT * FROM t_program_relawan");

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
                    <a href="kelola-p-relawan.php">
                        <i class="nav-icon fas fa-cog mr-1"></i>Program relawan</a>
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
                        <button class="mr-5" onclick="location.href='input.php'">Input Program Relawan<span class="fas fa-plus-square"></span></button>

                    </div>
                    <div class="card-body card-body-req">
                        <div class="table-responsive">
                            <table width="100%">
                                <thead>
                                    <tr>
                                        <td>ID</td>
                                        <td>Nama Program</td>
                                        <td>Lokasi Pelaksanaan </td>

                                        <td>Tgl Pelaksanaan </td>
                                        <td>Relawan Terkumpul</td>
                                        <td>Jumlah Target Relawan</td>
                                        <td>Status Program</td>
                                        <td class="justify-content-center">Aksi</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($programRelawan as $row) : ?>
                                        <tr>
                                            <td><?= $row["id_program_relawan"]; ?></td>
                                            <td class="table-snipet1"><?= $row["nama_program_relawan"]; ?></td>
                                            <td class="table-snipet2"><?= $row["lokasi_program"]; ?></td>

                                            <td><?= $row["tgl_pelaksanaan"]; ?></td>
                                            <td><?= $row['jumlah_relawan'] == 0 ? '0' : $row['jumlah_relawan']; ?></td>
                                            <td><?= $row["target_relawan"]; ?></td>
                                            <td>
                                                <?= $row["status_program_relawan"]; ?>
                                            </td>
                                            <td class="justify-content-center">
                                                <button type="button" class="btn btn-edit">
                                                    <a href="edit.php?id_program_relawan=<?= $row["id_program_relawan"]; ?>" class="fas fa-edit"></a>
                                                </button>
                                                <button type="button" class="btn btn-delete ml-1">
                                                    <a href="../../hapus.php?type=prelawan&id_program_relawan=<?= $row["id_program_relawan"]; ?>" class="far fa-trash-alt" onclick="return confirm('Anda yakin ingin menghapus program ini ?');"></a>
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