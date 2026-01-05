<div class="container mt-4">
    <?php
        // 1. URL'den gelen kategori adını güvenli bir şekilde alıyoruz
        // NOT: URL'den gelen Türkçe karakterli isimler otomatik olarak urlencode edilmiş olmalıdır.
        $kategori_adi = isset($_GET["isim"]) ? htmlspecialchars($_GET["isim"]) : "";

        // Eğer kategori adı boşsa, hata mesajı gösterip çıkıyoruz
        if (empty($kategori_adi)) {
            echo "<div class='alert alert-danger'>Hatalı istek! Lütfen geçerli bir kategori seçin.</div>";
            exit;
        }

        // 2. Kategori adından kategori ID'sini bulma sorgusu
        // Bu sorgu, kullanıcının tıkladığı isimden ID'yi bulur.
        $sorgu_kategori_id = $db->prepare("SELECT kategori_id FROM kategoriler WHERE kategori_adi = ?");
        $sorgu_kategori_id->execute([$kategori_adi]);
        $kategori = $sorgu_kategori_id->fetch(PDO::FETCH_ASSOC);

        if (!$kategori) {
            echo "<div class='alert alert-warning'>'**" . $kategori_adi . "**' adında bir kategori bulunamadı.</div>";
            exit;
        }

        $kategori_id = $kategori['kategori_id'];
    ?>

    <h3 class="mb-4 text-primary"><i class="fas fa-filter mr-2"></i> <?php echo htmlspecialchars($kategori_adi); ?> Kategorisindeki Kitaplar</h3>
    <hr>
    
    <div class="row">
        <?php
            // 3. Kategori ID'sine sahip tüm kitapları ve yazar adlarını çekme
            // Çoklu tablo birleştirme (JOIN) ile kitaba ait yazar ve kategori bilgilerini alıyoruz.
            // kitap_kategori tablosunu kullanarak ilişkilendirme yapıyoruz.
            $sorgu_kitaplar = $db->prepare("
                SELECT 
                    k.kitap_id, k.kitap_adi, k.kapak_resmi, 
                    y.yazar_adi
                FROM kitaplar k 
                INNER JOIN yazarlar y ON k.yazar_id = y.yazar_id
                INNER JOIN kitap_kategori kk ON k.kitap_id = kk.kitap_id
                WHERE kk.kategori_id = ?
                ORDER BY k.kitap_id DESC
            ");
            $sorgu_kitaplar->execute([$kategori_id]);
            $kitaplar = $sorgu_kitaplar->fetchAll(PDO::FETCH_ASSOC);

            if ($kitaplar) {
                foreach ($kitaplar as $kitap) {
        ?>
            
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                <div class="card h-100 shadow-sm">
                    <a href="index.php?sayfa=kitapdetay&id=<?php echo $kitap['kitap_id']; ?>">
                        <img class="card-img-top" src="<?php echo htmlspecialchars($kitap['kapak_resmi']); ?>" alt="<?php echo htmlspecialchars($kitap['kitap_adi']); ?>" style="height: 250px; object-fit: cover;">
                    </a>
                    <div class="card-body d-flex flex-column">
                        <h6 class="card-title text-truncate"><?php echo htmlspecialchars($kitap['kitap_adi']); ?></h6>
                        <p class="card-text text-muted small mt-auto">Yazar: **<?php echo htmlspecialchars($kitap['yazar_adi']); ?>**</p>
                        <a href="index.php?sayfa=kitapdetay&id=<?php echo $kitap['kitap_id']; ?>" class="btn btn-sm btn-info mt-2">Detay</a>
                    </div>
                </div>
            </div>

        <?php 
                } // foreach bitti
            } else {
                echo "<div class='col-12'><div class='alert alert-info'>Bu kategoriye ait henüz hiç kitap eklenmemiştir.</div></div>";
            }
        ?>
    </div>
</div>