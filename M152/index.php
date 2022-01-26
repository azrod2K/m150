<?php
session_start();



include "vues/header.php";

$uc=empty($_GET['uc']) ? "home" : $_GET['uc'];
switch ($uc) {
    case 'home':
      include 'controllers/home_controller.php';
        break;
    case 'post':
        include 'controllers/post_controller.php';
        break;
}
include "vues/footer.php";
?>