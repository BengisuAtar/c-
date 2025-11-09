<?php 
    // 1. URL'den gelen kitap ID'sini güvenli bir şekilde alıyoruz.
    $kitap_id = isset($_GET["id"]) ? (int)$_GET["id"] : 0;

    // Eğer ID geçerli değilse, hata verip işlemi durduruyoruz.
    if ($kitap_id == 0) {
        echo "<div class='alert alert-danger'>Hatalı istek! Kitap bulunamadı.</div>";
    } else {

        // 2. Kitap bilgilerini ve yazar adını almak için tabloları birleştiriyoruz.
        $sorgu = $db->prepare("
            SELECT 
                kitaplar.*, 
                yazarlar.yazar_adi 
            FROM kitaplar 
            INNER JOIN yazarlar ON kitaplar.yazar_id = yazarlar.yazar_id 
            WHERE kitaplar.kitap_id = ?
        ");

        $sorgu->execute([$kitap_id]);
        $kitap = $sorgu->fetch(PDO::FETCH_ASSOC);

        // 3. Veritabanından kitap bulunduysa bilgilerini gösteriyoruz.
        if ($kitap) {
?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-4">
            <img src="<?php echo htmlspecialchars($kitap['kapak_resmi']); ?>" class="img-fluid rounded" alt="<?php echo htmlspecialchars($kitap['kitap_adi']); ?>">
        </div>

        <div class="col-md-8">
            <h2><?php echo htmlspecialchars($kitap['kitap_adi']); ?></h2>
            <h4 class="text-muted"><?php echo htmlspecialchars($kitap['yazar_adi']); ?></h4>
            <p><strong>Yayın Yılı:</strong> <?php echo htmlspecialchars($kitap['yayin_yili']); ?></p>
            
            <hr>

            <h4>Açıklama</h4>
            <p><?php echo nl2br(htmlspecialchars($kitap['aciklama'])); ?></p>

            <hr>
            
            <button class="btn btn-primary">Kitaplığıma Ekle</button>
        </div>
    </div>

    <hr class="mt-5">

    <div class="row mt-4">
        <div class="col-12">
            <h3>Değerlendirmeler</h3>
            <p class="text-muted">Bu kitap için henüz bir değerlendirme yapılmamış.</p>
            </div>
    </div>
</div>

<?php
        } else {
            // Eğer o ID'ye sahip bir kitap veritabanında yoksa...
            echo "<div class='alert alert-warning'>Aradığınız kitap bulunamadı.</div>";
        }
    }
?>