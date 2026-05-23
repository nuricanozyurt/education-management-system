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



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Formdan gönderilen verileri işle
    $ogr_id = $_POST['ogr_id'];
    $odenen_ucret = $_POST['ogr_ucret'];
    $odeme_durumu = $_POST['odeme_durumu'];
    $odemedurumu = $_POST['odemedurumu'];
  
   
    try {
        // Ödeme durumunu güncelle
        $query = "UPDATE ogrenci_detay SET odemedurumu = ? WHERE ogr_id = ?";
        $statement = $db->prepare($query);
        $statement->execute([$odeme_durumu, $ogr_id]);
        

         if ($odemedurumu != $odeme_durumu &&  $odemedurumu == 0 ){ /* bu kısımda diğer odemedurumu değişkeninden farklı çünkü veri tabanından kontrol ediyorum ve birden fazla veri eklemesin diye kontrol için ekliyorum  (form yenilendiğinde) */
       
        // Ödeme tablosuna yeni kayıt ekle
        $query = "INSERT INTO odeme_tarih (ogr_id, odenen_ucret) VALUES (?, ?)";
        $statement = $db->prepare($query);
        $statement->execute([$ogr_id, $odenen_ucret]);
        
          }
       
    } catch(PDOException $e) {
        // Hata durumunda ekrana hata mesajını yazdırmak için ama yazdırmayacağım
    }
  


}

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
        /* Temel stillendirme */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

                /* Tablo stilleri */
             table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;

        }

        th, td {
            padding: 10px 5px; /* Yukarıdan ve aşağıdan 10px, soldan ve sağdan 5px */
            text-align: left;
            border-bottom: 1px solid #ddd; 
        }

        th {
            background-color: #f2f2f2;
}

        /* Düzenleme butonu stilleri */
        .edit-button {
            background-color: #4CAF50; /* Yeşil */
            border: none;
            color: white;
            padding: 8px 16px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            margin: 4px 2px;
            transition-duration: 0.4s;
            cursor: pointer;
            border-radius: 4px;
        }

        .edit-button:hover {
            background-color: #45a049; /* Koyu yeşil */
        }

        /* Animasyonlar */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        /* Gölgelendirme */
        .card {
            background-color: #fff;
            box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
            transition: 0.3s;
            margin-bottom: 20px;
            animation: fadeIn 1s ease;
        }



        /* arama butonu için */

        .header-search-container { position: relative; }

		.header-search-container .search-field {
  			font-size: var(--fs-7);
  			color: var(--onyx);
  			padding: 10px 15px;
  			padding-right: 50px;
  			border: 1px solid var(--cultured);
  			-webkit-border-radius: var(--border-radius-md);
       	    border-radius: var(--border-radius-md);
			}	

		.search-field::-webkit-search-cancel-button { display: none; }
	
		.search-btn {
 		 background: var(--white);
  		 position: absolute;
 		 top: 50%;
 		 right: 2px;
 		 -webkit-transform: translateY(-50%);
   		   -ms-transform: translateY(-50%);
  	        transform: translateY(-50%);
  	   	 color: var(--onyx);
 		 font-size: 18px;
 		 padding: 8px 15px;
 	    -webkit-border-radius: var(--border-radius-md);
          border-radius: var(--border-radius-md);
        -webkit-transition: color var(--transition-timing);
        -o-transition: color var(--transition-timing);
        transition: color var(--transition-timing);
}

.search-btn:hover { color: var(--salmon-pink); }
  .header-search-container { min-width: 300px; }

     .header-main .container { gap: 80px; }

  .header-search-container { -webkit-box-flex: 1; -webkit-flex-grow: 1; -ms-flex-positive: 1; flex-grow: 1; }

          input {
  display: block;
  width: 100%;
  font: inherit;
}

input::-webkit-input-placeholder { font: inherit; }

input::-moz-placeholder { font: inherit; }

input:-ms-input-placeholder { font: inherit; }

input::-ms-input-placeholder { font: inherit; }

input::placeholder { font: inherit; }
  button {
  background: none;
  font: inherit;
  border: none;
  cursor: pointer;
}

img, ion-icon, button, a { display: block; }





/* ALT KISMI CSS */

.simple-bar-chart{
  --line-count: 10;
  --line-color: currentcolor;
  --line-opacity: 0.25;
  --item-gap: 2%;
  --item-default-color: #060606;
  
  height: 10rem;
  display: grid;
  grid-auto-flow: column;
  gap: var(--item-gap);
  align-items: end;
  padding-inline: var(--item-gap);
  --padding-block: 1.5rem; /*space for labels*/
  padding-block: var(--padding-block);
  position: relative;
  isolation: isolate;
}

.simple-bar-chart::after{
  content: "";
  position: absolute;
  inset: var(--padding-block) 0;
  z-index: -1;
  --line-width: 1px;
  --line-spacing: calc(100% / var(--line-count));
  background-image: repeating-linear-gradient(to top, transparent 0 calc(var(--line-spacing) - var(--line-width)), var(--line-color) 0 var(--line-spacing));
  box-shadow: 0 var(--line-width) 0 var(--line-color);
  opacity: var(--line-opacity);
}
.simple-bar-chart > .item{
  height: calc(1% * var(--val));
  background-color: var(--clr, var(--item-default-color));
  position: relative;
  animation: item-height 1s ease forwards
}
@keyframes item-height { from { height: 0 } }

.simple-bar-chart > .item > * { position: absolute; text-align: center }
.simple-bar-chart > .item > .label { inset: 100% 0 auto 0 }
.simple-bar-chart > .item > .value { inset: auto 0 100% 0 }
















@media (prefers-color-scheme: dark) {
  body {
    background-color: #1D1E22;
    color: #f0f0f0;
  }
}
    </style>
</head>
<body>



<?php include 'header.php';




?>





<!-- Arama işlevi için JavaScript -->
<script type="text/javascript">
  function searchForElement() {
    var input, filter, tr, td, i, txtValue;
    input = document.getElementById("searchInput");
    filter = input.value.toUpperCase();
    tr = document.getElementsByClassName("ara");

    for (i = 0; i < tr.length; i++) {
      td = tr[i].getElementsByClassName("ara2");
      matchFound = false;
      for (var j = 0; j < td.length; j++) {
        txtValue = td[j].textContent || td[j].innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
          matchFound = true;
          break; // Eğer eşleşme bulunduysa döngüden çık
        }
      }
      if (matchFound) {
        tr[i].style.display = "";
        tr[i].style.transform = "translateY(0)"; // Reset transform to initial position
      } else {
        tr[i].style.display = "none";
      }
    }
  }
</script>



<div class="header-search-container">

         <input type="text" id="searchInput" onkeyup="searchForElement()" class="search-field" placeholder="Bir şeyler yazınız...">

          <button class="search-btn">
            <ion-icon name="search-outline"></ion-icon>
          </button>

        </div>

<div class="card"><br>
  <center>  <h2>Taksit Ödeme Durumu</h2> </center>
    <table>
        <tr><th>Sıra</th>
            <th>Ad</th>
            <th>Soyad</th>
            <th>TC Kimlik No</th>
            <th>Kayıt Tarihi</th>
            <th>Ödemesi Gereken Ücret</th>
            <th>Durum</th>
            <th>Ödeme Durumuu Düzenle</th>
            <th>Arşiv</th>
        </tr>
       <?php
include("../connect.php");

$counter = 0;

try {
    // Öğrenci bilgilerini sorgula
    $sorgu = $db->prepare("SELECT ogr_id, ogr_ad, ogr_soyad, veli_id, ogr_tc FROM ogrenci");
    $sorgu->execute();
    $ogrenciler = $sorgu->fetchAll(PDO::FETCH_ASSOC);

    // Sonuçları listele
    if ($ogrenciler) {
        
        foreach ($ogrenciler as $ogrenci) {
            $counter += 1;
            echo "<tr class='ara'>";
            echo "<td>" . $counter .  "</td>";
            echo "<td>".$ogrenci['ogr_ad']."</td>"; // Öğrenci adını düzgün bir şekilde ekle
            echo "<td>".$ogrenci['ogr_soyad']."</td>"; // Öğrenci soyadını düzgün bir şekilde ekle
            echo "<td class='ara2'>".$ogrenci['ogr_tc']."</td>";

            // İlgili veli bilgilerini sorgula
            $ogr_id = $ogrenci['ogr_id'];
            $veli_sorgu = $db->prepare("SELECT ogr_kayit_tar, ogr_ucret, odemedurumu FROM ogrenci_detay WHERE ogr_id = ?");
            $veli_sorgu->execute([$ogr_id]);
            $veli = $veli_sorgu->fetch(PDO::FETCH_ASSOC);

            // Eğer veli bulunduysa, bilgileri listele
            if ($veli) {
                echo "<td class='ara2'>".$veli['ogr_kayit_tar']."</td>";
                echo "<td class='ara2'>".$veli['ogr_ucret']."-TL</td>";
                echo "<td class='ara2'>";
                // Ödeme durumunu kontrol et ve uygun renkte göster
                if ($veli['odemedurumu'] == 0) {
                    echo "<span style='color:red;'>Ödenmedi</span>";
                } elseif ($veli['odemedurumu'] == 1) {
                    echo "<span style='color:green;'>Ödendi</span>";
                }
                echo "</td>";
            } else {
                echo "<td colspan='3'>Veli bilgisi bulunamadı.</td>";
            }

                 echo "<td>
                <form action='".$_SERVER['PHP_SELF']."' method='post'>
                      <input type='hidden' name='odemedurumu' value='".$veli['odemedurumu']."'>
                    <input type='hidden' name='ogr_ucret' value='".$veli['ogr_ucret']."'>
                    <input type='hidden' name='ogr_id' value='".$ogrenci['ogr_id']."'>
                    <button type='submit' class='edit-button' name='odeme_durumu' value='1'>Ödedi</button>
                    <button type='submit' class='edit-button' name='odeme_durumu' value='0'>Ödemedi</button>
                </form>
                  
            </td>";
              echo "<td>   <a class='edit-button' href='ogr_odeme_takvim.php?ogr_id=".$ogrenci['ogr_id']."&skjdldsfk984HDMSFNKL8045325KJNDSGFLKMDFKLSDKMSDFSDF935203adfsdkjf34235ncksdfkknnadasfnddfsdfsdfnsdflsdfjsodfsodfsdlfsdf=".$ogrenci['ogr_ad']."'>Arşiv</a> </td>"; /* bilerek uzun random karışık şey yazdım  yani grek yok sadece hoş */
            echo "</tr>";  
        }  
    } else {
        echo "<tr><td colspan='8'>Hiç öğrenci bulunamadı.</td></tr>";
    }
} catch(PDOException $e) {
    echo "<tr><td colspan='8'>Hata: " . $e->getMessage() . "</td></tr>";
}
?>

    </table>
</div>










<!-- ALT KISIM  -->

<br><br><br>
<h1>Başarı Oranımız</h1>
<div class="simple-bar-chart">
  
  <div class="item" style="--clr: #5EB344; --val: 80">
    <div class="label">YKS - TYT 300 ve üzeri</div>
    <div class="value">80%</div>
  </div>
  
  <div class="item" style="--clr: #FCB72A; --val: 63">
    <div class="label">YKS - AYT 300 ve üzeri</div>
    <div class="value">63%</div>
  </div>
  
  <div class="item" style="--clr: #F8821A; --val: 100">
    <div class="label">Baraj Geçme Oranı</div>
    <div class="value">100%</div>
  </div>
  
  <div class="item" style="--clr: #E0393E; --val: 15">
    <div class="label">YKS - AYT ilk 10000</div>
    <div class="value">15%</div>
  </div>
  
  <div class="item" style="--clr: #963D97; --val: 1">
    <div class="label">YKS - AYT ilk 100</div>
    <div class="value">1%</div>
  </div>
  
  <div class="item" style="--clr: #069CDB; --val: 95">
    <div class="label">Geri Bildirim Mutluluk Oranı</div>
    <div class="value">95%</div>
  </div>
</div>


<!-- ALT KISIM SON -->




          <?php include 'footer.php'; ?>
</body>
</html>




