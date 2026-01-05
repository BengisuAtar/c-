<div class="container" style="max-width: 1200px; padding: 0 20px;">
    
    <!-- Page Header -->
    <div style="margin: 40px 0 30px;">
        <h1 style="font-size: 32px; font-weight: 600; color: #2c1810; margin: 0 0 10px 0;">Tüm Kitaplar</h1>
        <p style="color: #888; font-size: 15px; margin: 0;">Kütüphanemizdeki tüm kitaplara göz atın</p>
    </div>

    <?php
        $sayfa_basina = 12;
        $aktif_sayfa = isset($_GET['p']) ? (int)$_GET['p'] : 1;
        
        if ($aktif_sayfa < 1) {
            $aktif_sayfa = 1;
        }
        
        $baslangic = ($aktif_sayfa - 1) * $sayfa_basina;

        try {
            $toplam_sorgu = $db->query("SELECT COUNT(*) as toplam FROM kitaplar");
            $toplam = $toplam_sorgu->fetch(PDO::FETCH_ASSOC)['toplam'];
            $toplam_sayfa = ceil($toplam / $sayfa_basina);
            
            if ($aktif_sayfa > $toplam_sayfa && $toplam_sayfa > 0) {
                $aktif_sayfa = $toplam_sayfa;
                $baslangic = ($aktif_sayfa - 1) * $sayfa_basina;
            }
        } catch(Exception $e) {
            echo "<div class='alert' style='background: #fff3cd; border-left: 3px solid #ffc107; padding: 15px; border-radius: 8px; color: #856404;'>Veritabanı hatası</div>";
            exit;
        }

        try {
            $sorgu = $db->prepare("
                SELECT 
                    k.*, 
                    y.yazar_adi 
                FROM kitaplar k 
                INNER JOIN yazarlar y ON k.yazar_id = y.yazar_id
                ORDER BY k.kitap_id DESC
                LIMIT :baslangic, :sayfa_basina
            ");
            
            $sorgu->bindValue(':baslangic', $baslangic, PDO::PARAM_INT);
            $sorgu->bindValue(':sayfa_basina', $sayfa_basina, PDO::PARAM_INT);
            
            $sorgu->execute();
            $kitaplar = $sorgu->fetchAll(PDO::FETCH_ASSOC);
        } catch(Exception $e) {
            echo "<div class='alert' style='background: #fff3cd; border-left: 3px solid #ffc107; padding: 15px; border-radius: 8px; color: #856404;'>Kitaplar yüklenirken hata oluştu</div>";
            $kitaplar = [];
        }
    ?>

    <!-- Stats Bar -->
    <div style="background: #f5f0eb; padding: 15px 20px; border-radius: 10px; margin-bottom: 30px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap;">
        <div style="color: #5C3317; font-size: 14px; font-weight: 500;">
            <i class="fa fa-book" style="color: #8B4513; margin-right: 8px;"></i>
            Toplam <strong><?php echo number_format($toplam); ?></strong> kitap
        </div>
        <?php if ($toplam_sayfa > 1) { ?>
        <div style="color: #888; font-size: 13px;">
            Sayfa <strong><?php echo $aktif_sayfa; ?></strong> / <strong><?php echo $toplam_sayfa; ?></strong>
        </div>
        <?php } ?>
    </div>

    <!-- Books Grid -->
    <div class="row">
        <?php 
            if ($kitaplar && count($kitaplar) > 0) {
                foreach ($kitaplar as $kitap) {
        ?>
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                <a href="index.php?sayfa=kitapdetay&id=<?php echo $kitap['kitap_id']; ?>" style="text-decoration: none;">
                    <div class="book-card">
                        <div class="book-cover">
                            <img src="<?php echo htmlspecialchars($kitap['kapak_resmi']); ?>" 
                                 alt="<?php echo htmlspecialchars($kitap['kitap_adi']); ?>"
                                 onerror="this.src='https://via.placeholder.com/300x400/f5f0eb/8B4513?text=OKUVA'">
                        </div>
                        <div class="book-info">
                            <h6 class="book-title">
                                <?php echo htmlspecialchars($kitap['kitap_adi']); ?>
                            </h6>
                            <p class="book-author">
                                <?php echo htmlspecialchars($kitap['yazar_adi']); ?>
                            </p>
                            <?php if ($kitap['yayin_yili']) { ?>
                                <span class="book-year"><?php echo htmlspecialchars($kitap['yayin_yili']); ?></span>
                            <?php } ?>
                        </div>
                    </div>
                </a>
            </div>
        <?php 
                }
            } else {
                echo "<div class='col-12'>";
                echo "<div style='text-align: center; padding: 80px 20px; background: white; border-radius: 12px;'>";
                echo "<i class='fa fa-book-open' style='font-size: 80px; color: #e5e5e5; margin-bottom: 20px;'></i>";
                echo "<h4 style='color: #999; margin-bottom: 10px;'>Henüz kitap yok</h4>";
                echo "<p style='color: #bbb; margin-bottom: 20px;'>İlk kitabı sen ekle!</p>";
                if (isset($_SESSION["kullanici_id"])) {
                    echo "<a href='index.php?sayfa=kitapekle' class='btn-primary'>Kitap Ekle</a>";
                } else {
                    echo "<a href='index.php?sayfa=login' class='btn-primary'>Giriş Yap</a>";
                }
                echo "</div>";
                echo "</div>";
            }
        ?>
    </div>

    <!-- Pagination -->
    <?php if ($toplam_sayfa > 1) { ?>
        <div style="margin: 50px 0; display: flex; justify-content: center; align-items: center; gap: 15px; flex-wrap: wrap;">
            
            <?php if ($aktif_sayfa > 1) { ?>
                <a href="index.php?sayfa=kitaplar&p=1" class="page-btn">
                    <i class="fas fa-angle-double-left"></i>
                </a>
                <a href="index.php?sayfa=kitaplar&p=<?php echo ($aktif_sayfa - 1); ?>" class="page-btn">
                    <i class="fas fa-angle-left"></i>
                </a>
            <?php } ?>

            <?php 
                $baslangic_sayfa = max(1, $aktif_sayfa - 2);
                $bitis_sayfa = min($toplam_sayfa, $aktif_sayfa + 2);
                
                for ($i = $baslangic_sayfa; $i <= $bitis_sayfa; $i++) { 
            ?>
                <a href="index.php?sayfa=kitaplar&p=<?php echo $i; ?>" 
                   class="page-btn <?php echo ($i == $aktif_sayfa) ? 'active' : ''; ?>">
                    <?php echo $i; ?>
                </a>
            <?php } ?>

            <?php if ($aktif_sayfa < $toplam_sayfa) { ?>
                <a href="index.php?sayfa=kitaplar&p=<?php echo ($aktif_sayfa + 1); ?>" class="page-btn">
                    <i class="fas fa-angle-right"></i>
                </a>
                <a href="index.php?sayfa=kitaplar&p=<?php echo $toplam_sayfa; ?>" class="page-btn">
                    <i class="fas fa-angle-double-right"></i>
                </a>
            <?php } ?>

        </div>
        
        <!-- Page Jump -->
        <div style="text-align: center; margin-bottom: 50px;">
            <form method="GET" action="index.php" style="display: inline-flex; align-items: center; gap: 10px;">
                <input type="hidden" name="sayfa" value="kitaplar">
                <label style="color: #666; font-size: 14px;">Sayfaya git:</label>
                <input type="number" name="p" 
                       min="1" max="<?php echo $toplam_sayfa; ?>" 
                       value="<?php echo $aktif_sayfa; ?>" 
                       style="width: 70px; padding: 6px 12px; border: 1px solid #e5e5e5; border-radius: 6px; text-align: center;">
                <button type="submit" class="btn-primary" style="padding: 6px 16px; font-size: 14px;">
                    Git
                </button>
            </form>
        </div>
    <?php } ?>

</div>

<style>
    .book-card {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        transition: all 0.3s ease;
        border: 1px solid #f0f0f0;
    }
    
    .book-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 24px rgba(0,0,0,0.08);
        border-color: #e5e5e5;
    }
    
    .book-cover {
        position: relative;
        padding-top: 140%;
        overflow: hidden;
        background: #f5f0eb;
    }
    
    .book-cover img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }
    
    .book-card:hover .book-cover img {
        transform: scale(1.05);
    }
    
    .book-info {
        padding: 14px;
    }
    
    .book-title {
        font-size: 14px;
        font-weight: 600;
        color: #2c1810;
        margin: 0 0 6px 0;
        line-height: 1.4;
        min-height: 40px;
    }
    
    .book-author {
        font-size: 13px;
        color: #666;
        margin: 0 0 8px 0;
    }
    
    .book-year {
        display: inline-block;
        font-size: 11px;
        color: #8B4513;
        background: #f5f0eb;
        padding: 3px 10px;
        border-radius: 12px;
        font-weight: 500;
    }
    
    .page-btn {
        width: 40px;
        height: 40px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: white;
        border: 1px solid #e5e5e5;
        border-radius: 8px;
        color: #666;
        text-decoration: none;
        font-weight: 500;
        font-size: 14px;
        transition: all 0.2s;
    }
    
    .page-btn:hover {
        background: #f5f0eb;
        border-color: #8B4513;
        color: #8B4513;
    }
    
    .page-btn.active {
        background: #8B4513;
        border-color: #8B4513;
        color: white;
    }
    
    .btn-primary {
        display: inline-block;
        padding: 10px 24px;
        background: linear-gradient(135deg, #8B4513, #DC143C);
        color: white;
        text-decoration: none;
        border-radius: 8px;
        font-weight: 500;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
    }
    
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(139, 69, 19, 0.3);
    }
</style>