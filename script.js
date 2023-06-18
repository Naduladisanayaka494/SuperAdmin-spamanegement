function toggleDropdown() {
    document.getElementById("dropdown").style.display = "block";
    document.getElementById("text-field").style.display = "none";
    document.getElementById("text-value").value = "";
}

function toggleTextField() {
    document.getElementById("dropdown").style.display = "none";
    document.getElementById("text-field").style.display = "block";

    var serviceType = document.querySelector('input[name="service-type"]:checked').value;
    var textValue = "";

    if (serviceType === "Normal") {
        textValue = "1500";
    } else if (serviceType === "Oil") {
        textValue = "2000";
    }

    document.getElementById("text-value").value = textValue;
}
