<?php
session_start();
include '../../config/connection.php';


if (!isset($_SESSION["username"])) {
    header('Location: ../../login.php?status=restrictedaccess');
    exit;
}

if ($_SESSION["level_user"] == 4){
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
$kategoriRelawan = queryKategori("SELECT * FROM t_kat_relawan
                    ORDER BY id_kat_relawan
                    ");

function upload()
{
    //upload gambar
    $namaFile = $_FILES['image_uploads']['name'];
    $ukuranFile = $_FILES['image_uploads']['size'];
    $error = $_FILES['image_uploads']['error'];
    $tmpName = $_FILES['image_uploads']['tmp_name'];

    if ($error === 4) {
        echo "
                     <script>
                         alert('gambar tidak ditemukan !');
                     </script>
                 ";
        return false;
    }

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

function uploadSyaratKetentuan()
{
    //upload gambar
    $namaFile = $_FILES['syarat_ketentuan_uploads']['name'];
    $ukuranFile = $_FILES['syarat_ketentuan_uploads']['size'];
    $error = $_FILES['syarat_ketentuan_uploads']['error'];
    $tmpName = $_FILES['syarat_ketentuan_uploads']['tmp_name'];

    if ($error === 4) {
        echo "
                     <script>
                         alert('gambar tidak ditemukan !');
                     </script>
                 ";
        return false;
    }

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

    $nama_program_relawan        = $_POST["tb_nama_program_relawan"];
    $nama_program_relawan        = htmlspecialchars($nama_program_relawan);


    $deskripsi_singkat_relawan   = $_POST["tb_deskripsi_relawan_singkat"];
    $deskripsi_singkat_relawan   = htmlspecialchars($deskripsi_singkat_relawan);

    $target_relawan              = $_POST["tb_target_relawan"];

    $tgl_pelaksanaan              = $_POST["tb_tgl_pelaksanaan"];

    $lokasi_program              = $_POST["tb_lokasi_program"];
    $lokasi_program              = htmlspecialchars($lokasi_program);

    $deskripsi_lengkap_relawan   = $_POST["tb_deskripsi_relawan_lengkap"];
    $deskripsi_lengkap_relawan   = htmlspecialchars($deskripsi_lengkap_relawan);

    $gambar = upload();
    $gambarSyaratKetentuan = uploadSyaratKetentuan();

    $status_program_relawan      = "Pending";


    $tgl_prelawan                = date('Y-m-d', time());

    $status_program_relawan      = "Pending";

    $lokasi_awal                 = $_POST["tb_lokasi_awal"];

    $penanggung_jawab            = $_POST["tb_penanggung_jawab"];
    $penanggung_jawab            = htmlspecialchars($penanggung_jawab);

    $tenggat_waktu               = $_POST["tb_tenggat_waktu"];

    $kategori_relawan            = $_POST["tb_kategori"];

    $created_by = $_SESSION["nama"];



    $query = "INSERT INTO t_program_relawan (nama_program_relawan,deskripsi_singkat_relawan,target_relawan,tgl_pelaksanaan,lokasi_program,deskripsi_lengkap_relawan,foto_p_relawan,status_program_relawan,tgl_prelawan,lokasi_awal,penanggung_jawab,tenggat_waktu,kategori_relawan, file_syarat_ketentuan, created_by)
VALUES ('$nama_program_relawan','$deskripsi_singkat_relawan','$target_relawan','$tgl_pelaksanaan','$lokasi_program',' $deskripsi_lengkap_relawan','$gambar','$status_program_relawan','$tgl_prelawan','$lokasi_awal','$penanggung_jawab','$tenggat_waktu','$kategori_relawan','$gambarSyaratKetentuan', '$created_by')  
     ";

    mysqli_query($conn, $query);

    // var_dump($query);die;

    //cek keberhasilan
    if (mysqli_affected_rows($conn) > 0) {
        echo "
            <script>
                alert('Data berhasil ditambahkan!');
                window.location.href = '../program-relawan'; 
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
                <i class="nav-icon fas fa-cog mr-1"></i>Program relawan</a> >
            <a href="input.php">
                <i class="nav-icon fas fa-plus-square mr-1"></i>Input program relawan</a>
        </div>
        <div class="form-profil">
            <div class="mt-2 regis-title">
                <h3>Input Program Relawan</h3>
            </div>
            <form action="" enctype="multipart/form-data" method="POST">
                <div class="form-group label-txt">
                    <div class="form-group mt-4 mb-3">
                        <label for="tb_nama_program_relawan" class="label-txt">Nama Program<span class="red-star">*</span></label>
                        <input type="text" id="tb_nama_program_relawan" name="tb_nama_program_relawan" class="form-control" placeholder="Nama program relawan" Required>
                    </div>


                    <div class="form-group mt-4 mb-3">
                        <label for="tb_kategori">Kategori Program Relawan<span class="red-star">*</span></label></label>
                        <select class="form-control" id="tb_kategori" name="tb_kategori" required>
                            <?php foreach ($kategoriRelawan as $row) : ?>
                                <option value="<?= $row["kategori_relawan"]; ?>"><?= $row["kategori_relawan"]; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>


                    <div class="form-group mt-4 mb-3">
                        <label for="tb_penanggung_jawab" class="label-txt">Penanggung Jawab<span class="red-star">*</span></label>
                        <input type="text" id="tb_penanggung_jawab" name="tb_penanggung_jawab" class="form-control" placeholder="Nama penanggung jawab" Required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="tb_target_relawan" class="label-txt">Target Jumlah Relawan<span class="red-star">*</span></label>
                        <input type="number" id="tb_target_relawan" name="tb_target_relawan" class="form-control" placeholder="Target relawan dikumpulkan" Required>
                    </div>
                    <div class="form-group mt-4 mb-3">
                        <label for="tb_lokasi_program" class="label-txt">Lokasi Pelaksanaan<span class="red-star">*</span></label>
                        <input type="text" id="tb_lokasi_program" name="tb_lokasi_program" class="form-control" placeholder="Lokasi dilaksanakannya program relawan" Required>
                    </div>
                    <div class="form-group mt-4 mb-3">
                        <label for="tb_lokasi_awal" class="label-txt">Lokasi Titik Kumpul<span class="red-star">*</span></label>
                        <input type="text" id="tb_lokasi_awal" name="tb_lokasi_awal" class="form-control" placeholder="Lokasi Titik kumpul" Required>
                    </div>
                    <div class="form-group mt-4 mb-3">
                        <label for="tb_tgl_pelaksanaan" class="label-txt">Tanggal Pelaksanaan Program<span class="red-star">*</span></label>
                        <input type="date" id="tb_tgl_pelaksanaan" name="tb_tgl_pelaksanaan" class="form-control" placeholder="Tanggal dilaksanakannya program relawan" Required>
                    </div>
                    <div class="form-group mt-4 mb-3">
                        <label for="tb_tenggat_waktu" class="label-txt">Tenggat Waktu Pengumpulan Relawan<span class="red-star">*</span></label>
                        <input type="date" id="tb_tenggat_waktu" name="tb_tenggat_waktu" class="form-control" placeholder="Lokasi Titik kumpul" Required>
                    </div>
                    <div class="form-group">
                        <label for="tb_deskripsi_relawan_singkat" class="label-txt">Deskripsi Singkat Program<span class="red-star">*</span></label>
                        <textarea class="form-control" id="tb_deskripsi_relawan_singkat" name="tb_deskripsi_relawan_singkat" rows="2" placeholder="Gambaran umum tentang program" Required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="tb_deskripsi_relawan_lengkap" class="label-txt">Deskripsi Lengkap Program</label>
                        <textarea class="form-control" id="tb_deskripsi_relawan_lengkap" name="tb_deskripsi_relawan_lengkap" rows="6" placeholder="Gambaran lengkap tentang program"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="image_uploads" class="label-txt">Foto Program<span class="red-star">*</span></label>
                        <div class="file-form">
                            <input type="file" id="image_uploads" name="image_uploads" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="syarat_ketentuan_uploads" class="label-txt">Foto Syarat dan Ketentuan<span class="red-star">*</span></label>
                        <div class="file-form">
                            <input type="file" id="syarat_ketentuan_uploads" name="syarat_ketentuan_uploads" class="form-control">
                        </div>
                    </div>
                </div>
                <button type="submit" name="submit" value="Simpan" class="btn btn-lg btn-primary w-100 yst-login-btn border-0 mt-4 mb-4">
                    <span class="yst-login-btn-fs">Buat Program</span></button>
            </form>
        </div>
    </main>
</div>
<!-- /.container-fluid -->
<!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php include '../../component/admin/footer.php'; ?>