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

function upload($image_upload)
{
    //upload gambar
    $namaFile = $_FILES[$image_upload]['name'];
    $ukuranFile = $_FILES[$image_upload]['size'];
    $error = $_FILES[$image_upload]['error'];
    $tmpName = $_FILES[$image_upload]['tmp_name'];


    //cek ekstensi gambar
    $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
    $ekstensiGambar = explode('.', $namaFile);
    $ekstensiGambar = strtolower(end($ekstensiGambar));

    //generate nama baru
    $namaFileBaru = uniqid();
    $namaFileBaru .= '.';
    $namaFileBaru .= $ekstensiGambar;


    //lolos pengecekan
    move_uploaded_file($tmpName, '../../img/' . $namaFileBaru);

    return $namaFileBaru;
}

function queryPlafon($query)
{
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}
$plafonBeasiswa = queryPlafon("SELECT * FROM t_plafon_beasiswa
                    ORDER BY id
                    ");

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

$currentWilayah = $_SESSION["wilayah_id"];

if ($_SESSION["level_user"] == '2a' || $_SESSION["level_user"] == '2b') {
    $userQuery = query("SELECT * FROM t_meninggal 
                ORDER BY id_meninggal DESC                
                ");
} else {
    $userQuery = query("SELECT * FROM t_meninggal
                WHERE wilayah_id = $currentWilayah
                ORDER BY id_meninggal DESC                
                ");
}


if (isset($_POST["submit"])) {

    $tanggal           = $_POST["tb_tgl_beasiswa"];
    $penerima          = $_POST["tb_penerima"];

    $namaAnak1         = $_POST["tb_nama_anak1"];
    $namaAnak2         = $_POST["tb_nama_anak2"];
    $namaAnak3         = $_POST["tb_nama_anak3"];

    $jenjang1          = $_POST["tb_jenjang_pendidikan1"];
    $jenjang2          = $_POST["tb_jenjang_pendidikan2"];
    $jenjang3          = $_POST["tb_jenjang_pendidikan3"];

    $nama_bank1        = $_POST["tb_nama_bank1"];
    $nama_bank2        = $_POST["tb_nama_bank2"];
    $nama_bank3        = $_POST["tb_nama_bank3"];

    $nominal1          = $_POST["tb_nominal1"] ? $_POST["tb_nominal1"] : 0;
    $unmaskedNom1      = preg_replace('/[^0-9\-]/', '', $nominal1);

    $nominal2          = $_POST["tb_nominal2"] ? $_POST["tb_nominal2"] : 0;
    $unmaskedNom2      = preg_replace('/[^0-9\-]/', '', $nominal2);

    $nominal3          = $_POST["tb_nominal3"] ? $_POST["tb_nominal3"] : 0;
    $unmaskedNom3      = preg_replace('/[^0-9\-]/', '', $nominal3);

    $nomor_rekening1   = $_POST["tb_noRekening1"] ? $_POST["tb_noRekening1"] : 0;
    $nomor_rekening2   = $_POST["tb_noRekening2"] ? $_POST["tb_noRekening2"] : 0;
    $nomor_rekening3   = $_POST["tb_noRekening3"] ? $_POST["tb_noRekening3"] : 0;

    $totalNominal      = $_POST["tb_total_nominal"];
    $unmaskedTotal     = preg_replace('/[^0-9\-]/', '', $totalNominal);

    $file_kk           = upload("image_uploads");

    $keterangan        = $_POST["tb_ket_beasiswa"];
    $keterangan        = htmlspecialchars($keterangan);

    $created_by                 = $_SESSION["nama"];


    // $formData = [$nominal1, $nominal2, $nominal3, $totalNominal];
    // var_dump('nilai asli', $unmaskedTotal);
    // var_dump('exploded', preg_replace('/[^0-9\-]/', '', $nominal1));
    // die;


    $query = "INSERT INTO t_beasiswa (
                tgl,
                user_nik, 
                nama_anak1,
                nama_anak2,
                nama_anak3,
                jenjang_pendidikan1,
                jenjang_pendidikan2,
                jenjang_pendidikan3,
                nominal_1,
                nominal_2,
                nominal_3,
                nama_bank1,
                nama_bank2,
                nama_bank3,
                nomor_rekening1,
                nomor_rekening2,
                nomor_rekening3,
                total_nominal,
                file_kk, 
                keterangan,
                created_by )
              VALUES (
                '$tanggal',
                '$penerima',
                '$namaAnak1',
                '$namaAnak2',
                '$namaAnak3',
                '$jenjang1',
                '$jenjang2',
                '$jenjang3',
                $unmaskedNom1,
                $unmaskedNom2,
                $unmaskedNom3,
                '$nama_bank1',
                '$nama_bank2',
                '$nama_bank3',
                '$nomor_rekening1',
                '$nomor_rekening2',
                '$nomor_rekening3',
                $unmaskedTotal,
                '$file_kk', 
                '$keterangan',
                '$created_by' )  
             ";


    mysqli_query($conn, $query);
    // var_dump($query);
    // die;

    //cek keberhasilan
    if (mysqli_affected_rows($conn) > 0) {
        echo "
            <script>
                alert('Data berhasil ditambahkan!');
                window.location.href = '../beasiswa';
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
                    <div class="form-group mt-4 mb-3" id="tgl_selesai_form">
                        <label for="tb_tgl_beasiswa" class="label-txt">Tanggal Pengajuan Beasiswa<span class="red-star">*</span></label>
                        <input type="date" id="tb_tgl_beasiswa" name="tb_tgl_beasiswa" class="form-control" value="<?php echo date("Y-m-d"); ?>">
                    </div>
                    <div class="form-group mt-4 mb-3">
                        <label for="tb_kategori">Penerima<span class="red-star">*</span></label></label>
                        <select class="form-control" id="tb_penerima" name="tb_penerima" required>
                            <option value="" selected disabled>Pilih NIK</option>;
                            <?php foreach ($userQuery as $row) : ?>
                                <option value="<?= $row["nik"]; ?>">
                                    <?php echo $row['nik']; ?> -
                                    <?php echo $row['nama'] ?>
                                </option>';
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group mt-4 mb-3">
                        <label for="data_anak">Data Anak<span class="red-star">*</span></label></label>
                        <div class="data-anak-container">
                            <div class="row mb-2 font-weight-bold">
                                <div class="col num-col d-flex justify-content-center">No</div>
                                <div class="col">Nama Anak</div>
                                <div class="col">Jenjang Pendidikan</div>
                                <div class="col">Nominal/6 bln</div>
                                <div class="col">Nama Bank</div>
                                <div class="col">No. Rekening</div>
                            </div>

                            <?php for ($x = 1; $x <= 3; $x++) : ?>
                                <div class="row mb-2" id="appendForm<?= $x ?>">
                                    <div class="col num-col d-flex align-items-center justify-content-center">
                                        <?= $x ?>
                                    </div>
                                    <div class="col"><input type="text" id="tb_nama_anak<?= $x ?>" name="tb_nama_anak<?= $x ?>" class="form-control"></div>
                                    <div class="col">
                                        <select class="form-control" id="tb_jenjang_pendidikan<?= $x ?>" name="tb_jenjang_pendidikan<?= $x ?>" onchange="handleJenjang()">
                                            <option value="" selected>Pilih Jenjang</option>
                                            <?php foreach ($plafonBeasiswa as $row) : ?>
                                                <option value="<?= $row["jenjang"]; ?>" data-nominal="<?= $row["nominal"]; ?>"><?= $row["jenjang"]; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col"><input type="text" id="tb_nominal<?= $x ?>" name="tb_nominal<?= $x ?>" class="form-control" onkeyup="handleNominal()" onchange="handleNominal()" readonly>
                                    </div>
                                    <div class="col"><input type="text" id="tb_nama_bank<?= $x ?>" name="tb_nama_bank<?= $x ?>" class="form-control"></div>
                                    <div class="col"><input type="number" id="tb_noRekening<?= $x ?>" name="tb_noRekeningk<?= $x ?>" class="form-control"></div>
                                    <!-- <div class="append-action">                        
                                    <button type="button" onclick="removeField?=$x?>()">-</button>                       
                                </div> -->
                                </div>
                            <?php endfor; ?>

                            <div class="row justify-content-end align-items-center  font-weight-bold">
                                <div class="col-auto ">Total</div>
                                <div class="col-auto ">
                                    <input type="text" id="tb_total" name="tb_total" class="input-total">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mt-2 mb-3" id="tgl_selesai_form">
                        <label for="tb_total_nominal" class="label-txt">Total Nominal<span class="red-star">*</span></label>
                        <input type="text" id="tb_total_nominal" name="tb_total_nominal" class="form-control" readonly>
                    </div>

                    <div class="form-group">
                        <label for="image_uploads" class="label-txt"> File Kartu Keluarga </label><br>
                        <!-- <img src="img/" class="edit-img popup " alt=""> -->
                        <div class="file-form">
                            <input type="file" id="image_uploads" name="image_uploads" class="form-control ">
                        </div>
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
        <script type="text/javascript">
            // Declare Variables
            var jenjang1 = document.getElementById("tb_jenjang_pendidikan1");
            var jenjang2 = document.getElementById("tb_jenjang_pendidikan2");
            var jenjang3 = document.getElementById("tb_jenjang_pendidikan3");
            var nominal1 = document.getElementById("tb_nominal1");
            var nominal2 = document.getElementById("tb_nominal2");
            var nominal3 = document.getElementById("tb_nominal3");

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

            function handleJenjang() {
                var value1 = parseInt(jenjang1.options[jenjang1.selectedIndex].dataset["nominal"]);
                document.querySelector('input[name="tb_nominal1"]').value = value1;

                var value2 = parseInt(jenjang2.options[jenjang2.selectedIndex].dataset["nominal"]);
                document.querySelector('input[name="tb_nominal2"]').value = value2;

                var value3 = parseInt(jenjang3.options[jenjang3.selectedIndex].dataset["nominal"]);
                document.querySelector('input[name="tb_nominal3"]').value = value3;

                let total1 = value1 ? value1 : 0;
                let total2 = value2 ? value2 : 0;
                let total3 = value3 ? value3 : 0;
                document.querySelector('input[name="tb_nominal1"]').value = formatRupiah(value1, 'Rp. ');
                document.querySelector('input[name="tb_nominal2"]').value = formatRupiah(value2, 'Rp. ');
                document.querySelector('input[name="tb_nominal3"]').value = formatRupiah(value3, 'Rp. ');
                document.querySelector('input[name="tb_total"]').value = formatRupiah(total1 + total2 + total3, 'Rp. ');
                document.querySelector('input[name="tb_total_nominal"]').value = formatRupiah(total1 + total2 + total3, 'Rp. ');

            }

            function handleNominal() {
                let value1 = parseInt(nominal1.value);
                let value2 = parseInt(nominal2.value);
                let value3 = parseInt(nominal3.value);
                let total1 = value1 ? value1 : 0;
                let total2 = value2 ? value2 : 0;
                let total3 = value3 ? value3 : 0;
                document.querySelector('input[name="tb_nominal1"]').value = value1;
                document.querySelector('input[name="tb_nominal2"]').value = value2;
                document.querySelector('input[name="tb_nominal3"]').value = value3;
                document.querySelector('input[name="tb_total"]').value = total1 + total2 + total3;
                document.querySelector('input[name="tb_total_nominal"]').value = total1 + total2 + total3;
            }

            // $(document).ready(function() {
            //     /* Dengan Rupiah */
            //     var tb_nominal1 = document.getElementById('tb_nominal1');
            //     tb_nominal1.addEventListener('keyup', function(e) {
            //         tb_nominal1.value = formatRupiah(this.value, 'Rp. ');
            //     });
            // })
        </script>
    </main>
</div>
<!-- /.container-fluid -->
<!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php include '../../component/admin/footer.php'; ?>