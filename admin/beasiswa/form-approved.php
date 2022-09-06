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
$id_beasiswa = $_GET["id_beasiswa"];

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

$queryApproved = mysqli_query($conn, "SELECT *
                    FROM t_approval_beasiswa
                    WHERE user_id = '$_SESSION[id_user]'
                    AND beasiswa_id = $id_beasiswa");

$approved = mysqli_fetch_array($queryApproved);

$beasiswa = query("SELECT * FROM t_beasiswa
                        LEFT JOIN t_user
                        ON t_beasiswa.user_id = t_user.id_user               
                        WHERE id_beasiswa = $id_beasiswa 
                        ")[0];

if (isset($_POST["submit"])) {

    $beasiswa_id      = $_POST["id_beasiswa"];

    $user_id          = $_POST["id_user"];

    $is_approve       = $_POST["status_beasiswa"];


    $query = "INSERT INTO t_approval_beasiswa (beasiswa_id, user_id, is_approve)
                VALUES ('$beasiswa_id','$user_id', '$is_approve')  
                     ";



    mysqli_query($conn, $query);
    // var_dump($query);die;

    //cek keberhasilan
    if (mysqli_affected_rows($conn) > 0) {
        echo "
            <script>
                alert('Data berhasil ditambahkan!');
                window.location.href = 'index.php';
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
                <i class="nav-icon fas fa-cog mr-1"></i>Kelola Beasiswa</a> >
            <a href="form-approved.php?id_beasiswa=<?= $row["id_beasiswa"]; ?>">
                <i class="nav-icon fas fa-cog mr-1"></i>Form Approve</a>
        </div>
        <div class="form-profil">
            <div class="mt-2 regis-title">
                <h3>Form Approve</h3>
            </div>
            <form action="" enctype="multipart/form-data" method="POST">
                <input type="hidden" name="id_user" value="<?= $_SESSION["id_user"] ?>">
                <input type="hidden" name="id_beasiswa" value="<?= $beasiswa["id_beasiswa"]; ?>">
                <div class="form-group label-txt">
                    <div class="form-group mt-4 mb-3">
                        <label for="tb_penerima" class="label-txt">Penerima<span class="red-star">*</span></label>
                        <input type="text" id="tb_penerima" name="tb_penerima" class="form-control" placeholder="Nama penerima" value="<?= $beasiswa["nama"]; ?>" readonly>
                    </div>
                    <div class="form-group mt-4 mb-3" id="tgl_selesai_form">
                        <label for="tb_tgl_beasiswa" class="label-txt">Tanggal Pengajuan<span class="red-star">*</span></label>
                        <input type="date" id="tb_tgl_beasiswa" name="tb_tgl_beasiswa" class="form-control" value="<?= $beasiswa["tgl"]; ?>" readonly>
                    </div>
                    <div class="form-group mt-4 mb-3">
                        <label for="tb_nominal" class="label-txt">Nominal<span class="red-star">*</span></label>
                        <input type="number" id="tb_nominal" name="tb_nominal" class="form-control" placeholder="Masukan Nominal beasiswa" value="<?= $beasiswa["nominal"]; ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="image_uploads2" class="label-txt">Surat Tagihan Sekolah / Kampus</label><br>
                        <img src="../../img/<?= $beasiswa["file_surat_tagihan"]; ?>" class="edit-img popup " alt="Preview Image Not Available">
                    </div>
                    <div class="form-group mt-4 mb-3">
                        <label for="tb_nama_pic" class="label-txt">Nama PIC Sekolah / Kampus<span class="red-star">*</span></label>
                        <input type="text" id="tb_nama_pic" name="tb_nama_pic" class="form-control" placeholder="Nama PIC" value="<?= $beasiswa["nama_pic"]; ?>" readonly>
                    </div>
                    <div class="form-group mt-4 mb-3">
                        <label for="tb_kontak_pic" class="label-txt">Kontak PIC Sekolah / Kampus<span class="red-star">*</span></label>
                        <input type="text" id="tb_kontak_pic" name="tb_kontak_pic" class="form-control" placeholder="Kontak PIC" value="<?= $beasiswa["kontak_pic"]; ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="tb_ket_beasiswa" class="label-txt">Keterangan</label>
                        <textarea readonly class="form-control" id="tb_ket_beasiswa" name="tb_ket_beasiswa" rows="6" placeholder="Keterangan"><?= $beasiswa["keterangan"]; ?></textarea>
                    </div>
                    <div class="form-group mb-5">
                        <label for="status_program_donasi" class="font-weight-bold"><span class="label-form-span">Status Beasiswa</span></label><br>


                        <?php if ($approved != NULL) { ?>
                            <div class="radio-wrapper mt-1 bg-white">
                                <div class="form-check form-check-inline">
                                    <input type="radio" id="status_beasiswa" name="status_beasiswa" class="form-check-input" value="1" <?php if ($approved["is_approve"] == 1) echo 'checked' ?>>
                                    <label class="form-check-label" for="status_berita">Diterima</label>
                                </div>
                            </div>
                            <div class="radio-wrapper mt-1 bg-white">
                                <div class="form-check form-check-inline">
                                    <input type="radio" id="status_beasiswa" name="status_beasiswa" class="form-check-input" value="2" <?php if ($approved['is_approve'] == 2) echo 'checked' ?>>
                                    <label class="form-check-label" for="status_berita">Ditolak</label>
                                </div>
                            </div>
                        <?php } else { ?>
                            <div class="radio-wrapper mt-1 bg-white">
                                <div class="form-check form-check-inline">
                                    <input type="radio" id="status_beasiswa" name="status_beasiswa" class="form-check-input" value="1">
                                    <label class="form-check-label" for="status_berita">Diterima</label>
                                </div>
                            </div>
                            <div class="radio-wrapper mt-1 bg-white">
                                <div class="form-check form-check-inline">
                                    <input type="radio" id="status_beasiswa" name="status_beasiswa" class="form-check-input" value="2">
                                    <label class="form-check-label" for="status_berita">Ditolak</label>
                                </div>
                            </div>
                        <?php } ?>
                    </div>



                </div>
                <?php
                if ($approved == NULL) {
                    echo '<button "type="submit" name="submit" value="Simpan" class="btn btn-lg btn-primary w-100 yst-login-btn border-0 mt-4 mb-4" onclick="return confirm(`Anda yakin ingin menyimpan data ?. Setelah menyimpan, anda tidak dapat merubahnya kembali`)";>
                        <span class="yst-login-btn-fs">Simpan</span>
                    </button>';
                } ?>
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