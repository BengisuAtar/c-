<?php 
    // Oturum değişkenlerini temizliyoruz
    session_unset();
    
    // Oturumu tamamen sonlandırıyoruz
    session_destroy();
    
    // Kullanıcıyı anasayfaya yönlendiriyoruz
    header("Location: index.php");
    exit();
?>