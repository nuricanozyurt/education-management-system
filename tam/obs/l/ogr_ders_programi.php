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


        

<?php   echo $diger_bilgiler['sinif'];    ?>


<a href="ders_programi/<?php   echo $diger_bilgiler['sinif'];    ?>.xls">Ders Programımı indir</a>
<p>Not:(Sınıfının genel ders programıdır. Hepsine veya seçtiğin Derslere gidebilirsin)</p>

  
<!-- BU ALT KISIM ÖZEL GELİŞTİRDİĞİM KOD EXCELDEN VERİLERİ İŞLEMEK İÇİN-->

<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8" />

    <meta name="viewport" content="width=device-width, initial-scale=1" />
  
    <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
</head>
<body>
  <div class="container">
        <h2 class="text-center mt-4 mb-4">DERS PROGRAMIM</h2>
        <div id="excel_data" class="mt-5"></div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.8/xlsx.full.min.js"></script>
    <script>
        var excel_file = "ders_programi/<?php echo $diger_bilgiler['sinif']; ?>.xls";
           // sınııfımız değişkenini php ile ilgili dosya yerine yazdırıyoruz
        var req = new XMLHttpRequest();
        req.open("GET", excel_file, true);
        req.responseType = "arraybuffer";

        req.onload = function (event) {
            var data = new Uint8Array(req.response);
            var work_book = XLSX.read(data, { type: "array" });
            var sheet_name = work_book.SheetNames;
            var sheet_data = XLSX.utils.sheet_to_json(work_book.Sheets[sheet_name[0]], { header: 1 });

            if (sheet_data.length > 0) {
                var table_output = '<table class="table table-striped table-bordered">';
                for (var row = 0; row < sheet_data.length; row++) {
                    table_output += '<tr>';
                    for (var cell = 0; cell < sheet_data[row].length; cell++) {
                        if (row == 0) {
                            table_output += '<th>' + sheet_data[row][cell] + '</th>';
                        } else {
                            table_output += '<td>' + sheet_data[row][cell] + '</td>';
                        }
                    }
                    table_output += '</tr>';
                }
                table_output += '</table>';
                document.getElementById('excel_data').innerHTML = table_output;
            }
        };

        req.send();
    </script>
</body>
</html>

  
<?php include 'include/alt.php'; ?>














