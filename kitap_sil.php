<?php 
// Bu sayfaya sadece giriş yapmış kullanıcılar erişebilmeli
if (!isset($_SESSION["kullanici_id"])) {
    echo "<div class='alert alert-danger'>Bu işlemi yapmak için lütfen giriş yapın.</div>";
    header("Refresh:2;url=index.php?sayfa=login");
    exit;
}

// 1. URL'den gelen kitap ID'sini güvenli bir şekilde alıyoruz.
$kitap_id = isset($_GET["id"]) ? (int)$_GET["id"] : 0;

if ($kitap_id == 0) {
    echo "<div class='alert alert-danger'>Hatalı istek! Silinecek kitap belirtilmedi.</div>";
    header("Refresh:2;url=index.php");
    exit;
}

// NOT: Güvenlik için, silme işlemi yapmadan önce bu kitabı gerçekten
// giriş yapan kullanıcının (kullanici_id) eklediğini kontrol etmek GEREKİR.
// Ancak mevcut veritabanı şemanızda 'kitaplar' tablosunda 'kullanici_id' sütunu yok.
// Bu yüzden bu kontrolü atlıyoruz, ancak bir sonraki aşamada eklenmelidir!

// 2. Kitabı silme sorgusunu hazırlıyoruz.
// NOT: PDO'daki CASCADE kısıtlamaları sayesinde, kitap_kategori tablosundaki 
// ilgili ilişkiler otomatik olarak silinecektir.
$sorgu = $db->prepare("DELETE FROM kitaplar WHERE kitap_id = ?");

$silme = $sorgu->execute([$kitap_id]);

if ($silme) {
    echo "<div class='alert alert-success mt-4'>Kitap başarıyla silinmiştir! Anasayfaya yönlendiriliyorsunuz...</div>";
    header("Refresh:2;url=index.php");
} else {
    echo "<div class='alert alert-danger mt-4'>Hata: Kitap silinirken bir sorun oluştu.</div>";
}
?>

<div class="container mt-5">
    </div>