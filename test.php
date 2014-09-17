<?php
include '/etc/freepbx.conf';

global $astman;

set_error_handler(null);
set_exception_handler(null);
error_reporting(E_ALL);
$cmd = $astman->PJSIPShowEndpoint('301');
$cmd = $astman->PJSIPShowEndpoint('301');
$cmd = $astman->PJSIPShowEndpoint('301');
$cmd = $astman->PJSIPShowEndpoint('301');
$cmd = $astman->PJSIPShowEndpoint('301');
$cmd = $astman->PJSIPShowEndpoint('301');
$cmd = $astman->PJSIPShowEndpoint('301');
$cmd = $astman->PJSIPShowEndpoint('301');
$cmd = $astman->PJSIPShowEndpoint('301');
$cmd = $astman->PJSIPShowEndpoint('301');
$cmd = $astman->PJSIPShowEndpoint('301');
$cmd = $astman->PJSIPShowEndpoint('301');

print_r($cmd);
print $cmd[1]['Password']."\n";

while ($r = fgets($astman->socket)) {
	print "Extra: $r";
}

