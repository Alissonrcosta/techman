<?php
session_start();
$senha = $_SESSION['senha'];
$perfil = $_SESSION['perfil'];

?>
<!doctype html>
<html lang="pt-br">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Techman</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
  
  <link rel="stylesheet" href="css/style.css">
</head>

<body>
  <!--Navegação -->
  <div class="container">
    <nav class="navbar navbar-light  justify-content-between navega">
      <a class="navbar-brand"><img src="img/techman.png" alt="" srcset=""></a>
      <?php
        include 'conecta.php';
        $admin = mysqli_query($conn, "SELECT * FROM tb_usuarios WHERE senha = $senha and perfil = 2");
        $row = mysqli_num_rows($admin);
        if($row > 0){
            echo '<button class="btnadmin" data-bs-toggle="modal" data-bs-target="#novoEquipamento">Novo Equipamento</button>';
            
        } else {
            "";
        }
      ?>
      <div class="modal fade" id="novoEquipamento" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Cadastro de Equipamento</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="cadEquipamento.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
              <input type="text" class="form-control" placeholder="Nome do Equipamento" name="equipamento" required>
            </div>
            <div class="mb-3">
              <input type="file" class="form-control" placeholder="Selecione a imagem" name="imagem" required>
            </div>
            <div class="mb-3">
              <textarea class="form-control" rows="3" placeholder="Insira seu comentário" name="comentario"></textarea>
            </div>
            <div class="mb-3 form-check">
              <input type="checkbox" class="form-check-input" name="ativo">
              <label class="form-check-label">Ativo</label>
            </div>
            <button type="submit" class="btn btn-primary">Cadastrar</button>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        </div>
      </div>
    </div>
  </div>


      <a class="btn btn-outline-success my-2 my-sm-0 btnlogo" href="sair.php" type="submit"><img src="img/logout_sair.png" width="40px" height="40px"></a>
    </nav> 
    <!--Fim da Nav -->
    <table class="table table-hover">
    <?php
    $pesquisa = mysqli_query($conn, "SELECT * FROM tb_equipamentos");
    $row = mysqli_num_rows($pesquisa);
    if ($row > 0) {
      while ($registro = $pesquisa->fetch_array()) {
        $id_equipamento = $registro['id_equipamento'];
        $imagem = $registro['imagem'];
        echo '<tr>';
        echo '<td><img class="imgequipamentos" src="img/' . $imagem . '"/></td>';
        echo '<td><b class="novo">' . $registro['equipamento'].'</b><br><p class="descricao">'. $registro['descricao'].'</p>';
        echo '&nbsp;<br/><a href="#?id='.$id_equipamento.'" data-bs-toggle="modal" data-bs-target="#comentar'.$id_equipamento.'"><img src="img/comentario.png" width="30" height="30"></a>&nbsp;&nbsp;&nbsp;&nbsp;';
        ?>
        <div class="modal fade" id="comentar<?php echo $id_equipamento; ?>" tabindex="-1" aria-labelledby="apagar" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Comentários</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
              <div class="modal-body">
              <?php 
                  $pesquisa3 = mysqli_query($conn, "SELECT tb_comentarios.*, tb_perfis.* from tb_comentarios,tb_perfis where tb_comentarios.perfil = tb_perfis.id_perfil and tb_comentarios.equipamento = $id_equipamento");
                  $row3 = mysqli_num_rows($pesquisa3);
                  if ($row3> 0) {
                    while ($registro3 = $pesquisa3->fetch_array()) {
                      $id_comentario = $registro3['id_comentario'];
                      $date = date_create($registro3['data']);
                      $data3 = date_format($date, 'd/m/Y');
                      echo '<table>';
                      echo '<tr>';
                      echo '<td><b>' . $registro3['perfil'] . '</b></td>';
                      echo '<td>' .$data3.'</td>';
                      echo '</tr>';
                      echo '<tr>';
                      echo '<td>'.$registro3['comentario'].'</td>';
                      echo '</tr>';
                      echo '</table>';
                    }
                  }
                  else {
                    echo "Não há registros de comentários!";
                  }
                ?>
                </div>
             <div class="modal-footer">
              <button type="button" class="btn btn-success" data-bs-target="#inserircomentario<?php echo $id_equipamento; ?>" data-bs-toggle="modal" data-bs-dismiss="modal">Cadastrar Comentário</button>
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" id="inserircomentario<?php echo $id_equipamento; ?>" tabindex="-1" aria-labelledby="apagar" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Comentário</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
              <div class="modal-body">
                <?php
                  $id_equipamento = $id_equipamento;
                ?>
                <form action="cadComentario.php?id_equipamento=<?php echo $id_equipamento; ?>" method="POST">
                <textarea class="form-control" rows="3" placeholder="Insira seu comentário" name="comentario"></textarea>
              </div>
             <div class="modal-footer">
              <button type="submit" class="btn btn-success">Cadastrar</button></a>
                </form>
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            </div>
          </div>
        </div>
      </div>
      <?php
        $admin = mysqli_query($conn, "SELECT * FROM tb_usuarios WHERE senha = $senha and perfil = 2");
        $row = mysqli_num_rows($admin);
        if ($row > 0) {
          echo '<a href="#?id_equipamento='.$id_equipamento.'" data-bs-toggle="modal" data-bs-target="#apagar'.$id_equipamento.'"><img src="img/deletar.png" width="30" height="30"></a>'; ?>
          <div class="modal fade" id="apagar<?php echo $id_equipamento; ?>" tabindex="-1" aria-labelledby="apagar" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Exclusão de Equipamento</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
              <div class="modal-body">
              Atenção! Tem certeza que
deseja excluir o equipamento? Essa ação não poderá ser desfeita.
              </div>
             <div class="modal-footer">
              <a href="delEquipamento.php?id_equipamento=<?php echo $id_equipamento; ?>"><button type="button" class="btn btn-danger">Excluir</button></a>
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            </div>
          </div>
        </div>
      </div>
        <?php
        } else {
          "";
        }
        echo '</td>';
        echo '</tr>';
      }
      echo '</table>';
    } else {
      echo "Não há registros inseridos!!!";
      echo '</tbody>';
      echo '</table>';
    }
    ?>

</table>
  </div>
   
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  
</body>

</html>