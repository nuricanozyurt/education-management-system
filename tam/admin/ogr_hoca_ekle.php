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
 
/* form verilerini işleme kısmı */
try {
   
    if(isset($_POST['add_recipe_btn'])) {
        $hoca_tc = $_POST['hoca_tc'];
        $hoca_ad = $_POST['hoca_ad'];
        $hoca_soyad = $_POST['hoca_soyad'];
        $hoca_alani = $_POST['hoca_alani'];
        $hoca_sinifi = $_POST['hoca_sinifi'];
        $iletisim = $_POST['iletisim'];

        // hoca_tc daha önce eklenmiş mi kontrol et
        $query = "SELECT * FROM hocalar WHERE hoca_tc = :hoca_tc";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':hoca_tc', $hoca_tc);
        $stmt->execute();

        if($stmt->rowCount() > 0) {
            // hoca_tc daha önce eklenmiş, güncelle
            $update_query = "UPDATE hocalar SET hoca_ad = :hoca_ad, hoca_soyad = :hoca_soyad, hoca_alani = :hoca_alani, hoca_sinifi = :hoca_sinifi, iletisim = :iletisim WHERE hoca_tc = :hoca_tc";
            $update_stmt = $db->prepare($update_query);
            $update_stmt->bindParam(':hoca_ad', $hoca_ad);
            $update_stmt->bindParam(':hoca_soyad', $hoca_soyad);
            $update_stmt->bindParam(':hoca_alani', $hoca_alani);
            $update_stmt->bindParam(':hoca_sinifi', $hoca_sinifi);
            $update_stmt->bindParam(':iletisim', $iletisim);
            $update_stmt->bindParam(':hoca_tc', $hoca_tc);
            $update_stmt->execute();

            echo "Hoca bilgileri güncellendi.";
        } else {
            // hoca_tc daha önce eklenmemiş, yeni kayıt ekle
            $insert_query = "INSERT INTO hocalar (hoca_ad, hoca_soyad, hoca_tc, hoca_alani, hoca_sinifi, iletisim) VALUES (:hoca_ad, :hoca_soyad, :hoca_tc, :hoca_alani, :hoca_sinifi, :iletisim)";
            $insert_stmt = $db->prepare($insert_query);
            $insert_stmt->bindParam(':hoca_ad', $hoca_ad);
            $insert_stmt->bindParam(':hoca_soyad', $hoca_soyad);
            $insert_stmt->bindParam(':hoca_tc', $hoca_tc);
            $insert_stmt->bindParam(':hoca_alani', $hoca_alani);
            $insert_stmt->bindParam(':hoca_sinifi', $hoca_sinifi);
            $insert_stmt->bindParam(':iletisim', $iletisim);
            $insert_stmt->execute();

            echo "Yeni hoca kaydedildi.";
        }
    }
} catch(PDOException $e) {
    echo "Hata: " . $e->getMessage();
}



if(isset($_GET['KKLEsdfsdg9852358kJKBDSJFKNSAD379jjbsfsdfmösdf9325235jkdfkjs3HSFSDGN93434923JKSKSFGKSF849584282jsfdbfsdfjdkjoerhk769nsgjsngkjsn3534539045kjnfdsdgnnsdf329845245948snfdksjdn'])){

 $hoca_tc = $_GET['KKLEsdfsdg9852358kJKBDSJFKNSAD379jjbsfsdfmösdf9325235jkdfkjs3HSFSDGN93434923JKSKSFGKSF849584282jsfdbfsdfjdkjoerhk769nsgjsngkjsn3534539045kjnfdsdgnnsdf329845245948snfdksjdn'];
 $hoca_ad = $_GET['ad'];
 $hoca_soyad = $_GET['soyad'];
 $hoca_alani = $_GET['alan'];
 $hoca_sinifi = $_GET['sinif'];
 $iletisim = $_GET['iletisim'];

?>


<div class="container">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <h1 class="text-center text-primary">Düzenle</h1>
        </div>
        <div class="card-body">
          <form action="#" method="post" accept-charset="utf-8" enctype="multipart/form-data">
            <div class="form-row">
              <div class="col-md-12 form-group">
              <label>Alan Seçiniz</label>
                <select required name="hoca_alani" class="form-control">
                  <?php 

                          

                  // Velileri seçmek için PDO kullanarak sorgu hazırlama
                  $dersler = "SELECT * FROM siniflar";
                  $stmt = $db->query($dersler);
                  // Her bir veliyi seçenek olarak ekleyin
                  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                    <option value="<?php echo $row['sinif']; ?>"><?php echo $row['sinif']?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
            <div class="form-row">
              <div class="col-md-12 form-group">
                <label>Hoca İsmi</label>
                <input required type="text" name="hoca_ad" value="<?php echo $hoca_ad  ?>" class="form-control">
              </div>
            </div>
            <div class="form-row">
              <div class="col-md-12 form-group">
                <label>Hoca Soyadı</label>
                <input required type="text" name="hoca_soyad" value="<?php echo $hoca_soyad  ?>" class="form-control">
              </div>
            </div>
            <div class="form-row">
              <div class="col-md-12 form-group">
                <label>Hoca TC</label>
                <input required type="text" name="hoca_tc" value="<?php echo $hoca_tc  ?>" class="form-control">
              </div>
            </div>
            <div class="form-row">
              <div class="col-md-12 form-group">
                <label> İletişim (Telefon)</label>
                <input required type="text" name="iletisim" value="<?php echo $iletisim  ?>" class="form-control">
              </div>
            </div>    
            <div class="form-row">
  <div class="col-md-12 form-group">
    <label>Hoca Sınıf</label>
    <select required name="hoca_sinifi" class="form-control">
  <?php 
  // Kan gruplarını seçmek için PDO kullanarak sorgu hazırlama
  $dersliksinif = "SELECT * FROM dersliksinif";
  $stmt = $db->query($dersliksinif);
  // Her bir kan grubunu seçenek olarak ekleyin
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
    <option value="<?php echo $row['dersliksinif']; ?>"><?php echo $row['dersliksinif']; ?></option>
  <?php } ?>
</select>

  </div>
</div>

        
           
          
            <div class="text-center mt-4">
              <button type="submit" name="add_recipe_btn" class="btn btn-primary col-md-6">Güncelle</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>


<?php 
}

// eğer veri geldise işte doldurulmamış hali gözükecek boşuna yeni sayfa yapmak istemedim  

else{

?>



<div class="container">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <h1 class="text-center text-primary">Hoca Ekle</h1>
        </div>
        <div class="card-body">
          <form action="#" method="post" accept-charset="utf-8" enctype="multipart/form-data">
            <div class="form-row">
              <div class="col-md-12 form-group">
              <label>Alan Seçiniz</label>
                <select required name="hoca_alani" class="form-control">
                  <?php 

                          

                  // Velileri seçmek için PDO kullanarak sorgu hazırlama
                  $dersler = "SELECT * FROM siniflar";
                  $stmt = $db->query($dersler);
                  // Her bir veliyi seçenek olarak ekleyin
                  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                    <option value="<?php echo $row['sinif']; ?>"><?php echo $row['sinif']?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
            <div class="form-row">
              <div class="col-md-12 form-group">
                <label>Hoca İsmi</label>
                <input required type="text" name="hoca_ad" value="" class="form-control">
              </div>
            </div>
            <div class="form-row">
              <div class="col-md-12 form-group">
                <label>Hoca Soyadı</label>
                <input required type="text" name="hoca_soyad" value="" class="form-control">
              </div>
            </div>
            <div class="form-row">
              <div class="col-md-12 form-group">
                <label>Hoca TC</label>
                <input required type="text" name="hoca_tc" value="" class="form-control">
              </div>
            </div>
            <div class="form-row">
              <div class="col-md-12 form-group">
                <label> İletişim (Telefon)</label>
                <input required type="text" name="iletisim" value="" class="form-control">
              </div>
            </div>    
            <div class="form-row">
  <div class="col-md-12 form-group">
    <label>Hoca Sınıf</label>
    <select required name="hoca_sinifi" class="form-control">
  <?php 
  // Kan gruplarını seçmek için PDO kullanarak sorgu hazırlama
  $dersliksinif = "SELECT * FROM dersliksinif";
  $stmt = $db->query($dersliksinif);
  // Her bir kan grubunu seçenek olarak ekleyin
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
    <option value="<?php echo $row['dersliksinif']; ?>"><?php echo $row['dersliksinif']; ?></option>
  <?php } ?>
</select>

  </div>
</div>

        
           
          
            <div class="text-center mt-4">
              <button type="submit" name="add_recipe_btn" class="btn btn-primary col-md-6">Ekle</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>









<?php 

} // else sonu
?>


<?php include 'footer.php'; ?>
<script src="ckeditor/ckeditor.js"></script>
<script>
  CKEDITOR.replace('editor');
</script>
