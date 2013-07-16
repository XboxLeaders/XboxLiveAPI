<?php
/**
 * XboxLeaders API - Xbox LIVE Data Aggregator
 *
 * @file		/1.0/profile.php
 * @package		XboxLeaders API
 * @version		1.0
 * @copyright	(c) 2013 - Jason Clemons <me@jasonclemons.me>
 * @license		http://opensource.org/licenses/mit-license.php The MIT License
 */

include("../includes/bootloader.php");
include("includes/kernel.php");
$api->output_headers();

$gamertag = (isset($_GET['gamertag']) && !empty($_GET['gamertag'])) ? trim($_GET['gamertag']) : null;
$region = (isset($_GET['region']) && !empty($_GET['region'])) ? $_GET['region'] : 'en-US';

if($api->offline) {
	echo $api->output_error(700);
} else if(!$api->logged_in) {
    echo $api->output_error(500);
} else {
    if(empty($gamertag)) {
        echo $api->output_error(301);
    } else if($api->check_culture($region) == false) {
		echo $api->output_error(305);
	} else {
        $data = $api->fetch_profile($gamertag, $region);
        if($data) {
            echo $api->output_payload($data);
        } else {
            echo $api->output_error($api->error);
        }
    }
}

?>