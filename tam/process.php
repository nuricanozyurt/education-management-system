<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'connect.php';

if(isset($_POST['add_recipe_btn'])){
   

    $ogr_tc = $_POST['ogr_tc'];
    $ogr_ad = $_POST['ogr_ad'];
    
    $veli_id = $_POST['veli_id'];
    $ogr_tel = $_POST['ogr_tel'];
    $ogr_adres = $_POST['ogr_adres'];
    
    $ogr_kayit_tar = $_POST['ogr_kayit_tar'];
    $ogr_dogum_tar = $_POST['ogr_dogum_tar'];
    $ogr_ucret = $_POST['ogr_ucret'];
    $okul_id = $_POST['okul_id'];
    $ogr_mail = $_POST['ogr_mail'];
    
$kan_id = $_POST['kan_id'];

// Kan grubunun adını al

  // Kan grubunun adını al
$kan_grup_sorgu = "SELECT * FROM kan";
$stmt = $db->query($kan_grup_sorgu);
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$ogr_kan_grubu = $row['kan_grup'];


/*
$kan_grup_sorgu = "SELECT * FROM kan";
  $stmt = $db->query($kan_grup_sorgu);
  $stmt->bindParam(':kan_id', $kan_id, PDO::PARAM_INT);
  $stmt->execute();
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  $ogr_kan_grubu = $row['kan_grup'];
  */      
   // Seçilen velinin soyadını al
   $veli_sorgu = "SELECT veli_soyad FROM veli WHERE veli_id = :veli_id";
   $stmt = $db->prepare($veli_sorgu);
   $stmt->bindParam(':veli_id', $veli_id, PDO::PARAM_INT);
   $stmt->execute();
   $row = $stmt->fetch(PDO::FETCH_ASSOC);
   $ogr_soyad = $row['veli_soyad'];
   
   //Seçilen okulun adını al
   $okul_sorgu = "SELECT okul_ad FROM okullar WHERE okul_id = :okul_id";
$stmt = $db->prepare($okul_sorgu);
$stmt->bindParam(':okul_id', $okul_id, PDO::PARAM_INT);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$ogr_okul = $row['okul_ad'];    

  
    // Öğrenci tablosuna ekleme
    $sorgu_ogrenci = $db->prepare("INSERT INTO ogrenci (ogr_tc, ogr_ad, ogr_soyad, veli_id) VALUES (?, ?, ?, ?)");
    $sorgu_ogrenci->execute([$ogr_tc, $ogr_ad, $ogr_soyad, $veli_id,]);
    $ogr_id = $db->lastInsertId();

    

// Öğrenci detay tablosuna ekleme
$sorgu_detay = $db->prepare("INSERT INTO ogrenci_detay (ogr_id, ogr_tel, ogr_adres, ogr_okul, ogr_kayit_tar, ogr_dogum_tar, ogr_ucret, ogr_kan_grubu, ogr_mail) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
$sorgu_detay->execute([$ogr_id, $ogr_tel, $ogr_adres, $ogr_okul, $ogr_kayit_tar, $ogr_dogum_tar, $ogr_ucret, $ogr_kan_grubu, $ogr_mail]);

// max devasmızlık ekleme ve kontrol için 
$toplamdevamsizlik = 20;
$devamsizlikgim = 0;
$devamsizlik = $db->prepare("INSERT INTO devamsizlik (ogr_id, toplamdevamsizlik, devamsizlikgim) VALUES (?, ?, ?)");
$devamsizlik->execute([$ogr_id, $toplamdevamsizlik, $devamsizlikgim]);


if ($sorgu_detay) {
    echo '<script>alert("Öğrenci Ekleme Başarılı");</script>';
    header("refresh:1;url=./admin/addstudent.php?yukleme=basarili");
    exit();
} else {
    echo "İşlem başarısız oldu. Lütfen tekrar deneyin.";
}
}
?>
