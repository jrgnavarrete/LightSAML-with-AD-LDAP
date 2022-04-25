# LightSAMLpruebas

I'm just testing things with SAML 2.0. Right now, the server can receive a SAMLRequest in http://localhost/login.php, bind the credentials with an Active Directory/LDAP and send to the service provider a SAMLResponse if the credentials are OK. 

In order to use this server for testing purposes, in "post-saml.php" you have to change the Destination to your SP Endpoint URL. Also, in "IdpProvider.php" you have to set the data of the LDAP server, the SP URL and the server (IDP) IP.

The Service Provider is Keycloak, but if you want to test it with Keycloak, you have to create a new Realm and add this server as an Identity Provider.

The code is based on: https://github.com/Prosple/saml_idp_example & https://github.com/lightSAML/lightSAML.

![demo(2)](https://user-images.githubusercontent.com/91310398/165076879-94dda63c-78d8-4459-9f28-e4b2be5dca5d.gif)
