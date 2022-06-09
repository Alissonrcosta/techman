<?php
    session_start();
    $id_equipamento = $_GET['id_equipamento'];
    $comentario = $_POST['comentario'];
    $senha = $_SESSION['senha'];
    include 'conecta.php';
    $perfil = mysqli_query($conn,"SELECT * FROM tb_usuarios WHERE senha = '$senha'");
    $row = mysqli_num_rows($perfil);
    if ($row > 0) {
      while ($registro = $perfil->fetch_array()) {
          $percorre = $registro['perfil'];
      }
    }
    $query = "INSERT INTO tb_comentarios(comentario,equipamento,perfil,data) values('".$comentario."','".$id_equipamento."','".$percorre."',NOW())";
    mysqli_query($conn,$query);
    header('Location: dash.php');
?>