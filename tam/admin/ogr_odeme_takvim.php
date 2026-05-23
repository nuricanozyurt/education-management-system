<style>
   .kart {
        background-color: white; /* Kart rengi */
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Gölge efekti */
        transition: transform 0.3s ease; /* Hareket efekti */
        margin: 10px;
        padding: 20px;
    }

    .kart:hover {
        transform: scale(1.05); /* Üzerine gelince hafif büyüme */
    }
</style>

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

require_once 'header.php'; 

   








// ogr_odeme_takvim.php dosyasında

// Öğrenci ID'sini GET ile al
$ogr_id = $_GET['ogr_id'];
$ogr_ad = $_GET['skjdldsfk984HDMSFNKL8045325KJNDSGFLKMDFKLSDKMSDFSDF935203adfsdkjf34235ncksdfkknnadasfnddfsdfsdfnsdflsdfjsodfsodfsdlfsdf'];

// Veritabanına bağlan
include("../connect.php");

// Öğrenciye ait ödeme bilgilerini çek
$query = "SELECT * FROM odeme_tarih WHERE ogr_id = ?";
$statement = $db->prepare($query);
$statement->execute([$ogr_id]);
$odeme_bilgileri = $statement->fetchAll(PDO::FETCH_ASSOC);

// HTML çıktısını oluşturuyorum
echo "<center><h1>".$ogr_ad." Ödeme Takvimi</h1></center><br>";
echo "<div class='odeme-kutusu'>";

foreach ($odeme_bilgileri as $odeme) {
    echo "<div class='kart'>";
    echo "<p>Ödenen Tarih: " . $odeme['tarih'] . "</p>";
    echo "<p>Ödenen Ücret: " . $odeme['odenen_ucret'] . "</p>";
    echo "</div>";
}

echo "</div>";





?>





















          <?php include 'footer.php'; ?>
