<?php 
    // 1. Veritabanı bağlantısını ve session'ları başlatıyoruz.
    include("baglanti.php");

    // 2. Her sayfada görünen menüyü dahil ediyoruz.
    include("bloklar/menu.php");

    // 3. Anasayfada görünecek olan slider'ı dahil ediyoruz.
    include("bloklar/slider.php");
?>

    <div class="row">
      
        <?php 
            // 4. URL'den gelen 'sayfa' parametresine göre ilgili dosyayı çağırıyoruz.
            if (isset($_GET["sayfa"])) 
            {
                $sayfa = $_GET["sayfa"];

                switch ($sayfa) 
                {
                    case 'uyeol':
                        include("uyeol.php");
                        break;

                    case 'login':
                        include("login.php");
                        break;
                        
                    case 'cikis':
                        include("cikis.php");
                        break;

                    case 'kitapdetay': 
                        include("kitap_detay.php");
                        break;
                    
                    case 'kitapekle':
                        include("kitap_ekle.php");
                        break;
                    
                    case 'arama':
                        include("arama.php");
                        break;
                    
                    case 'profil':
                        include("profil.php");
                        break;
                    
                    // Yeni sayfalar için hazırlık (şimdilik default'a yönlendiriyor)
                    case 'arama':
                    case 'tumkitaplar':
                    case 'yeni':
                    case 'populer':
                    case 'kategoriler':
                    case 'yazarlar':
                    case 'okuyorum':
                    case 'okunacak':
                    case 'okudum':
                    case 'favoriler':
                    case 'blog':
                    case 'hakkimizda':
                        echo "<div class='container mt-5 text-center'>";
                        echo "<h2>Bu sayfa henüz yapım aşamasında...</h2>";
                        echo "<p class='text-muted'>Yakında burada olacak!</p>";
                        echo "<a href='index.php' class='btn btn-primary'>Ana Sayfaya Dön</a>";
                        echo "</div>";
                        break;
                    
                    default:
                        include("default.php"); 
                        break;
                }
            }
            else
            {
                // Eğer 'sayfa' parametresi yoksa, anasayfayı yüklüyoruz.
                include("default.php");  
            }
        ?>     
    </div>
    
<?php 
    // 5. Her sayfanın en altında görünecek olan footer'ı dahil ediyoruz.
    include("bloklar/footer.php");
?>
</body>
</html>