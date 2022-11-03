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

    $tanggal           = $_POST["tb_tgl_beasiswa"];
    $penerima          = $_POST["tb_penerima"];

    $namaAnak1         = $_POST["tb_nama_anak1"];
    $namaAnak2         = $_POST["tb_nama_anak2"];
    $namaAnak3         = $_POST["tb_nama_anak3"];

    $jenjang1          = $_POST["tb_jenjang_pendidikan1"];
    $jenjang2          = $_POST["tb_jenjang_pendidikan2"];
    $jenjang3          = $_POST["tb_jenjang_pendidikan3"];

    $nominal1          = $_POST["tb_nominal1"] ? $_POST["tb_nominal1"] : 0 ;
    $nominal2          = $_POST["tb_nominal2"] ? $_POST["tb_nominal2"] : 0;
    $nominal3          = $_POST["tb_nominal3"] ? $_POST["tb_nominal3"] : 0;

    $totalNominal      = $_POST["tb_total_nominal"];


    $keterangan        = $_POST["tb_ket_beasiswa"];
    $keterangan        = htmlspecialchars($keterangan);

    // $formData = [$Penerima, $Tanggal, $Nominal, $Keterangan];
        
    // var_dump($formData);die;


    $query = "INSERT INTO t_beasiswa (
                tgl,
                user_id, 
                nama_anak1,
                nama_anak2,
                nama_anak3,
                jenjang_pendidikan1,
                jenjang_pendidikan2,
                jenjang_pendidikan3,
                nominal_1,
                nominal_2,
                nominal_3,
                total_nominal, 
                keterangan )
              VALUES (
                '$tanggal',
                '$penerima',
                '$namaAnak1',
                '$namaAnak2',
                '$namaAnak3',
                '$jenjang1',
                '$jenjang2',
                '$jenjang3',
                $nominal1,
                $nominal2,
                $nominal3,
                $totalNominal, 
                '$keterangan' )  
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
                        <label for="data_anak">Data Anak<span class="red-star">*</span></label></label>
                        <div class="data-anak-container">
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
                                <div class="col"><input type="text" id="tb_nama_anak<?=$x?>" name="tb_nama_anak<?=$x?>" class="form-control" ></div>
                                <div class="col">
                                <select class="form-control" id="tb_jenjang_pendidikan<?=$x?>" name="tb_jenjang_pendidikan<?=$x?>" onchange="handleJenjang()">
                                <option value="" selected >Pilih Jenjang</option>     
                                <?php foreach ($plafonBeasiswa as $row) : ?>       
                                <option value="<?= $row["jenjang"]; ?>"><?= $row["jenjang"]; ?></option>
                                <?php endforeach; ?>
                                </select>
                                </div>
                                <div class="col"><input type="number" id="tb_nominal<?=$x?>" name="tb_nominal<?=$x?>" class="form-control" onchange="handleNominal()">
                                </div>
                                <!-- <div class="append-action">                        
                                    <button type="button" onclick="removeField?=$x?>()">-</button>                       
                                </div> -->
                            </div>
                            <?php endfor; ?>
                            
                            <div class="row justify-content-end align-items-center  font-weight-bold">
                                <div class="col-auto ">Total</div>
                                <div class="col-auto ">
                                <input type="text" id="tb_total" name="tb_total" class="input-total">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mt-2 mb-3" id="tgl_selesai_form">
                        <label for="tb_total_nominal" class="label-txt">Total Nominal<span class="red-star">*</span></label>
                        <input type="number" id="tb_total_nominal" name="tb_total_nominal" class="form-control" readonly>
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

            // console.log('jen', jenjang1.value)
            
            if(jenjang1.value == 'SD / Sederajat'){
                var value1 = parseInt(600000);
            }else if(jenjang1.value == 'SMP / Sederajat'){
                var value1 = parseInt(1200000);
            }else if(jenjang1.value == 'SMA / Sederajat'){
                var value1 = parseInt(1800000);
            }else if(jenjang1.value == 'Kuliah'){
                var value1 = parseInt(2400000);
            }else{
                var value1 = parseInt(0);
            }

            if(jenjang2.value == 'SD / Sederajat'){
                var value2 = parseInt(600000);
            }else if(jenjang2.value == 'SMP / Sederajat'){
                var value2 = parseInt(1200000);
            }else if(jenjang2.value == 'SMA / Sederajat'){
                var value2 = parseInt(1800000);
            }else if(jenjang2.value == 'Kuliah'){
                var value2 = parseInt(2400000);
            }else{
                var value2 = parseInt(0);
            }

            if(jenjang3.value == 'SD / Sederajat'){
                var value3 = parseInt(600000);
            }else if(jenjang3.value == 'SMP / Sederajat'){
                var value3 = parseInt(1200000);
            }else if(jenjang3.value == 'SMA / Sederajat'){
                var value3 = parseInt(1800000);
            }else if(jenjang3.value == 'Kuliah'){
                var value3 = parseInt(2400000);
            }else{
                var value3 = parseInt(0);
            }
            
            let total1 = value1 ? value1 : 0;
            let total2 = value2 ? value2 : 0;
            let total3 = value3 ? value3 : 0;
            document.querySelector('input[name="tb_nominal1"]').value = value1;
            document.querySelector('input[name="tb_nominal2"]').value = value2;
            document.querySelector('input[name="tb_nominal3"]').value = value3;
            document.querySelector('input[name="tb_total"]').value = total1+total2+total3;  
            document.querySelector('input[name="tb_total_nominal"]').value = total1+total2+total3;  

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
            document.querySelector('input[name="tb_total_nominal"]').value = total1+total2+total3;  
            }

            // function removeField2(){
            // var element = document.getElementById("appendForm2");
            // element.classList.add("d-none");    
            // }

            // function removeField3(){
            // var element = document.getElementById("appendForm3");
            // element.classList.add("d-none");    
            // }
        </script>
    </main>
</div>
<!-- /.container-fluid -->
<!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php include '../../component/admin/footer.php'; ?>