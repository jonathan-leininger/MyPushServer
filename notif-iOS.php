<?php

// Set the content of the notification
// Set the message
// Set the badge
// Set the sound
// Set the others options

$payload['aps'] = array('alert' => 'This is the alert text', 'badge' => 1, 'sound' => 'default');
$payload = json_encode($payload);


// Set the receiver
// Set the device token which should receive the push notification

$deviceToken = "REPLACE_ME";


// Set the Apple server information
// Set the certificat name which should be in the same directory than this script

$apnsHost = 'gateway.sandbox.push.apple.com';
$apnsPort = 2195;
$apnsCert = 'apns-dev.pem';


// Send the request to Apple for a new notification

$streamContext = stream_context_create();
stream_context_set_option($streamContext, 'ssl', 'local_cert', $apnsCert);
$apns = stream_socket_client('ssl://' . $apnsHost . ':' . $apnsPort, $error, $errorString, 2, STREAM_CLIENT_CONNECT, $streamContext);
$apnsMessage = chr(0) . chr(0) . chr(32) . pack('H*', str_replace(' ', '', $deviceToken)) . chr(0) . chr(strlen($payload)) . $payload;
fwrite($apns, $apnsMessage);

// activate the php extension to use this function to close the socket
//socket_close($apns);
fclose($apns);
?>