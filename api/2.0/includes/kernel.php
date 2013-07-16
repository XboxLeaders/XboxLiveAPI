<?php
/**
 * XboxLeaders API v2.0 - Xbox LIVE Data Aggregator
 *
 * @file		/2.0/includes/kernel.php
 * @package		XboxLeaders API v2.0
 * @copyright	(c) 2013 - Jason Clemons <me@jasonclemons.me>
 * @license		http://opensource.org/licenses/mit-license.php The MIT License
 */

include("classes/api.class.php");

$api = new API($cache);

$api->format = (isset($_GET['format']) && in_array($_GET['format'], array("xml", "json"))) ? strtolower(trim($_GET['format'])) : "xml";
if(isset($_GET['callback']) && !empty($_GET['callback'])) {
	$api->format = "jsonp";
}
$api->version = "2.0";
$api->debug = (isset($_GET['debug']));
$api->cookie_file = COOKIE_FILE;
$api->debug_file = DEBUG_FILE;
$api->stack_trace_file = STACK_TRACE_FILE;
$api->access_file = ACCESS_FILE;
$api->save_to_access($_SERVER['REMOTE_ADDR'] . " " . $_SERVER['REQUEST_URI']);

$api->init(XBOX_EMAIL, XBOX_PASSWORD);

?>