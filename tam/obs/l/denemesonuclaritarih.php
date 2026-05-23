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
     
<style type="text/css">
	 /* arama butonu için */

        .header-search-container { position: relative; }

		.header-search-container .search-field {
  			font-size: var(--fs-7);
  			color: var(--onyx);
  			padding: 10px 15px;
  			padding-right: 50px;
  			border: 1px solid var(--cultured);
  			-webkit-border-radius: var(--border-radius-md);
       	    border-radius: var(--border-radius-md);
			}	

		.search-field::-webkit-search-cancel-button { display: none; }
	
		.search-btn {
 		 background: var(--white);
  		 position: absolute;
 		 top: 50%;
 		 right: 2px;
 		 -webkit-transform: translateY(-50%);
   		   -ms-transform: translateY(-50%);
  	        transform: translateY(-50%);
  	   	 color: var(--onyx);
 		 font-size: 18px;
 		 padding: 8px 15px;
 	    -webkit-border-radius: var(--border-radius-md);
          border-radius: var(--border-radius-md);
        -webkit-transition: color var(--transition-timing);
        -o-transition: color var(--transition-timing);
        transition: color var(--transition-timing);
}

.search-btn:hover { color: var(--salmon-pink); }
  .header-search-container { min-width: 300px; }

     .header-main .container { gap: 80px; }

  .header-search-container { -webkit-box-flex: 1; -webkit-flex-grow: 1; -ms-flex-positive: 1; flex-grow: 1; }

          input {
  display: block;
  width: 100%;
  font: inherit;
}



</style>



      <div class="content-wrapper">
         <!-- Container-fluid starts -->
         <!-- Main content starts -->
         <div class="container-fluid">
            <div class="row">
               <div class="main-header">
                  <h4>Deneme Sonuçları - Tüm Denemeler</h4>
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

        

<!-- Arama işlevi için JavaScript -->
<script type="text/javascript">
  function searchForElement() {
    var input, filter, tr, td, i, txtValue, h6;
    input = document.getElementById("searchInput");
    filter = input.value.toUpperCase();
    tr = document.getElementsByClassName("card-block");

    for (i = 0; i < tr.length; i++) {
      td = tr[i].getElementsByClassName("ara");
      matchFound = false;
      for (var j = 0; j < td.length; j++) {
        txtValue = td[j].textContent || td[j].innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
          matchFound = true;
          break; // Eğer eşleşme bulunduysa döngüden çık
        }
      }
      if (matchFound) {
        tr[i].style.display = "";
        tr[i].style.transform = "translateY(0)"; // Reset transform to initial position
      } else {
        tr[i].style.display = "none";
      }
    }
  }
</script>



<div class="header-search-container">

         <input type="text" id="searchInput" onkeyup="searchForElement()" class="search-field" placeholder="Tarih araması yap... (orn: 2024-04-20)">

          <button class="search-btn" style="display: none;">
            <ion-icon name="search-outline"></ion-icon>
          </button>

        </div>
<br><br>
        <!-- arama çubuğu son  -->





<?php

try {
    // Öğrenci ID'sine göre sıralanmış tüm denemeleri al
    $sql = "SELECT * FROM denemeler WHERE ogr_id = :ogr_id ORDER BY id DESC";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':ogr_id', $ogr_id);
    $stmt->execute();

    // Veri var mı yok mu kontrol et
    if ($stmt->rowCount() == 0) {
        echo "Üzgünüz, veri bulunamadı.";
    } else {
        // İlk ve son tarihleri al
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $ilk_tarih = $row["tarih"];
        $son_tarih = $row["tarih"];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $son_tarih = $row["tarih"];
        }

        // Slider'ın ilk ve son değerleri
        echo '<p id="slider-range"></p>';

        // Tüm denemeleri döngüyle alıp göster
        $stmt->execute(); // Sorguyu tekrar çalıştırarak başa dönelim
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            ?>
            <div class="col-xl-4 col-lg-12 grid-item">
                <div class="card">
                    <div class="card-block horizontal-card-img d-flex">
                        <div class="d-inline-block p-l-20">
                            <h6 class="ara"><?php echo $row["tarih"]; ?></h6>
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
                        <h6 class="txt-warning rotate-txt"><?php echo $denemeturu ?></h6>
                    </div>
                </div>
            </div>
            <?php
        }
    }
}
catch(PDOException $e) {
    echo "Hata: " . $e->getMessage();
}
?>


<!-- jQuery ve jQuery UI kütüphanelerini ekleyelim -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.min.js"></script>

<script>
    $( function() {
        var ilk_tarih = "<?php echo $ilk_tarih; ?>";
        var son_tarih = "<?php echo $son_tarih; ?>";
        $( "#slider-range" ).slider({
            range: true,
            min: new Date(ilk_tarih).getTime(), // İlk tarih
            max: new Date(son_tarih).getTime(), // Son tarih
            values: [ new Date(ilk_tarih).getTime(), new Date(son_tarih).getTime() ],
            slide: function( event, ui ) {
                // Slider değiştiğinde tarihleri güncelle
                $( "#slider-range" ).text( formatDate(new Date(ui.values[0])) + " - " + formatDate(new Date(ui.values[1])) );
            }
        });
        // Başlangıçtaki tarih aralığını yaz
        $( "#slider-range" ).text( formatDate(new Date(ilk_tarih)) + " - " + formatDate(new Date(son_tarih)) );

        // Tarih formatını dönüştürmek için yardımcı fonksiyon
        function formatDate(date) {
            var day = date.getDate();
            var month = date.getMonth() + 1;
            var year = date.getFullYear();
            return year + "-" + month + "-" + day;
        }
    } );
</script>




<!--  yedek -->
<?php /*

try {

    // Öğrenci ID'sine göre sıralanmış tüm denemeleri al
    $sql = "SELECT * FROM denemeler WHERE ogr_id = :ogr_id ORDER BY id DESC";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':ogr_id', $ogr_id);
    $stmt->execute();
    
    // Tüm denemeleri döngüyle alıp göster
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        ?>
        <div class="col-xl-4 col-lg-12 grid-item">
            <div class="card">
                <div class="card-block horizontal-card-img d-flex">
                    <div class="d-inline-block p-l-20">
                        <h6 class="ara"><?php echo $row["tarih"]; ?></h6>
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
                    <h6 class="txt-warning rotate-txt"><?php echo $denemeturu ?></h6>
                </div>
            </div>
        </div>
        <?php
    }
}
catch(PDOException $e) {
    echo $e->getMessage();
}


*/
?>

<!-- yedek son -->











 
      
        <!-- Alt SAĞ ALT BUTON-->
         <div class="fixed-button">
            <a href="#!" class="btn btn-md btn-primary">
              <i class="fa fa-shopping-cart" aria-hidden="true"></i> Belki Eklerim
            </a>
         </div>


      </div>
   </div>


 

  
  
<?php include 'include/alt.php'; ?>
