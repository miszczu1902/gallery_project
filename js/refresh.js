function handleSelect(elm) {
    window.location = "dodaj-foto.php?alb=" + elm.value;
}

function filterSelect(elm) {
    window.location = "galeria.php?strona=1&filter=" + elm.value;

}