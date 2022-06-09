<?php
   include 'conecta.php';
   $id_equipamento = $_GET['id_equipamento'];
   $sql = "DELETE FROM tb_equipamentos WHERE id_equipamento = $id_equipamento";
   if(mysqli_query($conn,$sql)){
    header("location:dash.php");
     }
?>