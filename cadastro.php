
    <div class="container">
 
        <div class="cover">
            <div class="front">
               <img src="./bens/imagens/cover.png"> 
               <div class="text">
                    <span class="text-1">Todos os novos amigos <br> são uma nova aventura</span>
                    <span class="text-2">Vamos nos conectar</span>
                </div>
            </div>
        </div>
        <form action="./bens/php/acao.php?signup" enctype="multipart/form-data" method="POST">
            <div class="form-content">
                <div class="login-form">
                    <div class="title">Signup</div>
                        <div class="input-boxes">
                            <div class="input-box">
                                <i class="ion-android-contact"></i>
                                <input type="text" name="nome"  placeholder="Seu nome">
                                <input type="text" name="apelido"  placeholder="Seu apelido">
                            </div>

                            <div class="input-boxe">
                                <i class="ion-transgender"></i>
                                <div class="lb">
                                    M <input type="radio" name="genero" class="check" value="0" >
                                    F <input type="radio" name="genero" class="check" value="1" <?=showFormData('genero')==1?'checked':''?>>
                                    Outro <input type="radio" name="genero" class="check" value="2" <?=showFormData('genero')==2?'checked':''?>>
                                </div>
                            </div>
                            <div class="input-box">
                                <i class="ion-ios-email"></i>
                                <input type="text" name="email" value="<?=showFormData('email')?>" placeholder="Seu email" >
                            </div>
                            <?=mostrarError('email')?>
                            <div class="input-box">
                                <i class="ion-android-contact"></i>
                                <input type="text" name="username" value="<?=showFormData('username')?>" placeholder="Seu nome de usuario">
                            </div>
                            <?=mostrarError('username')?>
                            <div class="input-box">
                                <i class="ion-ios-locked"></i>
                                <input type="password" name="password" placeholder="seu password" >
                            </div>
                            <?=mostrarError('password')?>
                            <div class=" button input-box">
                                <input type="submit" name="signup" value="Registrar">
                            </div>
                            <div class="text sign-up-text">Ja tem conta?<a href="?login"> Entrar agora</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
