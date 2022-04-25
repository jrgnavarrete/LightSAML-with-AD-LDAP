# LightSAMLpruebas

I'm just testing things with SAML 2.0. Right now, the server can receive a SAMLRequest in http://localhost/login.php, bind the credentials with an Active Directory/LDAP and send to the service provider a SAMLResponse if the credentials are OK. 

In order to use this server for testing purposes, in "post-saml.php" you have to change the Destination to your SP Endpoint URL. Also, in "IdpProvider.php" you have to set the data of the LDAP server, the SP URL and the server (IDP) IP. 

You can uncomment the lines in the "userExists" function of the "IdpProvider.php" file if you want to check credentials using the DistinguishedName instead of the UserPrincipalName.

The Service Provider is Keycloak, but if you want to use it, you have to create a new Realm and add this server as an Identity Provider.

The code is based on: https://github.com/Prosple/saml_idp_example & https://github.com/lightSAML/lightSAML.

![demo(3)](https://user-images.githubusercontent.com/91310398/165083187-c4f8957f-7581-47fd-9ce2-ebbde49d4fff.gif)
