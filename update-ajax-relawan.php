<?php

    include 'config/connection.php';


        $status_program_relawan = $_POST['status_program_relawan'];
        $id_program_relawan = $_POST['id_program_relawan'];

        // var_dump($status_program_donasi);die;
  
        $query = "UPDATE t_program_relawan
                  SET status_program_relawan='$status_program_relawan' WHERE id_program_relawan='$id_program_relawan'";
     
        mysqli_query($conn,$query);

  

?>