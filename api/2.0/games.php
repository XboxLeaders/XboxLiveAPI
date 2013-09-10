<?php
/*******************************************************************************
 * XboxLeaders Xbox LIVE REST API                                              *
 * =========================================================================== *
 * @file        games.php                                                      *
 * @package     XboxLiveAPI                                                    *
 * @version     2.0                                                            *
 * @copyright   (c) 2013 - Jason Clemons <me@jasonclemons.me>                  *
 * @contributor Alan Wynn <http://github.com/djekl>                            *
 * @contributor Luke Zbihlyj <http://github.com/lukezbihlyj>                   *
 * @license     http://opensource.org/licenses/mit-license.php The MIT License *
 *******************************************************************************/

include('../includes/bootloader.php');
include('includes/kernel.php');

$api->output_headers();
$gamertag = (isset($_GET['gamertag']) && !empty($_GET['gamertag'])) ? trim($_GET['gamertag']) : null;
$region   = (isset($_GET['region']) && !empty($_GET['region'])) ? $_GET['region'] : 'en-US';

if (!$api->logged_in) {
    echo $api->output_error(500);
} else {
    if (empty($gamertag)) {
        echo $api->output_error(301);
    } elseif ($api->check_culture($region) == false) {
        echo $api->output_error(305);
    } else {
        $data = $api->fetch_games($gamertag, $region);
        if ($data) {
            echo $api->output_payload($data);
        } else {
            echo $api->output_error($api->error);
        }
    }
}

?>