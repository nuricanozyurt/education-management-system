

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



  include 'header.php';







?>


<!-- üst son -->


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../images/<?php echo $list['website_favicon'];?>">
    <meta name="description" content="<?php echo $list['website_desc'];?>">
    <meta name="keywords" content="<?php echo $list['website_keyw'];?>">
    <meta name="author" content="<?php echo $list['website_owner'];?>">
    <title><?php echo $list['website_name'];?></title>
    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <!-- Sıralama özelliği-->
     
<style>



  video {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }
</style>
    <link rel="stylesheet" type="text/css" href="./vendor/datatables/datatables.min.css"/>

    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">


        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

           





<div id="video-container">
  <video autoplay loop muted>
    <source src="img/adminindex.mp4" type="video/mp4">
  
  </video>
</div>



</body>
</html>







<!-- alt son -->





          <?php include 'footer.php'; ?>
