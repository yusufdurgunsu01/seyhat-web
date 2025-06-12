<div class="login-box">
  <h2>Kayıt Ol</h2>

  <?php if (isset($_GET['error'])): ?>
    <div class="error-message"><?= htmlspecialchars($_GET['error']) ?></div>
  <?php endif; ?>

  <?php if (isset($_GET['success'])): ?>
    <div class="success-message" style="color:green; text-align:center; font-size:14px; margin-bottom:10px;">
      <?= htmlspecialchars($_GET['success']) ?>
    </div>
  <?php endif; ?>

  <form action="index.php?action=register" method="POST">
    <div class="input-group">
      <label for="email">E-posta</label>
      <input type="email" name="email" required>
    </div>
    <div class="input-group">
      <label for="password">Şifre</label>
      <input type="password" name="password" required>
    </div>
    <button type="submit" class="login-button">Kayıt Ol</button>
  </form>

  <div class="signup-link">
    Zaten hesabınız var mı? <a href="index.php?action=login">Giriş Yap</a>
  </div>
</div>

