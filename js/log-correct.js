function logchk() {
    var login = document.getElementById("l1").value;
    var haslo = document.getElementById("l2").value;

    if (/^[A-Za-z0-9]{6,20}$/.test(login) == true) {

        if (/[A-Z]/.test(haslo) == true && /[a-z]/.test(haslo) == true && /[0-9]/.test(haslo) == true && (haslo.length) >= 6 && (haslo.length) <= 20) {
            return true;
        } else {
            alert("Złe hasło");
            return false;
        }
    } else {
        alert("Zły login");
        return false;
    }
}