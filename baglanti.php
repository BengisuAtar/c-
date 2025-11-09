<?php 
// Okuva Modu - 'bu kod tarzında' baglanti.php

// 1. Session (Oturum) başlatma
// 'menu.php' ve 'login.php' dosyalarınızın çalışması için bu gereklidir.
if (!isset($_SESSION)) {
    session_start();
}

// 2. Veritabanı Bağlantısı (PDO)
// "alisveris" yerine kendi veritabanı adınızı ("okuva_db") yazıyoruz.
$db = new PDO("mysql:host=localhost;dbname=okuva_db", "root", "");

// 3. Türkçe Karakter Desteği Ayarı
// İstediğiniz 'bu kod tarzında' olduğu gibi.
$db->query("SET NAMES UTF8");

?>