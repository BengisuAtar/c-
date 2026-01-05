<div class="container" style="max-width: 440px; margin: 60px auto; padding: 0 20px;">
    
<?php 
    if (isset($_POST["uyeol"]))
    {
        $kullanici_adi  = $_POST["kullanici_adi"];
        $eposta         = $_POST["eposta"];
        $sifre          = $_POST["sifre"];
        $sifre_tekrar   = $_POST["sifre_tekrar"];

        if ($sifre == $sifre_tekrar) 
        {
            $sorgu = $db->prepare("SELECT * FROM kullanicilar WHERE eposta=? OR kullanici_adi=?");
            $sorgu->execute([$eposta, $kullanici_adi]);

            if ($sorgu->rowCount()) 
            {
                echo "<div class='error-alert'>
                        <i class='fas fa-exclamation-triangle'></i>
                        Bu e-posta veya kullanıcı adı zaten kullanılıyor!
                      </div>";
            }
            else
            {
                $sifre_hash = password_hash($sifre, PASSWORD_DEFAULT);

                $ekleme_sorgusu = $db->prepare("INSERT INTO kullanicilar SET 
                    kullanici_adi=?,
                    eposta=?,
                    sifre=?
                ");

                $kullanici_ekle = $ekleme_sorgusu->execute([
                    $kullanici_adi,
                    $eposta,
                    $sifre_hash
                ]);

                if ($kullanici_ekle) 
                {
                    echo "<div class='success-alert'>";
                    echo "<i class='fas fa-check-circle'></i>";
                    echo "Kayıt başarılı! Giriş sayfasına yönlendiriliyorsunuz...";
                    echo "</div>";
                    
                    echo "<script>";
                    echo "setTimeout(function() { window.location.href = 'index.php?sayfa=login'; }, 2000);";
                    echo "</script>";
                }
                else
                {
                    echo "<div class='error-alert'>
                            <i class='fas fa-times-circle'></i>
                            Kayıt işlemi başarısız!
                          </div>";
                }
            }
        }
        else
        {
            echo "<div class='error-alert'>
                    <i class='fas fa-exclamation-triangle'></i>
                    Girdiğiniz şifreler uyuşmuyor!
                  </div>";
        }   
    }
?>

    <div class="auth-box">
        <div style="text-align: center; margin-bottom: 35px;">
            <div style="width: 60px; height: 60px; background: linear-gradient(135deg, #8B4513, #DC143C); border-radius: 12px; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 20px;">
                <i class="fas fa-user-plus" style="font-size: 26px; color: white;"></i>
            </div>
            <h2 style="font-size: 28px; font-weight: 600; color: #2c1810; margin: 0 0 8px 0;">Üye Ol</h2>
            <p style="color: #888; font-size: 14px; margin: 0;">Ücretsiz ve kolay</p>
        </div>
        
        <form method="POST" action="">
            <div class="form-group">
                <label class="form-label">Kullanıcı Adı</label>
                <input type="text" 
                       class="form-input" 
                       name="kullanici_adi" 
                       placeholder="Kullanıcı adınız" 
                       required>
            </div>
            
            <div class="form-group">
                <label class="form-label">E-posta</label>
                <input type="email" 
                       class="form-input" 
                       name="eposta" 
                       placeholder="ornek@email.com" 
                       required>
            </div>
            
            <div class="form-group">
                <label class="form-label">Şifre</label>
                <input type="password" 
                       class="form-input" 
                       name="sifre" 
                       placeholder="En az 6 karakter" 
                       required
                       minlength="6">
                <small style="color: #888; font-size: 12px; margin-top: 5px; display: block;">En az 6 karakter olmalıdır</small>
            </div>
            
            <div class="form-group">
                <label class="form-label">Şifre Tekrar</label>
                <input type="password" 
                       class="form-input" 
                       name="sifre_tekrar" 
                       placeholder="Şifrenizi tekrar girin" 
                       required
                       minlength="6">
            </div>

            <button type="submit" name="uyeol" class="btn-submit">
                Üye Ol
            </button>
        </form>
        
        <div style="text-align: center; margin-top: 25px; padding-top: 25px; border-top: 1px solid #f0f0f0;">
            <p style="color: #888; font-size: 14px; margin-bottom: 12px;">Zaten hesabınız var mı?</p>
            <a href="index.php?sayfa=login" class="btn-secondary">
                Giriş Yap
            </a>
        </div>
    </div>
</div>

<style>
    .auth-box {
        background: white;
        padding: 40px;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        border: 1px solid #f0f0f0;
    }
    
    .form-group {
        margin-bottom: 20px;
    }
    
    .form-label {
        display: block;
        font-size: 14px;
        font-weight: 500;
        color: #2c1810;
        margin-bottom: 8px;
    }
    
    .form-input {
        width: 100%;
        padding: 12px 16px;
        border: 1px solid #e5e5e5;
        border-radius: 10px;
        font-size: 15px;
        transition: all 0.2s;
        background: white;
    }
    
    .form-input:focus {
        outline: none;
        border-color: #8B4513;
        box-shadow: 0 0 0 3px rgba(139, 69, 19, 0.1);
    }
    
    .form-input::placeholder {
        color: #bbb;
    }
    
    .btn-submit {
        width: 100%;
        padding: 14px;
        background: linear-gradient(135deg, #8B4513, #DC143C);
        color: white;
        border: none;
        border-radius: 10px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        margin-top: 10px;
    }
    
    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(139, 69, 19, 0.3);
    }
    
    .btn-secondary {
        display: inline-block;
        padding: 10px 24px;
        background: white;
        color: #8B4513;
        border: 1.5px solid #8B4513;
        border-radius: 10px;
        text-decoration: none;
        font-weight: 500;
        font-size: 14px;
        transition: all 0.2s;
    }
    
    .btn-secondary:hover {
        background: #8B4513;
        color: white;
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
</style>