<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OKUVA - Kitap Keşfet, Oku, Paylaş</title>
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <?php
ob_start(); // Çıktı tamponlamayı başlatır
// ... Uygulamanın geri kalanı
?>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
        }
        
        /* HEADER STILI */
        .top-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 15px 0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .logo {
            font-size: 32px;
            font-weight: 700;
            letter-spacing: 2px;
            text-decoration: none;
            color: white;
            transition: all 0.3s;
        }
        
        .logo:hover {
            color: #ffd700;
            text-decoration: none;
            transform: scale(1.05);
        }
        
        .logo i {
            margin-right: 10px;
            font-size: 36px;
        }
        
        /* ARAMA ÇUBUĞU */
        .search-box {
            position: relative;
        }
        
        .search-box input {
            border-radius: 25px;
            padding: 12px 50px 12px 20px;
            border: none;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        .search-box button {
            position: absolute;
            right: 5px;
            top: 5px;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            border: none;
            background: #667eea;
            color: white;
            transition: all 0.3s;
        }
        
        .search-box button:hover {
            background: #764ba2;
            transform: rotate(15deg);
        }
        
        /* KULLANICI MENÜSÜ */
        .user-menu {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .user-menu a {
            color: white;
            text-decoration: none;
            padding: 8px 20px;
            border-radius: 20px;
            transition: all 0.3s;
            font-weight: 500;
        }
        
        .user-menu a:hover {
            background: rgba(255,255,255,0.2);
            transform: translateY(-2px);
        }
        
        .btn-login {
            background: white;
            color: #667eea;
        }
        
        .btn-login:hover {
            background: #ffd700;
            color: #333;
        }
        
        .btn-register {
            background: transparent;
            border: 2px solid white;
        }
        
        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
            background: rgba(255,255,255,0.2);
            padding: 8px 20px;
            border-radius: 25px;
        }
        
        .user-avatar {
            width: 35px;
            height: 35px;
            background: white;
            color: #667eea;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 16px;
        }
        
        /* NAVİGASYON MENÜSÜ */
        .main-nav {
            background: white;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            padding: 0;
        }
        
        .main-nav .navbar {
            padding: 10px 0;
        }
        
        .main-nav .nav-link {
            color: #333;
            font-weight: 500;
            padding: 10px 20px;
            transition: all 0.3s;
            border-radius: 5px;
            margin: 0 5px;
        }
        
        .main-nav .nav-link:hover {
            background: #667eea;
            color: white;
            transform: translateY(-2px);
        }
        
        .main-nav .nav-link i {
            margin-right: 8px;
        }
        
        /* DROPDOWN MENÜ */
        .dropdown-menu {
            border: none;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            border-radius: 10px;
        }
        
        .dropdown-item {
            padding: 10px 20px;
            transition: all 0.3s;
        }
        
        .dropdown-item:hover {
            background: #667eea;
            color: white;
        }
        
        /* RESPONSIVE */
        @media (max-width: 768px) {
            .logo {
                font-size: 24px;
            }
            
            .search-box {
                margin: 15px 0;
            }
            
            .user-menu {
                justify-content: center;
                margin-top: 15px;
            }
        }
    </style>
</head>
<body>

    <!-- ÜST HEADER -->
    <div class="top-header">
        <div class="container">
            <div class="row align-items-center">
                
                <!-- LOGO -->
                <div class="col-md-3">
                    <a href="index.php" class="logo">
                        <i class="fa fa-book"></i>OKUVA
                    </a>
                </div>
                
                <!-- ARAMA ÇUBUĞU -->
                <div class="col-md-5">
                    <div class="search-box">
                        <form action="index.php" method="GET">
                            <input type="hidden" name="sayfa" value="arama">
                            <input type="text" 
                                   class="form-control" 
                                   name="q" 
                                   placeholder="Kitap, yazar veya kategori ara...">
                            <button type="submit">
                                <i class="fa fa-search"></i>
                            </button>
                        </form>
                    </div>
                </div>
                
                <!-- KULLANICI MENÜ -->
                <div class="col-md-4">
                    <div class="user-menu">
                        <?php 
                            // Kullanıcı giriş yapmış mı kontrol ediyoruz
                            if (isset($_SESSION["kullanici_adi"])) 
                            {
                        ?>
                            <!-- GİRİŞ YAPMIŞ KULLANICI -->
                            <div class="user-info">
                                <div class="user-avatar">
                                    <?php echo strtoupper(substr($_SESSION["kullanici_adi"], 0, 1)); ?>
                                </div>
                                <span><?php echo htmlspecialchars($_SESSION["kullanici_adi"]); ?></span>
                            </div>
                            
                            <a href="index.php?sayfa=cikis" class="btn-login">
                                <i class="fa fa-sign-out"></i> Çıkış
                            </a>
                        <?php 
                            } 
                            else 
                            {
                        ?>
                            <!-- GİRİŞ YAPMAYAN KULLANICI -->
                            <a href="index.php?sayfa=login" class="btn-login">
                                <i class="fa fa-sign-in"></i> Giriş Yap
                            </a>
                            
                            <a href="index.php?sayfa=uyeol" class="btn-register">
                                <i class="fa fa-user-plus"></i> Üye Ol
                            </a>
                        <?php 
                            }
                        ?>
                    </div>
                </div>
                
            </div>
        </div>
    </div>

    <!-- ANA NAVİGASYON MENÜSÜ -->
    <div class="main-nav">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light">
                
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mainMenu">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="mainMenu">
                    <ul class="navbar-nav mr-auto">
                        
                        <li class="nav-item">
                            <a class="nav-link" href="index.php">
                                <i class="fa fa-home"></i> Ana Sayfa
                            </a>
                        </li>
                        
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="kitaplarMenu" data-toggle="dropdown">
                                <i class="fa fa-book"></i> Kitaplar
                            </a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="index.php?sayfa=tumkitaplar">
                                    <i class="fa fa-list"></i> Tüm Kitaplar
                                </a>
                                <a class="dropdown-item" href="index.php?sayfa=yeni">
                                    <i class="fa fa-star"></i> Yeni Çıkanlar
                                </a>
                                <a class="dropdown-item" href="index.php?sayfa=populer">
                                    <i class="fa fa-fire"></i> Popüler Kitaplar
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="index.php?sayfa=kategoriler">
                                    <i class="fa fa-tags"></i> Kategoriler
                                </a>
                            </div>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?sayfa=yazarlar">
                                <i class="fa fa-users"></i> Yazarlar
                            </a>
                        </li>
                        <?php 
                            // Sadece giriş yapan kullanıcılara gösterilen menüler
                            if (isset($_SESSION["kullanici_adi"])) 
                            {
                        ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="kitapligimMenu" data-toggle="dropdown">
                                    <i class="fa fa-bookmark"></i> Kitaplığım
                                </a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="index.php?sayfa=okuyorum">
                                        <i class="fa fa-book-open"></i> Şu An Okuyorum
                                    </a>
                                    <a class="dropdown-item" href="index.php?sayfa=okunacak">
                                        <i class="fa fa-clock-o"></i> Okunacaklar
                                    </a>
                                    <a class="dropdown-item" href="index.php?sayfa=okudum">
                                        <i class="fa fa-check-circle"></i> Okuduklarım
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="index.php?sayfa=favoriler">
                                        <i class="fa fa-heart"></i> Favorilerim
                                    </a>
                                </div>
                            </li>
                            
                            <li class="nav-item">
                                <a class="nav-link" href="index.php?sayfa=kitapekle">
                                    <i class="fa fa-plus-circle"></i> Kitap Ekle
                                </a>
                            </li>
                        <?php 
                            }
                        ?>
                        
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?sayfa=blog">
                                <i class="fa fa-newspaper-o"></i> Blog
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?sayfa=hakkimizda">
                                <i class="fa fa-info-circle"></i> Hakkımızda
                            </a>
                        </li>
                        
                    </ul>
                </div>
            </nav>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>