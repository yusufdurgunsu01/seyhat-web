<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8">
  <title>Seyahat Rehberi</title>
  <link rel="stylesheet" href="assets/style.css">
  <style>
    .error-message {
      color: red;
      font-size: 14px;
      text-align: center;
      margin-bottom: 10px;
    }
    .success-message {
      color: green;
      font-size: 14px;
      text-align: center;
      margin-bottom: 10px;
    }
  </style>
</head>
<body style="background: url('view/istanbul.jpg') no-repeat center center fixed; background-size: cover;">
  <?php
    if (!empty($view) && file_exists($view)) {
      include $view;
    } else {
      echo "<div class='error-message'>İçerik yüklenemedi.</div>";
    }
  ?>
</body>
</html>
