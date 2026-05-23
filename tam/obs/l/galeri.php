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
     



		<!-- Sidebar chat end-->
		<div class="content-wrapper">
			<!-- Container-fluid starts -->
			<div class="container-fluid">
				<!-- Main content starts -->
				<div class="light-box">
					<!-- Row Starts -->
					<div class="row">
						<div class="col-sm-12 p-0">
							<div class="main-header">
								<h4>Ders Notları</h4>
								<ol class="breadcrumb breadcrumb-title breadcrumb-arrow">
									<li class="breadcrumb-item"><a href="index.php"><i class="icofont icofont-home"></i></a>
									</li>
									<li class="breadcrumb-item"><a href="#!"> YKS Notları</a>
									</li>
									<li class="breadcrumb-item"><a href="#">Videoları</a>
									</li>
								</ol>
							</div>
						</div>
					</div>
					<!-- Row end -->

					<!-- Row start -->
					<div class="row">

					

					</div>
					<!-- Row end -->

					<!-- Row start -->
					<div class="row">

						<!-- pdf başlangıç -->
						<div class="col-md-12">
							<div class="card">
								<div class="card-header">
									<h5 class="card-header-text">İndirilebilir Ders PDF'i</h5>
									<p>İstediğin dersin üstüne tıkla inceleye veya indir.</p>
								</div>
								<div class="card-block">
									<div class="row">
										<div class="col-xl-2 col-lg-3 col-sm-3 col-xs-12">
											<a href="pdf/tytaytbiyoloji.pdf">
												<img src="pdf/biyoloji.jpg" class="img-fluid" alt="">
											</a>
										</div>
										<div class="col-xl-2 col-lg-3 col-sm-3 col-xs-12">
											<a href="pdf/tytcografya.pdf">
												<img src="pdf/cografya.jpg" class="img-fluid" alt="">
											</a>
										</div>
										<div class="col-xl-2 col-lg-3 col-sm-3 col-xs-12">
											<a href="pdf/Matematik.pdf" >
												<img src="pdf/matematik.png" class="img-fluid" alt="">
											</a>
										</div>
										<div class="col-xl-2 col-lg-3 col-sm-3 col-xs-12">
											<a href="pdf/tytfizik.pdf" >
												<img src="pdf/fizik.jpg" class="img-fluid" alt="">
											</a>
										</div>

									</div>
								</div>
							</div>
						</div>
						<!-- Pdf son -->

					</div>
					<!-- Row end -->

					<!-- Row start -->
					<div class="row">

						<!-- Video Dersi başlangıç -->
						<div class="col-md-12">
							<div class="card">
								<div class="card-header">
									<h5 class="card-header-text">Video Galerisi</h5>
									<p>İstediğin dersin videosunu izlemek için lütfen tıkla.</p>
								</div>
								<div class="card-block">
									<div class="row">
										<div class="col-xl-2 col-lg-3 col-sm-3 col-xs-12">
											<a href="https://youtu.be/UbekBXydexw?list=PL5kIOunpmSBPcuGdkcdR3aTmfBckUWBna" data-toggle="lightbox" data-gallery="youtubevideos">
												<img src="pdf/videokimya.jpg" class="img-fluid" alt="">
											</a>
										</div>
										<div class="col-xl-2 col-lg-3 col-sm-3 col-xs-12">
											<a href="https://youtu.be/7y-RUAJDQjs" data-toggle="lightbox" data-gallery="youtubevideos">
												<img src="pdf/videomatematik.jpg" class="img-fluid" alt="">
											</a>
										</div>
										<div class="col-xl-2 col-lg-3 col-sm-3 col-xs-12">
											<a href="https://youtu.be/7y-RUAJDQjs" data-toggle="lightbox" data-gallery="youtubevideos">
												<img src="pdf/videoturkce.jpg" class="img-fluid" alt="">
											</a>
										</div>

									</div>
								</div>
							</div>
						</div>
						<!-- Video son-->

					</div>
					<!-- Row end -->

				
					


				</div>
			</div>
			<!-- Container-fluid ends -->
		</div>
	</div>


  
<?php include 'include/alt.php'; ?>
