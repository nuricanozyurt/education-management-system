<?php 


// Oturumu başlat
session_start();



// Oturumda kullanıcı kimliği var mı kontrol et
if(isset($_SESSION['email'])) {
        
// Kullanıcı girişi yapılmış, kullanıcı kimliğini kullanabiliriz
    
    
        require_once '../connect.php'; 
       
       $email = $_SESSION['email'];
    


} else {
    // Kullanıcı girişi yapılmamış, isterseniz giriş sayfasına yönlendirme yapabilirsiniz
    header("Location: ../admin.php");
    exit();
}




?>






<!-- bu alt form verileri işlemek için -->

<?php


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    

  

 
  // Öğrenci SINAV BİLGİSİ EKLE
$ogr_id = $_POST['ogr_id'];
$deneme_turu = $_POST['deneme_turu'];
$puan = $_POST['puan'];
$turkce_dogru = $_POST['turkce_dogru'];
$turkce_yanlis = $_POST['turkce_yanlis'];
$sosyal_dogru = $_POST['sosyal_dogru'];
$sosyal_yanlis = $_POST['sosyal_yanlis'];
$matematik_dogru = $_POST['matematik_dogru'];
$matematik_yanlis = $_POST['matematik_yanlis'];
$fen_dogru = $_POST['fen_dogru'];
$fen_yanlis = $_POST['fen_yanlis'];

try {
   
    // SQL sorgusu oluştur ve veritabanına ekle
    $stmt = $db->prepare("INSERT INTO denemeler (ogr_id, deneme_turu, puan, turkce_dogru, turkce_yanlis, sosyal_dogru, sosyal_yanlis, matematik_dogru, matematik_yanlis, fen_dogru, fen_yanlis) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$ogr_id, $deneme_turu, $puan, $turkce_dogru, $turkce_yanlis, $sosyal_dogru, $sosyal_yanlis, $matematik_dogru, $matematik_yanlis, $fen_dogru, $fen_yanlis]);

    echo "Veri başarıyla eklendi.";
    header("location: ogr_puanekle.php?ogr_id=$ogr_id");
        exit();
} catch(PDOException $e) {
    echo "Hata: " . $e->getMessage();
}


         }

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Öğrenci ve Veli Bilgileri</title>
<!-- jQuery eklentisini indirip projenize dahil edin -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<style type="text/css">
    
/* iPhone referanslı CSS */
.iphone-label {
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
    font-size: 16px;
    color: #333;
}

.iphone-select {
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    background-color: transparent;
    background-color: rgba(10, 0, 240, 0.3);
    border: 1px solid #ccc;
    padding: 10px;
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
    font-size: 16px;
    color: #333;
    width: 100%;
    max-width: 100%;
    box-sizing: border-box;
    border-radius: 5px;
}

/* İşaretçi simgesi için stil */
.iphone-select:after {
    content: '\25BC'; /* İşaretçi simgesi */
    position: absolute;
    top: 50%;
    right: 10px;
    transform: translateY(-50%);
    pointer-events: none;
    color: #666;
}

/* Seçenekler için stiller */
.iphone-select option {
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
    font-size: 16px;
    color: #333;
}



</style>
</head>
<body>



<?php include 'header.php';




?>


<?php
include("../connect.php");

// Öğrenci ID'sini GET parametresinden al
if(isset($_GET['ogr_id'])) {
    $ogr_id = $_GET['ogr_id'];
    

   }else {
    // Eğer POST isteği yapılmamışsa, $ogr_id'yi varsayılan bir değerle tanımlayabilirsiniz.
    $ogr_id = ''; // veya isteğe bağlı başka bir değer atayabilirsiniz.
}
?>


<div class="container">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <h1 class="text-center text-primary">Öğrenci ve Veli Bilgileri Düzenle</h1>
        </div>
        <div class="card-body">
          <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
            <!-- Eski Alanlar -->


                     <!-- baslangıc güncelleme  -->
          <?php    

            try {
             
                // Veritabanından deneme_turu tablosundaki verileri al
                $stmt = $db->prepare("SELECT * FROM deneme_turu");
                $stmt->execute();
                $deneme_turleri = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
            catch(PDOException $e)
            {
                echo $e->getMessage();
            }
            ?>

            <label for="derslik_sinif" class="iphone-label">Deneme Türünü Seç</label>
            <select name="deneme_turu" id="deneme_turu " class="iphone-select">
                <option value="">Lütfen bir deneme türü seçin</option>
                <?php foreach ($deneme_turleri as $deneme_turu): ?>
                    <option value="<?php echo $deneme_turu['deneme_turu']; ?>"><?php echo $deneme_turu['deneme_turu']; ?></option>
                <?php endforeach; ?>
            </select>
                                 <!-- son güncelleme  -->
            <br><br><br><br>

             <!-- gorsel yukleme bu altı -->
               <div class="form-row">
              <div class="col-md-6 form-group">
                <label>Öğrenci ID</label>
                <input required type="text" name="ogr_id" style="background-color: rgba(240, 0, 0, 0.2);"  value="<?php echo $ogr_id; ?>" class="form-control" readonly>
              </div>



  
  
 
 
 

              <div class="col-md-6 form-group">
                <label>Puanı</label>
                <input required type="text" name="puan"   value="" class="form-control">
              </div>
            </div>
            <div class="form-row">
              <div class="col-md-6 form-group">
                <label>Türkçe (D)</label>
                <input required type="text" name="turkce_dogru"   value="" class="form-control">
              </div>
              <div class="col-md-6 form-group">
  

               
                <label>Türkçe (Y)</label>
 

                 <input required type="text"   name="turkce_yanlis" value="" class="form-control" >
              </div>
            </div>
            <div class="form-row">
              <div class="col-md-6 form-group">
                <label>Sosyal Bilgileri (D)</label>
                <input required type="text" name="sosyal_dogru" value="" class="form-control">
              </div>
              <div class="col-md-6 form-group">
                <label>Sosyal Bilgileri (Y)</label>
                <input required type="text" name="sosyal_yanlis" value="" class="form-control">
              </div>
            </div>

  
 
  


            <div class="form-row">
              <div class="col-md-6 form-group">
                <label>Matematik (D)</label>
                <input required type="text" name="matematik_dogru" value="" class="form-control">
              </div>
              <div class="col-md-6 form-group">
                <label>Matematik (Y)</label>
                <input required type="text" name="matematik_yanlis" value="" class="form-control">
              </div>
            </div>
            <div class="form-row">
              <div class="col-md-6 form-group">
                <label>Fen (D)</label>
                <input required type="text" name="fen_dogru" value="" class="form-control">
              </div>
              <div class="col-md-6 form-group">
                <label>Fen (Y)</label>
                <input required type="text" name="fen_yanlis" value="" class="form-control">
              </div>
            </div>
            <!-- Yeni Eklenen Alanlar -->
           
            <!-- Yeni Eklenen Alanlar Sonu -->
            <div class="text-center mt-4">
              <button type="submit" name="edit_ogrenci_btn" class="btn btn-primary col-md-6">Düzenle</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>





          <?php include 'footer.php'; ?>





<!-- Loading Gif -->
<div id="loading" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%);">
    <img src="https://media.tenor.com/P_ZKppej79cAAAAi/gif.gif" alt="Yükleniyor...">
</div>
<script>
$(document).ready(function(){
    // Form submit olduğunda
    $("form").submit(function(e){
        e.preventDefault(); // Formun varsayılan submit işlemini durdur

        // loading.gif'i göster
        $("#loading").show();

        // 3 saniye sonra loading.gif'i gizle ve formu göster
        setTimeout(function(){
            $("#loading").hide();
            $("form").unbind('submit').submit(); // Formu tekrar submit et
        }, 3000);
    });
});
</script>



</body>

</html>
