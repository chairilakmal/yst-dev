<?php
session_start();
include '../../config/connection.php';


if (!isset($_SESSION["username"])) {
    header('Location: login.php?status=restrictedaccess');
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
    move_uploaded_file($tmpName, 'img/' . $namaFileBaru);

    return $namaFileBaru;
}


if (isset($_POST["submit"])) {

    $judul_berita               = $_POST["tb_judul_berita"];
    $judul_berita               = htmlspecialchars($judul_berita);

    $tgl_kejadian               = $_POST["tb_tgl_kejadian"];

    $isi_berita                 = $_POST["tb_isi_berita"];
    $isi_berita                 = htmlspecialchars($isi_berita);

    $gambar                     = upload();

    $tgl_penulisan              = date('Y-m-d', time());

    $kategori_berita            = $_POST["tb_kategori_berita"];

    $status_berita              = 1;


    $query = "INSERT INTO t_berita (judul_berita, tgl_kejadian, isi_berita,gambar_berita,tgl_penulisan,kategori_berita,status_berita)
                VALUES ('$judul_berita', '$tgl_kejadian', '$isi_berita','$gambar','$tgl_penulisan','$kategori_berita','$status_berita')";


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
            <a href="dashboard-admin.php">
                <i class="nav-icon fas fa-home mr-1"></i>Dashboard admin</a> >
            <a href="kelola-berita.php">
                <i class="nav-icon fas fa-cog mr-1"></i>Kelola Berita</a> >
            <a href="input-berita.php">
                <i class="nav-icon fas fa-plus-square mr-1"></i>Input Berita</a>
        </div>
        <div class="form-profil">
            <div class="mt-2 regis-title">
                <h3>Input Berita</h3>
            </div>
            <form action="" enctype="multipart/form-data" method="POST">
                <div class="form-group label-txt">
                    <div class="form-group mt-4 mb-3">
                        <label for="tb_judul_berita" class="label-txt">Judul Berita<span class="red-star">*</span></label>
                        <input type="text" id="tb_judul_berita" name="tb_judul_berita" class="form-control" placeholder="Judul Berita" Required>
                    </div>
                    <div class="form-group mt-4 mb-3">
                        <label for="tb_kategori_berita">Kategori</label>
                        <select class="form-control" id="tb_kategori_berita" name="tb_kategori_berita">
                            <option value="0">Kegiatan</option>
                            <option value="1">Berita</option>
                        </select>
                    </div>
                    <div class="form-group mt-4 mb-3">
                        <label for="tb_tgl_kejadian" class="label-txt">Tanggal Kejadian<span class="red-star">*</span></label>
                        <input type="date" id="tb_tgl_kejadian" name="tb_tgl_kejadian" class="form-control" Required>
                    </div>
                    <div class="form-group">
                        <label for="tb_isi_berita" class="label-txt">Isi Berita<span class="red-star">*</span></label>
                        <textarea class="form-control" id="tb_isi_berita" name="tb_isi_berita" rows="6" placeholder="Isi Berita" Required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="image_uploads" class="label-txt">Foto Berita<span class="red-star">*</span></label>
                        <div class="file-form">
                            <input type="file" id="image_uploads" name="image_uploads" class="form-control" Required>
                        </div>
                    </div>
                </div>
                <button type="submit" name="submit" value="Simpan" class="btn btn-lg btn-primary w-100 yst-login-btn border-0 mt-4 mb-4">
                    <span class="yst-login-btn-fs">Posting Berita</span>
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