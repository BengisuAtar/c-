<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>OKUVA - Kitap Platformu</title>

  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="fontawesome/css/all.css">
  <link rel="stylesheet" href="css/animate.css">
  <link rel="stylesheet" href="owlcarousel/docs/assets/owlcarousel/assets/owl.carousel.min.css">
  <link rel="stylesheet" href="owlcarousel/docs/assets/owlcarousel/assets/owl.theme.default.min.css">

  <script src="ckeditor/ckeditor.js"></script>
  <script src="owlcarousel/docs/assets/vendors/jquery.min.js"></script>
  <script src="owlcarousel/docs/assets/owlcarousel/owl.carousel.js"></script>
  
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f8f5f2;
    }
    
    /* Modern Minimal Header */
    .site-header {
      background: white;
      border-bottom: 1px solid #e5e5e5;
      position: sticky;
      top: 0;
      z-index: 1000;
      box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }
    
    .header-container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 20px;
    }
    
    .header-content {
      display: flex;
      align-items: center;
      justify-content: space-between;
      height: 70px;
    }
    
    /* Logo */
    .site-logo {
      display: flex;
      align-items: center;
      text-decoration: none;
      gap: 12px;
    }
    
    .logo-img {
      width: 40px;
      height: 40px;
      background: linear-gradient(135deg, #8B4513, #DC143C);
      border-radius: 8px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-size: 20px;
    }
    
    .logo-text {
      font-size: 28px;
      font-weight: 700;
      color: #2c1810;
      letter-spacing: -0.5px;
    }
    
    /* Navigation */
    .main-menu {
      display: flex;
      list-style: none;
      gap: 8px;
      margin: 0;
      padding: 0;
    }
    
    .main-menu > li > a {
      display: flex;
      align-items: center;
      padding: 8px 16px;
      color: #4a4a4a;
      text-decoration: none;
      font-size: 15px;
      font-weight: 500;
      border-radius: 6px;
      transition: all 0.2s;
    }
    
    .main-menu > li > a:hover {
      background: #f5f0eb;
      color: #8B4513;
    }
    
    .main-menu > li > a i {
      margin-right: 6px;
      font-size: 14px;
    }
    
    /* Dropdown */
    .menu-dropdown {
      position: relative;
    }
    
    .dropdown-content {
      display: none;
      position: absolute;
      top: 100%;
      left: 0;
      background: white;
      min-width: 200px;
      box-shadow: 0 8px 24px rgba(0,0,0,0.12);
      border-radius: 8px;
      margin-top: 8px;
      padding: 8px;
    }
    
    .menu-dropdown:hover .dropdown-content {
      display: block;
    }
    
    .dropdown-content a {
      display: block;
      padding: 10px 14px;
      color: #4a4a4a;
      text-decoration: none;
      border-radius: 6px;
      font-size: 14px;
      transition: all 0.2s;
    }
    
    .dropdown-content a:hover {
      background: #f5f0eb;
      color: #8B4513;
      padding-left: 18px;
    }
    
    /* Header Actions */
    .header-actions {
      display: flex;
      align-items: center;
      gap: 12px;
    }
    
    .search-btn {
      width: 36px;
      height: 36px;
      border: none;
      background: #f5f0eb;
      border-radius: 50%;
      color: #8B4513;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: all 0.2s;
    }
    
    .search-btn:hover {
      background: #8B4513;
      color: white;
    }
    
    .header-btn {
      padding: 8px 18px;
      border-radius: 20px;
      text-decoration: none;
      font-size: 14px;
      font-weight: 500;
      transition: all 0.2s;
      border: none;
      cursor: pointer;
    }
    
    .btn-outline {
      background: white;
      color: #8B4513;
      border: 1.5px solid #8B4513;
    }
    
    .btn-outline:hover {
      background: #8B4513;
      color: white;
    }
    
    .btn-solid {
      background: linear-gradient(135deg, #8B4513, #DC143C);
      color: white;
      box-shadow: 0 2px 8px rgba(139, 69, 19, 0.2);
    }
    
    .btn-solid:hover {
      transform: translateY(-1px);
      box-shadow: 0 4px 12px rgba(139, 69, 19, 0.3);
    }
    
    .user-menu {
      position: relative;
    }
    
    .user-btn {
      display: flex;
      align-items: center;
      gap: 8px;
      padding: 6px 12px;
      background: #f5f0eb;
      border: none;
      border-radius: 20px;
      color: #2c1810;
      font-weight: 500;
      cursor: pointer;
      font-size: 14px;
    }
    
    .user-avatar {
      width: 28px;
      height: 28px;
      background: linear-gradient(135deg, #8B4513, #DC143C);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-size: 12px;
      font-weight: 600;
    }
    
    /* Mobile Menu */
    .mobile-toggle {
      display: none;
      width: 36px;
      height: 36px;
      border: none;
      background: #f5f0eb;
      border-radius: 8px;
      color: #8B4513;
      cursor: pointer;
      font-size: 18px;
    }
    
    /* Search Modal */
    .search-modal {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: rgba(0,0,0,0.7);
      z-index: 2000;
      align-items: flex-start;
      justify-content: center;
      padding-top: 100px;
    }
    
    .search-modal.active {
      display: flex;
    }
    
    .search-box {
      background: white;
      padding: 20px;
      border-radius: 12px;
      width: 90%;
      max-width: 600px;
      box-shadow: 0 20px 60px rgba(0,0,0,0.3);
    }
    
    .search-input-wrapper {
      position: relative;
    }
    
    .search-input {
      width: 100%;
      padding: 15px 50px 15px 20px;
      border: 2px solid #e5e5e5;
      border-radius: 10px;
      font-size: 16px;
      outline: none;
      transition: border 0.2s;
    }
    
    .search-input:focus {
      border-color: #8B4513;
    }
    
    .search-submit {
      position: absolute;
      right: 8px;
      top: 50%;
      transform: translateY(-50%);
      width: 40px;
      height: 40px;
      background: linear-gradient(135deg, #8B4513, #DC143C);
      border: none;
      border-radius: 8px;
      color: white;
      cursor: pointer;
    }
    
    .close-search {
      position: absolute;
      top: 20px;
      right: 20px;
      width: 32px;
      height: 32px;
      background: rgba(255,255,255,0.2);
      border: none;
      border-radius: 50%;
      color: white;
      cursor: pointer;
      font-size: 20px;
    }
    
    /* Responsive */
    @media (max-width: 991px) {
      .main-menu {
        display: none;
        position: absolute;
        top: 70px;
        left: 0;
        right: 0;
        background: white;
        flex-direction: column;
        padding: 20px;
        box-shadow: 0 8px 24px rgba(0,0,0,0.1);
        gap: 4px;
      }
      
      .main-menu.active {
        display: flex;
      }
      
      .main-menu > li > a {
        padding: 12px 16px;
      }
      
      .dropdown-content {
        position: static;
        box-shadow: none;
        margin: 8px 0 0 0;
        padding-left: 20px;
      }
      
      .menu-dropdown:hover .dropdown-content {
        display: none;
      }
      
      .menu-dropdown.active .dropdown-content {
        display: block;
      }
      
      .mobile-toggle {
        display: block;
      }
      
      .header-btn {
        padding: 6px 14px;
        font-size: 13px;
      }
      
      .logo-text {
        font-size: 22px;
      }
    }
    
    @media (max-width: 576px) {
      .header-content {
        height: 60px;
      }
      
      .logo-img {
        width: 35px;
        height: 35px;
        font-size: 18px;
      }
      
      .logo-text {
        font-size: 20px;
      }
      
      .btn-outline {
        display: none;
      }
    }
  </style>
</head>

<body>
  <!-- Header -->
  <header class="site-header">
    <div class="header-container">
      <div class="header-content">
        <!-- Logo -->
        <a href="index.php" class="site-logo">
          <div class="logo-img">
            <i class="fas fa-book"></i>
          </div>
          <span class="logo-text">OKUVA</span>
        </a>
        
        <!-- Navigation -->
        <nav>
          <ul class="main-menu" id="mainMenu">
            <li><a href="index.php"><i class="fa fa-home"></i> Ana Sayfa</a></li>
            <li><a href="index.php?sayfa=kitaplar"><i class="fa fa-book"></i> Kitaplar</a></li>
            
            <li class="menu-dropdown">
              <a href="#"><i class="fa fa-list"></i> Kategoriler <i class="fas fa-chevron-down" style="font-size: 10px; margin-left: 4px;"></i></a>
              <div class="dropdown-content">
                <?php 
                  try {
                    $kategori_sorgu = $db->query("SELECT * FROM kategoriler ORDER BY kategori_adi");
                    $kategoriler = $kategori_sorgu->fetchAll(PDO::FETCH_ASSOC);
                    
                    if ($kategoriler) {
                      foreach ($kategoriler as $kategori) {
                        echo '<a href="index.php?sayfa=kategori&isim=' . urlencode($kategori['kategori_adi']) . '">' . htmlspecialchars($kategori['kategori_adi']) . '</a>';
                      }
                    }
                  } catch(Exception $e) {
                    echo '<a href="#">Kategoriler yüklenemedi</a>';
                  }
                ?>
              </div>
            </li>
            
            <?php if (isset($_SESSION["kullanici_id"])) { ?>
            <li class="menu-dropdown">
              <a href="#"><i class="fa fa-user"></i> Hesabım <i class="fas fa-chevron-down" style="font-size: 10px; margin-left: 4px;"></i></a>
              <div class="dropdown-content">
                <a href="index.php?sayfa=profil"><i class="fa fa-user-circle mr-2"></i><?php echo htmlspecialchars($_SESSION["kullanici_adi"]); ?></a>
                <a href="index.php?sayfa=kitapekle"><i class="fa fa-plus mr-2"></i>Kitap Ekle</a>
                <a href="index.php?sayfa=profil"><i class="fa fa-bookmark mr-2"></i>Kitaplığım</a>
                <a href="cikis.php" style="color: #DC143C;"><i class="fa fa-sign-out-alt mr-2"></i>Çıkış</a>
              </div>
            </li>
            <?php } ?>
          </ul>
        </nav>
        
        <!-- Actions -->
        <div class="header-actions">
          <button class="search-btn" onclick="openSearch()">
            <i class="fa fa-search"></i>
          </button>
          
          <?php if (isset($_SESSION["kullanici_id"])) { ?>
            <div class="user-menu">
              <button class="user-btn">
                <div class="user-avatar">
                  <?php echo mb_strtoupper(mb_substr($_SESSION["kullanici_adi"], 0, 1)); ?>
                </div>
                <span class="d-none d-md-inline"><?php echo htmlspecialchars($_SESSION["kullanici_adi"]); ?></span>
              </button>
            </div>
          <?php } else { ?>
            <a href="index.php?sayfa=login" class="header-btn btn-outline">Giriş</a>
            <a href="index.php?sayfa=uyeol" class="header-btn btn-solid">Üye Ol</a>
          <?php } ?>
          
          <button class="mobile-toggle" onclick="toggleMenu()">
            <i class="fas fa-bars"></i>
          </button>
        </div>
      </div>
    </div>
  </header>
  
  <!-- Search Modal -->
  <div class="search-modal" id="searchModal" onclick="closeSearch(event)">
    <button class="close-search" onclick="closeSearch(event)">
      <i class="fas fa-times"></i>
    </button>
    <div class="search-box" onclick="event.stopPropagation()">
      <form method="GET" action="index.php">
        <input type="hidden" name="sayfa" value="arama">
        <div class="search-input-wrapper">
          <input type="text" name="q" class="search-input" placeholder="Kitap veya yazar ara..." autofocus>
          <button type="submit" class="search-submit">
            <i class="fa fa-search"></i>
          </button>
        </div>
      </form>
    </div>
  </div>
  
  <!-- Main Container -->
  <div class="container" style="max-width: 1200px; margin-top: 30px; padding: 0 20px;">
  
  <script src="js/bootstrap.min.js"></script>
  <script>
    // Mobile menu toggle
    function toggleMenu() {
      const menu = document.getElementById('mainMenu');
      menu.classList.toggle('active');
    }
    
    // Search modal
    function openSearch() {
      document.getElementById('searchModal').classList.add('active');
      document.body.style.overflow = 'hidden';
    }
    
    function closeSearch(event) {
      if (event.target.id === 'searchModal' || event.target.closest('.close-search')) {
        document.getElementById('searchModal').classList.remove('active');
        document.body.style.overflow = 'auto';
      }
    }
    
    // Close menu when clicking outside
    document.addEventListener('click', function(event) {
      const menu = document.getElementById('mainMenu');
      const toggle = document.querySelector('.mobile-toggle');
      
      if (!event.target.closest('.main-menu') && !event.target.closest('.mobile-toggle')) {
        menu.classList.remove('active');
      }
    });
    
    // Dropdown toggle for mobile
    document.querySelectorAll('.menu-dropdown > a').forEach(function(item) {
      item.addEventListener('click', function(e) {
        if (window.innerWidth <= 991) {
          e.preventDefault();
          this.parentElement.classList.toggle('active');
        }
      });
    });
    
    // Owl Carousel
    $(document).ready(function(){
      $('.owl-carousel').owlCarousel({
        loop: true,
        margin: 15,
        nav: true,
        navText: ['<i class="fas fa-chevron-left"></i>', '<i class="fas fa-chevron-right"></i>'],
        dots: true,
        autoplay: true,
        autoplayTimeout: 4000,
        autoplayHoverPause: true,
        responsive: {
          0: { items: 2 },
          600: { items: 3 },
          1000: { items: 5 }
        }
      });
    });
    
    // ESC key to close search
    document.addEventListener('keydown', function(e) {
      if (e.key === 'Escape') {
        document.getElementById('searchModal').classList.remove('active');
        document.body.style.overflow = 'auto';
      }
    });
  </script>
</body>
</html>