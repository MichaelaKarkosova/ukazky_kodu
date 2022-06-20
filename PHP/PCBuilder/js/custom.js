   function zdroje()
    {
        window.location.href = "./spotreba.php";
    }
    function zdrojhodnoceni()
    {
        window.location.href = "./rate.php";
    }
    function show(str, type) {
    var xhttp;
    if (str == '') {
    document.getElementById('specify2').innerHTML = '';
    return;
}
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
    console.log(this.responseText+' '+this.readyState+' '+this.status);
    if (this.readyState == 4 && this.status == 200) {
    document.getElementById('specify').innerHTML = this.responseText;
}
}
    ;

    xhttp.open('GET', 'naseptavac.php?type='+type+'&specify2='+str, true);
    xhttp.send();
}
