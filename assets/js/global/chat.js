function ajax() {
    let req = new XMLHttpRequest();
    req.onreadystatechange = function(){

        if (req.readyState == 4 && req.status == 200) {
            document.getElementById('chat').innerHTML = req.responseText;
        }
    }
    req.open('GET', '../../../php/global/chat.php', true);
    req.send();
}
setInterval(function(){ajax();}, 1000);