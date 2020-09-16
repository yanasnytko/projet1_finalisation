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
if (isset($_GET['id']) && !empty($_GET['id'])) {
  $id = strip_tags($_GET['id']); // récuperartion de l'id dans l'url
  $sql = 'SELECT * FROM article WHERE `id`=:id';
  $statement = $connection->prepare($sql);
  $statement->execute([':id' => $id]);
  $article = $statement->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>L'article <?= $article['ArticleName']; ?> de <?= $article['Author']; ?></title>
  <link rel="stylesheet" href="../styles/styles.css">
</head>

<body>
  <header>
    <a href="flux.php">
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
    <h1>
      Lecture de l'article <?= $article['ArticleName']; ?> de <?= $article['Author']; ?>
    </h1>

    <h2 class="articleName">
      <?= $article['ArticleName']; ?>
    </h2>
    <div class="author">
      Par <a href="../crudUser/profile.php?id=<?= $article['AuthorId'] ?>"><?= $article['Author'] ?></a>
    </div>
    <div class="image">
      <embed src="data:<?= $article['ImageType'] ?>;base64,<?= base64_encode($article['ArticleImage']) ?>"
        width="200px" />
    </div>
    <div class="articleText"><?= $article['ArticleText'] ?>
    </div>
    <p>
      L'article a été publié le <?= $article['DatePublication']; ?>
    </p>
    <div class="actions">
      <?php
      if (isset($_SESSION["userId"]) && mb_strlen($_SESSION["userId"]) > 0) :
      ?>
      <a class="read" href="read.php?id=<?= $article['Id'] ?>">Lire l'article</a>
      <?php if ($article['AuthorId'] == $users['UserId']) : ?>
      <a class="update" href="update.php?id=<?= $article['Id'] ?>">Modifier</a>
      <a class="delete" href="delete.php?id=<?= $article['Id'] ?>"
        onclick="return confirm('Êtes-vous sûr de vouloir supprimer l\'article <?= $article['ArticleName'] ?>')">
        Supprimer
      </a>
      <?php endif; ?>
      <?php endif; ?>
    </div>
  </main>

</body>

</html>