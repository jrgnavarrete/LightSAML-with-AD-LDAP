<?php
$username = "ana";
$password = "usuario";


$ldapconfig['host'] = '172.28.9.138'; //CHANGE THIS TO THE CORRECT LDAP SERVER
$ldapconfig['port'] = '389';
$ldapconfig['basedn'] = 'dc=SAMLtest,dc=local';//CHANGE THIS TO THE CORRECT BASE DN
$ldapconfig['usersdn'] = 'cn=Users';//CHANGE THIS TO THE CORRECT USER OU/CN
$ds=ldap_connect($ldapconfig['host'], $ldapconfig['port']) or die ('Conexión incorrecta');

ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
ldap_set_option($ds, LDAP_OPT_REFERRALS, 0);
ldap_set_option($ds, LDAP_OPT_NETWORK_TIMEOUT, 10);

$dn="uid=".$username.",".$ldapconfig['usersdn'].",".$ldapconfig['basedn'];
echo $dn;
if ($bind=ldap_bind($ds, "ana", $password)) {
	echo("Correcto");//REPLACE THIS WITH THE CORRECT FUNCTION LIKE A REDIRECT;
} else {
	echo "Erróneo";
}

