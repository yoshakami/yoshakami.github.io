if (window.location.pathname.endsWith("/index.html"))
{
    window.location.href = window.location.href.substring(0, window.location.href.length - 11);
}

function getCookie(cname) {
    let name = cname + "=";
    let decodedCookie = decodeURIComponent(document.cookie);
    let ca = decodedCookie.split(';');
    for(let i = 0; i <ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) === ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) === 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}
function use_https() {
    document.cookie = "protocol=https;expires=Fri, 18 Dec 2099 12:00:00 UTC";
    document.getElementById("footer-protocol").style.display = "none";
    if (window.location.protocol === "http:")
    {
        window.location.protocol = "https:";
    }
}
function use_http() {
    document.cookie = "protocol=http;expires=Fri, 18 Dec 2099 12:00:00 UTC";
    document.getElementById("footer-protocol").style.display = "none";
    if (window.location.protocol === "https:")
    {
        window.location.protocol = "http:";
    }
}