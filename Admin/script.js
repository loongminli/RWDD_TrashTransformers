function checkStaffForm() {
    var form = document.querySelector(".staff-form");
    var inputs = form.querySelectorAll("input, select");

    for (var i = 0; i < inputs.length; i++) {
        if (inputs[i].hasAttribute("required") && inputs[i].value.trim() == "") {
            alert("Please fill in all required information!");
            return false;
        }
    }

    return true;
}