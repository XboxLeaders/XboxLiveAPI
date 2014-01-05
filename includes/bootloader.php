<?php
/*******************************************************************************
 * XboxLeaders Xbox LIVE REST API                                              *
 * =========================================================================== *
 * @file        bootloader.php                                                 *
 * @package     XboxLiveAPI                                                    *
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
 * You can add multiple accounts, or just one.
 */
$accounts = array(
    array(
        'email'    => 'john@example.com',
        'password' => 'Password123',
        'gamertag' => 'Major Nelson'
    )
);

/*!
 * Pick a random email to login
 */
$account = $accounts[0];
if (count($accounts) > 1) {
    $id      = rand(0, (count($accounts) - 1));
    $account = $accounts[$id];
}

/*!
 * Define the account credentials
 */
define('XBOX_EMAIL', $account['email']);
define('XBOX_PASSWORD', $account['password']);
define('XBOX_GAMERTAG', $account['gamertag']);

/*!
 * Define some log file locations.
 */
define('COOKIE_FILE', '../includes/cookies/' . XBOX_EMAIL . '.jar');
define('DEBUG_FILE', '../includes/logs/debug.log');
define('STACK_TRACE_FILE', '../includes/logs/stack_trace.log');

/*!
 * Initiate the caching engine.
 */
$cache = new Cache(CACHE_ENGINE);
