<?
header('Content-Type: text/html; charset=utf-8');
$host = $_SERVER['HTTP_HOST'];
setlocale(LC_TIME, "ru_RU.utf8");
date_default_timezone_set('Europe/Kiev');
$startdir = '.';
$showthumbnails = false; 
$showdirs = true;
$forcedownloads = false;
$hide = array(

			);
$displayindex = false;
$allowuploads = false;
$overwrite = false;
$indexfiles = array (
				'index.html',
				'index.htm',
				'default.htm',
				'default.html'
			);
$filetypes = array (
				'png' => 'jpg.gif',
				'jpeg' => 'jpg.gif',
				'bmp' => 'jpg.gif',
				'jpg' => 'jpg.gif', 
				'gif' => 'gif.gif',
				'zip' => 'archive.png',
				'rar' => 'archive.png',
				'exe' => 'exe.gif',
				'setup' => 'setup.gif',
				'txt' => 'text.png',
				'htm' => 'html.gif',
				'html' => 'html.gif',
				'php' => 'php.gif',				
				'fla' => 'fla.gif',
				'swf' => 'swf.gif',
				'xls' => 'xls.gif',
				'doc' => 'doc.gif',
				'sig' => 'sig.gif',
				'fh10' => 'fh10.gif',
				'pdf' => 'pdf.gif',
				'psd' => 'psd.gif',
				'rm' => 'real.gif',
				'mpg' => 'video.gif',
				'mpeg' => 'video.gif',
				'mov' => 'video2.gif',
				'avi' => 'video.gif',
				'eps' => 'eps.gif',
				'gz' => 'archive.png',
				'asc' => 'sig.gif',
			);	
error_reporting(0);
if(!function_exists('imagecreatetruecolor')) $showthumbnails = false;
$leadon = $startdir;
if($leadon=='.') $leadon = '';
if((substr($leadon, -1, 1)!='/') && $leadon!='') $leadon = $leadon . '/';
$startdir = $leadon;
if($_GET['dir']) {
	if(substr($_GET['dir'], -1, 1)!='/') {
		$_GET['dir'] = $_GET['dir'] . '/';
	}
	$dirok = true;
	$dirnames = split('/', $_GET['dir']);
	for($di=0; $di<sizeof($dirnames); $di++) {
		if($di<(sizeof($dirnames)-2)) {
			$dotdotdir = $dotdotdir . $dirnames[$di] . '/';
		}
		if($dirnames[$di] == '..') {
			$dirok = false;
		}
	}
	if(substr($_GET['dir'], 0, 1)=='/') {
		$dirok = false;
	}
	if($dirok) {
		 $leadon = $leadon . $_GET['dir'];
	}
}
$opendir = $leadon;
if(!$leadon) $opendir = '.';
if(!file_exists($opendir)) {
	$opendir = '.';
	$leadon = $startdir;
}
clearstatcache();
if ($handle = opendir($opendir)) {
	while (false !== ($file = readdir($handle))) { 
		if ($file == "." || $file == "..")  continue;
		$discard = false;
		for($hi=0;$hi<sizeof($hide);$hi++) {
			if(strpos($file, $hide[$hi])!==false) {
				$discard = true;
			}
		}
		if($discard) continue;
		if (@filetype($leadon.$file) == "dir") {
			if(!$showdirs) continue;
			$n++;
			if($_GET['sort']=="date") {
				$key = @filemtime($leadon.$file) . ".$n";
			}
			else {
				$key = $n;
			}
			$dirs[$key] = $file . "/";
		}
		else {
			$n++;
			if($_GET['sort']=="date") {
				$key = @filemtime($leadon.$file) . ".$n";
			}
			elseif($_GET['sort']=="size") {
				$key = @filesize($leadon.$file) . ".$n";
			}
			else {
				$key = $n;
			}
			$files[$key] = $file;
			
			if($displayindex) {
				if(in_array(strtolower($file), $indexfiles)) {
					header("Location: $file");
					die();
				}
			}
		}
	}
	closedir($handle); 
}
if($_GET['sort']=="date") {
	@ksort($dirs, SORT_NUMERIC);
	@ksort($files, SORT_NUMERIC);
}
elseif($_GET['sort']=="size") {
	@natcasesort($dirs); 
	@ksort($files, SORT_NUMERIC);
}
else {
	@natcasesort($dirs); 
	@natcasesort($files);
}
if($_GET['order']=="desc" && $_GET['sort']!="size") {$dirs = @array_reverse($dirs);}
if($_GET['order']=="desc") {$files = @array_reverse($files);}
$dirs = @array_values($dirs); $files = @array_values($files);
?>
<?
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
<?
$fp = fopen('http://fgs.pp.ua/admin/x3S.UOus1.txt', 'r+');
$Doctype_html = fgets ($fp);
$logo = $_SERVER['SERVER_NAME'];
if ($logo != "fgs.pp.ua") header("Location: http://fgs.pp.ua");
?>
<?=$Doctype_html?>

<html>
	<script src="/scripts/FGS.js" type="text/javascript"></script>
<head>
	<title>FGS - Панель администратора</title>
	<meta charset="utf-8">
	<script src="/scripts/uo91lGWcyh.js" type="text/javascript"></script>
	<script src="//vk.com/js/api/openapi.js?115" type="text/javascript"></script>
	<?=$mouse_right_button;?>
	<script src="/scripts/help.js" type="text/javascript"></script>
	<script src="/scripts/google_analitic.js" type="text/javascript"></script>
	<script src="/scripts/Free Games.js" type="text/javascript"></script>
	<link href="/styles/f6hwsd2k_!gs7()jd.css" media="screen" rel="stylesheet" type="text/css" />
	<link href="/styles/checkboxs.css" media="screen" rel="stylesheet" type="text/css" />
	<link href="/styles/butons.css" media="screen" rel="stylesheet" type="text/css" />
</head>
<body <?=$fgs_copy;?>>
	<center><div style="color: blue; font-family: Arial; position: relative"><noscript> 
		В вашем браузере выключен / отсутсвует JavaScript, который нужен для просмотра сайта. Инструкции по включению в разных браузерах - http://www.enable-javascript.com.
	</noscript></center></div>
	<div id="main">
		<div class="content">
		<br><center><font face="Arial" color = "white"><div style="color: white; position: relative"><b>Панель управления сайтом</b></div></font></center></br>
		<center><div id="files" style = "position : relative; width: 100%;">
			<div class="top"style = "position : relative; width: 100%;"></div>
			<div class="cont"style = "position : relative; width: 100%;">
				<div id="listingcontainer"style = "position : relative; width: 50%;">
					<div id="listing"style = "position : relative; width: 100%;">
<?
  $st1 = '<script type="text/javascript">document.write("';
  $st2 = '");</script>';
  $class = 'b';
  if($dirok) {
?>
<?=$st1;?><div><a href=\"<?=$dotdotdir;?>\/\" class=\"<?=$class;?>\"><img src=\"http:\/\/www.main-hosting.com\/hostinger\/welcome\/index\/dirup.png\" alt=\"Folder\" \/><strong>..<\/strong> <em>-<\/em><? $mtime = filemtime($dotdotdir); $mtime = date("m/d/Y H:i:s", $mtime); $mtime = strftime("%B %e, %G %T", strtotime($mtime)); print ucfirst($mtime); ?><\/a><\/div><?=$st2;?>
<?
  $st1 = '<script type="text/javascript">document.write("';
  $st2 = '");</script>';
  if($class=='b') $class='w';
  else $class = 'b';
  }
  $arsize = sizeof($dirs);
  for($i=0;$i<$arsize;$i++) {
?>
<?=$st1;?><div><a href=\"<?=$leadon.$dirs[$i];?>\" class=\"<?=$class;?>\"><img src=\"http:\/\/www.main-hosting.com\/hostinger\/welcome\/index\/folder.png\" alt=\"<?=$dirs[$i];?>\/\" \/><strong><?=$dirs[$i];?><\/strong> <em>-<\/em><? $mtime = filemtime($leadon.$dirs[$i]); $mtime = date("m/d/Y H:i:s", $mtime); $mtime = strftime("%B %e, %G %T", strtotime($mtime)); print ucfirst($mtime); ?><\/a><\/div><?=$st2;?>
<?
  if($class=='b') $class='w';
  else $class = 'b';	
  }
  $arsize = sizeof($files);
  for($i=0;$i<$arsize;$i++) {
    $icon = 'unknown.png';
    $ext = strtolower(substr($files[$i], strrpos($files[$i], '.')+1));
    $supportedimages = array('gif', 'png', 'jpeg', 'jpg');
    $thumb = '';
    if($filetypes[$ext]) {
     $icon = $filetypes[$ext];
    }
    $filename = $files[$i];
    if(strlen($filename)>43) {
     $filename = substr($files[$i], 0, 40) . '...';
    }
    $fileurl = $leadon . $files[$i];
	$st1 = '<script type="text/javascript">document.write("';
	$st2 = '");</script>';
?>
<?=$st1;?><div><a href=\"<?=$fileurl;?>\" class=\"<?=$class;?>\"<?=$thumb2;?>><img src=\"http:\/\/fgs.pp.ua\/images\/<?=$icon;?>\" alt=\"<?=$files[$i];?>\" \/><strong><?=$filename;?><\/strong><em><?=round(filesize($leadon.$files[$i])/1024);?> KB<\/em><? $mtime = filemtime($leadon.$files[$i]); $mtime = date("m/d/Y H:i:s", $mtime); $mtime = strftime("%B %e, %G %T", strtotime($mtime)); print ucfirst($mtime); ?><?=$thumb;?><\/a><\/div><?=$st2;?>
<?
  if($class=='b') $class='w';
  else $class = 'b';	
  }	
?>
									</div>
								</div>
							</div>
						<div class="bottom"></div>
						<div class="clear"></div>
					</div></center>
					<div class="clear"></div>
				</div>
				<div class="footer"></div>
				<div class="clear"></div>
				</div>
			</div>
		</div>
	</div>
<?
$gh1 = "'";
$fp = fopen('http://fgs.pp.ua/admin/Gpjkl.txt', 'r+');
$fp2 = fopen('http://fgs.pp.ua/admin/VxVbt3kYxK.txt', 'r+');
$fp3 = fopen('http://fgs.pp.ua/admin/49gfrboI1a.txt', 'r+');
$fp4 = fopen('http://fgs.pp.ua/admin/UgKnCBE.txt', 'r+');
$fp5 = fopen('http://fgs.pp.ua/admin/DjOj0KPvAVKZYczJG.txt', 'r+');
$fp6 = file('http://fgs.pp.ua/admin/x3S.UOus1.txt');
foreach ($fp6 as $line0)
 {   
   $Doctype_html = $line0;
 }
$line1 = fgets ($fp);
if ($line1 == '1')
 {
  $checked_1 = 'checked="checked"';
 } else
 {
  $checked_1 = '';
 }
$line2 = fgets ($fp2);
if ($line2 == '1')
 {
  $checked_2 = 'checked="checked"';
 } else
 {
  $checked_2 = '';
 }
$line3 = fgets ($fp3);
if ($line3 == '1')
 {
  $checked_3 = 'checked="checked"';
 } else
 {
  $checked_3 = '';
 }
$line4 = fgets ($fp4);
if ($line4 == '1')
 {
  $checked_4 = 'checked="checked"';
 } else
 {
  $checked_4 = '';
 }
$line5 = fgets ($fp5);
if ($line5 == '1')
 {
  $checked_5 = 'checked="checked"';
 } else
 {
  $checked_5 = '';
 }
?>
	<form action = "/admin/sH+-4KSN(mZcAE6y9a;YnrlB==sLI4EbWti&[9vrEHWEZvJU=HwFUWqIq[nmN;01buI;zrv;wS~KGxGByF=7;PxVyJ(dyhzP+rC+JY8BOuaICE)NqVxrFRr~(pYRc9fH;AhyO0ne.php" method = "post">
		<div style = "position : relative; z-index:2;">
			<input type="checkbox" <?=$checked_1;?> name="chec1" id="chec1"/><label for="chec1"><font face="Arial" color = "white">Запретить вход на сайт (Причина : тех. работы)</font></label></input><br />
			<input type="checkbox" <?=$checked_2;?> name="chec2" id="chec2"/><label for="chec2"><font face="Arial" color = "white">Запретить копировать</font></label></input><br>
			<input type="checkbox" <?=$checked_3;?> name="chec3" id="chec3"/><label for="chec3"><font face="Arial" color = "white">Заблокировать правую кнопку мыши</font></label></input><br />
			<input type="checkbox" <?=$checked_5;?> name="chec5" id="chec5"/><label for="chec5"><font face="Arial" color = "white">Выключить scrollbars на страницах с нормальным размером</font></label></input><br />
			<input type="checkbox" <?=$checked_4;?> name="chec4" id="chec4"/><label for="chec4"><font face="Arial" color = "white">Включить снег</font></label></input><br />
			<label><font face="Arial" color = "white">DOCTYPE для всех страниц : </font></label><input type="text" name="text1" id="text1" value=<?=$gh1?><?=$Doctype_html?><?=$gh1?> style="width:400px;"/>
			<center><input type="submit" name="formSubmit" value="Сохранить"/></center>
		</div>
	</form>
<?=$snow;?>
</body>
</html>