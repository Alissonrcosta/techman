<?php
    session_start();
    $senha = $_SESSION['senha'];
    $perfil = $_SESSION['perfil'];
    include 'conecta.php';
    $pesquisa = mysqli_query($conn, "SELECT * FROM tb_usuarios where senha = '$senha' and perfil = 2");
                    $row = mysqli_num_rows($pesquisa);
                    if($row > 0){
                        header('location:dash.php');
                    } else {
                        header('location:dash.php');
                    }
?>