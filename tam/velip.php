<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'connect.php';

if(isset($_POST['add_veli_btn'])){
    $veli_ad = $_POST['veli_ad'];
    $veli_soyad = $_POST['veli_soyad'];
    $veli_tel = $_POST['veli_tel'];
    $veli_tc = $_POST['veli_tc'];
    $veli_meslek = $_POST['veli_meslek'];
    $veli_mail = $_POST['veli_mail'];

   
        
    // Veli tablosuna ekleme
    $sorgu_veli = $db->prepare("INSERT INTO veli (veli_ad, veli_soyad, veli_tc, veli_tel, veli_meslek, veli_mail) VALUES (?, ?, ?, ?, ?, ?)");
    $sorgu_veli->execute([$veli_ad, $veli_soyad, $veli_tc, $veli_tel, $veli_meslek, $veli_mail]);
    $veli_id = $db->lastInsertId();

   

  

    if ($sorgu_veli) {
        header("Location: ./admin/addveli.php?yukleme=basarili");
        exit();
    } else {
        echo "İşlem başarısız oldu. Lütfen tekrar deneyin.";
    }
}
?>
