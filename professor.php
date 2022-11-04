<?php

@include 'conexao.php';

session_start();

$user_id = $_SESSION['admin_id'];

if(!isset($user_id)){
header('location:login.php');
}


if(isset($_POST['adicionar'])){

    $nome = $_POST['nome'];
    $nome = filter_var($nome, FILTER_SANITIZE_STRING);
    $genero = $_POST['genero'];
    $genero = filter_var($genero, FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $contacto = $_POST['contacto'];
    $contacto = filter_var($contacto, FILTER_SANITIZE_STRING);
    $localizacao = $_POST['localizacao'];
    $localizacao = filter_var($localizacao, FILTER_SANITIZE_STRING);
    $descricao = $_POST['descricao'];
    $descricao = filter_var($descricao, FILTER_SANITIZE_STRING);
    $disciplina = $_POST['disciplina'];
    $disciplina = filter_var($disciplina, FILTER_SANITIZE_STRING);
 
    $imagem = $_FILES['imagem']['name'];
    $imagem = filter_var($imagem, FILTER_SANITIZE_STRING);
    $image_size = $_FILES['imagem']['size'];
    $image_tmp_name = $_FILES['imagem']['tmp_name'];
    $image_folder = 'img/'.$imagem;
 
    $select_professor = $conn->prepare("SELECT * FROM `professores` WHERE nome = ?");
    $select_professor->execute([$nome]);
 
    if($select_professor->rowCount() > 0){
       $message[] = 'O nome do professor já existe!';
    }else{
 
       $insert_professor = $conn->prepare("INSERT INTO `professores`(nome, sexo, email, contacto, imagem, localizacao, descricao, disciplina) VALUES(?,?,?,?,?,?,?,?)");
       $insert_professor->execute([$nome, $genero, $email, $contacto, $imagem, $localizacao, $descricao, $disciplina]);
 
       if($insert_professor){
          if($image_size > 20000000){
             $message[] = 'Tamanho da imagem muito grande!';
          }else{
             move_uploaded_file($image_tmp_name, $image_folder);
             $message[] = 'Novo professor adicionado!';
          }
 
       }
 
    }
 
};

if(isset($_GET['delete'])){

  $delete_id = $_GET['delete'];
  $select_delete_image = $conn->prepare("SELECT imagem FROM `professores` WHERE id = ?");
  $select_delete_image->execute([$delete_id]);
  $fetch_delete_image = $select_delete_image->fetch(PDO::FETCH_ASSOC);
  unlink('img/'.$fetch_delete_image['imagem']);
  $delete_escola = $conn->prepare("DELETE FROM `professores` WHERE id = ?");
  $delete_escola->execute([$delete_id]);
  header('location:professor.php');

 }


?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Painel de Controle </title>

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
<button id="modal_btn" class="modalBtn"> Adicionar Professores</button>

<div class="modal" id="modal">
    <div class="professor">
    <div class="containerF">
        <form  enctype="multipart/form-data" method="POST">
            <div class="form-content">
                <div class="login-form">
                <span id="close_btn" class="ion-android-close"></span>
                    <div class="title">Adicionar Professor </div>
                        <div class="input-boxes">
                            <div class="input-box">
                                <i class="ion-android-contact"></i>
                                <input type="text" name="nome" value="" placeholder="Seu nome">
                            </div>
                            <div class="input-boxe">
                                <i class="ion-transgender"></i>
                                <div class="lb">
                                    <select name="genero">
                                        <option value="" selected disabled>Slelecionar seu genero</option>
                                        <option value="Masculino">Masculino</option>
                                        <option value="Feminino">Masculino</option>
                                    </select>
                                </div>
                            </div>
                            <div class="input-box">
                                <i class="ion-ios-email"></i>
                                <input type="text" name="email" value="" placeholder="Seu email" >
                            </div>
                            <div class="input-box">
                                <i class="ion-android-call"></i>
                                <input type="text" name="contacto" value="" placeholder="Seu numero">
                            </div>              
                            <div class="input-box">
                                <i class="ion-android-camera"></i>
                                <input type="file" name="imagem" accept="image/jpg, image/jpeg, image/png" placeholder="sua imagem" >
                            </div>
                            <div class="input-box">
                                <i class="ion-android-pin"></i>
                                <input type="text" name="localizacao" placeholder="sua localizacao" >
                            </div>
                            <div class="input-box">
                                <i class="ion-android-document"></i>
                                <input type="text" name="descricao" placeholder="sua descricao" >
                            </div>
                            <div class="input-box">
                                <i class="ion-android-create"></i>
                                <input type="text" name="disciplina" placeholder="sua disciplinas" >
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
        $show_professor = $conn->prepare("SELECT * FROM `professores` ORDER BY id DESC LIMIT 12");
        $show_professor->execute();
        if($show_professor->rowCount() > 0){
        while($fetch_professor = $show_professor->fetch(PDO::FETCH_ASSOC)){  
     ?>
  <div class="card">
    <div class="numero"><?= $fetch_professor['contacto']; ?></div>
    <div class="perfil-pessoal">
      <img src="img/<?= $fetch_professor['imagem']; ?>">
    </div>
    <div class="detalhes">
      <span class="disciplina"> <?= $fetch_professor['disciplina']; ?></span>
      <h4><?= $fetch_professor['nome']; ?></h4>
      <p><?= $fetch_professor['descricao']; ?> </p>
      <div class="info-pessoal">
        <div class="email-pessoal"><?= $fetch_professor['email']; ?></div>
        <div class="sobre-mim">
          <p><?= $fetch_professor['localizacao']; ?></p>
          <p><?= $fetch_professor['sexo']; ?></p>
          <a href="professor.php?delete=<?= $fetch_professor['id']; ?>" onclick="return confirm('Eliminar o professor?');"><i class="ion-ios-trash"></i></a>
        </div>
      </div>  
    </div>
  </div>
    <?php
        }
     }else{
            echo '<p class="empty">Não há professor adicionado ainda!</p>';
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
