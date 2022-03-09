function confirmx() {
    var mail = document.getElementById("mail").value;
    var password = document.getElementById("password").value;
    if (mail == '' && password == '') {
        alert('Podaj dane do zmiany');
        return false;
    }
    if (mail != '') {
        if (/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(mail) == false) {
            alert('Niepoprawny mail');
            return false;
        }
    }
    if (password != '') {
        if (/[A-Z]/.test(password) == false || /[a-z]/.test(password) == false || /[0-9]/.test(password) == false || (password.length) < 6 || (password.length) > 20) {
            alert('Niepoprawne hasło');
            return false;
        }
    }
}

function show() {
    if ($('#password').attr("type") == "text") $('#password').attr("type", "password");
    else $('#password').attr("type", "text");
}

function titleCh(x) {
    var title = $.trim($('#title' + x).val());
    if (title.length < 3 || title.length > 100) {
        alert("Tytuł musi mieć długość od 3 do 100 znaków");
        return false;
    } else return true;
}

function albsure() {
    var conf = confirm("Czy na pewno skasować album? Tego nie da się cofnąć!");
    {
        if (conf == true) {
            return true;
        } else return false;
    }
}

function fotsure() {
    var conf = confirm("Czy na pewno skasować zdjęcie? Tego nie da się cofnąć!");
    {
        if (conf == true) {
            return true;
        } else return false;
    }
}

function comsure() {
    var conf = confirm("Czy na pewno skasować komentarz? Tego nie da się cofnąć!");
    {
        if (conf == true) {
            return true;
        } else return false;
    }
}

function deluser() {
    var conf = confirm("Czy na pewno usunąć użytkownika? Tego nie da się cofnąć!");
    {
        if (conf == true) {
            return true;
        } else return false;
    }
}

function delalbs() {
    var conf = confirm("Czy na pewno usunąć album? Tego nie da się cofnąć!");
    {
        if (conf == true) {
            return true;
        } else return false;
    }
}

function chAlbT() {
    var title = $.trim($('#opisek').val());
    if (title.length < 3 || title.length > 100) {
        alert("Tytuł musi mieć długość od 3 do 100 znaków");
        return false;
    } else return true;
}


