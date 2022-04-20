<?php

include "inc.php";
// Reading the HTTP Request
$request = \Symfony\Component\HttpFoundation\Request::createFromGlobals();
?>

<! –– Simple form HTML for login––>
<h2>Inicio de sesión</h2>

<script src="validation.js"></script>
<noscript>"Tu navegador es obsoleto o no tiene Javascript activo."</noscript>

<form id="formul" action="post-saml.php" onsubmit="return validateForm()">
    <label for="username">Usuario:</label>
    <input id="username" name="username" type="text">

    <label for="password">Contraseña:</label>
    <input type="password" id="password" name="password">
    <br>

    <?php
        if(isset($_GET['fail'])){
            echo '<p style="color:red">Credenciales incorrectos.<p>';
        }
    ?>

    <input id="enviar" type="submit" value="Enviar datos">
    <input id="borrar" type="reset" value="Borrar datos">

    <input type="hidden" id="SAMLRequest" name="SAMLRequest" value="<?php print $request->get("SAMLRequest") ?>">
    <input type="hidden" id="RelayState" name="RelayState" value="<?php print $request->get("RelayState") ?>">
</form>
