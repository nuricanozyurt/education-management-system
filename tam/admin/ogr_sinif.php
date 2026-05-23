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
            width: 400%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
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

   /* Card Stili */
     /* Card Stili */
    .card {
        border: 1px solid #ccc;
        border-radius: 5px;
        padding: 20px;
        margin: 20px;
        width: 300px; /* Kartın genişliğini istediğiniz gibi ayarlayabilirsiniz */
        box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
        transition: 0.3s;
        background-color: #f5f5f5;
    }

    /* Kartın üzerine gelindiğinde hafif bir gölge efekti */
    .card:hover {
        box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
    }

    /* Başlık Stili */
    .card h2 {
        text-align: center;
        color: #333;
    }

    /* Seçim Kutusu Stili */
    .card select {
        width: 100%;
        padding: 10px;
        margin: 8px 0;
        display: inline-block;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }

    /* Tablo Stili */
    .card table {
        width: 100%;
        border-collapse: collapse;
    }

    /* Tablo Başlık Stili */
    .card th {
        background-color: #f2f2f2;
        color: #333;
        padding: 8px;
        text-align: left;
    }

    /* Tablo Satırı Stili */
    .card td {
        border-bottom: 1px solid #ddd;
        padding: 8px;
    }

    /* Son satırın alt çizgisini kaldırma */
    .card td:last-child {
        border-bottom: none;
    }

    /* Seçildikten Sonra Büyüme Animasyonu */
    .card.selected {
        width: 95%; /* Kartın büyüyeceği genişlik */
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






<div class="card" id="card">
   <h2 id="baslik">LÜTFEN OKUL SEÇİNİZ</h2>
    <select id="okulSecimi" onchange="okulSecildi(this.value)">
      <option value="">Okul Seçiniz</option>
        <?php
        include("../connect.php");

        // Okulları sorgula
        $sorgu = $db->prepare("SELECT DISTINCT ogr_okul FROM ogrenci_detay");
        $sorgu->execute();
        $okullar = $sorgu->fetchAll(PDO::FETCH_COLUMN);

        // Okulları listele
        foreach ($okullar as $okul) {
            echo "<option value='".$okul."'>".$okul."</option>";
        }
        ?>
    </select>
    <table id="ogrenciTablosu">
        <!-- Öğrenci tablosu burada olacak, başlangıçta boş olacak -->
    </table>
</div>

<script>
    function okulSecildi(okul) {
        if (okul) {
            // Okula göre öğrencileri getir
            fetch('ogr_getogrenciler.php?okul=' + okul)
            .then(response => response.text())
            .then(data => {
                document.getElementById('ogrenciTablosu').innerHTML = data;
                document.getElementById('card').classList.add('selected');
                document.getElementById('baslik').textContent = 'LÜTFEN ALMASI GEREKEN DERSLERİ SEÇİNİZ';
            });
        } else {
            document.getElementById('ogrenciTablosu').innerHTML = "<tr><td colspan='2'>Lütfen alması gereken dersleri seçin</td></tr>";
            document.getElementById('card').classList.remove('selected');
            document.getElementById('baslik').textContent = 'LÜTFEN OKUL SEÇİNİZ';
        }
    }
</script>



          <?php include 'footer.php'; ?>
</body>
</html>




