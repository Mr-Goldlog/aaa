<?php
$logo = $_SERVER['SERVER_NAME'];
if ($logo != "fgs.pp.ua") header("Location: http://fgs.pp.ua");
$fp = fopen('Gpjkl.txt', 'r+');
$fp2 = fopen('VxVbt3kYxK.txt', 'r+');
$fp3 = fopen('49gfrboI1a.txt', 'r+');
$fp4 = fopen('UgKnCBE.txt', 'r+');
$fp5 = fopen('DjOj0KPvAVKZYczJG.txt', 'r+');
$fp6 = fopen('x3S.UOus1.txt', 'r+');
if(isset($_POST['chec1']))
{
    echo "Вход на сайт запрещен.";
	$t = "1";
}
else
{
    echo "Вход на сайт не запрещен.";
	$t = "0";
}
if(isset($_POST['chec2']))
{
    echo "Копирование запрещено.";
	$t2 = "1";
}
else
{
    echo "Копирование разрешено.";
	$t2 = "0";
}
if(isset($_POST['chec3']))
{
    echo "Правая кнопка мыши заблокирована.";
	$t3 = "1";
}
else
{
    echo "Правая кнопка мыши разблокирована.";
	$t3 = "0";
}
if(isset($_POST['chec4']))
{
    echo "Снег идет.";
	$t4 = "1";
}
else
{
    echo "Снег не идет.";
	$t4 = "0";
}
if(isset($_POST['chec5']))
{
    echo "Scrollbars отключены.";
	$t5 = "1";
}
else
{
    echo "Scrollbars отображаются на всех страницах.";
	$t5 = "0";
}
$t6 = $_POST['text1'];
$test = fwrite($fp, $t);
$test = fwrite($fp2, $t2);
$test = fwrite($fp3, $t3);
$test = fwrite($fp4, $t4);
$test = fwrite($fp5, $t5);
$test = fwrite($fp6, $t6);
header ('Location: http://fgs.pp.ua/W;BgSN&&Ml0bLgv4OLrWHq;+r)S8chLmHGS7-jzRX%5EuebBftOgSSmis;;%5EVW(QVBtK[HsIrpJQY~zxY7x2-;r[eDg]r~Pa7nUJI8zzqX1t]Uv-(A]tst]ifs()sKM8=rSa0oL-AZ.php');
?>