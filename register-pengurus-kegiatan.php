<?php include 'config/connection.php';

if (isset($_POST["register"])) {

    $nama_lengkap = $_POST['tb_nama_user'];
    $no_hp = $_POST['num_nomer_hp'];
    $email = $_POST['tb_email'];
    $jenis_kelamin = $_POST['rb_jenis_kelamin'];
    $username = $_POST['tb_username'];
    $username = strtolower($username);
    $password = $_POST['pwd'];
    $level_user = 3;


    //enkripsi password
    $password = password_hash($password, PASSWORD_DEFAULT);

    //insert ke db
    $sql = "INSERT INTO t_user (nama_lengkap,no_hp,email,jenis_kelamin,username,password,level_user)
        VALUES ('$nama_lengkap','$no_hp','$email','$jenis_kelamin','$username','$password','$level_user')";



    mysqli_query($conn, $sql);


    if ($_POST > 0) {
        echo "<script>
                    alert('Registrasi Berhasil !');
                </script>";
    } else {
        echo mysqli_error($conn);
    }
}


?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width , initial-scale=1">
    <!-- Icon Title -->
    <link rel="icon" href="img/logo-only.svg">
    <title>YST - Daftar Akun Pengurus Kegiatan</title>
    <!-- Local CSS -->
    <link rel="stylesheet" href="css/login.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@600&family=Roboto:wght@500&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@600&display=swap" rel="stylesheet">
</head>

<body>
    <div>
        <div class="mt-4 yst-regis-box ">
            <div class="yst-regis-width">
                <div class="mt-3"> <a href="login.php" class="txt2">
                        < Kembali </a>
                </div>
                <div class="mt-4 regis-title">
                    <h3>Daftar Pengurus Kegiatan</h3>
                </div>
                <form action="" enctype="multipart/form-data" method="POST">
                    <div class="form-group">
                        <div class="form-group mt-4 mb-2">
                            <input type="text" id="tb_nama_user" name="tb_nama_user" class="form-control" placeholder="Nama lengkap">
                        </div>
                        <div class="form-group mb-2">
                            <input type="number" id="num_nomer_hp" name="num_nomer_hp" class="form-control" placeholder="Nomor telepon">
                        </div>
                        <div class="form-group mb-2">
                            <input type="text" id="tb_email" name="tb_email" class="form-control" placeholder="Email">
                        </div>
                        <div class="form-group mb-2">
                            <input type="text" id="tb_username" name="tb_username" class="form-control" placeholder="Username login">
                        </div>
                        <div class="form-group mb-2">
                            <input type="password" id="pwd" name="pwd" class="form-control" placeholder="Kata sandi baru">
                        </div>
                        <!-- <div class="form-group mb-2">
                            <input type="password" id="pwd2" name="pwd2" class="form-control" placeholder="Konfirmasi kata sandi">
                        </div> -->
                        <div class="form-group mb-5 ">
                            <label for="rb_jenis_kelamin" class="font-weight-bold"><span class="label-form-span">Jenis Kelamin</span></label><br>
                            <div class="radio-wrapper mt-1">
                                <div class="form-check form-check-inline">
                                    <input type="radio" id="rb_jenis_kelamin_pria" name="rb_jenis_kelamin" value="pria" class="form-check-input" checked>
                                    <label class="form-check-label" for="rb_jenis_kelamin_pria">Pria</label>
                                </div>
                            </div>
                            <div class="radio-wrapper2 mt-1">
                                <div class="form-check form-check-inline">
                                    <input type="radio" id="rb_jenis_kelamin_wanita" name="rb_jenis_kelamin" value="wanita" class="form-check-input">
                                    <label class="form-check-label" for="rb_jenis_kelamin_wanita">Wanita</label>
                                </div>
                            </div>
                        </div>

                    </div>
                    <button type="submit" name="register" class="btn btn-lg btn-primary w-100 yst-login-btn border-0 mt-4 mb-5">
                        <span class="yst-login-btn-fs">Daftar</span></button>
                </form>
            </div>
        </div>


    </div>
    <!-- Option 2: Separate Popper and Bootstrap JS -->

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js" integrity="sha384-SR1sx49pcuLnqZUnnPwx6FCym0wLsk5JZuNx2bPPENzswTNFaQU1RDvt3wT4gWFG" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script>

</body>

</html>