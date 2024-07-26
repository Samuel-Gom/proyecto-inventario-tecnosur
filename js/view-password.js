// CAMBIAR CAMPO DE PASSWORD A TEXT Y VICEVERSA - ARCHIVO INDEX.PHP
document.getElementById("view-password").addEventListener("click", function() {
    const passwordInput = document.getElementById("password");

    if (passwordInput.type === "password") {
        passwordInput.type = "text";
    } else {
        passwordInput.type = "password";
    }
});