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
          <h1 class="text-center text-primary">Veli Ekle</h1>
        </div>
        <div class="card-body">
          <form action="../velip.php" method="post" accept-charset="utf-8" enctype="multipart/form-data">
            <div class="form-row">
              <div class="col-md-12 form-group">
                <label>Veli Adı</label>
                <input required type="text" name="veli_ad" value="" class="form-control">
              </div>

            </div>
            <div class="form-row">
              <div class="col-md-12 form-group">
                <label>Veli Soyadı</label>
                <input required type="text" name="veli_soyad" value="" class="form-control">
              </div>
            </div>
            <div class="form-row">
              <div class="col-md-12 form-group">
                <label>Veli Mail</label>
                <input required type="text" name="veli_mail" value="" class="form-control">
              </div>
            </div>
      

            <div class="form-row">
              <div class="col-md-12 form-group">
                <label>Veli Telefonu</label>
                <input required type="text" name="veli_tel" value="" class="form-control">
              </div>
            </div>
            <div class="form-row">
              <div class="col-md-12 form-group">
                <label>Veli TCNO</label>
                <input required type="text" name="veli_tc" value="" class="form-control">
              </div>
            </div>
            <div class="form-row">
              <div class="col-md-12 form-group">
                <label>Veli Meslek</label>
                <input required type="text" name="veli_meslek" value="" class="form-control">
              </div>
            </div>
            

            <div class="form-row">
              <div class="col-md-12 form-group mt-3">
                
              </div>
            </div>
            <div class="text-center mt-4">
              <button type="submit" name="add_veli_btn" class="btn btn-primary col-md-6">Ekle</button>
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
