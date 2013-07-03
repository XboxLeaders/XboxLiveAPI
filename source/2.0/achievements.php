<?php
/*******************************************************************************
 * XboxLeaders Xbox LIVE REST API                                              *
 * =========================================================================== *
 * @file        achievements.php                                               *
 * @package     XboxLeadersApi                                                 *
 * @version     2.0                                                            *
 * @copyright   (c) 2013 - Jason Clemons <me@jasonclemons.me>                  *
 * @license     http://opensource.org/licenses/mit-license.php The MIT License *
 *******************************************************************************/

include("../includes/bootloader.php");
include("includes/kernel.php");
$api->output_headers();

$gamertag = (isset($_GET['gamertag']) && !empty($_GET['gamertag'])) ? trim($_GET['gamertag']) : null;
$gameid = (isset($_GET['gameid'])) ? (int)$_GET['gameid'] : null;
$region = (isset($_GET['region']) && !empty($_GET['region'])) ? $_GET['region'] : 'en-US';

if(!$api->logged_in) {
    echo $api->output_error(500);
} else {
    if(empty($gamertag)) {
        echo $api->output_error(301);
    } else if(empty($gameid)) {
        echo $api->output_error(302);
    } else if($api->check_culture($region) == false) {
		echo $api->output_error(305);
	} else {
        $data = $api->fetch_achievements($gamertag, $gameid, $region);
        if($data) {
            echo $api->output_payload($data);
        } else {
            echo $api->output_error($api->error);
        }
    }
}

?>