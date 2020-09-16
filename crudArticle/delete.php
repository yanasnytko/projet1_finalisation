<?php
require_once "db.php";
$id = strip_tags($_GET['id']);
$sql = 'DELETE FROM article WHERE `id`=:id';
$statement = $connection->prepare($sql);
if ($statement->execute([':id' => $id])) {
  header("Location: flux.php");
}