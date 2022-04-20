<?php

include "inc.php";
include "IdpProvider.php";
include "IdpTools.php";

// Initiating our IdP Provider dummy connection.
$idpProvider = new IdpProvider();

// Instantiating our Utility class.
$idpTools = new IdpTools();

// Check if the user exists. If it doesn't, we are redirecting the user to the login.php with the SAMLRequest and the RelayState
if (!$idpProvider->userExists($_GET['username'],$_GET['password'])){
    header("Location: login.php?SAMLRequest=" . urlencode($_GET['SAMLRequest']) . "&RelayState=" . urlencode($_GET['RelayState']) . "&fail=true");
    exit();
};

// Receive the HTTP Request and extract the SAMLRequest.
$request = \Symfony\Component\HttpFoundation\Request::createFromGlobals();
$saml_request = $idpTools->readSAMLRequest($request);

// Getting a few details from the message like ID and Issuer.
$issuer = $saml_request->getMessage()->getIssuer()->getValue();
$id = $saml_request->getMessage()->getID();

// Simulate user information from IdP
$user_id = $request->get("username");
$user_email = $idpProvider->getUserEmail();

// Construct a SAML Response.
$response = $idpTools->createSAMLResponse($idpProvider, $user_id, $user_email, $issuer, $id);

//print_r ($idpProvider); print_r ($user_id); print_r ($user_email);print_r ($issuer);print_r ($id);
//print_r ($response);

// Prepare the POST binding (form).
$bindingFactory = new \LightSaml\Binding\BindingFactory();
$postBinding = $bindingFactory->create(\LightSaml\SamlConstants::BINDING_SAML2_HTTP_POST);
$messageContext = new \LightSaml\Context\Profile\MessageContext();
$messageContext->setMessage($response);

// Ensure we include the RelayState.
$message = $messageContext->getMessage();
$message->setRelayState($request->get('RelayState'));
$messageContext->setMessage($message);

// Serialize the response to XML.
$serializationContext = new \LightSaml\Model\Context\SerializationContext();
$response->serialize($serializationContext->getDocument(), $serializationContext);

// Print response for testing purposes.
echo ($serializationContext->getDocument()->saveXML());

// Return the Response.
/** @var \Symfony\Component\HttpFoundation\Response $httpResponse */
// $httpResponse = $postBinding->send($messageContext);