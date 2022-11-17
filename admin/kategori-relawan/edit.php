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


//ambil id program di URL
$id_kat_relawan = $_GET["id_kat_relawan"];

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

$kategoriRelawan = query("SELECT * FROM t_kat_relawan WHERE id_kat_relawan = $id_kat_relawan")[0];

//UPDATE
if (isset($_POST["submit"])) {

    $kategori_relawan      = $_POST["tb_kategori_relawan"];
    $ket_kategori_relawan      = $_POST["tb_ket_kategori_relawan"];
    $updated_by = $_SESSION["nama"];
    $updated_at = date("Y-m-d H:i:s");

    // GLOBAL UPDATE
    $query = "UPDATE t_kat_relawan SET
                    kategori_relawan         = '$kategori_relawan',
                    ket_kategori_relawan     = '$ket_kategori_relawan',
                    updated_by               = '$updated_by',
                    updated_at               = '$updated_at'
                  WHERE id_kat_relawan       = $id_kat_relawan
                ";


    mysqli_query($conn, $query);


    //cek keberhasilan
    if (mysqli_affected_rows($conn) > 0) {
        echo "
            <script>
                alert('Data berhasil diubah!');
                window.location.href = '../kategori-relawan'; 
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
                <i class="nav-icon fas fa-home mr-1"></i>Kategori relawan</a> >
            <a href="edit.php">
                <i class="nav-icon fas fa-cog mr-1"></i>Edit Kategori relawan</a>
        </div>
        <div class="form-profil">
            <div class="mt-2 regis-title">
                <h3>Edit Kategori relawan</h3>
            </div>
            <form action="" enctype="multipart/form-data" method="POST">
                <div class="form-group label-txt">
                    <div class="form-group mt-4 mb-3">
                        <label for="tb_kategori_relawan" class="label-txt">Nama Kategori Program relawan<span class="red-star">*</span></label>
                        <input type="text" id="tb_kategori_relawan" name="tb_kategori_relawan" class="form-control" placeholder="Nama kategori relawan" value="<?= $kategoriRelawan["kategori_relawan"]; ?>" Required>
                    </div>
                    <div class="form-group">
                        <label for="tb_ket_kategori_relawan" class="label-txt">Keterangan Kategori</label>
                        <textarea class="form-control" id="tb_ket_kategori_relawan" name="tb_ket_kategori_relawan" rows="6" placeholder="Keterangan Kategori relawan"><?= $kategoriRelawan["ket_kategori_relawan"]; ?></textarea>
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