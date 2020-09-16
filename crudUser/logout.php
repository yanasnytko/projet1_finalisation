<?php
require_once "db_user.php";
session_start();
unset($_SESSION["userId"]);

// session_destroy();
// session_abort();

header("location:landing.php");