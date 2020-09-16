<?php
session_start();
require_once "db.php";
require_once "../crudUser/db_user.php";
require_once "../crudUser/login.php";

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
  <title>Publier un article</title>
  <link rel="stylesheet" href="../styles/styles.css">

</head>

<body>
  <header>
    <a href="flux.php">
      <img src="../images/logo.png" alt="logo de Well of Knowledge" width="50px">
    </a>
    <a class="navLink" href="#">Publier un nouveau article</a>
    <a class="navLink" href="../crudUser/profile.php?id=<?= $users['UserId'] ?>">
      Profile de <?= $users['UserName'] ?>
    </a>
    <a class="navLink" href="../crudUser/settings.php?id=<?= $users['UserId'] ?>">
      Paramètres
    </a>
    <a class="navLink" href="../crudUser/logout.php">Me déconnecter</a>
  </header>
  <main class="center">
    <h1>
      Publiez un article
    </h1>
    <form method="POST" enctype="multipart/form-data">
      <label for="articleName">Le nom de l'article&nbsp;:</label>
      <input type="text" name="articleName" id="articleName" require placeholder="Un nom d'article">
      <br>
      <label for="articleText">Le texte de l'article&nbsp;:</label>
      <textarea name="articleText" id="articleText" cols="30" rows="10" required
        placeholder="Le texte de l'article"></textarea>
      <br>
      <label for="articleImage">Choisissez une image pour votre article&nbsp;:</label>
      <input type="file" name="articleImage" id="articleImage">
      <br>
      <button type="submit">
        Publier
      </button>
    </form>
  </main>

  <?php
  if (isset($_SESSION["userId"]) && isset($_SESSION["userName"]) && isset($_POST['articleName']) && isset($_POST['articleText']) && isset($_FILES['articleImage'])) { // [ name de input ]
    $author = $_SESSION["userName"];
    $authorId = $_SESSION["userId"];
    $articleName = $_POST['articleName'];
    $articleText = $_POST['articleText'];

    // $target = "images/" . basename($_FILES['articleImage']['name']);
    $imageType = $_FILES["articleImage"]["type"];
    $articleImage = file_get_contents($_FILES['articleImage']['tmp_name']);

    $sql = 'INSERT INTO article(author, authorId, articleName, articleText, articleImage, imageType) VALUES(:author, :authorId, :articleName, :articleText, :articleImage, :imageType)';
    $statement = $connection->prepare($sql);
    if ($statement->execute([':author' => $author, ':authorId' => $authorId, ':articleName' => $articleName, ':articleText' => $articleText, ':articleImage' => $articleImage, ':imageType' => $imageType])) {
      echo "C'est dans la boîte !";
      header("location:flux.php");
    }
  }
  ?>

</body>

</html>