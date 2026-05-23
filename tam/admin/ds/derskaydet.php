<?php 


// Oturumu başlat
session_start();



// Oturumda kullanıcı kimliği var mı kontrol et
if(isset($_SESSION['email'])) {
        
// Kullanıcı girişi yapılmış, kullanıcı kimliğini kullanabiliriz
    
    
        require_once '../../connect.php'; 
       
       $email = $_SESSION['email'];
    


} else {
    // Kullanıcı girişi yapılmamış, isterseniz giriş sayfasına yönlendirme yapabilirsiniz
    header("Location: ../../admin.php");
    exit();
}




?>







<?php  

include "../../connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Öğrenci ID'sini al
    $ogr_id = $_POST['ogr_id'];

    // Seçilen sınıfları al
    $selected_classes = $_POST['selectedClasses'];

    try {
        // Veritabanında öğrenci ID'sine göre kayıt olup olmadığını kontrol et
        $check_sql = "SELECT COUNT(*) as count FROM ogrencidersleri WHERE ogr_id = :ogr_id";
        $check_stmt = $db->prepare($check_sql);
        $check_stmt->bindParam(':ogr_id', $ogr_id);
        $check_stmt->execute();
        $row = $check_stmt->fetch(PDO::FETCH_ASSOC);

        if ($row['count'] > 0) {
            // Öğrenci zaten var, güncelle
            $update_sql = "UPDATE ogrencidersleri SET ders1 = :ders1, ders2 = :ders2, ders3 = :ders3, ders4 = :ders4, ders5 = :ders5, ders6 = :ders6, ders7 = :ders7, ders8 = :ders8 WHERE ogr_id = :ogr_id";
            $stmt = $db->prepare($update_sql);
        } else {
            // Yeni öğrenci, ekle
            $insert_sql = "INSERT INTO ogrencidersleri (ogr_id, ders1, ders2, ders3, ders4, ders5, ders6, ders7, ders8) VALUES (:ogr_id, :ders1, :ders2, :ders3, :ders4, :ders5, :ders6, :ders7, :ders8)";
            $stmt = $db->prepare($insert_sql);
        }

        // Bağlamaları yap
        $stmt->bindParam(':ogr_id', $ogr_id);
        $stmt->bindParam(':ders1', $selected_classes[1]);
        $stmt->bindParam(':ders2', $selected_classes[2]);
        $stmt->bindParam(':ders3', $selected_classes[3]);
        $stmt->bindParam(':ders4', $selected_classes[4]);
        $stmt->bindParam(':ders5', $selected_classes[5]);
        $stmt->bindParam(':ders6', $selected_classes[6]);
        $stmt->bindParam(':ders7', $selected_classes[7]);
        $stmt->bindParam(':ders8', $selected_classes[8]);
        
        // Sorguyu çalıştır
        $stmt->execute();

        echo "Veriler başarıyla eklendi veya güncellendi.";

       header("Location: ../ogr_dersekle.php?i=$ogr_id");
exit();

    } catch(PDOException $e) {
        echo "Veri ekleme/güncelleme hatası: " . $e->getMessage();
    }
}


?>