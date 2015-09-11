<?php
/**
* This is the landing file for the friends endpoint.
*
* LICENSE: MIT (http://opensource.org/licenses/mit-license.html)
*
* @category XboxLeaders
* @package XboxLiveAPI
* @copyright Copyright (c) 2012 - 2014 XboxLeaders
* @license http://xboxleaders.github.io/license/ MIT License
* @version 2.0
* @link http://github.com/XboxLeaders/XboxLiveAPI
* @since File available since Release 1.0
*/

include('includes/bootloader.php');
include('includes/kernel.php');

$api->output_headers();
$gamertag = (isset($_GET['gamertag']) && !empty($_GET['gamertag'])) ? trim($_GET['gamertag']) : null;
$region   = (isset($_GET['region']) && !empty($_GET['region'])) ? $_GET['region'] : 'en-US';
$recipients = (isset($_GET['recipients']) && !empty($_GET['recipients'])) ? $_GET['recipients'] : null;
$message = (isset($_GET['message']) && !empty($_GET['message'])) ? $_GET['message'] : null;

if (!$api->logged_in) {
    echo $api->output_error(500);
} else {
    if (empty($gamertag)) {
        echo $api->output_error(301);
	} elseif (empty($recipients)) {		
		echo $api->output_error(307);
	} elseif (empty($message)) {
		echo $api->output_error(308);
    } elseif ($api->check_culture($region) == false) {
        echo $api->output_error(305);
    } else {
        $data = $api->sendMessage($gamertag, $region, $recipients, $message);
        if ($data) {
            echo $api->output_payload($data);
        } else {
            echo $api->output_error($api->error);
        }
    }
}
