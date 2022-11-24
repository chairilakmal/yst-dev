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

    $tanggal          = $_POST['tb_tanggal'];
    $nomorReferensi   = $_POST['tb_nomor_referensi'];
    $nominal          = $_POST['tb_nominal'];
    $unmaskedNom      = preg_replace('/[^0-9\-]/', '', $nominal);
    $sumber           = $_POST['tb_sumber'];
    $keterangan       = $_POST['tb_keterangan'];
    $status           = 0;
    $created_by       = $_SESSION["nama"];


    $query = "INSERT INTO  t_lap_keuangan(tanggal,nomor_referensi,nominal,sumber,keterangan,status, created_by)
                VALUES ('$tanggal','$nomorReferensi','$unmaskedNom','$sumber','$keterangan','$status','$created_by')";

    mysqli_query($conn, $query);
    // var_dump($query);die;

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
                    <div class="form-group mt-4 mb-3" id="tb_tanggal">
                        <label for="tb_tanggal" class="label-txt">Tanggal<span class="red-star">*</span></label>
                        <input type="date" id="tb_tanggal" name="tb_tanggal" class="form-control" value="<?php echo date("Y-m-d"); ?>">
                    </div>
                    <div class="form-group mt-4 mb-3">
                        <label for="tb_nomor_referensi" class="label-num">Nomor Referensi</label>
                        <input type="text" id="tb_nomor_referensi" name="tb_nomor_referensi" class="form-control" placeholder="Masukan nomor referensi">
                    </div>
                    <div class="form-group mt-4 mb-3">
                        <label for="tb_nominal" class="label-num">Nominal<span class="red-star">*</span></label>
                        <input type="text" id="tb_nominal" name="tb_nominal" class="form-control" placeholder="Masukan nominal pemasukan" onkeyup="handleNominal()" Required>
                    </div>
                    <div class="form-group">
                        <label for="tb_sumber" class="label-txt">Sumber Dana<span class="red-star">*</span></label>
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
<script>
    function formatRupiah(angka, prefix) {
        var number_string = angka.toString().replace(/[^,\d]/g, ''),
            split = number_string.split(','),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }
        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
    }

    function handleNominal() {
        var value = document.getElementById("tb_nominal").value;
        console.log(formatRupiah(value, 'Rp. '))
        document.querySelector('input[name="tb_nominal"]').value = formatRupiah(value, 'Rp. ');
    }
</script>
</main>
</div>
<!-- /.container-fluid -->
<!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php include '../../component/admin/footer.php'; ?>