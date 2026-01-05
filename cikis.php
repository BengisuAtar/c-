<?php 
// 1. Output buffering başlat (header hatalarını önler)
ob_start();

// 2. Session başlat (eğer başlatılmamışsa)
if (!isset($_SESSION)) {
    session_start();
}

// 3. Kullanıcı bilgilerini kaydet (isteğe bağlı - log için)
$kullanici_adi = isset($_SESSION["kullanici_adi"]) ? $_SESSION["kullanici_adi"] : "Bilinmeyen";

// 4. Tüm session verilerini temizle
session_unset();

// 5. Session'ı tamamen yok et
session_destroy();

// 6. Cookie'leri de temizle (varsa)
if (isset($_COOKIE['PHPSESSID'])) {
    setcookie('PHPSESSID', '', time() - 3600, '/');
}

// 7. Tarayıcı cache'ini temizle
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

// 8. Anasayfaya yönlendir
header("Location: index.php");

// 9. Output buffer'ı temizle ve gönder
if (ob_get_level()) {
    ob_end_flush();
}

exit();
?>