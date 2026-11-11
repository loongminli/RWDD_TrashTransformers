document.querySelectorAll(".number").forEach(element => {
    if (element.textContent.trim() === "0") {
        element.style.backgroundColor = "greenyellow";
        element.style.borderColor = "green";
    } else {
        element.style.backgroundColor = "red";
        element.style.borderColor = "darkred";
    }
});