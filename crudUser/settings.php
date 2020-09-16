<?php
session_start();
require_once "db_user.php";
require_once "login.php";

if (isset($_SESSION["userId"]) && mb_strlen($_SESSION["userId"]) > 0) {
  $userId = $_SESSION["userId"];
  $sqlUser = 'SELECT * FROM users WHERE `userId`=:userId';
  $statement = $connect->prepare($sqlUser);
  $statement->execute([':userId' => $userId]);
  $users = $statement->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Modifier le profile</title>
  <link rel="stylesheet" href="../styles/styles.css">
</head>

<body>
  <header>
    <a href="../crudArticle/flux.php">
      <img src="../images/logo.png" alt="logo de Well of Knowledge" width="50px">
    </a>
    <a class="navLink" href="../crudArticle/create.php">Publier un nouveau article</a>
    <a class="navLink" href="profile.php?id=<?= $users['UserId'] ?>">
      Profile de <?= $users['UserName'] ?>
    </a>
    <a class="navLink" href="#">
      Paramètres
    </a>
    <a class="navLink" href="logout.php">Me déconnecter</a>
  </header>
  <main class="center">
    <h1>
      <?= $users['UserName'] ?>, modifiez votre profile
    </h1>

    <form method="POST" enctype="multipart/form-data" class="center">
      <label for="userName">Votre nom&nbsp;:</label>
      <input value="<?= $users['UserName']; ?>" type="text" name="userName" id="userName">
      <br>
      <label for="userMail">Votre e-mail&nbsp;:</label>
      <input value="<?= $users['UserMail']; ?>" type="text" name="userMail" id="userMail">
      <br>
      <label for="userPass">Votre mot de passe&nbsp;:</label>
      <input value="" type="password" name="userPass" id="userPass">
      <p>
        N'oubliez pas de rentrer votre mot de passe, même si vous ne le changez pas&nbsp;!
      </p>
      <br>
      <embed src="data:<?= $users['UserImageType'] ?>;base64,<?= base64_encode($users['UserImage']) ?>" width="200px" />
      <input type="file" name="userImage" id="userImage"> <br>
      <button type="submit">
        Modifier
      </button>
    </form>
    <div class="actions">
      <a class="delete" href="../crudArticle/delete.php?id=<?= $users['UserId'] ?>"
        onclick="return confirm('Êtes-vous sûr de vouloir supprimer votre profile ?')">
        Supprimer le profile
      </a>
    </div>
  </main>
  <?php
  if (isset($_POST['userName']) && isset($_POST['userMail']) && isset($_POST['userPass'])) { // [ name de input ]
    $userName = $_POST['userName'];
    $userMail = $_POST['userMail'];
    $userPass = $_POST["userPass"];
    $userPass = md5($userPass . "wxcvbn123");

    if ($_FILES["userImage"]["size"] != 0) {
      /* $userImage = file_get_contents($_FILES['userImage']['tmp_name']);
      $userImageType = $_FILES["userImage"]["type"];
      $sql = 'UPDATE users SET userName=:userName, userMail=:userMail, userPass=:userPass, userImage = :userImage, userImageType=:userImageType WHERE UserId=:UserId';
      $statement = $connect->prepare($sql);
      $resultatRequet = $statement->execute([':userName' => $userName, ':userMail' => $userMail, ':userPass' => $userPass, ':userId' => $userId, ':userImage' => $userImage, ':userImageType' => $userImageType]);
    } else {
      $sql = 'UPDATE users SET userName=:userName, userMail=:userMail, userPass=:userPass WHERE userId=:userId';
      $statement = $connect->prepare($sql);
      $resultatRequet = $statement->execute([':userName' => $userName, ':userMail' => $userMail, ':userPass' => $userPass, ':userId' => $userId]); */
      $userImage = file_get_contents($_FILES['userImage']['tmp_name']);
      $userImageType = $_FILES["userImage"]["type"];
      $sql = 'UPDATE users SET userName=?, userMail=?, userPass=?, userImage=?, userImageType=? WHERE userId=?';
      $statement = $connect->prepare($sql);
      $resultatRequet = $statement->execute(
        array(
          $userName,
          $userMail,
          $userPass,
          $userImage,
          $userImageType,
          $userId
        )
      );
    } else {
      $sql = 'UPDATE users SET userName=:userName, userMail=:userMail, userPass=:userPass WHERE userId=:userId';
      $statement = $connect->prepare($sql);
      $resultatRequet = $statement->execute([':userName' => $userName, ':userMail' => $userMail, ':userPass' => $userPass, ':userId' => $userId]);
    }
    if ($resultatRequet == 1) {
      echo "<script type='text/javascript'>window.top.location='profile.php?id=" . $users['UserId'] . "';</script>";
    }
  }
  ?>
</body>

</html>
