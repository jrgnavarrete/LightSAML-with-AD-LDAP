// Simple Javascript function to validate the form (not nulls)
const validateForm = () => {
    if (document.getElementById('username').value == "") {
        alert("El nombre de usuario o correo electrónico no puede estar vacío.");
        return false;
    }
    if (document.getElementById('password').value == "") {
        alert("La contraseña no puede estar vacía.");
        return false;
    }
    if (document.getElementById('SAMLRequest').value == "" || document.getElementById('RelayState').value == "") {
        alert("Petición incorrecta debido a la petición de inicio de sesión.");
        return false;
    }
    var format = /[!#$%^&*()+\=\[\]{};':"\\|,<>\/?]+/;
    if(format.test(document.getElementById('SAMLRequest').value)){
        alert("No se permiten caracteres especiales, contacta con el administrador si tu nombre de usuario contiene alguno.");
        return false;
    }
}
