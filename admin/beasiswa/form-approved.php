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

function rupiah($angka)
{
    $hasil_rupiah = "Rp. " . number_format($angka, 0, '.', '.');
    return $hasil_rupiah;
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
function queryPlafon($query)
{
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}
$plafonBeasiswa = queryPlafon("SELECT * FROM t_plafon_beasiswa
                    ORDER BY id
                    ");
$queryApproved = mysqli_query($conn, "SELECT *
                    FROM t_approval_beasiswa
                    WHERE user_id = '$_SESSION[id_user]'
                    AND beasiswa_id = $id_beasiswa");

$approved = mysqli_fetch_array($queryApproved);



$queryApproveLimit = query("SELECT *
                    FROM t_approval_beasiswa
                    WHERE beasiswa_id = $id_beasiswa
                    AND is_approve = 1");
$approveLimit = count($queryApproveLimit);

$jumlah_approval = mysqli_query($conn, "SELECT COUNT(id_approval)
                            FROM t_approval_beasiswa
                            WHERE is_approve = 1 AND beasiswa_id = $id_beasiswa");

$countApproved = mysqli_fetch_array($jumlah_approval);
$jumlah_diterima = intval($countApproved[0]);
// var_dump($jumlah_diterima);
// die;

$beasiswa = query("SELECT * FROM t_beasiswa
                        LEFT JOIN t_meninggal
                        ON t_beasiswa.user_nik = t_meninggal.nik               
                        WHERE id_beasiswa = $id_beasiswa 
                        ")[0];

// var_dump($beasiswa);
// die;

if (isset($_POST["submit"])) {

    $beasiswa_id      = $_POST["id_beasiswa"];
    $user_id          = $_POST["id_user"];
    $is_approve       = $_POST["status_beasiswa"];
    $keteranganApproval = $_POST["tb_ket_approval"];
    $approved_at       = date('Y-m-d H:i:s');
    $approved_by       = $_SESSION["nama"];


    $query = "INSERT INTO t_approval_beasiswa (beasiswa_id, user_id, is_approve, keterangan)
                VALUES ('$beasiswa_id','$user_id', '$is_approve', '$keteranganApproval')  
                     ";

    if ($jumlah_diterima > 0) {
        $queryBeasiswa = "UPDATE t_beasiswa SET
        is_approve          = 1,
        approved_at         = '$approved_at',   
        approved_by         = '$approved_by'             
        WHERE id_beasiswa   = $id_beasiswa
        ";
    }


    mysqli_query($conn, $query);
    mysqli_query($conn, $queryBeasiswa);

    // var_dump($query);
    // die;

    //cek keberhasilan
    if (mysqli_affected_rows($conn) > 0) {
        echo "
            <script>
                alert('Beasiswa berhasil di approve !');
                window.location.href = '../beasiswa'; 
            </script>
            ";
    } else {
        echo "
                <script>
                    alert('Beasiswa gagal di approve !');
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
                    <div class="form-group mt-4 mb-3" id="tgl_selesai_form">
                        <label for="tb_tgl_beasiswa" class="label-txt">Tanggal Pengajuan Beasiswa<span class="red-star">*</span></label>
                        <input type="date" id="tb_tgl_beasiswa" name="tb_tgl_beasiswa" class="form-control" value="<?= $beasiswa["tgl"]; ?>" readonly>
                    </div>
                    <div class="form-group mt-4 mb-3">
                        <label for="tb_penerima" class="label-txt">Penerima<span class="red-star">*</span></label>
                        <input type="text" id="tb_penerima" name="tb_penerima" class="form-control" placeholder="Nama penerima" value="<?= $beasiswa["nama"]; ?>" readonly>
                    </div>
                    <div class="form-group mt-4 mb-3">
                        <label for="data_anak">Data Anak<span class="red-star">*</span></label></label>
                        <div class="data-anak-container">
                            <div class="row mb-2 font-weight-bold">
                                <div class="col num-col d-flex justify-content-center">No</div>
                                <div class="col">Nama Anak</div>
                                <div class="col">Jenjang Pendidikan</div>
                                <div class="col">Nominal/6 bln</div>
                            </div>

                            <?php for ($x = 1; $x <= 3; $x++) : ?>
                                <div class="row mb-2" id="appendForm<?= $x ?>">
                                    <div class="col num-col d-flex align-items-center justify-content-center">
                                        <?= $x ?>
                                    </div>
                                    <div class="col">
                                        <input type="text" id="tb_nama_anak<?= $x ?>" name="tb_nama_anak<?= $x ?>" class="form-control" value="<?= $beasiswa["nama_anak$x"]; ?>" disabled>
                                    </div>
                                    <div class="col">
                                        <select class="form-control" id="tb_jenjang_pendidikan<?= $x ?>" name="tb_jenjang_pendidikan<?= $x ?>" onchange="handleJenjang()" disabled>
                                            <option value="">Pilih Jenjang</option>

                                            <?php foreach ($plafonBeasiswa as $row) : ?>
                                                <option value="<?= $row["jenjang"]; ?>" <?php
                                                                                        if ($row["jenjang"] == $beasiswa["jenjang_pendidikan$x"]) {
                                                                                            echo 'selected="selected"';
                                                                                        }
                                                                                        ?>>
                                                    <?= $row["jenjang"]; ?>
                                                </option>

                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col">
                                        <input type="text" id="tb_nominal<?= $x ?>" name="tb_nominal<?= $x ?>" class="form-control" value="<?= rupiah($beasiswa["nominal_$x"]); ?>" onchange="handleNominal()" disabled>
                                    </div>
                                    <div class="col"><input type="text" id="tb_nama_bank<?= $x ?>" name="tb_nama_bank<?= $x ?>" class="form-control" value="<?= $beasiswa["nama_bank$x"]; ?>" disabled></div>
                                    <div class="col"><input type="text" id="tb_noRekening<?= $x ?>" name="tb_noRekening<?= $x ?>" class="form-control" value="<?= $beasiswa["nomor_rekening$x"]; ?>" disabled></div>
                                    <!-- <div class="append-action">                        
                                    <button type="button" onclick="removeField?=$x?>()">-</button>                       
                                </div> -->
                                </div>
                            <?php endfor; ?>

                            <div class="row justify-content-end align-items-center  font-weight-bold">
                                <div class="col-auto ">Total</div>
                                <div class="col-auto ">
                                    <input type="text" id="tb_total" name="tb_total" class="input-total" value="<?= rupiah($beasiswa["total_nominal"]); ?>" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mt-4 mb-3">
                        <label for="tb_nominal" class="label-txt">Nominal<span class="red-star">*</span></label>
                        <input type="text" id="tb_nominal" name="tb_nominal" class="form-control" placeholder="Masukan Nominal beasiswa" value="<?= rupiah($beasiswa["total_nominal"]); ?>" readonly>
                    </div>


                    <div class="form-group">
                        <label for="tb_ket_beasiswa" class="label-txt">Keterangan</label>
                        <textarea readonly class="form-control" id="tb_ket_beasiswa" name="tb_ket_beasiswa" rows="6" placeholder="Keterangan"><?= $beasiswa["keterangan"]; ?></textarea>
                    </div>

                    <div class="form-group">
                        <div class="row" style="margin-left: 1px;"> <label for="suratKematian_Baru" class="label-txt"> Evidence Kematian</label>
                        </div>
                        <!-- <div class="row ml-2">
                            <img src="../../upload/<?= $beasiswa["file_surat_kematian"]; ?>" class="edit-img popup1 " data-toggle="modal" data-target="#staticBackdrop">
                        </div> -->
                        <div class="row ml-2"><?= $beasiswa["file_surat_kematian"]; ?></div>

                        <div class="row ml-2 mt-2">
                            <a href="../../upload/<?= $beasiswa["file_surat_kematian"]; ?>" target="_blank">
                                <div class="handle-file-unduh"> Lihat</div>
                            </a>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row" style="margin-left: 1px;"> <label for="fileKK_Baru" class="label-txt"> File Kartu Keluarga </label>
                        </div>
                        <!-- <div class="row ml-2">
                            <img src="../../upload/<?= $beasiswa["file_kk"]; ?>" class="edit-img popup2 " data-toggle="modal" data-target="#staticBackdrop">
                        </div> -->
                        <div class="row ml-2"><?= $beasiswa["file_kk"]; ?></div>

                        <div class="row ml-2 mt-2">
                            <a href="../../upload/<?= $beasiswa["file_kk"]; ?>" target="_blank">
                                <div class="handle-file-unduh"> Lihat</div>
                            </a>
                        </div>
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
                if ($approveLimit < 2 && $approved == NULL) {
                    echo '<button type="button" 
                    class="btn btn-lg btn-primary w-100 yst-login-btn border-0 mt-4 mb-4" 
                    data-toggle="modal" data-target="#exampleModalCenter"
                    
                    >
                        <span class="yst-login-btn-fs">Proses</span>
                    </button>';
                } ?>
                <?php include '../../component/admin/modalKeterangan.php'; ?>
            </form>
        </div>
        <div class="modal fade" id="staticBackdrop" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel"> Preview Image </h5>
                        <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> -->
                    </div>
                    <div class="modal-body">
                        <img src="" id="popup-img" alt="image" class="w-100">
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script>
        $('.popup2').click(function() {
            var src = $(this).attr('src');
            $('#popup-img').attr('src', src);
        });
        $('.popup1').click(function() {
            var src = $(this).attr('src');
            $('#popup-img').attr('src', src);
        });
    </script>

</div>
<!-- /.container-fluid -->
<!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php include '../../component/admin/footer.php'; ?>