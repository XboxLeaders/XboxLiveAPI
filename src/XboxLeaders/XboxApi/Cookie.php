<?php
namespace XboxLeaders\XboxApi\Cookie;

use XboxLeaders\XboxApi\Config;

class Cookie
{
    protected function empty_cookie_file()
    {
        $this->logged_in = false;

        if (file_exists($this->cookie_file)) {
            $f = fopen($this->cookie_file, 'w');
            fclose($f);
        }
    }

    protected function add_cookie($domain, $name, $value, $path = '/', $expires = 0)
    {
        $file = fopen($this->cookie_file, 'a');

        if (!$file) {
            $this->error = 603;
        } else {
            fwrite($file, $domain . '	TRUE	' . $path . '	FALSE	' . $expires . '	' . $name . '	' . $value . "\r\n");
            fclose($file);
        }
    }
}
