<?php

@include 'conexao.php';

session_start();

$user_id = $_SESSION['admin_id'];

if(!isset($user_id)){
header('location:login.php');
}

if(isset($_GET['delete'])){

    $delete_id = $_GET['delete'];
    $delete_user = $conn->prepare("DELETE FROM `usuario` WHERE id = ?");
    $delete_user->execute([$delete_id]);
    header('location:settings.php');
 
}
if(isset($_POST['Atualizar'])){

    $contacto = $_POST['contacto'];
    $contacto = filter_var($contacto, FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
 
    $atualizar_perfil = $conn->prepare("UPDATE `usuario` SET contacto = ?, email = ? WHERE id = ?");
    $atualizar_perfil->execute([$contacto, $email, $user_id]);
 
    $image = $_FILES['imagem']['name'];
    $image = filter_var($image, FILTER_SANITIZE_STRING);
    $image_size = $_FILES['imagem']['size'];
    $image_tmp_name = $_FILES['imagem']['tmp_name'];
    $image_folder = 'img/'.$image;
    $old_image = $_POST['old_image'];
 
    if(!empty($image)){
       if($image_size > 2000000){
          $message[] = 'O tamanho da imagem muito grande!';
       }else{
          $atualizar_imagem = $conn->prepare("UPDATE `usuario` SET perfil = ? WHERE id = ?");
          $atualizar_imagem->execute([$image, $user_id]);
          if($atualizar_imagem){
             move_uploaded_file($image_tmp_name, $image_folder);
             unlink('img/'.$old_image);
             $message[] = 'Imagem carregada com sucesso!';
          };
       };
    };
 
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

<button id="modal_btn" class="modalBtn"> Atualizar meus dados</button>

<div class="modal" id="modal">
    <div class="professor">
    <div class="containerF">
        <?php
            $select_perfil = $conn->prepare("SELECT * FROM `usuario` WHERE id = ?");
            $select_perfil->execute([$user_id]);
            $fetch_perfil = $select_perfil->fetch(PDO::FETCH_ASSOC);
        ?>
        <form  enctype="multipart/form-data" method="POST">
            <div class="form-content">
                <div class="login-form">
                <span id="close_btn" class="ion-android-close"></span>
                    <div class="title">Adicionar Escolas </div>
                        <div class="input-boxes">
                            <div class="input-box">
                                <i class="ion-ios-email"></i>
                                <input type="text" name="email" value="<?= $fetch_perfil['email']; ?>" placeholder="email da escola" >
                            </div> 
                            <div class="input-box">
                                <i class="ion-android-call"></i>
                                <input type="text" name="contacto" value="<?= $fetch_perfil['contacto']; ?>" placeholder="contacto da escola">
                            </div>
                            <div class="input-box">
                                <i class="ion-android-image"></i>
                                <input type="file" name="imagem" accept="image/jpg, image/jpeg, image/png" placeholder="imagem da escola" >
                                <input type="hidden" name="old_image" value="<?= $fetch_perfil['perfil']; ?>">
                            </div>
                            <div class="input-box">
                            <input type="hidden" name="old_pass" value="<?= $fetch_perfil['password']; ?>">
                              <i class="ion-ios-locked"></i>
                              <input type="password" name="update_pass" placeholder="Seu antigo password" required>
                            </div>
                            <div class="input-box">
                              <i class="ion-ios-locked"></i>
                              <input type="password" name="new_pass" placeholder="Seu novo password" required>
                            </div>

                            
                            <div class=" button input-box">
                                <input type="submit" name="Atualizar" value="Atualizar">
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
        $select_user = $conn->prepare("SELECT * FROM `usuario`");
        $select_user->execute();
        while($fetch_user = $select_user->fetch(PDO::FETCH_ASSOC)){
    ?>
  <div class="card" >
    <div class="numero"><?= $fetch_user['contacto']; ?></div>
    <div class="perfil-pessoal">
      <img src="img/<?= $fetch_user['perfil']; ?>">
    </div>
    <div class="detalhes">
      <span class="disciplina"><?= $fetch_user['morada']; ?></span>
      <h4><?= $fetch_user['nome']; ?></h4>
      <div class="info-pessoal">
        <div class="email-pessoal"><?= $fetch_user['email']; ?></div>
        <div class="sobre-mim">
          <a href="settings.php?delete=<?= $fetch_user['id']; ?>" onclick="return confirm('Eliminar o usuário?');"><i class="ion-ios-trash"></i></a>
        </div>
      </div>  
    </div>
  </div>
  <?php
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
</html>