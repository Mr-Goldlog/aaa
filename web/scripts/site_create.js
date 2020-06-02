document.body.onkeydown = function(e) {
    e = e || window.event;
    var c = e.keyCode;
    if (c > 36 && c < 41 || c > 32 && c < 37) return false;
}