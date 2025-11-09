<div class="container-fluid">
    
    <!-- ÖNE ÇIKAN KİTAPLAR BÖLÜMÜ -->
<div class="row mt-4">
        <div class="col-12">
            <h3 class="mb-3">
                <i class="fa fa-star text-warning"></i> Öne Çıkan Kitaplar
            </h3>
        </div>
    </div>

    <div class="row">
        <?php 
            // Rastgele 4 kitap çekiyoruz
            $sorgu = $db->prepare("
                SELECT 
                    kitaplar.*, 
                    yazarlar.yazar_adi 
                FROM kitaplar 
                INNER JOIN yazarlar ON kitaplar.yazar_id = yazarlar.yazar_id 
                ORDER BY RAND() 
                LIMIT 4
            ");
            $sorgu->execute();
            
            while ($kitap = $sorgu->fetch(PDO::FETCH_ASSOC)) 
            {
        ?>
            <div class="col-md-3 mb-4">
                <div class="card h-100 shadow-sm" style="transition: transform 0.3s;">
                    <a href="index.php?sayfa=kitapdetay&id=<?php echo $kitap['kitap_id']; ?>" style="text-decoration: none; color: inherit;">
                        <img src="<?php echo htmlspecialchars($kitap['kapak_resmi']); ?>" 
                             class="card-img-top" 
                             alt="<?php echo htmlspecialchars($kitap['kitap_adi']); ?>"
                             style="height: 300px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title" style="color: #333; font-weight: bold;">
                                <?php echo htmlspecialchars($kitap['kitap_adi']); ?>
                            </h5>
                            <p class="card-text text-muted">
                                <i class="fa fa-user"></i> <?php echo htmlspecialchars($kitap['yazar_adi']); ?>
                            </p>
                            <p class="card-text">
                                <small class="text-muted">
                                    <i class="fa fa-calendar"></i> <?php echo htmlspecialchars($kitap['yayin_yili']); ?>
                                </small>
                            </p>
                        </div>
                    </a>
                </div>
            </div>
        <?php 
            }
        ?>
    </div>

    <hr class="my-5">

    <!-- YENİ EKLENEN KİTAPLAR BÖLÜMÜ -->
    <div class="row mt-4">
        <div class="col-12">
            <h3 class="mb-3">
                <i class="fa fa-book text-primary"></i> Yeni Eklenen Kitaplar
            </h3>
        </div>
    </div>

    <div class="row">
        <?php 
            // Son eklenen 8 kitabı çekiyoruz
            $sorgu = $db->prepare("
                SELECT 
                    kitaplar.*, 
                    yazarlar.yazar_adi 
                FROM kitaplar 
                INNER JOIN yazarlar ON kitaplar.yazar_id = yazarlar.yazar_id 
                ORDER BY kitaplar.kitap_id DESC 
                LIMIT 8
            ");
            $sorgu->execute();
            
            while ($kitap = $sorgu->fetch(PDO::FETCH_ASSOC)) 
            {
        ?>
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="card h-100 shadow-sm" style="transition: transform 0.3s;" 
                     onmouseover="this.style.transform='scale(1.05)'" 
                     onmouseout="this.style.transform='scale(1)'">
                    <a href="index.php?sayfa=kitapdetay&id=<?php echo $kitap['kitap_id']; ?>" style="text-decoration: none; color: inherit;">
                        <img src="<?php echo htmlspecialchars($kitap['kapak_resmi']); ?>" 
                             class="card-img-top" 
                             alt="<?php echo htmlspecialchars($kitap['kitap_adi']); ?>"
                             style="height: 300px; object-fit: cover;">
                        <div class="card-body">
                            <h6 class="card-title" style="color: #333; font-weight: bold; min-height: 45px;">
                                <?php echo htmlspecialchars($kitap['kitap_adi']); ?>
                            </h6>
                            <p class="card-text text-muted mb-1">
                                <small><i class="fa fa-user"></i> <?php echo htmlspecialchars($kitap['yazar_adi']); ?></small>
                            </p>
                            <p class="card-text">
                                <small class="text-muted">
                                    <i class="fa fa-calendar"></i> <?php echo htmlspecialchars($kitap['yayin_yili']); ?>
                                </small>
                            </p>
                        </div>
                    </a>
                </div>
            </div>
        <?php 
            }
        ?>
    </div>

    <hr class="my-5">

    <!-- YAZARLARA GÖRE KİTAPLAR BÖLÜMÜ -->
    <div class="row mt-4">
        <div class="col-12">
            <h3 class="mb-3">
                <i class="fa fa-users text-success"></i> Popüler Yazarlar ve Kitapları
            </h3>
        </div>
    </div>

    <div class="row">
        <?php 
            // En çok kitabı olan 4 yazarı ve kitaplarını çekiyoruz
            $sorgu_yazarlar = $db->prepare("
                SELECT 
                    yazarlar.yazar_id,
                    yazarlar.yazar_adi,
                    COUNT(kitaplar.kitap_id) as kitap_sayisi
                FROM yazarlar
                INNER JOIN kitaplar ON yazarlar.yazar_id = kitaplar.yazar_id
                GROUP BY yazarlar.yazar_id
                ORDER BY kitap_sayisi DESC
                LIMIT 4
            ");
            $sorgu_yazarlar->execute();
            
            while ($yazar = $sorgu_yazarlar->fetch(PDO::FETCH_ASSOC)) 
            {
        ?>
            <div class="col-md-6 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                        <h5 class="card-title">
                            <i class="fa fa-user-circle"></i> <?php echo htmlspecialchars($yazar['yazar_adi']); ?>
                        </h5>
                        <p class="mb-0">
                            <small><i class="fa fa-book"></i> <?php echo $yazar['kitap_sayisi']; ?> kitap</small>
                        </p>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <?php 
                                // Bu yazarın kitaplarını çekiyoruz
                                $sorgu_yazar_kitaplari = $db->prepare("
                                    SELECT * FROM kitaplar 
                                    WHERE yazar_id = ? 
                                    LIMIT 3
                                ");
                                $sorgu_yazar_kitaplari->execute([$yazar['yazar_id']]);
                                
                                while ($kitap = $sorgu_yazar_kitaplari->fetch(PDO::FETCH_ASSOC)) 
                                {
                            ?>
                                <div class="col-4">
                                    <a href="index.php?sayfa=kitapdetay&id=<?php echo $kitap['kitap_id']; ?>">
                                        <img src="<?php echo htmlspecialchars($kitap['kapak_resmi']); ?>" 
                                             class="img-fluid rounded shadow-sm" 
                                             alt="<?php echo htmlspecialchars($kitap['kitap_adi']); ?>"
                                             style="height: 150px; object-fit: cover; width: 100%;">
                                    </a>
                                </div>
                            <?php 
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php 
            }
        ?>
    </div>

    <hr class="my-5">

    <!-- YILLARA GÖRE KİTAPLAR BÖLÜMÜ -->
    <div class="row mt-4">
        <div class="col-12">
            <h3 class="mb-3">
                <i class="fa fa-history text-info"></i> Klasikler ve Yeni Çıkanlar
            </h3>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-danger text-white">
                    <h5><i class="fa fa-bookmark"></i> Klasik Eserler (2000 Öncesi)</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <?php 
                            $sorgu = $db->prepare("
                                SELECT 
                                    kitaplar.*, 
                                    yazarlar.yazar_adi 
                                FROM kitaplar 
                                INNER JOIN yazarlar ON kitaplar.yazar_id = yazarlar.yazar_id 
                                WHERE kitaplar.yayin_yili < 2000
                                ORDER BY RAND() 
                                LIMIT 4
                            ");
                            $sorgu->execute();
                            
                            while ($kitap = $sorgu->fetch(PDO::FETCH_ASSOC)) 
                            {
                        ?>
                            <div class="col-6 mb-3">
                                <a href="index.php?sayfa=kitapdetay&id=<?php echo $kitap['kitap_id']; ?>">
                                    <img src="<?php echo htmlspecialchars($kitap['kapak_resmi']); ?>" 
                                         class="img-fluid rounded shadow-sm" 
                                         alt="<?php echo htmlspecialchars($kitap['kitap_adi']); ?>"
                                         style="height: 200px; object-fit: cover; width: 100%;">
                                </a>
                                <p class="mt-2 mb-0 text-center">
                                    <small><strong><?php echo htmlspecialchars($kitap['kitap_adi']); ?></strong></small>
                                </p>
                            </div>
                        <?php 
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h5><i class="fa fa-newspaper-o"></i> Yeni Çıkanlar (2020 Sonrası)</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <?php 
                            $sorgu = $db->prepare("
                                SELECT 
                                    kitaplar.*, 
                                    yazarlar.yazar_adi 
                                FROM kitaplar 
                                INNER JOIN yazarlar ON kitaplar.yazar_id = yazarlar.yazar_id 
                                WHERE kitaplar.yayin_yili >= 2020
                                ORDER BY kitaplar.yayin_yili DESC 
                                LIMIT 4
                            ");
                            $sorgu->execute();
                            
                            while ($kitap = $sorgu->fetch(PDO::FETCH_ASSOC)) 
                            {
                        ?>
                            <div class="col-6 mb-3">
                                <a href="index.php?sayfa=kitapdetay&id=<?php echo $kitap['kitap_id']; ?>">
                                    <img src="<?php echo htmlspecialchars($kitap['kapak_resmi']); ?>" 
                                         class="img-fluid rounded shadow-sm" 
                                         alt="<?php echo htmlspecialchars($kitap['kitap_adi']); ?>"
                                         style="height: 200px; object-fit: cover; width: 100%;">
                                </a>
                                <p class="mt-2 mb-0 text-center">
                                    <small><strong><?php echo htmlspecialchars($kitap['kitap_adi']); ?></strong></small>
                                </p>
                            </div>
                        <?php 
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<style>
    .card {
        border: none;
        border-radius: 10px;
    }
    
    .card:hover {
        box-shadow: 0 8px 16px rgba(0,0,0,0.2) !important;
    }
    
    .card-img-top {
        border-radius: 10px 10px 0 0;
    }
    
    h3 i {
        margin-right: 10px;
    }
</style>