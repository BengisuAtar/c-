<!-- MODERN SLIDER BAŞLANGIÇ -->
<div id="mainSlider" class="carousel slide" data-ride="carousel" style="margin-bottom: 50px;">
    
    <!-- Slider İndikatörleri -->
    <ol class="carousel-indicators">
        <li data-target="#mainSlider" data-slide-to="0" class="active"></li>
        <li data-target="#mainSlider" data-slide-to="1"></li>
        <li data-target="#mainSlider" data-slide-to="2"></li>
    </ol>

    <!-- Slider İçeriği -->
    <div class="carousel-inner">
        
        <!-- 1. SLIDE - OKUVA'YA HOŞ GELDİNİZ -->
        <div class="carousel-item active">
            <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); height: 500px; position: relative; overflow: hidden;">
                <!-- Arka Plan Deseni -->
                <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0.1; background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'1\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
                
                <div class="container h-100">
                    <div class="row h-100 align-items-center">
                        <div class="col-md-7" style="position: relative; z-index: 2;">
                            <h1 style="color: white; font-size: 56px; font-weight: bold; margin-bottom: 20px; text-shadow: 2px 2px 4px rgba(0,0,0,0.3);">
                                OKUVA'ya Hoş Geldiniz! 📚
                            </h1>
                            <p style="color: white; font-size: 20px; margin-bottom: 30px; line-height: 1.6; text-shadow: 1px 1px 2px rgba(0,0,0,0.3);">
                                Binlerce kitap, yüzlerce yazar ve sınırsız okuma deneyimi sizi bekliyor. 
                                Hemen üye olun ve kitap dünyasına adım atın!
                            </p>
                            <div>
                                <?php 
                                    if (!isset($_SESSION["kullanici_adi"])) 
                                    {
                                ?>
                                    <a href="index.php?sayfa=uyeol" class="btn btn-lg" style="background: white; color: #667eea; padding: 15px 40px; border-radius: 50px; font-weight: bold; margin-right: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.2); transition: all 0.3s;">
                                        <i class="fa fa-user-plus"></i> Ücretsiz Üye Ol
                                    </a>
                                    <a href="index.php?sayfa=login" class="btn btn-lg" style="background: transparent; color: white; border: 3px solid white; padding: 15px 40px; border-radius: 50px; font-weight: bold; transition: all 0.3s;">
                                        <i class="fa fa-sign-in"></i> Giriş Yap
                                    </a>
                                <?php 
                                    } 
                                    else 
                                    {
                                ?>
                                    <a href="index.php?sayfa=kitapekle" class="btn btn-lg" style="background: white; color: #667eea; padding: 15px 40px; border-radius: 50px; font-weight: bold; margin-right: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.2);">
                                        <i class="fa fa-plus-circle"></i> Yeni Kitap Ekle
                                    </a>
                                <?php 
                                    }
                                ?>
                            </div>
                        </div>
                        <div class="col-md-5 text-center" style="position: relative; z-index: 2;">
                            <div style="animation: float 3s ease-in-out infinite;">
                                <i class="fa fa-book" style="font-size: 250px; color: rgba(255,255,255,0.2);"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2. SLIDE - KİTAPLIĞINI OLUŞTUR -->
        <div class="carousel-item">
            <div style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); height: 500px; position: relative; overflow: hidden;">
                <!-- Arka Plan Deseni -->
                <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0.1; background-image: url('data:image/svg+xml,%3Csvg width=\'80\' height=\'80\' viewBox=\'0 0 80 80\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'1\'%3E%3Cpath d=\'M50 50c0-5.523 4.477-10 10-10s10 4.477 10 10-4.477 10-10 10c0 5.523-4.477 10-10 10s-10-4.477-10-10 4.477-10 10-10zM10 10c0-5.523 4.477-10 10-10s10 4.477 10 10-4.477 10-10 10c0 5.523-4.477 10-10 10S0 25.523 0 20s4.477-10 10-10zm10 8c4.418 0 8-3.582 8-8s-3.582-8-8-8-8 3.582-8 8 3.582 8 8 8zm40 40c4.418 0 8-3.582 8-8s-3.582-8-8-8-8 3.582-8 8 3.582 8 8 8z\' /%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
                
                <div class="container h-100">
                    <div class="row h-100 align-items-center">
                        <div class="col-md-5 text-center" style="position: relative; z-index: 2;">
                            <div style="animation: float 3s ease-in-out infinite;">
                                <i class="fa fa-bookmark" style="font-size: 250px; color: rgba(255,255,255,0.2);"></i>
                            </div>
                        </div>
                        <div class="col-md-7" style="position: relative; z-index: 2;">
                            <h1 style="color: white; font-size: 56px; font-weight: bold; margin-bottom: 20px; text-shadow: 2px 2px 4px rgba(0,0,0,0.3);">
                                Kendi Kitaplığını Oluştur 📖
                            </h1>
                            <p style="color: white; font-size: 20px; margin-bottom: 30px; line-height: 1.6; text-shadow: 1px 1px 2px rgba(0,0,0,0.3);">
                                Okuduğun, okuyacağın ve şu an okuduğun kitapları takip et. 
                                Kişisel kitaplığınla okuma hedeflerine ulaş!
                            </p>
                            <div>
                                <a href="index.php?sayfa=okuyorum" class="btn btn-lg" style="background: white; color: #f5576c; padding: 15px 40px; border-radius: 50px; font-weight: bold; margin-right: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.2);">
                                    <i class="fa fa-book-open"></i> Kitaplığıma Git
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 3. SLIDE - YAZARLARI KEŞFET -->
        <div class="carousel-item">
            <div style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); height: 500px; position: relative; overflow: hidden;">
                <!-- Arka Plan Deseni -->
                <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0.1; background-image: url('data:image/svg+xml,%3Csvg width=\'100\' height=\'100\' viewBox=\'0 0 100 100\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cpath d=\'M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z\' fill=\'%23ffffff\' fill-opacity=\'1\' fill-rule=\'evenodd\'/%3E%3C/svg%3E');"></div>
                
                <div class="container h-100">
                    <div class="row h-100 align-items-center">
                        <div class="col-md-7" style="position: relative; z-index: 2;">
                            <h1 style="color: white; font-size: 56px; font-weight: bold; margin-bottom: 20px; text-shadow: 2px 2px 4px rgba(0,0,0,0.3);">
                                Favori Yazarlarını Keşfet ✍️
                            </h1>
                            <p style="color: white; font-size: 20px; margin-bottom: 30px; line-height: 1.6; text-shadow: 1px 1px 2px rgba(0,0,0,0.3);">
                                Yüzlerce yazar ve binlerce eser seni bekliyor. 
                                Sevdiğin yazarları takip et, yeni eserlerinden haberdar ol!
                            </p>
                            <div>
                                <a href="index.php?sayfa=yazarlar" class="btn btn-lg" style="background: white; color: #4facfe; padding: 15px 40px; border-radius: 50px; font-weight: bold; margin-right: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.2);">
                                    <i class="fa fa-users"></i> Yazarları Keşfet
                                </a>
                            </div>
                        </div>
                        <div class="col-md-5 text-center" style="position: relative; z-index: 2;">
                            <div style="animation: float 3s ease-in-out infinite;">
                                <i class="fa fa-pencil" style="font-size: 250px; color: rgba(255,255,255,0.2);"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Slider Kontrolleri -->
    <a class="carousel-control-prev" href="#mainSlider" role="button" data-slide="prev" style="width: 60px;">
        <div style="background: rgba(0,0,0,0.5); width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center; transition: all 0.3s;">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        </div>
        <span class="sr-only">Önceki</span>
    </a>
    <a class="carousel-control-next" href="#mainSlider" role="button" data-slide="next" style="width: 60px;">
        <div style="background: rgba(0,0,0,0.5); width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center; transition: all 0.3s;">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
        </div>
        <span class="sr-only">Sonraki</span>
    </a>
</div>

<style>
    /* Float Animasyonu */
    @keyframes float {
        0% {
            transform: translateY(0px);
        }
        50% {
            transform: translateY(-20px);
        }
        100% {
            transform: translateY(0px);
        }
    }
    
    /* Buton Hover Efektleri */
    #mainSlider .btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.3) !important;
    }
    
    /* Slider Kontrol Butonları Hover */
    .carousel-control-prev div:hover,
    .carousel-control-next div:hover {
        background: rgba(0,0,0,0.8) !important;
        transform: scale(1.1);
    }
    
    /* Responsive Ayarlar */
    @media (max-width: 768px) {
        #mainSlider .carousel-item > div {
            height: 400px !important;
        }
        
        #mainSlider h1 {
            font-size: 32px !important;
        }
        
        #mainSlider p {
            font-size: 16px !important;
        }
        
        #mainSlider .fa {
            font-size: 120px !important;
        }
    }
</style>

<!-- MODERN SLIDER BİTİŞ -->