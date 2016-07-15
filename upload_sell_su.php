<?php

/**
* $Id$
*
* SCS form upload example
*/

//you can ignore it
@include_once('config.php');

if (!class_exists('SCS')) require_once './class/SCS.php';

date_default_timezone_set('UTC');

// SCS access info
if (!defined('AccessKey')) define('AccessKey', '1gyrzihJMT7dcjFWEgRm');
if (!defined('SecretKey')) define('SecretKey', '58316601a56779fcaac0b35a5a625320706f7f68');
if (!defined('BucketName')) define('BucketName', 'selling-photos');

// Check for CURL
if (!extension_loaded('curl') && !@dl(PHP_SHLIB_SUFFIX == 'so' ? 'curl.so' : 'php_curl.dll'))
	exit("\nERROR: CURL extension not loaded\n\n");

// Pointless without your keys!
if (AccessKey == 'change-this' || SecretKey == 'change-this')
	exit("\nERROR: SCS access information required\n\nPlease edit the following lines in this file:\n\n".
	"define('AccessKey', 'change-me');\ndefine('SecretKey', 'change-me');\n\n");
	
// Pointless without your BucketName!
if (BucketName == 'change-this')
	exit("\nERROR: BucketName required\n\nPlease edit the following lines in this file:\n\n".
	"define('BucketName', 'change-me');\n\n");


SCS::setAuth(AccessKey, SecretKey);

$bucket = BucketName;
$path = ''; // Can be empty ''

$lifetime = 3600; // Period for which the parameters are valid
$maxFileSize = (1024 * 1024 * 1.5); // 1.5 MB

$metaHeaders = array('uid' => 123);
$requestHeaders = array(
    'Content-Type' => 'application/octet-stream',
    'Content-Disposition' => 'attachment; filename=${filename}'
);

$params = SCS::getHttpUploadPostParams(
    $bucket,
    $path,
    SCS::ACL_PUBLIC_READ,
    $lifetime,
    $maxFileSize,
    201, // Or a URL to redirect to on success
    $metaHeaders,
    $requestHeaders,
    false // False since we're not using flash
);

$uploadURL = 'http://' . $bucket . '.sinacloud.net/';

?>
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
<title>出售闲置登记表</title>

<!-- Stylesheet Load -->
<link href="styles/style.css"				rel="stylesheet" type="text/css">
<link href="styles/framework-style.css" 	rel="stylesheet" type="text/css">
<link href="styles/framework.css" 			rel="stylesheet" type="text/css">
<link href="styles/bxslider.css"			rel="stylesheet" type="text/css">
<link href="styles/swipebox.css"			rel="stylesheet" type="text/css">
<link href="styles/icons.css"				rel="stylesheet" type="text/css">
<link href="styles/style2.css"				rel="stylesheet" type="text/css">
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
            <em>闲置君马上就来~</em>
        </p>
    </div>
</div>

<div class="header">
    <a class="logo-home" ><img src="images/logo_su.jpg" alt="img" width="40"></a>
    <div class="header-text">
        <strong>中东校会 × 中大闲置</strong>
        <em align="right">毕业季特供</em>
    </div>
</div>
<div class="header-clear"></div>

<div class="content">
      <div class="container no-bottom">
          <div class="heading">
              <div class="heading-left">
                  <em>
                      记得要把所有的信息都填上哦~</em>
          
                  <h3>客官想要卖啥(●'◡'●)？</h3>
              </div>
              <div class="heading-right">
                  <span class="icon icon-pencil"></span>
              </div>
          </div>
      </div>
          
         

        
    	<div class="container no-bottom">
            <div class="contact-form no-bottom"> 
                <div class="formSuccessMessageWrap" id="formSuccessMessageWrap">
                    <div class="notification-box green-box">
                        <h4>YOUR MESSAGE HAS BEEN SENT!</h4>
                        <a href="#" class="close-notification">x</a>
                        <div class="clear"></div>
                        <p>
                            You're message has been successfully sent. Please allow up to 48 hours for us to reply!  
                        </p>  
                    </div> 
                </div>
            
                
                
                
                
                <form id="formid" method="post" action="upload_sell_do_su.php" enctype="multipart/form-data">
   
                    <fieldset>
                    
                        <?php
                                foreach ($params as $p => $v)
                                      echo "        <input type=\"hidden\" name=\"{$p}\" value=\"{$v}\" />\n";
                            ?>
                        
                       		<div>
                                1.闲置图片:<font color="blue"><br>(若图片大于1.5M，请压缩后上传,否则闲置君不会给你发的呦~)</font>
                                <br/>
                                <br/>
                                <input type="hidden" name="MAX_FILE_SIZE" value="1500000">
                                <input type="file" name="file" accept="image/*" multiple />
                                <br/>
                        	</div>
                        
                            <font color="blue">由于技术限制，请勿在以下空格中填写单双引号~<br><br></font>    
                            2. 闲置名称: 
                                <br/>
                            <input type="text" name="name" class="contactField requiredField"/>
                           
                                <br/>
                            3. 闲置价格:
                                <br>
                            <input type="text" name="price" class="contactField requiredField"/>
                            
                                <br/>
                            4. 闲置描述:
                                <br>
                                
                            <input type="text" name="description" class="contactField requiredField"/>
                            
                                <br/>
                            5. 我的联系方式:
                                <br/>
                            <input type="text" name="phone" class="contactField requiredField"/>
                            
                                <br/>
                        <div>
                            6. 学号：
                                <br/>
                            <input type="text" name="student_id" class="contactField requiredField"/>
                        </div>
                        <div>
                            7. 姓名：
                                <br/>
                            <input type="text" name="student_name" class="contactField requiredField"/>
                        </div>
                        <div>
                            8. 系别：
                                <br/>
                            <input type="text" name="student_class" class="contactField requiredField"/>
                        </div>
                                <br/>
                        <div>
                            9. 闲置类别: 
                                <br/>
                        	<div class="button-holder">
                            <input type="radio" name="type" id="radio-1-1" value="书籍" class="regular-radio"checked />
                                <label for="radio-1-1"></label>
                            闲置书籍（教材、课外阅读等）
                            <br />
                            <input type="radio" name="type" id="radio-1-2" value="数码" class="regular-radio" />
                                <label for="radio-1-2"></label>
                            数码及配件（电脑、手机等）
                            <br/>
                            <input type="radio" name="type" value="衣服" id="radio-1-3" class="regular-radio" />
                                <label for="radio-1-3"></label>
                            鞋服配饰（衣服、鞋帽、包袋、首饰等）
                            <br/>     
                            <input type="radio" name="type" value="日用品" id="radio-1-4" class="regular-radio" />
                                <label for="radio-1-4"></label>
                            家居日用（护肤品、杯具、体重秤等）
                            <br/> 
                            <input type="radio" name="type" value="电器" id="radio-1-5" class="regular-radio" />
                                <label for="radio-1-5"></label>
                            家用电器（洗衣机、台灯、热水壶等）
                            <br/> 
                            <input type="radio" name="type" value="文体" id="radio-1-6" class="regular-radio" />
                                <label for="radio-1-6"></label>
                            文体用品（健身器材、自行车、乐器、文具等）
                            <br/>
                            <input type="radio" name="type" value="其他"  class="regular-radio" id="radio-1-7" />
                                <label for="radio-1-7"></label>
                            其他（礼物、交通卡、明信片、门票等）
                        </div>
                        </div>
                        <br/>
                        	<div class="formSubmitButtonErrorsWrap">
                                <input type="button" value="上传&提交~" class="buttonWrap button-minimal grey-minimal contactSubmitButton" onClick="checkStart()" />
                            </div>                                
                                 
                                
                            
                        </fieldset>
					</form> 
                <script> 
                            
                            function checkStart(){ 
                            
                                check(formid); 
                            
                            } 
                            
                          	function check(form) { 
                                for (i=0;i<form.length;i++){ 
                                    if(form.elements[i].value == ""){ 
                                       alert("不能有空着的选项不填呦~"); 
                                       form.elements[i].focus(); 
                                       return; 
                                   } 
                               } 
                               form.submit(); 
                            } 
                </script>
            </div>
        </div>              
    <div class="decoration"></div>
</div>

<div class="footer">
    <div class="small-navigation-icons">

        <div class="clear"></div>
    </div>
    <p class="copyright">COPYRIGHT 2016 <a href="http://mp.weixin.qq.com/mp/getmasssendmsg?__biz=MzA3MTg1OTU3NQ==#wechat_webview_type=1&wechat_redirect">@中大闲置</a> 提供技术支持</p>
</div>



</body>
</html>