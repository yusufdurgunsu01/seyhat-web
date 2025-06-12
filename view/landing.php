<?php if (!isset($_SESSION)) session_start(); ?>
<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Ana Sayfa</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      background-color: #f2f2f2;
      color: #333;
    }

    header {
      background-color: #7092b9;
      color: white;
      padding: 20px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    header h1 {
      margin: 0;
      font-size: 24px;
    }

    .auth-buttons button {
      background-color: white;
      color: #7092b9;
      border: none;
      padding: 8px 16px;
      margin-left: 10px;
      border-radius: 6px;
      cursor: pointer;
      font-weight: bold;
    }

    .auth-buttons button:hover {
      background-color: #f3dede;
    }

    .mission {
      text-align: center;
      padding: 30px 20px;
      max-width: 700px;
      margin: auto;
    }

    .mission h2 {
      margin-bottom: 10px;
      font-size: 28px;
    }

    .destinations {
      max-width: 1000px;
      margin: 0 auto;
      padding: 20px;
    }

    .city-card {
      display: flex;
      background-color: white;
      border-radius: 10px;
      margin-bottom: 15px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.05);
      overflow: hidden;
    }

    .city-card img {
      width: 150px;
      height: 100%;
      object-fit: cover;
    }

    .city-info {
      padding: 15px;
      flex-grow: 1;
    }

    .city-info h3 {
      margin-top: 0;
      margin-bottom: 8px;
    }

    .city-info p {
      margin: 0;
      font-size: 15px;
    }
  </style>
</head>
<body>

  <header>
    <h1>Seyahat Yanımda</h1>
    <div class="auth-buttons">
      <button onclick="window.location.href='index.php?action=login'">Oturum Aç</button>
    </div>
  </header>

  <section class="mission">
    <h2>Dünyayı Keşfetmeye Hazır mısın?</h2>
    <p>Seyehat Yanımda, seni en güzel şehirlerle tanıştırır. Seyahate çıkmadan önce bilgi al, plan yap, yorumları incele.</p>
  </section>

  <section class="destinations">
    
    <a href="file:///C:/Users/asdass/Desktop/proje/%C5%9Eehir%20Ana%20Sayfa/seyhat.html" style="text-decoration: none; color: inherit;">
    <div class="city-card">
      <img src="/seyahat/view/resimler/kapadokya.jpg" alt="Kapadokya" />
      <div class="city-info">
        <h3>Kapadokya</h3>
        <p>Peri bacaları, sıcak hava balonları ve yeraltı şehirleriyle ünlü mistik bir bölge.</p>
      </div>
    </div>

    
    <div class="city-card">
      <img src="/seyahat/view/resimler/istanbul.jpg" alt="İstanbul" />
      <div class="city-info">
        <h3>İstanbul</h3>
        <p>İki kıtayı birleştiren kültür başkenti, tarihi dokusu ve hareketli sokaklarıyla büyüleyici.</p>
      </div>
    </div>

   
    <div class="city-card">
      <img src="/seyahat/view/resimler/efes.jpg" alt="Efes" />
      <div class="city-info">
        <h3>Efes</h3>
        <p>Antik dönemin en büyük kentlerinden biri, tarih severler için vazgeçilmez bir durak.</p>
      </div>
    </div>

    <!-- Şehir 4 -->
    <div class="city-card">
      <img src="/seyahat/view/resimler/pamukkale.jpg" alt="Pamukkale" />
      <div class="city-info">
        <h3>Pamukkale</h3>
        <p>Bembeyaz travertenleri ve şifalı termal sularıyla dünyaca ünlü doğal güzellik.</p>
      </div>
    </div>

    <!-- Şehir 5 -->
    <div class="city-card">
      <img src="/seyahat/view/resimler/uludag.jpg" alt="Uludağ" />
      <div class="city-info">
        <h3>Uludağ</h3>
        <p>Kış turizmi ve doğa yürüyüşleriyle bilinen Türkiye’nin en yüksek dağlarından biri.</p>
      </div>
    </div>
  </section>

</body>
</html>
