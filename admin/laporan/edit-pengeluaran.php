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

$id_lap_keuangan = $_GET["id_lap_keuangan"];
$lapKeuangan = query("SELECT * FROM t_lap_keuangan WHERE id_lap_keuangan = $id_lap_keuangan")[0];
$idBeasiswa = $lapKeuangan['beasiswa_id'];

$beasiswaQuery = query("SELECT * FROM t_beasiswa 
                LEFT JOIN t_meninggal 
                ON t_beasiswa.user_nik = t_meninggal.nik
                LEFT JOIN t_wilayah 
                ON t_meninggal.wilayah_id = t_wilayah.id_wilayah
                WHERE id_beasiswa = $idBeasiswa")[0];

// var_dump($beasiswaQuery);
// die;

function upload()
{
    //upload gambar
    $namaFile = $_FILES['image_uploads']['name'];
    $ukuranFile = $_FILES['image_uploads']['size'];
    $error = $_FILES['image_uploads']['error'];
    $tmpName = $_FILES['image_uploads']['tmp_name'];

    //cek ekstensi gambar
    $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
    $ekstensiGambar = explode('.', $namaFile);
    $ekstensiGambar = strtolower(end($ekstensiGambar));

    //generate nama baru
    $namaFileBaru = uniqid();
    $namaFileBaru .= '.';
    $namaFileBaru .= $ekstensiGambar;

    //lolos pengecekan
    move_uploaded_file($tmpName, '../../upload/' . $namaFileBaru);

    return $namaFileBaru;
}

if (isset($_POST["submit"])) {

    $tanggal          = $_POST['tb_tanggal'];

    $nominal      = $_POST['tb_nominal'];
    $unmaskedNom  = preg_replace('/[^0-9\-]/', '', $nominal);


    $sumber           = $_POST['tb_sumber'] ? $_POST['tb_sumber'] : 'Kas';

    $keterangan       = $_POST['tb_keterangan'] ? $_POST['tb_keterangan'] : '-';
    $status           = 1;

    $beasiswa_id      = $_POST['tb_beasiswa'] ? $_POST['tb_beasiswa'] : 0;
    $gambarLama       = $_POST["gambarLama"];

    $updated_by       = $_SESSION["nama"];
    $updated_at       = date('Y-m-d H:i:s');

    if ($_FILES['image_uploads']['error'] === 4) {
        $bukti_transfer = $gambarLama;
    } else {
        $bukti_transfer = upload();
    }

    $query = "UPDATE t_lap_keuangan SET
        tanggal = '$tanggal',
        nominal = '$unmaskedNom',
        sumber  = '$sumber',
        keterangan = '$keterangan',
        bukti_transfer = '$bukti_transfer',
        updated_by = '$updated_by',
        updated_at = '$updated_at'
        WHERE id_lap_keuangan = $id_lap_keuangan
    ";

    mysqli_query($conn, $query);

    // var_dump($query);
    // die;

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

<div class="content-wrapper">
    <main>
        <div class="page-title-link ml-4 mb-4">
            <a href="laporan-bulanan.php">
                <i class="nav-icon fas fa-home mr-1"></i>Dashboard admin</a> >
            <a href="laporan-bulanan.php">
                <i class="nav-icon fas fa-donate mr-1"></i>Laporan bulanan</a> >
            <a href="edit-pengeluaran.php">
                <i class="nav-icon fas fa-cog mr-1"></i>Edit pengeluaran</a>
        </div>
        <div class="form-profil">
            <div class="mt-2 regis-title">
                <h3>Edit Pengeluaran</h3>
            </div>
            <form action="" enctype="multipart/form-data" method="POST">
                <label for="tb_tipe_pengeluaran">Tipe Pengeluaran<span class="red-star">*</span></label></label>
                <input type="hidden" name="gambarLama" value="<?= $lapKeuangan["bukti_transfer"]; ?>">
                <input type="text" id="tb_tipe_pengeluaran" name="tb_tipe_pengeluaran" class="form-control" value="<?= $lapKeuangan["beasiswa_id"] != 0 ? 'Beasiswa' : 'Umum' ?>" disabled>
                <?php if ($lapKeuangan["beasiswa_id"] != 0) { ?>
                    <div class="form-group mt-4 mb-3" id="tgl_selesai_form">
                        <label for="tb_tipe_pengeluaran">Nama Beasiswa<span class="red-star">*</span></label></label>
                        <textarea class="form-control" id="tb_keterangan" name="tb_keterangan" rows="1" placeholder="Keterangan" readonly>Beasiswa Pendidikan Keluarga <?= $beasiswaQuery['nama'] ?> <?= $beasiswaQuery['kode_wilayah'] ?> ( <?php echo date("d-m-Y", strtotime($beasiswaQuery['tgl'])); ?> )</textarea>
                    </div>
                <?php  } ?>

                <div class="form-group mt-4 mb-3" id="tgl_selesai_form">
                    <label for="tb_tanggal" class="label-txt">Tanggal<span class="red-star">*</span></label>
                    <input type="date" id="tb_tanggal" name="tb_tanggal" class="form-control" value="<?= $lapKeuangan["tanggal"]; ?>">
                </div>

                <!-- Nominal Umum -->
                <div id="nominal_umum" class="form-group mt-4 mb-3">
                    <label for="tb_nominal" class="label-num">Nominal<span class="red-star">*</span></label>
                    <input type="text" id="tb_nominal" name="tb_nominal" class="form-control" placeholder="Masukan nominal pengeluaran" value="<?= rupiah($lapKeuangan["nominal"]); ?>" onkeyup="handleNominal()" <?php if ($lapKeuangan["beasiswa_id"] != 0) echo 'readOnly' ?>>
                </div>


                <div class="form-group">
                    <label for="tb_sumber" class="label-txt">Sumber Dana</label>
                    <input type="text" class="form-control" id="tb_sumber" name="tb_sumber" value="Kas" placeholder="Masukkan sumber dana" value="<?= $lapKeuangan["sumber"]; ?>"></input>
                </div>
                <div class="form-group">
                    <label for="tb_keterangan" class="label-txt">Keterangan</label>
                    <textarea class="form-control" id="tb_keterangan" name="tb_keterangan" rows="4" placeholder="Keterangan"><?= $lapKeuangan["keterangan"]; ?></textarea>
                </div>

                <div class="form-group">
                    <div class="row" style="margin-left: 1px;"> <label for="image_uploads" class="label-txt"> Bukti Transfer </label>
                    </div>
                    <div class="row ml-2">
                        <img src="../../upload/<?= $lapKeuangan["bukti_transfer"]; ?>" class="edit-img popup " alt="">
                    </div>
                    <div class="row ml-2"><?= $lapKeuangan["bukti_transfer"]; ?></div>

                    <div class="row ml-2 mt-2">
                        <a href="../../upload/<?= $lapKeuangan["bukti_transfer"]; ?>" target="_blank">
                            <div class="handle-file-unduh"> Lihat</div>
                        </a>

                        <div class="handle-file-ubah ml-3" onclick="handleUbahFile()"> Ubah </div>

                    </div>

                    <div class="file-form d-none" id="file-form">
                        <br><input type="file" id="image_uploads" name="image_uploads" class="form-control ">
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

    function handleNominal() {
        var value = document.getElementById("tb_nominal").value;
        console.log(formatRupiah(value, 'Rp. '))
        document.querySelector('input[name="tb_nominal"]').value = formatRupiah(value, 'Rp. ');
    }

    function handleUbahFile() {
        var uploadForm = document.getElementById("file-form");
        uploadForm.classList.toggle("d-none");
        // uploadForm.classList.add("d-none");
    }
</script>
<!-- Modal -->
<div class="modal fade" id="staticBackdrop" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Bukti Transfer </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <img src="" id="popup-img" alt="image" class="w-100">
            </div>
        </div>
    </div>
</div>
</main>
</div>
<!-- /.container-fluid -->
<!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php include '../../component/admin/footer.php'; ?>