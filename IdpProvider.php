<?php

class IdpProvider {

  // Defining some trusted Service Providers.
  private $trusted_sps = [
    'urn:service:provider:id' => 'http://localhost:8080/auth/realms/test'
  ];

  /**
   * Retrieves the Assertion Consumer Service.
   *
   * @param string
   *   The Service Provider Entity Id
   * @return
   *   The Assertion Consumer Service Url.
   */
  public function getServiceProviderAcs($entityId){
    return $this->trusted_sps[$entityId];
  }

  /**
   * Returning a dummy IdP identifier.
   *
   * @return string
   */
  public function getIdPId(){
    return "http://172.28.9.139/";
  }

  /**
   * Retrieves the certificate from the IdP.
   *
   * @return \LightSaml\Credential\X509Certificate
   */
  public function getCertificate(){
    return \LightSaml\Credential\X509Certificate::fromFile('cert/saml_test_certificate.crt');
  }

  /**
   * Retrieves the private key from the Idp.
   *
   * @return \RobRichards\XMLSecLibs\XMLSecurityKey
   */
  public function getPrivateKey(){
    return \LightSaml\Credential\KeyHelper::createPrivateKey('cert/saml_test_certificate.key', '', true);
  }

  /**
   * Returns an example user email.
   *
   * @return string
   */
  public function getUserEmail(){

    return "ejemplo@correo.com";
  }

  // Returns true if the user exists
  public function userExists($username, $password){
    $ldapconfig['host'] = '172.28.9.138'; //CHANGE THIS TO THE CORRECT LDAP SERVER
    $ldapconfig['port'] = '389';
    $ldapconfig['basedn'] = 'dc=SAMLtest,dc=local';//CHANGE THIS TO THE CORRECT BASE DN
    $ldapconfig['usersdn'] = 'cn=Users';//CHANGE THIS TO THE CORRECT USER OU/CN
    $ds=ldap_connect($ldapconfig['host'], $ldapconfig['port']) or die ('Conexión incorrecta con servidor LDAP');

    ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
    ldap_set_option($ds, LDAP_OPT_REFERRALS, 0);
    ldap_set_option($ds, LDAP_OPT_NETWORK_TIMEOUT, 10);

    $dn="cn=".$username.",".$ldapconfig['usersdn'].",".$ldapconfig['basedn'];

    if ($bind=ldap_bind($ds, $dn, $password)) {
      return true;
    } else {
      return false;
    }
  }
}
