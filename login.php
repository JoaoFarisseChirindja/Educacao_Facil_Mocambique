<?php

   @include 'conexao.php';

   session_start();

   if(isset($_POST['submit'])){

      $email = $_POST['email'];
      $email = filter_var($email, FILTER_SANITIZE_STRING);
      $pass = md5($_POST['pass']);
      $pass = filter_var($pass, FILTER_SANITIZE_STRING);

      $sql = "SELECT * FROM `usuario` WHERE email = ? AND password = ?";
      $stmt = $conn->prepare($sql);
      $stmt->execute([$email, $pass]);
      $rowCount = $stmt->rowCount();  

      $row = $stmt->fetch(PDO::FETCH_ASSOC);

      if($rowCount > 0){

         if($row['tipo_usuario'] == 'admin'){

            $_SESSION['admin_id'] = $row['id'];
            header('location:painel.php');

         }elseif($row['tipo_usuario'] == 'user'){

            $_SESSION['user_id'] = $row['id'];
            header('location:home.html');

         }else{
            $message[] = 'Usuario não encontrado!';
         }

      }else{
         $message[] = 'Email ou password incorrecto!';
      }

 

   }
   if(isset($_POST['Registrar'])){

    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $name = $_POST['nome'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $pass = md5($_POST['pass']);
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);
    $cpass = md5($_POST['cpass']);
    $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);
    $tipo= "user";

    $image = $_FILES['imagem']['name'];
    $image = filter_var($image, FILTER_SANITIZE_STRING);
    $image_size = $_FILES['imagem']['size'];
    $image_tmp_name = $_FILES['imagem']['tmp_name'];
    $image_folder = 'img/'.$image;

    $select = $conn->prepare("SELECT * FROM `usuario` WHERE email = ?");
    $select->execute([$email]);
 
    if($select->rowCount() > 0){
       $message[] = 'O Email do usuario já existe!';
    }else{
       if($pass != $cpass){
          $mensagem[] = 'A confirmação do password não corrresponde!';
       }else{
          $insert = $conn->prepare("INSERT INTO `usuario`(nome, email,password,tipo_usuario, perfil) VALUES(?,?,?,?,?)");
          $insert->execute([$name, $email, $pass,$tipo, $image]);
 
          if($insert){
             if($image_size > 2000000){
                $mensagem[] = 'Tamanho da Imagem muito grande!';
             }else{
                move_uploaded_file($image_tmp_name, $image_folder);
                $mensagem[] = 'Registrado com sucesso!';
                header('location:login.php');
             }
          }
 
       }
    }
 }

?>
<!DOCTYPE html>
<html lang="pt">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login</title>
        <link rel="shortcut icon" href="favicon/logo.png" type="image/x-icon">

        <link rel="stylesheet" href="./boxicons/fonts/boxicons.eot">
        <link rel="stylesheet" href="./assets/css/styles.css">
        <link rel="stylesheet" href="./boxicons/css/boxicons.min.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    </head>

    <body>
        <div class="container">
            <div class="signin-signup">
                <form action="" class="sign-in-form" method="POST">
                    <h2 class="title">Faça Login</h2>
                    <div class="input-field">
                        <i class="bx bx-user"></i>
                        <input type="email" name="email" placeholder="Digite seu email" required>
                    </div>
                    <div class="input-field">
                        <i class="bx bx-lock"></i>
                        <input type="password" name="pass" placeholder="Digite seu password" required>
                    </div>
                    <input type="submit" value="Entrar" class="btn" name="submit">
                        <?php
                            if(isset($message)){
                                foreach($message as $message){
                                    echo '
                                        <p style="text-align:center;"> <span style="color:red;">'.$message.'</span></p>
                                    ';
                                }
                            }
                        ?>
                    <p class="account-text">Ainda não tem conta? <a href="#" id="sign-up-btn2">Registrar agora</a></p>
                </form>
                <form action="" class="sign-up-form" enctype="multipart/form-data" method="POST">
                    <h2 class="title">Inscreva-se</h2>
                    <div class="input-field">
                        <i class="bx bx-user"></i>
                        <input type="text" name="nome" placeholder="Digite seu nome" required>
                    </div>
                    <div class="input-field">
                        <i class="bx bx-envelope"></i>
                        <input type="email" name="email" placeholder="Digite seu email" required>
                    </div>
                    <div class="input-field">
                        <i class="bx bx-lock"></i>
                        <input type="password" name="pass" placeholder="Digite seu password" required>
                    </div>
                    <div class="input-field">
                        <i class="bx bx-lock"></i>
                        <input type="password" name="cpass" placeholder="Confirmar password" required>
                    </div>
                    <div class="upload">
                        <input type="file" name="imagem"  required accept="image/jpg, image/jpeg, image/png, image/webp">
                    </div>
                    <input type="submit" value="Registrar" name="Registrar"  class="btn">
                    <?php
                            if(isset($mensagem)){
                                foreach($mensagem as $mensagem){
                                    echo '
                                        <p style="text-align:center;"> <span style="color:red;">'.$mensagem.'</span></p>
                                    ';
                                }
                            }
                        ?>
                    
                
                    <p class="account-text">Já tem uma conta?<a href="#" id="sign-in-btn2">Entrar agora</a></p>
                </form>
            </div>
            <div class="panels-container">
                <div class="panel left-panel">
                    <div class="content">
                        <h3>Membro Da Educação Facil Moçambique?</h3>
                        <p>Faça Login e desfrute das nossas funcionalidades</p>
                        <button class="btn" id="sign-in-btn">Faça Login</button>
                        <button class="btn" id="sign-in-btn"><a href="index.php" style="color: white;">Sair</a></button>
                    </div>
                    <img src="./favicon/signup.svg" alt="" class="image">
                </div>
                <div class="panel right-panel">
                    <div class="content">
                        <h3>Novo Na Plataforma?</h3>
                        <p>Inscreva-se hoje e ganha um welcome gift </p>
                        <button class="btn" id="sign-up-btn">Inscreva-se</button>
                        <button class="btn"><a href="index.php" style="color: white;">Sair</a></button>
                    </div>
                    <img src="./favicon/artboard_123063.svg" alt="" class="image">
                </div>
            </div>
        </div>
        
        <script src="./assets/js/app.js"></script>
    </body>

</html>