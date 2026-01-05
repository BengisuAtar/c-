<?php 
    // Arama sorgusunu alıyoruz
    $arama_kelime = isset($_GET["q"]) ? trim($_GET["q"]) : "";
?>

<div class="container mt-4">
    
    <!-- ARAMA BAŞLIĞI -->
    <div class="row mb-4">
        <div class="col-12">
            <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 40px; border-radius: 15px; color: white; box-shadow: 0 5px 15px rgba(0,0,0,0.2);">
                <h2 style="font-weight: bold; margin-bottom: 20px;">
                    <i class="fa fa-search"></i> Arama Sonuçları
                </h2>
                
                <!-- GELİŞMİŞ ARAMA FORMU -->
                <form method="GET" action="index.php">
                    <input type="hidden" name="sayfa" value="arama">
                    <div class="row">
                        <div class="col-md-10">
                            <input type="text" 
                                   class="form-control form-control-lg" 
                                   name="q" 
                                   value="<?php echo htmlspecialchars($arama_kelime); ?>"
                                   placeholder="Kitap adı, yazar adı veya açıklama ara..." 
                                   style="border-radius: 50px; padding: 15px 25px; border: none;">
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-light btn-lg w-100" style="border-radius: 50px; font-weight: bold;">
                                <i class="fa fa-search"></i> ARA
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php 
        if (!empty($arama_kelime)) 
        {
            // ARAMA SORGUSU - Kitap adı, yazar adı ve açıklamada arama yapıyoruz
            $sorgu = $db->prepare("
                SELECT 
                    kitaplar.*, 
                    yazarlar.yazar_adi 
                FROM kitaplar 
                INNER JOIN yazarlar ON kitaplar.yazar_id = yazarlar.yazar_id 
                WHERE 
                    kitaplar.kitap_adi LIKE ? OR 
                    yazarlar.yazar_adi LIKE ? OR 
                    kitaplar.aciklama LIKE ?
                ORDER BY kitaplar.kitap_id DESC
            ");
            
            $arama_parametresi = "%" . $arama_kelime . "%";
            $sorgu->execute([$arama_parametresi, $arama_parametresi, $arama_parametresi]);
            
            $sonuc_sayisi = $sorgu->rowCount();
    ?>

    <!-- SONUÇ SAYISI -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="alert" style="background: #f8f9fa; border-left: 5px solid #667eea;">
                <h5 style="margin: 0;">
                    <i class="fa fa-info-circle text-primary"></i> 
                    <strong>"<?php echo htmlspecialchars($arama_kelime); ?>"</strong> için 
                    <span class="text-primary"><?php echo $sonuc_sayisi; ?></span> sonuç bulundu.
                </h5>
            </div>
        </div>
    </div>

    <?php 
            if ($sonuc_sayisi > 0) 
            {
    ?>
        <!-- ARAMA SONUÇLARI -->
        <div class="row">
            <?php 
                while ($kitap = $sorgu->fetch(PDO::FETCH_ASSOC)) 
                {
                    // Arama kelimesini vurgulama için fonksiyon
                    function vurgula($metin, $kelime) {
                        return str_ireplace($kelime, '<mark style="background: #ffd700; padding: 2px 5px; border-radius: 3px;">' . $kelime . '</mark>', $metin);
                    }
                    
                    $kitap_adi_vurgulu = vurgula(htmlspecialchars($kitap['kitap_adi']), htmlspecialchars($arama_kelime));
                    $yazar_adi_vurgulu = vurgula(htmlspecialchars($kitap['yazar_adi']), htmlspecialchars($arama_kelime));
            ?>
                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm h-100" style="border: none; border-radius: 15px; transition: all 0.3s;" onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 8px 20px rgba(0,0,0,0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 5px rgba(0,0,0,0.1)'">
                        <div class="row no-gutters">
                            <div class="col-md-4">
                                <a href="index.php?sayfa=kitapdetay&id=<?php echo $kitap['kitap_id']; ?>">
                                    <img src="<?php echo htmlspecialchars($kitap['kapak_resmi']); ?>" 
                                         class="img-fluid" 
                                         alt="<?php echo htmlspecialchars($kitap['kitap_adi']); ?>"
                                         style="height: 250px; object-fit: cover; border-radius: 15px 0 0 15px; width: 100%;">
                                </a>
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title" style="color: #333; font-weight: bold;">
                                        <a href="index.php?sayfa=kitapdetay&id=<?php echo $kitap['kitap_id']; ?>" style="text-decoration: none; color: inherit;">
                                            <?php echo $kitap_adi_vurgulu; ?>
                                        </a>
                                    </h5>
                                    
                                    <p class="card-text mb-2">
                                        <i class="fa fa-user text-primary"></i> 
                                        <strong>Yazar:</strong> <?php echo $yazar_adi_vurgulu; ?>
                                    </p>
                                    
                                    <p class="card-text mb-3">
                                        <i class="fa fa-calendar text-success"></i> 
                                        <strong>Yayın Yılı:</strong> <?php echo htmlspecialchars($kitap['yayin_yili']); ?>
                                    </p>
                                    
                                    <p class="card-text text-muted" style="font-size: 14px;">
                                        <?php 
                                            $aciklama = htmlspecialchars($kitap['aciklama']);
                                            $aciklama_kisa = mb_substr($aciklama, 0, 150);
                                            echo vurgula($aciklama_kisa, htmlspecialchars($arama_kelime));
                                            if (mb_strlen($aciklama) > 150) {
                                                echo "...";
                                            }
                                        ?>
                                    </p>
                                    
                                    <a href="index.php?sayfa=kitapdetay&id=<?php echo $kitap['kitap_id']; ?>" class="btn btn-sm btn-primary" style="border-radius: 20px;">
                                        <i class="fa fa-eye"></i> Detayları Gör
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php 
                }
            ?>
        </div>
        
    <?php 
            } 
            else 
            {
    ?>
        <!-- SONUÇ BULUNAMADI -->
        <div class="row">
            <div class="col-12">
                <div class="text-center" style="padding: 80px 20px;">
                    <i class="fa fa-search" style="font-size: 120px; color: #ddd; margin-bottom: 30px;"></i>
                    <h3 style="color: #666; margin-bottom: 20px;">Üzgünüz, sonuç bulunamadı!</h3>
                    <p style="color: #999; font-size: 18px; margin-bottom: 30px;">
                        "<strong><?php echo htmlspecialchars($arama_kelime); ?></strong>" için hiçbir sonuç bulunamadı.<br>
                        Lütfen farklı anahtar kelimeler deneyiniz.
                    </p>
                    
                    <div style="background: #f8f9fa; padding: 30px; border-radius: 10px; max-width: 600px; margin: 0 auto;">
                        <h5 style="margin-bottom: 15px;"><i class="fa fa-lightbulb-o text-warning"></i> Arama İpuçları:</h5>
                        <ul style="text-align: left; color: #666;">
                            <li>Farklı anahtar kelimeler deneyin</li>
                            <li>Daha genel terimler kullanın</li>
                            <li>Yazım hatalarını kontrol edin</li>
                            <li>Kitap veya yazar adını tam yazmayı deneyin</li>
                        </ul>
                    </div>
                    
                    <a href="index.php" class="btn btn-primary btn-lg mt-4" style="border-radius: 50px; padding: 15px 40px;">
                        <i class="fa fa-home"></i> Ana Sayfaya Dön
                    </a>
                </div>
            </div>
        </div>
    <?php 
            }
        } 
        else 
        {
    ?>
        <!-- ARAMA YAPILMADIĞINDA -->
        <div class="row">
            <div class="col-12">
                <div class="text-center" style="padding: 80px 20px;">
                    <i class="fa fa-search" style="font-size: 120px; color: #ddd; margin-bottom: 30px;"></i>
                    <h3 style="color: #666; margin-bottom: 20px;">Arama yapmak için yukarıdaki kutucuğa yazın</h3>
                    <p style="color: #999; font-size: 18px;">
                        Kitap adı, yazar adı veya açıklama ile arama yapabilirsiniz.
                    </p>
                </div>
                
                <!-- POPÜLER ARAMALAR -->
                <div class="row mt-5">
                    <div class="col-12">
                        <h4 class="text-center mb-4">
                            <i class="fa fa-fire text-danger"></i> Popüler Aramalar
                        </h4>
                    </div>
                    
                    <?php 
                        // En çok kitabı olan 6 yazarı gösteriyoruz
                        $popüler_sorgu = $db->prepare("
                            SELECT 
                                yazarlar.yazar_adi,
                                COUNT(kitaplar.kitap_id) as kitap_sayisi
                            FROM yazarlar
                            INNER JOIN kitaplar ON yazarlar.yazar_id = kitaplar.yazar_id
                            GROUP BY yazarlar.yazar_id
                            ORDER BY kitap_sayisi DESC
                            LIMIT 6
                        ");
                        $popüler_sorgu->execute();
                        
                        while ($yazar = $popüler_sorgu->fetch(PDO::FETCH_ASSOC)) 
                        {
                    ?>
                        <div class="col-md-4 mb-3">
                            <a href="index.php?sayfa=arama&q=<?php echo urlencode($yazar['yazar_adi']); ?>" 
                               class="btn btn-outline-primary btn-block" 
                               style="border-radius: 50px; padding: 15px; font-weight: bold; transition: all 0.3s;">
                                <i class="fa fa-user"></i> <?php echo htmlspecialchars($yazar['yazar_adi']); ?>
                                <span class="badge badge-primary ml-2"><?php echo $yazar['kitap_sayisi']; ?> kitap</span>
                            </a>
                        </div>
                    <?php 
                        }
                    ?>
                </div>
            </div>
        </div>
    <?php 
        }
    ?>

</div>

<style>
    /* Arama Sayfası Özel Stilleri */
    .card:hover {
        cursor: pointer;
    }
    
    mark {
        animation: highlight 0.5s ease;
    }
    
    @keyframes highlight {
        0% {
            background: transparent;
        }
        50% {
            background: #ffd700;
        }
        100% {
            background: #ffd700;
        }
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .card .row .col-md-4 {
            margin-bottom: 15px;
        }
        
        .card .row .col-md-4 img {
            border-radius: 15px 15px 0 0 !important;
            height: 200px !important;
        }
    }
</style>