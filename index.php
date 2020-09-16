<?php
session_start();
require_once "crudUser/db_user.php";

if (isset($_SESSION["userId"]) && mb_strlen($_SESSION["userId"]) > 0) {
  header("location:crudArticle/flux.php");
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Well of Knowledge</title>
  <link rel="stylesheet" href="styles/styles.css">
</head>

<body class="center">
  <h1>
    Bienvenue sur Well of Knowledge&nbsp;!
  </h1>
  <p class="intro">
    Partagez avec nous votre passion, vos connaissances ou, pourquoi pas, votre humour&nbsp;? <br>
    Quoi qu'il en soit, ça nous va, tant que vous venez <span>comme vous êtes</span>&nbsp;!
  </p>
  <div class="intro">
    <a href="crudUser/landing.php" class="read intro">
      Se connecter
    </a>
    <a href="crudUser/landing.php" class="read intro">
      S'inscrire
    </a>
    <a href="crudArticle/flux.php" class="delete intro">
      Parcourir les articles
    </a>
  </div>
</body>

</html>