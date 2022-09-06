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

$laporanKeuangan = query("SELECT * FROM t_lap_keuangan WHERE id_lap_keuangan = $id_lap_keuangan")[0];
// var_dump($laporanKeuangan);
// die;

//UPDATE
if (isset($_POST["submit"])) {

    $id_lap_keuangan            = $_POST["id_lap_keuangan"];
    $bulan                      = $_POST['tb_bulan'];
    $tanggal                    = $_POST["tb_tanggal"];
    $nominal                    = $_POST["tb_nominal"];
    $sumber                     = $_POST["tb_sumber"];
    $keterangan                 = $_POST["tb_keterangan"];


    // GLOBAL UPDATE
    $query = "UPDATE t_lap_keuangan SET
                    bulan                        = '$bulan',
                    tanggal                      = '$tanggal',
                    nominal                      = '$nominal',
                    sumber                       = '$sumber', 
                    keterangan                   = '$keterangan',
                           
                    WHERE id_lap_keuangan              = $id_lap_keuangan
                ";
    // var_dump($query);
    // die();

    mysqli_query($conn, $query);


    //cek keberhasilan
    if (mysqli_affected_rows($conn) > 0) {
        echo "
            <script>
                alert('Data berhasil diubah!');
                window.location.href = 'laporan-bulanan.php';
            </script>
        ";
    } else {
        echo "
                <script>
                    alert('Data gagal diubah!');
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
            <a href="laporan-bulanan.php">
                <i class="nav-icon fas fa-home mr-1"></i>Dashboard admin</a> >
            <a href="laporan-bulanan.php">
                <i class="nav-icon fas fa-cog mr-1"></i>Laporan Bulanan</a> >
            <a href="edit.php">
                <i class="nav-icon fas fa-plus-square mr-1"></i>Edit</a>
        </div>
        <div class="form-profil">
            <div class="mt-2 regis-title">
                <h3>Edit</h3>
            </div>



            <form action="" enctype="multipart/form-data" method="POST">
            <input type="hidden" name="id_lap_keuangan" value="<?= $id_lap_keuangan["id_lap_keuangan"]; ?>">
                <div class="form-group label-txt">
                    <div class="form-group mt-4 mb-3">
                        <label for="tb_bulan">Bulan<span class="red-star">*</span></label></label>
                        <select name="tb_bulan">
                        <option selected="selected">Bulan</option>
                        <?php
                        $bulan=array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
                        $jlh_bln=count($bulan);
                        for($c=0; $c<$jlh_bln; $c+=1){
                            echo"<option value=$bulan[$c]> $bulan[$c] </option>";
                        }
                        ?>
                        </select>

                    </div>
                    <div class="form-group mt-4 mb-3" id="tgl_selesai_form">
                        <label for="tb_tanggal" class="label-txt">Tanggal<span class="red-star">*</span></label>
                        <input type="date" id="tb_tanggal" name="tb_tanggal" class="form-control" value="<?= $laporanKeuangan["tanggal"]; ?>" >
                    </div>
                    <div class="form-group mt-4 mb-3">
                        <label for="tb_nominal" class="label-num">Nominal<span class="red-star">*</span></label>
                        <input type="number" id="tb_nominal" name="tb_nominal" class="form-control" value="<?= $laporanKeuangan["nominal"]; ?>">
                    </div>
                    <div class="form-group">
                    <label for="tb_sumber" class="label-txt">Sumber Dana<span class="red-star">*</span></label>
                        <input type="text" id="tb_sumber" name="tb_sumber" class="form-control" value="<?= $laporanKeuangan["sumber"]; ?>">
                    </div>
                    <div class="form-group">
                    <label for="tb_keterangan" class="label-txt">Keterangan</label>
                        <input type="text" id="tb_keterangan" name="tb_keterangan" class="form-control" value="<?= $laporanKeuangan["keterangan"]; ?>">
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