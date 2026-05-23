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
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <h1 class="text-center text-primary">Öğrenci Ekle</h1>
        </div>
        <div class="card-body">
          <form action="../process.php" method="post" accept-charset="utf-8" enctype="multipart/form-data">
            <div class="form-row">
              <div class="col-md-12 form-group">
              <label>Veli Seçiniz</label>
                <select required name="veli_id" class="form-control">
                  <?php 

                   include("../connect.php");
                  // Velileri seçmek için PDO kullanarak sorgu hazırlama
                  $veli_sorgu = "SELECT * FROM veli";
                  $stmt = $db->query($veli_sorgu);
                  // Her bir veliyi seçenek olarak ekleyin
                  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                    <option value="<?php echo $row['veli_id']; ?>"><?php echo $row['veli_ad'] . ' ' . $row['veli_soyad']; ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
            <div class="form-row">
              <div class="col-md-12 form-group">
                <label>Öğrenci TCNO</label>
                <input required type="text" name="ogr_tc" value="" class="form-control">
              </div>
            </div>
            <div class="form-row">
              <div class="col-md-12 form-group">
                <label>Öğrenci Adı</label>
                <input required type="text" name="ogr_ad" value="" class="form-control">
              </div>
            </div>
            <div class="form-row">
              <div class="col-md-12 form-group">
                <label>Öğrenci Mail</label>
                <input required type="text" name="ogr_mail" value="" class="form-control">
              </div>
            </div>
            <div class="form-row">
              <div class="col-md-12 form-group">
                <label> Öğrenci Telefonu</label>
                <input required type="text" name="ogr_tel" value="" class="form-control">
              </div>
            </div>
            <div class="form-row">
  <div class="col-md-12 form-group">
    <label>Kan Grubu</label>
    <select required name="kan_id" class="form-control">
  <?php 
  // Kan gruplarını seçmek için PDO kullanarak sorgu hazırlama
  $kan_grup_sorgu = "SELECT * FROM kan";
  $stmt = $db->query($kan_grup_sorgu);
  // Her bir kan grubunu seçenek olarak ekleyin
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
    <option value="<?php echo $row['kan_id']; ?>"><?php echo $row['kan_grup']; ?></option>
  <?php } ?>
</select>

  </div>
</div>

            <div class="form-row">
              <div class="col-md-12 form-group">
                <label> Adres</label>
                <input required type="text" name="ogr_adres" value="" class="form-control">
              </div>
            </div>
            <div class="form-row">
              <div class="col-md-12 form-group">
                <label> Okul</label>
                <select required name="okul_id" class="form-control">
                
    <?php 
    // Okulları seçmek için PDO kullanarak sorgu hazırlama
    $okul_sorgu = "SELECT * FROM okullar";
    $stmt = $db->query($okul_sorgu);
    // Her bir okulu seçenek olarak ekleyin
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
        <option value="<?php echo $row['okul_id']; ?>"><?php echo $row['okul_ad']; ?></option>
    <?php } ?>
</select>

              </div>
            </div>
            <div class="form-row">
              <div class="col-md-12 form-group">
                <label>Kayıt Tarihi</label>
                <input required type="date" name="ogr_kayit_tar" value="<?php echo date('Y-m-d'); ?>" class="form-control">
              </div>
            </div>
            <div class="form-row">
              <div class="col-md-12 form-group">
                <label>Doğum Tarihi</label>
                <input required type="date" name="ogr_dogum_tar" value="" class="form-control">
              </div>
            </div>
            <div class="form-row">
              <div class="col-md-12 form-group">
                <label> Ücret</label>
                <input required type="text" name="ogr_ucret" value="" class="form-control">
              </div>
            </div>
            <div class="form-row">
              <div class="col-md-12 form-group mt-3"></div>
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


<?php include 'footer.php'; ?>
<script src="ckeditor/ckeditor.js"></script>
<script>
  CKEDITOR.replace('editor');
</script>
