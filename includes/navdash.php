<header>

<div class="side-bar">

  <div class="menu">
    <ul>


      <li> <a href="dashboard.php">Dashboard</a> </li>

      <li><a href="#">Articles</a></li>

      <li><a href="news.php">Newsletters</a></li>

      <li><a href="#">Partenaires</a></li>

      <li><a href="#">Émissions</a></li>

      <li><a href="#">Contacts</a></li>
      <li><a href="déconnexion.php">Déconnexion</a></li>

    </ul>
  </div>

  <div class="toggle-button">

    <span></span>
    <span></span>
    <span></span>
  </div>

</div>



<!-- <div class="search">
  <input type="search1" placeholder="RECHERCHE..">
  <a href="#">valider</a>
</div> -->


<div class="notif">

  <img src="img/cloche.png" alt="cloche notification">
  <img src="img/lettre.png" alt="">
</div>

<div class="user">
  <?php

  if (isset($_SESSION['users'])) {
    echo "<h2>{$_SESSION['users']['user_name']}</h2>";
  }

  ?>

  <img src="img/Places-user-identity-icon.png" alt="user">

</div>


</header>