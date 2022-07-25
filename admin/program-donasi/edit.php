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

$level_user = $_SESSION['level_user'];

//ambil id program di URL
$id_program_donasi = $_GET["id_program_donasi"];

function upload()
{
    //upload gambar
    $namaFile = $_FILES['image_uploads']['name'];
    $ukuranFile = $_FILES['image_uploads']['size'];
    $error = $_FILES['image_uploads']['error'];
    $tmpName = $_FILES['image_uploads']['tmp_name'];


    // if($error === 4){
    //     echo "
    //         <script>
    //             alert('gambar tidak ditemukan !');
    //         </script>
    //     ";
    //     return false;
    // }

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

function upload2()
{
    //upload gambar
    $namaFile2 = $_FILES['image_uploads2']['name'];
    $ukuranFile2 = $_FILES['image_uploads2']['size'];
    $error = $_FILES['image_uploads2']['error'];
    $tmpName2 = $_FILES['image_uploads2']['tmp_name'];

    //cek ekstensi gambar
    $ekstensiGambarValid2 = ['jpg', 'jpeg', 'png'];
    $ekstensiGambar2 = explode('.', $namaFile2);
    $ekstensiGambar2 = strtolower(end($ekstensiGambar2));

    //generate nama baru
    $namaFileBaru2 = uniqid();
    $namaFileBaru2 .= '.';
    $namaFileBaru2 .= $ekstensiGambar2;


    //lolos pengecekan
    move_uploaded_file($tmpName2, '../../img/' . $namaFileBaru2);
    return $namaFileBaru2;
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

$programDonasi = query("SELECT * FROM t_program_donasi WHERE id_program_donasi = $id_program_donasi")[0];
// var_dump($programDonasi);die;

//UPDATE
if (isset($_POST["submit"])) {



    $nama_program_donasi        = $_POST["tb_nama_program_donasi"];
    $nama_program_donasi        = htmlspecialchars($nama_program_donasi);

    $penanggung_jawab           = $_POST["tb_penanggung_jawab"];

    $deskripsi_singkat_donasi   = $_POST["tb_deskripsi_donasi_singkat"];
    $deskripsi_singkat_donasi   = htmlspecialchars($deskripsi_singkat_donasi);

    $target_dana                = $_POST["tb_target_dana"];

    $deskripsi_lengkap_donasi   = $_POST["tb_deskripsi_donasi_lengkap"];
    $deskripsi_lengkap_donasi   = htmlspecialchars($deskripsi_lengkap_donasi);

    $gambarLama                 = $_POST["gambarLama"];

    $gambarLama2                 = $_POST["gambarLama2"];

    $penerima_donasi            = $_POST["tb_penerima_donasi"];

    $tgl_penyaluran             = $_POST["tb_tgl_penyaluran"];

    $status_program_donasi      = $_POST["status_program_donasi"];

    $jangka_waktu               = $_POST["tb_jangka_waktu"];

    if ($jangka_waktu != 1) {
        $tgl_selesai                = $_POST["tb_tgl_selesai"];
    }


    if ($_FILES['image_uploads']['error'] === 4) {
        $gambar = $gambarLama;
    } else {
        $gambar = upload();
    }

    if ($_FILES['image_uploads2']['error'] === 4) {
        $gambar2 = $gambarLama2;
    } else {
        $gambar2 = upload2();
    }

    // if (isset($_FILES['image_uploads2'], $_POST['tb_tgl_penyaluran'])) {//do the fields exist
    //     if($_FILES['image_uploads2'] && $_POST['tb_tgl_penyaluran']){ //do the fields contain data
    //         $status_program_donasi      = 'Selesai';
    //     }
    // }

    // GLOBAL UPDATE
    $query = "UPDATE t_program_donasi SET
                    nama_program_donasi         = '$nama_program_donasi',
                    penanggung_jawab            = '$penanggung_jawab',
                    deskripsi_singkat_donasi    = '$deskripsi_singkat_donasi',
                    target_dana                 = '$target_dana',
                    deskripsi_lengkap_donasi    = '$deskripsi_lengkap_donasi',              
                    foto_p_donasi               = '$gambar',
                    penerima_donasi             = '$penerima_donasi',
                    bukti_penyaluran            = '$gambar2',
                    tgl_penyaluran              = '$tgl_penyaluran'
                  WHERE id_program_donasi       = $id_program_donasi
                ";

    //SUPERADMIN UPDATE (DENGAN STATUS)
    if ($_SESSION['level_user'] == 1 || $_SESSION['level_user'] == 2) {
        $status_program_donasi      = $_POST["status_program_donasi"];

        $query = "UPDATE t_program_donasi SET
                    nama_program_donasi         = '$nama_program_donasi',
                    penanggung_jawab            = '$penanggung_jawab',
                    deskripsi_singkat_donasi    = '$deskripsi_singkat_donasi',
                    target_dana                 = '$target_dana',
                    deskripsi_lengkap_donasi    = '$deskripsi_lengkap_donasi',
                    status_program_donasi       = '$status_program_donasi',
                    foto_p_donasi               = '$gambar',
                    penerima_donasi             = '$penerima_donasi',
                    bukti_penyaluran            = '$gambar2',
                    tgl_penyaluran              = '$tgl_penyaluran'
                  WHERE id_program_donasi       = $id_program_donasi
                ";
    }


    mysqli_query($conn, $query);
    // var_dump($query);die();


    //cek keberhasilan
    if (mysqli_affected_rows($conn) > 0) {
        echo "
            <script>
                alert('Data berhasil diubah!');
                window.location.href = '../berita/index.php'; 
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
                <i class="nav-icon fas fa-cog mr-1"></i>Program donasi</a> >
            <a href="edit.php">
                <i class="nav-icon fas fa-plus-square mr-1"></i>Edit program donasi</a>
        </div>
        <div class="form-profil">
            <div class="mt-2 regis-title">
                <h3>Edit Program Donasi</h3>
            </div>
            <form action="" enctype="multipart/form-data" method="POST">
                <input type="hidden" name="id_program_donasi" value="<?= $programDonasi["id_program_donasi"]; ?>">
                <input type="hidden" name="gambarLama" value="<?= $programDonasi["foto_p_donasi"]; ?>">
                <input type="hidden" name="gambarLama2" value="<?= $programDonasi["bukti_penyaluran"]; ?>">


                <div class="form-group label-txt">
                    <div class="form-group mt-4 mb-3">
                        <label for="tb_nama_program_donasi" class="label-txt">Nama Program</label>
                        <input type="text" id="tb_nama_program_donasi" name="tb_nama_program_donasi" class="form-control" placeholder="Nama program donasi" value="<?= $programDonasi["nama_program_donasi"]; ?>">
                    </div>
                    <div class="form-group mt-4 mb-3">
                        <label for="tb_kategori" class="label-txt">Kategori Program</label>
                        <input type="text" id="tb_kategori" name="tb_kategori" class="form-control" placeholder="Kategori program donasi" value="<?= $programDonasi["kategori_donasi"]; ?>" readonly>
                    </div>
                    <div class="form-group mt-4 mb-3">
                        <label for="tb_penanggung_jawab" class="label-txt">Penanggung Jawab</label>
                        <input type="text" id="tb_penanggung_jawab" name="tb_penanggung_jawab" class="form-control" placeholder="Nama penanggung jawab" value="<?= $programDonasi["penanggung_jawab"]; ?>">
                    </div>
                    <div class="form-group mb-3">
                        <label for="tb_target_dana" class="label-txt">Target Dana</label>
                        <input type="number" id="tb_target_dana" name="tb_target_dana" class="form-control" placeholder="Target dana dikumpulkan" value="<?= $programDonasi["target_dana"]; ?>">
                    </div>
                    <div class="form-group mb-3">
                        <label for="tb_penerima_donasi" class="label-txt">Penerima Donasi</label>
                        <input type="text" id="tb_penerima_donasi" name="tb_penerima_donasi" class="form-control" placeholder="Penerima donasi" value="<?php echo $programDonasi["penerima_donasi"]; ?>">
                    </div>

                    <div class="form-group mt-4 mb-3">
                        <label for="tb_jangka_waktu" class="label-txt">Jangka Waktu</label>
                        <input type="text" id="tb_jangka_waktu" name="tb_jangka_waktu" class="form-control" placeholder="Nama program donasi" value="<?php
                                                                                                                                                        if ($programDonasi["jangka_waktu"] == 0) {
                                                                                                                                                            echo "Tidak Tetap";
                                                                                                                                                        } else
                                                                                                                                                            echo "Tetap";
                                                                                                                                                        ?>" readonly>

                    </div>

                    <?php if ($programDonasi['jangka_waktu'] != 1) { ?>
                        <div class="form-group mt-4 mb-3">
                            <label for="tb_tgl_selesai" class="label-txt">Batas Waktu Pengumpulan</label>
                            <input type="date" id="tb_tgl_selesai" name="tb_tgl_selesai" class="form-control" value="<?php $programDonasi['tgl_selesai'] = preg_replace("/\s/", 'T', $programDonasi['tgl_selesai']);
                                                                                                                        echo $programDonasi['tgl_selesai'] ?>" REQUIRED readonly>
                        </div>

                    <?php } ?>




                    <div class="form-group">
                        <label for="tb_deskripsi_donasi_singkat" class="label-txt">Deskripsi Singkat</label>
                        <textarea class="form-control" id="tb_deskripsi_donasi_singkat" name="tb_deskripsi_donasi_singkat" rows="2"><?= $programDonasi["deskripsi_singkat_donasi"]; ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="tb_deskripsi_donasi_lengkap" class="label-txt">Deskripsi Lengkap</label>
                        <textarea class="form-control" id="tb_deskripsi_donasi_lengkap" name="tb_deskripsi_donasi_lengkap" rows="6"><?= $programDonasi["deskripsi_lengkap_donasi"]; ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="image_uploads" class="label-txt">Foto Program</label><br>
                        <img src="../../img/<?= $programDonasi["foto_p_donasi"]; ?>" class="edit-img popup " alt="">
                        <div class="file-form">
                            <input type="file" id="image_uploads" name="image_uploads" class="form-control ">
                        </div>
                    </div>

                    <div class="d-none">
                        <div class="form-group upload-bukti">
                            <h3 class="mt-4">Bukti Penyaluran Dana</h3>
                            <label for="image_uploads2" class="label-txt">Foto Bukti Penyaluran Dana</label><br>
                            <img src="../../img/<?= $programDonasi["bukti_penyaluran"]; ?>" class="edit-img popup " alt="">
                            <div class="file-form">
                                <input type="file" id="image_uploads2" name="image_uploads2" class="form-control ">
                            </div>
                        </div>
                        <div class="form-group mt-4 mb-3">
                            <label for="tb_tgl_penyaluran" class="label-txt">Tanggal Penyaluran Dana</label>
                            <input type="date" id="tb_tgl_penyaluran" name="tb_tgl_penyaluran" class="form-control" value="<?= $programDonasi["tgl_penyaluran"]; ?>">
                        </div>
                    </div>
                    <!-- Untuk upload bukti penyaluran -->
                    <?php if ($programDonasi['status_program_donasi'] == 'Siap disalurkan' || $programDonasi['status_program_donasi'] == 'Selesai') { ?>
                        <div class="second-bg">
                            <div class="form-group upload-bukti">
                                <h3 class="mt-4">Bukti Penyaluran Dana</h3>
                                <label for="image_uploads2" class="label-txt">Foto Bukti Penyaluran Dana</label><br>
                                <img src="../../img/<?= $programDonasi["bukti_penyaluran"]; ?>" class="edit-img popup " alt="">
                                <div class="file-form">
                                    <input type="file" id="image_uploads2" name="image_uploads2" class="form-control ">
                                </div>
                            </div>
                            <div class="form-group mt-4 mb-3">
                                <label for="tb_tgl_penyaluran" class="label-txt">Tanggal Penyaluran Dana</label>
                                <input type="date" id="tb_tgl_penyaluran" name="tb_tgl_penyaluran" class="form-control" value="<?= $programDonasi["tgl_penyaluran"]; ?>">
                            </div>

                        <?php } ?>
                        <!-- END Untuk upload bukti penyaluran -->

                        <!-- Hanya muncul jika level user = 1/2 / super admin -->
                        <?php if ($_SESSION['level_user'] == 1 || $_SESSION['level_user'] == 2) { ?>
                            <div class="form-group mb-5">
                                <label for="status_program_donasi" class="font-weight-bold"><span class="label-form-span">Status Program</span></label><br>
                                <div class="radio-wrapper mt-1 bg-white">
                                    <div class="form-check form-check-inline">
                                        <input type="radio" id="status_program_donasi" name="status_program_donasi" class="form-check-input" value="Pending" <?php if ($programDonasi['status_program_donasi'] == 'Pending') echo 'checked' ?>>
                                        <label class="form-check-label" for="status_program_donasi">Pending</label>
                                    </div>
                                </div>
                                <div class="radio-wrapper2 mt-1 bg-white">
                                    <div class="form-check form-check-inline">
                                        <input type="radio" id="status_program_donasi" name="status_program_donasi" class="form-check-input" value="Berjalan" <?php if ($programDonasi['status_program_donasi'] == 'Berjalan') echo 'checked' ?>>
                                        <label class="form-check-label" for="status_program_donasi">Berjalan</label>
                                    </div>
                                </div>
                                <div class="radio-wrapper mt-1 ml-3 bg-white">
                                    <div class="form-check form-check-inline">
                                        <input type="radio" id="status_program_donasi" name="status_program_donasi" class="form-check-input" value="Siap disalurkan" <?php if ($programDonasi['status_program_donasi'] == 'Siap disalurkan') echo 'checked' ?>>
                                        <label class="form-check-label" for="status_program_donasi">Siap disalurkan</label>
                                    </div>
                                </div>
                                <div class="radio-wrapper mt-1 bg-white">
                                    <div class="form-check form-check-inline">
                                        <input type="radio" id="status_program_donasi" name="status_program_donasi" class="form-check-input" value="Selesai" <?php if ($programDonasi['status_program_donasi'] == 'Selesai') echo 'checked' ?>>
                                        <label class="form-check-label" for="status_program_donasi">Selesai</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mb-2"><br><br></div>
                        </div>
                    <?php } ?>



                    <button type="submit" name="submit" value="Simpan" class="btn btn-lg btn-primary w-100 yst-login-btn border-0 mt-4 mb-4">
                        <span class="yst-login-btn-fs">Edit Program</span>
                    </button>
            </form>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Foto Program </h5>
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