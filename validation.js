// Simple Javascript function to validate the form (not nulls)
const validateForm = () => {
    if (document.getElementById('username').value == "") {
        alert("El username no puede estar vacío.");
        return false;
    }
    if (document.getElementById('password').value == "") {
        alert("La contraseña no puede estar vacía.");
        return false;
    }
    if (document.getElementById('SAMLRequest').value == "" || document.getElementById('RelayState').value == "") {
        alert("Petición incorrecta.");
        return false;
    }
}