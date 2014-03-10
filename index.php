<?php
/**
* This file does nothing. I promise :)
*
* LICENSE: MIT (http://opensource.org/licenses/mit-license.html)
*
* @category XboxLeaders
* @package XboxLiveAPI
* @copyright Copyright (c) 2012 - 2014 XboxLeaders
* @license http://xboxleaders.github.io/license/ MIT License
* @version 2.0
* @link http://github.com/XboxLeaders/XboxLiveAPI
* @since File available since Release 1.0
*/

include('includes/bootloader.php');
include('includes/kernel.php');

$api->output_headers();
echo $api->output_error(304);
