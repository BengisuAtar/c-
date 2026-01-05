-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1:3306
-- Üretim Zamanı: 04 Oca 2026, 17:25:54
-- Sunucu sürümü: 5.7.36
-- PHP Sürümü: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `okuva_db_final`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `degerlendirmeler`
--

DROP TABLE IF EXISTS `degerlendirmeler`;
CREATE TABLE IF NOT EXISTS `degerlendirmeler` (
  `degerlendirme_id` int(11) NOT NULL AUTO_INCREMENT,
  `kitap_id` int(11) NOT NULL,
  `kullanici_id` int(11) NOT NULL,
  `puan` int(1) NOT NULL,
  `yorum` text COLLATE utf8mb4_turkish_ci,
  `tarih` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`degerlendirme_id`),
  UNIQUE KEY `kullanici_kitap_degerlendirme` (`kullanici_id`,`kitap_id`),
  KEY `kitap_id` (`kitap_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kategoriler`
--

DROP TABLE IF EXISTS `kategoriler`;
CREATE TABLE IF NOT EXISTS `kategoriler` (
  `kategori_id` int(11) NOT NULL AUTO_INCREMENT,
  `kategori_adi` varchar(50) COLLATE utf8mb4_turkish_ci NOT NULL,
  `aciklama` text COLLATE utf8mb4_turkish_ci,
  PRIMARY KEY (`kategori_id`),
  UNIQUE KEY `kategori_adi` (`kategori_adi`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Tablo döküm verisi `kategoriler`
--

INSERT INTO `kategoriler` (`kategori_id`, `kategori_adi`, `aciklama`) VALUES
(1, 'Roman', 'Roman türündeki kitaplar'),
(2, 'Tarih', 'Tarih konulu eserler'),
(3, 'Edebiyat', 'Edebiyat eserleri'),
(4, 'Bilim Kurgu', 'Bilim kurgu romanları'),
(5, 'Polisiye', 'Polisiye ve gerilim romanları'),
(6, 'Felsefe', 'Felsefe eserleri'),
(7, 'Şiir', 'Şiir kitapları'),
(8, 'Biyografi', 'Biyografi ve anı kitapları'),
(9, 'Psikoloji', 'Psikoloji kitapları'),
(10, 'Kişisel Gelişim', 'Kişisel gelişim kitapları'),
(11, 'Fantastik', 'Fantastik romanlar'),
(12, 'Klasik', 'Dünya klasikleri');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kitaplar`
--

DROP TABLE IF EXISTS `kitaplar`;
CREATE TABLE IF NOT EXISTS `kitaplar` (
  `kitap_id` int(11) NOT NULL AUTO_INCREMENT,
  `kitap_adi` varchar(255) COLLATE utf8mb4_turkish_ci NOT NULL,
  `yazar_id` int(11) DEFAULT NULL,
  `aciklama` text COLLATE utf8mb4_turkish_ci NOT NULL,
  `kapak_resmi` varchar(500) COLLATE utf8mb4_turkish_ci DEFAULT NULL,
  `yayin_yili` int(4) DEFAULT NULL,
  `ekleyen_kullanici_id` int(11) DEFAULT NULL,
  `eklenme_tarihi` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`kitap_id`),
  KEY `yazar_id` (`yazar_id`),
  KEY `ekleyen_kullanici_id` (`ekleyen_kullanici_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Tablo döküm verisi `kitaplar`
--

INSERT INTO `kitaplar` (`kitap_id`, `kitap_adi`, `yazar_id`, `aciklama`, `kapak_resmi`, `yayin_yili`, `ekleyen_kullanici_id`, `eklenme_tarihi`) VALUES
(1, 'Masumiyet Müzesi', 1, 'Orhan Pamuk\'un Nobel sonrası yazdığı, aşk ve İstanbul üzerine büyüleyici bir roman. Kemal ile Füsun arasındaki aşk hikayesi...', 'https://i.dr.com.tr/cache/600x600-0/originals/0000000064102-1.jpg', 2008, NULL, '2025-12-28 10:29:02'),
(2, 'Kürk Mantolu Madonna', 3, 'Sabahattin Ali\'nin aşk ve fedakarlık üzerine kaleme aldığı klasik eseri. Raif Efendi ile Maria Puder arasındaki trajik aşk...', 'https://i.dr.com.tr/cache/600x600-0/originals/0000000064043-1.jpg', 1943, NULL, '2025-12-28 10:29:02'),
(3, 'Aşk', 2, 'Elif Şafak\'ın tasavvuf ve aşk üzerine yazdığı etkileyici romanı. Shams ile Rumi\'nin karşılaşması...', 'https://i.dr.com.tr/cache/600x600-0/originals/0001832130001-1.jpg', 2009, NULL, '2025-12-28 10:29:02'),
(4, 'Beyoğlu Rapsodisi', 4, 'Zülfü Livaneli\'nin müzik, aşk ve tarih üzerine romanı. İstanbul\'un kültürel dokusunu anlatan bir eser.', 'https://i.dr.com.tr/cache/600x600-0/originals/0000000366466-1.jpg', 2007, NULL, '2025-12-28 10:29:02'),
(5, 'Patasana', 5, 'Ahmet Ümit\'in polisiye türündeki başarılı eseri. İstanbul\'da geçen gizemli bir cinayet vakası...', 'https://i.dr.com.tr/cache/600x600-0/originals/0000000106180-1.jpg', 2000, NULL, '2025-12-28 10:29:02'),
(6, 'Çalıkuşu', 6, 'Türk edebiyatının en sevilen romanlarından biri. Feride\'nin hayat hikayesi...', 'https://i.dr.com.tr/cache/600x600-0/originals/0000000368391-1.jpg', 1922, NULL, '2025-12-28 10:29:02'),
(7, 'Tutunamayanlar', 7, 'Oğuz Atay\'ın başyapıtı. Modern Türk edebiyatının en önemli eserlerinden...', 'https://i.dr.com.tr/cache/600x600-0/originals/0001832125001-1.jpg', 1971, NULL, '2025-12-28 10:29:02'),
(8, 'İnce Memed', 8, 'Yaşar Kemal\'in eşkıya romanı. Çukurova\'nın destansı hikayesi...', 'https://i.dr.com.tr/cache/600x600-0/originals/0000000063827-1.jpg', 1955, NULL, '2025-12-28 10:29:02'),
(9, 'Bab-ı Esrar', 5, 'Ahmet Ümit\'in İstanbul üzerine yazdığı polisiye roman. Osmanlı dönemi gizemli olaylar...', 'https://i.dr.com.tr/cache/600x600-0/originals/0000000593347-1.jpg', 2008, NULL, '2025-12-28 10:29:02'),
(10, '10 Minutes 38 Seconds in This Strange World', 2, 'Elif Şafak\'ın İstanbul sokaklarında geçen güçlü romanı.', 'https://i.dr.com.tr/cache/600x600-0/originals/0001803906001-1.jpg', 2019, NULL, '2025-12-28 10:29:02');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kitap_kategori`
--

DROP TABLE IF EXISTS `kitap_kategori`;
CREATE TABLE IF NOT EXISTS `kitap_kategori` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kitap_id` int(11) NOT NULL,
  `kategori_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `kitap_kategori_unique` (`kitap_id`,`kategori_id`),
  KEY `kategori_id` (`kategori_id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Tablo döküm verisi `kitap_kategori`
--

INSERT INTO `kitap_kategori` (`id`, `kitap_id`, `kategori_id`) VALUES
(1, 1, 1),
(2, 1, 3),
(3, 2, 1),
(4, 2, 3),
(5, 2, 12),
(6, 3, 1),
(7, 3, 6),
(8, 4, 1),
(9, 4, 2),
(10, 5, 5),
(11, 6, 1),
(12, 6, 3),
(13, 6, 12),
(14, 7, 1),
(15, 7, 3),
(16, 7, 12),
(17, 8, 1),
(18, 8, 3),
(19, 8, 12),
(20, 9, 1),
(21, 9, 5),
(22, 10, 1),
(23, 10, 3);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kullanicilar`
--

DROP TABLE IF EXISTS `kullanicilar`;
CREATE TABLE IF NOT EXISTS `kullanicilar` (
  `kullanici_id` int(11) NOT NULL AUTO_INCREMENT,
  `kullanici_adi` varchar(50) COLLATE utf8mb4_turkish_ci NOT NULL,
  `eposta` varchar(100) COLLATE utf8mb4_turkish_ci NOT NULL,
  `sifre` varchar(255) COLLATE utf8mb4_turkish_ci NOT NULL,
  `kayit_tarihi` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`kullanici_id`),
  UNIQUE KEY `kullanici_adi` (`kullanici_adi`),
  UNIQUE KEY `eposta` (`eposta`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Tablo döküm verisi `kullanicilar`
--

INSERT INTO `kullanicilar` (`kullanici_id`, `kullanici_adi`, `eposta`, `sifre`, `kayit_tarihi`) VALUES
(1, 'su_11', 'bengisuatar1@gmail.com', '$2y$10$zHiCNfbDXRTQRDt16OoqeuC.qQXx.RmOqRUEVxgN4GFca.A4sWDRK', '2025-12-28 10:32:49');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kullanici_kitaplik`
--

DROP TABLE IF EXISTS `kullanici_kitaplik`;
CREATE TABLE IF NOT EXISTS `kullanici_kitaplik` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kullanici_id` int(11) NOT NULL,
  `kitap_id` int(11) NOT NULL,
  `durum` enum('okunacak','okunuyor','okundu') COLLATE utf8mb4_turkish_ci DEFAULT 'okunacak',
  `eklenme_tarihi` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `okunma_tarihi` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `kullanici_kitap_unique` (`kullanici_id`,`kitap_id`),
  KEY `kitap_id` (`kitap_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Tablo döküm verisi `kullanici_kitaplik`
--

INSERT INTO `kullanici_kitaplik` (`id`, `kullanici_id`, `kitap_id`, `durum`, `eklenme_tarihi`, `okunma_tarihi`) VALUES
(1, 1, 9, 'okunacak', '2025-12-29 14:12:44', NULL);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `yazarlar`
--

DROP TABLE IF EXISTS `yazarlar`;
CREATE TABLE IF NOT EXISTS `yazarlar` (
  `yazar_id` int(11) NOT NULL AUTO_INCREMENT,
  `yazar_adi` varchar(100) COLLATE utf8mb4_turkish_ci NOT NULL,
  `biyografi` text COLLATE utf8mb4_turkish_ci,
  `dogum_tarihi` date DEFAULT NULL,
  PRIMARY KEY (`yazar_id`),
  UNIQUE KEY `yazar_adi` (`yazar_adi`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Tablo döküm verisi `yazarlar`
--

INSERT INTO `yazarlar` (`yazar_id`, `yazar_adi`, `biyografi`, `dogum_tarihi`) VALUES
(1, 'Orhan Pamuk', 'Nobel Edebiyat Ödüllü Türk yazar. 1952 İstanbul doğumlu.', NULL),
(2, 'Elif Şafak', 'Türkiye\'nin en çok okunan yazarlarından. 1971 Strasbourg doğumlu.', NULL),
(3, 'Sabahattin Ali', 'Türk edebiyatının önemli isimlerinden. 1907-1948', NULL),
(4, 'Zülfü Livaneli', 'Yazar, besteci ve film yönetmeni. 1946 Ilgın doğumlu.', NULL),
(5, 'Ahmet Ümit', 'Türk polisiye roman yazarı. 1960 Gaziantep doğumlu.', NULL),
(6, 'Reşat Nuri Güntekin', 'Çalıkuşu romanının yazarı. 1889-1956', NULL),
(7, 'Oğuz Atay', 'Tutunamayanlar yazarı. 1934-1977', NULL),
(8, 'Yaşar Kemal', 'İnce Memed yazarı. 1923-2015', NULL);

--
-- Dökümü yapılmış tablolar için kısıtlamalar
--

--
-- Tablo kısıtlamaları `degerlendirmeler`
--
ALTER TABLE `degerlendirmeler`
  ADD CONSTRAINT `degerlendirmeler_ibfk_1` FOREIGN KEY (`kitap_id`) REFERENCES `kitaplar` (`kitap_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `degerlendirmeler_ibfk_2` FOREIGN KEY (`kullanici_id`) REFERENCES `kullanicilar` (`kullanici_id`) ON DELETE CASCADE;

--
-- Tablo kısıtlamaları `kitaplar`
--
ALTER TABLE `kitaplar`
  ADD CONSTRAINT `kitaplar_ibfk_1` FOREIGN KEY (`yazar_id`) REFERENCES `yazarlar` (`yazar_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `kitaplar_ibfk_2` FOREIGN KEY (`ekleyen_kullanici_id`) REFERENCES `kullanicilar` (`kullanici_id`) ON DELETE SET NULL;

--
-- Tablo kısıtlamaları `kitap_kategori`
--
ALTER TABLE `kitap_kategori`
  ADD CONSTRAINT `kitap_kategori_ibfk_1` FOREIGN KEY (`kitap_id`) REFERENCES `kitaplar` (`kitap_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `kitap_kategori_ibfk_2` FOREIGN KEY (`kategori_id`) REFERENCES `kategoriler` (`kategori_id`) ON DELETE CASCADE;

--
-- Tablo kısıtlamaları `kullanici_kitaplik`
--
ALTER TABLE `kullanici_kitaplik`
  ADD CONSTRAINT `kullanici_kitaplik_ibfk_1` FOREIGN KEY (`kullanici_id`) REFERENCES `kullanicilar` (`kullanici_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `kullanici_kitaplik_ibfk_2` FOREIGN KEY (`kitap_id`) REFERENCES `kitaplar` (`kitap_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
