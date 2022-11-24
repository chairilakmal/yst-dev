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
$id_meninggal = $_GET["id_meninggal"];

function upload($suratKematian_Baru)
{
    //upload gambar
    $namaFile = $_FILES[$suratKematian_Baru]['name'];
    $ukuranFile = $_FILES[$suratKematian_Baru]['size'];
    $error = $_FILES[$suratKematian_Baru]['error'];
    $tmpName = $_FILES[$suratKematian_Baru]['tmp_name'];

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

$currentWilayah = $_SESSION["wilayah_id"];
$selectNIK = query("SELECT * FROM t_user
                WHERE is_die = 'y' AND status_aktif = 'n'
                ORDER BY nik ASC ");

$dataKematian = query(" SELECT * FROM t_meninggal
                        WHERE id_meninggal = $id_meninggal")[0];

//UPDATE
if (isset($_POST["submit"])) {

    $id_meninggal               = $_POST["id_meninggal"];

    $nik                        = $_POST["tb_nik"];
    $nama                       = $_POST["tb_nama"];
    $no_kontak                  = $_POST["tb_no_kontak"];
    $nama_kontak                = $_POST["tb_nama_kontak"];

    $tgl_kematian               = $_POST["tb_tgl_kematian"];
    $waktu                      = $_POST["tb_waktu_kematian"];
    $tempat_meninggal           = $_POST["tb_tempat_kematian"];
    $tempat_pemakaman           = $_POST["tb_tempat_pemakaman"];

    $penyebab_kematian          = $_POST["tb_penyebab_kematian"];
    $penyebab_kematian          = htmlspecialchars($penyebab_kematian);

    $status_meninggal           = $_POST["tb_status_meninggal"];

    $suratKematian_Lama         = $_POST["suratKematian_Lama"];

    $updated_by                 = $_SESSION["nama"];
    $updated_at                 = date('Y-m-d H:i:s');

    if ($_FILES['suratKematian_Baru']['error'] === 4) {
        $suratKematian_Baru = $suratKematian_Lama;
    } else {
        $suratKematian_Baru = upload("suratKematian_Baru");
    }

    // GLOBAL UPDATE
    $queryDataKematian = "UPDATE t_meninggal SET
                            nik                         = '$nik',
                            nama                        = '$nama',
                            no_kontak                   = '$no_kontak',
                            nama_kontak                 = '$nama_kontak',
                            tgl_meninggal               = '$tgl_kematian',
                            waktu                       = '$waktu',
                            tempat                      = '$tempat_meninggal',
                            tempat_pemakaman            = '$tempat_pemakaman',
                            penyebab_kematian           = '$penyebab_kematian',
                            is_valid                    = '$status_meninggal',
                            file_surat_kematian         = '$suratKematian_Baru',
                            updated_by                  = '$updated_by',
                            updated_at                  = '$updated_at'
                            WHERE id_meninggal          = $id_meninggal
                        ";

    if ($status_meninggal == 'y') {
        $statusAktif = 'n';
    } else {
        $statusAktif = 'y';
    }

    // mysqli_query($conn, $queryDataUser);
    mysqli_query($conn, $queryDataKematian);



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
            <a href="../berita/index.php">
                <i class="nav-icon fas fa-home mr-1"></i>Dashboard admin</a> >
            <a href="index.php">
                <i class="nav-icon fas fa-cog mr-1"></i>Kelola Data Meninggal</a> >
            <a href="edit.php?id_meninggal=<?= $id_meninggal ?>">
                <i class="nav-icon fas fa-cog mr-1"></i>Edit Data Meninggal</a>
        </div>
        <div class="form-profil">
            <div class="mt-2 regis-title">
                <h3>Edit Data Meninggal</h3>
            </div>
            <form action="" enctype="multipart/form-data" method="POST">
                <input type="hidden" name="id_meninggal" value="<?= $dataKematian["id_meninggal"]; ?>">
                <input type="hidden" name="suratKematian_Lama" value="<?= $dataKematian["file_surat_kematian"]; ?>">
                <div class="form-group label-txt">
                    <div class="form-group mt-4 mb-3">
                        <div class="row">
                            <div class="col">
                                <label for="tb_nik">NIK<span class="red-star">*</span></label></label>
                                <input type="text" name="tb_nik" class="form-control" placeholder="Masukan NIK" value="<?= $dataKematian["nik"]; ?>">
                            </div>
                            <div class="col">
                                <label for="tb_nama">Nama Lengkap<span class="red-star">*</span></label></label>
                                <input type="text" name="tb_nama" class="form-control" placeholder="Masukan nama lengkap" value="<?= $dataKematian["nama"]; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="form-group mt-4 mb-3">
                        <div class="row">
                            <div class="col">
                                <label for="tb_no_kontak">Nomor Kontak Perwakilan<span class="red-star">*</span></label></label>
                                <input type="number" name="tb_no_kontak" class="form-control" placeholder=" Nomor kontak yang dapat dihubungi" value="<?= $dataKematian["no_kontak"]; ?>">
                            </div>
                            <div class="col">
                                <label for="tb_nama_kontak">Nama Kontak Perwakilan<span class="red-star">*</span></label></label>
                                <input type="text" name="tb_nama_kontak" class="form-control" placeholder="Nama kontak yang dapat dihubungi" value="<?= $dataKematian["nama_kontak"]; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="form-group mt-4 mb-3" id="tgl_selesai_form">
                        <label for="tb_tgl_kematian" class="label-txt">Tanggal<span class="red-star">*</span></label>
                        <input type="date" id="tb_tgl_kematian" name="tb_tgl_kematian" class="form-control" value="<?= $dataKematian["tgl_meninggal"]; ?>">
                    </div>
                    <div class="form-group mt-4 mb-3" id="tgl_selesai_form">
                        <label for="tb_waktu_kematian" class="label-txt">Waktu<span class="red-star">*</span></label>
                        <input type="time" id="tb_waktu_kematian" name="tb_waktu_kematian" class="form-control" value="<?= $dataKematian["waktu"]; ?>">
                    </div>

                    <div class="form-group mt-4 mb-3">
                        <label for="tb_tempat_kematian" class="label-txt">Tempat<span class="red-star">*</span></label>
                        <input type="text" id="tb_tempat_kematian" name="tb_tempat_kematian" class="form-control" placeholder="Tempat Meninggal" value="<?= $dataKematian["tempat"]; ?>" Required>
                    </div>
                    <div class="form-group mt-4 mb-3">
                        <label for="tb_tempat_pemakaman" class="label-txt">Tempat Pemakaman<span class="red-star">*</span></label>
                        <input type="text" id="tb_tempat_pemakaman" name="tb_tempat_pemakaman" class="form-control" placeholder="Tempat Pemakaman" value="<?= $dataKematian["tempat_pemakaman"]; ?>" Required>
                    </div>
                    <div class="form-group">
                        <label for="tb_penyebab_kematian" class="label-txt">Penyebab Kematian</label>
                        <textarea class="form-control" id="tb_penyebab_kematian" name="tb_penyebab_kematian" rows="6" placeholder="Penyebab Kematian"><?php echo $dataKematian["penyebab_kematian"]; ?></textarea>
                    </div>

                    <div class="form-group">
                        <div class="row" style="margin-left: 1px;"> <label for="suratKematian_Baru" class="label-txt"> Surat Keterangan Kematian </label>
                        </div>
                        <div class="row ml-2">
                            <img src="../../img/<?= $dataKematian["file_surat_kematian"]; ?>" class="edit-img popup " alt="">
                        </div>
                        <div class="row ml-2"><?= $dataKematian["file_surat_kematian"]; ?></div>

                        <div class="row ml-2 mt-2">
                            <a href="../../img/<?= $dataKematian["file_surat_kematian"]; ?>" target="_blank">
                                <div class="handle-file-unduh"> Lihat</div>
                            </a>

                            <div class="handle-file-ubah ml-3" onclick="handleUbahFile()"> Ubah </div>

                        </div>

                        <div class="file-form d-none" id="file-form">
                            <br><input type="file" id="suratKematian_Baru" name="suratKematian_Baru" class="form-control ">
                        </div>
                    </div>
                    <div class="form-group mb-5">
                        <label for="tb_status_meninggal" class="font-weight-bold"><span class="label-form-span">Status Approval </span></label><br>
                        <div class="radio-wrapper mt-1 bg-white">
                            <div class="form-check form-check-inline">
                                <input type="radio" id="tb_status_meninggal" name="tb_status_meninggal" class="form-check-input" value="y" <?php if ($dataKematian['is_valid'] == 'y') echo 'checked' ?>>
                                <label class="form-check-label" for="tb_status_meninggal">Approved </label>
                            </div>
                        </div>
                        <div class="radio-wrapper2 mt-1 bg-white">
                            <div class="form-check form-check-inline">
                                <input type="radio" id="tb_status_meninggal" name="tb_status_meninggal" class="form-check-input" value="n" <?php if ($dataKematian['is_valid'] == 'n') echo 'checked' ?>>
                                <label class="form-check-label" for="tb_status_meninggal">Menunggu Approval</label>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
        <button type="submit" name="submit" value="Simpan" class="btn btn-lg btn-primary w-100 yst-login-btn border-0 mt-4 mb-4">
            <span class="yst-login-btn-fs">Simpan</span>
        </button>
        </form>
</div>

<div class="modal fade" id="staticBackdrop" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel"> Preview Image </h5>
                <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> -->
            </div>
            <div class="modal-body">
                <img src="" id="popup-img" alt="image" class="w-100">
            </div>
        </div>
    </div>
</div>
<script>
    function handleUbahFile() {
        var uploadForm = document.getElementById("file-form");
        uploadForm.classList.toggle("d-none");
        // uploadForm.classList.add("d-none");
    }
</script>
</main>
</div>
<!-- /.container-fluid -->
<!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php include '../../component/admin/footer.php'; ?>