<?php
/*******************************************************************************
 * XboxLeaders Xbox LIVE REST API                                              *
 * =========================================================================== *
 * @file        search.php                                                     *
 * @package     XboxLeadersApi                                                 *
 * @version     2.0                                                            *
 * @copyright   (c) 2013 - Jason Clemons <me@jasonclemons.me>                  *
 * @license     http://opensource.org/licenses/mit-license.php The MIT License *
 *******************************************************************************/

include("../includes/bootloader.php");
include("includes/kernel.php");
$api->output_headers();

$query = (isset($_GET['query']) && !empty($_GET['query'])) ? trim($_GET['query']) : null;
$region = (isset($_GET['region']) && !empty($_GET['region'])) ? $_GET['region'] : 'en-US';

if(!$api->logged_in) {
    echo $api->output_error(500);
} else {
    if(empty($query)) {
        echo $api->output_error(306);
    } else if($api->check_culture($region) == false) {
		echo $api->output_error(305);
	} else {
        $data = $api->fetch_search($query, $region);
        if($data) {
            echo $api->output_payload($data);
        } else {
            echo $api->output_error($api->error);
        }
    }
}

?>