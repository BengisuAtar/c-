<div class="container" style="max-width: 800px; padding: 0 20px; margin: 60px auto;">

<?php 
    if (!isset($_SESSION["kullanici_id"])) {
        echo "<div class='error-alert'>Bu işlemi yapmak için lütfen giriş yapın.</div>";
        header("Refresh:2;url=index.php?sayfa=login");
        exit;
    }

    if (isset($_POST["kitap_ekle"])) {

        $kitap_adi      = $_POST["kitap_adi"];
        $yazar_adi_form = $_POST["yazar_adi"];
        $aciklama       = $_POST["aciklama"];
        $kapak_resmi    = $_POST["kapak_resmi_url"];
        $yayin_yili     = $_POST["yayin_yili"];
        $kategoriler    = isset($_POST["kategoriler"]) ? $_POST["kategoriler"] : [];

        if (!empty($kitap_adi) && !empty($yazar_adi_form)) {
            
            $sorgu_yazar = $db->prepare("SELECT * FROM yazarlar WHERE yazar_adi = ?");
            $sorgu_yazar->execute([$yazar_adi_form]);

            if ($sorgu_yazar->rowCount() > 0) {
                $yazar = $sorgu_yazar->fetch(PDO::FETCH_ASSOC);
                $yazar_id = $yazar['yazar_id'];
            } else {
                $sorgu_yeni_yazar = $db->prepare("INSERT INTO yazarlar SET yazar_adi = ?");
                $sorgu_yeni_yazar->execute([$yazar_adi_form]);
                $yazar_id = $db->lastInsertId();
            }

            $sorgu = $db->prepare("INSERT INTO kitaplar SET 
                kitap_adi=?,
                yazar_id=?, 
                aciklama=?,
                kapak_resmi=?,
                yayin_yili=?,
                ekleyen_kullanici_id=?
            ");

            $ekle = $sorgu->execute([
                $kitap_adi,
                $yazar_id,
                $aciklama,
                $kapak_resmi,
                $yayin_yili,
                $_SESSION["kullanici_id"]
            ]);

            if ($ekle) {
                $kitap_id = $db->lastInsertId();
                
                if (!empty($kategoriler)) {
                    $kategori_sorgu = $db->prepare("INSERT INTO kitap_kategori (kitap_id, kategori_id) VALUES (?, ?)");
                    foreach ($kategoriler as $kategori_id) {
                        $kategori_sorgu->execute([$kitap_id, $kategori_id]);
                    }
                }
                
                echo "<div class='success-alert'>
                        <i class='fas fa-check-circle'></i>
                        Kitap başarıyla eklendi!
                      </div>";
                header("Refresh:2;url=index.php?sayfa=kitapdetay&id={$kitap_id}");
            } else {
                echo "<div class='error-alert'>
                        <i class='fas fa-times-circle'></i>
                        Hata: Kitap eklenemedi!
                      </div>";
            }

        } else {
            echo "<div class='error-alert'>
                    <i class='fas fa-exclamation-triangle'></i>
                    Kitap adı ve yazar adı boş bırakılamaz!
                  </div>";
        }
    }
    
    $kategoriler_sorgu = $db->query("SELECT * FROM kategoriler ORDER BY kategori_adi");
    $kategoriler = $kategoriler_sorgu->fetchAll(PDO::FETCH_ASSOC);
?>

    <!-- Page Header -->
    <div style="text-align: center; margin-bottom: 40px;">
        <div style="width: 60px; height: 60px; background: linear-gradient(135deg, #8B4513, #DC143C); border-radius: 12px; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 20px;">
            <i class="fas fa-plus" style="font-size: 26px; color: white;"></i>
        </div>
        <h1 style="font-size: 32px; font-weight: 600; color: #2c1810; margin: 0 0 10px 0;">Yeni Kitap Ekle</h1>
        <p style="color: #888; font-size: 15px; margin: 0;">Kütüphaneye yeni bir kitap ekleyin</p>
    </div>
    
    <!-- Form -->
    <div style="background: white; padding: 40px; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.06); border: 1px solid #f0f0f0;">
        <form method="POST" action="">
            <div class="form-row">
                <div class="form-col">
                    <label class="form-label">
                        <i class="fas fa-book" style="color: #8B4513; margin-right: 6px;"></i>
                        Kitap Adı *
                    </label>
                    <input type="text" class="form-input" name="kitap_adi" placeholder="Kitabın adını girin" required>
                </div>

                <div class="form-col">
                    <label class="form-label">
                        <i class="fas fa-user" style="color: #8B4513; margin-right: 6px;"></i>
                        Yazar Adı *
                    </label>
                    <input type="text" class="form-input" name="yazar_adi" placeholder="Yazarın adını girin" required>
                    <small style="color: #888; font-size: 12px; margin-top: 5px; display: block;">
                        Yazar listede yoksa otomatik eklenecektir
                    </small>
                </div>
            </div>

            <div class="form-row">
                <div class="form-col">
                    <label class="form-label">
                        <i class="fas fa-calendar" style="color: #8B4513; margin-right: 6px;"></i>
                        Yayın Yılı
                    </label>
                    <input type="number" class="form-input" name="yayin_yili" placeholder="Örn: 2020" min="1000" max="<?php echo date('Y'); ?>">
                </div>
                
                <div class="form-col">
                    <label class="form-label">
                        <i class="fas fa-image" style="color: #8B4513; margin-right: 6px;"></i>
                        Kapak Resmi (URL)
                    </label>
                    <input type="text" class="form-input" name="kapak_resmi_url" placeholder="https://ornek.com/resim.jpg">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">
                    <i class="fas fa-tags" style="color: #8B4513; margin-right: 6px;"></i>
                    Kategoriler
                </label>
                <div class="category-grid">
                    <?php foreach ($kategoriler as $kategori) { ?>
                        <label class="category-checkbox">
                            <input type="checkbox" name="kategoriler[]" value="<?php echo $kategori['kategori_id']; ?>">
                            <span><?php echo htmlspecialchars($kategori['kategori_adi']); ?></span>
                        </label>
                    <?php } ?>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">
                    <i class="fas fa-align-left" style="color: #8B4513; margin-right: 6px;"></i>
                    Kitap Açıklaması
                </label>
                <textarea class="form-textarea" name="aciklama" rows="6" placeholder="Kitap hakkında açıklama yazın..."></textarea>
            </div>
            
            <button type="submit" class="btn-submit" name="kitap_ekle">
                <i class="fas fa-plus-circle"></i>
                Kitabı Ekle
            </button>
        </form>
    </div>
    
    <div style="text-align: center; margin-top: 25px;">
        <a href="index.php" style="color: #888; text-decoration: none; font-size: 14px; display: inline-flex; align-items: center; gap: 6px;">
            <i class="fas fa-arrow-left"></i> Ana Sayfaya Dön
        </a>
    </div>
</div>

<style>
    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 20px;
    }
    
    .form-col {
        min-width: 0;
    }
    
    .form-group {
        margin-bottom: 25px;
    }
    
    .form-label {
        display: block;
        font-size: 14px;
        font-weight: 600;
        color: #2c1810;
        margin-bottom: 8px;
    }
    
    .form-input, .form-textarea {
        width: 100%;
        padding: 12px 16px;
        border: 1px solid #e5e5e5;
        border-radius: 10px;
        font-size: 15px;
        transition: all 0.2s;
        background: white;
        font-family: inherit;
    }
    
    .form-input:focus, .form-textarea:focus {
        outline: none;
        border-color: #8B4513;
        box-shadow: 0 0 0 3px rgba(139, 69, 19, 0.1);
    }
    
    .form-input::placeholder, .form-textarea::placeholder {
        color: #bbb;
    }
    
    .form-textarea {
        resize: vertical;
        min-height: 120px;
    }
    
    .category-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
        gap: 12px;
    }
    
    .category-checkbox {
        display: flex;
        align-items: center;
        padding: 10px 14px;
        background: #f5f0eb;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.2s;
        user-select: none;
    }
    
    .category-checkbox:hover {
        background: #ebe1d6;
    }
    
    .category-checkbox input[type="checkbox"] {
        margin-right: 8px;
        cursor: pointer;
        width: 16px;
        height: 16px;
    }
    
    .category-checkbox input[type="checkbox"]:checked + span {
        font-weight: 600;
        color: #8B4513;
    }
    
    .category-checkbox span {
        font-size: 14px;
        color: #5C3317;
    }
    
    .btn-submit {
        width: 100%;
        padding: 16px;
        background: linear-gradient(135deg, #8B4513, #DC143C);
        color: white;
        border: none;
        border-radius: 10px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        margin-top: 30px;
    }
    
    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(139, 69, 19, 0.3);
    }
    
    .success-alert {
        background: #d4edda;
        border: 1px solid #c3e6cb;
        border-left: 4px solid #28a745;
        color: #155724;
        padding: 15px 20px;
        border-radius: 10px;
        margin-bottom: 25px;
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
        margin-bottom: 25px;
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 14px;
    }
    
    @media (max-width: 768px) {
        .form-row {
            grid-template-columns: 1fr;
        }
        
        .category-grid {
            grid-template-columns: 1fr;
        }
    }
</style>