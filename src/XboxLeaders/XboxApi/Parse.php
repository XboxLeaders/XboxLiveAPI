<?php
namespace XboxLeaders\XboxApi\Parse;

use XboxLeaders\XboxApi\Config;
use XboxLeaders\XboxApi\Utils;

class Parse extends Base
{
    public function __construct()
    {
        $config = new Config();
        $cache  = new Cache($config->_loadEngine());
        $utils  = new Utils();
    }

    public function fetch_profile($gamertag)
    {
        $gamertag = trim($gamertag);
        $url      = 'http://live.xbox.com/' . $this->region . '/Profile?gamertag=' . urlencode($gamertag);
        $key      = $this->version . ':profile.' . $gamertag;

    }
}
