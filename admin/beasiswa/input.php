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

$selectNIK = query("SELECT * FROM t_meninggal
                WHERE is_approve = 'y' ");

$userQuery = query("SELECT * FROM t_meninggal
                    LEFT JOIN t_user 
                    ON t_meninggal.id_user = t_user.id_user               
                    GROUP BY t_meninggal.id_user 
                    ORDER BY t_meninggal.id_user DESC                
                    ");

if (isset($_POST["submit"])) {

    $Penerima          = $_POST["tb_penerima"];

    $Tanggal           = $_POST["tb_tgl_beasiswa"];

    $Nominal           = $_POST["tb_nominal"];

    $Keterangan        = $_POST["tb_ket_beasiswa"];
    $Keterangan        = htmlspecialchars($Keterangan);




    $query = "INSERT INTO t_beasiswa (user_id, tgl, nominal, keterangan)
                VALUES ('$Penerima','$Tanggal', '$Nominal', '$Keterangan')  
                     ";



    mysqli_query($conn, $query);
    // var_dump($query);die;

    //cek keberhasilan
    if (mysqli_affected_rows($conn) > 0) {
        echo "
            <script>
                alert('Data berhasil ditambahkan!');
            </script>
            ";
    } else {
        echo "
                <script>
                    alert('Data gagal ditambahkan!');
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
            <a href="../berita/index.php">
                <i class="nav-icon fas fa-home mr-1"></i>Dashboard admin</a> >
            <a href="index.php">
                <i class="nav-icon fas fa-cog mr-1"></i>Kelola Beasiswa</a> >
            <a href="input.php">
                <i class="nav-icon fas fa-cog mr-1"></i>Input Beasiswa</a>
        </div>
        <div class="form-profil">
            <div class="mt-2 regis-title">
                <h3>Input Beasiswa</h3>
            </div>
            <form action="" enctype="multipart/form-data" method="POST">
                <div class="form-group label-txt">
                    <div class="form-group mt-4 mb-3">
                        <label for="tb_kategori">Penerima<span class="red-star">*</span></label></label>
                        <select class="form-control" id="tb_penerima" name="tb_penerima" required>
                            <option value="" selected disabled>Pilih NIK</option>;
                            <?php foreach ($userQuery as $row) : ?>
                                <option value="<?= $row["id_user"]; ?>"><?= $row["nik"]; ?></option>';
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group mt-4 mb-3" id="tgl_selesai_form">
                        <label for="tb_tgl_beasiswa" class="label-txt">Tanggal<span class="red-star">*</span></label>
                        <input type="date" id="tb_tgl_beasiswa" name="tb_tgl_beasiswa" class="form-control">
                    </div>
                    <div class="form-group mt-4 mb-3">
                        <label for="tb_nominal" class="label-txt">Nominal<span class="red-star">*</span></label>
                        <input type="number" id="tb_nominal" name="tb_nominal" class="form-control" placeholder="Masukan nominal beasiswa" Required>
                    </div>
                    <div class="form-group">
                        <label for="tb_ket_beasiswa" class="label-txt">Keterangan</label>
                        <textarea class="form-control" id="tb_ket_beasiswa" name="tb_ket_beasiswa" rows="6" placeholder="Keterangan"></textarea>
                    </div>
                </div>
                <button type="submit" name="submit" value="Simpan" class="btn btn-lg btn-primary w-100 yst-login-btn border-0 mt-4 mb-4">
                    <span class="yst-login-btn-fs">Simpan</span>
                </button>
            </form>
        </div>
    </main>
</div>
<!-- /.container-fluid -->
<!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php include '../../component/admin/footer.php'; ?>