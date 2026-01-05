<?php 
    // Kullanıcı giriş yapmış mı kontrol ediyoruz
    if (!isset($_SESSION["kullanici_id"])) {
        echo "<div class='container mt-5 text-center'>";
        echo "<div class='alert alert-warning'>";
        echo "<h4><i class='fa fa-exclamation-triangle'></i> Bu sayfayı görüntülemek için giriş yapmalısınız!</h4>";
        echo "<a href='index.php?sayfa=login' class='btn btn-primary mt-3'>Giriş Yap</a>";
        echo "</div>";
        echo "</div>";
        exit();
    }

    // Kullanıcı bilgilerini çekiyoruz
    $kullanici_id = $_SESSION["kullanici_id"];
    
    $sorgu = $db->prepare("SELECT * FROM kullanicilar WHERE kullanici_id = ?");
    $sorgu->execute([$kullanici_id]);
    $kullanici = $sorgu->fetch(PDO::FETCH_ASSOC);
    
    // Kitaplık istatistiklerini çek
    $okundu_sorgu = $db->prepare("SELECT COUNT(*) as sayi FROM kullanici_kitaplik WHERE kullanici_id = ? AND durum = 'okundu'");
    $okundu_sorgu->execute([$kullanici_id]);
    $okundu_sayisi = $okundu_sorgu->fetch(PDO::FETCH_ASSOC)['sayi'];
    
    $okunacak_sorgu = $db->prepare("SELECT COUNT(*) as sayi FROM kullanici_kitaplik WHERE kullanici_id = ? AND durum = 'okunacak'");
    $okunacak_sorgu->execute([$kullanici_id]);
    $okunacak_sayisi = $okunacak_sorgu->fetch(PDO::FETCH_ASSOC)['sayi'];
    
    $okunuyor_sorgu = $db->prepare("SELECT COUNT(*) as sayi FROM kullanici_kitaplik WHERE kullanici_id = ? AND durum = 'okunuyor'");
    $okunuyor_sorgu->execute([$kullanici_id]);
    $okunuyor_sayisi = $okunuyor_sorgu->fetch(PDO::FETCH_ASSOC)['sayi'];
    
    // Kullanıcının eklediği kitap sayısı
    $eklenen_kitap_sorgu = $db->prepare("SELECT COUNT(*) as sayi FROM kitaplar WHERE ekleyen_kullanici_id = ?");
    $eklenen_kitap_sorgu->execute([$kullanici_id]);
    $eklenen_kitap_sayisi = $eklenen_kitap_sorgu->fetch(PDO::FETCH_ASSOC)['sayi'];
    
    // Profil güncelleme işlemi
    if (isset($_POST["profil_guncelle"])) {
        $yeni_kullanici_adi = $_POST["kullanici_adi"];
        $yeni_eposta = $_POST["eposta"];
        
        // E-posta veya kullanıcı adı başkası tarafından kullanılıyor mu kontrol et
        $kontrol_sorgu = $db->prepare("
            SELECT * FROM kullanicilar 
            WHERE (eposta = ? OR kullanici_adi = ?) 
            AND kullanici_id != ?
        ");
        $kontrol_sorgu->execute([$yeni_eposta, $yeni_kullanici_adi, $kullanici_id]);
        
        if ($kontrol_sorgu->rowCount() > 0) {
            echo "<div class='container mt-4'><div class='alert alert-danger'>Bu e-posta veya kullanıcı adı başkası tarafından kullanılıyor!</div></div>";
        } else {
            $guncelle_sorgu = $db->prepare("
                UPDATE kullanicilar SET 
                kullanici_adi = ?,
                eposta = ?
                WHERE kullanici_id = ?
            ");
            
            if ($guncelle_sorgu->execute([$yeni_kullanici_adi, $yeni_eposta, $kullanici_id])) {
                $_SESSION["kullanici_adi"] = $yeni_kullanici_adi;
                $_SESSION["eposta"] = $yeni_eposta;
                echo "<div class='container mt-4'><div class='alert alert-success'>Profiliniz başarıyla güncellendi!</div></div>";
                echo "<script>setTimeout(function() { window.location.reload(); }, 2000);</script>";
            }
        }
    }
    
    // Şifre değiştirme işlemi
    if (isset($_POST["sifre_degistir"])) {
        $eski_sifre = $_POST["eski_sifre"];
        $yeni_sifre = $_POST["yeni_sifre"];
        $yeni_sifre_tekrar = $_POST["yeni_sifre_tekrar"];
        
        if (password_verify($eski_sifre, $kullanici["sifre"])) {
            if ($yeni_sifre == $yeni_sifre_tekrar) {
                $sifre_hash = password_hash($yeni_sifre, PASSWORD_DEFAULT);
                
                $sifre_guncelle = $db->prepare("UPDATE kullanicilar SET sifre = ? WHERE kullanici_id = ?");
                
                if ($sifre_guncelle->execute([$sifre_hash, $kullanici_id])) {
                    echo "<div class='container mt-4'><div class='alert alert-success'>Şifreniz başarıyla değiştirildi!</div></div>";
                }
            } else {
                echo "<div class='container mt-4'><div class='alert alert-danger'>Yeni şifreler uyuşmuyor!</div></div>";
            }
        } else {
            echo "<div class='container mt-4'><div class='alert alert-danger'>Eski şifreniz hatalı!</div></div>";
        }
    }
?>

<div class="container mt-4">
    
    <!-- PROFİL BAŞLIĞI -->
    <div class="row mb-4">
        <div class="col-12">
            <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 50px; border-radius: 15px; color: white; box-shadow: 0 5px 15px rgba(0,0,0,0.2); position: relative; overflow: hidden;">
                <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0.1; background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'1\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
                
                <div class="row align-items-center" style="position: relative; z-index: 2;">
                    <div class="col-md-2 text-center mb-3 mb-md-0">
                        <div style="width: 120px; height: 120px; background: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto; box-shadow: 0 5px 15px rgba(0,0,0,0.3);">
                            <span style="font-size: 60px; font-weight: bold; color: #667eea;">
                                <?php echo mb_strtoupper(mb_substr($kullanici["kullanici_adi"], 0, 1, 'UTF-8'), 'UTF-8'); ?>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-10">
                        <h2 style="font-weight: bold; margin-bottom: 10px;">
                            <?php echo htmlspecialchars($kullanici["kullanici_adi"]); ?>
                        </h2>
                        <p style="margin-bottom: 5px; opacity: 0.9;">
                            <i class="fa fa-envelope"></i> <?php echo htmlspecialchars($kullanici["eposta"]); ?>
                        </p>
                        <p style="margin: 0; opacity: 0.9;">
                            <i class="fa fa-calendar"></i> Üyelik Tarihi: <?php echo date("d.m.Y", strtotime($kullanici["kayit_tarihi"])); ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- İSTATİSTİKLER -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card shadow-sm" style="border: none; border-radius: 15px; background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white;">
                <div class="card-body text-center p-4">
                    <i class="fa fa-check-circle" style="font-size: 50px; margin-bottom: 15px;"></i>
                    <h3 style="font-weight: bold; margin-bottom: 5px;"><?php echo $okundu_sayisi; ?></h3>
                    <p style="margin: 0; opacity: 0.9;">Okuduğum Kitaplar</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-3">
            <div class="card shadow-sm" style="border: none; border-radius: 15px; background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white;">
                <div class="card-body text-center p-4">
                    <i class="fa fa-book-open" style="font-size: 50px; margin-bottom: 15px;"></i>
                    <h3 style="font-weight: bold; margin-bottom: 5px;"><?php echo $okunuyor_sayisi; ?></h3>
                    <p style="margin: 0; opacity: 0.9;">Şu An Okuduklarım</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-3">
            <div class="card shadow-sm" style="border: none; border-radius: 15px; background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); color: white;">
                <div class="card-body text-center p-4">
                    <i class="fa fa-bookmark" style="font-size: 50px; margin-bottom: 15px;"></i>
                    <h3 style="font-weight: bold; margin-bottom: 5px;"><?php echo $okunacak_sayisi; ?></h3>
                    <p style="margin: 0; opacity: 0.9;">Okuma Listem</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-3">
            <div class="card shadow-sm" style="border: none; border-radius: 15px; background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); color: white;">
                <div class="card-body text-center p-4">
                    <i class="fa fa-plus-circle" style="font-size: 50px; margin-bottom: 15px;"></i>
                    <h3 style="font-weight: bold; margin-bottom: 5px;"><?php echo $eklenen_kitap_sayisi; ?></h3>
                    <p style="margin: 0; opacity: 0.9;">Eklediğim Kitaplar</p>
                </div>
            </div>
        </div>
    </div>

    <!-- TAB MENÜ -->
    <div class="row">
        <div class="col-12">
            <ul class="nav nav-tabs" style="border-bottom: 3px solid #667eea;">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#kitapligim" style="font-weight: bold; color: #667eea;">
                        <i class="fa fa-book"></i> Kitaplığım
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#bilgilerim" style="font-weight: bold; color: #667eea;">
                        <i class="fa fa-user"></i> Bilgilerim
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#sifreDegistir" style="font-weight: bold; color: #667eea;">
                        <i class="fa fa-lock"></i> Şifre Değiştir
                    </a>
                </li>
            </ul>

            <div class="tab-content mt-4">
                
                <!-- KİTAPLIĞIM TAB -->
                <div id="kitapligim" class="tab-pane fade show active">
                    <div class="card shadow-sm" style="border: none; border-radius: 15px;">
                        <div class="card-body p-4">
                            <h4 class="mb-4"><i class="fa fa-book text-primary"></i> Kitaplığım</h4>
                            
                            <?php
                                // Kullanıcının kitaplığındaki kitapları çek
                                $kitaplik_sorgu = $db->prepare("
                                    SELECT 
                                        k.kitap_id, k.kitap_adi, k.kapak_resmi,
                                        y.yazar_adi,
                                        kk.durum
                                    FROM kullanici_kitaplik kk
                                    INNER JOIN kitaplar k ON kk.kitap_id = k.kitap_id
                                    INNER JOIN yazarlar y ON k.yazar_id = y.yazar_id
                                    WHERE kk.kullanici_id = ?
                                    ORDER BY kk.eklenme_tarihi DESC
                                ");
                                $kitaplik_sorgu->execute([$kullanici_id]);
                                $kitaplik = $kitaplik_sorgu->fetchAll(PDO::FETCH_ASSOC);
                                
                                if ($kitaplik) {
                            ?>
                                <div class="row">
                                    <?php foreach ($kitaplik as $kitap) { ?>
                                        <div class="col-md-3 mb-4">
                                            <div class="card h-100 shadow-sm" style="border: none; border-radius: 10px;">
                                                <a href="index.php?sayfa=kitapdetay&id=<?php echo $kitap['kitap_id']; ?>">
                                                    <img src="<?php echo htmlspecialchars($kitap['kapak_resmi']); ?>" 
                                                         class="card-img-top" 
                                                         alt="<?php echo htmlspecialchars($kitap['kitap_adi']); ?>"
                                                         style="height: 200px; object-fit: cover; border-radius: 10px 10px 0 0;">
                                                </a>
                                                <div class="card-body">
                                                    <h6 class="card-title text-truncate"><?php echo htmlspecialchars($kitap['kitap_adi']); ?></h6>
                                                    <p class="card-text text-muted small"><?php echo htmlspecialchars($kitap['yazar_adi']); ?></p>
                                                    <span class="badge 
                                                        <?php 
                                                            if ($kitap['durum'] == 'okundu') echo 'badge-success';
                                                            elseif ($kitap['durum'] == 'okunuyor') echo 'badge-info';
                                                            else echo 'badge-warning';
                                                        ?>">
                                                        <?php 
                                                            if ($kitap['durum'] == 'okundu') echo '✅ Okundu';
                                                            elseif ($kitap['durum'] == 'okunuyor') echo '📖 Okunuyor';
                                                            else echo '📚 Okunacak';
                                                        ?>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            <?php 
                                } else {
                                    echo "<div class='text-center py-5'>";
                                    echo "<i class='fa fa-book-open' style='font-size: 80px; color: #ddd; margin-bottom: 20px;'></i>";
                                    echo "<h5 style='color: #999;'>Henüz kitaplığınızda kitap yok</h5>";
                                    echo "<p class='text-muted'>Kitaplara göz atın ve okuma listenize ekleyin!</p>";
                                    echo "<a href='index.php?sayfa=kitaplar' class='btn btn-primary mt-3' style='border-radius: 50px;'>";
                                    echo "<i class='fa fa-book mr-1'></i> Kitaplara Göz At";
                                    echo "</a>";
                                    echo "</div>";
                                }
                            ?>
                        </div>
                    </div>
                </div>

                <!-- BİLGİLERİM TAB -->
                <div id="bilgilerim" class="tab-pane fade">
                    <div class="card shadow-sm" style="border: none; border-radius: 15px;">
                        <div class="card-body p-4">
                            <h4 class="mb-4"><i class="fa fa-edit text-primary"></i> Profil Bilgilerini Düzenle</h4>
                            
                            <form method="POST" action="">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label style="font-weight: bold;">
                                                <i class="fa fa-user text-primary"></i> Kullanıcı Adı
                                            </label>
                                            <input type="text" 
                                                   class="form-control form-control-lg" 
                                                   name="kullanici_adi" 
                                                   value="<?php echo htmlspecialchars($kullanici['kullanici_adi']); ?>"
                                                   required
                                                   style="border-radius: 10px;">
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label style="font-weight: bold;">
                                                <i class="fa fa-envelope text-primary"></i> E-posta Adresi
                                            </label>
                                            <input type="email" 
                                                   class="form-control form-control-lg" 
                                                   name="eposta" 
                                                   value="<?php echo htmlspecialchars($kullanici['eposta']); ?>"
                                                   required
                                                   style="border-radius: 10px;">
                                        </div>
                                    </div>
                                </div>
                                
                                <button type="submit" name="profil_guncelle" class="btn btn-primary btn-lg" style="border-radius: 50px; padding: 12px 40px;">
                                    <i class="fa fa-save"></i> Değişiklikleri Kaydet
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- ŞİFRE DEĞİŞTİR TAB -->
                <div id="sifreDegistir" class="tab-pane fade">
                    <div class="card shadow-sm" style="border: none; border-radius: 15px;">
                        <div class="card-body p-4">
                            <h4 class="mb-4"><i class="fa fa-lock text-warning"></i> Şifre Değiştir</h4>
                            
                            <form method="POST" action="">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label style="font-weight: bold;">
                                                <i class="fa fa-key text-warning"></i> Mevcut Şifre
                                            </label>
                                            <input type="password" 
                                                   class="form-control form-control-lg" 
                                                   name="eski_sifre" 
                                                   placeholder="Mevcut şifrenizi girin"
                                                   required
                                                   style="border-radius: 10px;">
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label style="font-weight: bold;">
                                                <i class="fa fa-lock text-warning"></i> Yeni Şifre
                                            </label>
                                            <input type="password" 
                                                   class="form-control form-control-lg" 
                                                   name="yeni_sifre" 
                                                   placeholder="Yeni şifrenizi girin"
                                                   required
                                                   style="border-radius: 10px;">
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label style="font-weight: bold;">
                                                <i class="fa fa-lock text-warning"></i> Yeni Şifre Tekrar
                                            </label>
                                            <input type="password" 
                                                   class="form-control form-control-lg" 
                                                   name="yeni_sifre_tekrar" 
                                                   placeholder="Yeni şifrenizi tekrar girin"
                                                   required
                                                   style="border-radius: 10px;">
                                        </div>
                                    </div>
                                </div>
                                
                                <button type="submit" name="sifre_degistir" class="btn btn-warning btn-lg" style="border-radius: 50px; padding: 12px 40px; color: white;">
                                    <i class="fa fa-check"></i> Şifreyi Değiştir
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>

<style>
    .nav-tabs .nav-link {
        border: none;
        border-bottom: 3px solid transparent;
        transition: all 0.3s;
    }
    
    .nav-tabs .nav-link:hover {
        border-bottom: 3px solid #667eea;
        background: rgba(102, 126, 234, 0.1);
    }
    
    .nav-tabs .nav-link.active {
        border-bottom: 3px solid #667eea;
        background: rgba(102, 126, 234, 0.1);
        color: #667eea !important;
    }
    
    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }
    
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
    }
    
    .btn-warning:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(255, 193, 7, 0.4);
    }
</style>