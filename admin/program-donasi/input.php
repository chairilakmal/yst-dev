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

// Kategori
function queryKategori($query)
{
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}
$kategoriDonasi = queryKategori("SELECT * FROM t_kat_donasi
                    ORDER BY id_kat_donasi
                    ");

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
    move_uploaded_file($tmpName, '../../upload/' . $namaFileBaru);

    return $namaFileBaru;
}


if (isset($_POST["submit"])) {

    $nama_program_donasi        = $_POST["tb_nama_program_donasi"];
    $nama_program_donasi        = htmlspecialchars($nama_program_donasi);

    $deskripsi_singkat_donasi   = $_POST["tb_deskripsi_donasi_singkat"];
    $deskripsi_singkat_donasi   = htmlspecialchars($deskripsi_singkat_donasi);

    $target_dana                = $_POST["tb_target_dana"];


    $deskripsi_lengkap_donasi   = $_POST["tb_deskripsi_donasi_lengkap"];
    $deskripsi_lengkap_donasi   = htmlspecialchars($deskripsi_lengkap_donasi);

    $status_program_donasi      = "Pending";

    $gambar                     = upload();

    $tgl_pdonasi                = date('Y-m-d', time());

    $tgl_selesai                = $_POST["tb_tgl_selesai"];
    $penerima_donasi            = $_POST["tb_penerima_donasi"];
    $penanggung_jawab           = $_POST["tb_penanggung_jawab"];

    $jangka_waktu               = $_POST["tb_jangka_waktu"];

    $kategori_donasi            = $_POST["tb_kategori"];

    $created_by = $_SESSION["nama"];

    if ($jangka_waktu == 1) {
        $tgl_selesai = "2040-12-12";
    }


    $query = "INSERT INTO t_program_donasi (nama_program_donasi, deskripsi_singkat_donasi, target_dana,deskripsi_lengkap_donasi,foto_p_donasi,tgl_pdonasi,tgl_selesai,status_program_donasi,penerima_donasi,penanggung_jawab,jangka_waktu,kategori_donasi,created_by)
                VALUES ('$nama_program_donasi','$deskripsi_singkat_donasi','$target_dana',' $deskripsi_lengkap_donasi','$gambar','$tgl_pdonasi','$tgl_selesai','$status_program_donasi','$penerima_donasi','$penanggung_jawab','$jangka_waktu','$kategori_donasi','$created_by')  
                     ";



    mysqli_query($conn, $query);


    //cek keberhasilan
    if (mysqli_affected_rows($conn) > 0) {
        echo "
            <script>
                alert('Data berhasil ditambahkan!');
                window.location.href = '../program-donasi'; 
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
                <i class="nav-icon fas fa-cog mr-1"></i>Program donasi</a> >
            <a href="input.php">
                <i class="nav-icon fas fa-plus-square mr-1"></i>Input program donasi</a>
        </div>
        <div class="form-profil">
            <div class="mt-2 regis-title">
                <h3>Input Program Donasi</h3>
            </div>
            <form action="" enctype="multipart/form-data" method="POST">
                <div class="form-group label-txt">
                    <div class="form-group mt-4 mb-3">
                        <label for="tb_kategori">Kategori Donasi<span class="red-star">*</span></label></label>
                        <select class="form-control" id="tb_kategori" name="tb_kategori" required>
                            <?php foreach ($kategoriDonasi as $row) : ?>
                                <option value="<?= $row["kategori_donasi"]; ?>"><?= $row["kategori_donasi"]; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group mt-4 mb-3">
                        <label for="tb_nama_program_donasi" class="label-txt">Nama Program<span class="red-star">*</span></label>
                        <input type="text" id="tb_nama_program_donasi" name="tb_nama_program_donasi" class="form-control" placeholder="Nama program donasi" Required>
                    </div>
                    <div class="form-group mt-4 mb-3">
                        <label for="tb_penanggung_jawab" class="label-txt">Penanggung Jawab<span class="red-star">*</span></label>
                        <input type="text" id="tb_penanggung_jawab" name="tb_penanggung_jawab" class="form-control" placeholder="Nama penanggung jawab" Required>
                    </div>
                    <div class="form-group mt-4 mb-3">
                        <label for="tb_penerima_donasi" class="label-txt">Penerima Donasi<span class="red-star">*</span></label>
                        <input type="text" id="tb_penerima_donasi" name="tb_penerima_donasi" class="form-control" placeholder="Penerima Donasi" Required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="tb_target_dana" class="label-txt">Target Dana<span class="red-star">*</span></label>
                        <input type="number" id="tb_target_dana" name="tb_target_dana" class="form-control" placeholder="Target dana dikumpulkan" Required>
                    </div>
                    <div class="form-group mt-4 mb-3">
                        <label for="tb_jangka_waktu">Jangka Waktu<span class="red-star">*</span></label></label>
                        <select class="form-control" id="tb_jangka_waktu" name="tb_jangka_waktu" required>
                            <option value="0">Tidak Tetap</option>
                            <option value="1">Tetap</option>
                        </select>
                    </div>
                    <div class="form-group mt-4 mb-3" id="tgl_selesai_form">
                        <label for="tb_tgl_selesai" class="label-txt">Tenggat Waktu Pengumpulan Donasi<span class="red-star">*</span></label>
                        <input type="date" id="tb_tgl_selesai" name="tb_tgl_selesai" class="form-control" placeholder="Tanggal akhir pengumpulan dana">
                    </div>
                    <div class="form-group">
                        <label for="tb_deskripsi_donasi_singkat" class="label-txt">Deskripsi Singkat<span class="red-star">*</span></label>
                        <textarea class="form-control" id="tb_deskripsi_donasi_singkat" name="tb_deskripsi_donasi_singkat" rows="2" placeholder="Gambaran umum tentang program" Required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="tb_deskripsi_donasi_lengkap" class="label-txt">Deskripsi Lengkap</label>
                        <textarea class="form-control" id="tb_deskripsi_donasi_lengkap" name="tb_deskripsi_donasi_lengkap" rows="6" placeholder="Gambaran lengkap tentang program"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="image_uploads" class="label-txt">Foto Program<span class="red-star">*</span></label>
                        <div class="file-form">
                            <input type="file" id="image_uploads" name="image_uploads" class="form-control" Required>
                        </div>
                    </div>
                </div>
                <button type="submit" name="submit" value="Simpan" class="btn btn-lg btn-primary w-100 yst-login-btn border-0 mt-4 mb-4">
                    <span class="yst-login-btn-fs">Buat Program</span>
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