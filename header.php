  <!-- 
    - #HEADER
  -->

  <header class="header" data-header>
    <div class="container">

      <h1>
        <a href="#" class="logo">Dashboard</a>
      </h1>

      <button class="menu-toggle-btn icon-box" data-menu-toggle-btn aria-label="Toggle Menu">
        <span class="material-symbols-rounded  icon">menu</span>
      </button>

      <nav class="navbar">
        <div class="container">

          <ul class="navbar-list">

            <li>
              <a href="painel.php" class="navbar-link active icon-box">
                <span class="material-symbols-rounded  icon">grid_view</span>

                <span>Home</span>
              </a>
            </li>

            <li>
              <a href="professor.php" class="navbar-link icon-box">
                <span class="material-symbols-rounded  icon">folder</span>

                <span>Professor</span>
              </a>
            </li>

            <li>
              <a href="escola.php" class="navbar-link icon-box">
                <span class="material-symbols-rounded  icon">list</span>

                <span>Escolas</span>
              </a>
            </li>

            <li>
              <a href="settings.php" class="navbar-link icon-box">
                <span class="material-symbols-rounded  icon">settings</span>

                <span>Settings</span>
              </a>
            </li>

          </ul>

          <ul class="user-action-list">

            <li>
              <a href="#" class="notification icon-box">
                <span class="material-symbols-rounded  icon">notifications</span>
              </a>
            </li>

            <li>
              <a href="#" class="header-profile">
                <?php
                  $select_perfil = $conn->prepare("SELECT * FROM `usuario` WHERE id = ?");
                  $select_perfil->execute([$user_id]);
                  $fetch_perfil = $select_perfil->fetch(PDO::FETCH_ASSOC);
                ?>

                <figure class="profile-avatar">
                  <img src="img/<?= $fetch_perfil['perfil']; ?>"  width="32" height="32">
                </figure>

                <div>
                
                  <p class="profile-title"><?= $fetch_perfil['nome']; ?></p>

                  <p class="profile-subtitle">Admin</p>
                </div>

              </a>
            </li>

          </ul>

        </div>
      </nav>

    </div>
  </header>

