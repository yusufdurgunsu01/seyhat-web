<?php
$action = $_GET['action'] ?? 'login';
$view = '';

require_once 'controller/AuthController.php';

switch ($action) {
  case 'login':
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      (new AuthController())->login($_POST);
      exit;
    }
    $view = 'view/login.php';
    break;

  case 'register':
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      (new AuthController())->register($_POST);
      exit;
    }
    $view = 'view/register.php';
    break;

  default:
    $view = 'view/login.php';
}

include 'view/template.php';
