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

function upload($image_upload)
{
    //upload gambar
    $namaFile = $_FILES[$image_upload]['name'];
    $ukuranFile = $_FILES[$image_upload]['size'];
    $error = $_FILES[$image_upload]['error'];
    $tmpName = $_FILES[$image_upload]['tmp_name'];

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

    if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
        echo "
                     <script>
                         alert('kesalahan pada format gambar !');
                     </script>
                 ";
        return false;
    }

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

$selectNIK = query("SELECT * FROM t_user
                WHERE is_die = 'n' AND status_aktif = 'y' 
                ORDER BY nik ASC ");

$dataKematian = query(" SELECT * FROM t_meninggal
                        LEFT JOIN t_user
                        ON t_meninggal.id_user = t_user.id_user 
                        WHERE id_meninggal = $id_meninggal")[0];

// var_dump($berita);
// die;

//UPDATE
if (isset($_POST["submit"])) {

    $id_meninggal               = $_POST["id_meninggal"];

    $id_user                    = $_POST["tb_nik"];
    $tgl_kematian               = $_POST["tb_tgl_kematian"];
    $waktu                      = $_POST["tb_waktu_kematian"];
    $tempat_meninggal           = $_POST["tb_tempat_kematian"];
    $tempat_pemakaman           = $_POST["tb_tempat_pemakaman"];

    $penyebab_kematian          = $_POST["tb_penyebab_kematian"];
    $penyebab_kematian          = htmlspecialchars($penyebab_kematian);

    $status_meninggal           = $_POST["tb_status_meninggal"];

    //$suratKematian              = upload("image_uploads1");
    //$KartuKeluarga              = upload("image_uploads2");

    //$nama = $_SESSION['nama'];

    //$updated_by                 = $_POST[$nama];

    $kartuKeluarga_Lama                 = $_POST["kartuKeluarga_Lama"];
    $suratKematian_Lama                 = $_POST["suratKematian_Lama"];


    if ($_FILES['kartuKeluarga_Baru']['error'] === 4) {
        $kartuKeluarga_Baru = $kartuKeluarga_Lama;
    } else {
        $kartuKeluarga_Baru = upload("kartuKeluarga_Baru");
    }

    if ($_FILES['suratKematian_Baru']['error'] === 4) {
        $suratKematian_Baru = $suratKematian_Lama;
    } else {
        $suratKematian_Baru = upload("suratKematian_Baru");
    }


    // if (isset($_FILES['image_uploads2'], $_POST['tb_tgl_penyaluran'])) {//do the fields exist
    //     if($_FILES['image_uploads2'] && $_POST['tb_tgl_penyaluran']){ //do the fields contain data
    //         $status_berita      = 'Selesai';
    //     }
    // }

    // GLOBAL UPDATE
    $queryDataKematian = "UPDATE t_meninggal SET
                            id_user                     = '$id_user',
                            tgl                         = '$tgl_kematian',
                            waktu                       = '$waktu',
                            tempat                      = '$tempat_meninggal',
                            tempat_pemakaman            = '$tempat_pemakaman',
                            penyebab_kematian           = '$penyebab_kematian',
                            is_approve                  = '$status_meninggal',
                            file_kk                     = '$kartuKeluarga_Baru',
                            file_surat_kematian         = '$suratKematian_Baru'
                           
                            WHERE id_meninggal          = $id_meninggal
                        ";

    if ($status_meninggal == 'y') {
        $statusAktif = 'n';
    } else {
        $statusAktif = 'y';
    }


    $queryDataUser = "UPDATE t_user SET 
                        status_aktif    = '$statusAktif',
                        is_die          = '$status_meninggal'

                        WHERE id_user   = $id_user
                        ";
    // var_dump($query);
    // die();

    mysqli_query($conn, $queryDataUser);
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
                <i class="nav-icon fas fa-cog mr-1"></i>Kelola Data Wafat</a> >
            <a href="edit.php?id_meninggal=<?= $id_meninggal ?>">
                <i class="nav-icon fas fa-cog mr-1"></i>Edit Data Wafat</a>
        </div>
        <div class="form-profil">
            <div class="mt-2 regis-title">
                <h3>Edit Data Meninggal</h3>
            </div>
            <form action="" enctype="multipart/form-data" method="POST">
                <input type="hidden" name="id_meninggal" value="<?= $dataKematian["id_meninggal"]; ?>">
                <input type="hidden" name="kartuKeluarga_Lama" value="<?= $dataKematian["file_kk"]; ?>">
                <input type="hidden" name="suratKematian_Lama" value="<?= $dataKematian["file_surat_kematian"]; ?>">
                <div class="form-group label-txt">
                    <div class="form-group mt-4 mb-3">
                        <label for="tb_nik">NIK<span class="red-star">*</span></label></label>
                        <select class="form-control" id="tb_nik" name="tb_nik">
                            <option value="<?= $dataKematian["id_user"]; ?>"><?= $dataKematian["nik"]; ?></option>;
                            <?php foreach ($selectNIK as $row) : ?>
                                <option value="<?= $row["id_user"]; ?>"><?= $row["nik"]; ?></option>';
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group mt-4 mb-3" id="tgl_selesai_form">
                        <label for="tb_tgl_kematian" class="label-txt">Tanggal<span class="red-star">*</span></label>
                        <input type="date" id="tb_tgl_kematian" name="tb_tgl_kematian" class="form-control" value="<?= $dataKematian["tgl"]; ?>">
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
                        <label for="kartuKeluarga_Baru" class="label-txt"> Kartu Keluarga </label><br>
                        <img src="../../img/<?= $dataKematian["file_kk"]; ?>" class="edit-img popup " alt="">
                        <div class="file-form">
                            <br><input type="file" id="kartuKeluarga_Baru" name="kartuKeluarga_Baru" class="form-control ">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="suratKematian_Baru" class="label-txt"> Surat Keterangan Kematian </label><br>
                        <img src="../../img/<?= $dataKematian["file_surat_kematian"]; ?>" class="edit-img popup " alt="">
                        <div class="file-form">
                            <br><input type="file" id="suratKematian_Baru" name="suratKematian_Baru" class="form-control ">
                        </div>
                    </div>
                    <!-- <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <button type="submit" name="submit" value="Simpan" class="btn btn-lg btn-primary w-100 yst-login-btn border-0 mt-4 mb-4">
                                            <span class="yst-login-btn-fs">Approve Data</span>
                                        </button>
                                    </div>

                                </div>
                            </div> -->
                    <div class="form-group mb-5">
                        <label for="tb_status_meninggal" class="font-weight-bold"><span class="label-form-span">Status Meninggal </span></label><br>
                        <div class="radio-wrapper mt-1 bg-white">
                            <div class="form-check form-check-inline">
                                <input type="radio" id="tb_status_meninggal" name="tb_status_meninggal" class="form-check-input" value="y" <?php if ($dataKematian['is_approve'] == 'y') echo 'checked' ?>>
                                <label class="form-check-label" for="tb_status_meninggal">Sudah Meninggal</label>
                            </div>
                        </div>
                        <div class="radio-wrapper2 mt-1 bg-white">
                            <div class="form-check form-check-inline">
                                <input type="radio" id="tb_status_meninggal" name="tb_status_meninggal" class="form-check-input" value="n" <?php if ($dataKematian['is_approve'] == 'n') echo 'checked' ?>>
                                <label class="form-check-label" for="tb_status_meninggal">Belum Meninggal</label>
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

<div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel"> Preview Image </h5>
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