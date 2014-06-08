<?php
namespace XboxLeaders\XboxApi\Config;

class Config
{
    require 'vendor/autoload.php';

    define('CACHE_ENGINE', 'apc');

    define('XBOX_ACCOUNTS', array(
        array(
            'email' => 'john@appleseed.com',
            'passwd' => 'example123',
        )
    ));

    define('COOKIE_FILE', 'path/to/cookie.jar');

    define('DEBUG_FILE', 'path/to/debug.log');

    define('STACK_TRACE_FILE', 'path/to/stack_trace.log');
}
