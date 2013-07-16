<?php
/**
 * XboxLeaders API - Xbox LIVE Data Aggregator
 *
 * @file		/1.0/index.php
 * @package		XboxLeaders API
 * @version		1.0
 * @copyright	(c) 2013 - Jason Clemons <me@jasonclemons.me>
 * @license		http://opensource.org/licenses/mit-license.php The MIT License
 */

include("../includes/bootloader.php");
include("includes/kernel.php");
$api->output_headers();

echo $api->output_error(304);

?>