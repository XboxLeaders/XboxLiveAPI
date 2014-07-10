<?php
/**
* This is the landing file for the achievements endpoint
*
* LICENSE: MIT (http://opensource.org/licenses/mit-license.html)
*
* @category     XboxLeaders
* @package      XboxLiveAPI
* @copyright    Copyright (c) 2012 - 2014 XboxLeaders
* @license      https://www.xboxleaders.com/license/ MIT License
* @version      2.0.1
* @link         http://github.com/XboxLeaders/XboxLiveAPI
* @since        File available since Release 1.0
*/

include('includes/bootloader.php');
include('includes/kernel.php');

$api->output_headers();
$gamertag = (isset($_GET['gamertag']) && !empty($_GET['gamertag'])) ? trim($_GET['gamertag']) : null;
$gameid   = (isset($_GET['gameid'])) ? (int)$_GET['gameid'] : null;
$region   = (isset($_GET['region']) && !empty($_GET['region'])) ? $_GET['region'] : 'en-US';

if (!$api->logged_in) {
    echo $api->output_error(500);
} else {
    if (empty($gamertag)) {
        echo $api->output_error(301);
    } elseif (empty($gameid)) {
        echo $api->output_error(302);
    } elseif ($api->check_culture($region) == false) {
        echo $api->output_error(305);
    } else {
        $data = $api->fetch_achievements($gamertag, $gameid, $region);
        if ($data) {
            echo $api->output_payload($data);
        } else {
            echo $api->output_error($api->error);
        }
    }
}
