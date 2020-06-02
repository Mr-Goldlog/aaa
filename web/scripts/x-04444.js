document.write("<div class=\"new-select-style-wpandyou\" style=\"position: relative; top: 20px; \">");
document.write("<select id='Select' onChange=\"if(value!=''){location=value}else{options[selectedIndex=0];}\">");
document.write("<option value=\"http:\/\/fgs.pp.ua\/games\/\">Выберите платформу<\/option>");
document.write("<optgroup label=\"-ОПЕРАЦИОННЫЕ СИСТЕМЫ-\"><\/optgroup>");
document.write("<option value=\"Windows\">Windows<\/option>");
document.write("<option value=\"Ubuntu\">Ubuntu (Linux)<\/option>");
document.write("<option value=\"Mac ОS X\">Mac ОS X<\/option>");
document.write("<optgroup label=\"-МОБИЛЬНЫЕ ПЛАТФОРМЫ-\"><\/optgroup>");
document.write("<option value=\"Android\">Android<\/option>");
document.write("<option value=\"iOS\">iOS<\/option>");
document.write("<option value=\"Tizen\">Tizen<\/option>");
document.write("<optgroup label=\"-КОНСОЛИ-\"><\/optgroup>");
document.write("<option value=\"Xbox One\">Xbox One<\/option>");
document.write("<option value=\"PlayStation 4\">PlayStation 4<\/option>");
document.write("<option value=\"PlayStation Vita\">PlayStation Vita<\/option>");
document.write("<option value=\"PlayStation 3\">PlayStation 3<\/option>");
document.write("<optgroup label=\"-ДРУГОЕ-\"><\/optgroup>");
document.write("<option value=\"Online\">Онлайн<\/option>");
document.write("<\/select>");
document.write("<\/div>");

var objSel = document.getElementById("Select");
if (document.URL == "http://fgs.pp.ua/games/") {
    objSel.selectedIndex = 0;
} else
if (document.URL == "http://fgs.pp.ua/games/Windows") {
    objSel.selectedIndex = 1;
} else
if (document.URL == "http://fgs.pp.ua/games/Ubuntu") {
    objSel.selectedIndex = 2;
} else
if (document.URL == "http://fgs.pp.ua/games/Android") {
    objSel.selectedIndex = 4;
} else
if (document.URL == "http://fgs.pp.ua/games/iOS") {
    objSel.selectedIndex = 5;
} else
if (document.URL == "http://fgs.pp.ua/games/Tizen") {
    objSel.selectedIndex = 6;
} else
if (document.URL == "http://fgs.pp.ua/games/Xbox%20One") {
    objSel.selectedIndex = 7;
} else
if (document.URL == "http://fgs.pp.ua/games/PlayStation%204") {
    objSel.selectedIndex = 8;
} else
if (document.URL == "http://fgs.pp.ua/games/PlayStation%20Vita") {
    objSel.selectedIndex = 9;
} else
if (document.URL == "http://fgs.pp.ua/games/PlayStation%203") {
    objSel.selectedIndex = 10;
} else
if (document.URL == "http://fgs.pp.ua/games/Online") {
    objSel.selectedIndex = 11;
} else objSel.selectedIndex = 3;