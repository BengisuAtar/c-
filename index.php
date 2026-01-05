<?php 
    // Veritabanı bağlantısını ve session'ları başlat
    include("baglanti.php");

    // Menüyü dahil et
    include("bloklar/menu.php");

    // Slider'ı dahil et
    include("bloklar/slader.php");
?>

<div class="row">
    <?php 
        // URL'den gelen sayfa parametresine göre ilgili dosyayı çağır
        if (isset($_GET["sayfa"])) {
            $sayfa = $_GET["sayfa"];

            // Güvenlik için sayfa adını kontrol et
            $izin_verilen_sayfalar = [
                'uyeol', 
                'login', 
                'kitapdetay', 
                'kitapekle',      // Alt çizgisiz
                'kitap_ekle',     // Alt çizgili (ikisi de çalışsın)
                'kitapduzenle', 
                'kitap_duzenle',  // Alt çizgili
                'kitapsil', 
                'kitap_sil',      // Alt çizgili
                'kitaplar', 
                'arama', 
                'kategori', 
                'profil'
            ];

            if (in_array($sayfa, $izin_verilen_sayfalar)) {
                
                // Dosya adı eşleştirmesi (alt çizgili ve çizgisiz)
                $dosya_adi = $sayfa;
                
                // Alt çizgili versiyonu dene
                if ($sayfa == 'kitapekle') {
                    $dosya_adi = file_exists('kitap_ekle.php') ? 'kitap_ekle' : 'kitapekle';
                } elseif ($sayfa == 'kitapduzenle') {
                    $dosya_adi = file_exists('kitap_duzenle.php') ? 'kitap_duzenle' : 'kitapduzenle';
                } elseif ($sayfa == 'kitapsil') {
                    $dosya_adi = file_exists('kitap_sil.php') ? 'kitap_sil' : 'kitapsil';
                } elseif ($sayfa == 'kitapdetay') {
                    $dosya_adi = file_exists('kitap_detay.php') ? 'kitap_detay' : 'kitapdetay';
                }
                
                $dosya_yolu = $dosya_adi . ".php";
                
                if (file_exists($dosya_yolu)) {
                    include($dosya_yolu);
                } else {
                    echo "<div class='container mt-4'>";
                    echo "<div class='alert alert-danger'>";
                    echo "<h4><i class='fas fa-exclamation-triangle mr-2'></i>Sayfa Bulunamadı!</h4>";
                    echo "<p>Aradığınız sayfa bulunamadı: <strong>" . htmlspecialchars($sayfa) . ".php</strong></p>";
                    echo "<p class='text-muted'>Dosya konumu: <code>" . htmlspecialchars($dosya_yolu) . "</code></p>";
                    echo "<a href='index.php' class='btn btn-primary'>Ana Sayfaya Dön</a>";
                    echo "</div>";
                    echo "</div>";
                }
            } else {
                // Güvenlik: İzin verilmeyen sayfa
                echo "<div class='container mt-4'>";
                echo "<div class='alert alert-warning'>";
                echo "<h4><i class='fas fa-exclamation-circle mr-2'></i>Geçersiz Sayfa!</h4>";
                echo "<p>Erişmek istediğiniz sayfa geçerli değil.</p>";
                echo "<a href='index.php' class='btn btn-primary'>Ana Sayfaya Dön</a>";
                echo "</div>";
                echo "</div>";
            }
        } else {
            // Sayfa parametresi yoksa anasayfayı yükle
            include("default.php");
        }
    ?>     
</div>

<?php 
    // Footer'ı dahil et
    include("bloklar/footer.php");
?>
</body>
</html>
<?php
// Output buffer'ı temizle ve gönder
if (ob_get_level()) {
    ob_end_flush();
}
?>