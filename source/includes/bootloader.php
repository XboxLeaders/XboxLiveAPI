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
const XBOX_EMAIL = '';
const XBOX_PASSWORD = '';
const XBOX_GAMERTAG = '';

/*!
 * Define some log file locations.
 */
const COOKIE_FILE = '../includes/login_cookies.jar';
const DEBUG_FILE = '../includes/logs/debug.log';
const STACK_TRACE_FILE = '../includes/logs/stack_trace.log';
const ACCESS_FILE = '../includes/logs/access.log';

/*!
 * Initiate the caching engine.
 */
$cache = new Cache(CACHE_ENGINE);

?>