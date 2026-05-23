

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../obs/l/assets/images/favicon.png" type="image/x-icon">
   <link rel="icon" href="../obs/l/assets/images/favicon.ico" type="image/x-icon">
   <title>Admin Paneli</title>

    <!--

    <link rel="icon" href="../images/<?php /* echo $list['website_favicon'];  */?>">
     <title><?php /* echo $list['website_name'];   */ ?></title>
    yedek  -->

    <meta name="description" content="<?php echo $list['website_desc'];?>">
    <meta name="keywords" content="<?php echo $list['website_keyw'];?>">
    <meta name="author" content="<?php echo $list['website_owner'];?>">
    
    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <!-- Sıralama özelliği-->

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

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="./">
              <div class="sidebar-brand-icon rotate-n-15">
                  <img src="./img/kitap3.png" alt="logo" style="height:50px;">
              </div>
                <div class="sidebar-brand-text mx-3">Yönetim Paneli</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">
            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-user"></i>
                    <span>Öğrenci Yönetimi</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Öğrenci işlemi</h6>
                        <a class="collapse-item" href="./addstudent.php">Öğrenci Ekle</a>
                        <a class="collapse-item" href="./addveli.php">Veli Ekle</a>
                        <a class="collapse-item" href="ogr_ogrencipuanekle.php">Notlar</a>
                         <a class="collapse-item" href="ogr_devamsizlik.php">Devamsızlık</a>

                    </div>
                </div>
            </li>
            
             <li class="nav-item">
                <a class="nav-link" href="ogr_sinavolustur.php">
                   
                <i class="fas fa-fw fa-clipboard-check"></i>

                    <span>Sınav Ekle</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
                    aria-expanded="true" aria-controls="collapsePages">
                    <i class="fas fa-fw fa-bars"></i>
                    <span>Ders Programı Yönetimi</span>
                </a>
                <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                      <a class="collapse-item" href="add_ders.php">Ders Ekle Sil</a>
                       <a class="collapse-item" href="ogr_sinif.php">Öğrenci Ders Kayıt</a>
                       <a class="collapse-item" href="ogr_ders_programi.php">Ders Programı</a>

                 
                        
                    </div>
                </div>
            </li>

         

           <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePagessinif"
                    aria-expanded="true" aria-controls="collapsePages">
                    <i class="fas fa-fw fa-bars"></i>
                    <span>Sınıf ve Sınıf Atama</span>
                </a>
                <div id="collapsePagessinif" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                      <a class="collapse-item" href="add_class.php">Sınıf Oluştur</a>
                      <a class="collapse-item" href="ogr_sinifata.php">Sınıf Ata</a>
                        
                    </div>
                </div>
            </li>
             
             
            <!-- Nav Item - Charts -->
            
             

            <li class="nav-item">
                <a class="nav-link" href="ogr_users.php">
                    <i class="fas fa-fw fa-user"></i>
                    <span>Öğrenciler</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="ogr_hocalar.php">
                    <i class="fas fa-fw fa-user"></i>
                    <span>Hocalar</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="ogr_taksit.php">
                    <i class="fas fa-fw fa-user"></i>
                    <span>Taksit Ödemeleri</span></a>
            </li>
            

            <li class="nav-item">
                <a class="nav-link" href="../admin.php">
                    <i class="fas fa-fw fa-share"></i>
                    <span>Çıkış</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>



        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>


                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"> Sayın, Admin</span>
                                <img class="img-profile rounded-circle"
                                    src="img/undraw_profile.svg">
                            </a>

                        </li>
                    </ul>
                </nav>
