#[XboxLiveAPI](https://www.xboxleaders.com)
###Simple & Powerful RESTful API For Xbox LIVE

XboxLiveAPI is a simple and powerful RESTful API created to obtain data from Xbox LIVE, created and
maintained by [Jason Clemons](http://twitter.com/jasonclemons) and [Alan Wynn](http://twitter.com/djekl).
Stay up to date [@xboxleaders](http://twitter.com/xboxleaders).

Get started at https://www.xboxleaders.com/get-started/!

Please consider [donating to the project](https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=6ZHLXELDHACX6) to keep the servers alive!

##License
- XboxLiveAPI source files are licensed under the MIT License:
  - http://opensource.org/licenses/mit-license.html
- The XboxLiveAPI documentation is licensed under the CC BY 3.0 License:
  - http://creativecommons.org/licenses/by/3.0/
- Attribution is not required, but much appreciated:
  - `Data Provided By XboxLeaders - https://www.xboxleaders.com`
- Full details: https://www.xboxleaders.com/license

## Getting Started
  1. [PHP](http://php.net/downloads.php) 5.4 or higher required
  2. [Apache](http://httpd.apache.org) 2.2 or higher required
  3. [cURL](http://php.net/curl) and [JSON](http://pecl.php.net/package/json) libraries required
  4. [APC](http://pecl.php.net/package/apc)/[XCache](http://xcache.lighttpd.net)/[Memcached](http://memcached.org) highly recommended
  5. Install using [Composer](http://getcomposer.org)

## Composer
  1. Get [Composer](http://getcomposer.org)
  2. Require xboxleaders/xboxliveapi `php composer.phar require xboxleaders/xboxliveapi`
  3. Install dependencies with `php composer.phar install`


## Using the Xbox Live API
There are two main ways in which you can use the XboxLiveAPI. The main one, which is what
is used on xboxleaders.com, is the RESTful API. XboxLiveAPI comes ready to do this right
out of the box, and only needs to be placed in a publicly accessible directory, and add
login credentials to `bootloader.php`.

The second way to use the API is to call it directly using the endpoint models. Here's
an example on how to do this:

    <?php
    require('../api/{version}/includes/kernel.php');
    
    // fetch profile model
    $data = $api->fetch_profile('Major Nelson', 'en-GB');

It's really that simple. Below are the other models that you can use to return results. Keep
in mind that the `search` endpoint is NOT in version 1.0.

### Profile Model

```php
$data = $api->fetch_profile($gamertag, $region);
```

### Games Model

```php
$data = $api->fetch_games($gamertag, $region);
```

### Achievements Model

```php
$data = $api->fetch_achievements($gamertag, $gameid, $region);
```

### Friends Model

```php
$data = $api->fetch_friends($gamertag, $region);
```

### Search Model

```php
$data = $api->fetch_search($query, $region);
```
