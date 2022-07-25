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



if (isset($_POST["submit"])) {

    $kategori_donasi      = $_POST["tb_kategori_donasi"];
    $kategori_donasi        = htmlspecialchars($kategori_donasi);

    $ket_kategori_donasi      = $_POST["tb_ket_kategori_donasi"];


    $query = "INSERT INTO t_kat_donasi (kategori_donasi,ket_kategori_donasi)
                VALUES ('$kategori_donasi','$ket_kategori_donasi')  
                     ";



    mysqli_query($conn, $query);
    // var_dump($query);die;

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
                        <label for="tb_kategori">NIK<span class="red-star">*</span></label></label>
                        <select class="form-control" id="tb_kategori" name="tb_kategori" required>
                            <option value="" selected disabled>Pilih NIK</option>
                            <option value="">NIK 111222</option>
                            <option value="">NIK 222333</option>
                            <option value="">NIK 444555</option>
                        </select>
                    </div>
                    <div class="form-group mt-4 mb-3" id="tgl_selesai_form">
                        <label for="tb_tgl_selesai" class="label-txt">Tanggal<span class="red-star">*</span></label>
                        <input type="date" id="tb_tgl_selesai" name="tb_tgl_selesai" class="form-control" placeholder="Tanggal akhir pengumpulan dana">
                    </div>
                    <div class="form-group mt-4 mb-3" id="tgl_selesai_form">
                        <label for="tb_tgl_selesai" class="label-txt">Waktu<span class="red-star">*</span></label>
                        <input type="time" id="tb_tgl_selesai" name="tb_tgl_selesai" class="form-control" placeholder="Tanggal akhir pengumpulan dana">
                    </div>
                    <div class="form-group mt-4 mb-3">
                        <label for="tb_nama_program_donasi" class="label-txt">Tempat<span class="red-star">*</span></label>
                        <input type="text" id="tb_nama_program_donasi" name="tb_nama_program_donasi" class="form-control" placeholder="Tempat Meninggal" Required>
                    </div>
                    <div class="form-group mt-4 mb-3">
                        <label for="tb_nama_program_donasi" class="label-txt">Tempat Pemakaman<span class="red-star">*</span></label>
                        <input type="text" id="tb_nama_program_donasi" name="tb_nama_program_donasi" class="form-control" placeholder="Tempat Pemakaman" Required>
                    </div>
                    <div class="form-group">
                        <label for="tb_ket_kategori_donasi" class="label-txt">Penyebab Kematian</label>
                        <textarea class="form-control" id="tb_ket_kategori_donasi" name="tb_ket_kategori_donasi" rows="6" placeholder="Penyebab Kematian"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="image_uploads2" class="label-txt"> Kartu Keluarga </label><br>
                        <!-- <img src="img/" class="edit-img popup " alt=""> -->
                        <div class="file-form">
                            <input type="file" id="image_uploads2" name="image_uploads2" class="form-control ">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="image_uploads2" class="label-txt"> Surat Keterangan Kematian </label><br>
                        <!-- <img src="img/" class="edit-img popup " alt=""> -->
                        <div class="file-form">
                            <input type="file" id="image_uploads2" name="image_uploads2" class="form-control ">
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