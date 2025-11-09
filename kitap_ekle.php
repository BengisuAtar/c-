<div class="container mt-3" style="width: 800px;">

<?php 
    // kitap-ekle.php - DÜZELTİLMİŞ VERSİYON

    // Form gönderilmiş mi kontrol ediliyor.
    if (isset($_POST["kitap_ekle"])) {

        // 1. Formdan gelen verileri alıyoruz (veritabanı sütunlarına uygun)
        $kitap_adi      = $_POST["kitap_adi"];
        $yazar_adi_form = $_POST["yazar_adi"]; // Formdan gelen yazar ADI
        $aciklama       = $_POST["aciklama"];
        $kapak_resmi    = $_POST["kapak_resmi_url"]; // Formdaki 'kapak_resmi_url' idi
        $yayin_yili     = $_POST["yayin_yili"];

        // Alanların boş olup olmadığını kontrol edelim
        if (!empty($kitap_adi) && !empty($yazar_adi_form)) {
            
            // 2. YAZAR KONTROLÜ: Formdan gelen yazar adı veritabanında var mı?
            $sorgu_yazar = $db->prepare("SELECT * FROM yazarlar WHERE yazar_adi = ?");
            $sorgu_yazar->execute([$yazar_adi_form]);

            if ($sorgu_yazar->rowCount() > 0) {
                // Yazar varsa, ID'sini al
                $yazar = $sorgu_yazar->fetch(PDO::FETCH_ASSOC);
                $yazar_id = $yazar['yazar_id'];
            } else {
                // Yazar yoksa, 'yazarlar' tablosuna YENİ yazar ekle
                $sorgu_yeni_yazar = $db->prepare("INSERT INTO yazarlar SET yazar_adi = ?");
                $sorgu_yeni_yazar->execute([$yazar_adi_form]);
                
                // Eklenen yeni yazarın ID'sini al
                $yazar_id = $db->lastInsertId();
            }

            // 3. KİTAP EKLEME: Artık doğru 'yazar_id' elimizde.
            // Veritabanı şemanızla (okuva_db.sql) tam uyumlu sorgu:
            $sorgu = $db->prepare("INSERT INTO kitaplar SET 
                kitap_adi=?,
                yazar_id=?, 
                aciklama=?,
                kapak_resmi=?,
                yayin_yili=?
            ");

            $ekle = $sorgu->execute([
                $kitap_adi,
                $yazar_id, // Bulunan veya yeni eklenen yazarın ID'si
                $aciklama,
                $kapak_resmi,
                $yayin_yili
            ]);

            if ($ekle) {
                echo "<div class='alert alert-success'>Kitap başarıyla eklendi!</div>";
                header("Refresh:2;url=index.php"); // Anasayfaya yönlendir
            } else {
                echo "<div class='alert alert-danger'>Hata: Kitap eklenemedi!</div>";    
            }

        } else {
            echo "<div class='alert alert-warning'>Kitap adı ve yazar adı boş bırakılamaz!</div>";
        }
    }
?>

    <h3 align="center">SİSTEME YENİ KİTAP EKLE</h3>
    <form method="POST" action="">
        <div class="input-group-lg mt-3">
            <label>Kitap Adı:</label>
            <input type="text" class="form-control" name="kitap_adi" placeholder="Kitabın adını girin">
        </div>

        <div class="input-group-lg mt-3">
            <label>Yazar Adı:</label>
            <input type="text" class="form-control" name="yazar_adi" placeholder="Yazarın adını girin">
        </div>

        <div class="input-group-lg mt-3">
            <label>Yayın Yılı:</label>
            <input type="number" class="form-control" name="yayin_yili" placeholder="Örn: 1984">
        </div>
        
        <div class="input-group-lg mt-3">
            <label>Kapak Resmi (URL):</label>
            <input type="text" class="form-control" name="kapak_resmi_url" placeholder="https://ornek.com/resim.jpg">
        </div>

        <div class="input-group-lg mt-3">
            <label>Kitap Açıklaması:</label>
            <textarea class="form-control" name="aciklama" rows="5"></textarea>
        </div>
        
        <button class="btn btn-primary mt-3 mb-5 p-3 w-100" name="kitap_ekle">Kitabı Ekle</button>
    </form>
</div>