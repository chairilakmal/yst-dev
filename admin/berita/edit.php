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

$level_user = $_SESSION['level_user'];

//ambil id program di URL
$id_berita = $_GET["id_berita"];

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

$berita = query("SELECT * FROM t_berita WHERE id_berita = $id_berita")[0];
// var_dump($berita);
// die;

//UPDATE
if (isset($_POST["submit"])) {

    $id_berita                  = $_POST["id_berita"];

    $judul_berita               = $_POST["tb_judul_berita"];

    $judul_berita               = htmlspecialchars($judul_berita);

    $tgl_kejadian               = $_POST["tb_tgl_kejadian"];

    $isi_berita                 = $_POST["tb_isi_berita"];
    $isi_berita                 = htmlspecialchars($isi_berita);

    $kategori_berita            = $_POST["tb_kategori_berita"];

    $status_berita              = $_POST["status_berita"];

    $gambarLama                 = $_POST["gambarLama"];

    $updated_by                 = $_SESSION["nama"];
    $updated_at                 = date('Y-m-d H:i:s');


    if ($_FILES['image_uploads']['error'] === 4) {
        $gambar = $gambarLama;
    } else {
        $gambar = upload();
    }
    

    // GLOBAL UPDATE
    $query = "UPDATE t_berita SET
                    judul_berita                = '$judul_berita',
                    tgl_kejadian                = '$tgl_kejadian',
                    isi_berita                  = '$isi_berita',
                    gambar_berita               = '$gambar', 
                    kategori_berita             = '$kategori_berita',
                    status_berita               = '$status_berita',
                    updated_by                  = '$updated_by',
                    updated_at                  = '$updated_at'
                    WHERE id_berita             = $id_berita
                ";
    // var_dump($query);
    // die();

    mysqli_query($conn, $query);


    //cek keberhasilan
    if (mysqli_affected_rows($conn) > 0) {
        echo "
            <script>
                alert('Data berhasil diubah!');
                window.location.href = '../berita';
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
            <a href="index.php">
                <i class="nav-icon fas fa-home mr-1"></i>Dashboard admin</a> >
            <a href="index.php">
                <i class="nav-icon fas fa-cog mr-1"></i>Kelola Berita</a> >
            <a href="edit.php?id_berita=<?= $id_berita ?>">
                <i class="nav-icon fas fa-plus-square mr-1"></i>Edit Berita</a>
        </div>
        <div class="form-profil">
            <div class="mt-2 regis-title">
                <h3>Edit Berita</h3>
            </div>
            <form action="" enctype="multipart/form-data" method="POST">
                <input type="hidden" name="id_berita" value="<?= $berita["id_berita"]; ?>">
                <input type="hidden" name="gambarLama" value="<?= $berita["gambar_berita"]; ?>">
                <div class="form-group label-txt">
                    <div class="form-group mt-4 mb-3">
                        <label for="tb_judul_berita" class="label-txt">Judul Berita<span class="red-star">*</span></label>
                        <input type="text" id="tb_judul_berita" name="tb_judul_berita" class="form-control" placeholder="Judul Berita" value="<?= $berita["judul_berita"]; ?>">
                    </div>
                    <div class="form-group mt-4 mb-3">
                        <label for="tb_kategori_berita">Kategori</label>
                        <select class="form-control" id="tb_kategori_berita" name="tb_kategori_berita">
                            <option value="0" <?php if ($berita['kategori_berita'] == '0') echo 'selected' ?>>Kegiatan</option>
                            <option value="1" <?php if ($berita['kategori_berita'] == '1') echo 'selected' ?>>Berita</option>
                        </select>
                    </div>
                    <div class="form-group mt-4 mb-3">
                        <label for="tb_tgl_kejadian" class="label-txt">Tanggal Kejadian<span class="red-star">*</span></label>
                        <input type="date" id="tb_tgl_kejadian" name="tb_tgl_kejadian" class="form-control" value="<?= $berita["tgl_kejadian"]; ?>">
                    </div>
                    <div class="form-group">
                        <label for="tb_isi_berita" class="label-txt">Isi Berita<span class="red-star">*</span></label>
                        <textarea class="form-control" id="tb_isi_berita" name="tb_isi_berita" rows="6" placeholder="Isi Berita"><?= $berita["isi_berita"]; ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="image_uploads" class="label-txt">Foto Berita<span class="red-star">*</span></label><br>
                        <img src="../../img/<?= $berita["gambar_berita"]; ?>" class="edit-img popup " alt="">
                        <div class="file-form">
                            <input type="file" id="image_uploads" name="image_uploads" class="form-control">
                        </div>
                    </div>
                    <!-- Hanya muncul jika level user = 3 / super admin -->
                    <?php if ($_SESSION['level_user'] == 1 || $_SESSION['level_user'] == '2a' || $_SESSION['level_user'] == '2b') { ?>
                        <div class="form-group mb-5">
                            <label for="status_berita" class="font-weight-bold"><span class="label-form-span">Status Berita</span></label><br>
                            <div class="radio-wrapper mt-1 bg-white">
                                <div class="form-check form-check-inline">
                                    <input type="radio" id="status_berita" name="status_berita" class="form-check-input" value="1" <?php if ($berita['status_berita'] == 1) echo 'checked' ?>>
                                    <label class="form-check-label" for="status_berita">Pending</label>
                                </div>
                            </div>
                            <div class="radio-wrapper2 mt-1 bg-white">
                                <div class="form-check form-check-inline">
                                    <input type="radio" id="status_berita" name="status_berita" class="form-check-input" value="2" <?php if ($berita['status_berita'] == 2) echo 'checked' ?>>
                                    <label class="form-check-label" for="status_berita">Publikasi</label>
                                </div>
                            </div>

                            <div class="form-group mb-2"><br><br></div>
                        </div>
                    <?php } ?>
                </div>
                <button type="submit" name="submit" value="Simpan" class="btn btn-lg btn-primary w-100 yst-login-btn border-0 mt-4 mb-4">
                    <span class="yst-login-btn-fs">Perbarui Berita</span>
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