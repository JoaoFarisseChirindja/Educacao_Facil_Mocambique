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


    <div class="escola">
    <div class="containerF">
        <?php
            $update_id = $_GET['update'];
            $select_escola = $conn->prepare("SELECT * FROM `escola` WHERE id = ?");
            $select_escola->execute([$update_id]);
            if($select_escola->rowCount() > 0){
            while($fetch_escola = $select_escola->fetch(PDO::FETCH_ASSOC)){ 
        ?>
        <form  enctype="multipart/form-data" method="POST">
            <div class="form-content">
                <div class="login-form">
                <span id="close_btn" class="ion-android-close"></span>
                    <div class="title">Adicionar Escolas </div>
                        <div class="input-boxes">
                            <div class="input-box">
                                <i class="ion-android-contact"></i>
                                <input type="text" name="nome" value="<?= $fetch_escola['nome']; ?>" placeholder="nome da escola">
                            </div>
                            <div class="input-boxe">
                                <i class="ion-transgender"></i>
                                <div class="lb">
                                  <select name="nivel">
                                    <option selected><?= $fetch_escola['nivel']; ?></option>
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
                                <input type="text" name="email" value="<?= $fetch_escola['email']; ?>" placeholder="email da escola" >
                            </div> 
                            <div class="input-box">
                                <i class="ion-android-call"></i>
                                <input type="text" name="contacto" value="<?= $fetch_escola['contacto']; ?>" placeholder="contacto da escola">
                            </div>
                            <div class="input-box">
                                <i class="ion-android-image"></i>
                                <input type="file" name="imagem" accept="image/jpg, image/jpeg, image/png, image/webp" placeholder="imagem da escola" >
                            </div>
                            <div class="input-box">
                              <i class="ion-map"></i>
                              <input type="text" name="endereco" value="<?= $fetch_escola['email']; ?>" placeholder="endereco da escola" >
                            </div>
                            <div class="input-box">
                                <i class="ion-android-pin"></i>
                                <input type="text" name="longitude" value="<?= $fetch_escola['longitude']; ?>" placeholder="longitude" >
                                <input type="text" name="latitude" value="<?= $fetch_escola['latitude']; ?>" placeholder="latitude" >  
                            </div>
                            <div class="input-box">
                                <i class="ion-android-document"></i>
                                <input type="text" name="descricao" value="<?= $fetch_escola['descricao']; ?>"  placeholder="sua descricao" >
                            </div>
                            <div class="input-box">
                                <i class="ion-android-clipboard"></i>
                                <input type="number" name="vagas" value="<?= $fetch_escola['vagas']; ?>" placeholder="vagas" >
                            </div>
                            <div class="input-box">
                              <i class="ion-ios-basketball"></i>
                              <input type="text" name="atividades" value="<?= $fetch_escola['atividades']; ?>" placeholder="atividades" >
                            </div>
                            <?php
                                }
                                }else{
                                 echo '<p class="empty">Não á escola ainda!</p>';
                                }
                            ?>
                            <div class="input-box">
                            <?php
                                $update_id = $_GET['update'];
                                $select_imagens = $conn->prepare("SELECT * FROM `imagens` WHERE id = ?");
                                $select_imagens->execute([$update_id]);
                                if($select_imagens->rowCount() > 0){
                                while($fetch_escola = $select_imagens->fetch(PDO::FETCH_ASSOC)){ 
                            ?>
                              <i class="ion-images"></i>
                              <input type="file" name="fotos[]" accept="image/jpg, image/jpeg, image/png" multiple placeholder="imagem da escola" >
                            </div>
                            <?php
                            }
                            }
                            ?>
                            <div class=" button input-box">
                                <input type="submit" name="Atualizar_Escola" value="Atualizar">
                                <a href="escola.php" class="btn btn-danger">Voltar</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    </div>



</body>
</html>