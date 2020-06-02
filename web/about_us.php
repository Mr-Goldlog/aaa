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
    <title>FGS - О нас</title><?=$scrollbar;?>
	<meta charset="utf-8">

    <script src="/scripts/uo91lGWcyh.js" type="text/javascript"></script>
    <script src="//vk.com/js/api/openapi.js?115" type="text/javascript"></script><?=$mouse_right_button;?>
    </head>

<body <?=$fgs_copy;?>>
    <center><div style="color: blue; font-family: Arial; position: relative"><noscript> 
			В вашем браузере выключен / отсутсвует JavaScript, который нужен для просмотра сайта. Инструкции по включению в разных браузерах - http://www.enable-javascript.com.
	</noscript></center></div>
    <script src="/scripts/help.js" type="text/javascript"></script> <script src="/scripts/google_analitic.js" type="text/javascript"></script> <script src="/scripts/Free%20Games.js" type="text/javascript"></script> <script src="/scripts/Design.js" type="text/javascript"></script><br />
    <center>
		<div style="position: relative; z-index=2;"><font face="Arial" color = "white">
			Компания <b>Free Games Studio</b> создаёт игры,<br />
			которые вы можете скачать на Windows и другие ОС.<br />
			Основана в 2014 году.<br />
			<br />
			Список работников компании :<br />
			<b><a href="http://vk.com/id189352863" target="_blank">Константин
			Скороходов</a></b> - создатель, разработчик;<br />
			<b><a href="http://vk.com/id256443334" target="_blank">Денис
			Михайленко</a></b> - системный разработчик, управляющий сайтом;<br />
			<b><a href="http://vk.com/id191667016" target="_blank">Никита
			Фешкин</a></b> - художник пиксельной графики, разработчик;<br />
			<b><a href="http://vk.com/id220180012" target="_blank">Даниил
			Мухин</a></b> - дизайнер игровых проектов и сайта.<br />
			Список людей которые раньше работали в компании :<br />
			<b><a href="http://vk.com/id252742252" target="_blank">Максим
			Арбатов</a></b><br />
			<br />
		</font></div><script src="//vk.com/js/api/openapi.js?115" type="text/javascript"></script> <script type="text/javascript">
	VK.init({apiId: 5060159, onlyWidgets: true});
	</script>
    </center>
    <center>
		<div id="vk_like"></div><script>
	VK.Widgets.Like("vk_like", {type: "button", verb: 1, height: 20});
		</script>
	</center>
    <div style="width:135px; position:absolute; left:50%; margin-left:-75px;">
        <br />
        <a class="mrc__plugin_uber_like_button" data-mrc-config=
        "{'cm' : '1', 'sz' : '20', 'st' : '1', 'tp' : 'mm'}" href=
        "http://connect.mail.ru/share" target="_blank">Нравится</a>
        <script charset="UTF-8" src="http://cdn.connect.mail.ru/js/loader.js"
        type="text/javascript"></script>
    </div>

    <div style="width:105px; position:absolute; left:50%; margin-left:-70px;">
        <br />
        <br />
        <br />

        <div id="ok_shareWidget"></div><script src="/scripts/class.js"></script>
    </div><?=$snow;?>
    </body>
</html>