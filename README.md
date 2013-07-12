#[XboxLiveAPI v2.0.0](https://www.xboxleaders.com)
###Simple & Powerful RESTful API For Xbox LIVE

XboxLiveAPI is a simple and powerful RESTful API created to obtain data from Xbox LIVE, created and
maintained by [Jason Clemons](http://twitter.com/jasonclemons) and [Alan Wynn](http://twitter.com/djekl).
Stay up to date [@xboxleaders](http://twitter.com/xboxleaders).

Get started at https://www.xboxleaders.com!

##License
- XboxLiveAPI source files are licensed under the MIT License:
  - http://opensource.org/licenses/mit-license.html
- The XboxLiveAPI documentation is licensed under the CC BY 3.0 License:
  - http://creativecommons.org/licenses/by/3.0/
- Attribution is not required, but much appreciated:
  - `Data Provided By XboxLeaders - https://www.xboxleaders.com`
- Full details: https://www.xboxleaders.com/license

##Changelog
- v2.0.0 - major rewrite over v1.0

##Versioning

XboxLiveAPI will be maintained under the Semantic Versioning guidelines as much as possible. Releases will be numbered with the following format:

`<major>.<minor>.<patch>`

And constructed with the following guidelines:

* Breaking backward compatibility bumps the major (and resets the minor and patch)
* New additions without breaking backward compatibility bumps the minor (and resets the patch)
* Bug fixes and misc changes bumps the patch

For more information on SemVer, please visit http://semver.org.

##Workflow

XboxLiveAPI will be developed using the [GitHub Workflow](http://scottchacon.com/2011/08/31/github-flow.html) as much as possible. All pull requests
must be against the `*-wip` branches. Commits will be made to `*.0.x-dev` branches before being pushed to `master`.

##Author
- Email: me@jasonclemons.me
- Twitter: http://twitter.com/jasonclemons
- GitHub: https://github.com/jasonclemons


## Using the XboxLiveAPI

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

## Hacking on XboxLiveAPI

From the root of the repository, install the tools used to develop.

    $ bundle install
    $ npm install
