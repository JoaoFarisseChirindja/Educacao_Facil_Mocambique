<?php

@include 'conexao.php';
require_once 'funcao.php';



$user_id = $_SESSION['admin_id'];

if(!isset($user_id)){
header('location:login.php');
}
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
<button id="modal_btn" class="modalBtn"> Adicionar Escolas</button>

<div class="modal" id="modal">
    <div class="escola">
    <div class="containerF">
        <form  enctype="multipart/form-data" method="POST">
            <div class="form-content">
                <div class="login-form">
                <span id="close_btn" class="ion-android-close"></span>
                    <div class="title">Adicionar Escolas </div>
                        <div class="input-boxes">
                            <div class="input-box">
                                <i class="ion-android-contact"></i>
                                <input type="text" name="nome" value="" placeholder="nome da escola">
                            </div>
                            <div class="input-boxe">
                                <i class="ion-transgender"></i>
                                <div class="lb">
                                  <select name="nivel">
                                    <option value="" selected disabled>Selecionar o nivel da escola</option>
                                    <option value="pre-primario">pre-primario</option>
                                    <option value="primario">primario</option>
                                    <option value="secundario">secundario</option>
                                    <option value="Medio">Medio</option>
                                    <option value="superior">superior</option>
                                </select>
                                </div>
                            </div>
                            <div class="input-box">
                                <i class="ion-ios-email"></i>
                                <input type="text" name="email" value="" placeholder="email da escola" >
                            </div> 
                            <div class="input-box">
                                <i class="ion-android-call"></i>
                                <input type="text" name="contacto" value="" placeholder="contacto da escola">
                            </div>
                            <div class="input-box">
                                <i class="ion-android-image"></i>
                                <input type="file" name="imagem" accept="image/jpg, image/jpeg, image/png" placeholder="imagem da escola" >
                            </div>
                            <div class="input-box">
                              <i class="ion-map"></i>
                              <input type="text" name="endereco" placeholder="endereco da escola" >
                            </div>
                            <div class="input-box">
                                <i class="ion-android-pin"></i>
                                <input type="text" name="longitude" placeholder="longitude" >
                                <input type="text" name="latitude" placeholder="latitude" >  
                            </div>
                            <div class="input-box">
                                <i class="ion-android-document"></i>
                                <input type="text" name="descricao" placeholder="sua descricao" >
                            </div>
                            <div class="input-box">
                                <i class="ion-android-clipboard"></i>
                                <input type="number" name="vagas" placeholder="vagas" >
                            </div>
                            <div class="input-box">
                              <i class="ion-ios-basketball"></i>
                              <input type="text" name="atividades" placeholder="atividades" >
                            </div>
                            <div class="input-box">
                              <i class="ion-images"></i>
                              <input type="file" name="fotos[]" accept="image/jpg, image/jpeg, image/png" multiple placeholder="imagem da escola" >
                            </div>

                            <div class=" button input-box">
                                <input type="submit" name="adicionar" value="adicionar">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    </div>
</div>

<div class="cards">
    <?php
        $show_escola = $conn->prepare("SELECT * FROM `escola` ORDER BY id DESC LIMIT 12");
        $show_escola->execute();
        if($show_escola->rowCount() > 0){
        while($fetch_escola = $show_escola->fetch(PDO::FETCH_ASSOC)){  
    ?>
  <div class="card">
    <div class="numero"><?= $fetch_escola['contacto']; ?></div>
    <div class="ver"><a href="ver.php?pid=<?= $fetch_escola['id']; ?>"><i class="ion-ios-eye-outline"></i></a></div>
    <div class="perfil-pessoal">
      <img src="img/<?= $fetch_escola['imagem']; ?>">
    </div>
    <div class="detalhes">
      <span class="nivel"><?= $fetch_escola['nivel']; ?></span>
      <h4><?= $fetch_escola['nome']; ?></h4>
      <p><?= $fetch_escola['descricao']; ?></p>
      <div class="info-pessoal">
        <div class="email-pessoal"><?= $fetch_escola['email']; ?></div>
        <div class="sobre-mim">
          <a href="atualizar.php?update=<?= $fetch_escola['id']; ?>"> <i class="ion-ios-compose"></i></a>
          <a href="escola.php?delete=<?= $fetch_escola['id']; ?>" onclick="return confirm('Eliminar a scola?');"><i class="ion-ios-trash"></i></a>
        </div>
      </div>  
    </div>
  </div>
  <?php
        }
     }else{
            echo '<p class="empty">Não há escola adicionado ainda!</p>';
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