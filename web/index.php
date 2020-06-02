<?
$fp = fopen('http://fgs.pp.ua/admin/x3S.UOus1.txt', 'r+');
$Doctype_html = fgets ($fp);
$logo = $_SERVER['SERVER_NAME'];
if ($logo != "fgs.pp.ua") header("Location: http://fgs.pp.ua");
?>
<?=$Doctype_html?>

<html>
<?
$fp = fopen('http://fgs.pp.ua/admin/Gpjkl.txt', 'r+');
$line1 = fgets ($fp);
if ($line1 == '1')
 {
  header ('Location: http://fgs.pp.ua/errors/repair.php');
 }
$fp = fopen('http://fgs.pp.ua/admin/VxVbt3kYxK.txt', 'r+');
$line1 = fgets ($fp);
if ($line1 == '1')
 {
  $fgs_copy = 'oncopy="return false;"';
 }
$fp = fopen('http://fgs.pp.ua/admin/49gfrboI1a.txt', 'r+');
$line1 = fgets ($fp);
if ($line1 == '1')
 {
  $mouse_right_button = '<script type="text/javascript">document.write("<script src=\"\/scripts\/mb.js\" type=\"text\/javascript\"><\/script>");</script>';
 }
$fp = fopen('http://fgs.pp.ua/admin/UgKnCBE.txt', 'r+');
$line1 = fgets ($fp);
if ($line1 == '1')
 {
  $snow = '<script src="/scripts/TbdLcBqFQ724UmmaIkqoDp5tl.js" type="text/javascript"></script>';
 }
$fp = fopen('http://fgs.pp.ua/admin/DjOj0KPvAVKZYczJG.txt', 'r+');
$line1 = fgets ($fp);
if ($line1 == '1')
 {
  $scrollbar = '<script src="/scripts/site_create.js" type="text/javascript"></script>
<link rel="stylesheet" href="/styles/overflow.css" type="text/css"/>';
 }
?>

<head>
    <title>FGS - Главная страница</title><?=$scrollbar;?>
	<meta charset="utf-8">
    <meta name="openstat-verification" content="795309c61b993142dc13158360917e1a6f81888b" />
	
    <script src="/scripts/uo91lGWcyh.js" type="text/javascript"></script>
    <script src="//vk.com/js/api/openapi.js?115" type="text/javascript"></script><?=$mouse_right_button;?>
    </head>

<body <?=$fgs_copy;?>>
    <center><div style="color: blue; font-family: Arial; position: relative"><noscript> 
			В вашем браузере выключен / отсутсвует JavaScript, который нужен для просмотра сайта. Инструкции по включению в разных браузерах - http://www.enable-javascript.com.
	</noscript></center></div>
	<script src="/scripts/help.js" type="text/javascript"></script> <script src="/scripts/google_analitic.js" type="text/javascript"></script> <script src="/scripts/Free%20Games.js" type="text/javascript"></script> <script src="/scripts/Design.js" type="text/javascript"></script><br />
    <center>
		<div style="color: white; font-family: Arial; position: relative">
			Наше интро :
		</div>
		<br />

		<div style="position: relative; z-index=2;">
			<iframe frameborder="0" height="315" src=
			"//www.youtube.com/embed/BqOSNEVfUt0?rel=0" width="560"></iframe><br />
		</div>

		<div style="position: relative; z-index=2;">
			<font color="white" face="Arial">Наш почтовый ящик :<br /></font>
			<a href=
			"mailto:freegamesstudio@yandex.ru"><big>freegamesstudio@yandex.ru</big></a>
		</div><br />
		<script src="/scripts/plus_vidjet.js" type="text/javascript"></script>

		<div class="pluso" data-background="none;" data-options=
		"medium,square,line,horizontal,counter,sepcounter=1,theme=14"
		data-services="vkontakte,odnoklassniki,facebook,twitter,google,moimir,livejournal,yandex,liveinternet,bobrdobr,email">
		</div><br />
	</center>
    <?=$snow;?>
    </body>
</html>