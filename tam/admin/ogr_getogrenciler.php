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




include("../connect.php");

// Okul adını al
$okul = $_GET['okul'];

$counter = 0; // Sıra numarası için sayaç

try {
    // Öğrenci bilgilerini sorgula
    $sorgu = $db->prepare("SELECT ogrenci.ogr_id, ogrenci.ogr_ad, ogrenci.ogr_soyad, ogrenci.ogr_tc FROM ogrenci INNER JOIN ogrenci_detay ON ogrenci.ogr_id = ogrenci_detay.ogr_id WHERE ogrenci_detay.ogr_okul = ?");
    $sorgu->execute([$okul]);
    $ogrenciler = $sorgu->fetchAll(PDO::FETCH_ASSOC);

    // Sonuçları listele
    if ($ogrenciler) {
        foreach ($ogrenciler as $ogrenci) {
            $counter++; // Sayaçı arttır
            echo "<tr class='ara'>";

            echo "<td>" . $counter .  "</td>";

            
            echo "<td class='ara2'>".$ogrenci['ogr_ad']." ".$ogrenci['ogr_soyad']." <br> ".$ogrenci['ogr_tc']."</td>";

            // İlgili veli bilgilerini sorgula
            $veli_id = $ogrenci['ogr_id'];
            $veli_sorgu = $db->prepare("SELECT ogr_okul, ogr_adres FROM ogrenci_detay WHERE ogr_id = ?");
            
            $veli_sorgu->execute([$veli_id]);
            $veli = $veli_sorgu->fetch(PDO::FETCH_ASSOC);

            // Eğer veli bulunduysa, bilgileri listele
            if ($veli) {
                echo "<td class='ara2'>".$veli['ogr_adres']." - <br> ".$veli['ogr_okul']."</td>";
            } else {
                echo "<td colspan='6'>Okul ve Adres bilgisi bulunamadı.</td>";
            }

            // Sınıfların listelenmesi
            for ($i = 1; $i <= 1; $i++) {
                echo "<td><a href='ogr_dersekle.php?i=" . $ogrenci['ogr_id'] . "'><select class='edit-button' name='selectedClasses[".$ogrenci['ogr_id']."][".$i."]' '>";
                echo "<option value=''>Ders Ekle</option>"; // Boş seçenek
                
                
                echo "</select></a></td>";
            }
              
          
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='8'>Seçilen okula ait öğrenci bulunamadı.</td></tr>";
    }
} catch(PDOException $e) {
    echo "<tr><td colspan='8'>Hata: " . $e->getMessage() . "</td></tr>";
}
?>


