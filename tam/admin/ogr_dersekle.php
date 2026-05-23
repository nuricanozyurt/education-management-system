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
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Öğrenci Ders Ekleme</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #f9f9f9;
        }

        select {
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #fff;
            color: #333;
            display: block;
            width: calc(100% - 20px);
            margin-bottom: 5px;
        }

        button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            display: block;
            margin: 0 auto;
        }

        button:hover {
            background-color: #45a049;
        }

        .error {
            color: red;
        }

        .selected {
           /* background-color: #a6e7a6;  Yeşil renk */
        }
    </style>
</head>


<body>

    <?php include 'header.php';




?>

    <div class="container">
        <table>
            <tr>
                <th>Sıra No</th>
                <th>Öğrenci Bilgileri</th>
                <th>Veli Bilgileri</th>
                <th>Form</th>
            </tr>
            <?php
            include("../connect.php");

            // Öğrenci ID'sini al
            $ogr_id = $_GET['i'];
            $counter = 0;

            try {
                // Öğrenci bilgilerini sorgula
                $sorgu = $db->prepare("SELECT ogrenci.ogr_id, ogrenci.ogr_ad, ogrenci.ogr_soyad, ogrenci.ogr_tc FROM ogrenci WHERE ogrenci.ogr_id = ?");
                $sorgu->execute([$ogr_id]);
                $ogrenci = $sorgu->fetch(PDO::FETCH_ASSOC);

                if ($ogrenci) {
                    $counter++;
                    echo "<tr>";
                    echo "<td>" . $counter .  "</td>";
                    echo "<td>".$ogrenci['ogr_ad']." ".$ogrenci['ogr_soyad']." <br> ".$ogrenci['ogr_tc']."</td>";

                    // Öğrenciye ait veli bilgilerini sorgula
                    $veli_sorgu = $db->prepare("SELECT ogr_okul, ogr_adres FROM ogrenci_detay WHERE ogr_id = ?");
                    $veli_sorgu->execute([$ogr_id]);
                    $veli = $veli_sorgu->fetch(PDO::FETCH_ASSOC);

                    echo "<td>";
                    if ($veli) {
                        echo $veli['ogr_adres']." - <br> ".$veli['ogr_okul'];
                    } else {
                        echo "Okul ve Adres bilgisi bulunamadı.";
                    }
                    echo "</td>";

                    echo "<td>";
                    echo "<form method='post' action='ds/derskaydet.php'>";
                    echo "<input type='text' name='ogr_id'  style='display: none;'  value='".$ogrenci['ogr_id']."' required><br><br>";

                    // Öğrenci derslerini kontrol et
                    $dersler_sorgu = $db->prepare("SELECT * FROM ogrencidersleri WHERE ogr_id = ?");
                    $dersler_sorgu->execute([$ogr_id]);
                    $dersler = $dersler_sorgu->fetch(PDO::FETCH_ASSOC);

                    for ($i = 1; $i <= 8; $i++) {
                        echo "<select name='selectedClasses[".$i."]' onclick='openSelectOptions(this)'>";
                        echo "<option value=''>Ders Ekle</option>";

                        // Ders seçeneklerini oluştur
                        $sinif_sorgu = $db->prepare("SELECT DISTINCT sinif FROM siniflar");
                        $sinif_sorgu->execute();
                        $siniflar = $sinif_sorgu->fetchAll(PDO::FETCH_COLUMN);

                        foreach ($siniflar as $sinif) {
                            // Eğer ders seçiliyse, onu seçili yap
                            if ($dersler && isset($dersler["ders$i"]) && $dersler["ders$i"] == $sinif) {
                                echo "<option value='".$sinif."' selected>".$sinif."</option>";
                            } else {
                                echo "<option value='".$sinif."'>".$sinif."</option>";
                            }
                        }
                        echo "</select>";
                    }

                    echo "<button type='submit' name='submit'>Onayla</button>";
                    echo "</form>";

                    echo "</td>";
                       echo "<a href='../takvim.php?i=" . $ogrenci['ogr_id'] . "'>  <button type='submit' name='submit'>Takvim oluştur</button></a>";
                    echo "</tr>";
                } else {
                    echo "<tr><td colspan='4'>Öğrenci bulunamadı.</td></tr>";
                }
            } catch(PDOException $e) {
                echo "<tr><td colspan='4' class='error'>Hata: " . $e->getMessage() . "</td></tr>";
            }
            ?>
        </table>
    </div>
</body>
</html>






          <?php include 'footer.php'; ?>



<!-- Loading Gif -->
<div id="loading" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%);">
    <img src="https://media.tenor.com/k-A2Bukh1lUAAAAi/loading-loading-symbol.gif" alt="Yükleniyor...">
</div>
<script>
window.onload = function() {
    const loading = document.getElementById('loading');
    // Sayfa yüklendiğinde yükleme GIF'ini göster
    loading.style.display = 'block';

    // 1 saniye sonra yükleme GIF'ini gizle
    setTimeout(function() {
        loading.style.display = 'none';
    }, 2000); // 1000ms = 1 saniye
};
</script>



