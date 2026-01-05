<footer style="background: white; margin-top: 80px; border-top: 1px solid #e5e5e5;">
    <div style="max-width: 1200px; margin: 0 auto; padding: 60px 20px 30px;">
        <div class="row">
            <!-- Logo & About -->
            <div class="col-md-4 mb-4">
                <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 20px;">
                    <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #8B4513, #DC143C); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white; font-size: 20px;">
                        <i class="fas fa-book"></i>
                    </div>
                    <span style="font-size: 24px; font-weight: 700; color: #2c1810;">OKUVA</span>
                </div>
                <p style="color: #666; line-height: 1.7; font-size: 14px; margin-bottom: 20px;">
                    Kitap severler için tasarlanmış modern platform. Yeni kitaplar keşfedin, 
                    okuma listenizi oluşturun ve kitap topluluğuyla deneyimlerinizi paylaşın.
                </p>
                <div style="color: #888; font-size: 13px;">
                    <i class="fas fa-book mr-2" style="color: #8B4513;"></i>
                    <?php 
                        try {
                            $kitap_sayisi = $db->query("SELECT COUNT(*) FROM kitaplar")->fetchColumn();
                            echo number_format($kitap_sayisi) . " kitap";
                        } catch(Exception $e) {
                            echo "Binlerce kitap";
                        }
                    ?>
                </div>
            </div>
            
            <!-- Quick Links -->
            <div class="col-md-2 col-6 mb-4">
                <h6 style="font-size: 14px; font-weight: 600; color: #2c1810; margin-bottom: 20px; text-transform: uppercase; letter-spacing: 0.5px;">Keşfet</h6>
                <ul style="list-style: none; padding: 0; margin: 0;">
                    <li style="margin-bottom: 12px;">
                        <a href="index.php" class="footer-link">Ana Sayfa</a>
                    </li>
                    <li style="margin-bottom: 12px;">
                        <a href="index.php?sayfa=kitaplar" class="footer-link">Tüm Kitaplar</a>
                    </li>
                    <li style="margin-bottom: 12px;">
                        <a href="index.php?sayfa=arama" class="footer-link">Kitap Ara</a>
                    </li>
                    <?php if (isset($_SESSION["kullanici_id"])) { ?>
                    <li style="margin-bottom: 12px;">
                        <a href="index.php?sayfa=kitapekle" class="footer-link">Kitap Ekle</a>
                    </li>
                    <?php } ?>
                </ul>
            </div>
            
            <!-- Account -->
            <div class="col-md-2 col-6 mb-4">
                <h6 style="font-size: 14px; font-weight: 600; color: #2c1810; margin-bottom: 20px; text-transform: uppercase; letter-spacing: 0.5px;">Hesap</h6>
                <ul style="list-style: none; padding: 0; margin: 0;">
                    <?php if (isset($_SESSION["kullanici_id"])) { ?>
                    <li style="margin-bottom: 12px;">
                        <a href="index.php?sayfa=profil" class="footer-link">Profilim</a>
                    </li>
                    <li style="margin-bottom: 12px;">
                        <a href="index.php?sayfa=profil" class="footer-link">Kitaplığım</a>
                    </li>
                    <li style="margin-bottom: 12px;">
                        <a href="cikis.php" class="footer-link">Çıkış Yap</a>
                    </li>
                    <?php } else { ?>
                    <li style="margin-bottom: 12px;">
                        <a href="index.php?sayfa=login" class="footer-link">Giriş Yap</a>
                    </li>
                    <li style="margin-bottom: 12px;">
                        <a href="index.php?sayfa=uyeol" class="footer-link">Üye Ol</a>
                    </li>
                    <?php } ?>
                </ul>
            </div>
            
            <!-- Contact -->
            <div class="col-md-4 mb-4">
                <h6 style="font-size: 14px; font-weight: 600; color: #2c1810; margin-bottom: 20px; text-transform: uppercase; letter-spacing: 0.5px;">İletişim</h6>
                <div style="margin-bottom: 12px;">
                    <a href="mailto:info@okuva.com" class="footer-link" style="display: flex; align-items: center; gap: 10px;">
                        <i class="fa fa-envelope" style="color: #8B4513; width: 16px;"></i>
                        info@okuva.com
                    </a>
                </div>
                <div style="margin-bottom: 12px;">
                    <a href="tel:+905551234567" class="footer-link" style="display: flex; align-items: center; gap: 10px;">
                        <i class="fa fa-phone" style="color: #8B4513; width: 16px;"></i>
                        +90 (xxx) xxx xx xx
                    </a>
                </div>
                <div style="margin-bottom: 20px;">
                    <span class="footer-link" style="display: flex; align-items: center; gap: 10px;">
                        <i class="fa fa-map-marker-alt" style="color: #8B4513; width: 16px;"></i>
                        Eskişehir, Sivrihisar
                    </span>
                </div>
                
                <!-- Social Media -->
                <div style="display: flex; gap: 10px; margin-top: 20px;">
                    <a href="#" class="social-icon">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="social-icon">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="social-icon">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" class="social-icon">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Bottom Bar -->
        <div style="border-top: 1px solid #f0f0f0; margin-top: 40px; padding-top: 25px;">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-left mb-3 mb-md-0">
                    <p style="margin: 0; color: #888; font-size: 13px;">
                        © <?php echo date("Y"); ?> OKUVA. Tüm hakları saklıdır.
                    </p>
                </div>
                <div class="col-md-6 text-center text-md-right">
                    <p style="margin: 0; color: #888; font-size: 13px;">
                        <i class="fas fa-heart" style="color: #DC143C;"></i> Bengisu Atar
                    </p>
                </div>
            </div>
        </div>
    </div>
</footer>

<style>
    .footer-link {
        color: #666;
        text-decoration: none;
        font-size: 14px;
        transition: color 0.2s;
    }
    
    .footer-link:hover {
        color: #8B4513;
    }
    
    .social-icon {
        width: 36px;
        height: 36px;
        background: #f5f0eb;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #8B4513;
        text-decoration: none;
        transition: all 0.2s;
    }
    
    .social-icon:hover {
        background: #8B4513;
        color: white;
        transform: translateY(-2px);
    }
</style>