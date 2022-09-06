<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include('../../config/PHPMailer-master/PHPMailer-master/src/Exception.php');
include('../../config/PHPMailer-master/PHPMailer-master/src/PHPMailer.php');
include('../../config/PHPMailer-master/PHPMailer-master/src/SMTP.php');

session_start();
include '../../config/connection.php';

$level_user = $_SESSION['level_user'];

function rupiah($angka)
{
    $hasil_rupiah = "Rp. " . number_format($angka, 0, '.', '.');
    return $hasil_rupiah;
}

if (!isset($_SESSION["username"])) {
    header('Location: ../../login.php?status=restrictedaccess');
    exit;
}

if ($_SESSION["level_user"] == 4) {
    header('Location: ../../user/dashboard-donasi/dashboard-user.php');
    exit;
}

$id_donasi = $_GET["id_donasi"];
// var_dump($id_donasi);die;

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



$result = query("SELECT * FROM t_donasi WHERE id_donasi = $id_donasi")[0];

//UPDATE
if (isset($_POST["submit"])) {

    $status_donasi          = $_POST["status_donasi"];
    $nominal_donasi         = '';
    $email_penerima         = $_POST["tb_email"];
    $nama_program_donasi    = $_POST["tb_nama_program_donasi"];
    $nama_donatur           = $_POST["tb_nama_donatur"];
    $tgl_donasi             = $_POST["tb_tgl_donasi"];

    if ($status_donasi == 'Diterima') {
        $nominal_donasi = $_POST["belum_dibayar"];
    }

    $query = "UPDATE t_donasi SET
              
                    status_donasi       = '$status_donasi',
                    nominal_donasi      = '$nominal_donasi'
                  WHERE id_donasi             = $id_donasi

                ";
    // if($status_donasi = "Diterima"){
    // $nominal_donasi = $_POST["belum_dibayar"];
    // $query = "UPDATE t_donasi SET
    //         status_donasi               = '$status_donasi'
    //         nominal_donasi              = '$nominal_donasi'
    //         WHERE id_donasi             = $id_donasi
    //         ";

    // }


    mysqli_query($conn, $query);

    //cek keberhasilan
    if (mysqli_affected_rows($conn) > 0) {
        echo "
            <script>
                alert('Data berhasil diubah!');
                
            </script>
            ";

        if ($status_donasi == 'Diterima') {
            $nominal_donasi = $_POST["belum_dibayar"];

            //PHPMailer
            $email_pengirim = 'vchoze@gmail.com';
            $nama_pengirim = 'Yayasan Sekar Telkom';

            $subjek = '[Yayasan Sekar Telkom] Donasi Untuk ' . $nama_program_donasi . ' Sudah Diterima';

            $pesan = '<h2>Donasi atas nama ' . $nama_donatur . ' sejumlah ' . rupiah($nominal_donasi) . ' telah kami terima, kami ucapkan terima kasih. Semoga Anda mendapat berkah selalu dalam kehidupan.</h2>

                        <p>
                            <strong>Rincian donasi :</strong>
                        </p>
                        <table>
                            <tr>
                                <td>Tanggal pembuatan donasi</td>
                                <td>:</td>
                                <td>' . $tgl_donasi . '</td>
                            </tr>
                            <tr>
                                <td>Program pilihan</td>
                                <td>:</td>
                                <td>' . $nama_program_donasi . '</td>
                            </tr>
                            <tr>
                                <td>Donasi atas nama</td>
                                <td>:</td>
                                <td>' . $nama_donatur . '</td>
                            </tr>
                            <tr>
                                <td>Nominal donasi</td>
                                <td>:</td>
                                <td><strong>' . rupiah($nominal_donasi) . '</strong></td>
                            </tr> 
                        </table>
                        ';

            // $pesan = 'Halo '.$email_penerima.', ikut test PHPMailer ya !';

            $mail = new PHPMailer;
            $mail->isSMTP();

            $mail->Host = 'smtp.gmail.com';
            $mail->Username = $email_pengirim;
            $mail->Password = 'xzwuieypdcbmmcyp';
            $mail->Port = 465;
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = 'ssl';
            $mail->SMTPDebug = 2;

            $mail->setFrom($email_pengirim, $nama_pengirim);
            $mail->addAddress($email_penerima);
            $mail->isHTML(true);
            $mail->Subject = $subjek;
            $mail->Body = $pesan;

            $send = $mail->send();

            if ($send) {
                echo "
                <script>
                    alert('Email Terkirim !');
                    window.location.href = 'index.php'; 
                </script>
                ";
            } else {
                echo "
                <script>
                    alert('Email Gagal Terkirim !');
                    
                </script>
                ";
            }
        }
    } else {
        echo "
                <script>
                    alert('Data gagal diubah!');
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
            <a href="edit.php?id_donasi=<?= $id_donasi ?>">
                <i class=" nav-icon fas fa-plus-square mr-1"></i>Edit donasi</a>
        </div>
        <div class="form-profil halaman-view">
            <div class="mt-2 regis-title">
                <h3>ID Donasi :<?php echo $result['id_donasi'] ?></h3>
            </div>
            <form action="" enctype="multipart/form-data" method="POST">
                <div class="form-group label-txt">
                    <input type="hidden" id="tb_email" name="tb_email" class="form-control" value="<?= $result["email"]; ?>" readonly>
                    <div class="form-group mt-2 mb-2" id="tb_tgl_donasi">
                        <label for="tb_tgl_donasi" class="font-weight-bold"><span class="label-form-span">Tanggal Donasi</span></label><br>
                        <input type="date" id="tb_tgl_donasi" name="tb_tgl_donasi" class="form-control" value="<?= $result["tgl_donasi"]; ?>" readonly>
                    </div>
                    <div class="form-group mt-2 mb-2">
                        <label for="tb_nama_program_donasi" class="font-weight-bold"><span class="label-form-span">Program Donasi Pilihan</span></label><br>
                        <input type="text" id="tb_nama_program_donasi" name="tb_nama_program_donasi" class="form-control" value="<?php echo $result['nama_program_donasi'] ?>" readonly>
                    </div>
                    <div class="form-group mt-2 mb-2" id="buatNominal">
                        <label for="belum_dibayar" class="font-weight-bold"><span class="label-form-span">Nominal Donasi</span></label><br>
                        <input type="number" id="belum_dibayar" name="belum_dibayar" class="form-control" value="<?php echo $result['belum_dibayar'] ?>" readonly>
                    </div>
                    <div class="form-group mt-3 mb-2">
                        <label for="nama_donatur" class="font-weight-bold"><span class="label-form-span">Nama Donatur</span></label><br>
                        <input type="text" id="tb_nama_donatur" name="tb_nama_donatur" class="form-control" value="<?php echo $result['nama_donatur'] ?>" readonly>
                    </div>

                    <!-- Hanya muncul jika level user = 3 / super admin / approver -->
                    <?php if ($_SESSION['level_user'] == 1 || $_SESSION['level_user'] == 2) { ?>
                        <div class="form-group mb-5 ">
                            <label for="status_donasi" class="font-weight-bold"><span class="label-form-span">Status Donasi</span></label><br>
                            <div class="radio-wrapper mt-1">
                                <div class="form-check form-check-inline">
                                    <input type="radio" id="status_donasi" name="status_donasi" class="form-check-input" value="Menunggu Verifikasi" <?php if ($result['status_donasi'] == 'Menunggu Verifikasi') echo 'checked' ?>>
                                    <label class="form-check-label" for="status_donasi">Menunggu Verifikasi</label>
                                </div>
                            </div>
                            <div class="radio-wrapper2 mt-1">
                                <div class="form-check form-check-inline">
                                    <input type="radio" id="status_donasi" name="status_donasi" class="form-check-input" value="Diterima" <?php if ($result['status_donasi'] == 'Diterima') echo 'checked' ?>>
                                    <label class="form-check-label" for="status_donasi">Diterima</label>
                                </div>
                            </div>
                        </div>
                    <?php } ?>


                </div>

                <?php if ($_SESSION['level_user'] == 1 || $_SESSION['level_user'] == 2) { ?>
                    <button type="submit" name="submit" value="Simpan" class="btn btn-lg btn-primary w-100 yst-login-btn border-0 mt-4 mb-4">
                        <span class="yst-login-btn-fs">Kirim</span>
                    </button>
                <?php } ?>
            </form>
        </div>
    </main>
</div>
<!-- /.container-fluid -->
<!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php include '../../component/admin/footer.php'; ?>