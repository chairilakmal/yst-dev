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
                                        <td class="text-center">ID <br> Beasiswa</td>
                                        <td>Penerima</td>
                                        <td>Tanggal</td>
                                        <td>Nominal</td>
                                        <td>Status</td>

                                        <td class="justify-content-center">Aksi</td>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr>
                                        <td class="text-center">1</td>
                                        <td class="table-snipet1">TEST</td>
                                        <td>01-05-2022</td>
                                        <td>Rp. 20.000.000</td>
                                        <td>Pending</td>

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