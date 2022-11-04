<?php

@include 'conexao.php';

session_start();



if(isset($_POST['adicionar'])){

    $nome = $_POST['nome'];
    $nome = filter_var($nome, FILTER_SANITIZE_STRING);
    $nivel = $_POST['nivel'];
    $nivel = filter_var($nivel, FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $contacto = $_POST['contacto'];
    $contacto = filter_var($contacto, FILTER_SANITIZE_STRING);
    $endereco = $_POST['endereco'];
    $endereco = filter_var($endereco, FILTER_SANITIZE_STRING);
    $longitude = $_POST['longitude'];
    $longitude = filter_var($longitude, FILTER_SANITIZE_STRING);
    $latitude = $_POST['latitude'];
    $latitude = filter_var($latitude, FILTER_SANITIZE_STRING);
    $descricao = $_POST['descricao'];
    $descricao = filter_var($descricao, FILTER_SANITIZE_STRING);
    $vagas = $_POST['vagas'];
    $vagas = filter_var($vagas, FILTER_SANITIZE_STRING);
    $atividades = $_POST['atividades'];
    $atividades = filter_var($atividades, FILTER_SANITIZE_STRING);
 
    $imagem = $_FILES['imagem']['name'];
    $imagem = filter_var($imagem, FILTER_SANITIZE_STRING);
    $image_size = $_FILES['imagem']['size'];
    $image_tmp_name = $_FILES['imagem']['tmp_name'];
    $image_folder = 'img/'.$imagem;
    
    

    $select_escola = $conn->prepare("SELECT * FROM `escola` WHERE nome = ?");
    $select_escola->execute([$nome]);
 
    if($select_escola->rowCount() > 0){
       $message[] = 'O nome do escola já existe!';
    }else{
 
       $insert_escola = $conn->prepare("INSERT INTO `escola`(nome, nivel, contacto, email, imagem, descricao, vagas, atividades, endereco, longitude, latitude) VALUES(?,?,?,?,?,?,?,?,?,?,?)");
       $insert_escola->execute([$nome, $nivel, $contacto, $email, $imagem, $descricao, $vagas, $atividades,$endereco, $longitude, $latitude ]);
 
       if($insert_escola){
          if($image_size > 20000000){
             $message[] = 'Tamanho da imagem muito grande!';
          }else{
             move_uploaded_file($image_tmp_name, $image_folder);
             $message[] = 'Novo escola adicionado!';
          }
 
       }
       if ($insert_escola->rowCount()) {
        $escola_id = $conn->lastInsertId();
        $diretorio = "img/$escola_id/";
        mkdir($diretorio, 0755);
        $arquivo = $_FILES['fotos'];

        for ($cont = 0; $cont < count($arquivo['name']); $cont++) {
          $nome_arquivo = $arquivo['name'][$cont];
          $destino = $diretorio . $arquivo['name'][$cont];

          if (move_uploaded_file($arquivo['tmp_name'][$cont], $destino)) {
            $query_imagem = "INSERT INTO imagens (nome_imagem, escola_id) VALUES (:nome_imagem, :escola_id)";
            $cad_imagem = $conn->prepare($query_imagem);
            $cad_imagem->bindParam(':nome_imagem', $nome_arquivo);
            $cad_imagem->bindParam(':escola_id', $escola_id);

            if ($cad_imagem->execute()) {
                $_SESSION['msg'] = "<p style='color: green;'>escola cadastrado com sucesso!</p>";
            } else {
                $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Imagem não cadastrada com sucesso!</p>";
            }
          }else {
          $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Imagem não cadastrada com sucesso!</p>";
        }
    }
 
    }
   

    }
 
 };

 
 if(isset($_GET['delete'])){

   $delete_id = $_GET['delete'];
   $select_delete_image = $conn->prepare("SELECT imagem FROM `escola` WHERE id = ?");
   $select_delete_image->execute([$delete_id]);
   $fetch_delete_image = $select_delete_image->fetch(PDO::FETCH_ASSOC);
   unlink('img/'.$fetch_delete_image['imagem']);
   $delete_escola = $conn->prepare("DELETE FROM `escola` WHERE id = ?");
   $delete_escola->execute([$delete_id]);
   header('location:escola.php');

  }

  if(isset($_POST['Atualizar_Escola'])){

   $pid = $_POST['pid'];
   $nome = $_POST['nome'];
   $nome = filter_var($nome, FILTER_SANITIZE_STRING);
   $nivel = $_POST['nivel'];
   $nivel = filter_var($nivel, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $contacto = $_POST['contacto'];
   $contacto = filter_var($contacto, FILTER_SANITIZE_STRING);
   $endereco = $_POST['endereco'];
   $endereco = filter_var($endereco, FILTER_SANITIZE_STRING);
   $longitude = $_POST['longitude'];
   $longitude = filter_var($longitude, FILTER_SANITIZE_STRING);
   $latitude = $_POST['latitude'];
   $latitude = filter_var($latitude, FILTER_SANITIZE_STRING);
   $descricao = $_POST['descricao'];
   $descricao = filter_var($descricao, FILTER_SANITIZE_STRING);
   $vagas = $_POST['vagas'];
   $vagas = filter_var($vagas, FILTER_SANITIZE_STRING);
   $atividades = $_POST['atividades'];
   $atividades = filter_var($atividades, FILTER_SANITIZE_STRING);

   $imagem = $_FILES['imagem']['name'];
   $imagem = filter_var($imagem, FILTER_SANITIZE_STRING);
   $image_size = $_FILES['imagem']['size'];
   $image_tmp_name = $_FILES['imagem']['tmp_name'];
   $image_folder = 'img/'.$imagem;
   


   $atualizar_escola = $conn->prepare("UPDATE `escola` SET nome = ?, nivel = ?, email = ?, contacto= ?, endereco= ?, longitude= ?, descricao= ?, vagas= ?, atividades= ? WHERE id = ?");
   $atualizar_escola->execute([$name, $nivel, $details, $email, $pid, $contacto, $endereco, $longitude, $latitude, $descricao, $vagas, $atividades]);

   $message[] = 'Escola atualizado com sucesso!';

   if(!empty($imagem)){
      if($image_size > 2000000){
         $message[] = 'imagem muito grande!';
      }else{

         $update_image = $conn->prepare("UPDATE `escola` SET imagem = ? WHERE id = ?");
         $update_image->execute([$imagem, $pid]);

         if($update_image){
            move_uploaded_file($image_tmp_name, $image_folder);
            unlink('img/'.$old_image);
            $message[] = 'imagem  atualizada com sucesso!';
         }
      }
   }

}
 

?>