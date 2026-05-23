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



<?php include 'header.php';


?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Öğrenci Bilgileri</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap"
    rel="stylesheet">
     <style>
         .container {
            width: 100%;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            transition: box-shadow 0.3s ease;
            margin: 20px;
            background-color: rgba(10, 80, 240, 0.8);

        }
  

.list-container {
    background-color: #f4f4f4;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.list-container h2 {
    text-align: center;
    margin-bottom: 20px;
}

.list-container ul {
    list-style-type: none;
    padding: 0;
}

.list-container ul li {
    padding: 10px;
    border-bottom: 1px solid #ddd;
}

.list-container ul li:last-child {
    border-bottom: none;
}

.list-container ul li:hover {
    background-color: #f0f0f0;
}

/* Button Style */
.btn {
    background-color: #007bff; /* Mavi renk */
    color: #28a745; /* Yeşilimsi renk */
    border: none;
    padding: 10px 20px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    transition-duration: 0.4s;
    cursor: pointer;
    border-radius: 4px;
}

.btn:hover {
    background-color: #0056b3; /* Koyu mavi hover rengi */
    color: #ffffff; /* Beyaz hover rengi */
}


 
 /* gğncelleme butonu içic */
 /* Güncelleme Formu için Genel Stiller */
.update-form {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: space-between;
    padding: 20px;
    margin-top: 20px;
    background-color: #f9f9f9;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
    width: 300px;
    box-sizing: border-box;
}

.update-form input[type="text"], .update-form button {
    width: 100%;
    padding: 10px;
    margin: 5px 0;
    border-radius: 20px;
    border: 1px solid #ccc;
    box-sizing: border-box;
}

/* Güncelle Butonu için Stiller */
.update-form button {
    background-color: #007aff;
    color: white;
    font-weight: bold;
    border: none;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.update-form button:hover {
    background-color: #005ecb;
}

/* Giriş Kutusu için Stiller */
.update-form input[type="text"] {
    border: 2px solid #ddd;
}

.update-form input[type="text"]:focus {
    outline: none;
    border-color: #007aff;
}

.hidden {
    display: none;
}


/* güncelleme butonu son */ 
/* Form stilleri */
form {
    display: flex;
    flex-direction: column;
    align-items: center;
    color: white;
    font-family: Arial, sans-serif;
}

/* Etiket stilleri */
form label {
    margin-bottom: 5px;
}

  /* Giriş kutusu stilleri */
        form input[type="text"],
        form select,
        form input[type="date"] {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: none;
            border-radius: 5px;
            background-color: rgba(255, 255, 255, 0.2);
            color: black; /* Metin rengini değiştirdim */
            font-size: 16px;
            box-sizing: border-box;
        }

/* Buton stilleri */
form button[type="submit"] {
    padding: 10px 20px;
    margin-top: 10px;
    border: none;
    border-radius: 5px;
    background-color: #007bff; /* Apple'ın mavi rengi */
    color: white;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

form button[type="submit"]:hover {
    background-color: #0056b3; /* Hover efekti için daha koyu bir mavi */
}
   
   /**  df **/


   
    </style>
</head>
<body>





<?php
include '../connect.php'; // Veritabanı bağlantısını sağlamak için


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Form gönderildiğinde sınıf ekleyelim
    $tarih= $_POST['tarih'];
    $sinif = $_POST['sinavadi'];
    $sinav_turu = $_POST['sinav_turu'];
    
    try {
        $stmt = $db->prepare("INSERT INTO sinavtarih (sinif, tarih, sinav_turu) VALUES (:sinif, :tarih, :sinav_turu)");
        $stmt->bindParam(':sinif', $sinif); // Parametreyi bağlama
        $stmt->bindParam(':tarih', $tarih); // Parametreyi bağlama
        $stmt->bindParam(':sinav_turu', $sinav_turu); // Parametreyi bağlama
        $stmt->execute();
        echo "Sınıf başarıyla eklendi.";
    } catch(PDOException $e) {
        echo "Sınıf eklenirken hata oluştu: " . $e->getMessage();
    }
}






if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id']) && isset($_POST['updatedValue'])) {
    $id = $_POST['id'];
    $updatedValue = $_POST['updatedValue'];

    try {
        $stmt = $db->prepare("UPDATE sinavtarih SET tarih = :updatedValue WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':updatedValue', $updatedValue);
        $stmt->execute();
        echo "Sınıf başarıyla güncellendi.";
    } catch(PDOException $e) {
        echo "Sınıf güncellenirken hata oluştu: " . $e->getMessage();
    }
}




?>
<center>
  <div class="container">
        <p>Sınav</p>
   <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    
    
                     <!-- baslangıc güncelleme  -->
                <?php
                try {
                    // Veritabanından dersliksinif tablosundaki verileri al
                    $stmt = $db->prepare("SELECT * FROM dersliksinif");
                    $stmt->execute();
                    $derslik_sinif = $stmt->fetchAll(PDO::FETCH_ASSOC);
                } catch (PDOException $e) {
                    echo $e->getMessage();
                }
                ?>

                <label for="derslik_sinif" class="iphone-label">Sınıf Seç</label>
                <select name="sinavadi" id="deneme_turu" class="iphone-select">
                    <option value="">Lütfen Sınavın olduğu sınıfı seçin</option>
                    <?php foreach ($derslik_sinif as $sinif): ?>
                        <option value="<?php echo $sinif['dersliksinif']; ?>"><?php echo $sinif['dersliksinif']; ?></option>
                    <?php endforeach; ?>
                </select>

                <!-- ayrı -->
                <?php

            try {
             
                // Veritabanından deneme_turu tablosundaki verileri al
                $stmt = $db->prepare("SELECT * FROM deneme_turu");
                $stmt->execute();
                $deneme_turleri = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
            catch(PDOException $e)
            {
                echo $e->getMessage();
            }
            ?>

            <label for="derslik_sinif" class="iphone-label">Deneme Türünü Seç</label>
            <select name="sinav_turu" id="deneme_turu " class="iphone-select">
                <option value="">Lütfen hangi denemeye girecekseler seç</option>
                <?php foreach ($deneme_turleri as $deneme_turu): ?>
                    <option value="<?php echo $deneme_turu['deneme_turu']; ?>"><?php echo $deneme_turu['deneme_turu']; ?></option>
                <?php endforeach; ?>
            </select>
                                 <!-- son güncelleme  -->
               <label for="derslik_sinif" class="iphone-label">Sınav Tarihini Seç</label>
               <input type="date" name="tarih">

              <br>


    <button type="submit" class="btn" name="submit">Sınavı Ekle</button>
</form>



    </div>

    <div class="container list-container">
    <h2 style="text-align:center;">Tüm Sınavlar</h2>
    <ul>
        <?php
        $sinavtarih = $db->query("SELECT * FROM sinavtarih")->fetchAll(PDO::FETCH_ASSOC);
        
            foreach ($sinavtarih as $sinif) {
                echo "<li>{$sinif['tarih']}
                 <i class='fa fa-edit edit-icon' data-id='{$sinif['id']}'></i> 
                    <i class='fa fa-trash delete-icon' data-id='{$sinif['id']}'></i> </li>";

                       echo "<p style='fon-size: 13px; color: red; '>Sınıfı: ({$sinif['sinif']})
                </p>";
                     
            }
        
          
        ?>
    </ul>
</div>

<!-- Güncelleme Formu -->
<div id="updateForm" class="update-form hidden">
    <input type="text" id="updatedValue">
    <button id="updateButton">Güncelle</button>
</div>

</center>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const editIcons = document.querySelectorAll('.edit-icon');

    editIcons.forEach(icon => {
        icon.addEventListener('click', function() {
            // Öncelikle mevcut açık olan tüm güncelleme formlarını kapatın
            const existingForms = document.querySelectorAll('.update-form');
            existingForms.forEach(form => {
                form.remove(); // Mevcut formu kaldır
            });

            const id = this.getAttribute('data-id');
            const listItem = this.parentElement;
            const currentText = listItem.childNodes[0].nodeValue.trim(); // Metin değerini alın

            // Güncelleme formunu oluşturun
            const updateForm = document.createElement('div');
            updateForm.classList.add('update-form');
            updateForm.innerHTML = `
                <input type="text" class="updatedValue" value="${currentText}">
                <button class="updateButton" data-id="${id}">Güncelle</button>
            `;
            
            // List item'a formu ekleyin
            listItem.appendChild(updateForm);

            // Güncelle butonu için olay işleyici
            const updateButton = updateForm.querySelector('.updateButton');
            updateButton.addEventListener('click', function() {
                const updatedValue = updateForm.querySelector('.updatedValue').value.trim();
                if (updatedValue !== '') {
                    const formData = new FormData();
                    formData.append('id', id);
                    formData.append('updatedValue', updatedValue);

                    fetch('', {  // kendi yani bu adrese yolladım üstede ifle aldım
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.text())
                    .then(data => {
                        console.log(data); // Sunucu yanıtını konsolda göster
                        location.reload(); // Sayfayı yenile
                    })
                    .catch(error => {
                        console.error('Güncelleme sırasında bir hata oluştu:', error);
                    });
                }
            });
        });
    });
});
</script>

<!-- silme kısmı altı -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const deleteIcons = document.querySelectorAll('.delete-icon');

    deleteIcons.forEach(icon => {
        icon.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            if (confirm('Bu Sınavı silmek istediğinize emin misiniz?')) {
                fetch('ds/dsilsinav.php', {  // bu kısma 'sil.php' mesela
                    method: 'POST',
                    body: JSON.stringify({ id: id }),
                    headers: {
                        'Content-Type': 'application/json',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if(data.success) {
                        window.location.reload();
                    } else {
                        alert('Silme işlemi başarısız.');
                    }
                })
                .catch(error => {
                    console.error('Silme işlemi sırasında hata oluştu:', error);
                });
            }
        });
    });
});
</script>


          <?php include 'footer.php'; ?>
</body>
</html>



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
