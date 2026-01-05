<div class="row mt-4">
    <div class="col-12">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
            <div>
                <h3 style="font-size: 24px; font-weight: 600; color: #2c1810; margin: 0;">Öne Çıkan Kitaplar</h3>
                <p style="color: #888; font-size: 14px; margin: 5px 0 0 0;">En popüler ve yeni eklenen kitaplar</p>
            </div>
            <a href="index.php?sayfa=kitaplar" style="color: #8B4513; text-decoration: none; font-weight: 500; font-size: 14px; display: flex; align-items: center; gap: 6px;">
                Tümünü Gör <i class="fas fa-arrow-right" style="font-size: 12px;"></i>
            </a>
        </div>
        
        <div class="owl-carousel owl-theme">
            
            <?php 
                try {
                    $slider_sorgu = $db->prepare("
                        SELECT k.*, y.yazar_adi 
                        FROM kitaplar k
                        LEFT JOIN yazarlar y ON k.yazar_id = y.yazar_id
                        ORDER BY k.kitap_id DESC 
                        LIMIT 10
                    ");
                    $slider_sorgu->execute();
                    $slider_kitaplar = $slider_sorgu->fetchAll(PDO::FETCH_ASSOC);

                    if ($slider_kitaplar) {
                        foreach ($slider_kitaplar as $kitap) {
            ?>
                
                <div class="item">
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
                        echo '<div class="col-12 text-center py-5">';
                        echo '<p style="color: #999;">Henüz kitap eklenmemiş.</p>';
                        echo '</div>';
                    }
                } catch(Exception $e) {
                    echo '<div class="col-12"><p style="color: #DC143C;">Kitaplar yüklenirken bir hata oluştu.</p></div>';
                }
            ?>
        </div>
    </div>
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
    
    /* Owl Carousel Styling */
    .owl-theme .owl-nav {
        margin-top: 25px;
    }
    
    .owl-theme .owl-nav [class*='owl-'] {
        background: white;
        color: #8B4513;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        margin: 0 5px;
        border: 1px solid #e5e5e5;
        transition: all 0.2s;
    }
    
    .owl-theme .owl-nav [class*='owl-']:hover {
        background: #8B4513;
        color: white;
        border-color: #8B4513;
        transform: scale(1.1);
    }
    
    .owl-theme .owl-dots {
        margin-top: 20px;
    }
    
    .owl-theme .owl-dots .owl-dot span {
        background: #e5e5e5;
        width: 8px;
        height: 8px;
        margin: 0 4px;
    }
    
    .owl-theme .owl-dots .owl-dot.active span,
    .owl-theme .owl-dots .owl-dot:hover span {
        background: #8B4513;
    }
</style>