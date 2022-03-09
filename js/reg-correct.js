function chk() {
    var login = document.getElementById("r1").value;
    var haslo = document.getElementById("r2").value;
    var phaslo = document.getElementById("r3").value;
    var mail = document.getElementById("r4").value;
    if (/^[A-Za-z0-9]{6,20}$/.test(login) == true) {
        if (/[A-Z]/.test(haslo) == true && /[a-z]/.test(haslo) == true && /[0-9]/.test(haslo) == true && (haslo.length) >= 6 && (haslo.length) <= 20) {
            if (phaslo == haslo) {
                if (/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(mail) == true) {
                    return true;
                } else {
                    alert("Zły mail");
                    return false;
                }
            } else {
                alert("Hasła się nie zgadzają");
                return false;
            }
        } else {
            alert("Złe hasło");
            return false;
        }
    } else {
        alert("Niepoprawny login");
        return false;
    }
}
