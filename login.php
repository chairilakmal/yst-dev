<?php

session_start();
include 'config/connection.php';

if (isset($_POST["login"])) {

  $username = $_POST["username"];
  $password = $_POST["password"];

  $result = mysqli_query($conn, "SELECT * FROM t_user WHERE
    username = '$username'");

  //cek ketersediaan user
  if (mysqli_num_rows($result) === 1) {

    //cek password
    $row = mysqli_fetch_array($result);
    if (password_verify($password, $row["password"])) {
      //set session
      $_SESSION["id_user"] = $row["id_user"];
      $_SESSION["username"] = $row["username"];
      $_SESSION["level_user"] = $row["level_user"];

      if ($_SESSION["level_user"] == "4") {
        header("Location: pilih-donasi.php");
      } else {
        header("Location: dashboard-admin.php");
      }
    }
  }

  $error = true;
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
  <title>YST - Masuk atau Daftar</title>
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
  <div class="text-center ">
    <div class="mt-5 yst-login-box ">

      <?php if (isset($error)) : ?>
        <script>
          alert('Username / password salah !');
        </script>
        <!-- <p style="color:red; font-style:italic;">username / passwod salah</p> -->
      <?php endif; ?>

      <form action="" method="POST" class="yst-login-width ">
        <div class="kembali-konten pt-3">
          <a href="index.php" class="txt3 hov1">
            < Kembali </a>
        </div>
        <img class="mt-4 mb-4" src="img/logo-yst.png" alt="YST Logo" height="100">
        <label for="username" class="visually-hidden">Username</label>
        <input type="text" name="username" id="username" class="form-control mb-2" placeholder="Username" required autofocus>
        <label for="password" class="visually-hidden">Password</label>
        <input type="password" name="password" id="password" placeholder="Password" class="form-control mb-3">
        <div>
          <button type="submit" name="login" class="btn btn-lg btn-primary w-100 yst-login-btn border-0">
            <span class="yst-login-btn-fs">Login</span></button>
        </div>
      </form>

      <div class="text-center mt-4">
        <span class="txt1">
          Belum punya akun ?
        </span>
        <a href="register.php" class="txt2 hov1">
          Daftar Sekarang
        </a><br><br>
      </div>
      <div class="text-center">
        <a href="register-pengurus-kegiatan.php" class="txt2 hov1">
          Daftar Pengurus Kegiatan
        </a><br><br>
      </div>


    </div>
    <!-- Option 2: Separate Popper and Bootstrap JS -->

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js" integrity="sha384-SR1sx49pcuLnqZUnnPwx6FCym0wLsk5JZuNx2bPPENzswTNFaQU1RDvt3wT4gWFG" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script>

</body>

</html>