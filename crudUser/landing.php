<?php
session_start();
require_once "db_user.php";

if (isset($_SESSION["userId"]) && mb_strlen($_SESSION["userId"]) > 0) {
  header("location:../crudArticle/flux.php");
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Well of Knowledge</title>
  <link rel="stylesheet" type="text/css" href="../styles/styles.css">
</head>

<body>
  <main class="center">
    <a href="#">
      <img src="../images/logo.png" alt="logo de Well of Knowledge" width="50px">
    </a>
    <h1 id="nom">
      Well of Knowledge
    </h1>
    <div class="center">
      <h2>
        Se connecter
      </h2>
      <form method="POST" action="login.php" id="loginForm" class="center">
        <label for="userMail">E-mail&nbsp;:</label>
        <input type="text" name="userMail" id="userMail" />
        <label for="userPass">Password&nbsp;:</label>
        <input type="password" name="userPass" id="userPass" />
        <br>
        <input type="submit" name="login" id="login" value="Se connecter" class="read" />
      </form>
    </div>
    <p>
      Partagez avec nous votre passion, vos connaissances ou, pourquoi pas, votre humour&nbsp;? <br>
      Quoi qu'il en soit, ça nous va, tant que vous venez <span>comme vous êtes</span>&nbsp;!
    </p>
    <div class="center">
      <h2>
        Inscrivez-vous&nbsp;!
      </h2>
      <form action="register.php" method="POST" id="registerForm" class="center">
        <label for="userName">
          Nom&nbsp;:
        </label>
        <input type="text" name="userName" id="userName">
        <label for="userMail">
          E-mail&nbsp;:
        </label>
        <input type="text" name="userMail" id="userMailRegister">
        <label for="userPass">
          Mot de passe&nbsp;:
        </label>
        <input type="password" name="userPass" id="userPassRegister">
        <br>
        <p class="image">
          Une fois enregistré, vous pourriez ajouter une image de profile&nbsp;!
        </p>
        <input type="submit" name="register" id="register" value="S'inscrire" class="read">
      </form>
    </div>
    <div class="landing">
      <a href="../crudArticle/flux.php" class="delete">Parcourir les articles</a>
      <br>
      <p>
        (sans connexion)
      </p>
    </div>
  </main>
</body>

</html>