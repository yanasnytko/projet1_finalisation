<?php
require_once "db_user.php";

if (isset($_POST["login"])) {
  if (empty($_POST["userMail"]) || empty($_POST["userPass"])) {
    echo '<p>Tous les champs ont besoin d\être remplis</p>';
  } else {
    $sql = "SELECT * FROM users WHERE userMail=:userMail  AND userPass=:userPass ";
    $statement = $connect->prepare($sql);
    $userMail = $_POST["userMail"];
    $userPass = $_POST["userPass"];
    $userPass = md5($userPass . "wxcvbn123");
    $statement->execute([':userMail' => $userMail, ':userPass' => $userPass]);
    $count = $statement->rowCount();
    if ($count > 0) {
      $user = $statement->fetch(PDO::FETCH_ASSOC);
      $userId = $user['UserId'];
      $userName = $user['UserName'];
      session_start();
      $_SESSION["userId"] = $userId;
      $_SESSION["userName"] = $userName;
      header("location:../crudArticle/flux.php");
    } else {
      echo '<p>L\'e-mail ou le mot de passe est incorrect</p>';
      echo '<a href="landing.php">Retour</a>';
    }
  }
}