//CHECK A CHECKBOX
function check(id) {
    document.getElementById(id).checked = true;
}
//UNCHECK A CHECKBOX
function uncheck(id) {
    document.getElementById(id).checked = false;
}

function getEventDetails(str) {
    // event.preventDefault();
    //hide_div("new_screen_div");
    // document.getElementById('modal-edit').style.display = "block";
    // console.log("hello ajax");
    if (str === "") {
        document.getElementById("txtHint").innerHTML = "";
        return;
    } else {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("modal_body").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "event_details.php?q=" + str, true);
        xmlhttp.send();
    }
}