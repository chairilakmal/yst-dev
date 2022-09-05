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


if (isset($_POST["submit"])) {

    $id_banner                  = $_POST["id_banner"];

    $judul_halaman_utama        = $_POST["tb_judul_halaman"];
    $judul_halaman_utama        = htmlspecialchars($judul_halaman_utama);

    $deskripsi                   = $_POST["tb_deskripsi"];
    $deskripsi                   = htmlspecialchars($deskripsi);

    $buttonText                 = $_POST["tb_textButton"];
    $buttonText                 = htmlspecialchars($buttonText);

    $gambarLama                 = $_POST["gambarLama"];

    if ($_FILES['image_uploads']['error'] === 4) {
        $gambar = $gambarLama;
    } else {
        $gambar = upload();
    }


    $query = "UPDATE t_konten_beranda SET
    Judul                = '$judul_halaman_utama',
    Deskripsi            = '$deskripsi',
    buttonText           = '$buttonText',
    Gambar               = '$gambar'
           
    WHERE id_banner      = $id_banner
";
    // var_dump($query);
    // die();

    mysqli_query($conn, $query);


    //cek keberhasilan
    if (mysqli_affected_rows($conn) > 0) {
        echo "
            <script>
            alert('Data berhasil diubah!');
            window.location.href = 'halaman-utama.php'; 
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

function queryBanner($query)
{
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

$Banner = queryBanner("SELECT * FROM t_konten_beranda")[0];

?>



<?php include '../../component/admin/header.php'; ?>
<?php include '../../component/admin/sidebar.php'; ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <main>
        <div class="page-title-link ml-4 mb-4">
            <a href="../berita/index.php">
                <i class="nav-icon fas fa-home mr-1"></i>Dashboard admin</a> >
            <a href="../berita/index.php">
                <i class="nav-icon fas fa-cog mr-1"></i>Kelola Konten</a> >
            <a href="halaman-utama.php">
                <i class="nav-icon fas fa-plus-square mr-1"></i>Halaman Utama</a>
        </div>
        <div class="form-profil">
            <div class="mt-2 regis-title">
                <h3>Kelola Halaman Utama</h3>
            </div>
            <form action="" enctype="multipart/form-data" method="POST">
                <input type="hidden" name="id_banner" value="<?= $Banner["id_banner"]; ?>">
                <input type="hidden" name="gambarLama" value="<?= $Banner["Gambar"]; ?>">
                <div class="form-group label-txt">
                    <div class="form-group mt-4 mb-3">
                        <label for="tb_judul_halaman" class="label-txt">Judul Halaman Utama<span class="red-star">*</span></label>
                        <input type="text" id="tb_judul_halaman" name="tb_judul_halaman" class="form-control" placeholder="Judul Halaman Utama" value="<?= $Banner["Judul"]; ?>">
                    </div>
                    <div class=" form-group">
                        <label for="tb_deskripsi" class="label-txt">Deskripsi<span class="red-star">*</span></label>
                        <textarea type="text" id="tb_deskripsi" name="tb_deskripsi" rows="6" class="form-control"><?= $Banner["Deskripsi"]; ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="tb_textButton" class="label-txt">Button Text<span class="red-star">*</span></label>
                        <input class="form-control" id="tb_textButton" name="tb_textButton" rows="6" value="<?= $Banner["buttonText"]; ?>">
                    </div>
                    <div class="form-group">
                        <label for="image_uploads" class="label-txt">Gambar Latar Belakang<span class="red-star">*</span></label>
                        <br><img src="../../img/<?= $Banner["Gambar"]; ?>" class="edit-img popup " alt="Preview Image Not Available">
                        <div class="file-form">
                            <br><input type="file" id="image_uploads" name="image_uploads" class="form-control">
                        </div>
                    </div>
                </div>
                <button type="submit" name="submit" value="Simpan" class="btn btn-lg btn-primary w-100 yst-login-btn border-0 mt-4 mb-4">
                    <span class="yst-login-btn-fs">Konfirmasi Perubahan</span>
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