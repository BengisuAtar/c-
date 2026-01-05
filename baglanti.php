<?php 
// 1. Output Buffering Başlat (Header hatalarını önler)
ob_start();

// 2. Session (Oturum) başlatma
if (!isset($_SESSION)) {
    session_start();
}

// 3. Veritabanı Bağlantısı (PDO)
try {
    $db = new PDO("mysql:host=localhost;dbname=okuva_db_final", "root", "");
    
    // 4. Türkçe Karakter Desteği Ayarı
    $db->query("SET NAMES UTF8");
    
    // 5. PDO Hata Modunu Ayarla
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
} catch(PDOException $e) {
    die("Veritabanı Bağlantı Hatası: " . $e->getMessage());
}
?>