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

function queryNIK($query)
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
$selectNIK = queryNIK("SELECT * FROM t_user
                WHERE is_die = 'n' AND status_aktif = 'y' AND wilayah_id = $currentWilayah
                ORDER BY nik ASC 
                ");


if (isset($_POST["submit"])) {

    $id_user                    = $_POST["tb_nik"];
    $tgl_kematian               = $_POST["tb_tgl_kematian"];
    $waktu                      = $_POST["tb_waktu_kematian"];
    $tempat_meninggal           = $_POST["tb_tempat_kematian"];
    $tempat_pemakaman           = $_POST["tb_tempat_pemakaman"];

    $penyebab_kematian          = $_POST["tb_penyebab_kematian"];
    $penyebab_kematian          = htmlspecialchars($penyebab_kematian);

    $suratKematian              = upload("image_uploads");

    $nama = $_SESSION['nama'];

    $created_by                 = $nama;
    $updated_by                 = $nama;


    $query = "INSERT INTO t_meninggal 
        (
            id_user, 
            tgl, 
            waktu, 
            tempat, 
            tempat_pemakaman, 
            penyebab_kematian, 
            file_kk, 
            file_surat_kematian, 
            created_by, 
            updated_by)
            VALUES (
                '$id_user', 
                '$tgl_kematian',
                '$waktu',
                '$tempat_meninggal',
                '$tempat_pemakaman',
                '$penyebab_kematian', 
                '$KartuKeluarga', 
                '$suratKematian', 
                '$created_by', 
                '$updated_by')";


    mysqli_query($conn, $query);
    // var_dump($query);
    // die;
    //cek keberhasilan
    if (mysqli_affected_rows($conn) > 0) {
        echo "
            <script>
                alert('Data berhasil ditambahkan!');
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
                <i class="nav-icon fas fa-cog mr-1"></i>Kelola Meninggal</a>
        </div>
        <div class="form-profil">
            <div class="mt-2 regis-title">
                <h3>Input Data Meninggal</h3>
            </div>
            <form action="" enctype="multipart/form-data" method="POST">
                <div class="form-group label-txt">
                    <div class="form-group mt-4 mb-3">
                        <div class="row">
                            <div class="col">
                                <label for="tb_nik">NIK<span class="red-star">*</span></label></label>
                                <input type="text" name="tb_nik" class="form-control" placeholder="Masukan NIK">
                            </div>
                            <div class="col">
                                <label for="tb_nama">Nama Lengkap<span class="red-star">*</span></label></label>
                                <input type="text" name="tb_nama" class="form-control" placeholder="Masukan nama lengkap">
                            </div>
                        </div>
                    </div>
                    <div class="form-group mt-4 mb-3">
                        <div class="row">
                            <div class="col">
                                <label for="tb_no_kontak">Nomor Kontak Perwakilan<span class="red-star">*</span></label></label>
                                <input type="text" name="tb_no_kontak" class="form-control" placeholder=" Nomor kontak yang dapat dihubungi">
                            </div>
                            <div class="col">
                                <label for="tb_nama_kontak">Nama Kontak Perwakilan<span class="red-star">*</span></label></label>
                                <input type="text" name="tb_nama_kontak" class="form-control" placeholder="Nama kontak yang dapat dihubungi">
                            </div>
                        </div>
                    </div>
                    <div class="form-group mt-4 mb-3">
                        <label for="tb_tgl_kematian" class="label-txt">Tanggal<span class="red-star">*</span></label>
                        <input type="date" id="tb_tgl_kematian" name="tb_tgl_kematian" class="form-control">
                    </div>
                    <div class="form-group mt-4 mb-3">
                        <label for="tb_waktu_kematian" class="label-txt">Waktu<span class="red-star">*</span></label>
                        <input type="time" id="tb_waktu_kematian" name="tb_waktu_kematian" class="form-control">
                    </div>
                    <div class="form-group mt-4 mb-3">
                        <label for="tb_tempat_kematian" class="label-txt">Tempat<span class="red-star">*</span></label>
                        <input type="text" id="tb_tempat_kematian" name="tb_tempat_kematian" class="form-control" placeholder="Tempat meninggal" Required>
                    </div>
                    <div class="form-group mt-4 mb-3">
                        <label for="tb_tempat_pemakaman" class="label-txt">Tempat Pemakaman<span class="red-star">*</span></label>
                        <input type="text" id="tb_tempat_pemakaman" name="tb_tempat_pemakaman" class="form-control" placeholder="Tempat pemakaman" Required>
                    </div>
                    <div class="form-group">
                        <label for="tb_penyebab_kematian" class="label-txt">Penyebab Kematian</label>
                        <textarea class="form-control" id="tb_penyebab_kematian" name="tb_penyebab_kematian" rows="6" placeholder="Penyebab kematian"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="image_uploads" class="label-txt"> Surat Keterangan Kematian </label><br>
                        <!-- <img src="img/" class="edit-img popup " alt=""> -->
                        <div class="file-form">
                            <input type="file" id="image_uploads" name="image_uploads" class="form-control ">
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