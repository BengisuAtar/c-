 
<div class="container mt-3" style="width: 450px;">

<?php
    if (isset($_POST["uyegiris"])) 
    {
        $eposta = $_POST["eposta"];
        $sifre = $_POST["sifre"];

        // 1. Sadece e-posta adresine göre kullanıcıyı buluyoruz.
        $sorgu = $db->prepare("SELECT * FROM kullanicilar WHERE eposta = ?");
        $sorgu->execute([$eposta]);
        
        // 2. Kullanıcı bulundu mu diye kontrol ediyoruz.
        if ($sorgu->rowCount() > 0)
        {
            $kullanici = $sorgu->fetch(PDO::FETCH_ASSOC);

            // 3. GÜVENLİK: Kullanıcının girdiği şifre ile veritabanındaki HASH'lenmiş şifreyi karşılaştırıyoruz.
            if (password_verify($sifre, $kullanici["sifre"]))
            {
                // Şifre doğruysa, session'ları başlatıyoruz.
                $_SESSION["kullanici_adi"] = $kullanici["kullanici_adi"];
                $_SESSION["eposta"]        = $kullanici["eposta"];
                $_SESSION["kullanici_id"]  = $kullanici["kullanici_id"]; // Bu çok önemli!

                echo "<div class='alert alert-success'>Giriş başarılı! Anasayfaya yönlendiriliyorsunuz...</div>";
                header("Refresh:2;url=index.php");
            }
            else
            {
                // Şifre yanlışsa...
                echo "<div class='alert alert-danger'>E-posta veya şifre hatalı!</div>";
            }
        }
        else
        {
            // E-posta bulunamadıysa...
            echo "<div class='alert alert-danger'>E-posta veya şifre hatalı!</div>";
        }
    }
?>

    <div style="padding: 20px; box-sizing: border-box; box-shadow: 0px 0px 10px #ccc; margin-top: 20px;">
        <form method="POST" action="">
            <h3 class="mt-2 text-center">OKUVA'YA GİRİŞ YAP</h3>
            <div class="row mt-3">
                <div class="input-group input-group-lg">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                    </div>
                    <input type="email" name="eposta" class="form-control" placeholder="E-posta Adresinizi Girin" required>
                </div>
                <div class="input-group input-group-lg mt-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-key"></i></span>
                    </div>
                    <input type="password" name="sifre" class="form-control" placeholder="Şifrenizi Girin" required>
                </div>  
            </div>
            <div class="row mt-4">
                <div class="input-group w-100">
                    <button class="btn btn-outline-success btn-lg w-100" name="uyegiris">GİRİŞ YAP</button> 
                </div>
            </div>
        </form>
    </div>
</div>

 
