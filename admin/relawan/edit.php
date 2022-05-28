<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include('../../config/PHPMailer-master/PHPMailer-master/src/Exception.php');
include('../../config/PHPMailer-master/PHPMailer-master/src/PHPMailer.php');
include('../../config/PHPMailer-master/PHPMailer-master/src/SMTP.php');

session_start();
include '../../config/connection.php';



if (!isset($_SESSION["username"])) {
    header('Location: login.php?status=restrictedaccess');
    exit;
}

$id_relawan = $_GET["id_relawan"];
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


$result = query("SELECT * FROM t_relawan
                      LEFT JOIN t_program_relawan ON t_relawan.id_program_relawan = t_program_relawan.id_program_relawan
                      WHERE id_relawan = $id_relawan ")[0];
// $result = query("SELECT * FROM t_relawan WHERE id_relawan = $id_relawan")[0];

//UPDATE
if (isset($_POST["submit"])) {

    $status_relawan      = $_POST["status_relawan"];
    // var_dump($status_relawan);die;
    $relawan_jadi        = '';
    $email_penerima      = $_POST["tb_email"];
    $nama_donatur        = $_POST["tb_nama_lengkap"];
    $nama_program_relawan  = $_POST["tb_nama_program_relawan"];
    $tgl_pelaksanaan        = $_POST["tb_tgl_pelaksanaan"];
    $lokasi                 = $_POST["tb_lokasi_program"];
    $titik_kumpul                 = $_POST["tb_lokasi_awal"];

    if ($status_relawan == "Diterima") {
        $relawan_jadi = 1;
    }

    $query = "UPDATE t_relawan SET
                    status_relawan      = '$status_relawan',
                    relawan_jadi        = '$relawan_jadi'
                  WHERE id_relawan      = $id_relawan

                ";


    mysqli_query($conn, $query);

    if (mysqli_affected_rows($conn) > 0) {
        echo "
            <script>
                alert('Data berhasil diubah!');
                
            </script>
            ";

        if ($status_relawan == 'Diterima') {

            //PHPMailer
            $email_pengirim = 'vchoze@gmail.com';
            $nama_pengirim = 'Yayasan Sekar Telkom';

            $subjek = '[Yayasan Sekar Telkom] Pendaftaran Anda sebagai relawan telah disetujui';

            $pesan = '<h2>Halo ' . $nama_donatur . ' kami telah menyetujui pendaftaran relawan Anda.</h2>

                        <p>
                            <strong>Rincian program relawan :</strong>
                        </p>
                        <table>
                            <tr>
                                <td>Nama Program</td>
                                <td>:</td>
                                <td>' . $nama_program_relawan . '</td>
                            </tr>
                            <tr>
                                <td>Tanggal pelaksanaan</td>
                                <td>:</td>
                                <td>' . $tgl_pelaksanaan . '</td>
                            </tr>
                            <tr>
                                <td>Lokasi pelaksanaan</td>
                                <td>:</td>
                                <td>' . $lokasi . '</td>
                            </tr>
                            <tr>
                                <td>Titik kumpul</td>
                                <td>:</td>
                                <td>' . $titik_kumpul . '</td>
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
                    window.location.href = 'kelola-relawan.php'; 
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
        <div class="request-data">
            <div class="projects">
                <div class="page-title-link ml-4 mb-4">
                    <a href="dashboard-admin.php">
                        <i class="nav-icon fas fa-home mr-1"></i>Dashboard admin</a> >
                    <a href="kelola-relawan.php">
                        <i class="nav-icon fas fa-user-cog mr-1"></i>Kelola relawan</a>
                </div>

                <div class="form-profil halaman-view">
                    <div class="mt-2 regis-title">
                        <h3>Kelola Relawan</h3>
                    </div>
                    <form action="" enctype="multipart/form-data" method="POST">
                        <div class="form-group label-txt">
                            <input type="hidden" id="tb_relawan_pending" name="tb_relawan_pending" class="form-control" value="1">
                            <div class="form-group mt-4 mb-2">
                                <label for="tb_nama_program_relawan" class="font-weight-bold"><span class="label-form-span">Program Pilihan</span></label><br>
                                <input type="text" id="tb_nama_program_relawan" name="tb_nama_program_relawan" class="form-control" value="<?php echo $result['nama_program_relawan'] ?>" readonly>
                            </div>
                            <div class="form-group mt-4 mb-3">
                                <label for="tb_tgl_pelaksanaan" class="font-weight-bold"><span class="label-form-span">Tanggal Pelaksanaan</span></label><br>
                                <input type="date" id="tb_tgl_pelaksanaan" name="tb_tgl_pelaksanaan" class="form-control" value="<?= $result["tgl_pelaksanaan"]; ?>" readonly>
                            </div>
                            <div class="form-group mt-4 mb-2">
                                <label for="tb_lokasi_program" class="font-weight-bold"><span class="label-form-span">Lokasi Pelaksanaan</span></label><br>
                                <input type="text" id="tb_lokasi_program" name="tb_lokasi_program" class="form-control" value="<?php echo $result['lokasi_program'] ?>" readonly>
                            </div>
                            <div class="form-group mt-4 mb-2">
                                <label for="tb_lokasi_awal" class="font-weight-bold"><span class="label-form-span">Titik Kumpul</span></label><br>
                                <input type="text" id="tb_lokasi_awal" name="tb_lokasi_awal" class="form-control" value="<?php echo $result['lokasi_awal'] ?>" readonly>
                            </div>
                            <div class="form-group mt-4 mb-2">
                                <label for="tb_nama_lengkap" class="font-weight-bold"><span class="label-form-span">Nama Relawan</span></label><br>
                                <input type="text" id="tb_nama_lengkap" name="tb_nama_lengkap" class="form-control" value="<?php echo $result['nama_lengkap'] ?>" readonly>
                            </div>
                            <div class="form-group mt-4 mb-2">
                                <label for="tb_no_hp" class="font-weight-bold"><span class="label-form-span">Nomor Telepon</span></label><br>
                                <input type="text" id="tb_no_hp" name="tb_no_hp" class="form-control" value="<?php echo $result['no_hp'] ?>" readonly>
                            </div>
                            <div class="form-group mt-4 mb-2">
                                <label for="tb_email" class="font-weight-bold"><span class="label-form-span">Email</span></label><br>
                                <input type="text" id="tb_email" name="tb_email" class="form-control" value="<?php echo $result['email'] ?>" readonly>
                            </div>
                            <div class="form-group mt-4 mb-2">
                                <label for="tb_domisili" class="font-weight-bold"><span class="label-form-span">Domisili</span></label><br>
                                <input type="text" id="tb_domisili" name="tb_domisili" class="form-control" value="<?php echo $result['domisili'] ?>" readonly>
                            </div>
                            <div class="form-group mb-5 ">
                                <label for="status_relawan" class="font-weight-bold"><span class="label-form-span">Status Relawan</span></label><br>
                                <div class="radio-wrapper mt-1">
                                    <div class="form-check form-check-inline">
                                        <input type="radio" id="status_relawan" name="status_relawan" class="form-check-input" value="Menunggu Seleksi" <?php if ($result['status_relawan'] == 'Menunggu Seleksi') echo 'checked' ?>>
                                        <label class="form-check-label" for="status_relawan">Menunggu Seleksi</label>
                                    </div>
                                </div>
                                <div class="radio-wrapper mt-1">
                                    <div class="form-check form-check-inline">
                                        <input type="radio" id="status_relawan" name="status_relawan" class="form-check-input" value="Diterima" <?php if ($result['status_relawan'] == 'Diterima') echo 'checked' ?>>
                                        <label class="form-check-label" for="status_relawan">Diterima</label>
                                    </div>
                                </div>
                                <div class="radio-wrapper2 ml-2 mt-1">
                                    <div class="form-check form-check-inline">
                                        <input type="radio" id="status_relawan" name="status_relawan" class="form-check-input" value="Ditolak" <?php if ($result['status_relawan'] == 'Ditolak') echo 'checked' ?>>
                                        <label class="form-check-label" for="status_relawan">Ditolak</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="submit" name="submit" value="Simpan" class="btn btn-lg btn-primary w-100 yst-login-btn border-0 mt-4 mb-4" onclick="handleSubmit()">
                            <span class="yst-login-btn-fs">Edit</span>
                        </button>
                    </form>
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