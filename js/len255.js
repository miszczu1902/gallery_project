function chkLen() {
    var len = $("#ds").val();
    if (len.length > 255) {
        alert("Za długi opis zdjęcia");
        return false;
    }
}