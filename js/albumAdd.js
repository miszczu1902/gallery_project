function chkName() {
    al = $.trim($("#add ").val());
    if (al.length >= 3) {
        if (al.length <= 100) {
            return true;
        } else {
            alert("Za długa nazwa albumu");
            return false;
        }
    } else {
        alert("Za krótka nazwa albumu");
        return false;
    }
}
