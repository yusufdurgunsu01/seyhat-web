<?php
require_once 'core/db.php';
require_once 'model/User.php';

class AuthController {
  public function login($data) {
    $email = $data['email'];
    $password = $data['password'];

    $userModel = new User($GLOBALS['conn']);
    $user = $userModel->findByEmailAndPassword($email, $password);

    if ($user) {
      header("Location: /seyahat/view/yusuf.html");
    } else {
      header("Location: index.php?action=login&error=E-posta veya şifre hatalı");
    }
  }

  public function register($data) {
    $email = $data['email'];
    $password = $data['password'];

    $user = new User($GLOBALS['conn']);

    // E-posta kontrolü
    if ($user->emailExists($email)) {
        // Kayıtlıysa uyarı ile register sayfasına yönlendir
        header("Location: index.php?action=register&error=Bu e-posta zaten kayıtlı.");
        exit;
    }

    // Kayıt başarılı mı?
    if ($user->register($email, $password)) {
        header("Location: index.php?action=login&success=Hesabınız başarıyla oluşturuldu.");
        exit;
    } else {
        header("Location: index.php?action=register&error=Kayıt işlemi başarısız oldu.");
        exit;
    }
  }

}
