<?php
namespace XboxLeaders\XboxApi\Cookie;

use XboxLeaders\XboxApi\Config;

class Cookie
{
    protected function empty_cookie_file()
    {
        $this->logged_in = false;

        if (file_exists(COOKIE_JAR))
        {
            $f = fopen(COOKIE_JAR, 'w');
            fclose($f);
        }
    }

    protected function add_cookie($domain, $name, $value, $path = '/', $expires = 0)
    {
        $file = fopen(COOKIE_JAR, 'a');

        if (!$file)
        {
            $this->error = 603;
        }
        else
        {
            fwrite($file, $domain . '	TRUE	' . $path . '	FALSE	' . $expires . '	' . $name . '	' . $value . "\r\n");
            fclose($file);
        }
    }
}
