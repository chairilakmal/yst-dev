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
$id_lap_keuangan = $_GET["id_lap_keuangan"];


function rupiah($angka)
{
    $hasil_rupiah = "Rp. " . number_format($angka, 0, '.', '.');
    return $hasil_rupiah;
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


$lapKeuangan = query("SELECT * FROM t_lap_keuangan WHERE id_lap_keuangan = $id_lap_keuangan")[0];



if (isset($_POST["submit"])) {

    $tanggal          = $_POST['tb_tanggal'];
    $nomorReferensi   = $_POST['tb_nomor_referensi'];
    $nominal          = $_POST['tb_nominal'];
    $sumber           = $_POST['tb_sumber'];
    $keterangan       = $_POST['tb_keterangan'];
    $updated_by       = $_SESSION["nama"];
    $updated_at       = date('Y-m-d H:i:s');


    $query = "UPDATE t_lap_keuangan SET
        tanggal         = '$tanggal',
        nomor_referensi = '$nomorReferensi',
        nominal         = '$nominal',
        sumber          = '$sumber',
        keterangan      = '$keterangan',
        updated_by      = '$updated_by',
        updated_at      = '$updated_at' 
        WHERE id_lap_keuangan     = $id_lap_keuangan
        ";


    mysqli_query($conn, $query);
    // var_dump($query);die;

    //cek keberhasilan
    if (mysqli_affected_rows($conn) > 0) {
        echo "
            <script>
                alert('Data berhasil diubah !');
                window.location.href = 'laporan-bulanan.php';
            </script>
            ";
    } else {
        echo "
                <script>
                    alert('Data gagal diubah !');
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
            <a href="laporan-bulanan.php">
                <i class="nav-icon fas fa-donate mr-1"></i>Laporan bulanan</a> >
            <a href="edit.php?id_lap_keuangan=<?= $row["id_lap_keuangan"]; ?>">
                <i class="nav-icon fas fa-cog mr-1"></i>Edit</a>
        </div>
        <div class="form-profil">
            <div class="mt-2 regis-title">
                <h3>Edit</h3>
            </div>
            <form action="" enctype="multipart/form-data" method="POST">
                <input type="hidden" name="id_lap_keuangan" value="<?= $lapKeuangan["id_lap_keuangan"]; ?>">
                <input type="hidden" name="status" value="<?= $lapKeuangan["status"]; ?>">
                <div class="form-group label-txt">
                    <div class="form-group mt-4 mb-3">
                        <!-- <div class="form-group">
                            <label for="tb_sumber" class="label-txt">Tipe Pengeluaran<span class="red-star">*</span></label>
                            <textarea class="form-control" id="tb_tipe_pengeluaran" name="tb_tipe_pengeluaran" rows="1" disabled Required>
                                
                        </div> -->
                        <div class="form-group mt-4 mb-3">
                            <label for="tb_tanggal" class="label-txt">Tanggal<span class="red-star">*</span></label>
                            <input type="date" id="tb_tanggal" name="tb_tanggal" class="form-control" value="<?= $lapKeuangan["tanggal"]; ?>" Required>
                        </div>
                        <div class="form-group mt-4 mb-3">
                            <label for="tb_nomor_referensi" class="label-num">Nomor Referensi</label>
                            <input type="number" lang="en" id="tb_nomor_referensi" name="tb_nomor_referensi" class="form-control" placeholder="Masukan nomor referensi" value="<?= $lapKeuangan["nomor_referensi"]; ?>">
                        </div>
                        <div class="form-group mt-4 mb-3">
                            <label for="tb_nominal" class="label-num">Nominal<span class="red-star">*</span></label>
                            <input type="number" lang="en" id="tb_nominal" name="tb_nominal" class="form-control" placeholder="Masukkan Nominal" value="<?= $lapKeuangan["nominal"]; ?>" Required>
                        </div>
                        <div class="form-group">
                            <label for="tb_sumber" class="label-txt">Sumber Dana<span class="red-star">*</span></label>
                            <textarea class="form-control" id="tb_sumber" name="tb_sumber" placeholder="Masukkan sumber dana" Required><?= $lapKeuangan["sumber"]; ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="tb_keterangan" class="label-txt">Keterangan</label>
                            <textarea class="form-control" id="tb_keterangan" name="tb_keterangan" placeholder="Keterangan"><?= $lapKeuangan["keterangan"]; ?></textarea>
                        </div>
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