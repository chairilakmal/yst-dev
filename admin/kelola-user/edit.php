<?php
session_start();
include '../../config/connection.php';


if (!isset($_SESSION["username"])) {
    header('Location: login.php?status=restrictedaccess');
    exit;
}


//ambil id program di URL
$id_user = $_GET["id_user"];


//fungsi GET Array
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

$userQuery = query("SELECT * FROM t_user WHERE id_user = $id_user")[0];

//UPDATE
if (isset($_POST["submit"])) {

    $level_user             = $_POST["tb_level_user"];


    // GLOBAL UPDATE
    $query = "UPDATE t_user SET
                    level_user        = '$level_user'
                  WHERE id_user       = $id_user
                ";


    mysqli_query($conn, $query);


    //cek keberhasilan
    if (mysqli_affected_rows($conn) > 0) {
        echo "
            <script>
                alert('Data berhasil diubah!');
                window.location.href = 'kelola-user.php'; 
            </script>
        ";
    } else {
        echo "
                <script>
                    alert('Tidak ada perubahan data');
                </script>
            ";
    }
}

?>
<?php include '../../component/admin/header.php'; ?>
<?php include '../../component/admin/sidebar.php'; ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <main>
        <div class="page-title-link ml-4 mb-4">
            <a href="kelola-user.php">
                <i class="nav-icon fas fa-home mr-1"></i>Kelola User</a> >
            <a href="edit-user.php">
                <i class="nav-icon fas fa-cog mr-1"></i>Edit User</a>
        </div>
        <div class="form-profil">
            <div class="mt-2 form-title">
                <h3>Edit User</h3>
            </div>
            <form action="" enctype="multipart/form-data" method="POST">
                <div class="form-segment">
                    <h5>Data Diri</h5>
                </div>
                <!-- FORM DATA DIRI -->
                <div class="form-group label-txt">
                    <div class="form-group mt-4 mb-3">
                        <label for="tb_nama_lengkap" class="label-txt">Nama<span class="red-star">*</span></label>
                        <input type="text" id="tb_nama_lengkap" name="tb_nama_lengkap" class="form-control" value="<?= $userQuery["nama"]; ?>" readonly>
                    </div>
                    <div class="form-group mt-4 mb-3">
                        <label for="tb_nik" class="label-txt">NIK<span class="red-star">*</span></label>
                        <input type="text" id="tb_nik" name="tb_nik" class="form-control" value="<?= $userQuery["nik"]; ?>" readonly>
                    </div>
                    <div class="form-group mt-4 mb-3">
                        <label for="tb_wilayah" class="label-txt">Wilayah Regional<span class="red-star">*</span></label>
                        <input type="text" id="tb_wilayah" name="tb_wilayah" class="form-control" value="<?= $userQuery["wilayah_id"]; ?>" readonly>
                    </div>
                    <div class="form-group mt-4 mb-3">
                        <label for="tb_no_hp" class="label-txt">No HP<span class="red-star">*</span></label>
                        <input type="text" id="tb_no_hp" name="tb_no_hp" class="form-control" value="<?= $userQuery["no_hp"]; ?>" readonly>
                    </div>
                    <div class="form-group mt-4 mb-3">
                        <label for="tb_email" class="label-txt">Email<span class="red-star">*</span></label>
                        <input type="text" id="tb_email" name="tb_email" class="form-control" value="<?= $userQuery["email"]; ?>" readonly>
                    </div>
                    <div class="form-group mt-4 mb-3">
                        <label for="tb_username" class="label-txt">username<span class="red-star">*</span></label>
                        <input type="text" id="tb_username" name="tb_username" class="form-control" value="<?= $userQuery["username"]; ?>" readonly>
                    </div>

                    <div class="form-group mb-5">
                        <label for="tb_level_user" class="font-weight-bold"><span class="label-form-span">Level User</span></label><br>
                        <div class="radio-wrapper mt-1 bg-white">
                            <div class="form-check form-check-inline">
                                <input type="radio" id="tb_level_user" name="tb_level_user" class="form-check-input" value="1" <?php if ($userQuery['level_user'] == 1) echo 'checked' ?>>
                                <label class="form-check-label" for="tb_level_user">Level 1</label>
                            </div>
                        </div>
                        <div class="radio-wrapper mt-1 bg-white">
                            <div class="form-check form-check-inline">
                                <input type="radio" id="tb_level_user" name="tb_level_user" class="form-check-input" value="2" <?php if ($userQuery['level_user'] == 2) echo 'checked' ?>>
                                <label class="form-check-label" for="tb_level_user">Level 2</label>
                            </div>
                        </div>
                        <div class="radio-wrapper mt-1 bg-white">
                            <div class="form-check form-check-inline">
                                <input type="radio" id="tb_level_user" name="tb_level_user" class="form-check-input" value="3" <?php if ($userQuery['level_user'] == 3) echo 'checked' ?>>
                                <label class="form-check-label" for="tb_level_user">Level 3</label>
                            </div>
                        </div>
                        <div class="radio-wrapper mt-1 bg-white">
                            <div class="form-check form-check-inline">
                                <input type="radio" id="tb_level_user" name="tb_level_user" class="form-check-input" value="4" <?php if ($userQuery['level_user'] == 4) echo 'checked' ?>>
                                <label class="form-check-label" for="tb_level_user">Level 4</label>
                            </div>
                        </div>
                        <div class="form-group mb-2"><br><br></div>
                    </div>
                </div>

                <!-- FORM DATA KELUARGA -->
                <div id="dynamic_field">
                    <div class="form-segment">
                        <div class="row d-flex justify-content-center">
                            <div class="col-lg-3">
                                <button type="button" name="add" id="add" value="Simpan" class="btn btn-lg btn-primary yst-login-btn border-0 ">
                                    <span class="yst-login-btn-sm">Tambah Data Keluarga (+)</span>
                                </button>
                            </div>
                        </div>

                    </div>

                </div>


                <button type="submit" name="submit" value="Simpan" class="btn btn-lg btn-primary w-100 yst-login-btn border-0 mt-4 mb-4">
                    <span class="yst-login-btn-fs">Kirim</span>
                </button>
            </form>
        </div>
    </main>
</div>
<!-- /.container-fluid -->
<!-- /.content -->
</div>
<!-- /.content-wrapper -->

<footer class="main-footer">
    <center><strong> &copy; YST 2021.</strong> Yayasan Sekar Telkom </center>
</footer>

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->


<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>

<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- overlayScrollbars -->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>

<script>
    $(document).ready(function() {
        var i = 0;
        $('#add').click(function() {
            i++;
            $('#dynamic_field').append('<div id="form-keluarga' + i + '"><div class="row justify-content-start"><div class="col-auto "><h5 class="mt-3">Data Keluarga ' + i + '</h5></div><div class="col-lg-3 mt-2"><button type="button" name="remove" id="' + i + '" class="btn btn-danger btn_remove">X</button></div></div><div class="form-group label-txt mt-4 py-3 data-keluarga-border"><div class="form-group mt-3 mb-3"><label for="tb_nama" class="label-txt">Nama<span class="red-star">*</span></label><input type="text" id="tb_nama" name="tb_nama" class="form-control"></div><div class="form-group mt-4 mb-3"><label for="tb_nik" class="label-txt">NIK<span class="red-star">*</span></label><input type="text" id="tb_nik" name="tb_nik" class="form-control"></div><div class="form-group mt-4 mb-3"><label for="tb_jk" class="label-txt">Jenis Kelamin<span class="red-star">*</span></label><input type="text" id="tb_jk" name="tb_jk" class="form-control"></div><div class="form-group mt-4 mb-3"><label for="tb_tempat_lahir" class="label-txt">Tempat Lahir<span class="red-star">*</span></label><input type="text" id="tb_tempat_lahir" name="tb_tempat_lahir" class="form-control"></div><div class="form-group mt-4 mb-3"><label for="tb_tgl_lahir" class="label-txt">Tanggal Lahir<span class="red-star">*</span></label><input type="date" id="tb_tgl_lahir" name="tb_tgl_lahir" class="form-control"></div><div class="form-group mt-4 mb-3"><label for="tb_agama" class="label-txt">Agama<span class="red-star">*</span></label><input type="text" id="tb_agama" name="tb_agama" class="form-control"></div><div class="form-group mt-4 mb-3"><label for="tb_pendidikan" class="label-txt">Pendidikan<span class="red-star">*</span></label><input type="text" id="tb_pendidikan" name="tb_pendidikan" class="form-control"></div><div class="form-group mt-4 mb-3"><label for="tb_pekerjaan" class="label-txt">Pekerjaan<span class="red-star">*</span></label><input type="text" id="tb_pekerjaan" name="tb_pekerjaan" class="form-control"></div><div class="form-group mt-4 mb-3"><label for="tb_status_kawin">Status Kawin<span class="red-star">*</span></label></label><select class="form-control" id="tb_status_kawin" name="tb_status_kawin"><option value="" selected disabled>Pilih Status Kawin</option><option value="">Belum Kawin</option><option value="">Kawin Tercatat</option><option value="">Kawin Belum Tercatat</option><option value="">Cerai Hidup</option><option value="">Cerai Mati</option></select></div><div class="form-group mt-4 mb-3"><label for="tb_status_keluarga">Status Hubungan Keluarga<span class="red-star">*</span></label></label><select class="form-control" id="tb_status_keluarga" name="tb_status_keluarga"><option value="" selected disabled>Pilih Status Keluarga</option><option value="">Kepala Keluarga</option><option value="">Suami</option><option value="">Istri</option><option value="">Anak</option><option value="">Menantu</option><option value="">Cucu</option><option value="">Orang Tua</option><option value="">Mertua</option><option value="">Famili Lain</option><option value="">Pembantu</option></select></div></div></div>');
        });
        $(document).on('click', '.btn_remove', function() {
            var button_id = $(this).attr("id");
            $('#form-keluarga' + button_id + '').remove();
            i--;
        });
        $('#submit').click(function() {
            $.ajax({
                url: "name.php",
                method: "POST",
                data: $('#add_name').serialize(),
                success: function(data) {
                    alert(data);
                    $('#add_name')[0].reset();
                }
            });
        });
    });
</script>
</body>

</html>