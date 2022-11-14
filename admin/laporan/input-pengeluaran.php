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

$beasiswaQuery = query("SELECT * FROM t_beasiswa 
                LEFT JOIN t_meninggal 
                ON t_beasiswa.user_nik = t_meninggal.nik
                LEFT JOIN t_wilayah 
                ON t_meninggal.wilayah_id = t_wilayah.id_wilayah
                WHERE is_approve = 1 ");

function upload()
{
    //upload gambar
    $namaFile = $_FILES['image_uploads']['name'];
    $ukuranFile = $_FILES['image_uploads']['size'];
    $error = $_FILES['image_uploads']['error'];
    $tmpName = $_FILES['image_uploads']['tmp_name'];

    //  if($error === 4){
    //      echo "
    //          <script>
    //              alert('gambar tidak ditemukan !');
    //          </script>
    //      ";
    //      return false;
    //  }

    //cek ekstensi gambar
    $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
    $ekstensiGambar = explode('.', $namaFile);
    $ekstensiGambar = strtolower(end($ekstensiGambar));

    // if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
    //     echo "
    //                  <script>
    //                      alert('kesalahan pada format gambar !');
    //                  </script>
    //              ";
    //     return false;
    // }

    //generate nama baru
    $namaFileBaru = uniqid();
    $namaFileBaru .= '.';
    $namaFileBaru .= $ekstensiGambar;


    //lolos pengecekan
    move_uploaded_file($tmpName, '../../img/' . $namaFileBaru);

    return $namaFileBaru;
}

// die;


if (isset($_POST["submit"])) {

    $tanggal          = $_POST['tb_tanggal'];
    $tipe             = $_POST['tb_tipe_pengeluaran'];

    if ($tipe == 1) {
        $nominal      = $_POST['tb_nominal'];
    } else {
        $nominal      = $_POST['tb_nominal_beasiswa'];
    }

    $sumber           = $_POST['tb_sumber'];
    $keterangan       = $_POST['tb_keterangan'];
    $status           = 1;

    $beasiswa_id      = $_POST['tb_beasiswa'] ? $_POST['tb_beasiswa'] : 0;

    // $bukti_transfer   =  isset($_FILES["image_uploads"]) ? 'tru' :  'fals';
    if ($_FILES['image_uploads']['name'] !== "") {
        $bukti_transfer   = upload();
    } else {
        $bukti_transfer   = null;
    }
    // var_dump($_POST['tb_nominal_beasiswa']);
    // die;

    // GLOBAL UPDATE
    $query = "INSERT INTO t_lap_keuangan (
        tanggal,
        nominal,
        sumber,
        keterangan,
        beasiswa_id,
        status,
        bukti_transfer)
            VALUES (
                '$tanggal', 
                '$nominal',
                '$sumber',
                '$keterangan',
                '$beasiswa_id',
                '$status',
                '$bukti_transfer')";

    mysqli_query($conn, $query);
    // var_dump($query);
    // die;

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

<div class="content-wrapper">
    <main>
        <div class="page-title-link ml-4 mb-4">
            <a href="laporan-bulanan.php">
                <i class="nav-icon fas fa-home mr-1"></i>Dashboard admin</a> >
            <a href="laporan-bulanan.php">
                <i class="nav-icon fas fa-donate mr-1"></i>Laporan bulanan</a> >
            <a href="input-pengeluaran.php">
                <i class="nav-icon fas fa-cog mr-1"></i>Input pengeluaran</a>
        </div>
        <div class="form-profil">
            <div class="mt-2 regis-title">
                <h3>Input Pengeluaran</h3>
            </div>
            <form action="" enctype="multipart/form-data" method="POST">
                <div class="form-group mt-4 mb-3">
                    <label for="tb_tipe_pengeluaran">Tipe Pengeluaran<span class="red-star">*</span></label></label>
                    <select class="form-control" id="tb_tipe_pengeluaran" name="tb_tipe_pengeluaran" required onchange="handleType()">
                        <option value="1" selected>Umum</option>
                        <option value="2">Beasiswa</option>
                    </select>
                </div>
                <div id="field_beasiswa" class="form-group mt-4 mb-3 d-none">
                    <label for="tb_beasiswa">Pilih Beasiswa<span class="red-star">*</span></label></label>
                    <select class="form-control" id="tb_beasiswa" name="tb_beasiswa" onchange="handleBeasiswa()">
                        <option value="" selected>Pilih Beasiswa</option>;
                        <?php foreach ($beasiswaQuery as $row) : ?>
                            <option value="<?= $row["id_beasiswa"]; ?>" data-nominal="<?= $row["total_nominal"]; ?>">
                                Beasiswa Pendidikan Keluarga <?php echo $row['nama']; ?> <?php echo $row['kode_wilayah']; ?> ( <?php echo date("d-m-Y", strtotime($row['tgl'])); ?> )
                            </option>';
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group mt-4 mb-3" id="tgl_selesai_form">
                    <label for="tb_tanggal" class="label-txt">Tanggal<span class="red-star">*</span></label>
                    <input type="date" id="tb_tanggal" name="tb_tanggal" class="form-control" value="<?php echo date("Y-m-d"); ?>">
                </div>

                <!-- Nominal Umum -->
                <div id="nominal_umum" class="form-group mt-4 mb-3">
                    <label for="tb_nominal" class="label-num">Nominal<span class="red-star">*</span></label>
                    <input type="number" id="tb_nominal" name="tb_nominal" class="form-control" placeholder="Masukan nominal pengeluaran" value="">
                </div>
                <!-- Nominal Beasiswa -->
                <div id="nominal_beasiswa" class="form-group mt-4 mb-3 d-none">
                    <label for="tb_nominal_beasiswa" class="label-num">Nominal Beasiswa<span class="red-star">*</span></label>
                    <input type="number" id="tb_nominal_beasiswa" name="tb_nominal_beasiswa" class="form-control" placeholder="Masukan nominal pengeluaran" readonly>
                </div>

                <div class="form-group">
                    <label for="tb_sumber" class="label-txt">Sumber Dana<span class="red-star">*</label>
                    <input type="text" class="form-control" id="tb_sumber" name="tb_sumber" placeholder="Masukkan sumber dana" Required></input>
                </div>
                <div class="form-group">
                    <label for="tb_keterangan" class="label-txt">Keterangan</label>
                    <textarea class="form-control" id="tb_keterangan" name="tb_keterangan" rows="4" placeholder="Keterangan"></textarea>
                </div>
                <div class="form-group">
                    <label for="image_uploads" class="label-txt">Bukti Transfer</label>
                    <div class="file-form">
                        <input type="file" id="image_uploads" name="image_uploads" class="form-control">
                    </div>
                </div>
        </div>
        <button type="submit" name="submit" value="Simpan" class="btn btn-lg btn-primary w-100 yst-login-btn border-0 mt-4 mb-4">
            <span class="yst-login-btn-fs">Simpan</span>
        </button>
        </form>
</div>

<script>
    var fieldType = document.getElementById("tb_tipe_pengeluaran");
    var selectBeasiswa = document.getElementById("tb_beasiswa");
    var fieldBeasiswa = document.getElementById("field_beasiswa");
    var nominalUmum = document.getElementById("nominal_umum");
    var nominalBeasiswa = document.getElementById("nominal_beasiswa");

    function handleType() {
        if (fieldType.value == 2) {
            fieldBeasiswa.classList.remove("d-none");
            nominalUmum.classList.add("d-none");
            nominalBeasiswa.classList.remove("d-none");
        } else {
            fieldBeasiswa.classList.add("d-none");
            nominalUmum.classList.remove("d-none");
            nominalBeasiswa.classList.add("d-none");
        }
    }

    function handleBeasiswa() {
        let _this = parseInt(selectBeasiswa.options[selectBeasiswa.selectedIndex].dataset["nominal"]);
        document.querySelector('input[name="tb_nominal_beasiswa"]').value = _this;
        console.log(_this)
    }
</script>

</main>
</div>
<!-- /.container-fluid -->
<!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php include '../../component/admin/footer.php'; ?>