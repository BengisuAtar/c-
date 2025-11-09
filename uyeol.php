<div class="container mt-3" style="width: 600px;">
    
<?php 
    
    if (isset($_POST["uyeol"]))
    {
        // Formdan gelen verileri alıyoruz
        $kullanici_adi  = $_POST["kullanici_adi"];
        $eposta         = $_POST["eposta"];
        $sifre          = $_POST["sifre"];
        $sifre_tekrar   = $_POST["sifre_tekrar"];

        // Şifrelerin eşleşip eşleşmediğini kontrol ediyoruz
        if ($sifre == $sifre_tekrar) 
        {
            // E-posta veya kullanıcı adının daha önce alınıp alınmadığını kontrol ediyoruz
            $sorgu = $db->prepare("SELECT * FROM kullanicilar WHERE eposta=? OR kullanici_adi=?");
            $sorgu->execute([$eposta, $kullanici_adi]);

            if ($sorgu->rowCount()) 
            {
                echo "<div class='alert alert-danger'>Bu e-posta veya kullanıcı adı daha önce alınmış!</div>";
            }
            else
            {
                // ŞİFRE GÜVENLİĞİ: Şifreyi asla düz metin olarak kaydetmiyoruz!
                // password_hash() fonksiyonu ile güvenli bir şekilde şifreliyoruz.
                $sifre_hash = password_hash($sifre, PASSWORD_DEFAULT);

                $ekleme_sorgusu = $db->prepare("INSERT INTO kullanicilar SET 
                kullanici_adi=?,
                eposta=?,
                sifre=?
                ");

                $kullanici_ekle = $ekleme_sorgusu->execute([
                    $kullanici_adi,
                    $eposta,
                    $sifre_hash // Veritabanına şifrelenmiş halini kaydediyoruz
                ]);

                if ($kullanici_ekle) 
                {
                    echo "<div class='alert alert-success'>Kayıt Başarılı! Giriş sayfasına yönlendiriliyorsunuz...</div>";
                    header("Refresh:2;url=index.php?sayfa=login");
                }
                else
                {
                    echo "<div class='alert alert-danger'>Hata: Kayıt işlemi başarısız oldu!</div>";    
                }
            }
        }
        else
        {
            echo "<div class='alert alert-danger'>Girdiğiniz şifreler uyuşmuyor!</div>";
        }   
    }
?>  
    <h3 align="center">Okuva'ya Ücretsiz Üye Olun</h3>
    <form method="POST" action="">
        <div class="input-group-lg">
            <input type="text" class="form-control input-group-lg mt-3" name="kullanici_adi" placeholder="Kullanıcı Adınızı Girin" required>
            <input type="email" class="form-control mt-3" name="eposta" placeholder="E-posta Adresinizi Girin" required>
            <input type="password" class="form-control mt-3" name="sifre" placeholder="Şifrenizi Girin" required>
            <input type="password" class="form-control mt-3" name="sifre_tekrar" placeholder="Şifrenizi Tekrar Girin" required>

            <button class="btn btn-primary mt-3 mb-5 p-3 w-100" name="uyeol">Üye Ol</button>
        </div>
    </form>
</div>
