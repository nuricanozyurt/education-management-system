<?php
ob_start(); // Çıktı tamponlamasını başlat
// Kodunuzun geri kalanı
?>



<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Güven Dershanesi</title>
    <!-- Google fonts -->
       <link href="//fonts.googleapis.com/css2?family=Ubuntu:wght@300;400;500;700&display=swap" rel="stylesheet">
    <!-- Template CSS Style link -->
    <link rel="stylesheet" href="../assets/css/style-starter.css">
<link rel="stylesheet" href="fonts/material-icon/css/material-design-iconic-font.min.css">

<link rel="stylesheet" href="css/style.css">
<meta name="robots" content="noindex, follow">
<script nonce="03541aba-f354-4619-861a-71ab5ff04323">try{(function(w,d){!function(b,c,d,e){b[d]=b[d]||{};b[d].executed=[];b.zaraz={deferred:[],listeners:[]};b.zaraz.q=[];b.zaraz._f=function(f){return async function(){var g=Array.prototype.slice.call(arguments);b.zaraz.q.push({m:f,a:g})}};for(const h of["track","set","debug"])b.zaraz[h]=b.zaraz._f(h);b.zaraz.init=()=>{var i=c.getElementsByTagName(e)[0],j=c.createElement(e),k=c.getElementsByTagName("title")[0];k&&(b[d].t=c.getElementsByTagName("title")[0].text);b[d].x=Math.random();b[d].w=b.screen.width;b[d].h=b.screen.height;b[d].j=b.innerHeight;b[d].e=b.innerWidth;b[d].l=b.location.href;b[d].r=c.referrer;b[d].k=b.screen.colorDepth;b[d].n=c.characterSet;b[d].o=(new Date).getTimezoneOffset();if(b.dataLayer)for(const o of Object.entries(Object.entries(dataLayer).reduce(((p,q)=>({...p[1],...q[1]})),{})))zaraz.set(o[0],o[1],{scope:"page"});b[d].q=[];for(;b.zaraz.q.length;){const r=b.zaraz.q.shift();b[d].q.push(r)}j.defer=!0;for(const s of[localStorage,sessionStorage])Object.keys(s||{}).filter((u=>u.startsWith("_zaraz_"))).forEach((t=>{try{b[d]["z_"+t.slice(7)]=JSON.parse(s.getItem(t))}catch{b[d]["z_"+t.slice(7)]=s.getItem(t)}}));j.referrerPolicy="origin";j.src="/cdn-cgi/zaraz/s.js?z="+btoa(encodeURIComponent(JSON.stringify(b[d])));i.parentNode.insertBefore(j,i)};["complete","interactive"].includes(c.readyState)?zaraz.init():b.addEventListener("DOMContentLoaded",zaraz.init)}(w,d,"zarazData","script");})(window,document)}catch(e){throw fetch("/cdn-cgi/zaraz/t"),e;};</script>

</head>

<body>
    <!-- header -->
    <header id="site-header" class="fixed-top">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light">
                <a class="navbar-brand" href="index.php"><i class="fas fa-graduation-cap"></i>Güven Dershanesi
                </a>
                <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon fa icon-expand fa-bars"></span>
                    <span class="navbar-toggler-icon fa icon-close fa-times"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarScroll">
                    <ul class="navbar-nav ms-auto my-2 my-lg-0 navbar-nav-scroll">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="../index.php">Anasayfa</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../about.php">Hakkımızda</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../contact.php">İletişim</a>
                        </li>
                        <li class="nav-item">
                            <li><a href="index.php">Giriş Yap</a></li>
                        </li>
                         <li class="nav-item">
                           
                        </li>
                        
                    </ul>
                    
                </div>
                <!-- toggle switch for light and dark theme -->
                <div class="cont-ser-position">
                    <nav class="navigation">
                        <div class="theme-switch-wrapper">
                            <label class="theme-switch" for="checkbox">
                                <input type="checkbox" id="checkbox">
                                <div class="mode-container">
                                    <i class="gg-sun"></i>
                                    <i class="gg-moon"></i>
                                </div>
                            </label>
                        </div>
                    </nav>
                </div>
                <!-- //toggle switch for light and dark theme -->
            </nav>
        </div>
    </header>
  

<div class="main">

<!--
<section class="signup">
<div class="container">
<div class="signup-content">
<div class="signup-form">
<h2 class="form-title">Kayıt Ol</h2>
<form method="POST" class="register-form" id="register-form">
<div class="form-group">
<label for="name"><i class="zmdi zmdi-account material-icons-name"></i></label>
<input type="text" name="name" id="name" placeholder="İsmin" />
</div>
<div class="form-group">
<label for="email"><i class="zmdi zmdi-email"></i></label>
<input type="email" name="email" id="email" placeholder="E-Posta" />
</div>
<div class="form-group">
<label for="pass"><i class="zmdi zmdi-lock"></i></label>
<input type="password" name="pass" id="pass" placeholder="Şifre" />
</div>
<div class="form-group">
<label for="re-pass"><i class="zmdi zmdi-lock-outline"></i></label>
<input type="password" name="re_pass" id="re_pass" placeholder="Şifreyi Doğrula" />
</div>
<div class="form-group">
<input type="checkbox" name="agree-term" id="agree-term" class="agree-term" />
<label for="agree-term" class="label-agree-term"><span><span></span></span>Kullanım Şözleşmesini Kabul et<a href="#" class="term-service">Servis</a></label>
</div>
<div class="form-group form-button">
<input type="submit" name="signup" id="signup" class="form-submit" value="Kayıt Ol" />
</div>
</form>
</div>
<div class="signup-image">
<figure><img src="https://colorlib.com/etc/regform/colorlib-regform-7/images/signin-image.jpg" alt="sing up image"></figure>
<a href="#" class="signup-image-link">x</a>
</div>
</div>
</div>
</section>



-->
<section class="sign-in">
<div class="container">
<div class="signin-content">
<div class="signin-image">
<figure><img src="https://colorlib.com/etc/regform/colorlib-regform-7/images/signup-image.jpg" alt="sing up image"></figure>
<a href="#" class="signup-image-link">Kayıt Olmak için Randevu Al</a>
</div>
<div class="signin-form">
<h2 class="form-title">Giriş Yap</h2>
<form method="POST" class="register-form" id="login-form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
<div class="form-group">
<label for="your_name"><i class="zmdi zmdi-account material-icons-name"></i></label>
<input type="text" name="your_name" id="your_name" placeholder="E-Posta" />
</div>
<div class="form-group">
<label for="your_pass"><i class="zmdi zmdi-lock"></i></label>
<input type="password" name="your_pass" id="your_pass" placeholder="Password" />
</div>
<div class="form-group">
<input type="checkbox" name="remember-me" id="remember-me" class="agree-term" />
<label for="remember-me" class="label-agree-term"><span><span></span></span>Beni Hatırla</label>
</div>
<div class="form-group form-button">
<input type="submit" name="signin" id="signin" class="form-submit" value="Giriş Yap" />
</div>
</form>


<?php
session_start(); // Session başlat

include "../connect.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['your_name'];
    $password = $_POST['your_pass'];

    // Öğrenci detay tablosunu kontrol et
    $stmt = $db->prepare("SELECT * FROM ogrenci_detay WHERE ogr_mail = :email");
    $stmt->execute(array(':email' => $email));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($row) {
        // Öğrenci tablosunu kontrol et
        $stmt = $db->prepare("SELECT * FROM ogrenci WHERE ogr_id = :ogr_id AND ogr_tc = :password");
        $stmt->execute(array(':ogr_id' => $row['ogr_id'], ':password' => $password));
        $ogrenci = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($ogrenci) {
            // Doğru giriş bilgileri
            // Oturum değişkenlerini ayarla
            $_SESSION['ogr_id'] = $row['ogr_id']; // Öğrenci ID'sini oturumda sakla
            header("Location: l/index.php");  // Oturum değişkenlerini sakladıktan sonra ana sayfaya yönlendir
            exit(); // veya die();
        } else {
            echo "Hatalı şifre";
        }
    } else {
        echo "Bu e-posta ile kayıtlı bir kullanıcı bulunamadı";
    }
}
?>


<div class="social-login">
<span class="social-label">Takip Et</span>
<ul class="socials">
<li><a href="#"><i class="display-flex-center zmdi zmdi-facebook"></i></a></li>
<li><a href="#"><i class="display-flex-center zmdi zmdi-twitter"></i></a></li>
<li><a href="#"><i class="display-flex-center zmdi zmdi-google"></i></a></li>
</ul>
</div>
</div>
</div>
</div>
</section>
</div>

<script src="js/jquery.js"></script>
<script src="js/main.js"></script>

<script async src="https://www.googletagmanager.com/gtag/js?id=UA-23581568-13"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-23581568-13');
</script>
<script defer src="https://static.cloudflareinsights.com/beacon.min.js/v84a3a4012de94ce1a686ba8c167c359c1696973893317" integrity="sha512-euoFGowhlaLqXsPWQ48qSkBSCFs3DPRyiwVu3FjR96cMPx+Fr+gpWRhIafcHwqwCqWS42RZhIudOvEI+Ckf6MA==" data-cf-beacon='{"rayId":"870008333cfb50f9","version":"2024.3.0","token":"cd0b4b3a733644fc843ef0b185f98241"}' crossorigin="anonymous"></script>
</body>
</html>


<!-- bootstrap -->
    <script src="../assets/js/bootstrap.min.js"></script>
    <!-- //bootstrap -->