<?php
/**
* This is the main initiation file for the API.
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

include('classes/api.class.php');
 
$api = new API($cache);

if (isset($_GET['callback']) && !empty($_GET['callback'])) {
    $api->format   = 'jsonp';
    $api->callback = preg_replace('/(<.*>)|(.*;)/g', '', $_GET['callback']);
} else {
    $api->format   = (isset($_GET['format']) && in_array($_GET['format'], array('xml', 'json', 'php'))) ? strtolower(trim($_GET['format'])) : 'json';
}

$api->version          = '2.0.1';
$api->debug            = (isset($_GET['debug']));
$api->cookie_file      = COOKIE_FILE;
$api->debug_file       = DEBUG_FILE;
$api->stack_trace_file = STACK_TRACE_FILE;

$api->init(XBOX_EMAIL, XBOX_PASSWORD);
