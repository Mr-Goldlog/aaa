﻿var openstat = {
    counter: 2376513,
    image: 5087,
    color: "458efc",
    next: openstat
};
(function(d, t, p) {
    var j = d.createElement(t);
    j.async = true;
    j.type = "text/javascript";
    j.src = ("https:" == p ? "https:" : "http:") + "//openstat.net/cnt.js";
    var s = d.getElementsByTagName(t)[0];
    s.parentNode.insertBefore(j, s);
})(document, "script", document.location.protocol);