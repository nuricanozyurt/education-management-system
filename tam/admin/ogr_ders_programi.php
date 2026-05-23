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




 include 'header.php';
 
?>


<!-- bu alt form verilerini işlemek için -->


<?php

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['ogr_excel'])) {
    $dersId = $_POST['ders_bilgisi']; // Seçilen ders değerini al
    $fileName = $_FILES['ogr_excel']['name']; // Yüklenen dosyanın orijinal adı
    $fileTmpName = $_FILES['ogr_excel']['tmp_name']; // Geçici dosya adı
    $fileType = $_FILES['ogr_excel']['type']; // Dosya tipi

    // Uygun dosya türünü kontrol et
    if ($fileType == "application/vnd.ms-excel" || $fileType == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet") {
        // Dosya adını yeniden oluştur
        $newFileName = $dersId . ".xls";

        // Dosyayı belirlenen yere taşı
        $uploadDirectory = "../obs/l/ders_programi/";
        $uploadPath = $uploadDirectory . $newFileName;

        // Ders id'sini kontrol et
        $stmt = $db->prepare("SELECT * FROM ders_programi WHERE ders = ?");
        $stmt->execute([$dersId]);
        $existingFile = $stmt->fetch();

        if ($existingFile) {
            // Ders zaten varsa, dosyayı güncelle
            if (move_uploaded_file($fileTmpName, $uploadPath)) {
                // Dosyayı güncelle
                $stmt = $db->prepare("UPDATE ders_programi SET ders_programi = ? WHERE ders = ?");
                $stmt->execute([$newFileName, $dersId]);

                echo "Dosya başarıyla güncellendi.";
            } else {
                echo "Dosya yüklenemedi.";
            }
        } else {
            // Ders yoksa, yeni kayıt ekle
            if (move_uploaded_file($fileTmpName, $uploadPath)) {
                // Veritabanına kaydet
                $stmt = $db->prepare("INSERT INTO ders_programi (ders, ders_programi) VALUES (?, ?)");
                $stmt->execute([$dersId, $newFileName]);

                echo "Dosya başarıyla yüklendi ve veritabanına kaydedildi.";
            } else {
                echo "Dosya yüklenemedi.";
            }
        }
    } else {
        echo "Yalnızca Excel dosyaları yüklenebilir.";
    }
}

?>

<div class="container">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <h1 class="text-center text-primary">Ders Programı Ekle</h1>
        </div>
        <div class="card-body">
		     <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
		  <div class="form-row">
		    <div class="col-md-12 form-group">
		      <label>SINIF SEÇİNİZ</label>
		      <select required name="ders_bilgisi" class="form-control">
		        <?php
		          include("../connect.php");
		          // Velileri seçmek için PDO kullanarak sorgu hazırlama
		          $sinif_sorgu = "SELECT * FROM dersliksinif";
		          $stmt = $db->query($sinif_sorgu);
		          // Her bir sinifi seçenek olarak ekleyin
		          while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
		            <option value="<?php echo $row['dersliksinif']; ?>"><?php echo $row['dersliksinif']; ?></option>
		        <?php } ?>
		      </select>
		    </div>
		  </div>
		  <div class="form-row">
		    <div class="col-md-12 form-group">
		      <label>Lütfen Excel Dosyasını Yükle</label>
		      <input required type="file" name="ogr_excel" accept=".xls,.xlsx" class="form-control">
		    </div>
		  </div>
		  <div class="form-row">
		    <div class="col-md-12 form-group">
		      <button type="submit" name="submit" class="btn btn-primary">Gönder</button>
		    </div>
		  </div>
		</form>

        </div>
      </div>
    </div>
  </div>
</div>


<?php include 'footer.php'; ?>
<script src="ckeditor/ckeditor.js"></script>
<script>
  CKEDITOR.replace('editor');
</script>
