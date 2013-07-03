<?php
/*******************************************************************************
 * XboxLeaders Xbox LIVE REST API                                              *
 * =========================================================================== *
 * @file        index.php                                                      *
 * @package     XboxLeadersApi                                                 *
 * @version     2.0                                                            *
 * @copyright   (c) 2013 - Jason Clemons <me@jasonclemons.me>                  *
 * @license     http://opensource.org/licenses/mit-license.php The MIT License *
 *******************************************************************************/

include("../includes/bootloader.php");
include("includes/kernel.php");
$api->output_headers();

echo $api->output_error(304);

?>