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


//ambil id program di URL
$id = $_GET["id"];

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


$plafonBeasiswa = query("SELECT * FROM t_plafon_beasiswa
                    WHERE id = $id
                    ")[0];

// var_dump($plafonBeasiswa);
// die;

//UPDATE
if (isset($_POST["submit"])) {

    $jenjang                  = $_POST["tb_jenjang"];
    $nominal                  = $_POST["tb_nominal"];

    // GLOBAL UPDATE
    $query = "UPDATE t_plafon_beasiswa SET
                    jenjang                 = '$jenjang',
                    nominal                 = '$nominal'
                  WHERE id                  = $id
                ";


    mysqli_query($conn, $query);


    //cek keberhasilan
    if (mysqli_affected_rows($conn) > 0) {
        echo "
            <script>
                alert('Data berhasil diubah!');
                window.location.href = 'index.php'; 
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
            <a href="index.php">
                <i class="nav-icon fas fa-home mr-1"></i>Plafon Beasiswa</a> >
            <a href="edit.php">
                <i class="nav-icon fas fa-cog mr-1"></i>Edit Plafon Beasiswa</a>
        </div>
        <div class="form-profil">
            <div class="mt-2 regis-title">
                <h3>Edit Plafon Beasiswa</h3>
            </div>
            <form action="" enctype="multipart/form-data" method="POST">
                <div class="form-group label-txt">
                    <div class="form-group mt-4 mb-3">
                        <label for="tb_jenjang" class="label-txt">Jenjang<span class="red-star">*</span></label>
                        <input type="text" id="tb_jenjang" name="tb_jenjang" class="form-control" placeholder="" value="<?= $plafonBeasiswa["jenjang"]; ?>" Required>
                    </div>
                    <div class="form-group">
                        <label for="tb_nominal" class="label-txt">Nominal</label>
                        <input type="number" id="tb_nominal" name="tb_nominal" class="form-control" placeholder="" value="<?= $plafonBeasiswa["nominal"]; ?>" Required>
                    </div>
                </div>
                <button type="submit" name="submit" value="Simpan" class="btn btn-lg btn-primary w-100 yst-login-btn border-0 mt-4 mb-4">
                    <span class="yst-login-btn-fs">Edit Kategori</span>
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