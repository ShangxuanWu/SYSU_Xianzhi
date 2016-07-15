<?php
$page = $_GET['page'];
$location_view = $_GET['l'];//1=guangzhou 2=zhuhai
if($page == 12.25) 
    $page = 1;
$time = date("Y-m-d");
//$ttime = $_GET["ttime"];
$ttime=$time;
$ttime_=date("m-d");
$ttime1=date('Y-m-d' , strtotime('-1 day'));
$ttime2=date('Y-m-d' , strtotime('-2 day'));
$ttime2_=date('m-d' , strtotime('-2 day'));
$things_per_page = 10;

?>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<!DOCTYPE html><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!--Declare page as mobile friendly --> 
<meta name="viewport" content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0"/>
<!-- Declare page as iDevice WebApp friendly -->
<meta name="apple-mobile-web-app-capable" content="yes"/>
<!-- iDevice WebApp Splash Screen, Regular Icon, iPhone, iPad, iPod Retina Icons -->
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/splash/splash-icon.png"> 
<!-- iPhone 3, 3Gs -->
<link rel="apple-touch-startup-image" href="images/splash/splash-screen.png" 			media="screen and (max-device-width: 320px)" /> 
<!-- iPhone 4 -->
<link rel="apple-touch-startup-image" href="images/splash/splash-screen_402x.png" 		media="(max-device-width: 480px) and (-webkit-min-device-pixel-ratio: 2)" /> 
<!-- iPhone 5 -->
<link rel="apple-touch-startup-image" sizes="640x1096" href="images/splash/splash-screen_403x.png" />

<!-- Page Title -->
<title>@中大闲置</title>

<!-- Stylesheet Load -->
<link href="styles/style.css"				rel="stylesheet" type="text/css">
<link href="styles/framework-style.css" 	rel="stylesheet" type="text/css">
<link href="styles/framework.css" 			rel="stylesheet" type="text/css">
<link href="styles/bxslider.css"			rel="stylesheet" type="text/css">
<link href="styles/swipebox.css"			rel="stylesheet" type="text/css">
<link href="styles/icons.css"				rel="stylesheet" type="text/css">
<link href="styles/retina.css" 				rel="stylesheet" type="text/css" media="only screen and (-webkit-min-device-pixel-ratio: 2)" />


<!--Page Scripts Load -->
<script src="scripts/jquery.min.js"		type="text/javascript"></script>	
<script src="scripts/hammer.js"			type="text/javascript"></script>	
<script src="scripts/jquery-ui-min.js"  type="text/javascript"></script>
<script src="scripts/subscribe.js"		type="text/javascript"></script>
<script src="scripts/contact.js"		type="text/javascript"></script>
<script src="scripts/jquery.swipebox.js" type="text/javascript"></script>
<script src="scripts/bxslider.js"		type="text/javascript"></script>
<script src="scripts/colorbox.js"		type="text/javascript"></script>
<script src="scripts/retina.js"			type="text/javascript"></script>
<script src="scripts/custom.js"			type="text/javascript"></script>
<script src="scripts/framework.js"		type="text/javascript"></script>

</head>
<body>

<div id="preloader">
	<div id="status">
    	<p class="center-text">
			莫着急...
            <em>闲置君马上就来！</em>
        </p>
    </div>
</div>

<div class="header">
    <a class="logo-home" href="index.html"><img src="images/logob.png" alt="img" width="40"></a>
    <div class="header-text">
        <strong align="right">内部使用</strong>
        <em align="right">这三天的闲置列表~</em>
    </div>
</div>
<div class="header-clear"></div>

<div class="content">
      
      
      
      <div class="container">
          <div class="blog-post">
                 
                  <p>
                      

<?php

$con = mysql_connect(SAE_MYSQL_HOST_M.':'.SAE_MYSQL_PORT,SAE_MYSQL_USER,SAE_MYSQL_PASS);
if(!$con){ 
    die('could not connect:'.mysql_error());
}
mysql_select_db(SAE_MYSQL_DB,$con);
mysql_set_charset("utf8_general_ci");

$start = ($page-1)*$things_per_page+1;
$end = $page*$things_per_page;
if($location_view==1)
{
$sql = "SELECT * 
FROM `test` 
WHERE review_ok = 1 and
(time LIKE '$ttime'or time LIKE '$ttime1' or time LIKE '$ttime2')
and (location = '东校区' or location = '南校区' or location = '北校区')
ORDER BY id DESC"
    ;}
else
{
    $sql = "SELECT * 
FROM `test` 
WHERE review_ok = 1 and
(time LIKE '$ttime'or time LIKE '$ttime1' or time LIKE '$ttime2')
and location = '珠海校区'
ORDER BY id DESC"
        
    ;
}

$query = mysql_query($sql) or die(mysql_error());
$result = mysql_fetch_array($query);
$count = 0;
$displayed_count = 0;
$total_page = ceil(mysql_num_rows($query)/$things_per_page);
mysql_close($con);
if(!$result)//开始判断是够为空  
    {  
    echo "<br><font color='red'>这几天闲置君没有收到更多的闲置了！</font><br><br>";

    } 
else
{
    $count = $count + 1;
   
 do{
     if(1){
         
         $displayed_count = $displayed_count + 1;
         
?>
                           <font color="blue">【闲置编号】   <?php echo $result['id'];?></font><br>
                      <font color="red">【闲置名称】<?php echo $result['name'];?><br></font>  
  【闲置价格】<?php echo $result['price'];?><br>

                      
<?php
         if($count != $end)
             echo '<br>';
         else
             echo '<br><br><br>';
     }
     $count = $count + 1;
 } while($result = mysql_fetch_array($query));
    if($displayed_count < $things_per_page)
    {
        echo "<br><font color = 'blue'>这几天闲置君没有收到更多闲置了！</font>";
    }
?>
                    
                     
                      
                      <?php }?>
                          <br>
                      <div class="decoration"></div>                     
          </div>     
<div class="footer">
    <div class="small-navigation-icons">
    	<a href="search_sell.php" class="small-nav-icon facebook-nav"></a>
        <a href="#" class="small-nav-icon go-up up-nav"></a>
        <a href="upload_sell.php" class="small-nav-icon upload-nav"></a>
        <div class="clear"></div>
    </div>
    <p class="copyright">COPYRIGHT 2016 @中大闲置 ALL RIGHTS RESERVED</p>
</div>



</body>


