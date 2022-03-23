<?php
session_start();
if (!isset($_SESSION['message'])) {
  $_SESSION['message'] = [
      'type' => null,
      'content' => null
  ];
}
ini_set('display_errors', 1);
require("models/MonPdo.php");
require("models/Post.php");
require("models/Media.php");

include "vues/header.php";

$uc = filter_input(INPUT_GET, 'uc') == null ? "home" : filter_input(INPUT_GET, 'uc'); // affiche la page accueil par défaut
switch ($uc) {
    case 'home':
      $posts = Post::getAllPosts();
      include 'vues/home.php';
        break;
    case 'post':
        include 'controllers/post_controller.php';
        break;
}
include "vues/footer.php";
error_reporting(E_ALL);
?>