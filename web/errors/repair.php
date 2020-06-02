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
if ($line1 != '1')
 {
  header ('Location: http://fgs.pp.ua/');
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
    <title>FGS - Технические Работы</title><?=$scrollbar;?>
	<meta charset="utf-8">
    <script src="/scripts/uo91lGWcyh.js" type="text/javascript"></script>
    <script src="//vk.com/js/api/openapi.js?115" type="text/javascript"></script><?=$mouse_right_button;?>
    </head>
<body <?=$fgs_copy;?>>
    <div style="width=100%;height=100%;"></div>
    <center><div style="color: blue; font-family: Arial; position: relative"><noscript> 
			В вашем браузере выключен / отсутсвует JavaScript, который нужен для просмотра сайта. Инструкции по включению в разных браузерах - http://www.enable-javascript.com.
	</noscript></center></div>
    <script src="/scripts/help.js" type="text/javascript"></script> <script src="/scripts/google_analitic.js" type="text/javascript"></script> <script src="/scripts/Free%20Games.js" type="text/javascript"></script> <script src="/scripts/Design.js" type="text/javascript"></script><script src="//vk.com/js/api/openapi.js?115" type="text/javascript"></script>
    <center><div style="position:relative;top:-2px; z-index:2;">
        <br />
        <font face="Arial" color = "white" size = 7>Технические работы</font><br />
        <font face="Arial" color = "white">На нашем сайте ведуться технические работы.<br />
        Зайдите на сайт позже.</font>
    </div></center><?=$snow;?>
    <br />
</body>
</html>