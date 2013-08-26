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
define('CACHE_ENGINE', 'apc');

/*!
 * Define the account details.
 */
$accounts['email'][] = '';
$accounts['email'][] = '';
$accounts['email'][] = '';
$accounts['email'][] = '';
$accounts['email'][] = '';
$accounts['email'][] = '';
$accounts['email'][] = '';
$accounts['email'][] = '';
$accounts['email'][] = '';
$accounts['email'][] = '';

$accounts['passwd'] = '';

/*!
 * Pick a random email to login
 */
$id = rand(0, count($accounts['email']));
$account = $account['email'][$id];

/*!
 * Define the account credentials
 */
define('XBOX_EMAIL', $account['email']);
define('XBOX_PASSWORD', $account['passwd']);

/*!
 * Define some log file locations.
 */
define('COOKIE_FILE', '../includes/cookies/' . XBOX_EMAIL . '.jar'); // path to cookie file
define('DEBUG_FILE', '../includes/logs/debug.log');                  // path to debug log
define('STACK_TRACE_FILE', '../includes/logs/stack_trace.log');      // path to stack trace
define('ACCESS_FILE', '../includes/logs/access.log');                // path to access log

/*!
 * Initiate the caching engine.
 */
$cache = new Cache(CACHE_ENGINE);

?>