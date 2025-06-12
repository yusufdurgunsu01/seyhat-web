<?php

if (!isset($_SESSION)) session_start();
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seyahat Rehberi</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Custom CSS -->
    <style>
        body {
            background-image: url('https://images.unsplash.com/photo-1524231757912-21f4fe3a7200?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2000&q=80');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            background-repeat: no-repeat;
        }
        .navbar {
            background: linear-gradient(135deg, #d23607 0%, #0952d1 100%) !important;
            box-shadow: 0 2px 10px rgba(7, 218, 130, 0.789);
        }
        .navbar-brand {
            font-weight: bold;
            font-size: 1.5rem;
            color: rgb(85, 9, 214) !important;
        }
        .nav-link {
            color: rgba(211, 7, 238, 0.9) !important;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .nav-link:hover {
            color: rgb(233, 8, 162) !important;
            transform: translateY(-2px);
        }
        .container {
            background-color: rgba(8, 228, 210, 0);
            border-radius: 15px;
            padding: 20px;
            margin-top: 20px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
        }
        #map {
            height: 500px;
            width: 100%;
            margin-bottom: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .location-card {
            margin-bottom: 15px;
            cursor: pointer;
            background-color: rgba(255, 255, 255, 0.95);
        }
        .rating {
            color: #ffc107;
        }
        .card {
            background-color: rgba(255, 255, 255, 0.95);
            border: none;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }
        .modal-content {
            background-color: rgba(255, 255, 255, 0.98);
        }
        /* Deneyim paylaşma modal stilleri */
        #shareExperienceModal .modal-content {
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(167, 188, 175, 0.542);
            background: linear-gradient(rgba(21, 35, 123, 0.95), rgba(12, 35, 153, 0.95)),
                        url('view/images/ntv.jpg') center/cover no-repeat;
            position: relative;
        }
        #shareExperienceModal .modal-header {
            border-radius: 15px 15px 0 0;
            background: linear-gradient(135deg, #502c2c 0%, #2d1218 100%);
            border-bottom: 2px solid rgba(255, 255, 255, 0.1);
            padding: 1.5rem;
        }
        #shareExperienceModal .modal-body {
            padding: 2rem;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 0 0 15px 15px;
        }
        #shareExperienceModal .card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(5px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        #shareExperienceModal .card-header {
            background: rgba(80, 44, 44, 0.1);
            border-bottom: 1px solid rgba(80, 44, 44, 0.2);
        }
        #shareExperienceModal .form-control,
        #shareExperienceModal .form-select {
            background: rgba(48, 152, 161, 0.9);
            border: 1px solid rgba(80, 44, 44, 0.2);
        }
        #shareExperienceModal .form-control:focus,
        #shareExperienceModal .form-select:focus {
            background: rgba(46, 203, 203, 0.95);
            border-color: #502c2c;
            box-shadow: 0 0 0 0.25rem rgba(80, 44, 44, 0.25);
        }
        #shareExperienceModal .btn-primary {
            background: linear-gradient(135deg, #502c2c 0%, #2d1218 100%);
            border: none;
            padding: 0.8rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        #shareExperienceModal .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(80, 44, 44, 0.3);
        }
        #shareExperienceModal .btn-outline-secondary {
            border-color: #502c2c;
            color: #502c2c;
        }
        #shareExperienceModal .btn-outline-secondary:hover {
            background: #502c2c;
            color: rgb(14, 100, 87);
        }
        #shareExperienceModal .rating {
            font-size: 24px;
            color: #666689;
            cursor: pointer;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
        }
        #shareExperienceModal .rating .fas {
            margin-right: 5px;
            transition: all 0.2s ease;
        }
        #shareExperienceModal .rating .fas:hover,
        #shareExperienceModal .rating .fas.active {
            color: #502c2c;
            transform: scale(1.1);
        }
        #shareExperienceModal .form-label {
            color: #502c2c;
            font-weight: 600;
        }
        #shareExperienceModal .form-text {
            color: #666;
        }
        #shareExperienceModal .modal-title {
            font-size: 1.5rem;
            font-weight: 600;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
        }
        #shareExperienceModal .photo-preview {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 10px;
        }
        #shareExperienceModal .photo-preview img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 8px;
            border: 2px solid rgba(80, 44, 44, 0.2);
            transition: all 0.3s ease;
        }
        #shareExperienceModal .photo-preview img:hover {
            transform: scale(1.05);
            border-color: #502c2c;
        }
        /* Animasyonlar */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        #shareExperienceModal .modal-content {
            animation: fadeIn 0.3s ease-out;
        }
        #shareExperienceModal .card {
            animation: fadeIn 0.4s ease-out;
        }
        #shareExperienceModal .form-group {
            animation: fadeIn 0.5s ease-out;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="#">Seyahat Rehberi</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Çıkış Butonu -->
        <div class="d-flex ms-auto">
            <a href="index.php?action=logout" class="btn btn-outline-light">Çıkış Yap</a>
        </div>
    </div>
</nav>

    <!-- Main Content -->
    <div class="container mt-4">
        <div class="row">
            <!-- Map Section -->
            <div class="col-md-8">
                <div id="map"></div>
                <!-- Recommended Cities Section -->
                <div class="card mt-4 border-0 shadow">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-star"></i> Önerilen Şehirler</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Balikesir -->
                            <div class="col-md-4 mb-4">
                                <div class="card h-100 border-0 shadow-sm">
                                    <img src="view/images/balikesir.jpg" class="card-img-top" alt="Balikesir" style="height: 200px; object-fit: cover;">
                                    <div class="card-body">
                                        <h5 class="card-title text-primary">Balikesir</h5>
                                        <p class="card-text">Kazdağı Milli Parkı, Şeytan Sofrası ve Ayvalık Adaları ile doğal güzelliklerin merkezi.</p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <small class="text-muted"><i class="fas fa-map-marker-alt"></i> Marmara Bölgesi</small>
                                            <button class="btn btn-sm btn-outline-primary" onclick="showCityInfo('Balikesir')">Detaylar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Bitlis -->
<div class="col-md-4 mb-4">
    <div class="card h-100 border-0 shadow-sm">
        <img src="view/images/bitlis.jpg" class="card-img-top" alt="Bitlis" style="height: 200px; object-fit: cover;">
        <div class="card-body">
            <h5 class="card-title text-primary">Bitlis</h5>
            <p class="card-text">Nemrut Krater Gölü, Ahlat Selçuklu Mezarlığı ve tarihi kaleleriyle doğa ve tarihin iç içe geçtiği bir şehir.</p>
            <div class="d-flex justify-content-between align-items-center">
                <small class="text-muted"><i class="fas fa-map-marker-alt"></i> Doğu Anadolu Bölgesi</small>
                <button class="btn btn-sm btn-outline-primary" onclick="showCityInfo('Bitlis')">Detaylar</button>
            </div>
        </div>
    </div>
</div>

                            <!-- Zonguldak -->
                            <div class="col-md-4 mb-4">
                                <div class="card h-100 border-0 shadow-sm">
                                    <img src="view/images/zonguldak.jpg" class="card-img-top" alt="Zonguldak" style="height: 200px; object-fit: cover;">
                                    <div class="card-body">
                                        <h5 class="card-title text-primary">Zonguldak</h5>
                                        <p class="card-text">Gökgöl Mağarası ve Kapuz Plajı ile doğal güzelliklerin buluştuğu şehir.</p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <small class="text-muted"><i class="fas fa-map-marker-alt"></i> Karadeniz Bölgesi</small>
                                            <button class="btn btn-sm btn-outline-primary" onclick="showCityInfo('Zonguldak')">Detaylar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Aydın -->
                            <div class="col-md-4 mb-4">
                                <div class="card h-100 border-0 shadow-sm">
                                    <img src="view/images/Aydın.jpg" class="card-img-top" alt="Aydın" style="height: 200px; object-fit: cover;">
                                    <div class="card-body">
                                        <h5 class="card-title text-primary">Aydın</h5>
                                        <p class="card-text">Efes Antik Kenti ve Dilek Yarımadası ile tarih ve doğanın buluştuğu yer.</p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <small class="text-muted"><i class="fas fa-map-marker-alt"></i> Ege Bölgesi</small>
                                            <button class="btn btn-sm btn-outline-primary" onclick="showCityInfo('Aydin')">Detaylar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Ardahan -->
                            <div class="col-md-4 mb-4">
                                <div class="card h-100 border-0 shadow-sm">
                                    <img src="view/images/ardahan.jpg" class="card-img-top" alt="Ardahan" style="height: 200px; object-fit: cover;">
                                    <div class="card-body">
                                        <h5 class="card-title text-primary">Ardahan</h5>
                                        <p class="card-text">Çıldır Gölü ve Posof Vadisi ile doğal güzelliklerin başkenti.</p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <small class="text-muted"><i class="fas fa-map-marker-alt"></i> Doğu Anadolu Bölgesi</small>
                                            <button class="btn btn-sm btn-outline-primary" onclick="showCityInfo('Ardahan')">Detaylar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Elazığ -->
<div class="col-md-4 mb-4">
    <div class="card h-100 border-0 shadow-sm">
        <img src="view/images/elazig.jpg" class="card-img-top" alt="Elazığ" style="height: 200px; object-fit: cover;">
        <div class="card-body">
            <h5 class="card-title text-primary">Elazığ</h5>
            <p class="card-text">Harput Kalesi, Hazar Gölü ve zengin kültürel mirasıyla tarihi ve doğal güzellikleri bir arada sunar.</p>
            <div class="d-flex justify-content-between align-items-center">
                <small class="text-muted"><i class="fas fa-map-marker-alt"></i> Doğu Anadolu Bölgesi</small>
                <button class="btn btn-sm btn-outline-primary" onclick="showCityInfo('Elazığ')">Detaylar</button>
            </div>
        </div>
    </div>
</div>
<!-- Kahramanmaraş -->
<div class="col-md-4 mb-4">
    <div class="card h-100 border-0 shadow-sm">
        <img src="view/images/kahramanmaras.jpg" class="card-img-top" alt="Kahramanmaraş" style="height: 200px; object-fit: cover;">
        <div class="card-body">
            <h5 class="card-title text-primary">Kahramanmaraş</h5>
            <p class="card-text">Kahramanmaraş, Akdeniz Bölgesi'nin önemli şehirlerinden biridir. Maraş dondurması, tarihi dokusu ve zengin kültürüyle öne çıkar. Tarihi ve doğal güzellikleriyle ziyaretçilerini bekliyor.</p>
            <div class="d-flex justify-content-between align-items-center">
                <small class="text-muted"><i class="fas fa-map-marker-alt"></i> Akdeniz Bölgesi</small>
                <button class="btn btn-sm btn-outline-primary" onclick="showCityInfo('Kahramanmaras')">Detaylar</button>
            </div>
        </div>
    </div>
</div>

<!-- Konya -->
<div class="col-md-4 mb-4">
    <div class="card h-100 border-0 shadow-sm">
        <img src="view/images/konya.jpg" class="card-img-top" alt="Konya" style="height: 200px; object-fit: cover;">
        <div class="card-body">
            <h5 class="card-title text-primary">Konya</h5>
            <p class="card-text">Konya, İç Anadolu Bölgesi'nin önemli şehirlerinden biridir. Mevlana'nın şehri olarak bilinen Konya, Selçuklu mirası ve zengin kültürel değerleriyle öne çıkar.</p>
            <div class="d-flex justify-content-between align-items-center">
                <small class="text-muted"><i class="fas fa-map-marker-alt"></i> İç Anadolu Bölgesi</small>
                <button class="btn btn-sm btn-outline-primary" onclick="showCityInfo('Konya')">Detaylar</button>
            </div>
        </div>
    </div>
</div>

                            <!-- Artvin -->
                            <div class="col-md-4 mb-4">
                                <div class="card h-100 border-0 shadow-sm">
                                    <img src="view/images/artvin.jpg" class="card-img-top" alt="Artvin" style="height: 200px; object-fit: cover;">
                                    <div class="card-body">
                                        <h5 class="card-title text-primary">Artvin</h5>
                                        <p class="card-text">Kaçkar Dağları ve Yusufeli Vadisi ile doğanın kalbi.</p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <small class="text-muted"><i class="fas fa-map-marker-alt"></i> Karadeniz Bölgesi</small>
                                            <button class="btn btn-sm btn-outline-primary" onclick="showCityInfo('Artvin')">Detaylar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Samsun -->
                            <div class="col-md-4 mb-4">
                                <div class="card h-100 border-0 shadow-sm">
                                    <img src="view/images/samsun.jpeg" class="card-img-top" alt="Samsun" style="height: 200px; object-fit: cover;">
                                    <div class="card-body">
                                        <h5 class="card-title text-primary">Samsun</h5>
                                        <p class="card-text">Samsun, Karadeniz Bölgesi'nin önemli şehirlerinden biridir. Atatürk'ün Kurtuluş Savaşı'nı başlattığı şehir olarak tarihi öneme sahiptir. Doğal güzellikleri ve kültürel zenginliğiyle öne çıkar.</p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <small class="text-muted"><i class="fas fa-map-marker-alt"></i> Karadeniz Bölgesi</small>
                                            <button class="btn btn-sm btn-outline-primary" onclick="showCityInfo('Samsun')">Detaylar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Yozgat -->
                            <div class="col-md-4 mb-4">
                                <div class="card h-100 border-0 shadow-sm">
                                    <img src="view/images/Yozgat.jpeg" class="card-img-top" alt="Yozgat" style="height: 200px; object-fit: cover;">
                                    <div class="card-body">
                                        <h5 class="card-title text-primary">Yozgat</h5>
                                        <p class="card-text">Yozgat, İç Anadolu Bölgesi'nin önemli şehirlerinden biridir. Çamlık Milli Parkı, tarihi yapıları ve zengin kültürel mirasıyla öne çıkar. Doğal güzellikleri ve tarihi dokusuyla ziyaretçilerini bekliyor.</p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <small class="text-muted"><i class="fas fa-map-marker-alt"></i> İç Anadolu Bölgesi</small>
                                            <button class="btn btn-sm btn-outline-primary" onclick="showCityInfo('Yozgat')">Detaylar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Sidebar -->
            <div class="col-md-4">
                <!-- Deneyim Paylaşma Kartı -->
                <div class="card">
                    <div class="card-header bg-gradient text-white" style="background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%);">
                        <h5 class="mb-0"><i class="fas fa-share-alt"></i> Deneyimlerimi Paylaş</h5>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-4">
                            <img src="view/images/ntv1.jpg" alt="Deneyim Paylaş" class="img-fluid rounded mb-3" style="max-height: 400px; width: auto;">
                            <p class="card-text">Seyahat deneyimlerinizi diğer gezginlerle paylaşın, onların da sizin deneyimlerinizden faydalanmasını sağlayın!</p>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#shareExperienceModal">
                                <img src="view/images/ntv.jpg" alt="Deneyim Paylaş" class="img-fluid rounded mb-3" style="max-height: 100px; width: auto;">
                                <i class="fas fa-pen-fancy me-2"></i>Yeni Deneyim Paylaş
                            </button>
                            <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#myExperiencesModal">
                                <i class="fas fa-history me-2"></i>Deneyimlerimi Görüntüle
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Deneyim Paylaşma Modal -->
    <div class="modal fade" id="shareExperienceModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-pen-fancy me-2"></i>
                        Seyahat Deneyiminizi Paylaşın
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="experienceForm">
                        <!-- Şehir ve Tarih Seçimi -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label"><i class="fas fa-city me-2"></i>Şehir</label>
                                <select class="form-select" required>
                                    <option value="">Şehir Seçin</option>
                                    <option value="Konya">Konya</option>
                                    <option value="Balikesir">Balıkesir</option>
                                    <option value="Bitlis">Bitlis</option>
                                    <option value="Zonguldak">Zonguldak</option>
                                    <option value="Aydin">Aydın</option>
                                    <option value="Ardahan">Ardahan</option>
                                    <option value="Elazig">Elazığ</option>
                                   
                                    <option value="Kahramanmaras">Kahramanmaraş</option>
                                    <option value="Samsun">Samsun</option>
                                    <option value="Yozgat">Yozgat</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label"><i class="fas fa-calendar-alt me-2"></i>Ziyaret Tarihi</label>
                                <input type="date" class="form-control" required>
                            </div>
                        </div>

                        <!-- Başlık ve Kategori -->
                        <div class="row mb-4">
                            <div class="col-md-8">
                                <label class="form-label"><i class="fas fa-heading me-2"></i>Başlık</label>
                                <input type="text" class="form-control" placeholder="Deneyiminize kısa ve çarpıcı bir başlık verin" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label"><i class="fas fa-tags me-2"></i>Kategori</label>
                                <select class="form-select" required>
                                    <option value="">Kategori Seçin</option>
                                    <option value="tarihi">Tarihi Gezi</option>
                                    <option value="doga">Doğa Gezisi</option>
                                    <option value="kultur">Kültür Turu</option>
                                    <option value="yemek">Yemek Turu</option>
                                    <option value="macera">Macera Turu</option>
                                </select>
                            </div>
                        </div>

                        <!-- Deneyim Detayları -->
                        <div class="mb-4">
                            <label class="form-label"><i class="fas fa-book-open me-2"></i>Deneyiminiz</label>
                            <div class="form-floating">
                                <textarea class="form-control" id="experienceText" style="height: 200px" placeholder="Seyahat deneyiminizi detaylı bir şekilde anlatın..." required></textarea>
                                <label for="experienceText">Deneyiminizi buraya yazın...</label>
                            </div>
                            <div class="form-text">
                                <i class="fas fa-info-circle me-1"></i>
                                Deneyiminizi anlatırken şunlara değinmeyi unutmayın:
                                <ul class="mt-2">
                                    <li>Gezdiğiniz yerler ve gördüğünüz şeyler</li>
                                    <li>Yaşadığınız ilginç anılar</li>
                                    <li>Önerileriniz ve tavsiyeleriniz</li>
                                    <li>Dikkat edilmesi gereken noktalar</li>
                                </ul>
                            </div>
                        </div>

                        <!-- Konaklama ve Yemek -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="card h-100">
                                    <div class="card-header bg-light">
                                        <label class="form-label mb-0"><i class="fas fa-hotel me-2"></i>Konaklama Bilgileri</label>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <input type="text" class="form-control" placeholder="Kaldığınız otel veya pansiyon">
                                        </div>
                                        <div class="mb-3">
                                            <input type="number" class="form-control" placeholder="Gecelik fiyat (TL)">
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="recommendStay">
                                            <label class="form-check-label" for="recommendStay">
                                                Bu konaklama yerini öneriyorum
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card h-100">
                                    <div class="card-header bg-light">
                                        <label class="form-label mb-0"><i class="fas fa-utensils me-2"></i>Yemek Mekanları</label>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <input type="text" class="form-control" placeholder="Yemek yediğiniz restoran">
                                        </div>
                                        <div class="mb-3">
                                            <input type="text" class="form-control" placeholder="Yediğiniz yemekler">
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="recommendFood">
                                            <label class="form-check-label" for="recommendFood">
                                                Bu mekanı öneriyorum
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Fotoğraflar -->
                        <div class="card mb-4">
                            <div class="card-header bg-light">
                                <label class="form-label mb-0"><i class="fas fa-images me-2"></i>Fotoğraflar</label>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <input type="file" class="form-control" multiple accept="image/*" id="experiencePhotos">
                                    <div class="form-text">En fazla 5 fotoğraf yükleyebilirsiniz. Her fotoğraf en fazla 5MB olmalıdır.</div>
                                </div>
                                <div class="row" id="photoPreview">
                                    <!-- Fotoğraf önizlemeleri buraya gelecek -->
                                </div>
                            </div>
                        </div>

                        <!-- Değerlendirme -->
                        <div class="card mb-4">
                            <div class="card-header bg-light">
                                <label class="form-label mb-0"><i class="fas fa-star me-2"></i>Değerlendirmeniz</label>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Genel Puan</label>
                                        <div class="rating">
                                            <i class="fas fa-star" data-rating="1"></i>
                                            <i class="fas fa-star" data-rating="2"></i>
                                            <i class="fas fa-star" data-rating="3"></i>
                                            <i class="fas fa-star" data-rating="4"></i>
                                            <i class="fas fa-star" data-rating="5"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Konaklama</label>
                                        <div class="rating">
                                            <i class="fas fa-star" data-rating="1"></i>
                                            <i class="fas fa-star" data-rating="2"></i>
                                            <i class="fas fa-star" data-rating="3"></i>
                                            <i class="fas fa-star" data-rating="4"></i>
                                            <i class="fas fa-star" data-rating="5"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Yemek</label>
                                        <div class="rating">
                                            <i class="fas fa-star" data-rating="1"></i>
                                            <i class="fas fa-star" data-rating="2"></i>
                                            <i class="fas fa-star" data-rating="3"></i>
                                            <i class="fas fa-star" data-rating="4"></i>
                                            <i class="fas fa-star" data-rating="5"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Etiketler ve Gizlilik -->
                        <div class="row mb-4">
                            <div class="col-md-8">
                                <label class="form-label"><i class="fas fa-tags me-2"></i>Etiketler</label>
                                <input type="text" class="form-control" placeholder="Örn: tarihi yerler, doğa, yemek (virgülle ayırın)">
                                <div class="form-text">Etiketler, deneyiminizin daha kolay bulunmasını sağlar.</div>
                            </div>
                            <div class="col-md-4">
                                <div class="card h-100">
                                    <div class="card-header bg-light">
                                        <label class="form-label mb-0"><i class="fas fa-eye me-2"></i>Gizlilik</label>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="anonymousCheck">
                                            <label class="form-check-label" for="anonymousCheck">
                                                Anonim olarak paylaş
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="privateCheck">
                                            <label class="form-check-label" for="privateCheck">
                                                Sadece arkadaşlarımla paylaş
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-paper-plane me-2"></i>Deneyimi Paylaş
                            </button>
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                <i class="fas fa-times me-2"></i>İptal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Deneyimlerimi Görüntüle Modal -->
    <div class="modal fade" id="myExperiencesModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-gradient text-white" style="background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%);">
                    <h5 class="modal-title"><i class="fas fa-history me-2"></i>Deneyimlerim</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="list-group">
                        <!-- Örnek deneyim kartları -->
                        <div class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1">Konya'da Mevlana'yı Keşfetmek</h5>
                                <small class="text-muted">3 gün önce</small>
                            </div>
                            <p class="mb-1">Mevlana Müzesi'ni ziyaret ettim ve tarihi atmosferi soludum...</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">Konya</small>
                                <div class="btn-group">
                                    <button class="btn btn-sm btn-outline-primary">Düzenle</button>
                                    <button class="btn btn-sm btn-outline-danger">Sil</button>
                                </div>
                            </div>
                        </div>
                        <!-- Diğer deneyimler buraya eklenecek -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Şehir Detayları Modal -->
    <div class="modal fade" id="cityDetailsModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-gradient text-white" style="background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%);">
                    <h5 class="modal-title" id="cityModalTitle">Şehir Detayları</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <img id="cityDetailImage" src="" class="img-fluid rounded mb-3" alt="Şehir Görseli">
                        </div>
                        <div class="col-md-6">
                            <div id="cityDetailContent">
                                <!-- İçerik dinamik olarak doldurulacak -->
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-12">
                            <h5>Öne Çıkan Yerler</h5>
                            <div id="cityPlaces" class="row">
                                <!-- Yerler dinamik olarak doldurulacak -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <!-- Custom JavaScript -->
    <script src="/seyahat/assets/harita.js"></script>

    <script>
        // Mevcut scriptler
        // ... existing code ...

        // Fotoğraf önizleme
        document.getElementById('experiencePhotos').addEventListener('change', function(e) {
            const preview = document.getElementById('photoPreview');
            preview.innerHTML = '';
            preview.className = 'photo-preview';
            
            if (this.files) {
                Array.from(this.files).forEach(file => {
                    if (file.type.startsWith('image/')) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const img = document.createElement('img');
                            img.src = e.target.result;
                            img.title = file.name;
                            preview.appendChild(img);
                        }
                        reader.readAsDataURL(file);
                    }
                });
            }
        });

        // Yıldız derecelendirme sistemi
        document.querySelectorAll('.rating').forEach(ratingContainer => {
            const stars = ratingContainer.querySelectorAll('.fas');
            stars.forEach(star => {
                star.addEventListener('click', function() {
                    const rating = this.getAttribute('data-rating');
                    stars.forEach(s => {
                        if (s.getAttribute('data-rating') <= rating) {
                            s.classList.add('active');
                        } else {
                            s.classList.remove('active');
                        }
                    });
                });
            });
        });

        // Form gönderimi
        document.getElementById('experienceForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const submitBtn = this.querySelector('button[type="submit"]');
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Paylaşılıyor...';
            submitBtn.disabled = true;

            // Simüle edilmiş form gönderimi
            setTimeout(() => {
                submitBtn.innerHTML = '<i class="fas fa-check me-2"></i>Başarıyla Paylaşıldı!';
                setTimeout(() => {
                    $('#shareExperienceModal').modal('hide');
                    submitBtn.innerHTML = '<i class="fas fa-paper-plane me-2"></i>Deneyimi Paylaş';
                    submitBtn.disabled = false;
                }, 1000);
            }, 2000);
        });

        // Çıkış fonksiyonu
        function exitApp() {
            if (confirm('Uygulamadan çıkmak istediğinizden emin misiniz?')) {
                window.close();
                // Eğer window.close() çalışmazsa (tarayıcı güvenlik politikaları nedeniyle)
                // kullanıcıyı ana sayfaya yönlendir
                window.location.href = 'about:blank';
            }
        }

        // Gezdiklerim fonksiyonu
        function showMyTravels() {
            // Yeni pencerede gezi haritası sayfasını aç
            const travelMapWindow = window.open('gezi_haritam.html', '_blank', 'width=1200,height=800');
            if (travelMapWindow) {
                travelMapWindow.focus();
            } else {
                alert('Pop-up penceresi engellendi. Lütfen tarayıcı ayarlarınızı kontrol edin.');
            }
        }

        // Şehir detaylarını gösterme fonksiyonu
        function showCityInfo(cityName) {
            const cityDetails = {
                'Balikesir': {
                    title: 'Balıkesir Gezi Rehberi',
                    image: 'view/images/balikesir.jpg',
                    description: `
                        <div class="mb-4">
                            <h4>Balıkesir</h4>
                            <p>Balıkesir, Marmara ve Ege Bölgeleri'nin kesişiminde yer alan, hem deniz hem de doğal güzellikleriyle öne çıkan bir şehirdir. Kazdağı Milli Parkı, Şeytan Sofrası ve Ayvalık Adaları gibi doğal güzellikleriyle ünlüdür.</p>
                        
                            <h5 class="text-primary mt-4">Tarihi Yerler</h5>
                            <ul class="list-unstyled">
                                <li><i class="fas fa-check-circle text-success me-2"></i>Zağnos Paşa Camii - Osmanlı dönemi camisi</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>Saat Kulesi - Şehrin simgesi</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>Karesi Beyliği Müzesi - Tarihi eserler</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>Ayvalık Tarihi Evleri - Osmanlı mimarisi</li>
                            </ul>

                            <h5 class="text-primary mt-4">Doğal Güzellikler</h5>
                            <ul class="list-unstyled">
                                <li><i class="fas fa-check-circle text-success me-2"></i>Kazdağı Milli Parkı - Doğal güzellikler</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>Şeytan Sofrası - Panoramik manzara</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>Ayvalık Adaları - Deniz turizmi</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>Edremit Körfezi - Plajlar ve koylar</li>
                            </ul>

                            <h5 class="text-primary mt-4">Yerel Lezzetler</h5>
                            <ul class="list-unstyled">
                                <li><i class="fas fa-check-circle text-success me-2"></i>Balıkesir Kaymaklısı - Tatlı</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>Höşmerim - Yöresel tatlı</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>Susurluk Ayranı - Meşhur içecek</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>Balıkesir Mantısı - El açması mantı</li>
                            </ul>

                            <h5 class="text-primary mt-4">Önemli Telefonlar</h5>
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <tr><td><strong>Valilik:</strong></td><td>444 1 111</td></tr>
                                    <tr><td><strong>Belediye:</strong></td><td>444 2 222</td></tr>
                                    <tr><td><strong>Hastane:</strong></td><td>444 3 333</td></tr>
                                    <tr><td><strong>Polis:</strong></td><td>444 4 444</td></tr>
                                </table>
                            </div>
                        </div>
                    `,
                    places: [
                        {
                            name: 'Kazdağı Milli Parkı',
                            image: 'view/images/kazdagi.jpeg',
                            description: 'Doğal güzellikleri ve yürüyüş parkurlarıyla ünlü milli park.'
                        },
                        {
                            name: 'Şeytan Sofrası',
                            image: 'view/images/seyton.jpeg',
                            description: 'Ayvalık\'ın en yüksek noktasından muhteşem körfez manzarası.'
                        },
                        {
                            name: 'Ayvalık Adaları',
                            image: 'view/images/ayvalik.jpeg',
                            description: 'Temiz denizi ve doğal güzellikleriyle ünlü adalar.'
                        }
                    ]
                },
                'Bitlis': {
                    title: 'Bitlis Gezi Rehberi',
                    image: 'view/images/bitlis.jpg',
                    description: `
                        <div class="mb-4">
                            <h4>Bitlis</h4>
                            <p>Bitlis, Doğu Anadolu Bölgesi'nde yer alan, tarihi ve doğal güzellikleriyle öne çıkan bir şehirdir. Nemrut Krater Gölü, Ahlat Selçuklu Mezarlığı ve tarihi kaleleriyle ünlüdür.</p>
                        
                            <h5 class="text-primary mt-4">Tarihi Yerler</h5>
                            <ul class="list-unstyled">
                                <li><i class="fas fa-check-circle text-success me-2"></i>Bitlis Kalesi - Tarihi kale</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>Ahlat Selçuklu Mezarlığı - UNESCO Dünya Mirası Geçici Listesi'nde</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>İhlasiye Medresesi - Selçuklu dönemi medresesi</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>Şerefiye Camii - Osmanlı dönemi camisi</li>
                            </ul>

                            <h5 class="text-primary mt-4">Doğal Güzellikler</h5>
                            <ul class="list-unstyled">
                                <li><i class="fas fa-check-circle text-success me-2"></i>Nemrut Krater Gölü - Volkanik göl</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>Van Gölü - Türkiye\'nin en büyük gölü</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>Nemrut Dağı - Volkanik dağ</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>Narlıdere Vadisi - Doğal güzellik</li>
                            </ul>

                            <h5 class="text-primary mt-4">Yerel Lezzetler</h5>
                            <ul class="list-unstyled">
                                <li><i class="fas fa-check-circle text-success me-2"></i>Bitlis Köftesi - Yöresel köfte</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>Büryan Kebabı - Özel pişirme yöntemi</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>Katık Aşı - Geleneksel çorba</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>Bitlis Balı - Doğal bal</li>
                            </ul>

                            <h5 class="text-primary mt-4">Önemli Telefonlar</h5>
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <tr><td><strong>Valilik:</strong></td><td>444 1 111</td></tr>
                                    <tr><td><strong>Belediye:</strong></td><td>444 2 222</td></tr>
                                    <tr><td><strong>Hastane:</strong></td><td>444 3 333</td></tr>
                                    <tr><td><strong>Polis:</strong></td><td>444 4 444</td></tr>
                                </table>
                            </div>
                        </div>
                    `,
                    places: [
                        {
                            name: 'Nemrut Krater Gölü',
                            image: 'view/images/nemrut.jpeg',
                            description: 'Volkanik patlama sonucu oluşan krater gölü.'
                        },
                        {
                            name: 'Ahlat Selçuklu Mezarlığı',
                            image: 'view/images/ahlat.jpeg',
                            description: 'UNESCO Dünya Mirası Geçici Listesi\'nde yer alan tarihi mezarlık.'
                        },
                        {
                            name: 'Bitlis Kalesi',
                            image: 'view/images/bitliskale.jpeg',
                            description: 'Şehrin merkezinde yer alan tarihi kale.'
                        }
                    ]
                },
                'Zonguldak': {
                    title: 'Zonguldak Gezi Rehberi',
                    image: 'view/images/zonguldak.jpg',
                    description: `
                        <div class="mb-4">
                            <h4>Zonguldak</h4>
                            <p>Zonguldak, Karadeniz Bölgesi'nin önemli şehirlerinden biridir. Gökgöl Mağarası, Kapuz Plajı ve madencilik tarihiyle öne çıkar. Doğal güzellikleri ve tarihi yapılarıyla ziyaretçilerini bekliyor.</p>
                        
                            <h5 class="text-primary mt-4">Tarihi Yerler</h5>
                            <ul class="list-unstyled">
                                <li><i class="fas fa-check-circle text-success me-2"></i>Maden Müzesi - Madencilik tarihi</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>Kozlu Maden Şehitliği - Tarihi anıt</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>Uzun Mehmet Anıtı - Tarihi anıt</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>Kilimli Tarihi Evleri - Osmanlı mimarisi</li>
                            </ul>

                            <h5 class="text-primary mt-4">Doğal Güzellikler</h5>
                            <ul class="list-unstyled">
                                <li><i class="fas fa-check-circle text-success me-2"></i>Gökgöl Mağarası - Doğal mağara</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>Kapuz Plajı - Doğal plaj</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>Harmankaya Şelalesi - Doğal şelale</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>Bostanbükü Tabiat Parkı - Doğal güzellik</li>
                            </ul>

                            <h5 class="text-primary mt-4">Yerel Lezzetler</h5>
                            <ul class="list-unstyled">
                                <li><i class="fas fa-check-circle text-success me-2"></i>Malak - Yöresel hamur işi</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>Uğmaç Çorbası - Geleneksel çorba</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>Keşkek - Yöresel yemek</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>Mancar Yemeği - Yöresel ot yemeği</li>
                            </ul>

                            <h5 class="text-primary mt-4">Önemli Telefonlar</h5>
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <tr><td><strong>Valilik:</strong></td><td>444 1 111</td></tr>
                                    <tr><td><strong>Belediye:</strong></td><td>444 2 222</td></tr>
                                    <tr><td><strong>Hastane:</strong></td><td>444 3 333</td></tr>
                                    <tr><td><strong>Polis:</strong></td><td>444 4 444</td></tr>
                                </table>
                            </div>
                        </div>
                    `,
                    places: [
                        {
                            name: 'Gökgöl Mağarası',
                            image: 'view/images/gokgol.jpeg',
                            description: 'Doğal oluşumlu mağara, sarkıt ve dikitleriyle ünlü.'
                        },
                        {
                            name: 'Kapuz Plajı',
                            image: 'view/images/kapuz.jpeg',
                            description: 'Temiz denizi ve doğal güzelliğiyle ünlü plaj.'
                        },
                        {
                            name: 'Maden Müzesi',
                            image: 'view/images/maden.jpeg',
                            description: 'Zonguldak\'ın madencilik tarihini yansıtan müze.'
                        }
                    ]
                },
                'Aydin': {
                    title: 'Aydın Gezi Rehberi',
                    image: 'view/images/Aydın.jpg',
                    description: `
                        <div class="mb-4">
                            <h4>Aydın</h4>
                            <p>Aydın, Ege Bölgesi'nin önemli şehirlerinden biridir. Efes Antik Kenti, Dilek Yarımadası ve zengin tarihi mirasıyla öne çıkar. Antik çağlardan günümüze uzanan tarihi ve doğal güzellikleriyle ziyaretçilerini bekliyor.</p>
                        
                            <h5 class="text-primary mt-4">Tarihi Yerler</h5>
                            <ul class="list-unstyled">
                                <li><i class="fas fa-check-circle text-success me-2"></i>Efes Antik Kenti - UNESCO Dünya Mirası</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>Milet Antik Kenti - Tarihi kent</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>Didim Apollon Tapınağı - Antik tapınak</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>Priene Antik Kenti - Tarihi kent</li>
                            </ul>

                            <h5 class="text-primary mt-4">Doğal Güzellikler</h5>
                            <ul class="list-unstyled">
                                <li><i class="fas fa-check-circle text-success me-2"></i>Dilek Yarımadası Milli Parkı - Doğal güzellik</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>Bafa Gölü - Doğal göl</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>Kuşadası Plajları - Deniz turizmi</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>Karahayıt Kaplıcaları - Termal turizm</li>
                            </ul>

                            <h5 class="text-primary mt-4">Yerel Lezzetler</h5>
                            <ul class="list-unstyled">
                                <li><i class="fas fa-check-circle text-success me-2"></i>Çine Köftesi - Yöresel köfte</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>İncir Dolması - Tatlı</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>Zeytinyağlı Yer Elması - Yöresel yemek</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>Kestane Şekeri - Tatlı</li>
                            </ul>

                            <h5 class="text-primary mt-4">Önemli Telefonlar</h5>
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <tr><td><strong>Valilik:</strong></td><td>444 1 111</td></tr>
                                    <tr><td><strong>Belediye:</strong></td><td>444 2 222</td></tr>
                                    <tr><td><strong>Hastane:</strong></td><td>444 3 333</td></tr>
                                    <tr><td><strong>Polis:</strong></td><td>444 4 444</td></tr>
                                </table>
                            </div>
                        </div>
                    `,
                    places: [
                        {
                            name: 'Efes Antik Kenti',
                            image: 'view/images/efes.jpeg',
                            description: 'UNESCO Dünya Mirası Listesi\'nde yer alan antik kent.'
                        },
                        {
                            name: 'Dilek Yarımadası',
                            image: 'view/images/dilek.jpeg',
                            description: 'Doğal güzellikleri ve plajlarıyla ünlü milli park.'
                        },
                        {
                            name: 'Didim Apollon Tapınağı',
                            image: 'view/images/didim.jpeg',
                            description: 'Antik dönemin en büyük tapınaklarından biri.'
                        }
                    ]
                },
                'Ardahan': {
                    title: 'Ardahan Gezi Rehberi',
                    image: 'view/images/ardahan.jpg',
                    description: `
                        <div class="mb-4">
                            <h4>Ardahan</h4>
                            <p>Ardahan, Doğu Anadolu Bölgesi'nin kuzeydoğusunda yer alan, doğal güzellikleri ve tarihi yapılarıyla öne çıkan bir şehirdir. Çıldır Gölü, Posof Vadisi ve yaylalarıyla ünlüdür.</p>
                        
                            <h5 class="text-primary mt-4">Tarihi Yerler</h5>
                            <ul class="list-unstyled">
                                <li><i class="fas fa-check-circle text-success me-2"></i>Ardahan Kalesi - Tarihi kale</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>Şeytan Kalesi - Tarihi kale</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>Kurtkale - Tarihi kale</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>Ardahan Müzesi - Tarihi eserler</li>
                            </ul>

                            <h5 class="text-primary mt-4">Doğal Güzellikler</h5>
                            <ul class="list-unstyled">
                                <li><i class="fas fa-check-circle text-success me-2"></i>Çıldır Gölü - Doğal göl</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>Posof Vadisi - Doğal güzellik</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>Yalnızçam Yaylası - Yayla turizmi</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>Aktaş Gölü - Doğal göl</li>
                            </ul>

                            <h5 class="text-primary mt-4">Yerel Lezzetler</h5>
                            <ul class="list-unstyled">
                                <li><i class="fas fa-check-circle text-success me-2"></i>Höşmerim - Yöresel tatlı</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>Kuymak - Yöresel yemek</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>Gendime Çorbası - Geleneksel çorba</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>Ardahan Balı - Doğal bal</li>
                            </ul>

                            <h5 class="text-primary mt-4">Önemli Telefonlar</h5>
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <tr><td><strong>Valilik:</strong></td><td>444 1 111</td></tr>
                                    <tr><td><strong>Belediye:</strong></td><td>444 2 222</td></tr>
                                    <tr><td><strong>Hastane:</strong></td><td>444 3 333</td></tr>
                                    <tr><td><strong>Polis:</strong></td><td>444 4 444</td></tr>
                                </table>
                            </div>
                        </div>
                    `,
                    places: [
                        {
                            name: 'Çıldır Gölü',
                            image: 'view/images/cildir.jpeg',
                            description: 'Kışın donan yüzeyiyle ünlü doğal göl.'
                        },
                        {
                            name: 'Posof Vadisi',
                            image: 'view/images/posof.jpeg',
                            description: 'Doğal güzellikleri ve yürüyüş parkurlarıyla ünlü vadi.'
                        },
                        {
                            name: 'Ardahan Kalesi',
                            image: 'view/images/ardahankale.jpeg',
                            description: 'Şehrin merkezinde yer alan tarihi kale.'
                        }
                    ]
                },
                'Elazig': {
                    title: 'Elazığ Gezi Rehberi',
                    image: 'view/images/elazig.jpg',
                    description: `
                        <div class="mb-4">
                            <h4>Elazığ</h4>
                            <p>Elazığ, Doğu Anadolu Bölgesi'nin önemli şehirlerinden biridir. Harput Kalesi, Hazar Gölü ve zengin kültürel mirasıyla öne çıkar. Tarihi ve doğal güzellikleriyle ziyaretçilerini bekliyor.</p>
                        
                            <h5 class="text-primary mt-4">Tarihi Yerler</h5>
                            <ul class="list-unstyled">
                                <li><i class="fas fa-check-circle text-success me-2"></i>Harput Kalesi - Tarihi kale</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>Ulu Camii - Selçuklu dönemi camisi</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>Meryem Ana Kilisesi - Tarihi kilise</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>Elazığ Müzesi - Tarihi eserler</li>
                            </ul>

                            <h5 class="text-primary mt-4">Doğal Güzellikler</h5>
                            <ul class="list-unstyled">
                                <li><i class="fas fa-check-circle text-success me-2"></i>Hazar Gölü - Doğal göl</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>Buzluk Mağarası - Doğal mağara</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>Keban Baraj Gölü - Yapay göl</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>Golan Kaplıcaları - Termal turizm</li>
                            </ul>

                            <h5 class="text-primary mt-4">Yerel Lezzetler</h5>
                            <ul class="list-unstyled">
                                <li><i class="fas fa-check-circle text-success me-2"></i>Elazığ Çorbası - Geleneksel çorba</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>İşkene - Yöresel yemek</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>Harput Köftesi - Yöresel köfte</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>Gömme - Yöresel tatlı</li>
                            </ul>

                            <h5 class="text-primary mt-4">Önemli Telefonlar</h5>
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <tr><td><strong>Valilik:</strong></td><td>444 1 111</td></tr>
                                    <tr><td><strong>Belediye:</strong></td><td>444 2 222</td></tr>
                                    <tr><td><strong>Hastane:</strong></td><td>444 3 333</td></tr>
                                    <tr><td><strong>Polis:</strong></td><td>444 4 444</td></tr>
                                </table>
                            </div>
                        </div>
                    `,
                    places: [
                        {
                            name: 'Harput Kalesi',
                            image: 'view/images/harput.jpeg',
                            description: 'Tarihi kale ve çevresindeki tarihi yapılar.'
                        },
                        {
                            name: 'Hazar Gölü',
                            image: 'view/images/hazar.jpeg',
                            description: 'Doğal güzelliği ve su sporlarıyla ünlü göl.'
                        },
                        {
                            name: 'Buzluk Mağarası',
                            image: 'view/images/buzluk.jpeg',
                            description: 'Yazın bile buz tutan doğal mağara.'
                        }
                    ]
                },
                'Konya': {
                    title: 'Konya Gezi Rehberi',
                    image: 'view/images/konya.jpg',
                    description: `
                        <div class="mb-4">
                            <h4>Konya</h4>
                            <p>Konya, İç Anadolu Bölgesi'nin önemli şehirlerinden biridir. Mevlana'nın şehri olarak bilinen Konya, Selçuklu mirası ve zengin kültürel değerleriyle öne çıkar.</p>
                        
                            <h5 class="text-primary mt-4">Tarihi Yerler</h5>
                            <ul class="list-unstyled">
                                <li><i class="fas fa-check-circle text-success me-2"></i>Mevlana Müzesi - Mevlevi kültürü</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>Alaaddin Camii - Selçuklu dönemi camisi</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>İnce Minareli Medrese - Selçuklu dönemi medresesi</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>Karatay Medresesi - Selçuklu dönemi medresesi</li>
                            </ul>

                            <h5 class="text-primary mt-4">Doğal Güzellikler</h5>
                            <ul class="list-unstyled">
                                <li><i class="fas fa-check-circle text-success me-2"></i>Meke Gölü - Volkanik göl</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>Tuz Gölü - Doğal göl</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>Meram Bağları - Doğal güzellik</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>Ilgın Termal Kaplıcaları - Termal turizm</li>
                            </ul>

                            <h5 class="text-primary mt-4">Yerel Lezzetler</h5>
                            <ul class="list-unstyled">
                                <li><i class="fas fa-check-circle text-success me-2"></i>Etli Ekmek - Yöresel yemek</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>Fırın Kebabı - Yöresel kebap</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>Kuzu Tandır - Yöresel et yemeği</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>Şekpare - Yöresel tatlı</li>
                            </ul>

                            <h5 class="text-primary mt-4">Önemli Telefonlar</h5>
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <tr><td><strong>Valilik:</strong></td><td>444 1 111</td></tr>
                                    <tr><td><strong>Belediye:</strong></td><td>444 2 222</td></tr>
                                    <tr><td><strong>Hastane:</strong></td><td>444 3 333</td></tr>
                                    <tr><td><strong>Polis:</strong></td><td>444 4 444</td></tr>
                                </table>
                            </div>
                        </div>
                    `,
                    places: [
                        {
                            name: 'Mevlana Müzesi',
                            image: 'view/images/mevlana.jpeg',
                            description: 'Mevlevi kültürünün merkezi, tarihi müze.'
                        },
                        {
                            name: 'Meke Gölü',
                            image: 'view/images/meke.jpeg',
                            description: 'Volkanik patlama sonucu oluşan krater gölü.'
                        },
                        {
                            name: 'Alaaddin Camii',
                            image: 'view/images/alaaddin.jpeg',
                            description: 'Selçuklu döneminin önemli camisi.'
                        }
                    ]
                },
                'Artvin': {
                    title: 'Artvin Gezi Rehberi',
                    image: 'view/images/artvin.jpg',
                    description: `
                        <div class="mb-4">
                            <h4>Artvin</h4>
                            <p>Artvin, Karadeniz Bölgesi'nin doğusunda yer alan, doğal güzellikleriyle öne çıkan bir şehirdir. Kaçkar Dağları, Yusufeli Vadisi ve yaylalarıyla ünlüdür.</p>
                        
                            <h5 class="text-primary mt-4">Tarihi Yerler</h5>
                            <ul class="list-unstyled">
                                <li><i class="fas fa-check-circle text-success me-2"></i>Artvin Kalesi - Tarihi kale</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>İşhan Kilisesi - Tarihi kilise</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>Ortacalar Camii - Tarihi cami</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>Artvin Müzesi - Tarihi eserler</li>
                            </ul>

                            <h5 class="text-primary mt-4">Doğal Güzellikler</h5>
                            <ul class="list-unstyled">
                                <li><i class="fas fa-check-circle text-success me-2"></i>Kaçkar Dağları - Doğal güzellik</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>Yusufeli Vadisi - Doğal güzellik</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>Karçal Dağları - Doğal güzellik</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>Şavşat Karagöl - Doğal göl</li>
                            </ul>

                            <h5 class="text-primary mt-4">Yerel Lezzetler</h5>
                            <ul class="list-unstyled">
                                <li><i class="fas fa-check-circle text-success me-2"></i>Muhlama - Yöresel yemek</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>Hamsi Tava - Yöresel balık yemeği</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>Kaysefe - Yöresel tatlı</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>Artvin Balı - Doğal bal</li>
                            </ul>

                            <h5 class="text-primary mt-4">Önemli Telefonlar</h5>
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <tr><td><strong>Valilik:</strong></td><td>444 1 111</td></tr>
                                    <tr><td><strong>Belediye:</strong></td><td>444 2 222</td></tr>
                                    <tr><td><strong>Hastane:</strong></td><td>444 3 333</td></tr>
                                    <tr><td><strong>Polis:</strong></td><td>444 4 444</td></tr>
                                </table>
                            </div>
                        </div>
                    `,
                    places: [
                        {
                            name: 'Kaçkar Dağları',
                            image: 'view/images/kackar.jpg',
                            description: 'Doğal güzellikleri ve yürüyüş parkurlarıyla ünlü dağlar.'
                        },
                        {
                            name: 'Yusufeli Vadisi',
                            image: 'view/images/yusufeli.jpg',
                            description: 'Doğal güzellikleri ve rafting parkurlarıyla ünlü vadi.'
                        },
                        {
                            name: 'Şavşat Karagöl',
                            image: 'view/images/karagol.jpg',
                            description: 'Doğal güzelliği ve piknik alanlarıyla ünlü göl.'
                        }
                    ]
                },
                'Kahramanmaras': {
                    title: 'Kahramanmaraş Gezi Rehberi',
                    image: 'view/images/kahramanmaras.jpg',
                    description: `
                        <div class="mb-4">
                            <h4>Kahramanmaraş</h4>
                            <p>Kahramanmaraş, Akdeniz Bölgesi'nin önemli şehirlerinden biridir. Maraş dondurması, tarihi dokusu ve zengin kültürüyle öne çıkar. Tarihi ve doğal güzellikleriyle ziyaretçilerini bekliyor.</p>
                        
                            <h5 class="text-primary mt-4">Tarihi Yerler</h5>
                            <ul class="list-unstyled">
                                <li><i class="fas fa-check-circle text-success me-2"></i>Kahramanmaraş Kalesi - Tarihi kale</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>Ulu Camii - Selçuklu dönemi camisi</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>Taş Medrese - Selçuklu dönemi medresesi</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>Kahramanmaraş Müzesi - Tarihi eserler</li>
                            </ul>

                            <h5 class="text-primary mt-4">Doğal Güzellikler</h5>
                            <ul class="list-unstyled">
                                <li><i class="fas fa-check-circle text-success me-2"></i>Tekir Yaylası - Doğal güzellik</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>Başkonuş Yaylası - Yayla turizmi</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>Menzelet Baraj Gölü - Doğal göl</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>Döngel Mağarası - Doğal mağara</li>
                            </ul>

                            <h5 class="text-primary mt-4">Yerel Lezzetler</h5>
                            <ul class="list-unstyled">
                                <li><i class="fas fa-check-circle text-success me-2"></i>Maraş Dondurması - Dünyaca ünlü dondurma</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>Tarhana Çorbası - Geleneksel çorba</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>Maraş Tava - Yöresel et yemeği</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>Maraş Biberi - Yöresel baharat</li>
                            </ul>

                            <h5 class="text-primary mt-4">Önemli Telefonlar</h5>
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <tr><td><strong>Valilik:</strong></td><td>444 1 111</td></tr>
                                    <tr><td><strong>Belediye:</strong></td><td>444 2 222</td></tr>
                                    <tr><td><strong>Hastane:</strong></td><td>444 3 333</td></tr>
                                    <tr><td><strong>Polis:</strong></td><td>444 4 444</td></tr>
                                </table>
                            </div>
                        </div>
                    `,
                    places: [
                        {
                            name: 'Kahramanmaraş Kalesi',
                            image: 'view/images/maraskale.jpeg',
                            description: 'Şehrin merkezinde yer alan tarihi kale.'
                        },
                        {
                            name: 'Tekir Yaylası',
                            image: 'view/images/tekir.jpeg',
                            description: 'Doğal güzellikleri ve piknik alanlarıyla ünlü yayla.'
                        },
                        {
                            name: 'Döngel Mağarası',
                            image: 'view/images/dongel.jpeg',
                            description: 'Doğal oluşumlu mağara, sarkıt ve dikitleriyle ünlü.'
                        }
                    ]
                },
                'Samsun': {
                    title: 'Samsun Gezi Rehberi',
                    image: 'view/images/samsun.jpeg',
                    description: `
                        <div class="mb-4">
                            <h4>Samsun</h4>
                            <p>Samsun, Karadeniz Bölgesi'nin önemli şehirlerinden biridir. Atatürk'ün Kurtuluş Savaşı'nı başlattığı şehir olarak tarihi öneme sahiptir. Doğal güzellikleri ve kültürel zenginliğiyle öne çıkar.</p>
                        
                            <h5 class="text-primary mt-4">Tarihi Yerler</h5>
                            <ul class="list-unstyled">
                                <li><i class="fas fa-check-circle text-success me-2"></i>Bandırma Vapuru Müzesi - Tarihi müze</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>Gazi Müzesi - Atatürk'ün kaldığı ev</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>Amisos Tepesi - Antik kent kalıntıları</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>Arkeoloji Müzesi - Tarihi eserler</li>
                            </ul>

                            <h5 class="text-primary mt-4">Doğal Güzellikler</h5>
                            <ul class="list-unstyled">
                                <li><i class="fas fa-check-circle text-success me-2"></i>Kızılırmak Deltası - Doğal güzellik</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>Ladik Gölü - Doğal göl</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>Kabaceviz Şelalesi - Doğal şelale</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>Akdağ Kayak Merkezi - Kış turizmi</li>
                            </ul>

                            <h5 class="text-primary mt-4">Yerel Lezzetler</h5>
                            <ul class="list-unstyled">
                                <li><i class="fas fa-check-circle text-success me-2"></i>Mantı - El açması mantı</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>Keşkek - Yöresel yemek</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>Pide - Yöresel hamur işi</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>Nokul - Yöresel tatlı</li>
                            </ul>

                            <h5 class="text-primary mt-4">Önemli Telefonlar</h5>
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <tr><td><strong>Valilik:</strong></td><td>444 1 111</td></tr>
                                    <tr><td><strong>Belediye:</strong></td><td>444 2 222</td></tr>
                                    <tr><td><strong>Hastane:</strong></td><td>444 3 333</td></tr>
                                    <tr><td><strong>Polis:</strong></td><td>444 4 444</td></tr>
                                </table>
                            </div>
                        </div>
                    `,
                    places: [
                        {
                            name: 'Bandırma Vapuru',
                            image: 'view/images/bandirma.jpeg',
                            description: 'Atatürk\'ün Samsun\'a çıktığı tarihi gemi.'
                        },
                        {
                            name: 'Kızılırmak Deltası',
                            image: 'view/images/kizilirmak.jpeg',
                            description: 'Doğal güzellikleri ve kuş türleriyle ünlü delta.'
                        },
                        {
                            name: 'Amisos Tepesi',
                            image: 'view/images/amisos.jpeg',
                            description: 'Antik kent kalıntıları ve manzarasıyla ünlü tepe.'
                        }
                    ]
                },
                'Yozgat': {
                    title: 'Yozgat Gezi Rehberi',
                    image: 'view/images/yozgat.jpeg',
                    description: `
                        <div class="mb-4">
                            <h4>Yozgat</h4>
                            <p>Yozgat, İç Anadolu Bölgesi'nin önemli şehirlerinden biridir. Çamlık Milli Parkı, tarihi yapıları ve zengin kültürel mirasıyla öne çıkar. Doğal güzellikleri ve tarihi dokusuyla ziyaretçilerini bekliyor.</p>
                        
                            <h5 class="text-primary mt-4">Tarihi Yerler</h5>
                            <ul class="list-unstyled">
                                <li><i class="fas fa-check-circle text-success me-2"></i>Yozgat Saat Kulesi - Şehrin simgesi</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>Nizamoğlu Konağı - Tarihi konak</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>Yozgat Müzesi - Tarihi eserler</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>Basilica Therma - Roma dönemi hamamı</li>
                            </ul>

                            <h5 class="text-primary mt-4">Doğal Güzellikler</h5>
                            <ul class="list-unstyled">
                                <li><i class="fas fa-check-circle text-success me-2"></i>Çamlık Milli Parkı - Doğal güzellik</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>Akdağmadeni Ormanları - Doğal güzellik</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>Kazankaya Kanyonu - Doğal güzellik</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>Şahmuratlı Göleti - Doğal göl</li>
                            </ul>

                            <h5 class="text-primary mt-4">Yerel Lezzetler</h5>
                            <ul class="list-unstyled">
                                <li><i class="fas fa-check-circle text-success me-2"></i>Testi Kebabı - Yöresel kebap</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>Arabaşı Çorbası - Geleneksel çorba</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>Madımak - Yöresel ot yemeği</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>Yozgat Tandır Kebabı - Yöresel et yemeği</li>
                            </ul>

                            <h5 class="text-primary mt-4">Önemli Telefonlar</h5>
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <tr><td><strong>Valilik:</strong></td><td>444 1 111</td></tr>
                                    <tr><td><strong>Belediye:</strong></td><td>444 2 222</td></tr>
                                    <tr><td><strong>Hastane:</strong></td><td>444 3 333</td></tr>
                                    <tr><td><strong>Polis:</strong></td><td>444 4 444</td></tr>
                                </table>
                            </div>
                        </div>
                    `,
                    places: [
                        {
                            name: 'Çamlık Milli Parkı',
                            image: 'view/images/camlik.jpeg',
                            description: 'Doğal güzellikleri ve yürüyüş parkurlarıyla ünlü milli park.'
                        },
                        {
                            name: 'Kazankaya Kanyonu',
                            image: 'view/images/kazankaya.jpeg',
                            description: 'Doğal güzellikleri ve manzarasıyla ünlü kanyon.'
                        },
                        {
                            name: 'Nizamoğlu Konağı',
                            image: 'view/images/nizamoglu.jpeg',
                            description: 'Tarihi konak ve müze.'
                        }
                    ]
                }
            };

            const city = cityDetails[cityName];
            if (city) {
                document.getElementById('cityModalTitle').textContent = city.title;
                document.getElementById('cityDetailImage').src = city.image;
                document.getElementById('cityDetailContent').innerHTML = city.description;
                
                const placesContainer = document.getElementById('cityPlaces');
                placesContainer.innerHTML = '';
                
                city.places.forEach(place => {
                    placesContainer.innerHTML += `
                        <div class="col-md-4 mb-3">
                            <div class="card h-100">
                                <img src="${place.image}" class="card-img-top" alt="${place.name}" style="height: 200px; object-fit: cover;">
                                <div class="card-body">
                                    <h6 class="card-title">${place.name}</h6>
                                    <p class="card-text">${place.description}</p>
                                </div>
                            </div>
                        </div>
                    `;
                });

                const cityModal = new bootstrap.Modal(document.getElementById('cityDetailsModal'));
                cityModal.show();
            }
        }
    </script>

    <!-- Gezdiklerim Modal -->
    <div class="modal fade" id="myTravelsModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-gradient text-white" style="background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%);">
                    <h5 class="modal-title"><i class="fas fa-map-marked-alt me-2"></i>Gezdiğim Yerler</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div id="travelMap" style="height: 400px; margin-bottom: 20px;"></div>
                    <div class="list-group">
                        <div class="list-group-item">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1">Ziyaret Edilen Şehirler</h5>
                                <span class="badge bg-primary rounded-pill">8</span>
                            </div>
                            <p class="mb-1">Toplam ziyaret edilen şehir sayısı</p>
                        </div>
                        <!-- Ziyaret edilen şehirler listesi buraya dinamik olarak eklenecek -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
