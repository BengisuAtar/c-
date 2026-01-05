<div class="container mt-3" style="max-width: 800px;">

<?php
    // Giriş kontrolü
    if (!isset($_SESSION["kullanici_id"])) {
        echo "<div class='alert alert-danger'>Bu işlemi yapmak için lütfen giriş yapın.</div>";
        exit;
    }
    
    $kitap_id = isset($_GET["id"]) ? (int)$_GET["id"] : 0;

    // 1. Güncellenecek kitabın mevcut verilerini ve yazarını çekme
    $sorgu_kitap = $db->prepare("
        SELECT 
            k.*, 
            y.yazar_adi 
        FROM kitaplar k 
        INNER JOIN yazarlar y ON k.yazar_id = y.yazar_id 
        WHERE k.kitap_id = ?
    ");
    $sorgu_kitap->execute([$kitap_id]);
    $kitap = $sorgu_kitap->fetch(PDO::FETCH_ASSOC);

    if (!$kitap) {
        echo "<div class='alert alert-danger'>Düzenlenecek kitap bulunamadı.</div>";
        exit;
    }
    
    // Kitabın mevcut kategorilerini çek
    $mevcut_kategoriler_sorgu = $db->prepare("SELECT kategori_id FROM kitap_kategori WHERE kitap_id = ?");
    $mevcut_kategoriler_sorgu->execute([$kitap_id]);
    $mevcut_kategoriler = $mevcut_kategoriler_sorgu->fetchAll(PDO::FETCH_COLUMN);

    // --- Güncelleme Formu Gönderildiğinde ---
    if (isset($_POST["kitap_guncelle"])) {
        $kitap_adi      = $_POST["kitap_adi"];
        $yazar_adi_form = $_POST["yazar_adi"];
        $aciklama       = $_POST["aciklama"];
        $kapak_resmi    = $_POST["kapak_resmi_url"]; 
        $yayin_yili     = $_POST["yayin_yili"];
        $kategoriler    = isset($_POST["kategoriler"]) ? $_POST["kategoriler"] : [];

        // Yazar kontrolü
        $sorgu_yazar = $db->prepare("SELECT yazar_id FROM yazarlar WHERE yazar_adi = ?");
        $sorgu_yazar->execute([$yazar_adi_form]);

        if ($sorgu_yazar->rowCount() > 0) {
            $yazar_id = $sorgu_yazar->fetch(PDO::FETCH_ASSOC)['yazar_id'];
        } else {
            $sorgu_yeni_yazar = $db->prepare("INSERT INTO yazarlar SET yazar_adi = ?");
            $sorgu_yeni_yazar->execute([$yazar_adi_form]);
            $yazar_id = $db->lastInsertId();
        }

        // 2. Verileri güncelleme sorgusu
        $guncelle_sorgu = $db->prepare("UPDATE kitaplar SET 
            kitap_adi=?,
            yazar_id=?, 
            aciklama=?,
            kapak_resmi=?,
            yayin_yili=?
            WHERE kitap_id=?
        ");

        $guncelle = $guncelle_sorgu->execute([
            $kitap_adi,
            $yazar_id,
            $aciklama,
            $kapak_resmi,
            $yayin_yili,
            $kitap_id
        ]);

        if ($guncelle) {
            // 3. Kategorileri güncelle - önce eskilerini sil
            $db->prepare("DELETE FROM kitap_kategori WHERE kitap_id = ?")->execute([$kitap_id]);
            
            // Yeni kategorileri ekle
            if (!empty($kategoriler)) {
                $kategori_sorgu = $db->prepare("INSERT INTO kitap_kategori (kitap_id, kategori_id) VALUES (?, ?)");
                foreach ($kategoriler as $kategori_id) {
                    $kategori_sorgu->execute([$kitap_id, $kategori_id]);
                }
            }
            
            echo "<div class='alert alert-success'><i class='fas fa-check-circle mr-2'></i>Kitap başarıyla güncellendi!</div>";
            header("Refresh:2;url=index.php?sayfa=kitapdetay&id={$kitap_id}"); 
        } else {
            echo "<div class='alert alert-danger'><i class='fas fa-times-circle mr-2'></i>Hata: Kitap güncellenemedi!</div>";    
        }
    }
    
    // Tüm kategorileri çek
    $kategoriler_sorgu = $db->query("SELECT * FROM kategoriler ORDER BY kategori_adi");
    $kategoriler = $kategoriler_sorgu->fetchAll(PDO::FETCH_ASSOC);
?>

    <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 30px; border-radius: 15px 15px 0 0; color: white; margin-bottom: 0;">
        <h3 align="center" style="margin: 0;">
            <i class="fas fa-edit mr-2"></i> Kitap Düzenle: <?php echo htmlspecialchars($kitap['kitap_adi']); ?>
        </h3>
    </div>
    
    <div style="background: white; padding: 30px; border-radius: 0 0 15px 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
        <form method="POST" action="">
            <div class="form-group">
                <label style="font-weight: bold;">
                    <i class="fas fa-book text-warning mr-1"></i> Kitap Adı *
                </label>
                <input type="text" class="form-control form-control-lg" name="kitap_adi" value="<?php echo htmlspecialchars($kitap['kitap_adi']); ?>" required style="border-radius: 10px;">
            </div>

            <div class="form-group">
                <label style="font-weight: bold;">
                    <i class="fas fa-user text-warning mr-1"></i> Yazar Adı *
                </label>
                <input type="text" class="form-control form-control-lg" name="yazar_adi" value="<?php echo htmlspecialchars($kitap['yazar_adi']); ?>" required style="border-radius: 10px;">
            </div>

            <div class="form-group">
                <label style="font-weight: bold;">
                    <i class="fas fa-calendar text-warning mr-1"></i> Yayın Yılı
                </label>
                <input type="number" class="form-control form-control-lg" name="yayin_yili" value="<?php echo htmlspecialchars($kitap['yayin_yili']); ?>" style="border-radius: 10px;">
            </div>
            
            <div class="form-group">
                <label style="font-weight: bold;">
                    <i class="fas fa-image text-warning mr-1"></i> Kapak Resmi (URL)
                </label>
                <input type="text" class="form-control form-control-lg" name="kapak_resmi_url" value="<?php echo htmlspecialchars($kitap['kapak_resmi']); ?>" style="border-radius: 10px;">
            </div>

            <div class="form-group">
                <label style="font-weight: bold;">
                    <i class="fas fa-tags text-warning mr-1"></i> Kategoriler
                </label>
                <div class="row">
                    <?php foreach ($kategoriler as $kategori) { ?>
                        <div class="col-md-6 mb-2">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" 
                                       class="custom-control-input" 
                                       id="kategori_<?php echo $kategori['kategori_id']; ?>" 
                                       name="kategoriler[]" 
                                       value="<?php echo $kategori['kategori_id']; ?>"
                                       <?php echo in_array($kategori['kategori_id'], $mevcut_kategoriler) ? 'checked' : ''; ?>>
                                <label class="custom-control-label" for="kategori_<?php echo $kategori['kategori_id']; ?>">
                                    <?php echo htmlspecialchars($kategori['kategori_adi']); ?>
                                </label>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>

            <div class="form-group">
                <label style="font-weight: bold;">
                    <i class="fas fa-align-left text-warning mr-1"></i> Kitap Açıklaması
                </label>
                <textarea class="form-control form-control-lg" name="aciklama" rows="6" style="border-radius: 10px;"><?php echo htmlspecialchars($kitap['aciklama']); ?></textarea>
            </div>
            
            <button class="btn btn-warning btn-lg p-3 w-100" name="kitap_guncelle" style="border-radius: 50px; font-weight: bold; color: white;">
                <i class="fas fa-save mr-2"></i> Kitabı Güncelle
            </button>
        </form>
    </div>
    
    <div class="mt-3 mb-5 text-center">
        <a href="index.php?sayfa=kitapdetay&id=<?php echo $kitap_id; ?>" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left mr-1"></i> Kitap Detayına Dön
        </a>
    </div>
</div>

<style>
    .form-control:focus {
        border-color: #ffc107;
        box-shadow: 0 0 0 0.2rem rgba(255, 193, 7, 0.25);
    }
    
    .custom-control-input:checked ~ .custom-control-label::before {
        background-color: #ffc107;
        border-color: #ffc107;
    }
</style>