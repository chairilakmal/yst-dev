<?php

session_start();
include '../../config/connection.php';


if (!isset($_SESSION["username"])) {
    header('Location: login.php?status=restrictedaccess');
    exit;
}

// function query($query)
// {
//     global $conn;
//     $result = mysqli_query($conn, $query);
//     $rows = [];
//     while ($row = mysqli_fetch_assoc($result)) {
//         $rows[] = $row;
//     }
//     return $rows;
// }

// $userQuery = query("SELECT * FROM t_user
//                     ORDER BY id_user                   
//                     ");
// $organigram = query("SELECT * FROM t_organigram
//                     ORDER BY user_id
//                     ");


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
                    <a href="kelola-user.php">
                        <i class="nav-icon fas fa-cog mr-1"></i>Kelola User Non Aktif</a>
                </div>

                <div class="card card-request-data">
                    <div class="card-header-req">
                        <div class="row ml-1 ">

                        </div>
                        <button class="mr-5" onclick="location.href='input.php'">Tambah Data <span class="fas fa-plus-square"></span></button>
                    </div>
                    <div class="card-body card-body-req">
                        <div class="table-responsive">
                            <table width="100%">
                                <thead>
                                    <tr>
                                        <td class="text-center">ID <br> User</td>
                                        <td>NIK</td>
                                        <td>Tanggal</td>
                                        <td>Tempat</td>
                                        <td>Penyebab</td>

                                        <td class="justify-content-center">Aksi</td>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr>
                                        <td class="text-center">1</td>
                                        <td class="table-snipet1">TEST</td>
                                        <td>01-05-2022</td>
                                        <td>Bandung</td>
                                        <td>Sakit Jantung</td>

                                        <td class="justify-content-center">
                                            <button type="button" class="btn btn-edit">
                                                <a href="edit.php" class="fas fa-edit"></a>
                                            </button>
                                            <button type="button" class="btn btn-delete ml-1">
                                                <a href="#" class="far fa-trash-alt" onclick="return confirm('Anda yakin ingin menghapus user ini ?');"></a>
                                            </button>
                                        </td>
                                    </tr>

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