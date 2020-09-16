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
  $id = strip_tags($_GET['id']);
  $sql = 'SELECT * FROM article WHERE `id`=:id';
  $statement = $connection->prepare($sql);
  $statement->execute([':id' => $id]);
  $article = $statement->fetch();
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Modifier l'article <?= $article['ArticleName']; ?> de <?= $article['Author']; ?></title>
  <link rel="stylesheet" href="../styles/styles.css">
</head>

<body>
  <header>
    <a href="flux.php">
      <img src="../images/logo.png" alt="logo de Well of Knowledge" width="50px">
    </a>
    <a class="navLink" href="create.php">Publier un nouveau article</a>
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
      Modifiez l'article <?= $article['ArticleName'] ?>
    </h1>

    <form method="POST" enctype="multipart/form-data" class="center">
      <label for="articleName">Le nom de l'article&nbsp;:</label>
      <input value="<?= $article['ArticleName'] ?>" type="text" name="articleName" id="articleName">
      <br>
      <label for="articleText">Le texte de l'article&nbsp;:</label>
      <textarea name="articleText" id="articleText" cols="30" rows="10">
<?= $article['ArticleText'] ?>
</textarea>
      <br>
      <embed src="data:<?= $article['ImageType'] ?>;base64,<?= base64_encode($article['ArticleImage']) ?>"
        width="200px" />
      <input type="file" name="articleImage" id="articleImage"> <br>
      <button type="submit">
        Modifier
      </button>
    </form>
    <div class="actions">
      <a class="read" href="read.php?id=<?= $article['Id'] ?>">Lire l'article publié</a>
      <a class="delete" href="delete.php?id=<?= $article['Id'] ?>"
        onclick="return confirm('Êtes-vous sûr de vouloir supprimer l\'article <?= $article['ArticleName']; ?> ?')">
        Supprimer
      </a>
    </div>
  </main>
  <?php
  if (isset($_POST['articleName']) && isset($_POST['articleText'])) { // [ name de input ]
    $articleName = $_POST['articleName'];
    $articleText = $_POST['articleText'];

    if ($_FILES["articleImage"]["size"] != 0) {
      $articleImage = file_get_contents($_FILES['articleImage']['tmp_name']);
      $imageType = $_FILES["articleImage"]["type"];
      $sql = 'UPDATE article SET articleName=:articleName, articleText=:articleText, articleImage = :articleImage, imageType=:imageType WHERE id=:id';
      $statement = $connection->prepare($sql);
      $resultatRequet = $statement->execute([':articleName' => $articleName, ':articleText' => $articleText, ':id' => $id, ':articleImage' => "$articleImage", ":imageType" => $imageType]);
    } else {
      $sql = 'UPDATE article SET articleName=:articleName, articleText=:articleText WHERE id=:id';
      $statement = $connection->prepare($sql);
      $resultatRequet = $statement->execute([':articleName' => $articleName, ':articleText' => $articleText, ':id' => $id]);
    }
    if ($resultatRequet == 1) {
      // echo "L'article a bien été modifié !";
      // header("Location: /crud/read.php?id=" . $article['Id']);
      echo "<script type='text/javascript'>window.top.location='read.php?id=" . $article['Id'] . "';</script>";
    }
  }
  ?>
</body>

</html>