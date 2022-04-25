<!DOCTYPE html>
<html lang="en">

<?php
include "inc.php";
// Reading the HTTP Request
$request = \Symfony\Component\HttpFoundation\Request::createFromGlobals();
?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
	<link rel="stylesheet" href="styles/styleslogin.css" type="text/css">
</head>

<body>
<script type="text/javascript" src="validation.js"></script>
<div class="container">
	<div class="screen">
		<div class="screen__content">
			<form class="login" id="formul" action="post-saml.php" onsubmit="return validateForm()">
				<div class="login__field">
					<i class="login__icon fas fa-user"></i>
					<input type="text" id="username" name="username" class="login__input" placeholder="Nombre de usuario">
				</div>
				<div class="login__field">
					<i class="login__icon fas fa-lock"></i>
					<input type="password" id="password" name="password" class="login__input" placeholder="Contraseña">
				</div>

				<?php
					// If the username or password are wrong:
        			if(isset($_GET['fail'])){
            			echo '<p style="color:red">Credenciales incorrectos.<p>';
        			}
    			?>
				<button class="button login__submit">
					<span class="button__text">Iniciar sesión</span>
					<i class="button__icon fas fa-chevron-right"></i>
				</button>
				<input type="hidden" id="SAMLRequest" name="SAMLRequest" value="<?php print $request->get("SAMLRequest") ?>">
				<input type="hidden" id="RelayState" name="RelayState" value="<?php print $request->get("RelayState") ?>">				
			</form>
		</div>
		<div class="screen__background">
			<span class="screen__background__shape screen__background__shape4"></span>
			<span class="screen__background__shape screen__background__shape3"></span>		
			<span class="screen__background__shape screen__background__shape2"></span>
			<span class="screen__background__shape screen__background__shape1"></span>
		</div>		
	</div>
</div>
</body>
</html>