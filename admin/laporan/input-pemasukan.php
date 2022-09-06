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


if (isset($_POST["submit"])) {

    $bulan            = $_POST['tb_bulan'];
    $tanggal          = $_POST['tb_tanggal'];
    $nominal          = $_POST['tb_nominal'];
    $sumber           = $_POST['tb_sumber'];
    $keterangan       = $_POST['tb_keterangan'];
    $status           = 1;
    
    
    $laporanKeuangan = "INSERT INTO  t_lap_keuangan(bulan,tanggal,nominal,sumber,keterangan,status)
                VALUES ('$bulan','$tanggal','$nominal','$sumber','$keterangan','$status')";


    mysqli_query($conn, $laporanKeuangan);
    // var_dump($laporanKeuangan);die;

    //cek keberhasilan
    if (mysqli_affected_rows($conn) > 0) {
        echo "
            <script>
                alert('Data berhasil ditambahkan!');
                window.location.href = 'laporan-bulanan.php';
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
            <a href="laporan-bulanan.php">
                <i class="nav-icon fas fa-home mr-1"></i>Dashboard admin</a> >
            <a href="laporan-bulanan.php">
                <i class="nav-icon fas fa-donate mr-1"></i>Laporan bulanan</a> >
            <a href="input-pemasukan.php">
                <i class="nav-icon fas fa-cog mr-1"></i>Input pemasukan</a> 

        </div>
        <div class="form-profil">
            <div class="mt-2 regis-title">
                <h3>Input Pemasukan</h3>
            </div>
            <form action="" enctype="multipart/form-data" method="POST">
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
                        <input type="date" id="tb_tanggal" name="tb_tanggal" class="form-control" >
                    </div>
                    <div class="form-group mt-4 mb-3">
                        <label for="tb_nominal" class="label-num">Nominal<span class="red-star">*</span></label>
                        <input type="number" id="tb_nominal" name="tb_nominal" class="form-control" placeholder="Masukan nominal pemasukan" Required>
                    </div>
                    <div class="form-group">
                        <label for="tb_sumber" class="label-txt">Sumber Dana</label>
                        <textarea class="form-control" id="tb_sumber" name="tb_sumber" placeholder="Masukkan sumber dana"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="tb_keterangan" class="label-txt">Keterangan</label>
                        <textarea class="form-control" id="tb_keterangan" name="tb_keterangan" placeholder="Keterangan"></textarea>
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