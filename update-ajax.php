<?php

    include 'config/connection.php';


        $status_program_donasi = $_POST['status_program_donasi'];
        $id_program_donasi = $_POST['id_program_donasi'];

        // var_dump($status_program_donasi);die;
  
        $query = "UPDATE t_program_donasi
                  SET status_program_donasi='$status_program_donasi' WHERE id_program_donasi='$id_program_donasi'";
     
        mysqli_query($conn,$query);

  

?>