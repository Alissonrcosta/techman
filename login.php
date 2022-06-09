<?php
    session_start();
    include 'conecta.php';
    
    $senha = $_POST['senha'];
    $logar = mysqli_query($conn, "SELECT * FROM tb_usuarios where senha='$senha'");
    if(mysqli_num_rows($logar)>0){
        while($registro = $logar->fetch_array()){
        $_SESSION['senha'] = $registro['senha'];
        $_SESSION['perfil'] = $registro['perfil'];
        
        }
        include 'verifica.php';
    }
    else {
        unset($_SESSION['senha']);
        header('location:index.php');
    }
?>