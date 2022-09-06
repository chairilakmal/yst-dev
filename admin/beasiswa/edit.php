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

function upload($image_uploads)
{
    //upload gambar
    $namaFile = $_FILES[$image_uploads]['name'];
    $ukuranFile = $_FILES[$image_uploads]['size'];
    $error = $_FILES[$image_uploads]['error'];
    $tmpName = $_FILES[$image_uploads]['tmp_name'];


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

$cariNamaApprove = query("SELECT * FROM t_approval_beasiswa
                        LEFT JOIN t_user
                        ON t_approval_beasiswa.user_id = t_user.id_user 
                        WHERE is_approve = 1 AND beasiswa_id = $id_beasiswa              
                        ");

$cariNamaReject = query("SELECT * FROM t_approval_beasiswa
                        LEFT JOIN t_user
                        ON t_approval_beasiswa.user_id = t_user.id_user 
                        WHERE is_approve = 2 AND beasiswa_id = $id_beasiswa              
                        ");

$beasiswa = query("SELECT * FROM t_beasiswa
                        LEFT JOIN t_user
                        ON t_beasiswa.user_id = t_user.id_user               
                        WHERE id_beasiswa = $id_beasiswa 
                        ")[0];

$jumlah_approval = mysqli_query($conn, "SELECT COUNT(id_approval)
                            FROM t_approval_beasiswa
                            WHERE is_approve = 1 AND beasiswa_id = $id_beasiswa");

$approved = mysqli_fetch_array($jumlah_approval);
$jumlah_diterima = intval($approved[0]);

$jumlah_nonApproval = mysqli_query($conn, "SELECT COUNT(id_approval)
                        FROM t_approval_beasiswa
                        WHERE is_approve = 2 AND beasiswa_id = $id_beasiswa");

$rejected = mysqli_fetch_array($jumlah_nonApproval);
$jumlah_ditolak = intval($rejected[0]);


if (isset($_POST["submit"])) {

    $Tanggal           = $_POST["tb_tgl_beasiswa"];

    $Nominal           = $_POST["tb_nominal"];

    $Keterangan        = $_POST["tb_ket_beasiswa"];
    $Keterangan        = htmlspecialchars($Keterangan);

    $namaPIC           = $_POST["tb_nama_pic"];
    $namaPIC           = htmlspecialchars($namaPIC);

    $kontakPIC         = $_POST["tb_kontak_pic"];
    $kontakPIC         = htmlspecialchars($kontakPIC);

    $status_beasiswa   = $_POST["status_beasiswa"];

    $suratTagihan_Lama            = $_POST["suratTagihan_Lama"];

    if ($_FILES['suratTagihan_Baru']['error'] === 4) {
        $suratTagihan_Baru = $suratTagihan_Lama;
    } else {
        $suratTagihan_Baru = upload("suratTagihan_Baru");
    }

    if ($beasiswa['is_approve'] == 1) {
        $buktiTransfer_Lama  = $_POST["buktiTransfer_Lama"];
        if ($_FILES['buktiTransfer_Baru']['error'] === 4) {
            $buktiTransfer_Baru = $buktiTransfer_Lama;
        } else {
            $buktiTransfer_Baru = upload("buktiTransfer_Baru");
        }

        $query = "UPDATE t_beasiswa SET
        tgl                 = '$Tanggal',
        nominal             = '$Nominal',
        keterangan          = '$Keterangan',
        nama_pic            = '$namaPIC',
        kontak_pic          = '$kontakPIC',
        file_trf            = '$buktiTransfer_Baru',
        file_surat_tagihan  = '$suratTagihan_Baru',
        is_approve          = '$status_beasiswa' 
               
        WHERE id_beasiswa     = $id_beasiswa
        ";
    } else {
        $query = "UPDATE t_beasiswa SET
        tgl                 = '$Tanggal',
        nominal             = '$Nominal',
        keterangan          = '$Keterangan',
        nama_pic            = '$namaPIC',
        kontak_pic          = '$kontakPIC',
        file_surat_tagihan  = '$suratTagihan_Baru',
        is_approve          = '$status_beasiswa' 
               
        WHERE id_beasiswa     = $id_beasiswa
        ";
    }








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
                <i class="nav-icon fas fa-cog mr-1"></i>Edit Data Beasiswa</a>
        </div>
        <div class="form-profil">
            <div class="mt-2 regis-title">
                <h3>Edit Beasiswa</h3>
            </div>
            <form action="" enctype="multipart/form-data" method="POST">
                <input type="hidden" name="updated_by" value="<?= $_SESSION["nama"] ?>">
                <input type="hidden" name="buktiTransfer_Lama" value="<?= $beasiswa["file_trf"]; ?>">
                <input type="hidden" name="suratTagihan_Lama" value="<?= $beasiswa["file_surat_tagihan"]; ?>">
                <div class="form-group label-txt">
                    <div class="form-group mt-4 mb-3">
                        <label for="tb_penerima" class="label-txt">Penerima<span class="red-star">*</span></label>
                        <input type="text" id="tb_penerima" name="tb_penerima" class="form-control" placeholder="Nama penerima" value="<?= $beasiswa["nama"]; ?>" readonly>
                    </div>
                    <div class="form-group mt-4 mb-3" id="tgl_selesai_form">
                        <label for="tb_tgl_beasiswa" class="label-txt">Tanggal Pengajuan<span class="red-star">*</span></label>
                        <input type="date" id="tb_tgl_beasiswa" name="tb_tgl_beasiswa" class="form-control" value="<?= $beasiswa["tgl"]; ?>">
                    </div>
                    <div class="form-group mt-4 mb-3">
                        <label for="tb_nominal" class="label-txt">Nominal<span class="red-star">*</span></label>
                        <input type="number" id="tb_nominal" name="tb_nominal" class="form-control" placeholder="Masukan Nominal beasiswa" value="<?= $beasiswa["nominal"]; ?>" Required>
                    </div>
                    <div class="form-group">
                        <label for="suratTagihan_Baru" class="label-txt">Surat Tagihan Sekolah / Kampus</label>
                        <br><img src="../../img/<?= $beasiswa["file_surat_tagihan"]; ?>" class="edit-img popup mb-3" alt="Preview Image Not Available">
                        <div class="file-form">
                            <input type="file" id="suratTagihan_Baru" name="suratTagihan_Baru" class="form-control ">
                        </div>
                    </div>
                    <div class="form-group mt-4 mb-3">
                        <label for="tb_nama_pic" class="label-txt">Nama PIC Sekolah / Kampus<span class="red-star">*</span></label>
                        <input type="text" id="tb_nama_pic" name="tb_nama_pic" class="form-control" placeholder="Nama PIC" value="<?= $beasiswa["nama_pic"]; ?>">
                    </div>
                    <div class="form-group mt-4 mb-3">
                        <label for="tb_kontak_pic" class="label-txt">Kontak PIC Sekolah / Kampus<span class="red-star">*</span></label>
                        <input type="text" id="tb_kontak_pic" name="tb_kontak_pic" class="form-control" placeholder="Kontak PIC" value="<?= $beasiswa["kontak_pic"]; ?>">
                    </div>
                    <div class="form-group">
                        <label for="tb_ket_beasiswa" class="label-txt">Keterangan</label>
                        <textarea class="form-control" id="tb_ket_beasiswa" name="tb_ket_beasiswa" rows="6" placeholder="Keterangan"><?= $beasiswa["keterangan"]; ?></textarea>
                    </div>
                    <?php if ($beasiswa['is_approve'] == 1) { ?>
                        <div class="form-group">
                            <label for="buktiTransfer_Baru" class="label-txt"> Bukti Transfer</label><br>
                            <br><img src="../../img/<?= $beasiswa["file_trf"]; ?>" class="edit-img popup " alt="Preview Image Not Available">
                            <div class="file-form">
                                <br><input type="file" id="buktiTransfer_Baru" name="buktiTransfer_Baru" class="form-control ">
                            </div>
                        </div>
                    <?php } ?>
                    <div class="form-group mb-5">
                        <br><label for="Jumlah_Approve" class="font-weight-bold"><span class="label-form-span">Jumlah Approve : <?= $jumlah_diterima ?> </span></label><br>
                        <table>
                            <?php foreach ($cariNamaApprove as $row) : ?>
                                <tr>
                                    <td> - <?= $row["nama"]; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                        <br><label for="Jumlah_Reject" class="font-weight-bold"><span class="label-form-span">Jumlah Reject : <?= $jumlah_ditolak ?> </span></label><br>
                        <table>
                            <?php foreach ($cariNamaReject as $row) : ?>
                                <tr>
                                    <td> - <?= $row["nama"]; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </table>

                        <br><label for="status_program_donasi" class="font-weight-bold"><span class="label-form-span">Aksi</span></label><br>

                        <div class="radio-wrapper mt-1 bg-white">
                            <div class="form-check form-check-inline">
                                <input type="radio" id="status_beasiswa" name="status_beasiswa" class="form-check-input" value="0" <?php if ($beasiswa['is_approve'] == 0) echo 'checked' ?>>
                                <label class="form-check-label" for="status_berita">Pending</label>
                            </div>
                        </div>

                        <?php
                        if ($jumlah_diterima == 6) {
                            echo
                            '<div class="radio-wrapper mt-1 bg-white">
                                <div class="form-check form-check-inline">
                                    <input type="radio" id="status_beasiswa" name="status_beasiswa" class="form-check-input" value="1" checked>
                                <label class="form-check-label" for="status_berita">Terverifikasi</label>
                            </div>
                        </div>';
                        } else {
                            echo
                            '<div class="radio-wrapper mt-1 bg-white">
                                <div class="form-check form-check-inline">
                                    <input type="radio" id="status_beasiswa" name="status_beasiswa" class="form-check-input" value="1" disabled>
                                <label class="form-check-label" for="status_berita">Terverifikasi</label>
                            </div>
                        </div>';
                        } ?>

                    </div>
                </div>
                <button type="submit" name="submit" value="Simpan" class="btn btn-lg btn-primary w-100 yst-login-btn border-0 mt-4 mb-4">
                    <span class="yst-login-btn-fs">Simpan</span>
                </button>
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