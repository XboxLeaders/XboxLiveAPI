<?php
/*******************************************************************************
 * XboxLeaders Xbox LIVE REST API                                              *
 * =========================================================================== *
 * @file        bootloader.php                                                 *
 * @package     XboxLiveApi                                                    *
 * @version     2.0                                                            *
 * @copyright   (c) 2013 - Jason Clemons <me@jasonclemons.me>                  *
 * @contributor Alan Wynn <http://github.com/djekl>                            *
 * @contributor Luke Zbihlyj <http://github.com/lukezbihlyj>                   *
 * @license     http://opensource.org/licenses/mit-license.php The MIT License *
 *******************************************************************************/

include('classes/cache.class.php');
include('classes/base.class.php');

/*!
 * Define the caching engine to be used.
 * Supports: apc, memcached, xcache, disk
 */
const CACHE_ENGINE = 'apc';

/*!
 * Define the account details.
 */
const XBOX_EMAIL = '';     // xbox live email
const XBOX_PASSWORD = '';  // xbox live password
const XBOX_GAMERTAG = '';  // xbox live gamertag

/*!
 * Define some log file locations.
 */
const COOKIE_FILE = '../includes/login_cookies.jar';         // path to cookie file
const DEBUG_FILE = '../includes/logs/debug.log';             // path to debug log
const STACK_TRACE_FILE = '../includes/logs/stack_trace.log'; // path to stack trace
const ACCESS_FILE = '../includes/logs/access.log';           // path to access log

/*!
 * Initiate the caching engine.
 */
$cache = new Cache(CACHE_ENGINE);

?>