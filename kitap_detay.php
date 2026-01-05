<?php 
    $kitap_id = isset($_GET["id"]) ? (int)$_GET["id"] : 0;

    if ($kitap_id == 0) {
        echo "<div class='container' style='max-width: 1200px; padding: 0 20px; margin-top: 40px;'>
                <div class='error-alert'>Hatalı istek! Kitap bulunamadı.</div>
              </div>";
    } else {

        if (isset($_POST["kitapliga_ekle"]) && isset($_SESSION["kullanici_id"])) {
            $durum = $_POST["durum"];
            $kullanici_id = $_SESSION["kullanici_id"];
            
            $kontrol = $db->prepare("SELECT * FROM kullanici_kitaplik WHERE kullanici_id = ? AND kitap_id = ?");
            $kontrol->execute([$kullanici_id, $kitap_id]);
            
            if ($kontrol->rowCount() > 0) {
                $guncelle = $db->prepare("UPDATE kullanici_kitaplik SET durum = ? WHERE kullanici_id = ? AND kitap_id = ?");
                $guncelle->execute([$durum, $kullanici_id, $kitap_id]);
                echo "<div class='container' style='max-width: 1200px; padding: 0 20px; margin-top: 40px;'>
                        <div class='success-alert'>Kitaplık durumu güncellendi!</div>
                      </div>";
            } else {
                $ekle = $db->prepare("INSERT INTO kullanici_kitaplik (kullanici_id, kitap_id, durum) VALUES (?, ?, ?)");
                $ekle->execute([$kullanici_id, $kitap_id, $durum]);
                echo "<div class='container' style='max-width: 1200px; padding: 0 20px; margin-top: 40px;'>
                        <div class='success-alert'>Kitap kitaplığınıza eklendi!</div>
                      </div>";
            }
        }

        $sorgu = $db->prepare("
            SELECT 
                kitaplar.*, 
                yazarlar.yazar_adi,
                yazarlar.biyografi
            FROM kitaplar 
            INNER JOIN yazarlar ON kitaplar.yazar_id = yazarlar.yazar_id 
            WHERE kitaplar.kitap_id = ?
        ");

        $sorgu->execute([$kitap_id]);
        $kitap = $sorgu->fetch(PDO::FETCH_ASSOC);

        $kategoriler_sorgu = $db->prepare("
            SELECT k.kategori_id, k.kategori_adi 
            FROM kategoriler k
            INNER JOIN kitap_kategori kk ON k.kategori_id = kk.kategori_id
            WHERE kk.kitap_id = ?
        ");
        $kategoriler_sorgu->execute([$kitap_id]);
        $kategoriler = $kategoriler_sorgu->fetchAll(PDO::FETCH_ASSOC);
        
        $kitaplik_durum = null;
        if (isset($_SESSION["kullanici_id"])) {
            $durum_sorgu = $db->prepare("SELECT durum FROM kullanici_kitaplik WHERE kullanici_id = ? AND kitap_id = ?");
            $durum_sorgu->execute([$_SESSION["kullanici_id"], $kitap_id]);
            $durum_sonuc = $durum_sorgu->fetch(PDO::FETCH_ASSOC);
            if ($durum_sonuc) {
                $kitaplik_durum = $durum_sonuc['durum'];
            }
        }

        if ($kitap) {
?>

<div class="container" style="max-width: 1200px; padding: 0 20px; margin: 40px auto;">
    
    <!-- Breadcrumb -->
    <div style="margin-bottom: 30px;">
        <a href="index.php" style="color: #888; text-decoration: none; font-size: 14px;">Ana Sayfa</a>
        <span style="color: #ddd; margin: 0 8px;">/</span>
        <a href="index.php?sayfa=kitaplar" style="color: #888; text-decoration: none; font-size: 14px;">Kitaplar</a>
        <span style="color: #ddd; margin: 0 8px;">/</span>
        <span style="color: #2c1810; font-size: 14px; font-weight: 500;"><?php echo htmlspecialchars(mb_substr($kitap['kitap_adi'], 0, 40)); ?></span>
    </div>
    
    <div class="row">
        <!-- Kitap Görseli -->
        <div class="col-md-4 mb-4">
            <div style="position: sticky; top: 90px;">
                <div style="background: white; padding: 20px; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.06); border: 1px solid #f0f0f0;">
                    <img src="<?php echo htmlspecialchars($kitap['kapak_resmi']); ?>" 
                         alt="<?php echo htmlspecialchars($kitap['kitap_adi']); ?>"
                         style="width: 100%; border-radius: 12px; box-shadow: 0 8px 24px rgba(0,0,0,0.12);"
                         onerror="this.src='https://via.placeholder.com/400x600/f5f0eb/8B4513?text=OKUVA'">
                    
                    <?php if (isset($_SESSION["kullanici_id"])) { ?>
                    <!-- Kitaplığa Ekle -->
                    <div style="margin-top: 20px; padding-top: 20px; border-top: 1px solid #f0f0f0;">
                        <form method="POST" action="">
                            <label style="font-size: 14px; font-weight: 600; color: #2c1810; display: block; margin-bottom: 10px;">
                                <i class="fas fa-bookmark" style="color: #8B4513; margin-right: 6px;"></i>
                                Kitaplığıma Ekle
                            </label>
                            <select class="form-select" name="durum" required>
                                <option value="okunacak" <?php echo $kitaplik_durum == 'okunacak' ? 'selected' : ''; ?>>📚 Okunacak</option>
                                <option value="okunuyor" <?php echo $kitaplik_durum == 'okunuyor' ? 'selected' : ''; ?>>📖 Okunuyor</option>
                                <option value="okundu" <?php echo $kitaplik_durum == 'okundu' ? 'selected' : ''; ?>>✅ Okundu</option>
                            </select>
                            <button type="submit" name="kitapliga_ekle" class="btn-library">
                                <?php echo $kitaplik_durum ? 'Durumu Güncelle' : 'Kitaplığa Ekle'; ?>
                            </button>
                        </form>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>

        <!-- Kitap Bilgileri -->
        <div class="col-md-8">
            <div style="background: white; padding: 35px; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.06); border: 1px solid #f0f0f0;">
                
                <h1 style="font-size: 32px; font-weight: 600; color: #2c1810; margin: 0 0 15px 0; line-height: 1.3;">
                    <?php echo htmlspecialchars($kitap['kitap_adi']); ?>
                </h1>
                
                <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 25px;">
                    <a href="index.php?sayfa=arama&q=<?php echo urlencode($kitap['yazar_adi']); ?>" 
                       style="font-size: 18px; color: #8B4513; text-decoration: none; font-weight: 500;">
                        <i class="fas fa-user" style="font-size: 16px; margin-right: 6px;"></i>
                        <?php echo htmlspecialchars($kitap['yazar_adi']); ?>
                    </a>
                    
                    <?php if ($kitap['yayin_yili']) { ?>
                        <span style="color: #ddd;">•</span>
                        <span style="color: #888; font-size: 15px;">
                            <i class="fas fa-calendar"></i> <?php echo htmlspecialchars($kitap['yayin_yili']); ?>
                        </span>
                    <?php } ?>
                </div>
                
                <!-- Kategoriler -->
                <?php if (!empty($kategoriler)) { ?>
                <div style="margin-bottom: 30px;">
                    <div style="display: flex; flex-wrap: wrap; gap: 8px;">
                        <?php foreach ($kategoriler as $kategori) { ?>
                            <a href="index.php?sayfa=kategori&isim=<?php echo urlencode($kategori['kategori_adi']); ?>" 
                               class="category-tag">
                                <?php echo htmlspecialchars($kategori['kategori_adi']); ?>
                            </a>
                        <?php } ?>
                    </div>
                </div>
                <?php } ?>
                
                <hr style="border: none; height: 1px; background: #f0f0f0; margin: 30px 0;">
                
                <!-- Açıklama -->
                <div style="margin-bottom: 30px;">
                    <h3 style="font-size: 18px; font-weight: 600; color: #2c1810; margin: 0 0 15px 0;">
                        <i class="fas fa-align-left" style="color: #8B4513; margin-right: 8px;"></i>
                        Açıklama
                    </h3>
                    <p style="font-size: 15px; line-height: 1.8; color: #555;">
                        <?php echo nl2br(htmlspecialchars($kitap['aciklama'])); ?>
                    </p>
                </div>

                <!-- Yazar Hakkında -->
                <?php if ($kitap['biyografi']) { ?>
                <div style="background: #f5f0eb; padding: 20px; border-radius: 12px; margin-bottom: 30px;">
                    <h4 style="font-size: 16px; font-weight: 600; color: #2c1810; margin: 0 0 12px 0;">
                        <i class="fas fa-info-circle" style="color: #8B4513; margin-right: 8px;"></i>
                        Yazar Hakkında
                    </h4>
                    <p style="font-size: 14px; line-height: 1.7; color: #666; margin: 0;">
                        <?php echo htmlspecialchars($kitap['biyografi']); ?>
                    </p>
                </div>
                <?php } ?>
                
                <!-- Düzenle & Sil Butonları -->
                <?php if (isset($_SESSION["kullanici_id"])) { ?>
                <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                    <a href="index.php?sayfa=kitapduzenle&id=<?php echo $kitap['kitap_id']; ?>" 
                       class="btn-edit">
                        <i class="fas fa-edit"></i> Düzenle
                    </a>
                    <a href="index.php?sayfa=kitapsil&id=<?php echo $kitap['kitap_id']; ?>" 
                       class="btn-delete"
                       onclick="return confirm('Bu kitabı silmek istediğinizden emin misiniz?');">
                        <i class="fas fa-trash-alt"></i> Sil
                    </a>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<style>
    .form-select {
        width: 100%;
        padding: 10px 14px;
        border: 1px solid #e5e5e5;
        border-radius: 8px;
        font-size: 14px;
        margin-bottom: 10px;
        background: white;
        cursor: pointer;
    }
    
    .form-select:focus {
        outline: none;
        border-color: #8B4513;
    }
    
    .btn-library {
        width: 100%;
        padding: 10px;
        background: linear-gradient(135deg, #8B4513, #DC143C);
        color: white;
        border: none;
        border-radius: 8px;
        font-weight: 500;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.2s;
    }
    
    .btn-library:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(139, 69, 19, 0.3);
    }
    
    .category-tag {
        display: inline-block;
        padding: 6px 14px;
        background: #f5f0eb;
        color: #8B4513;
        border-radius: 20px;
        text-decoration: none;
        font-size: 13px;
        font-weight: 500;
        transition: all 0.2s;
    }
    
    .category-tag:hover {
        background: #8B4513;
        color: white;
        transform: translateY(-1px);
    }
    
    .btn-edit, .btn-delete {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 20px;
        border-radius: 8px;
        text-decoration: none;
        font-size: 14px;
        font-weight: 500;
        transition: all 0.2s;
    }
    
    .btn-edit {
        background: white;
        color: #8B4513;
        border: 1.5px solid #8B4513;
    }
    
    .btn-edit:hover {
        background: #8B4513;
        color: white;
    }
    
    .btn-delete {
        background: white;
        color: #DC143C;
        border: 1.5px solid #DC143C;
    }
    
    .btn-delete:hover {
        background: #DC143C;
        color: white;
    }
    
    .success-alert {
        background: #d4edda;
        border: 1px solid #c3e6cb;
        border-left: 4px solid #28a745;
        color: #155724;
        padding: 15px 20px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 14px;
    }
    
    .error-alert {
        background: #f8d7da;
        border: 1px solid #f5c6cb;
        border-left: 4px solid #dc3545;
        color: #721c24;
        padding: 15px 20px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 14px;
    }
</style>

<?php
        } else {
            echo "<div class='container' style='max-width: 1200px; padding: 0 20px; margin-top: 40px;'>
                    <div class='error-alert'>Aradığınız kitap bulunamadı.</div>
                  </div>";
        }
    }
?>