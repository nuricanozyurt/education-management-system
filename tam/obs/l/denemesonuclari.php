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

   


?>
 <!-- yanda açılan menü bu her birine tek tek yapmak yerine include yapıyorum ve url kontrol izinsiz girişi önelmek için-->
     




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

            <!-- 1-3-block row start -->
            <div class="row">
             


               <div class="col-lg-8">
                  <div class="card">
                     <div class="card-header">
                        <h5 class="card-header-text">Denemelerde Başarı Grafiğin</h5>
                     </div>
                     <div class="card-block">
                      
<!-- bu alt kısım yandaki grafik harici css yapmak istemedim ve js direk burada yaptım -->
                               
<div class="grafik-container">
  <canvas id="grafikCanvas"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Chart.js kütüphanesini ekleyin -->




         <!-- burada şunu yapıcam gelen veriyi grafiğe çeviricem js ile -->
         <?php
         try {
             // Veritabanından tarih ve puan verilerini çekmek için sorgu yapılacak
             $sql = "SELECT tarih, puan, deneme_turu, turkce_dogru, turkce_yanlis, sosyal_dogru, sosyal_yanlis, matematik_dogru, matematik_yanlis, fen_dogru, fen_yanlis FROM denemeler WHERE ogr_id = ? ORDER BY tarih ASC";
             $stmt = $db->prepare($sql);
             $stmt->execute([$ogr_id]);
             $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

             $tarihler = array(); // Tarihleri tutacak dizi
             $puanlar = array(); // Puanları tutacak dizi
             $deneme_turu = array(); // Deneme türlerini tutacak dizi

             foreach ($rows as $row) {
                 // Türkçe tarih formatı için strftime fonksiyonu kullanılıyor
                 $turkce_tarih = strftime('%e %B', strtotime($row['tarih']));
                 $tarihler[] = $turkce_tarih;
                 $puanlar[] = $row['puan']; // Puanları diziye ekle

                 // Her bir deneme türü için doğru ve yanlış sayıları ile birlikte toplam doğru sayısını hesapla
                 $turkce_dogru = $row['turkce_dogru'] - ($row['turkce_yanlis']/4);  // 4 yanlış 1 doğru anlamında
                 $sosyal_dogru = $row['sosyal_dogru'] - ($row['sosyal_yanlis']/4);
                 $matematik_dogru = $row['matematik_dogru'] - ($row['matematik_yanlis']/4);
                 $fen_dogru = $row['fen_dogru'] - ($row['fen_yanlis']/4);
                 $toplamnetdogru = $turkce_dogru + $sosyal_dogru +  $matematik_dogru + $fen_dogru;
                 $toplamdogru =  $row['turkce_dogru'] + $row['sosyal_dogru'] + $row['matematik_dogru'] + $row['fen_dogru'];
                 $toplamyanlis =  $row['sosyal_yanlis'] + $row['fen_yanlis'] + $row['matematik_yanlis'] + $row['turkce_yanlis'];

                      $deneme_turu[] = array(
                     'tarih' => $turkce_tarih,
                     'tur' => $row['deneme_turu'],
                     'puan' => $row['puan'],
                     'turkce_dogru' => $turkce_dogru,
                     'sosyal_dogru' => $sosyal_dogru,
                     'matematik_dogru' => $matematik_dogru,
                     'fen_dogru' => $fen_dogru,
                     'toplamnetdogru' => $toplamnetdogru,
                     'toplamdogru' => $toplamdogru, 
                     'toplamyanlis' => $toplamyanlis
                 );

             }

             // Verileri JSON formatına dönüştürerek JavaScript'e aktar
             $tarihler_json = json_encode($tarihler);
             $puanlar_json = json_encode($puanlar);
             $deneme_turu_json = json_encode($deneme_turu); 

         echo "<script>
                 const ctx = document.getElementById('grafikCanvas').getContext('2d');
                 const grafik = new Chart(ctx, {
                   type: 'line',
                   data: {
                     labels: $tarihler_json,
                     datasets: [{
                       label: 'Veri: ',
                       data: $puanlar_json,
                       backgroundColor: 'rgba(255, 99, 132, 0.2)',
                       borderColor: 'rgba(255, 99, 132, 1)',
                       borderWidth: 1,
                       tension: 0.4,
                       borderDash: [5, 5]
                     }]
                   },
                   options: {
                     scales: {
                       y: {
                         beginAtZero: true
                       }
                     },
                     animation: {
                       duration: 2000
                     },
                     plugins: {
                       tooltip: {
                         callbacks: {
                           label: function(context) {
                             var label = context.dataset.label || '';
                             if (label) {
                               for (let i = 0; i < denemeTuruData.length; i++) {
                                 if (denemeTuruData[i].tarih === context.label) {
                                   label += 'Net Doğru: ' + denemeTuruData[i].toplamnetdogru + ', Toplam Doğru: ' + denemeTuruData[i].toplamdogru + ', Toplam Yanlış: ' + denemeTuruData[i].toplamyanlis;
                                   break;
                                 }
                               }
                             }

                             if (context.parsed.y !== null) {
                               label += '\\nPuan: ' + context.parsed.y;
                             }

                             return label;
                           }
                         }
                       }
                     }
                   }
                 });

                 const denemeTuruData = $deneme_turu_json;
                 console.log(denemeTuruData);
               </script>";

         } catch (PDOException $e) {
             echo "Bağlantı hatası: " . $e->getMessage();
         }
         ?>


         <style type="text/css">
            



         .grafik-container {
           width: 80%;
           max-width: 700px;
         }

         canvas {
           background-color: #ffffff;
           border-radius: 8px;
           box-shadow: 0 10px 20px rgba(0,0,0,0.1);
         }

         </style>




                        <!-- bu üst kısım yandaki grafik harici css yapmak istemedim ve js direk burada yaptım -->


                     </div>
                  </div>
               </div>


<?php 
try {
    // Öğrenci ID'sine göre sıralanmış, en sonuncu deneme verisini al
    $sql = "SELECT * FROM denemeler WHERE ogr_id = :ogr_id ORDER BY ogr_id DESC LIMIT 1";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':ogr_id', $ogr_id);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // Sonuncu denemenin verilerini ekrana yazdır
    if ($row) {
?>
        <div class="col-xl-4 col-lg-12 grid-item">
            <div class="card">
                <div class="card-block horizontal-card-img d-flex">
                    <div class="d-inline-block p-l-20">
                        <h6>DENEME SONUÇLARI:</h6>
                        <table>
                            <tr>
                                <th>Ders</th>
                                <th>Net</th>
                                <th>Doğru (D)</th>
                                <th>Yanlış (Y)</th>
                            </tr>
                            <tr>
                                <td>Türkçe</td>
                                <td><?php echo $row["turkce_dogru"]; ?></td>
                                <td><?php echo $row["turkce_dogru"]; ?></td>
                                <td><?php echo $row["turkce_yanlis"]; ?></td>
                            </tr>
                            <tr>
                                <td>Matematik</td>
                                <td><?php echo $row["matematik_dogru"]; ?></td>
                                <td><?php echo $row["matematik_dogru"]; ?></td>
                                <td><?php echo $row["matematik_yanlis"]; ?></td>
                            </tr>
                            <tr>
                                <td>Sosyal</td>
                                <td><?php echo $row["sosyal_dogru"]; ?></td>
                                <td><?php echo $row["sosyal_dogru"]; ?></td>
                                <td><?php echo $row["sosyal_yanlis"]; ?></td>
                            </tr>
                            <tr>
                                <td>Fen</td>
                                <td><?php echo $row["fen_dogru"]; ?></td>
                                <td><?php echo $row["fen_dogru"]; ?></td>
                                <td><?php echo $row["fen_yanlis"]; ?></td>
                            </tr>
                        </table>
                    </div>
                    <?php 
                        // $denemeturu değişkeni tanımlıysa kullan, değilse hata oluşmaması için boş bırak
                        if (isset($denemeturu)) {
                            echo '<h6 class="txt-warning rotate-txt">' . $denemeturu . '</h6>';
                        }
                    ?>
                </div>
            </div>
        </div>
      <?php
          } else {
              // Veri bulunamadığında mesajı göster
              echo "Üzgünüz, veriye ulaşamadık";
          }
      } catch(PDOException $e) {
          // Veritabanı hatası olduğunda mesajı göster
          echo "Üzgünüz, veriye ulaşamadık";
      }
      ?>

            <?php
try {
    // Öğrencinin sınıf bilgisini al
    $sinif = $ogrenci['sinif'];

    // Bugünün tarihini al
    $bugun = date('Y-m-d');

    // Sorguyu hazırla: Bugün ve gelecekteki tüm sınav tarihlerini al
    $sorgu = $db->prepare("SELECT sinif, tarih, sinav_turu FROM sinavtarih WHERE sinif = :sinif AND tarih >= :bugun ORDER BY tarih ASC");
    $sorgu->bindParam(':sinif', $sinif);
    $sorgu->bindParam(':bugun', $bugun);
    $sorgu->execute();

    // Sonuçları döngü içinde işle
    while ($sonuc = $sorgu->fetch(PDO::FETCH_ASSOC)) {
        $sinav_tarihi = $sonuc['tarih'];
        $sinif = $sonuc['sinif'];
        $sinav_turu = $sonuc['sinav_turu'];

        // İki tarih arasındaki gün farkını hesapla
        $gun_farki = (strtotime($sinav_tarihi) - strtotime($bugun)) / (60 * 60 * 24);

        // Sonucu ekrana yazdır
        echo '<div class="col-xl-4 col-lg-12 grid-item">
                  <div class="card">
                      <div class="card-block horizontal-card-img d-flex">
                          <div class="d-inline-block p-l-20">
                              <h6><strong>DENEME SINAVI TARİHİ:</strong> <h6 style="color: red;">' . $sinav_tarihi . '</h6></h6>' . $sinif . ' sınıfında gireceğin ' . $sinav_turu . ' sınavın ';
        if ($gun_farki > 0) {
            // Sınav tarihine daha günler varsa
            echo "Sınav tarihine <strong style='color: red;'> $gun_farki </strong> gün kaldı.";
        } else {
            // Eğer bugün sınav günü ise
            echo "<strong style='color: red;'> Bugün sınav günü!</strong>";
        }
        echo          '</div>
                      </div>
                  </div>
              </div>';
    }
} catch(PDOException $e) {
    // Hata oluştuğunda hata mesajını ekrana yazdır
    echo "Üzgünüz veriye ulaşamadık: " . $e->getMessage();
}
?>


            </div>

            <!-- 1-3-block row end -->

 
      
         <!-- Alt SAĞ ALT BUTON-->
         <div class="fixed-button">
            <a href="#!" class="btn btn-md btn-primary">
              <i class="fa fa-shopping-cart" aria-hidden="true"></i> Belki Eklerim
            </a>
         </div>


      </div>
   </div>


 
  
  
<?php include 'include/alt.php'; ?>
