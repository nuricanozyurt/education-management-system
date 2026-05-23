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
               <div class="col-lg-4">
                  <div class="card">
                     <div class="user-block-2">
                      <img class="img-fluid rounded-circle" style="max-width: 50%; max-height: 50%; object-fit: cover;" src="ogrenciimg/<?php echo $gorsel ?>" alt="user-header">

                        <h5><?php  echo    $ogrenci['ogr_ad'] .' '. $ogrenci['ogr_soyad'] ?></h5>
                        <h6>Öğrenci</h6>
                     </div>
                     <div class="card-block">

                        <div class="user-block-2-activities">
                           <div class="user-block-2-active"> 
                              <i class="icofont icofont-clock-time"></i><strong> Adres-Okul  </strong> <?php  echo   $ogrenci['ogr_adres'] . ' /<br>' . $ogrenci['ogr_okul']?> 
                              <label class="label label-primary">0</label>
                           </div>
                        </div>
                        <div class="user-block-2-activities">
                           <div class="user-block-2-active">
                              <i class="icofont icofont-picture"></i><strong>  TC: </strong> <?php  echo   $ogrenci['ogr_tc'] ?>
                              <label class="label label-primary">0</label>
                           </div>
                        </div>
                        <div class="user-block-2-activities">
                           <div class="user-block-2-active">
                              <i class="icofont icofont-picture"></i><strong>  Mail Adresi: </strong> <?php  echo   $ogrenci['ogr_mail'] ?>
                              <label class="label label-primary">0</label>
                           </div>
                        </div>
                        <div class="user-block-2-activities">
                           <div class="user-block-2-active">
                              <i class="icofont icofont-ui-user"></i> <strong> İletişim:</strong> <?php  echo   $ogrenci['ogr_tel'] ?>
                              <label class="label label-primary">0</label>
                           </div>

                        </div>
                        <div class="user-block-2-activities">
                           <div class="user-block-2-active">
                              <i class="icofont icofont-users"></i> <strong> Doğum Tarihi:  </strong> <?php  echo   $ogrenci['ogr_dogum_tar'] ?>
                              <label class="label label-primary">0</label>
                           </div>
                        </div>

                        
                        <div class="user-block-2-activities">
                           <div class="user-block-2-active">
                              <i class="icofont icofont-picture"></i><strong>  Sınıf: </strong> <?php  echo   $ogrenci['sinif'] ?>
                              <label class="label label-primary">0</label>
                           </div>
                        </div>
                         
                        <div class="user-block-2-activities">
                           <div class="user-block-2-active">
                              <i class="icofont icofont-picture"></i><strong>  Kan Grubu: </strong> <?php  echo   $ogrenci['ogr_kan_grubu'] ?>
                              <label class="label label-primary">0</label>
                           </div>
                        </div>
                        
                        <div class="user-block-2-activities">
                           <div class="user-block-2-active">
                              <i class="icofont icofont-picture"></i><strong>  Ödemesi Gereken ücret: </strong> <?php  echo   $ogrenci['ogr_ucret'] ?> TL
                              <label class="label label-primary">0</label>
                           </div>
                        </div>
                        <div class="user-block-2-activities">
                           <div class="user-block-2-active">
                              <i class="icofont icofont-picture"></i><strong>  Ödeme Durumu: </strong> 
                              <?php  // odemedurumu değerine göre renk ve yazı belirleyelim
                                   if ($odemedurumu == 0) {
                                       $renk = "danger";
                                       $odeme_durumu = "Ödenmedi";
                                   } else {
                                       $renk = "success";
                                       $odeme_durumu = "Ödendi";
                                   } 

                                    // Son olarak, HTML çıktısını oluşturalım
      
                                 echo '<span class="label label-' . $renk . '">' . $odeme_durumu . '</span>';
                                   ?>
                              <label class="label label-primary">0</label>
                           </div>
                        </div>
                        <div class="user-block-2-activities">
                           <div class="user-block-2-active">
                              <i class="icofont icofont-picture"></i><strong>  Bizlere Kayıt Tarihin: </strong> <?php  echo   $ogrenci['ogr_kayit_tar'] ?>
                              <label class="label label-primary">0</label>
                           </div>
                        </div>
                        <div class="text-center">
                           <button type="button" class="btn btn-warning waves-effect waves-light text-uppercase m-r-30">
                                    Öğrenci
                                </button>
                           <button type="button" class="btn btn-primary waves-effect waves-light text-uppercase">
                                    Detay
                                </button>
                        </div>
                     </div>
                  </div>
               </div>


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
        $turkce_dogru = $row['turkce_dogru'] - $row['turkce_yanlis']/4;  // 4 yanlış 1 doğru anlamında
        $sosyal_dogru = $row['sosyal_dogru'] - $row['sosyal_yanlis']/4;
        $matematik_dogru = $row['matematik_dogru'] - $row['matematik_yanlis']/4;
        $fen_dogru = $row['fen_dogru'] - $row['fen_yanlis']/4;
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


                              
            <!-- puanın son verisinı alıcam --> 
               <div class="col-xl-4 col-lg-12 grid-item">
                  <div class="card">
                     <div class="card-block horizontal-card-img d-flex"> <p> En son deneme</p>
                        <img class="media-object img-circle" src="ogrenciimg/<?php echo $gorsel; ?>" alt="Generic placeholder image">

                        <div class="d-inlineblock  p-l-20">
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
                                echo '<h6 class="dashboard-total-products">' . $puan . ' Puan</h6>';
                                // Son olarak, HTML çıktısını oluşturalım
                                echo '<span class="label label-warning">Türü: ' . $denemeturu . '</span> Sonuçlar Kısmından İncele<br>';
                            } else {
                                echo "Öğrenci detayı bulunamadı.";
                            }
                        } catch (PDOException $e) {
                            echo "Bağlantı hatası: " . $e->getMessage();
                        }

                        ?>

                          <a href="#">contact@admin.com</a>
                       </div>
                        <h6 class="txt-warning rotate-txt">+</h6>
                     </div>
                  </div>
               </div>
               <!-- puanın sondam 1 öncesi verisinı alıcam --> 

               <div class="col-xl-4 col-lg-12 grid-item">
                  <div class="card">
                     <div class="card-block horizontal-card-img d-flex"><p> Bir önceki deneme</p>
                        <img class="media-object img-circle" src="ogrenciimg/<?php echo $gorsel; ?>" alt="Generic placeholder image">

                        <div class="d-inlineblock  p-l-20">
                                  <?php



try {
    // ogr_id ile ilgili sondan bir önceki deneme kaydını sorgulayalım
    $sql = "SELECT deneme_turu, puan FROM denemeler WHERE ogr_id = ? ORDER BY id DESC LIMIT 1 OFFSET 1";
    $stmt = $db->prepare($sql);
    $stmt->execute([$ogr_id]);
    $row = $stmt->fetch();

    if ($row) {
        // Puan değerlerini ve deneme türünü alalım
        $puan = $row['puan'];
        $denemeturu = $row['deneme_turu'];
        echo '<h6 class="dashboard-total-products">' . $puan . ' Puan</h6>';
        // HTML çıktısını oluşturalım
        echo '<span class="label label-warning">Türü: ' . $denemeturu . '</span> Sonuçlar Kısmından İncele<br>';
    } else {
        echo "İlgili öğrenciye ait yeterli kayıt bulunamadı.";
    }
} catch (PDOException $e) {
    echo "Bağlantı hatası: " . $e->getMessage();
}

?>


                          
                          <a href="#">contact@admin.com</a>
                       </div>
                        <h6 class="txt-danger rotate-txt">+</h6>
                     </div>
                  </div>
               </div>









 <!-- Bu alt kısım kullnıcının ogr_id bilgisine göre sorgu yapan bir algoritme ve onun ile aynı sııfta olanları gösteiyoruz -->










<?php

try {
    $suankisinif = $diger_bilgiler['sinif'];

    // Öğrenci bilgilerini al
    $stmt = $db->prepare("SELECT ogr_id, ogr_ad, ogr_soyad FROM ogrenci WHERE ogr_id IN (SELECT ogr_id FROM ogrenci_detay WHERE sinif = :sinif)");
    $stmt->bindParam(':sinif', $suankisinif);
    $stmt->execute();
    $ogrenciler = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo '<div class="col-xl-8 col-lg-12">';
    echo '<div class="card">';
    echo '<div class="card-block"><center><h1 style="font-size: 16px;">Sınıfınızdaki Kişiler - ' . $suankisinif . '</h1></center><br>';
    echo '<div class="table-responsive">';
    echo '<table class="table m-b-0 photo-table">';
    echo '<thead>';
    echo '<tr class="text-uppercase">';
    echo '<th>Görsel</th>';
    echo '<th>Öğrenci İsmi</th>';
    echo '<th>Sınıfı</th>';
    echo '<th>Mail Adresi</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';

    // İlk üç öğrenciyi göstermek için sayaç kullanın
    $count = 0;
    foreach ($ogrenciler as $ogrenci) {
        if ($count < 3) {
            $ogr_id = $ogrenci['ogr_id'];

            // Derslik bilgisini al
            $stmt = $db->prepare("SELECT sinif, ogr_mail FROM ogrenci_detay WHERE ogr_id = :ogr_id");
            $stmt->bindParam(':ogr_id', $ogr_id);
            $stmt->execute();
            $derslik_sinif = "";
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $derslik_sinif .= $row['sinif'] . "<br>";
                $ogr_mail = $row['ogr_mail']; // Öğrenci mailini al
            }

            // Öğrencinin fotoğrafını al
            $stmt = $db->prepare("SELECT gorsel FROM gorseller WHERE ogr_id = :ogr_id");
            $stmt->bindParam(':ogr_id', $ogr_id);
            $stmt->execute();
            $gorsel = $stmt->fetchColumn();

            // Öğrencinin bilgilerini tabloya ekleyin
            echo '<tr>';
            echo '<th>';
            echo '<img class="img-fluid img-circle" src="ogrenciimg/' . $gorsel . '" alt="User">';
            echo '</th>';
            echo '<td>' . $ogrenci['ogr_ad'] . ' ' . $ogrenci['ogr_soyad'] . '</td>';
            echo '<td>';
            echo $derslik_sinif;
            echo '</td>';
            echo '<td>';
            echo $ogr_mail; // Öğrenci mailini tabloya ekleyin
            echo '</td>';
            echo '</tr>';

            $count++;
        } else {
            break; // Sayaç 3'e ulaştığında döngüyü sonlandırın
        }
    }

    echo '</tbody>';
    echo '</table>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</div>';

} catch (PDOException $e) {
    echo "Hata: " . $e->getMessage();
}

?>




           






            </div>
            <!-- 1-3-blok row end -->

           

            <!-- 2-1 block end -->
         </div>
           <!-- Alt SAĞ ALT BUTON-->
         <div class="fixed-button">
            <a href="#!" class="btn btn-md btn-primary">
              <i class="fa fa-shopping-cart" aria-hidden="true"></i> Belki Eklerim
            </a>
         </div>

      </div>
   </div>


  
<?php include 'include/alt.php'; ?>
