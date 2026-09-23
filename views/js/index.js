function togglePassword(Id, button) {

    let field = document.getElementById(Id);

    if (field.type === "password") {
        field.type = "text";
        button.innerHTML = "Hide";
    }
    else {
        field.type = "password";
        button.innerHTML = "Show";
    }
}

