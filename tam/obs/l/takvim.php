<?php 


// Oturumu başlat
session_start();



// Oturumda kullanıcı kimliği var mı kontrol et
if(isset($_SESSION['ogr_id'])) {
        
// Kullanıcı girişi yapılmış, kullanıcı kimliğini kullanabiliriz
    
    
        require_once '../../connect.php'; 
       
       $ogr_id = $_SESSION['ogr_id'];
      try {
        

         // Öğrenci bilgilerini al
        $stmt = $db->prepare("SELECT * FROM ogrenci WHERE ogr_id = :ogr_id");
        $stmt->bindParam(':ogr_id', $ogr_id);
        $stmt->execute();
        $ogrenci_bilgileri = $stmt->fetch(PDO::FETCH_ASSOC);

        // Öğrenciye ait diğer bilgileri al
        $stmt = $db->prepare("SELECT * FROM ogrenci_detay WHERE ogr_id = :ogr_id");
        $stmt->bindParam(':ogr_id', $ogr_id);
        $stmt->execute();
        $diger_bilgiler = $stmt->fetch(PDO::FETCH_ASSOC);

        // Öğrenciye ait görseli al
        $stmt = $db->prepare("SELECT gorsel FROM gorseller WHERE ogr_id = :ogr_id");
        $stmt->bindParam(':ogr_id', $ogr_id);
        $stmt->execute();
        $gorsel = $stmt->fetchColumn();

        // Eğer görsel bulunamadıysa varsayılan görseli ata
        if (!$gorsel) {
            $gorsel = "kayitsiz.png";
        }

        // Tüm bilgileri bir değişkene ata
        $ogrenci = array_merge($ogrenci_bilgileri, $diger_bilgiler, ['gorsel' => $gorsel]);

        // Öğrenci bilgilerini kullanarak istediğiniz işlemi yapabilirsiniz
        // Örneğin:
    /*    echo "Öğrenci Adı: " . $ogrenci['ogr_ad'] . "<br>";
        echo "Öğrenci Soyadı: " . $ogrenci['ogr_soyad'] . "<br>";
        echo "Öğrenci Görseli: <img src='" . $ogrenci['gorsel'] . "' alt='Öğrenci Görseli'><br>";
        */
    } catch(PDOException $e) {
        // Hata oluştuğunda hatayı göster
        echo "Hata: " . $e->getMessage();
    }


} else {
    // Kullanıcı girişi yapılmamış, isterseniz giriş sayfasına yönlendirme yapabilirsiniz
    header("Location: ../index.php");
    exit();
}

require_once 'include/leftslider.php'; 

   


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




 <!-- yanda açılan menü bu her birine tek tek yapmak yerine include yapıyorum ve url kontrol izinsiz girişi önelmek için-->
     



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

#ulkismi {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr 1fr 1fr 1fr 1fr;
    flex-wrap: wrap;
    list-style: none;

    #likismi{
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


      <div class="content-wrapper">
         <!-- Container-fluid starts -->
         <!-- Main content starts -->
         <div class="container-fluid">
            <div class="row">
               <div class="main-header">
                  <h4>Anasayfa</h4>
               </div>
            </div>
            <!-- 4-blocks row start -->
            <div class="row dashboard-header">
               <div class="col-lg-3 col-md-6">
                  <div class="card dashboard-product">
                     <span>DENEME SONUCUM</span>

                        <?php

                  // Bu kısım puan için
                  try {
                      // ogr_id ile ilgili en son eklenen deneme kaydını sorgulayalım
                      // Örneğin, 'id'  gibi bir sütun üzerinden en son kaydı sıralayabiliriz
                      $sql = "SELECT deneme_turu, puan FROM denemeler WHERE ogr_id = ? ORDER BY id DESC LIMIT 1";
                      $stmt = $db->prepare($sql);
                      $stmt->execute([$ogr_id]);
                      $row = $stmt->fetch();

                      if ($row) {
                          // Puan değerlerini alalım
                          $puan = $row['puan'];
                          $denemeturu = $row['deneme_turu'];
                          echo '<h2 class="dashboard-total-products">' . $puan . ' Puan</h2>';
                          // Son olarak, HTML çıktısını oluşturalım
                          echo '<span class="label label-warning">Türü: ' . $denemeturu . '</span> Sonuçlar Kısmından İncele<br>';
                      } else {
                          echo "Öğrenci detayı bulunamadı.";
                      }
                  } catch (PDOException $e) {
                      echo "Bağlantı hatası: " . $e->getMessage();
                  }

                  ?>

                     




                    
                     <div class="side-box">
                        <i class="ti-signal text-warning-color"></i>
                     </div>
                  </div>
               </div>
               <div class="col-lg-3 col-md-6">
                  <div class="card dashboard-product">
                     <span>Devamsızlığım</span>
                     


                                      <?php   
      
                                    // bu kısım devamsızlık için

                                     try {

                      // ogr_id ile devamsizlik tablosunu sorgulayalım
                      $sql = "SELECT devamsizlikgim, kalandevamsizlik FROM devamsizlik WHERE ogr_id = ?";
                      $stmt = $db->prepare($sql);
                      $stmt->execute([$ogr_id]);
                      $row = $stmt->fetch();

                      if ($row) {
                          // devamsizlikgim ve kalandevamsizlik değerlerini alalım
                          $devamsizlikgim = $row['devamsizlikgim'];
                          $kalandevamsizlik = $row['kalandevamsizlik'];
                           echo '<h2 class="dashboard-total-products">' . $devamsizlikgim . ' Gün Oldu</h2>';
                          // Son olarak, HTML çıktısını oluşturalım
                          echo '<span class="label label-primary">' . $devamsizlikgim . '</span> Devamsızlık Günüm<br>';
                          
                      } else {
                          echo "Öğrenci detayı bulunamadı.";
                      }
                  } catch (PDOException $e) {
                      echo "Bağlantı hatası: " . $e->getMessage();
                  }  

                  ?>
                     
                     <div class="side-box ">
                        <i class="ti-gift text-primary-color"></i>
                     </div>
                  </div>
               </div>
               <div class="col-lg-3 col-md-6">
                  <div class="card dashboard-product">
                     <span>Devamsızlık Kalan Gün Sayısı</span>
                     <h2 class="dashboard-total-products"><?php  echo  $kalandevamsizlik  ?><span> Gün Kaldı</span></h2>
                     <span class="label label-success"><?php  echo  $kalandevamsizlik  ?></span>Hata varsa bizim ile iletişime geçin
                     <div class="side-box">
                        <i class="ti-direction-alt text-success-color"></i>
                     </div>
                  </div>
               </div>
               <div class="col-lg-3 col-md-6">
                  <div class="card dashboard-product">
                     <span>Aylık Ödemeniz</span>
                     <h2 class="dashboard-total-products"><?php echo   $diger_bilgiler['ogr_ucret'];  ?><span> TL</span></h2>

                     <?php   

                     try {

    // ogr_id ile ogrenci_detay tablosunu sorgulayalım
    $sql = "SELECT odemedurumu, ogr_ucret FROM ogrenci_detay WHERE ogr_id = ?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$ogr_id]);
    $row = $stmt->fetch();

    if ($row) {
        // odemedurumu ve ogr_ucret değerlerini alalım
        $odemedurumu = $row['odemedurumu'];
        $ogr_ucret = $row['ogr_ucret'];

        // odemedurumu değerine göre renk ve yazı belirleyelim
        if ($odemedurumu == 0) {
            $renk = "danger";
            $odeme_durumu = "Ödenmedi";
        } else {
            $renk = "success";
            $odeme_durumu = "Ödendi";
        }

        // Son olarak, HTML çıktısını oluşturalım
      
        echo '<span class="label label-' . $renk . '">' . $odeme_durumu . '</span> Ödeme Durumu';
    } else {
        echo "Öğrenci detayı bulunamadı.";
    }
}
catch(PDOException $e)
{
    echo "Bağlantı hatası: " . $e->getMessage();
}
?>
                    
                     <div class="side-box">
                        <i class="ti-rocket text-danger-color"></i>
                     </div>
                  </div>
               </div>
            </div>
            <!-- 4-blocks row end -->
    <!-- Öğrenci adı ve soyadını göster -->
    <h1><?php echo $ogrenci['ogr_ad'] . " " . $ogrenci['ogr_soyad']; ?> </h1>
    
    <!-- Günün tarihini göster -->
    <p>Bugünün Tarihi: <?php echo $bugun; ?></p>

    <!-- Öğrenci derslerini listele -->
    <h2>Sevgili <?php echo $ogrenci['ogr_ad']  ?>  Seçtiğin derslere  göre senin için böyle Çalışma programı hazırladık</h2>
          <div class="buton-container">
        <button class="buton" id="indirBtn">İndir</button>
        <button class="buton" id="yenileBtn">Yenile</button>
    </div>
    
 
<?php

// Öğrenci derslerini al
$sorgu_dersler = $db->prepare("SELECT ders1, ders2, ders3, ders4, ders5, ders6, ders7, ders8 FROM ogrencidersleri WHERE ogr_id = ?");
$sorgu_dersler->execute([$ogr_id]);
$dersler = $sorgu_dersler->fetch(PDO::FETCH_ASSOC);

// Eğer dersler varsa devam et, yoksa hata mesajı göster
if ($dersler) {
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
    echo "<ul id='ulkismi' style='list-style: none; padding: 0;'>";

    // Her gün için döngü
    while ($baslangic_tarihi <= $bitis_tarihi) {
        // Tarihi al ve formatla
        $tarih = $baslangic_tarihi->format('Y-m-d');
        // Tarih için bir class tanımla
        $class = ($baslangic_tarihi->format('N') == 7) ? 'tatil' : '';

        // Tarihi ekrana yazdır
        echo "<li id='likismi' class='$class'><time datetime='$tarih'>" . $baslangic_tarihi->format('j') . "</time>";

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
} else {
    // Dersler bulunamadı mesajı göster
    echo "Öğrencinin dersleri bulunamadı.";
}
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


<?php include 'include/alt.php'; ?>
