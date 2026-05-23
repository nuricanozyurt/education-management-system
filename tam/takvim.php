<?php
include("connect.php");

// Öğrenci ID'sini al
$ogr_id = $_GET['i'];

// Öğrenci bilgilerini al
$sorgu = $db->prepare("SELECT ogr_ad, ogr_soyad FROM ogrenci WHERE ogr_id = ?");
$sorgu->execute([$ogr_id]);
$ogrenci = $sorgu->fetch(PDO::FETCH_ASSOC);

// Şu anki tarihi al
$bugun = date("d.m.Y");

// Öğrenci derslerini al
$sorgu_dersler = $db->prepare("SELECT ders1, ders2, ders3, ders4, ders5, ders6, ders7, ders8 FROM ogrencidersleri WHERE ogr_id = ?");
$sorgu_dersler->execute([$ogr_id]);
$dersler = $sorgu_dersler->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Öğrenci Bilgileri ve Dersler</title>

    <!-- CSS Stili -->


<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.2/html2pdf.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.0/html2pdf.bundle.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/dom-to-image/2.6.0/dom-to-image.min.js"></script>

<style type="text/css">

 .tatil {
        background-color: rgba(0, 255, 0, 0.3); /* Yeşilimsi renk tonu ve hafif transparan */
    }


    @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@100;300;400;500;800&display=swap");

body {
    display: flex;
    flex-flow: column;
    align-items: center;
    font-family: "Poppins", serif;
    background: rgb(238, 174, 202);
    background: radial-gradient(
        circle,
        rgba(238, 174, 202, 1) 0%,
        rgba(148, 187, 233, 1) 100%
    );
}
h1 {
    font-weight: 800;
    margin: 1rem 0 0;
}

ul {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr 1fr 1fr 1fr 1fr;
    flex-wrap: wrap;
    list-style: none;

    li {
        display: flex;
        width: 10rem;
        height: 10rem;
        margin: 0.25rem;
        flex-flow: column;
        border-radius: 0.2rem;
        padding: 1rem;
        font-weight: 300;
        font-size: 0.8rem;
        box-sizing: border-box;
        background: rgba(255, 255, 255, 0.25);
        box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
        backdrop-filter: blur(4px);
        -webkit-backdrop-filter: blur(4px);
        border-radius: 10px;
        border: 1px solid rgba(255, 255, 255, 0.18);

        time {
            font-size: 2rem;
            margin: 0 0 1rem 0;
            font-weight: 500;
        }
    }
    .today {
        time {
            font-weight: 800;
        }
        background: #ffffff70;
    }
}

 .buton-container {
    display: flex;
}

.buton {
    background-color: #007aff; /* Renk iPhone tasarımından esinlenerek seçildi */
    border: none;
    color: white;
    padding: 10px 20px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;
    border-radius: 8px;
}

.buton:hover {
    background-color: #0056b3; /* Hover rengi */
}
</style>
</head>
<body>
    <!-- Öğrenci adı ve soyadını göster -->
    <h1><?php echo $ogrenci['ogr_ad'] . " " . $ogrenci['ogr_soyad']; ?> </h1>
    
    <!-- Günün tarihini göster -->
    <p>Bugünün Tarihi: <?php echo $bugun; ?></p>

    <!-- Öğrenci derslerini listele -->
    <h2>Sevgili <?php echo $ogrenci['ogr_ad']  ?>  Seçtiğin derslere  göre senin için böyle ders programı hazırladık</h2>
          <div class="buton-container">
        <button class="buton" id="indirBtn">İndir</button>
        <button class="buton" id="yenileBtn">Yenile</button>
    </div>
    
 
<?php
include("connect.php");

// Öğrenci ID'sini al
$ogr_id = $_GET['i'];

// Öğrenci derslerini al
$sorgu_dersler = $db->prepare("SELECT ders1, ders2, ders3, ders4, ders5, ders6, ders7, ders8 FROM ogrencidersleri WHERE ogr_id = ?");
$sorgu_dersler->execute([$ogr_id]);
$dersler = $sorgu_dersler->fetch(PDO::FETCH_ASSOC);

// Tüm dersleri bir diziye ekleyelim
$tum_dersler = [];
foreach ($dersler as $ders) {
    if (!empty($ders)) {
        $tum_dersler[] = $ders;
    }
}

// Bugünkü tarihi al
$bugun = new DateTime();

// Tarihlerin başlangıç ve bitiş tarihlerini belirle
$baslangic_tarihi = clone $bugun;
$bitis_tarihi = (clone $baslangic_tarihi)->modify('+28 days');

// <ul> etiketi ile başla
echo "<ul style='list-style: none; padding: 0;'>";

// Her gün için döngü
while ($baslangic_tarihi <= $bitis_tarihi) {
    // Tarihi al ve formatla
    $tarih = $baslangic_tarihi->format('Y-m-d');
    // Tarih için bir class tanımla
    $class = ($baslangic_tarihi->format('N') == 7) ? 'tatil' : '';

    // Tarihi ekrana yazdır
    echo "<li class='$class'><time datetime='$tarih'>" . $baslangic_tarihi->format('j') . "</time>";

    // Eğer gün Pazar ise, "Tatil" yaz
    if ($baslangic_tarihi->format('N') == 7) {
        echo " Tatil";
    } else {
        // Gün sayısı
        $gun_sayisi = rand(1, 2);

        // Eğer aralık 8 gün değilse, rastgele dersleri ekle
        if ($gun_sayisi != 8) {
            // Rastgele dersleri sıralayalım
            shuffle($tum_dersler);
            // Gün sayısı kadar ders ekleyelim
            for ($i = 0; $i < $gun_sayisi; $i++) {
                // Eğer dersler bitmemişse, bir ders ekle
                if (!empty($tum_dersler)) {
                    echo $tum_dersler[array_rand($tum_dersler)];
                    // Eğer bu son ders değilse ve bir sonraki ders de varsa, araya "ve" ekle
                    if ($i < $gun_sayisi - 1 && isset($tum_dersler[$i + 1])) {
                        echo " ve ";
                    }
                }
            }
        }
    }

    // </li> etiketi ile kapat
    echo "</li>";

    // Bir sonraki güne geç
    $baslangic_tarihi->modify('+1 day');
}

// </ul> etiketi ile kapat
echo "</ul>";
?>



<script type="text/javascript">
    
document.getElementById("indirBtn").addEventListener("click", function() {
    // Ekranı PNG olarak kaydet
    domtoimage.toBlob(document.body, { quality: 1 }) // Kaliteyi en yükseğe ayarladık
        .then(function(blob) {
            // Blob'u indirme bağlantısına dönüştür
            var link = document.createElement('a');
            link.download = 'ekran.png';
            link.href = window.URL.createObjectURL(blob);
            link.click();
        });
});
document.getElementById("yenileBtn").addEventListener("click", function() {
    // Sayfanın yeniden yüklenmesi
    location.reload();
});

</script>