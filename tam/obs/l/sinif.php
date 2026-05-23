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


            <!-- Bu alt kısım kullnıcının ogr_id bilgisine göre sorgu yapan bir algoritme ve onun ile aynı sııfta olanları gösteiyoruz -->

             <?php


  try {
    $suankisinif = $diger_bilgiler['sinif'];

    // Öğrenci bilgilerini al
    $stmt = $db->prepare("SELECT ogr_id, ogr_ad, ogr_soyad FROM ogrenci WHERE ogr_id IN (SELECT ogr_id FROM ogrenci_detay WHERE sinif = :sinif)");
    $stmt->bindParam(':sinif', $suankisinif);
    $stmt->execute();
    $ogrenciler = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // HTML içeriğini oluşturuyoruz
    echo '<div class="row" ';
    echo '<div class="col-xl-8 col-lg-12" style="width: 100%;">';
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
    
    // Tüm öğrencilerin bilgilerini tabloya eklemek kısmı
    foreach ($ogrenciler as $ogrenci) {
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
        echo $ogr_mail; // Öğrenci mailini tabloya ekliyoruz
        echo '</td>';
        echo '</tr>';
    }

    echo '</tbody>';
    echo '</table>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
} catch (PDOException $e) {
    echo "Hata: " . $e->getMessage();
}

?>

            <!-- 2-1 block end -->
         </div>
       
      </div>
   </div>


  
<?php include 'include/alt.php'; ?>
