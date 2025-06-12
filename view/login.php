<div class="login-box">
  <h2>Seyahat Rehberi</h2>
  <?php if (isset($_GET['error'])): ?>
    <div class="error-message"><?= htmlspecialchars($_GET['error']) ?></div>
  <?php endif; ?>
  <?php if (isset($_GET['success'])): ?>
    <div class="success-message"><?= htmlspecialchars($_GET['success']) ?></div>
  <?php endif; ?>
  <form action="index.php?action=login" method="POST">
    <div class="input-group">
      <label for="email">E-posta</label>
      <input type="email" id="email" name="email" placeholder="ornek@eposta.com" required>
    </div>
    <div class="input-group">
      <label for="password">Şifre</label>
      <input type="password" id="password" name="password" placeholder="Şifrenizi girin" required>
    </div>
    <button type="submit" class="login-button">Giriş Yap</button>
  </form>
  <div class="signup-link">
    Hesabınız yok mu? <a href="index.php?action=register">Kayıt Ol</a>
  </div>
</div>
