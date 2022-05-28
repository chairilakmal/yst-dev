<?php
session_start();
include '../../config/connection.php';


if (!isset($_SESSION["username"])) {
    header('Location: login.php?status=restrictedaccess');
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
            <a href="dashboard-admin.php">
                <i class="nav-icon fas fa-home mr-1"></i>Dashboard admin</a> >
            <a href="kelola-beasiswa.php">
                <i class="nav-icon fas fa-cog mr-1"></i>Kelola Beasiswa</a>
        </div>
        <div class="form-profil">
            <div class="mt-2 regis-title">
                <h3>Edit Beasiswa</h3>
            </div>
            <form action="" enctype="multipart/form-data" method="POST">
                <div class="form-group label-txt">
                    <div class="form-group mt-4 mb-3">
                        <label for="tb_penerima" class="label-txt">Penerima<span class="red-star">*</span></label>
                        <input type="text" id="tb_penerima" name="tb_penerima" class="form-control" placeholder="Nama penerima" Required>
                    </div>
                    <div class="form-group mt-4 mb-3" id="tgl_selesai_form">
                        <label for="tb_tgl_selesai" class="label-txt">Tanggal<span class="red-star">*</span></label>
                        <input type="date" id="tb_tgl_selesai" name="tb_tgl_selesai" class="form-control" placeholder="Tanggal akhir pengumpulan dana">
                    </div>
                    <div class="form-group mt-4 mb-3">
                        <label for="tb_nama_program_donasi" class="label-txt">Nominal<span class="red-star">*</span></label>
                        <input type="number" id="tb_nama_program_donasi" name="tb_nama_program_donasi" class="form-control" placeholder="Masukan nominal beasiswa" Required>
                    </div>
                    <div class="form-group">
                        <label for="tb_ket_kategori_donasi" class="label-txt">Keterangan</label>
                        <textarea class="form-control" id="tb_ket_kategori_donasi" name="tb_ket_kategori_donasi" rows="6" placeholder="Keterangan"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="image_uploads2" class="label-txt"> Bukti Transfer</label><br>
                        <!-- <img src="img/" class="edit-img popup " alt=""> -->
                        <div class="file-form">
                            <input type="file" id="image_uploads2" name="image_uploads2" class="form-control ">
                        </div>
                    </div>
                    <div class="form-group mb-5">
                        <label for="status_program_donasi" class="font-weight-bold"><span class="label-form-span">Status Beasiswa</span></label><br>
                        <div class="radio-wrapper mt-1 bg-white">
                            <div class="form-check form-check-inline">
                                <input type="radio" id="status_program_donasi" name="status_program_donasi" class="form-check-input" value="Pending" checked>
                                <label class="form-check-label" for="status_program_donasi">1</label>
                            </div>
                        </div>
                        <div class="radio-wrapper2 mt-1 bg-white">
                            <div class="form-check form-check-inline">
                                <input type="radio" id="status_program_donasi" name="status_program_donasi" class="form-check-input" value="Berjalan">
                                <label class="form-check-label" for="status_program_donasi">2</label>
                            </div>
                        </div>
                        <div class="radio-wrapper mt-1 ml-3 bg-white">
                            <div class="form-check form-check-inline">
                                <input type="radio" id="status_program_donasi" name="status_program_donasi" class="form-check-input" value="Siap disalurkan">
                                <label class="form-check-label" for="status_program_donasi">3</label>
                            </div>
                        </div>
                        <div class="radio-wrapper mt-1 bg-white">
                            <div class="form-check form-check-inline">
                                <input type="radio" id="status_program_donasi" name="status_program_donasi" class="form-check-input" value="Selesai">
                                <label class="form-check-label" for="status_program_donasi">4</label>
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
</main>
</div>
<!-- /.container-fluid -->
<!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php include '../../component/admin/footer.php'; ?>