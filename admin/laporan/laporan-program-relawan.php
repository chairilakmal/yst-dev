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
                    WHERE status_program_relawan = 'Selesai'                    
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
                    <a href="laporan-program-relawan.php">
                        <i class="nav-icon fas fa-cog mr-1"></i>Laporan program relawan</a>
                </div>

                <div class="card card-request-data">
                    <div class="card-header-req">
                        <div class="row ml-1 ">
                            <div class="col ">
                                <div class="dropdown show ">

                                    <div class="dropdown-menu green-drop" aria-labelledby="dropdownMenuLink">
                                        <a class="dropdown-item" href="#">Terbaru</a>
                                        <a class="dropdown-item" href="#">Pending</a>
                                        <a class="dropdown-item" href="#">Disetujui</a>
                                        <a class="dropdown-item" href="#">Ditolak</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button class="mr-5" onclick="window.print();">Cetak Laporan <span class="fa fa-print"></span></button>

                    </div>
                    <div class="card-body card-body-req">
                        <div class="table-responsive">
                            <table width="100%">
                                <thead>
                                    <tr>
                                        <td>Kode<br> Program</td>
                                        <td class="col-2">Nama Program Relawan</td>
                                        <td class="col-2">Lokasi Pelaksanaan </td>
                                        <td class="col-2">Relawan Terkumpul</td>
                                        <td class="col-2">Tgl Pelaksanaan </td>
                                        <td class="col-2">Penanggung Jawab </td>


                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($programRelawan as $row) : ?>
                                        <tr>
                                            <td><?= $row["id_program_relawan"]; ?></td>
                                            <td class="col-2"><?= $row["nama_program_relawan"]; ?></td>
                                            <td class="col-2"><?= $row["lokasi_program"]; ?></td>
                                            <td class="col-2 text-center"><?= $row['jumlah_relawan'] == 0 ? '0' : $row['jumlah_relawan']; ?></td>
                                            <td class="col-2"><?= $row["tgl_pelaksanaan"]; ?></td>
                                            <td class="col-2"><?= $row["penanggung_jawab"]; ?></td>

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