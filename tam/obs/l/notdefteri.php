<?php  // Oturumu başlat
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
       /* echo "Öğrenci Adı: " . $ogrenci['ogr_ad'] . "<br>";
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
         <div class="container-fluid">
            <!-- Main content starts -->

            <!-- Header starts -->
            <div class="row">
               <div class="col-sm-12 p-0">
                  <div class="main-header">
                     <h4>Ders çalışırken kullanabileceğin dijital notun. Mantığı basit üstüne tıkla yaz ve arından kaydet. </h4>
                     <ol class="breadcrumb breadcrumb-title breadcrumb-arrow">
                        <li class="breadcrumb-item">
                            <button id="download-btn">Notu Görsel Olarak İndir</button>  <!-- sayfayı görsel olarak indirme altaki
                              js kodu ile buradaki id yi takip ediyorum basınca işte o kod çalışıyor -->
                        </li>
                        
                        
                     </ol>
                  </div>
               </div>
            </div>
            <!-- Header ends -->




            </div></div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.3.2/html2canvas.min.js"></script>
<!-- 
bir tür dijital not defteri oluşturmak istedim ve kullanıcıların oluşturdukları notları görsel olarak indirebilmelerini sağlamak istiyorum. HTML5 Canvas API'si ve birkaç JavaScript kütüphanesi kullanarak bu işlevselliği sağlayabiliriz. html2canvas kütüphanesini kullanarak div'i bir canvas'a dönüştürüp sonra da bu canvas'ı bir görüntüye çevirdim ve kullanıcının indirmesini sağlayadım üsteki scripte o yüzden -->

<script>
document.getElementById('download-btn').addEventListener('click', function() {
    html2canvas(document.getElementById('notebook-paper')).then(function(canvas) {
        // Canvas'ı bir Data URL'sine dönüştür
        var image = canvas.toDataURL('image/png');
        
        // Bir <a> elementi yarat ve href olarak bu URL'yi ata
        var downloadLink = document.createElement('a');
        downloadLink.href = image;
        downloadLink.download = 'notum.png'; // İndirilen dosyanın adı yani png formatında
        
        // <a> elementini tıkla ve sonra DOM'dan kaldır
        document.body.appendChild(downloadLink);
        downloadLink.click();
        document.body.removeChild(downloadLink);
    });
});

</script>

<div id="notebook-paper">
        <header>
            <h1>Notum</h1>
        </header>
        <div id="content" contenteditable="true" >  
         <!-- öenemli not  "contenteditable="true" " kısmı sonradan yazı yazabilmem için -->
            
            <!-- Kullanıcı notlarını buraya yazıcak-->

            <div class="hipsum">
                <p>Buraya notlarınızı yazabilirsiniz...</p>
            </div>
        </div>
    </div>
   

<style type="text/css">

/* buton için */

#download-btn {
    background-color: #4CAF50; /* Yeşil arka plan */
    border: none;
    color: white;
    padding: 15px 32px; /* Üst ve alttan 15px, sağdan ve soldan 32px boşluk */
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px; /* Yazı boyutu */
    margin: 4px 2px;
    cursor: pointer; /* Fare imleci butonun üzerine geldiğinde değişir */
    border-radius: 5px; /* Kenar yuvarlaklığı */
    transition-duration: 0.4s; /* Geçiş efekti süresi */
}

#download-btn:hover {
    background-color: #45a049; /* Fare ile üzerine gelindiğinde arka plan rengi */
    box-shadow: 0 12px 16px 0 rgba(0,0,0,0.24), 0 17px 50px 0 rgba(0,0,0,0.19); /* Gölgelendirme efekti */
}


/* buton son */




   * {
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    -ms-box-sizing: border-box;
    -o-box-sizing: border-box;
    box-sizing: border-box;
}
 body {
    background: #f1f1f1;
    font-family: helvetica neue, helvetica, arial, sans-serif;
    font-weight: 200;
}
 #notebook-paper {
  
    width: 960px;
    height: 1109px;
    background: linear-gradient(to bottom, white 29px, #00b0d7 1px);
    margin: 50px auto;
    background-size: 100% 30px;
    position: relative;
    padding-top: 150px;
    padding-left: 160px;
    padding-right: 20px;
    overflow: hidden;
    border-radius: 5px;
    -webkit-box-shadow: 3px 3px 3px rgba(0, 0, 0, .2), 0px 0px 6px rgba(0, 0, 0, .2);
    -moz-box-shadow: 3px 3px 3px rgba(0, 0, 0, .2), 0px 0px 6px rgba(0, 0, 0, .2);
    -ms-box-shadow: 3px 3px 3px rgba(0, 0, 0, .2), 0px 0px 6px rgba(0, 0, 0, .2);
    -o-box-shadow: 3px 3px 3px rgba(0, 0, 0, .2), 0px 0px 6px rgba(0, 0, 0, .2);
    box-shadow: 3px 3px 3px rgba(0, 0, 0, .2), 0px 0px 6px rgba(0, 0, 0, .2);
}
 #notebook-paper:before {
    content: '';
    display: block;
    position: absolute;
    z-index: 1;
    top: 0;
    left: 140px;
    height: 100%;
    width: 1px;
    background: #db4034;
}
 #notebook-paper header {
    height: 150px;
    width: 100%;
    background: white;
    position: absolute;
    top: 0;
    left: 0;
}
 #notebook-paper header h1 {
    font-size: 60px;
    line-height: 60px;
    padding: 127px 20px 0 160px;
}
 #notebook-paper #content {
    margin-top: 67px;
    font-size: 20px;
    line-height: 30px;
}
 #notebook-paper #content p {
    margin: 0 0 30px 0;
}
 
</style>






  
<?php include 'include/alt.php'; ?>
