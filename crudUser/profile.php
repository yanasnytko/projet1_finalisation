<?php
/* session_start();
require_once "db_user.php";
require_once "login.php";

if (isset($_SESSION["userId"]) && mb_strlen($_SESSION["userId"]) > 0) {
  $userId = $_SESSION["userId"];
  $sqlUser = 'SELECT * FROM users WHERE `userId`=:userId';
  $statement = $connect->prepare($sqlUser);
  $statement->execute([':userId' => $userId]);
  $users = $statement->fetch(PDO::FETCH_ASSOC);
} */
?>

<?php
session_start();
require_once "db_user.php";
require_once "login.php";

if (isset($_GET['id']) && !empty($_GET['id'])) {
  $userId = strip_tags($_GET['id']);
  $sqlUser = 'SELECT * FROM users WHERE `userId`=:userId';
  $statement = $connect->prepare($sqlUser);
  $statement->execute([':userId' => $userId]);
  $users = $statement->fetch(PDO::FETCH_ASSOC);
}
?>

<?php
require_once "../crudArticle/db.php";
$authorId = $users['UserId'];
$sql = 'SELECT * FROM article WHERE `authorId`=:userId';
$statement = $connection->prepare($sql);
$statement->execute([':userId' => $authorId]);
$article = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Le profile de <?= $users['UserName'] ?></title>
  <link rel="stylesheet" href="../styles/styles.css">
</head>

<body>
  <header>
    <a href="../crudArticle/flux.php">
      <img src="../images/logo.png" alt="logo de Well of Knowledge" width="50px">
    </a>
    <?php if (isset($_SESSION["userId"]) && mb_strlen($_SESSION["userId"]) > 0) : ?>
    <a class="navLink" href="../crudArticle/create.php">Publier un nouveau article</a>
    <a class="navLink" href="profile.php?id=<?= $_SESSION["userName"] ?>">
      Profile de <?= $_SESSION["userName"] ?>
    </a>
    <a class="navLink" href="settings.php?id=<?= $_SESSION["userId"] ?>">
      Paramètres
    </a>
    <a class="navLink" href="logout.php">Me déconnecter</a>
    <?php else : ?>
    <a class="navLink" href="landing.php">Me connecter</a>
    <?php endif; ?>
  </header>

  <main>
    <h1>
      Profile de <?= $users['UserName'] ?>
    </h1>
    <div>
      <embed src="data:<?= $users['UserImageType'] ?>;base64,<?= base64_encode($users['UserImage']) ?>" width="200px" />
    </div>

    <?php if (isset($_SESSION["userId"]) && mb_strlen($_SESSION["userId"]) > 0 && $_SESSION["userId"] == $userId) : ?>
    <a href="settings.php?id=<?= $users['UserId'] ?>">
      Modifier mon profile via la page des paramètres
    </a>
    <?php endif; ?>

    <h2>
      Les articles de <?= $users['UserName'] ?>
    </h2>

    <?php foreach ($article as $value) : ?>
    <div class="article">
      <h3 class="articleName"><?= $value['ArticleName'] ?></h3>
      <div class="image">
        <embed src="data:<?= $value['ImageType'] ?>;base64,<?= base64_encode($value['ArticleImage']) ?>"
          width="200px" />
      </div>
      <div class="actions">
        <a class="read" href="../crudArticle/read.php?id=<?= $value['Id'] ?>">
          Lire l'article
        </a>
        <?php if (isset($_SESSION["userId"]) && mb_strlen($_SESSION["userId"]) > 0 && $_SESSION["userId"] == $userId) : ?>
        <a class="update" href="../crudArticle/update.php?id=<?= $value['Id'] ?>">
          Modifier
        </a>
        <a class="delete" href="../crudArticle/delete.php?id=<?= $value['Id'] ?>"
          onclick="return confirm('Êtes-vous sûr de vouloir supprimer l\'article <?= $value['ArticleName'] ?>')">
          Supprimer
        </a>
        <?php endif; ?>


      </div>
    </div>
    <?php endforeach; ?>
    <?php if (isset($_SESSION["userId"]) && mb_strlen($_SESSION["userId"]) > 0 && $_SESSION["userId"] == $userId) : ?>
    <p>
      <?= $_SESSION["userName"] ?>, pensez à <a href="../crudArticle/create.php">publier un nouveau article.</a>
    </p>
    <?php endif; ?>
  </main>
</body>

</html>
