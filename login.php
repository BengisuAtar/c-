<div class="container" style="max-width: 440px; margin: 60px auto; padding: 0 20px;">

<?php
    if (isset($_POST["uyegiris"])) 
    {
        $eposta = $_POST["eposta"];
        $sifre = $_POST["sifre"];

        $sorgu = $db->prepare("SELECT * FROM kullanicilar WHERE eposta = ?");
        $sorgu->execute([$eposta]);
        
        if ($sorgu->rowCount() > 0)
        {
            $kullanici = $sorgu->fetch(PDO::FETCH_ASSOC);

            if (password_verify($sifre, $kullanici["sifre"]))
            {
                $_SESSION["kullanici_adi"] = $kullanici["kullanici_adi"];
                $_SESSION["eposta"]        = $kullanici["eposta"];
                $_SESSION["kullanici_id"]  = $kullanici["kullanici_id"];

                echo "<div class='success-alert'>
                        <i class='fas fa-check-circle'></i>
                        Giriş başarılı! Yönlendiriliyorsunuz...
                      </div>";
                header("Refresh:2;url=index.php");
            }
            else
            {
                echo "<div class='error-alert'>
                        <i class='fas fa-times-circle'></i>
                        E-posta veya şifre hatalı!
                      </div>";
            }
        }
        else
        {
            echo "<div class='error-alert'>
                    <i class='fas fa-times-circle'></i>
                    E-posta veya şifre hatalı!
                  </div>";
        }
    }
?>

    <div class="auth-box">
        <div style="text-align: center; margin-bottom: 35px;">
            <div style="width: 60px; height: 60px; background: linear-gradient(135deg, #8B4513, #DC143C); border-radius: 12px; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 20px;">
                <i class="fas fa-lock" style="font-size: 26px; color: white;"></i>
            </div>
            <h2 style="font-size: 28px; font-weight: 600; color: #2c1810; margin: 0 0 8px 0;">Giriş Yap</h2>
            <p style="color: #888; font-size: 14px; margin: 0;">Kitap dünyasına hoş geldiniz</p>
        </div>
        
        <form method="POST" action="">
            <div class="form-group">
                <label class="form-label">E-posta</label>
                <input type="email" 
                       name="eposta" 
                       class="form-input" 
                       placeholder="ornek@email.com" 
                       required>
            </div>
            
            <div class="form-group">
                <label class="form-label">Şifre</label>
                <input type="password" 
                       name="sifre" 
                       class="form-input" 
                       placeholder="••••••••" 
                       required>
            </div>
            
            <button type="submit" name="uyegiris" class="btn-submit">
                Giriş Yap
            </button>
        </form>
        
        <div style="text-align: center; margin-top: 25px; padding-top: 25px; border-top: 1px solid #f0f0f0;">
            <p style="color: #888; font-size: 14px; margin-bottom: 12px;">Hesabınız yok mu?</p>
            <a href="index.php?sayfa=uyeol" class="btn-secondary">
                Ücretsiz Üye Ol
            </a>
        </div>
    </div>
</div>