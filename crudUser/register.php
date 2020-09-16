<?php
require_once "db_user.php";

if (isset($_POST['userName'], $_POST['userMail'], $_POST['userPass'])) {
  $userName = filter_var(trim($_POST['userName']), FILTER_SANITIZE_STRING);
  $userMail = filter_var(trim($_POST['userMail']), FILTER_SANITIZE_STRING);
  $userPass = filter_var(trim($_POST['userPass']), FILTER_SANITIZE_STRING);

  if (mb_strlen($userName) < 3 || mb_strlen($userName) > 90) {
    echo "La longueur incorrecte de nom";
    exit();
  } else if (mb_strlen($userMail) < 5 || mb_strlen($userMail) > 90) {
    echo "La longueur incorrecte d'e-mail";
    exit();
  } else if (mb_strlen($userPass) < 2 || mb_strlen($userPass) > 90) {
    echo "La longueur incorrecte de mot de passe";
    exit();
  }

  $userPass = md5($userPass . "wxcvbn123");

  $sqlArticle = 'INSERT INTO users(UserName, UserMail, UserPass) VALUES( :userName, :userMail, :userPass)';
  $statement = $connect->prepare($sqlArticle);
  if ($statement->execute([':userName' => $userName, ':userMail' => $userMail, ':userPass' => $userPass])) {
    // header("Location: login.php");
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
        header("Location: landing.php");
      }
    }
  }
} else {
  echo "Remplissez tous les champs, svp !";
}