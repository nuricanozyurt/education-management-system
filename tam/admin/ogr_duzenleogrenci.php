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

    try {
        // Öğrenci bilgilerini sorgula
        $sorgu_ogrenci = $db->prepare("SELECT ogr_ad, ogr_soyad, ogr_tc, veli_id FROM ogrenci WHERE ogr_id = ?");
        $sorgu_ogrenci->execute([$ogr_id]);
        $ogrenci = $sorgu_ogrenci->fetch(PDO::FETCH_ASSOC);

        // Öğrenci bilgilerini yazdır
        if($ogrenci) {
            // Eğer öğrenciye ait veli bilgisi varsa, veli bilgilerini sorgula ve yazdır
            if($ogrenci['veli_id']) {
                $veli_id = $ogrenci['veli_id'];
                $sorgu_veli = $db->prepare("SELECT veli_ad, veli_soyad, veli_tel, veli_tc, veli_meslek, veli_mail FROM veli WHERE veli_id = ?");
                $sorgu_veli->execute([$veli_id]);
                $veli = $sorgu_veli->fetch(PDO::FETCH_ASSOC);

                if($veli) {   /*
                    echo "<h2>Veli Bilgileri</h2>";
                    echo "Ad: " . $veli['veli_ad'] . "<br>";
                    echo "Soyad: " . $veli['veli_soyad'] . "<br>";
                    echo "Telefon: " . $veli['veli_tel'] . "<br>";
                    echo "TC Kimlik No: " . $veli['veli_tc'] . "<br>";
                    echo "Meslek: " . $veli['veli_meslek'] . "<br>";
                    echo "E-posta: " . $veli['veli_mail'] . "<br>";
                    */  /* gerekirse kullanırıım */
                } else {
                    echo "Veli bilgisi bulunamadı.";
                }
            } else {
                echo "Öğrenciye ait veli bilgisi bulunamadı.";
            }
        } else {
            echo "Öğrenci bulunamadı.";
        }

        // Öğrenci detaylarını sorgula
        $sorgu_detay = $db->prepare("SELECT ogr_tel, ogr_adres, ogr_okul, ogr_kan_grubu, ogr_kayit_tar, ogr_dogum_tar, ogr_ucret, ogr_mail, sinif FROM ogrenci_detay WHERE ogr_id = ?");
        $sorgu_detay->execute([$ogr_id]);
        $ogrenci_detay = $sorgu_detay->fetch(PDO::FETCH_ASSOC);

        // Öğrenci detaylarını yazdır
        if($ogrenci_detay) {
        /*    echo "<h2>Öğrenci Detayları</h2>";
            echo "Telefon: " . $ogrenci_detay['ogr_tel'] . "<br>";
            echo "Adres: " . $ogrenci_detay['ogr_adres'] . "<br>";
            echo "Okul: " . $ogrenci_detay['ogr_okul'] . "<br>";
            echo "Kan Grubu: " . $ogrenci_detay['ogr_kan_grubu'] . "<br>";
            echo "Kayıt Tarihi: " . $ogrenci_detay['ogr_kayit_tar'] . "<br>";
            echo "Doğum Tarihi: " . $ogrenci_detay['ogr_dogum_tar'] . "<br>";
            echo "Ücret: " . $ogrenci_detay['ogr_ucret'] . "<br>";
            echo "E-posta: " . $ogrenci_detay['ogr_mail'] . "<br>";
        
          */  /* gerekirse kullanırıım */
        } else {
            echo "Öğrenci detayları bulunamadı.";
        }
    } catch(PDOException $e) {
        // echo "Hata: " . $e->getMessage();
    }
} else {
    echo "Öğrenci ID bilgisi eksik.";
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
          <form action="" method="post" accept-charset="utf-8" enctype="multipart/form-data">
            <!-- Eski Alanlar -->


                     <!-- baslangıc güncelleme  -->
              

               <?php  // "dersliksinif" tablosundan verileri çek
$stmt = $db->prepare("SELECT dersliksinif FROM dersliksinif");
$stmt->execute();
$derslik_siniflari = $stmt->fetchAll(PDO::FETCH_ASSOC); ?>


   <label for="derslik_sinif" class="iphone-label">Derslik Sınıf (Güncellemek için seçeneklerden seç)</label>
<select name="sinif" id="derslik_sinif" class="iphone-select">
    <option value="<?php echo $ogrenci_detay['sinif']; ?>" selected><?php echo $ogrenci_detay['sinif']; ?></option> <!-- İlk değer -->
    <?php foreach ($derslik_siniflari as $sinif): ?>
        <option value="<?php echo $sinif['dersliksinif']; ?>"><?php echo $sinif['dersliksinif']; ?></option>
    <?php endforeach; ?>
</select>

                     <!-- son güncelleme  -->
<br><br><br><br>

 <!-- gorsel yukleme bu altı -->

<center> <!-- ortalamak için  -->

              <div class="col-md-6 form-group">
                
                <?php   /* şimdi şey yapmam gerek veri tbanından ogr_id ye göre sorgu ve karşılaştırma eğer gorseller tablomda ogr_id ile eşleşen değer varsa gorsel sütünundaki değeri alıcam ve arından img ile birleştirip o görseli çekicem. yoksada boş bir değer atayacam bu sayede her türlü bir görseli ekranda göstericem */

 // Veritabanından gorseli al
    $query = $db->prepare("SELECT gorsel FROM gorseller WHERE ogr_id = :ogr_id");
    $query->bindParam(':ogr_id', $ogr_id, PDO::PARAM_INT);
    $query->execute();
    $gorsel = $query->fetchColumn();

    if ($gorsel) {
        // Eğer gorsel varsa ekrana bas
        echo '<img  style="width: 40%; border-radius: 50%;"  src="../obs/l/ogrenciimg/' . $gorsel . '" alt="Öğrenci Görseli">';
    } else {
        // Eğer gorsel yoksa varsayılan görseli ekrana bas
        echo '<img  style="width: 40%; border-radius: 50%;" src="../obs/l/ogrenciimg/kayitsiz.png" alt="Varsayılan Görsel">';
    }

    ?>
 
              </div>
              
         




<div class="col-md-6 form-group">
     <div class="image-container">
  <label for="gorsel" class="image-upload">
    <div class="image-preview">
      <span id="gorsel-isim">Görsel Yükle</span>
    </div>
  </label>
  <p style="margin-left: 20px; font-size: 12px">Not: Lütfen Görseli Kare Formatında Atınız*</p>
  <input type="file" id="gorsel" name="gorsel" accept="image/*"><br><br>
</div>

<script>  // şimdi kare formatta seçmem gerekiyor kaliteli olsun diye uyarı verdim bende
  document.getElementById('gorsel').onchange = function (event) {
    var file = event.target.files[0];
    var imageType = /image.*/;

    if (file.type.match(imageType)) {
        var reader = new FileReader();

        reader.onload = function (e) {
            var img = new Image();
            img.src = reader.result;

            img.onload = function () {
                if (img.width === img.height) {
                    // Görüntü kare boyutlarında ise devam et
                    console.log('Görüntü kare boyutlarında.');
                } else {
                    // Görüntü kare boyutlarında değilse uyarı ver ve dosya seçimini iptal et
                    alert('Lütfen Kare Boyutlarında bir görüntü seçin.');
                    document.getElementById('gorsel').value = ''; // Dosya seçimi iptal edilir.
                }
            };
        };

        reader.readAsDataURL(file);
    } else {
        // Seçilen dosya bir görüntü değilse uyarı ver ve dosya seçimini iptal et
        alert('Lütfen bir görüntü dosyası seçin.');
        document.getElementById('gorsel').value = ''; // Dosya seçimi iptal edilir.
    }
};

</script>


    <style type="text/css">
         /* gorsel ekleme kısmı için özel tasarım ekledim */
.image-container {
  width: 40%;
  display: flex;
  justify-content: center;
  align-items: center;
}

.image-container input[type="file"] {
  display: none;
}

.image-container .image-upload {
  border: 2px dashed #ccc;
  padding: 16px;
  border-radius: 8px;
  cursor: pointer;
}

.image-container .image-preview {
  width: 30%;
  height: 20px;
  display: flex;
  justify-content: center;
  align-items: center;
  border: 2px dashed #ccc;
  border-radius: 8px;
}

.image-container .image-preview span {
  color: #888;
  font-size: 14px;
}



    </style>






<script>
  var gorselInput = document.getElementById("gorsel");
  var gorselIsimSpan = document.getElementById("gorsel-isim");

  gorselInput.addEventListener("change", function() {
    //var gorselDosya = gorselInput.files[0];
    //gorselIsimSpan.textContent = gorselDosya.name;
    gorselIsimSpan.textContent = "Görsel Seçildi";
  });

  // bu js kodunda şunu yaptık eğer dedim kullanıcı görsel-isim id li yukarıdaki şeye tıklarsa onun artık yeni ismi görsel yükle değil görsel sçeildi olsun.
</script>

  </div>
            
<br><br><br>
</center>
    <!-- üst kısım görsel yükleme işlemi -->


            <div class="form-row">
              <div class="col-md-6 form-group">
                <label>Öğrenci Adı</label>
                <input required type="text" name="ogr_ad" style="background-color: rgba(240, 0, 0, 0.2);"  value="<?php echo $ogrenci['ogr_ad']; ?>" class="form-control">
              </div>
              <div class="col-md-6 form-group">
                <label>Öğrenci Soyadı</label>
                <input required type="text" name="ogr_soyad" style="background-color: rgba(240, 0, 0, 0.2);"  value="<?php echo $ogrenci['ogr_soyad']; ?>" class="form-control">
              </div>
            </div>
            <div class="form-row">
              <div class="col-md-6 form-group">
                <label>Öğrenci TC Kimlik No</label>
                <input required type="text" name="ogr_tc"  style="background-color: rgba(0, 240, 0, 0.2);"  value="<?php echo $ogrenci['ogr_tc']; ?>" class="form-control">
              </div>
              <div class="col-md-6 form-group">
  

                <!--   <label>SINIFI</label>
                <input required type="text" style="background-color: rgba(0, 0, 0, 0.2);"  name="sinif" value="<?php echo $ogrenci_detay['sinif']; ?>" class="form-control" > 
                -->  
                <label>Veli_ID</label>
 

                 <input required type="text"   name="veli_id" value="<?php echo $ogrenci['veli_id']; ?>" class="form-control" readonly >
              </div>
            </div>
            <div class="form-row">
              <div class="col-md-6 form-group">
                <label>Veli Adı</label>
                <input required type="text" name="veli_ad" value="<?php echo $veli['veli_ad']; ?>" class="form-control">
              </div>
              <div class="col-md-6 form-group">
                <label>Veli Soyadı</label>
                <input required type="text" name="veli_soyad" value="<?php echo $veli['veli_soyad']; ?>" class="form-control">
              </div>
            </div>
            <div class="form-row">
              <div class="col-md-6 form-group">
                <label>Veli Mail</label>
                <input required type="text" name="veli_mail" value="<?php echo $veli['veli_mail']; ?>" class="form-control">
              </div>
              <div class="col-md-6 form-group">
                <label>Veli Telefonu</label>
                <input required type="text" name="veli_tel" value="<?php echo $veli['veli_tel']; ?>" class="form-control">
              </div>
            </div>
            <div class="form-row">
              <div class="col-md-6 form-group">
                <label>Veli TC Kimlik No</label>
                <input required type="text" name="veli_tc" value="<?php echo $veli['veli_tc']; ?>" class="form-control">
              </div>
              <div class="col-md-6 form-group">
                <label>Veli Meslek</label>
                <input required type="text" name="veli_meslek" value="<?php echo $veli['veli_meslek']; ?>" class="form-control">
              </div>
            </div>
            <!-- Yeni Eklenen Alanlar -->
            <div class="form-row">
              <div class="col-md-6 form-group">
                <label>Öğrenci Mail</label>
                <input required type="text" name="ogr_mail" value="<?php echo $ogrenci_detay['ogr_mail']; ?>" class="form-control">
              </div>
              <div class="col-md-6 form-group">
                <label>Öğrenci Telefonu</label>
                <input required type="text" name="ogr_tel" value="<?php echo $ogrenci_detay['ogr_tel']; ?>" class="form-control">
              </div>
            </div>
            <div class="form-row">
              <div class="col-md-6 form-group">
                <label>Kan Grubu</label>
                <input required type="text" name="ogr_kan_grubu" value="<?php echo $ogrenci_detay['ogr_kan_grubu']; ?>" class="form-control">
              </div>
              <div class="col-md-6 form-group">
                <label>Adres</label>
                <input required type="text" name="ogr_adres" value="<?php echo $ogrenci_detay['ogr_adres']; ?>" class="form-control">
              </div>
            </div>
            <div class="form-row">
              <div class="col-md-6 form-group">
                <label>Okul</label>
                <input required type="text" name="ogr_okul" value="<?php echo $ogrenci_detay['ogr_okul']; ?>" class="form-control">
              </div>
              <div class="col-md-6 form-group">
                <label>Kayıt Tarihi</label>
                <input required type="text" name="ogr_kayit_tar" value="<?php echo $ogrenci_detay['ogr_kayit_tar']; ?>" class="form-control">
              </div>
            </div>
            <div class="form-row">
              <div class="col-md-6 form-group">
                <label>Doğum Tarihi</label>
                <input required type="text" name="ogr_dogum_tar" value="<?php echo $ogrenci_detay['ogr_dogum_tar']; ?>" class="form-control">
              </div>
              <div class="col-md-6 form-group">
                <label>Ücret</label>
                <input required type="text" name="ogr_ucret" value="<?php echo $ogrenci_detay['ogr_ucret']; ?>" class="form-control">
              </div>
            </div>
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



<?php


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
       
        // Öğrenci ve veli bilgilerini güncelle
        $ogr_ad = $_POST['ogr_ad'];
        $ogr_soyad = $_POST['ogr_soyad'];
        $ogr_tc = $_POST['ogr_tc'];
        $veli_id = $_POST['veli_id'];
        $sinif = $_POST['sinif'];
        $veli_ad = $_POST['veli_ad'];
        $veli_soyad = $_POST['veli_soyad'];
        $veli_mail = $_POST['veli_mail'];
        $veli_tel = $_POST['veli_tel'];
        $veli_tc = $_POST['veli_tc'];
        $veli_meslek = $_POST['veli_meslek'];
        $ogr_mail = $_POST['ogr_mail'];
        $ogr_tel = $_POST['ogr_tel'];
        $ogr_kan_grubu = $_POST['ogr_kan_grubu'];
        $ogr_adres = $_POST['ogr_adres'];
        $ogr_okul = $_POST['ogr_okul'];
        $ogr_kayit_tar = $_POST['ogr_kayit_tar'];
        $ogr_dogum_tar = $_POST['ogr_dogum_tar'];
        $ogr_ucret = $_POST['ogr_ucret'];


         
                 // Görsel dosyası kaydedeceği yolu
            $target_dir = "../obs/l/ogrenciimg/";

        // Görsel dosyasını yükle
        $gorsel_isim =  date("dmYHis") . ".png"; // Tarih ve saat bilgisini dosya adına ekle
        $target_file = $target_dir . $gorsel_isim;
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Görseli kontrol et
        if (isset($_POST["submit"])) {
            $check = getimagesize($_FILES["gorsel"]["tmp_name"]);

            if ($check !== false) {
                echo "Dosya bir resim - " . $check["mime"] . ".";
                $uploadOk = 1;
            } else {
                echo "Dosya bir resim değil.";
                $uploadOk = 0;
            }
        }

       
        try {
            // Öğrenci tablosunu güncelle
            $sorgu_ogrenci_update = $db->prepare("UPDATE ogrenci SET ogr_ad = ?, ogr_soyad = ?, ogr_tc = ?, veli_id = ? WHERE ogr_id = ?");
            $sorgu_ogrenci_update->execute([$ogr_ad, $ogr_soyad, $ogr_tc, $veli_id, $ogr_id]);

            // Veli tablosunu güncelle
            $sorgu_veli_update = $db->prepare("UPDATE veli SET veli_ad = ?, veli_soyad = ?, veli_mail = ?, veli_tel = ?, veli_tc = ?, veli_meslek = ? WHERE veli_id = ?");
            $sorgu_veli_update->execute([$veli_ad, $veli_soyad, $veli_mail, $veli_tel, $veli_tc, $veli_meslek, $veli_id]);

            // Öğrenci detay tablosunu güncelle
            $sorgu_detay_update = $db->prepare("UPDATE ogrenci_detay SET ogr_mail = ?, ogr_tel = ?, ogr_kan_grubu = ?, ogr_adres = ?, ogr_okul = ?, ogr_kayit_tar = ?, ogr_dogum_tar = ?, ogr_ucret = ?,  sinif = ? WHERE ogr_id = ?");
            $sorgu_detay_update->execute([$ogr_mail, $ogr_tel, $ogr_kan_grubu, $ogr_adres, $ogr_okul, $ogr_kayit_tar, $ogr_dogum_tar, $ogr_ucret, $sinif, $ogr_id]);

            echo "Öğrenci ve veli bilgileri başarıyla güncellendi.";

        } catch(PDOException $e) {
            //echo "Hata: " . $e->getMessage();
        }

        if($uploadOk  == 1) {
    if (move_uploaded_file($_FILES["gorsel"]["tmp_name"], $target_file)) {
        echo "Dosya " . htmlspecialchars(basename($_FILES["gorsel"]["name"])) . " başarıyla yüklendi.";

        try {

          
          

            // Veritabanına kaydetme veya güncelleme işlemi
            $ogrenci_gorsel = $db->prepare("SELECT * FROM gorseller WHERE ogr_id = ?");
            $ogrenci_gorsel->execute([$ogr_id]);
            $row_count = $ogrenci_gorsel->rowCount();

            if ($row_count > 0) {
                // Eşleşen ogr_id varsa, güncelle
                $ogrenci_gorsel_update = $db->prepare("UPDATE gorseller SET gorsel = ? WHERE ogr_id = ?");
                $ogrenci_gorsel_update->execute([$gorsel_isim, $ogr_id]);
            } else {
                // Eşleşen ogr_id yoksa, ekle
                $ogrenci_gorsel_insert = $db->prepare("INSERT INTO gorseller (ogr_id, gorsel) VALUES (?, ?)");
                $ogrenci_gorsel_insert->execute([$ogr_id, $gorsel_isim]);
            }

           

            echo "Öğrenci ve veli bilgileri başarıyla güncellendi.";
           
        } catch(PDOException $e) {
             echo "Hata: " . $e->getMessage();
        }
    }}}

 else {
    echo "Güncellenemedi";
}





/* orjinal yedek


    if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
       
        // Öğrenci ve veli bilgilerini güncelle
        $ogr_ad = $_POST['ogr_ad'];
        $ogr_soyad = $_POST['ogr_soyad'];
        $ogr_tc = $_POST['ogr_tc'];
        $veli_id = $_POST['veli_id'];
        $sinif = $_POST['sinif'];
        $veli_ad = $_POST['veli_ad'];
        $veli_soyad = $_POST['veli_soyad'];
        $veli_mail = $_POST['veli_mail'];
        $veli_tel = $_POST['veli_tel'];
        $veli_tc = $_POST['veli_tc'];
        $veli_meslek = $_POST['veli_meslek'];
        $ogr_mail = $_POST['ogr_mail'];
        $ogr_tel = $_POST['ogr_tel'];
        $ogr_kan_grubu = $_POST['ogr_kan_grubu'];
        $ogr_adres = $_POST['ogr_adres'];
        $ogr_okul = $_POST['ogr_okul'];
        $ogr_kayit_tar = $_POST['ogr_kayit_tar'];
        $ogr_dogum_tar = $_POST['ogr_dogum_tar'];
        $ogr_ucret = $_POST['ogr_ucret'];


         
                 // Görsel dosyası kaydedeceği yolu
            $target_dir = "../obs/l/ogrenciimg/";

        // Görsel dosyasını yükle
        $gorsel_isim =  date("dmYHis") . ".png"; // Tarih ve saat bilgisini dosya adına ekle
        $target_file = $target_dir . $gorsel_isim;
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Görseli kontrol et
        if (isset($_POST["submit"])) {
            $check = getimagesize($_FILES["gorsel"]["tmp_name"]);

            if ($check !== false) {
                echo "Dosya bir resim - " . $check["mime"] . ".";
                $uploadOk = 1;
            } else {
                echo "Dosya bir resim değil.";
                $uploadOk = 0;
            }
        }

       
        try {
            // Öğrenci tablosunu güncelle
            $sorgu_ogrenci_update = $db->prepare("UPDATE ogrenci SET ogr_ad = ?, ogr_soyad = ?, ogr_tc = ?, veli_id = ? WHERE ogr_id = ?");
            $sorgu_ogrenci_update->execute([$ogr_ad, $ogr_soyad, $ogr_tc, $veli_id, $ogr_id]);

            // Veli tablosunu güncelle
            $sorgu_veli_update = $db->prepare("UPDATE veli SET veli_ad = ?, veli_soyad = ?, veli_mail = ?, veli_tel = ?, veli_tc = ?, veli_meslek = ? WHERE veli_id = ?");
            $sorgu_veli_update->execute([$veli_ad, $veli_soyad, $veli_mail, $veli_tel, $veli_tc, $veli_meslek, $veli_id]);

            // Öğrenci detay tablosunu güncelle
            $sorgu_detay_update = $db->prepare("UPDATE ogrenci_detay SET ogr_mail = ?, ogr_tel = ?, ogr_kan_grubu = ?, ogr_adres = ?, ogr_okul = ?, ogr_kayit_tar = ?, ogr_dogum_tar = ?, ogr_ucret = ?,  sinif = ? WHERE ogr_id = ?");
            $sorgu_detay_update->execute([$ogr_mail, $ogr_tel, $ogr_kan_grubu, $ogr_adres, $ogr_okul, $ogr_kayit_tar, $ogr_dogum_tar, $ogr_ucret, $sinif, $ogr_id]);

            echo "Öğrenci ve veli bilgileri başarıyla güncellendi.";

        } catch(PDOException $e) {
            //echo "Hata: " . $e->getMessage();
        }

        if($uploadOk  == 1) {
    if (move_uploaded_file($_FILES["gorsel"]["tmp_name"], $target_file)) {
        echo "Dosya " . htmlspecialchars(basename($_FILES["gorsel"]["name"])) . " başarıyla yüklendi.";

        try {

          
          

            // Veritabanına kaydetme veya güncelleme işlemi
            $ogrenci_gorsel = $db->prepare("SELECT * FROM gorseller WHERE ogr_id = ?");
            $ogrenci_gorsel->execute([$ogr_id]);
            $row_count = $ogrenci_gorsel->rowCount();

            if ($row_count > 0) {
                // Eşleşen ogr_id varsa, güncelle
                $ogrenci_gorsel_update = $db->prepare("UPDATE gorseller SET gorsel = ? WHERE ogr_id = ?");
                $ogrenci_gorsel_update->execute([$gorsel_isim, $ogr_id]);
            } else {
                // Eşleşen ogr_id yoksa, ekle
                $ogrenci_gorsel_insert = $db->prepare("INSERT INTO gorseller (ogr_id, gorsel) VALUES (?, ?)");
                $ogrenci_gorsel_insert->execute([$ogr_id, $gorsel_isim]);
            }

           

            echo "Öğrenci ve veli bilgileri başarıyla güncellendi.";
           
        } catch(PDOException $e) {
             echo "Hata: " . $e->getMessage();
        }
    }}}

 else {
    echo "Güncellenemedi";
}


*/


/*
  sill 

      
else {
    if (move_uploaded_file($_FILES["gorsel"]["tmp_name"], $target_file)) {
        echo "Dosya " . htmlspecialchars(basename($_FILES["gorsel"]["name"])) . " başarıyla yüklendi.";

        try {

          
            // Öğrenci tablosunu güncelle
            $sorgu_ogrenci_update = $db->prepare("UPDATE ogrenci SET ogr_ad = ?, ogr_soyad = ?, ogr_tc = ?, veli_id = ? WHERE ogr_id = ?");
            $sorgu_ogrenci_update->execute([$ogr_ad, $ogr_soyad, $ogr_tc, $veli_id, $ogr_id]);

            // Veli tablosunu güncelle
            $sorgu_veli_update = $db->prepare("UPDATE veli SET veli_ad = ?, veli_soyad = ?, veli_mail = ?, veli_tel = ?, veli_tc = ?, veli_meslek = ? WHERE veli_id = ?");
            $sorgu_veli_update->execute([$veli_ad, $veli_soyad, $veli_mail, $veli_tel, $veli_tc, $veli_meslek, $veli_id]);

            // Öğrenci detay tablosunu güncelle
            $sorgu_detay_update = $db->prepare("UPDATE ogrenci_detay SET ogr_mail = ?, ogr_tel = ?, ogr_kan_grubu = ?, ogr_adres = ?, ogr_okul = ?, ogr_kayit_tar = ?, ogr_dogum_tar = ?, ogr_ucret = ?,  sinif = ? WHERE ogr_id = ?");
            $sorgu_detay_update->execute([$ogr_mail, $ogr_tel, $ogr_kan_grubu, $ogr_adres, $ogr_okul, $ogr_kayit_tar, $ogr_dogum_tar, $ogr_ucret, $sinif, $ogr_id]);


            // Veritabanına kaydetme veya güncelleme işlemi
            $ogrenci_gorsel = $db->prepare("SELECT * FROM gorseller WHERE ogr_id = ?");
            $ogrenci_gorsel->execute([$ogr_id]);
            $row_count = $ogrenci_gorsel->rowCount();

            if ($row_count > 0) {
                // Eşleşen ogr_id varsa, güncelle
                $ogrenci_gorsel_update = $db->prepare("UPDATE gorseller SET gorsel = ? WHERE ogr_id = ?");
                $ogrenci_gorsel_update->execute([$target_file, $ogr_id]);
            } else {
                // Eşleşen ogr_id yoksa, ekle
                $ogrenci_gorsel_insert = $db->prepare("INSERT INTO gorseller (ogr_id, gorsel) VALUES (?, ?)");
                $ogrenci_gorsel_insert->execute([$ogr_id, $target_file]);
            }

           

            echo "Öğrenci ve veli bilgileri başarıyla güncellendi.";
           
        } catch(PDOException $e) {
             echo "Hata: " . $e->getMessage();
        }
    } else {
        echo "Dosya yüklenirken bir hata oluştu.". $e->getMessage();
    }
}

}


*/
?>


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
