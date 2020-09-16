<?php

$servername = "localhost";
$user = "root";
$pass = "";
$db_name = "mediacolabo";
// $connection = mysqli_connect($host, $user, $pass, $db_name);
// $conn = new PDO("mysql:host=$servername;dbname=bddtest", $username, $password);

// mysqli_query($connection, "SET NAMES utf8");


try {
  $connection = new PDO("mysql:host=$servername;dbname=$db_name", $user, $pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
  // On définit le mode d'erreur de PDO sur Exception
  $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  // echo 'Connexion réussie';

  // On crée la table et ses colonnes, on leur spécifie quelle est la clé primaire (ID, doit être utilisé une seule fois) et quelles sont les types valeurs attendues par les autres champs, NOT NULL permet de spécifier que le champs doit être spécifiquement rempli pour que la requête soit valide.
  $sql = "CREATE TABLE article(
    Id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    Author VARCHAR(30) NOT NULL,
    AuthorId VARCHAR(30) NOT NULL,
    ArticleName VARCHAR(30) NOT NULL,
    ArticleText VARCHAR(1250) NOT NULL,
    ArticleImage mediumblob() NOT NULL,
    ImageType VARCHAR(30) NOT NULL,
    DatePublication TIMESTAMP CURRENT_TIMESTAMP)";

  $connection->exec($sql);
  // echo 'Table bien créée !';
}

// On capture les exceptions si une exception est lancée et on affiche les informations relatives à celle-ci
catch (PDOException $e) {
  // echo "Erreur : " . $e->getMessage();
}

//Une fois le script entièrement lu: terminer la connexion
// $connection = null;