<?php
session_start();
include '../../config/connection.php';


if (!isset($_SESSION["username"])) {
    header('Location: login.php?status=restrictedaccess');
    exit;
}


//ambil id program di URL
$id_kat_donasi = $_GET["id_kat_donasi"];

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

$kategoriDonasi = query("SELECT * FROM t_kat_donasi WHERE id_kat_donasi = $id_kat_donasi")[0];

//UPDATE
if (isset($_POST["submit"])) {

    $kategori_donasi      = $_POST["tb_kategori_donasi"];
    $ket_kategori_donasi      = $_POST["tb_ket_kategori_donasi"];

    // GLOBAL UPDATE
    $query = "UPDATE t_kat_donasi SET
                    kategori_donasi         = '$kategori_donasi',
                    ket_kategori_donasi     = '$ket_kategori_donasi'
                  WHERE id_kat_donasi       = $id_kat_donasi
                ";


    mysqli_query($conn, $query);


    //cek keberhasilan
    if (mysqli_affected_rows($conn) > 0) {
        echo "
            <script>
                alert('Data berhasil diubah!');
                window.location.href = 'kelola-kat-donasi.php'; 
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
            <a href="kelola-kat-donasi.php">
                <i class="nav-icon fas fa-home mr-1"></i>Kategori Donasi</a> >
            <a href="input-kategori-donasi.php">
                <i class="nav-icon fas fa-cog mr-1"></i>Edit Kategori Donasi</a>
        </div>
        <div class="form-profil">
            <div class="mt-2 regis-title">
                <h3>Edit Kategori Donasi</h3>
            </div>
            <form action="" enctype="multipart/form-data" method="POST">
                <div class="form-group label-txt">
                    <div class="form-group mt-4 mb-3">
                        <label for="tb_kategori_donasi" class="label-txt">Nama Kategori Program Donasi<span class="red-star">*</span></label>
                        <input type="text" id="tb_kategori_donasi" name="tb_kategori_donasi" class="form-control" placeholder="Nama kategori donasi" value="<?= $kategoriDonasi["kategori_donasi"]; ?>" Required>
                    </div>
                    <div class="form-group">
                        <label for="tb_ket_kategori_donasi" class="label-txt">Keterangan Kategori</label>
                        <textarea class="form-control" id="tb_ket_kategori_donasi" name="tb_ket_kategori_donasi" rows="6" placeholder="Keterangan Kategori Donasi"><?= $kategoriDonasi["ket_kategori_donasi"]; ?></textarea>
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