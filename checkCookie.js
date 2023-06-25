function getCookie(name) {
    var dc = document.cookie;
    var prefix = name + "=";
    var begin = dc.indexOf("; " + prefix);
    if (begin == -1) {
        begin = dc.indexOf(prefix);
        if (begin != 0) return null;
    }
    else
    {
        begin += 2;
        var end = document.cookie.indexOf(";", begin);
        if (end == -1) {
        end = dc.length;
        }
    }
    return decodeURI(dc.substring(begin + prefix.length, end));
  } 
//     function doSomething() {
//         var myCookie = getCookie("PHPSESSID");

//         if (myCookie == null) {
//             // do cookie doesn't exist stuff;
//             location.href = "/login/login.php";
//         }
//         else {
//             // do cookie exists stuff
//             location.href = "/eventManager/event-list.php"
//         }
//   }