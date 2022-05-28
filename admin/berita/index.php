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
//Berita
function queryBerita($query)
{
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

$berita = queryBerita("SELECT *
                    FROM t_berita ORDER BY id_berita DESC
                    ");

//    function query($query){
//        global $conn;
//         $result = mysqli_query($conn, "SELECT * FROM t_program_donasi"); 
//         $rows = [];
//         while($row = mysqli_fetch_assoc($result)){
//             $rows[] = $row;
//         }
//         return $rows;
//    }


//    $programDonasi = query("SELECT * FROM t_program_donasi");

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
                    <a href="dashboard-admin.php">
                        <i class="nav-icon fas fa-cog mr-1"></i>Program donasi</a>
                </div>

                <div class="card card-request-data">
                    <div class="card-header-req">
                        <div class="row ml-1 ">

                        </div>
                        <button class="mr-5" onclick="location.href='input.php'">Input Berita <span class="fas fa-plus-square"></span></button>

                    </div>
                    <div class="card-body card-body-req">
                        <div class="table-responsive">
                            <table width="100%">
                                <thead>
                                    <tr>
                                        <td class="text-center">Kode <br> Berita</td>
                                        <td>Judul Berita</td>
                                        <td>Tanggal Kejadian</td>
                                        <td>Tanggal Penulisan</td>
                                        <td>Status Berita</td>
                                        <td class="justify-content-center">Aksi</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($berita as $row) : ?>
                                        <tr>
                                            <td class="text-center"><?= $row["id_berita"]; ?></td>
                                            <td class="table-snipet1"><?= $row["judul_berita"]; ?></td>
                                            <td><?= date("d-m-Y", strtotime($row["tgl_kejadian"])); ?></td>
                                            <td><?= date("d-m-Y", strtotime($row["tgl_penulisan"])); ?></td>

                                            <td><?php
                                                if ($row['status_berita'] == 1) {
                                                    echo 'Pending';
                                                } else {
                                                    echo 'Publikasi';
                                                } ?></td>

                                            <td class="justify-content-between">
                                                <button type="button" class="btn btn-edit">
                                                    <a href="edit.php?id_berita=<?= $row["id_berita"]; ?>" class="fas fa-edit"></a>
                                                </button>

                                                <!-- <php if($row['status_program_donasi'] == 'Siap disalurkan' || $row['status_program_donasi'] == 'Selesai'){?>
                                                    <button type="button" class="btn btn-edit">
                                                        <a href="edit-program-donasi.php?id_program_donasi=<= $row["id_program_donasi"]; ?>" class="fa fa-upload"></a>
                                                    </button>
                                                    <php } ?> -->

                                                <button type="button" class="btn btn-delete ml-1">
                                                    <a href="../../hapus.php?type=berita&id_berita=<?= $row["id_berita"]; ?>" class="far fa-trash-alt" onclick="return confirm('Anda yakin ingin menghapus program ini ?');"></a>
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