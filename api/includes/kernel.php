<?php
/*******************************************************************************
 * XboxLeaders Xbox LIVE REST API                                              *
 * =========================================================================== *
 * @file        kernel.php                                                     *
 * @package     XboxLiveAPI                                                    *
 * @version     2.0                                                            *
 * @copyright   (c) 2013 - Jason Clemons <me@jasonclemons.me>                  *
 * @contributor Alan Wynn <http://github.com/djekl>                            *
 * @contributor Luke Zbihlyj <http://github.com/lukezbihlyj>                   *
 * @license     http://opensource.org/licenses/mit-license.php The MIT License *
 *******************************************************************************/

include('classes/api.class.php');
 
$api = new API($cache);

if (isset($_GET['callback']) && !empty($_GET['callback'])) {
    $api->format   = 'jsonp';
    $api->callback = preg_replace('/(<.*>)|(.*;)/g', '', $_GET['callback']);
} else {
    $api->format   = (isset($_GET['format']) && in_array($_GET['format'], array('xml', 'json', 'php'))) ? strtolower(trim($_GET['format'])) : 'json';
}

$api->version          = '2.0';
$api->debug            = (isset($_GET['debug']));
$api->cookie_file      = COOKIE_FILE;
$api->debug_file       = DEBUG_FILE;
$api->stack_trace_file = STACK_TRACE_FILE;
$api->error_file       = ERROR_FILE;

$api->init(XBOX_EMAIL, XBOX_PASSWORD);
