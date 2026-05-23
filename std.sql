-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 13 Nis 2024, 13:44:31
-- Sunucu sürümü: 10.4.27-MariaDB
-- PHP Sürümü: 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `std`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `denemeler`
--

CREATE TABLE `denemeler` (
  `id` int(11) NOT NULL,
  `ogr_id` int(11) DEFAULT NULL,
  `deneme_turu` varchar(50) DEFAULT NULL,
  `puan` float DEFAULT NULL,
  `turkce_dogru` int(11) DEFAULT NULL,
  `turkce_yanlis` int(11) DEFAULT NULL,
  `sosyal_dogru` int(11) DEFAULT NULL,
  `sosyal_yanlis` int(11) DEFAULT NULL,
  `matematik_dogru` int(11) DEFAULT NULL,
  `matematik_yanlis` int(11) DEFAULT NULL,
  `fen_dogru` int(11) DEFAULT NULL,
  `fen_yanlis` int(11) DEFAULT NULL,
  `tarih` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `denemeler`
--

INSERT INTO `denemeler` (`id`, `ogr_id`, `deneme_turu`, `puan`, `turkce_dogru`, `turkce_yanlis`, `sosyal_dogru`, `sosyal_yanlis`, `matematik_dogru`, `matematik_yanlis`, `fen_dogru`, `fen_yanlis`, `tarih`) VALUES
(13, 9, 'YKS-TYT', 453, 30, 2, 20, 0, 40, 0, 16, 4, '2024-04-10 10:32:37'),
(14, 9, 'YKS-TYT', 453, 30, 2, 20, 0, 40, 0, 16, 4, '2024-04-10 10:34:01'),
(15, 12, 'YKS-AYT', 350, 33, 4, 16, 4, 27, 8, 6, 4, '2024-04-11 16:56:45'),
(17, 12, 'YKS-AYT', 453, 36, 4, 20, 0, 36, 0, 16, 4, '2024-04-11 17:00:29'),
(18, 13, 'YKS-AYT', 312, 25, 9, 20, 0, 12, 2, 14, 9, '2024-04-11 17:49:15'),
(19, 13, 'YKS-AYT', 459, 36, 0, 20, 0, 30, 3, 16, 2, '2024-04-11 17:50:18'),
(22, 13, 'ALES-YDS', 400, 20, 20, 20, 20, 20, 20, 20, 20, '2024-04-12 07:56:12'),
(23, 13, 'KPSS', 485, 10, 10, 10, 10, 10, 10, 10, 0, '2024-04-12 07:59:52');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `deneme_turu`
--

CREATE TABLE `deneme_turu` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `deneme_turu` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `deneme_turu`
--

INSERT INTO `deneme_turu` (`id`, `deneme_turu`) VALUES
(1, 'YKS-TYT'),
(2, 'YKS-AYT'),
(3, 'DGS'),
(4, 'ALES'),
(5, 'KPSS'),
(6, 'ALES-YDS');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `dersliksinif`
--

CREATE TABLE `dersliksinif` (
  `id` int(11) NOT NULL,
  `dersliksinif` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `dersliksinif`
--

INSERT INTO `dersliksinif` (`id`, `dersliksinif`) VALUES
(1, 'BOS'),
(2, 'MATH-1001'),
(4, 'ENG - 103'),
(5, '12.Sınıf YKS Kursu'),
(6, 'B12-Bio'),
(9, '12.Sınıf Sayısal');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `ders_programi`
--

CREATE TABLE `ders_programi` (
  `id` int(11) NOT NULL,
  `ders` varchar(255) DEFAULT NULL,
  `ders_programi` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `ders_programi`
--

INSERT INTO `ders_programi` (`id`, `ders`, `ders_programi`) VALUES
(10, '12.Sınıf YKS Kursu', '12.Sınıf YKS Kursu.xls'),
(11, 'B12-Bio', 'B12-Bio.xls');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `devamsizlik`
--

CREATE TABLE `devamsizlik` (
  `id` int(11) NOT NULL,
  `ogr_id` int(11) DEFAULT NULL,
  `toplamdevamsizlik` int(11) DEFAULT NULL,
  `devamsizlikgim` int(11) DEFAULT NULL,
  `kalandevamsizlik` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `devamsizlik`
--

INSERT INTO `devamsizlik` (`id`, `ogr_id`, `toplamdevamsizlik`, `devamsizlikgim`, `kalandevamsizlik`) VALUES
(7, 9, 20, 0, 20),
(8, 10, 20, 0, 20),
(9, 11, 20, 0, 20),
(10, 12, 20, 2, 18),
(11, 13, 20, 3, 17);

--
-- Tetikleyiciler `devamsizlik`
--
DELIMITER $$
CREATE TRIGGER `update_kalandevamsizlik` BEFORE INSERT ON `devamsizlik` FOR EACH ROW BEGIN
    SET NEW.kalandevamsizlik = NEW.toplamdevamsizlik - NEW.devamsizlikgim;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `gorseller`
--

CREATE TABLE `gorseller` (
  `id` int(11) NOT NULL,
  `ogr_id` int(11) DEFAULT NULL,
  `gorsel` varchar(255) DEFAULT 'kayitsiz.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `gorseller`
--

INSERT INTO `gorseller` (`id`, `ogr_id`, `gorsel`) VALUES
(7, 9, '10042024122220.png'),
(8, 10, '10042024122245.png'),
(9, 12, '11042024194721.png'),
(10, 13, '11042024194817.png');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `hocalar`
--

CREATE TABLE `hocalar` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `hoca_ad` varchar(50) DEFAULT NULL,
  `hoca_soyad` varchar(50) DEFAULT NULL,
  `hoca_tc` varchar(11) DEFAULT NULL,
  `hoca_alani` varchar(100) DEFAULT NULL,
  `hoca_sinifi` varchar(50) DEFAULT NULL,
  `iletisim` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `hocalar`
--

INSERT INTO `hocalar` (`id`, `hoca_ad`, `hoca_soyad`, `hoca_tc`, `hoca_alani`, `hoca_sinifi`, `iletisim`) VALUES
(3, 'Varol', 'Güven', '12344312421', 'Almanca', 'BOS', '2531345122'),
(4, 'Ayşen', 'Korkmaz', '50427275764', 'Türk Dili ve Edebiyat', 'ENG - 103', '05347018124');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kan`
--

CREATE TABLE `kan` (
  `kan_id` int(11) NOT NULL,
  `kan_grup` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Tablo döküm verisi `kan`
--

INSERT INTO `kan` (`kan_id`, `kan_grup`) VALUES
(1, 'A+'),
(2, 'A-'),
(3, 'B+'),
(4, 'B-'),
(5, 'AB+'),
(6, 'AB-'),
(7, '0+'),
(8, '0-');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `odeme_tarih`
--

CREATE TABLE `odeme_tarih` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ogr_id` int(11) DEFAULT NULL,
  `tarih` date DEFAULT curdate(),
  `odenen_ucret` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `odeme_tarih`
--

INSERT INTO `odeme_tarih` (`id`, `ogr_id`, `tarih`, `odenen_ucret`) VALUES
(51, 9, '2024-04-10', '14600.00'),
(52, 12, '2024-04-11', '14604.00'),
(53, 13, '2024-04-11', '1456.00');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `ogrenci`
--

CREATE TABLE `ogrenci` (
  `ogr_id` int(11) NOT NULL,
  `ogr_ad` varchar(30) NOT NULL,
  `ogr_soyad` varchar(30) NOT NULL,
  `veli_id` int(11) NOT NULL,
  `ogr_tc` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Tablo döküm verisi `ogrenci`
--

INSERT INTO `ogrenci` (`ogr_id`, `ogr_ad`, `ogr_soyad`, `veli_id`, `ogr_tc`) VALUES
(9, 'Cansu', 'Gezgin', 7, '41033002270'),
(10, 'Burak', 'Arabacı', 6, '40828739233'),
(11, 'Elif', 'Bakırcı', 8, '41033002271'),
(12, 'Dilay', 'Akarsu', 9, '41033002271'),
(13, 'Dilay', 'Bakırcı', 8, '41033002273');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `ogrencidersleri`
--

CREATE TABLE `ogrencidersleri` (
  `id` int(11) NOT NULL,
  `ogr_id` int(11) DEFAULT NULL,
  `ders1` varchar(50) DEFAULT NULL,
  `ders2` varchar(50) DEFAULT NULL,
  `ders3` varchar(50) DEFAULT NULL,
  `ders4` varchar(50) DEFAULT NULL,
  `ders5` varchar(50) DEFAULT NULL,
  `ders6` varchar(50) DEFAULT NULL,
  `ders7` varchar(50) DEFAULT NULL,
  `ders8` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `ogrencidersleri`
--

INSERT INTO `ogrencidersleri` (`id`, `ogr_id`, `ders1`, `ders2`, `ders3`, `ders4`, `ders5`, `ders6`, `ders7`, `ders8`) VALUES
(11, 9, 'Almanca', 'Türk Dili ve Edebiyat', 'Kimya', 'İngilizce', '', '', '', ''),
(12, 12, 'Almanca', 'Türk Dili ve Edebiyat', 'Fizik', 'Kimya', '', '', '', ''),
(13, 13, 'Almanca', 'Türk Dili ve Edebiyat', 'İngilizce', 'Fizik', 'Kimya', '', '', '');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `ogrenci_detay`
--

CREATE TABLE `ogrenci_detay` (
  `ogr_id` int(11) NOT NULL,
  `ogr_tel` varchar(11) NOT NULL,
  `ogr_adres` varchar(30) NOT NULL,
  `ogr_okul` varchar(60) NOT NULL,
  `ogr_kan_grubu` varchar(3) NOT NULL,
  `ogr_kayit_tar` date NOT NULL,
  `ogr_dogum_tar` varchar(30) NOT NULL,
  `ogr_ucret` varchar(30) NOT NULL,
  `ogr_mail` varchar(50) NOT NULL,
  `sinif` varchar(20) NOT NULL DEFAULT 'Bilgi Yok',
  `odemedurumu` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Tablo döküm verisi `ogrenci_detay`
--

INSERT INTO `ogrenci_detay` (`ogr_id`, `ogr_tel`, `ogr_adres`, `ogr_okul`, `ogr_kan_grubu`, `ogr_kayit_tar`, `ogr_dogum_tar`, `ogr_ucret`, `ogr_mail`, `sinif`, `odemedurumu`) VALUES
(9, '53427145490', 'Çanakkale İskele', 'Merkez Çanakkale Anadolu Lisesi', 'A+', '2024-04-10', '2006-02-22', '14600', 'cansu@gmail.com', '12.Sınıf YKS Kursu', 0),
(10, '53427145444', 'Çanakkale Merkez', 'Merkez Çanakkale Anadolu Lisesi', 'A+', '2024-04-10', '1998-10-10', '13787', 'burak@gmail.com', 'B12-Bio', 0),
(11, '0253445774', 'Tekirdağ Merkez', 'Merkez Çanakkale Anadolu Lisesi', 'A+', '2024-04-11', '2024-04-11', '27520', 'elif@gmail.com', 'Bilgi Yok', 0),
(12, '0253445775', 'Çanakkale İskele', 'Merkez Çanakkale Anadolu Lisesi', 'A+', '2024-04-11', '2024-04-11', '14604', 'dilay2@gmail.com', 'B12-Bio', 1),
(13, '0253445774', 'Çanakkale Merkez', 'Ali Haydar Önder Anadolu Lisesi', 'A+', '2024-04-11', '2024-04-11', '1456', 'dilay@gmail.com', 'B12-Bio', 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `okullar`
--

CREATE TABLE `okullar` (
  `okul_id` int(11) NOT NULL,
  `okul_ad` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Tablo döküm verisi `okullar`
--

INSERT INTO `okullar` (`okul_id`, `okul_ad`) VALUES
(1, 'Merkez Çanakkale Anadolu Lisesi'),
(2, 'Çanakkale İbrahim Bodur Anadolu Lisesi'),
(3, 'Çanakkale Mesleki ve Teknik Anadolu Lisesi'),
(4, 'Ali Haydar Önder Anadolu Lisesi');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `sinavtarih`
--

CREATE TABLE `sinavtarih` (
  `id` int(11) NOT NULL,
  `sinif` varchar(50) DEFAULT NULL,
  `tarih` date DEFAULT NULL,
  `sinav_turu` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `sinavtarih`
--

INSERT INTO `sinavtarih` (`id`, `sinif`, `tarih`, `sinav_turu`) VALUES
(15, '12.Sınıf YKS Kursu', '2024-04-18', 'YKS-AYT'),
(16, '12.Sınıf YKS Kursu', '2024-04-26', 'YKS-TYT'),
(19, '12.Sınıf YKS Kursu', '2024-04-19', 'YKS-TYT'),
(20, 'B12-Bio', '2024-04-12', 'DGS'),
(21, 'B12-Bio', '2024-04-13', 'YKS-AYT');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `siniflar`
--

CREATE TABLE `siniflar` (
  `id` int(11) NOT NULL,
  `sinif` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `siniflar`
--

INSERT INTO `siniflar` (`id`, `sinif`) VALUES
(58, 'Almanca'),
(70, 'Türk Dili ve Edebiyat'),
(71, 'İngilizce'),
(72, 'Fizik'),
(73, 'Türk Dili ve Edebiyat'),
(75, 'Kimya');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `veli`
--

CREATE TABLE `veli` (
  `veli_id` int(11) NOT NULL,
  `veli_ad` varchar(250) NOT NULL,
  `veli_soyad` varchar(250) NOT NULL,
  `veli_tel` varchar(20) DEFAULT '',
  `veli_tc` varchar(20) DEFAULT '',
  `veli_meslek` varchar(30) NOT NULL,
  `veli_mail` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Tablo döküm verisi `veli`
--

INSERT INTO `veli` (`veli_id`, `veli_ad`, `veli_soyad`, `veli_tel`, `veli_tc`, `veli_meslek`, `veli_mail`) VALUES
(6, 'Leyla', 'Arabacı', '05356456456', '4245456456', 'Bankacı', 'leyla_tekin2@gmail.com'),
(7, 'Ahmet', 'Gezgin', '05348953645', '34123675651', 'Esnaf', 'ahmet@gmail.com'),
(8, 'Arif', 'Bakırcı', '05347834245', '4125675782757', 'Esnaf', 'arif@gmail.com'),
(9, 'Elif', 'Akarsu', '05356456444', '41033002245', 'CEO', 'akarsu@gmail.com');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `yonetici`
--

CREATE TABLE `yonetici` (
  `id` int(11) NOT NULL,
  `isim` varchar(255) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `sifre` char(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `yonetici`
--

INSERT INTO `yonetici` (`id`, `isim`, `mail`, `sifre`) VALUES
(1, 'admin', 'koddehasi_bi10@gmail.com', 'koddehasi_bi10');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `denemeler`
--
ALTER TABLE `denemeler`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `deneme_turu`
--
ALTER TABLE `deneme_turu`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `dersliksinif`
--
ALTER TABLE `dersliksinif`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `ders_programi`
--
ALTER TABLE `ders_programi`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `devamsizlik`
--
ALTER TABLE `devamsizlik`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `gorseller`
--
ALTER TABLE `gorseller`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `hocalar`
--
ALTER TABLE `hocalar`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `kan`
--
ALTER TABLE `kan`
  ADD PRIMARY KEY (`kan_id`);

--
-- Tablo için indeksler `odeme_tarih`
--
ALTER TABLE `odeme_tarih`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `ogrenci`
--
ALTER TABLE `ogrenci`
  ADD PRIMARY KEY (`ogr_id`),
  ADD KEY `veli_id` (`veli_id`);

--
-- Tablo için indeksler `ogrencidersleri`
--
ALTER TABLE `ogrencidersleri`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `ogrenci_detay`
--
ALTER TABLE `ogrenci_detay`
  ADD PRIMARY KEY (`ogr_id`);

--
-- Tablo için indeksler `okullar`
--
ALTER TABLE `okullar`
  ADD PRIMARY KEY (`okul_id`);

--
-- Tablo için indeksler `sinavtarih`
--
ALTER TABLE `sinavtarih`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `siniflar`
--
ALTER TABLE `siniflar`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `veli`
--
ALTER TABLE `veli`
  ADD PRIMARY KEY (`veli_id`);

--
-- Tablo için indeksler `yonetici`
--
ALTER TABLE `yonetici`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mail` (`mail`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `denemeler`
--
ALTER TABLE `denemeler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- Tablo için AUTO_INCREMENT değeri `deneme_turu`
--
ALTER TABLE `deneme_turu`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Tablo için AUTO_INCREMENT değeri `dersliksinif`
--
ALTER TABLE `dersliksinif`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Tablo için AUTO_INCREMENT değeri `ders_programi`
--
ALTER TABLE `ders_programi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Tablo için AUTO_INCREMENT değeri `devamsizlik`
--
ALTER TABLE `devamsizlik`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Tablo için AUTO_INCREMENT değeri `gorseller`
--
ALTER TABLE `gorseller`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Tablo için AUTO_INCREMENT değeri `hocalar`
--
ALTER TABLE `hocalar`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Tablo için AUTO_INCREMENT değeri `kan`
--
ALTER TABLE `kan`
  MODIFY `kan_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Tablo için AUTO_INCREMENT değeri `odeme_tarih`
--
ALTER TABLE `odeme_tarih`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- Tablo için AUTO_INCREMENT değeri `ogrenci`
--
ALTER TABLE `ogrenci`
  MODIFY `ogr_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Tablo için AUTO_INCREMENT değeri `ogrencidersleri`
--
ALTER TABLE `ogrencidersleri`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Tablo için AUTO_INCREMENT değeri `ogrenci_detay`
--
ALTER TABLE `ogrenci_detay`
  MODIFY `ogr_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Tablo için AUTO_INCREMENT değeri `okullar`
--
ALTER TABLE `okullar`
  MODIFY `okul_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Tablo için AUTO_INCREMENT değeri `sinavtarih`
--
ALTER TABLE `sinavtarih`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Tablo için AUTO_INCREMENT değeri `siniflar`
--
ALTER TABLE `siniflar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- Tablo için AUTO_INCREMENT değeri `veli`
--
ALTER TABLE `veli`
  MODIFY `veli_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Tablo için AUTO_INCREMENT değeri `yonetici`
--
ALTER TABLE `yonetici`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
