<div class="container" style="max-width: 1200px; padding: 0 20px;">
    
    <!-- POPÜLER YAZARLAR -->
    <section style="margin: 50px 0;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
            <div>
                <h3 style="font-size: 24px; font-weight: 600; color: #2c1810; margin: 0;">Popüler Yazarlar</h3>
                <p style="color: #888; font-size: 14px; margin: 5px 0 0 0;">Kütüphanemizin en çok okunan yazarları</p>
            </div>
        </div>

        <div class="row">
            <?php
                $sorgu_yazarlar = $db->prepare("
                    SELECT 
                        y.yazar_id,
                        y.yazar_adi,
                        y.biyografi,
                        COUNT(k.kitap_id) as kitap_sayisi
                    FROM yazarlar y
                    LEFT JOIN kitaplar k ON y.yazar_id = k.yazar_id
                    GROUP BY y.yazar_id
                    HAVING kitap_sayisi > 0
                    ORDER BY kitap_sayisi DESC
                    LIMIT 6
                ");
                $sorgu_yazarlar->execute();
                $yazarlar = $sorgu_yazarlar->fetchAll(PDO::FETCH_ASSOC);

                if ($yazarlar) {
                    foreach ($yazarlar as $yazar) {
            ?>
                <div class="col-md-4 col-sm-6 mb-4">
                    <div class="author-card">
                        <div class="author-avatar">
                            <?php echo mb_strtoupper(mb_substr($yazar['yazar_adi'], 0, 1, 'UTF-8'), 'UTF-8'); ?>
                        </div>
                        <h6 class="author-name">
                            <?php echo htmlspecialchars($yazar['yazar_adi']); ?>
                        </h6>
                        <p class="author-bio">
                            <?php 
                                if ($yazar['biyografi']) {
                                    echo htmlspecialchars(mb_substr($yazar['biyografi'], 0, 80)) . '...';
                                } else {
                                    echo 'Türk edebiyatının önemli isimlerinden biri.';
                                }
                            ?>
                        </p>
                        <div class="author-stats">
                            <span><i class="fas fa-book"></i> <?php echo $yazar['kitap_sayisi']; ?> Kitap</span>
                        </div>
                        <a href="index.php?sayfa=arama&q=<?php echo urlencode($yazar['yazar_adi']); ?>" class="author-btn">
                            Kitaplarını Gör
                        </a>
                    </div>
                </div>
            <?php 
                    }
                } else {
                    echo "<div class='col-12'><p style='text-align: center; color: #999;'>Henüz yazar eklenmemiş.</p></div>";
                }
            ?>
        </div>
    </section>

    <!-- SON EKLENEN KİTAPLAR -->
    <section style="margin: 50px 0;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
            <div>
                <h3 style="font-size: 24px; font-weight: 600; color: #2c1810; margin: 0;">Son Eklenen Kitaplar</h3>
                <p style="color: #888; font-size: 14px; margin: 5px 0 0 0;">Kütüphaneye yeni eklenen eserler</p>
            </div>
            <a href="index.php?sayfa=kitaplar" style="color: #8B4513; text-decoration: none; font-weight: 500; font-size: 14px; display: flex; align-items: center; gap: 6px;">
                Tümünü Gör <i class="fas fa-arrow-right" style="font-size: 12px;"></i>
            </a>
        </div>
        
        <div class="row">
            <?php
                $sorgu_son = $db->prepare("
                    SELECT 
                        k.*, 
                        y.yazar_adi 
                    FROM kitaplar k 
                    INNER JOIN yazarlar y ON k.yazar_id = y.yazar_id
                    ORDER BY k.kitap_id DESC
                    LIMIT 8
                ");
                $sorgu_son->execute();
                $son_eklenenler = $sorgu_son->fetchAll(PDO::FETCH_ASSOC);

                if ($son_eklenenler) {
                    foreach ($son_eklenenler as $kitap) {
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
                                    <?php echo htmlspecialchars(mb_substr($kitap['kitap_adi'], 0, 40)); ?>
                                    <?php echo mb_strlen($kitap['kitap_adi']) > 40 ? '...' : ''; ?>
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
                    echo "<div class='col-12'><p style='text-align: center; color: #999;'>Henüz hiç kitap eklenmemiş.</p></div>";
                }
            ?>
        </div>
    </section>

</div>

<style>
    /* Author Cards */
    .author-card {
        background: white;
        border: 1px solid #f0f0f0;
        border-radius: 12px;
        padding: 30px 25px;
        text-align: center;
        transition: all 0.3s ease;
    }
    
    .author-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 16px rgba(0,0,0,0.06);
        border-color: #e5e5e5;
    }
    
    .author-avatar {
        width: 70px;
        height: 70px;
        background: linear-gradient(135deg, #8B4513, #DC143C);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        font-size: 28px;
        font-weight: 700;
        color: white;
    }
    
    .author-name {
        font-size: 18px;
        font-weight: 600;
        color: #2c1810;
        margin: 0 0 12px 0;
    }
    
    .author-bio {
        font-size: 14px;
        color: #666;
        line-height: 1.6;
        margin: 0 0 15px 0;
        min-height: 60px;
    }
    
    .author-stats {
        display: inline-block;
        background: #f5f0eb;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 13px;
        color: #8B4513;
        font-weight: 500;
        margin-bottom: 15px;
    }
    
    .author-stats i {
        margin-right: 4px;
    }
    
    .author-btn {
        display: inline-block;
        padding: 8px 20px;
        background: white;
        border: 1.5px solid #8B4513;
        color: #8B4513;
        text-decoration: none;
        border-radius: 20px;
        font-size: 14px;
        font-weight: 500;
        transition: all 0.2s;
    }
    
    .author-btn:hover {
        background: #8B4513;
        color: white;
    }
    
    /* Book Cards */
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
</style>