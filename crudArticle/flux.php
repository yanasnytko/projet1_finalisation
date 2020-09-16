<?php
session_start();
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

<?php
require_once "db.php";
$sql = 'SELECT * FROM article';
$statement = $connection->prepare($sql);
$statement->execute();
$article = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Le flux des articles</title>
  <link rel="stylesheet" href="../styles/styles.css" />
</head>

<body>

  <header>
    <a href=" #">
      <img src="../images/logo.png" alt="logo de Well of Knowledge" width="50px">
    </a>
    <?php if (isset($_SESSION["userId"]) && mb_strlen($_SESSION["userId"]) > 0) : ?>
    <a class="navLink" href="create.php">Publier un nouveau article</a>
    <a class="navLink" href="../crudUser/profile.php?id=<?= $users['UserId'] ?>">
      Profile de <?= $users['UserName'] ?>
    </a>
    <a class="navLink" href="../crudUser/settings.php?id=<?= $users['UserId'] ?>">
      Paramètres
    </a>
    <a class="navLink" href="../crudUser/logout.php">Me déconnecter</a>
    <?php else : ?>
    <a class="navLink" href="../crudUser/landing.php">Me connecter</a>
    <?php endif; ?>
  </header>

  <main>
    <?php if (isset($_SESSION["userId"]) && mb_strlen($_SESSION["userId"]) > 0) : ?>
    <h1>
      <?= $users['UserName'] ?>, bienvenue sur le flux des articles
    </h1>
    <?php else : ?>
    <h1>
      Bienvenue sur le flux des articles
    </h1>
    <?php endif; ?>

    <?php foreach ($article as $value) : ?>
    <div class="article">
      <h2 class="articleName"><?= $value['ArticleName'] ?></h2>
      <div class="author">par <a href="../crudUser/profile.php?id=<?= $value['AuthorId'] ?>"><?= $value['Author'] ?></a>
      </div>
      <div class="image">
        <embed src="data:<?= $value['ImageType'] ?>;base64,<?= base64_encode($value['ArticleImage']) ?>"
          width="200px" />
      </div>
      <div class="articleText"><?= $value['ArticleText'] ?></div>
      <div class="actions">
        <a class="read" href="read.php?id=<?= $value['Id'] ?>">Lire l'article</a>
        <?php
          if (isset($_SESSION["userId"]) && mb_strlen($_SESSION["userId"]) > 0 && $value['AuthorId'] == $users['UserId']) :
          ?>
        <a class="update" href="update.php?id=<?= $value['Id'] ?>">Modifier</a>
        <a class="delete" href="delete.php?id=<?= $value['Id'] ?>"
          onclick="return confirm('Êtes-vous sûr de vouloir supprimer l\'article <?= $value['ArticleName'] ?>')">
          Supprimer
        </a>
        <?php endif; ?>
      </div>
    </div>
    <?php endforeach; ?>
  </main>
</body>

</html>