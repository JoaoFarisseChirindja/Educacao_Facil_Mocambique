<?php

@include 'conexao.php';
require_once 'funcao.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>

  <!-- 
    - favicon
  -->
  <link rel="shortcut icon" href="./favicon.svg" type="image/svg+xml">

  <!-- 
    - custom css link
  -->
  <link rel="stylesheet" href="./assets/css/style.css">

  <!-- 
    - google font link
  -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;900&display=swap"
    rel="stylesheet">

  <!-- 
    - material icon link
  -->
  <link
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200"
    rel="stylesheet" />
    <link rel="stylesheet" href="Ionicons/css/ionicons.min.css">
    

</head>
<body>
<?php include 'header.php'; ?>
  <div class="vizualizacao">
  <?php
    $pid = $_GET['pid'];
        $show_escola = $conn->prepare("SELECT * FROM `escola` WHERE id = ? ");
        $show_escola->execute([$pid]);
        if($show_escola->rowCount() > 0){
        while($fetch_escola = $show_escola->fetch(PDO::FETCH_ASSOC)){  
    ?>
    <div class="verr">
        <h2 class="titulo"><?= $fetch_escola['nome']; ?></h2>
        <div class="perfil-escolar">
            <img src="img/<?= $fetch_escola['imagem']; ?>">
        </div>
        <div class="info-escola">
            <p class="email">Email da instituicao: <span><?= $fetch_escola['email']; ?></span></p>
            <p class="email">Numero da instituicao: <span><?= $fetch_escola['contacto']; ?></span></p>
            <div class="sobre-escola">
              <p>Nivel: <span><?= $fetch_escola['nivel']; ?></span></p>
              <p>Vagas que tem: <span><?= $fetch_escola['vagas']; ?></span></p>
            </div>
            <div class="desc">
            <?= $fetch_escola['descricao']; ?>
            </div>
        </div>
        <?php
              }
            }else{
              echo '<p class="empty">Não á escola ainda!</p>';
            }
        ?>
        
        <h3>Fotos da Escola</h3>
        <div class="wrapp-galaria">
          <div class="galeria">
          <?php
              $pid = $_GET['pid'];
              $show_fotos = $conn->prepare("SELECT * FROM `imagens` WHERE escola_id = ? ");
              $show_fotos->execute([$pid]);
              if($show_fotos->rowCount() > 0){
              while($fetch_fotos = $show_fotos->fetch(PDO::FETCH_ASSOC)){  
        ?>
            <img src="img/<?php $escola_id ?>/<?= $fetch_fotos['nome_imagem']; ?>"  >
          </div>
        
        </div>

    </div>
    <?php
         }
      }else{
         echo '<p class="empty">Não á Produtos ainda!</p>';
      }
   ?>
   
    
  </div>




  
<script>
    document.getElementById("modal_btn").onclick = function(){
    document.getElementById("modal").style.display = 'block';
}
document.getElementById("close_btn").onclick = function(){
           document.getElementById("modal").style.display = 'none';
       }
</script>
 <!-- 
    - custom js link
  -->
  <script src="./assets/js/script.js"></script>

</body>