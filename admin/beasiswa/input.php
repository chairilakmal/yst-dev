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

$selectNIK = query("SELECT * FROM t_meninggal WHERE is_approve = 'y' ");

$userQuery = query("SELECT * FROM t_meninggal
                    LEFT JOIN t_user 
                    ON t_meninggal.id_user = t_user.id_user               
                    -- GROUP BY t_meninggal.id_user 
                    ORDER BY t_meninggal.id_user DESC                
                    ");

if (isset($_POST["submit"])) {

    $Penerima          = $_POST["tb_penerima"];

    $Tanggal           = $_POST["tb_tgl_beasiswa"];

    $Nominal           = $_POST["tb_nominal"];


    $Keterangan        = $_POST["tb_ket_beasiswa"];
    $Keterangan        = htmlspecialchars($Keterangan);

    // $formData = [$Penerima, $Tanggal, $Nominal, $Keterangan];
        
    // var_dump($formData);die;


    $query = "INSERT INTO t_beasiswa (user_id, tgl, total_nominal, keterangan )
                VALUES ('$Penerima','$Tanggal', '$Nominal', '$Keterangan' )  
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
                <i class="nav-icon fas fa-cog mr-1"></i>Kelola Beasiswa</a> >
            <a href="input.php">
                <i class="nav-icon fas fa-cog mr-1"></i>Input Beasiswa</a>
        </div>
        <div class="form-profil">
            <div class="mt-2 regis-title">
                <h3>Input Beasiswa</h3>
            </div>
            <form action="" enctype="multipart/form-data" method="POST">
                <div class="form-group label-txt">
                    <div class="form-group mt-4 mb-3" id="tgl_selesai_form">
                        <label for="tb_tgl_beasiswa" class="label-txt">Tanggal Pengajuan Beasiswa<span class="red-star">*</span></label>
                        <input type="date" id="tb_tgl_beasiswa" name="tb_tgl_beasiswa" class="form-control" value="<?php echo date("Y-m-d"); ?>">
                    </div>
                    <div class="form-group mt-4 mb-3">
                        <label for="tb_kategori">Penerima<span class="red-star">*</span></label></label>
                        <select class="form-control" id="tb_penerima" name="tb_penerima" required>
                            <option value="" selected disabled>Pilih NIK</option>;
                            <?php foreach ($userQuery as $row) : ?>
                                <option value="<?= $row["id_user"]; ?>">
                                    <?php echo $row['nik']; ?> -
                                    <?php echo $row['nama'] ?>
                                </option>';
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group mt-4 mb-3">
                        <label for="tb_kategori">Data Anak<span class="red-star">*</span></label></label>
                        <div class="row mb-2 font-weight-bold">
                            <div class="col num-col d-flex justify-content-center">No</div>
                            <div class="col">Nama Anak</div>
                            <div class="col">Jenjang Pendidikan</div>
                            <div class="col">Nominal/6 bln</div>
                        </div>

                        <?php for ($x = 1; $x <= 3; $x++) : ?>
                        <div class="row mb-2" id="appendForm<?=$x?>">
                            <div class="col num-col d-flex align-items-center justify-content-center">
                            <?= $x ?>
                            </div>
                            <div class="col"><input type="text" id="tb_nama_anak<?=$x?>" name="tb_nama_anak<?=$x?>" class="form-control" placeholder="Masukan nama anak" Required></div>
                            <div class="col">
                            <select class="form-control" id="tb_jenjang_pendidikan<?=$x?>" name="tb_jenjang_pendidikan<?=$x?>" required onchange="handleJenjang()">
                                <option value="" selected disabled hidden>Jenjang Pendidikan</option>
                                <option value="600000">SD / Sederajat</option>
                                <option value="1200000">SMP / Sederajat</option>
                                <option value="1800000">SMA / Sederajat</option>
                                <option value="2400000">Kuliah</option>
                            </select>
                            </div>
                            <div class="col"><input type="number" id="tb_nominal<?=$x?>" name="tb_nominal<?=$x?>" class="form-control" Required onchange="handleNominal()"></div>
                            <div class="append-action">
                                <?php if($x > 1){?>
                                <button type="button" onclick="removeField<?=$x?>()">-</button>
                                <?php }?>
                            </div>
                        </div>
                        <?php endfor; ?>
                        
                        <div class="row justify-content-end align-items-center  font-weight-bold">
                            <div class="col-auto ">Total Nominal</div>
                            <div class="col-auto ">
                            <input type="text" id="tb_total" name="tb_total" class="input-total">
                            </div>
                        </div>
                    </div>
                    
                   
                    <div class="form-group">
                        <label for="tb_ket_beasiswa" class="label-txt">Keterangan</label>
                        <textarea class="form-control" id="tb_ket_beasiswa" name="tb_ket_beasiswa" rows="6" placeholder="Keterangan"></textarea>
                    </div>
                </div>
                <button type="submit" name="submit" value="Simpan" class="btn btn-lg btn-primary w-100 yst-login-btn border-0 mt-4 mb-4">
                    <span class="yst-login-btn-fs">Simpan</span>
                </button>
            </form>
        </div>
        <script>
            // Declare Variables
            var jenjang1 = document.getElementById("tb_jenjang_pendidikan1");
            var jenjang2 = document.getElementById("tb_jenjang_pendidikan2");
            var jenjang3 = document.getElementById("tb_jenjang_pendidikan3");
            var nominal1 = document.getElementById("tb_nominal1");
            var nominal2 = document.getElementById("tb_nominal2");
            var nominal3 = document.getElementById("tb_nominal3");
            
            function handleJenjang() {
            let value1 = parseInt(jenjang1.value);
            let value2 = parseInt(jenjang2.value);
            let value3 = parseInt(jenjang3.value);
            let total1 = value1 ? value1 : 0;
            let total2 = value2 ? value2 : 0;
            let total3 = value3 ? value3 : 0;
            document.querySelector('input[name="tb_nominal1"]').value = value1;
            document.querySelector('input[name="tb_nominal2"]').value = value2;
            document.querySelector('input[name="tb_nominal3"]').value = value3;
            document.querySelector('input[name="tb_total"]').value = total1+total2+total3;  
            }  
        
            function handleNominal(){
            let value1 = parseInt(nominal1.value);
            let value2 = parseInt(nominal2.value);
            let value3 = parseInt(nominal3.value);
            let total1 = value1 ? value1 : 0;
            let total2 = value2 ? value2 : 0;
            let total3 = value3 ? value3 : 0;
            document.querySelector('input[name="tb_nominal1"]').value = value1;
            document.querySelector('input[name="tb_nominal2"]').value = value2;
            document.querySelector('input[name="tb_nominal3"]').value = value3;
            document.querySelector('input[name="tb_total"]').value = total1+total2+total3;  
            }

            function removeField2(){
            var element = document.getElementById("appendForm2");
            element.classList.add("d-none");    
            }

            function removeField3(){
            var element = document.getElementById("appendForm3");
            element.classList.add("d-none");    
            }
        </script>
    </main>
</div>
<!-- /.container-fluid -->
<!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php include '../../component/admin/footer.php'; ?>