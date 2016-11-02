<?php
include('./vendor/autoload.php');
include('./config.php');
include('./randos.php');

use Twilio\Jwt\AccessToken;
use Twilio\Jwt\Grants\VideoGrant;
use Twilio\Rest\Client;

// An identifier for your app - can be anything you'd like
$appName = 'TwilioVideoDemo';

// choose a random username for the connecting user
$identity = randomUsername();

$token = "b279fdd9e42fe596fa3e95ac5b863a0d";
$client = new Client($TWILIO_ACCOUNT_SID, $token);
$theToken = $client->tokens->create();
echo $token->username;

// Create access token, which we will serialize and send to the client
$token = new AccessToken(
    $TWILIO_ACCOUNT_SID,
    $TWILIO_API_KEY,
    $TWILIO_API_SECRET,
    3600,
    $identity
);

// Grant access to Video
$grant = new VideoGrant();
$grant->setConfigurationProfileSid($TWILIO_CONFIGURATION_SID);
$token->addGrant($grant);

// return serialized token and the user's randomly generated ID
echo json_encode(array(
    'identity' => $identity,
    'token' => $token->toJWT(),
));
