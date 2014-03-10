<?php
/**
* This file takes all the data gained from Xbox LIVE, and parses
* it into a more readable format.
*
* LICENSE: MIT (http://opensource.org/licenses/mit-license.html)
*
* @category     XboxLeaders
* @package      XboxLiveAPI
* @copyright    Copyright (c) 2012 - 2014 XboxLeaders
* @license      http://xboxleaders.github.io/license/ MIT License
* @version      2.0
* @link         http://github.com/XboxLeaders/XboxLiveAPI
* @since        File available since Release 1.0
*/

class API extends Base
{
    /**
     * Version of this API
     */
    public $version = '2.0';

    /**
     * Fetch profile information
     *
     * @access public
     * @var    string $gamertag
     * @var    string $region
     * @return array
     */
    public function fetch_profile($gamertag, $region)
    {
        $gamertag = trim($gamertag);
        $url = 'http://live.xbox.com/' . $region . '/Profile?gamertag=' . urlencode($gamertag);
        $key = $this->version . ':profile.' . $gamertag;

        $data = $this->__cache->fetch($key);
        if (!$data) {
            $data      = $this->fetch_url($url);
            $freshness = 'new';
            $this->__cache->store($key, $data, 3600);
        } else {
            $freshness = 'from cache';
        }

        if (stripos($data, '<section class="contextRail custom">')) {
            $user = array();
            $user['gamertag']                   = trim($gamertag);
            $user['tier']                       = (strpos($data, '<div class="goldBadge">') !== false) ? 'gold' : 'silver';
            $user['badges']['xboxlaunchteam']   = false;
            $user['badges']['nxelaunchteam']    = false;
            $user['badges']['kinectlaunchteam'] = false;
            $user['avatar']['full']             = 'http://avatar.xboxlive.com/avatar/' . $gamertag . '/avatar-body.png';
            $user['avatar']['small']            = 'http://avatar.xboxlive.com/avatar/' . $gamertag . '/avatarpic-s.png';
            $user['avatar']['large']            = 'http://avatar.xboxlive.com/avatar/' . $gamertag . '/avatarpic-l.png';
            $user['avatar']['tile']             = trim(str_replace('https://avatar-ssl', 'http://avatar', $this->find($data, '<img class="gamerpic" src="', '" alt="')));
            $user['gamerscore']                 = (int) trim($this->find($data, '<div class="gamerscore">', '</div>'));
            $user['reputation']                 = 0;
            $user['presence']                   = trim(str_replace("\r\n", ' - ', $this->find($data, '<div class="presence">', '</div>')));
            $user['online']                     = (bool)(strpos($user['presence'], 'Online') !== false && strpos($user['presence'], 'Online Status Unavailable') === false);
            $user['gamertag']                   = str_replace(array('&#39;s Profile', '\'s Profile'), '', trim($this->find($data, '<h1 class="pageTitle">', '</h1>')));
            $user['motto']                      = $this->clean(trim(strip_tags($this->find($data, '<div class="motto">', '</div>'))));
            $user['name']                       = trim(strip_tags($this->find($data, '<div class="name" title="', '">')));
            $user['location']                   = trim(strip_tags(str_replace('<label>Location:</label>', '', trim($this->find($data, '<div class="location">', '</div>')))));
            $user['biography']                  = trim(strip_tags(str_replace('<label>Bio:</label>', '', trim($this->find($data, '<div class="bio">', '</div>')))));

            $recentactivity = $this->fetch_games($gamertag, $region);
            if (is_array($recentactivity)) {
                $user['recentactivity'] = array_slice($recentactivity['games'], 0, 5, true);
            } else {
                $user['recentactivity'] = null;
            }

            if (strpos($data, '<div class="badges">') !== false) {
                if (strpos($data, 'xbox360Badge') !== false) {
                    $user['badges']['xboxlaunchteam'] = true;
                }
                if (strpos($data, 'nxeBadge') !== false) {
                    $user['badges']['nxelaunchteam'] = true;
                }
                if (strpos($data, 'kinectBadge') !== false) {
                    $user['badges']['kinectlaunchteam'] = true;
                }
            }

            $starvalue = array(
                'Empty'        => 0,
                'Quarter'      => 1,
                'Half'         => 2,
                'ThreeQuarter' => 3,
                'Full'         => 4,
            );

            preg_match_all('~<div class="Star (.*?)"></div>~si', $data, $reputation);
            foreach ($reputation[1] as $value) {
                $user['reputation'] = $user['reputation'] + $starvalue[$value];
            }

            $user['freshness'] = $freshness;

            return $user;
        } elseif (stripos($data, 'errorCode: \'404\'')) {
            $this->error = 501;

            return false;
        } else {
            $this->error = 500;
            $this->__cache->remove($key);
            $this->force_new_login();

            return false;
        }
    }

    /**
     * Fetch achievement information for a specific game
     *
     * @access public
     * @var    string $gamertag
     * @var    int    $gameid
     * @var    string $region
     * @return array
     */
    public function fetch_achievements($gamertag, $gameid, $region)
    {
        $gamertag = trim($gamertag);
        $url      = 'https://live.xbox.com/' . $region . '/Activity/Details?titleId=' . urlencode($gameid) . '&compareTo=' . urlencode($gamertag);
        $key      = $this->version . ':achievements.' . $gamertag . '.' . $gameid;

        $data = $this->__cache->fetch($key);
        if (!$data) {
            $data      = $this->fetch_url($url);
            $freshness = 'new';
            $this->__cache->store($key, $data, 3600);
        } else {
            $freshness = 'from cache';
        }

        $json = $this->find($data, 'broker.publish(routes.activity.details.load, ', ');');
        $json = json_decode($json, true);

        if (!empty($json)) {
            $achievements                           = array();
            $achievements['gamertag']               = $g = $json['Players'][0]['Gamertag'];
            $achievements['game']                   = $this->clean($json['Game']['Name']);
            $achievements['id']                     = $json['Game']['Id'];
            $achievements['hid']                    = dechex($json['Game']['Id']);
            $achievements['gamerscore']['current']  = $json['Game']['Progress'][$g]['Score'];
            $achievements['gamerscore']['total']    = $json['Game']['PossibleScore'];
            $achievements['achievement']['current'] = $json['Game']['Progress'][$g]['Achievements'];
            $achievements['achievement']['total']   = $json['Game']['PossibleAchievements'];
            $achievements['progress']               = $json['Players'][0]['PercentComplete'];
            $achievements['lastplayed']             = (int)substr($json['Game']['Progress'][$g]['LastPlayed'], 6, 10);

            $i = 0;
            foreach ($json['Achievements'] as $achievement) {
                $achievements['achievements'][$i]['id']                  = $achievement['Id'];
                $achievements['achievements'][$i]['title']               = '';
                $achievements['achievements'][$i]['artwork']['locked']   = 'https://live.xbox.com/Content/Images/HiddenAchievement.png';
                $achievements['achievements'][$i]['artwork']['unlocked'] = 'https://live.xbox.com/Content/Images/HiddenAchievement.png';
                $achievements['achievements'][$i]['title']               = 'Secret Achievement';
                $achievements['achievements'][$i]['description']         = 'This is a secret achievement. Unlock it to find out more.';
                $achievements['achievements'][$i]['gamerscore']          = 0;
                $achievements['achievements'][$i]['secret']              = (bool)$achievement['IsHidden'];
                $achievements['achievements'][$i]['unlocked']            = false;
                $achievements['achievements'][$i]['unlockdate']          = null;
                $achievements['achievements'][$i]['unlockedoffline']     = null;

                if (!$achievement['IsHidden']) {
                    // find colored achievement tile
                    // get image name. removes url and extension
                    $ach_info  = pathinfo($achievement['TileUrl']);
                    // decode image name
                    $ach_str1  = base64_decode($ach_info['filename']);
                    // remove everything before /ach
                    $ach_str2  = strstr($ach_str1, '/ach');
                    // subtract last 12 spaces and/or whitespace from string
                    $ach_str3  = substr($ach_str2, 0, -11);
                    // create color tile source
                    $ach_color = 'https://image-ssl.xboxlive.com/global/t.' . dechex($json['Game']['Id']) . $ach_str3;

                    $achievements['achievements'][$i]['artwork']['locked']   = $achievement['TileUrl'];
                    $achievements['achievements'][$i]['artwork']['unlocked'] = $ach_color;
                }

                if (!empty($achievement['Name'])) {
                    $achievements['achievements'][$i]['title'] = $this->clean($achievement['Name']);
                }

                if (!empty($achievement['Description'])) {
                    $achievements['achievements'][$i]['description'] = $this->clean($achievement['Description']);
                }

                if (!empty($achievement['Score'])) {
                    $achievements['achievements'][$i]['gamerscore'] = $achievement['Score'];
                }

                if (!empty($achievement['EarnDates'][$g]['EarnedOn'])) {
                    $achievements['achievements'][$i]['unlocked']        = true;
                    $achievements['achievements'][$i]['unlockdate']      = (int)substr($achievement['EarnDates'][$g]['EarnedOn'], 6, 10);
                    $achievements['achievements'][$i]['unlockedoffline'] = (bool)$achievement['EarnDates'][$g]['IsOffline'];
                }

                $i++;
            }

            $achievements['freshness'] = $freshness;
            return $achievements;
        } elseif (stripos($data, 'errorCode: \'404\'')) {
            $this->error = 502;
            return false;
        } else {
            $this->error = 500;
            $this->__cache->remove($key);
            $this->force_new_login();
            return false;
        }
    }

    /**
     * Fetch information about played games
     *
     * @access public
     * @var    string $gamertag
     * @var    string $region
     * @return array
     */
    public function fetch_games($gamertag, $region)
    {
        $gamertag  = trim($gamertag);
        $url       = 'https://live.xbox.com/' . $region . '/Activity';
        $key       = $this->version . ':games.' . $gamertag;
        $data      = $this->__cache->fetch($key);
        $freshness = 'from cache';

        if (!$data) {
            $data      = $this->fetch_url($url);
            $post_data = '__RequestVerificationToken=' . urlencode(trim($this->find($data, '<input name="__RequestVerificationToken" type="hidden" value="', '" />'))) . '&compareTo=' . urlencode($gamertag);
            $headers   = array('X-Requested-With: XMLHttpRequest', 'Content-Type: application/x-www-form-urlencoded; charset=UTF-8');
            $data      = $this->fetch_url('https://live.xbox.com/' . $region . '/Activity/Summary?compareTo=' . urlencode($gamertag) . '&lc=1033', $url, 10, $post_data, $headers);
            $freshness = 'new';
            $this->__cache->store($key, $data, 3600);
        }

        $json = json_decode($data, true);

        if ($json['Success'] == 'true' && $json['Data']['Players'][0]['Gamertag'] != $this->account_gamertag) {
            $json                             = $json['Data'];
            $games                            = array();
            $games['gamertag']                = $g = $json['Players'][0]['Gamertag'];
            $games['gamerscore']['current']   = $json['Players'][0]['Gamerscore'];
            $games['gamerscore']['total']     = 0;
            $games['achievements']['current'] = 0;
            $games['achievements']['total']   = 0;
            $games['totalgames']              = $json['Players'][0]['GameCount'];
            $games['progress']                = $json['Players'][0]['PercentComplete'];

            $i = 0;
            foreach ($json['Games'] as $game) {
                if ($game['Progress'][$g]['LastPlayed'] !== 'null') {
                    $games['games'][$i]['id']                      = $game['Id'];
                    $games['games'][$i]['hid']                     = dechex($game['Id']);
                    $games['games'][$i]['isapp']                   = (bool)($game['PossibleScore'] == 0);
                    $games['games'][$i]['title']                   = $this->clean($game['Name']);
                    $games['games'][$i]['artwork']['small']        = 'http://download.xbox.com/content/images/66acd000-77fe-1000-9115-d802' . dechex($game['Id']) . '/1033/boxartsm.jpg';
                    $games['games'][$i]['artwork']['large']        = 'http://download.xbox.com/content/images/66acd000-77fe-1000-9115-d802' . dechex($game['Id']) . '/1033/boxartlg.jpg';
                    $games['games'][$i]['gamerscore']['current']   = $game['Progress'][$g]['Score'];
                    $games['games'][$i]['gamerscore']['total']     = $game['PossibleScore'];
                    $games['games'][$i]['achievements']['current'] = $game['Progress'][$g]['Achievements'];
                    $games['games'][$i]['achievements']['total']   = $game['PossibleAchievements'];
                    $games['games'][$i]['progress']                = 0;
                    $games['games'][$i]['lastplayed']              = (int)substr($game['Progress'][$g]['LastPlayed'], 6, 10);
                    $games['gamerscore']['total']                  = $games['gamerscore']['total'] + $games['games'][$i]['gamerscore']['total'];
                    $games['achievements']['current']              = $games['achievements']['current'] + $games['games'][$i]['achievements']['current'];
                    $games['achievements']['total']                = $games['achievements']['total'] + $games['games'][$i]['achievements']['total'];

                    if ($game['Progress'][$g]['Achievements'] !== 0) {
                        $games['games'][$i]['progress'] = round((($game['Progress'][$g]['Achievements'] / $game['PossibleAchievements']) * 100), 1);
                    }

                    $i++;
                }
            }

            $games['freshness'] = $freshness;
            return $games;
        } elseif ($json['Data']['Players'][0]['Gamertag'] == $this->account_gamertag) {
            $this->error = 501;
            return false;
        } else {
            $this->error = 500;
            $this->__cache->remove($key);
            $this->force_new_login();
            return false;
        }
    }

    /**
     * Fetch data about a players' friends list
     *
     * @access public
     * @var    string $gamertag
     * @var    string $region
     * @return array
     */
    public function fetch_friends($gamertag, $region)
    {
        $gamertag  = trim($gamertag);
        $url       = 'https://live.xbox.com/' . $region . '/Friends';
        $key       = $this->version . ':friends.' . $gamertag;
        $data      = $this->__cache->fetch($key);
        $freshness = 'from cache';

        if (!$data) {
            $data      = $this->fetch_url($url);
            $post_data = '__RequestVerificationToken=' . urlencode(trim($this->find($data, '<input name="__RequestVerificationToken" type="hidden" value="', '" />')));
            $headers   = array('X-Requested-With: XMLHttpRequest', 'Content-Type: application/x-www-form-urlencoded; charset=UTF-8');
            $data      = $this->fetch_url('https://live.xbox.com/' . $region . '/Friends/List?Gamertag=' . urlencode($gamertag), $url, 10, $post_data, $headers);
            $freshness = 'new';
            $this->__cache->store($key, $data, 3600);
        }

        $json = json_decode($data, true);

        if (!empty($json['Data']) && $json['Data']['Friends'] != null) {
            $friends                 = array();
            $friends['total']        = 0;
            $friends['totalonline']  = 0;
            $friends['totaloffline'] = 0;

            $i = 0;
            foreach ($json['Data']['Friends'] as $friend) {
                $friends['friends'][$i]['gamertag']          = $friend['GamerTag'];
                $friends['friends'][$i]['gamerpic']['small'] = $friend['GamerTileUrl'];
                $friends['friends'][$i]['gamerpic']['large'] = $friend['LargeGamerTileUrl'];
                $friends['friends'][$i]['gamerscore']        = $friend['GamerScore'];
                $friends['friends'][$i]['online']            = (bool)$friend['IsOnline'];
                $friends['friends'][$i]['status']            = $friend['Presence'];
                $friends['friends'][$i]['lastseen']          = (int)substr($friend['LastSeen'], 6, 10);

                $friends['total']++;
                if ($friend['IsOnline']) {
                    $friends['totalonline']++;
                } else {
                    $friends['totaloffline']++;
                }

                $i++;
            }

            $friends['freshness'] = $freshness;
            return $friends;
        } else {
            $this->error = 503;
            $this->__cache->remove($key);
            $this->force_new_login();
            return false;
        }
    }

    /**
     * Fetch data for a search query
     *
     * @access public
     * @var    string $query
     * @var    string $region
     * @return array
     */
    public function fetch_search($query, $region)
    {
        $query     = trim($query);
        $url       = 'http://marketplace.xbox.com/' . $region . '/SiteSearch/xbox/?query=' . urlencode($query);
        $key       = $this->version . ':friends.' . $query;
        $data      = $this->__cache->fetch($key);
        $freshness = 'from cache';

        if (!$data) {
            $data      = $this->fetch_url($url);
            $freshness = 'new';
            $this->__cache->store($key, $data, 3600);
        }

        $json = json_decode($data, true);
        if ($json['totalEntries'] >= 1) {
            $search                 = array();
            $search['totalresults'] = $json['totalEntries'];
            $search['resultslink']  = 'http://marketplace.xbox.com' . $json['allResultsUrl'];

            $i = 0;
            foreach ($json['entries'] as $entry) {
                $search['results'][$i]['title']                 = $entry['title'];
                $search['results'][$i]['parent']                = $entry['parentTitle'];
                $search['results'][$i]['link']                  = 'http://marketplace.xbox.com' . $entry['detailsUrl'];
                $search['results'][$i]['image']                 = $entry['image'];
                $search['results'][$i]['downloadtype']['class'] = $entry['downloadTypeClass'];
                $search['results'][$i]['downloadtype']['title'] = $entry['downloadTypeText'];
                $search['results'][$i]['prices']['silver']      = $entry['prices']['silver'];
                $search['results'][$i]['prices']['gold']        = $entry['prices']['gold'];
                $i++;
            }

            $search['freshness'] = $freshness;
            return $search;
        } else {
            $this->error = 504;
            $this->__cache->remove($key);
            return false;
        }
    }
}
