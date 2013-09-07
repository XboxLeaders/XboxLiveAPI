<?php
/*******************************************************************************
 * XboxLeaders Xbox LIVE REST API                                              *
 * =========================================================================== *
 * @file        api.class.php                                                  *
 * @package     XboxLiveApi                                                    *
 * @version     2.0                                                            *
 * @copyright   (c) 2013 - Jason Clemons <me@jasonclemons.me>                  *
 * @contributor Alan Wynn <http://github.com/djekl>                            *
 * @contributor Luke Zbihlyj <http://github.com/lukezbihlyj>                   *
 * @license     http://opensource.org/licenses/mit-license.php The MIT License *
 *******************************************************************************/

class API extends Base {
    /**
     * Version of this API
     */
    public $version = '2.0';

    /**
     * Fetch profile information
     *
     * @access		public
     * @var			string		gamertag
     * @var			string		region
     * @return		array
     */
    public function fetch_profile($gamertag, $region) {
        $gamertag = trim($gamertag);
        $url = 'http://live.xbox.com/' . $region . '/Profile?gamertag=' . urlencode($gamertag);
        $key = $this->version . ':profile.' . $gamertag;
        
        $data = $this->__cache->fetch($key);
        if(!$data) {
            $data = $this->fetch_url($url);
            $freshness = 'new';
            $this->__cache->store($key, $data, 3600);
        } else {
            $freshness = 'from cache';
        }

        if(stripos($data, '<section class="contextRail custom">')) {
            $user = array();
            $user['gamertag'] = trim($gamertag);
            $user['tier'] = (strpos($data, '<div class="goldBadge">') !== false) ? 'gold' : 'silver';
            $user['badges']['xboxlaunchteam'] = false;
            $user['badges']['nxelaunchteam'] = false;
            $user['badges']['kinectlaunchteam'] = false;
            $user['avatar']['full'] = 'http://avatar.xboxlive.com/avatar/' . $gamertag . '/avatar-body.png';
            $user['avatar']['small'] = 'http://avatar.xboxlive.com/avatar/' . $gamertag . '/avatarpic-s.png';
            $user['avatar']['large'] = 'http://avatar.xboxlive.com/avatar/' . $gamertag . '/avatarpic-l.png';
            $user['avatar']['tile'] = trim(str_replace('https://avatar-ssl', 'http://avatar', $this->find($data, '<img class="gamerpic" src="', '" alt="')));
            $user['gamerscore'] = (int)trim($this->find($data, '<div class="gamerscore">', '</div>'));
            $user['reputation'] = 0;
            $user['presence'] = trim(str_replace("\r\n", ' - ', trim($this->find($data, '<div class="presence">', '</div>'))));
            $user['online'] = (empty($user['presence'])
                or (strpos($user['presence'], 'Last seen') !== false)
                or (strpos($user['presence'], 'Offline') !== false)
                or (trim(strpos($user['presence'], '') !== false))) ? false : true;
            $user['gamertag'] = str_replace(array('&#39;s Profile', '\'s Profile'), '', trim($this->find($data, '<h1 class="pageTitle">', '</h1>')));
            $user['motto'] = $this->clean(trim(strip_tags($this->find($data, '<div class="motto">', '</div>'))));
            $user['name'] = trim(strip_tags($this->find($data, '<div class="name" title="', '">')));
            $user['location'] = trim(strip_tags(str_replace('<label>Location:</label>', '', trim($this->find($data, '<div class="location">', '</div>')))));
            $user['biography'] = trim(strip_tags(str_replace('<label>Bio:</label>', '', trim($this->find($data, '<div class="bio">', '</div>')))));
            
            $recent_games = $this->fetch_games($gamertag, $region);
            $user['recentactivity'] = array($recent_games['games'][0], $recent_games['games'][1], $recent_games['games'][2], $recent_games['games'][3], $recent_games['games'][4]);

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

            preg_match_all('~<div class="Star (.*?)"></div>~si', $data, $reputation);
            foreach ($reputation[1] as $k => $v) {
                $starvalue = array(
                    'Empty' => 0, 'Quarter' => 1, 'Half' => 2,
                    'ThreeQuarter' => 3, 'Full' => 4
                );
                $user['reputation'] = $user['reputation'] + $starvalue[$v];
            }

            $user['freshness'] = $freshness;
            
            return $user;
        } else if(stripos($data, 'errorCode: \'404\'')) {
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
     * @access		public
     * @var			string		gamertag
     * @var			int			gameid
     * @var			string		region
     * @return		array
     */
    public function fetch_achievements($gamertag, $gameid, $region) {
        $gamertag = trim($gamertag);
        $url = 'https://live.xbox.com/' . $region . '/Activity/Details?titleId=' . urlencode($gameid) . '&compareTo=' . urlencode($gamertag);
        $key = $this->version . ':achievements.' . $gamertag . '.' . $gameid;
        
        $data = $this->__cache->fetch($key);
        if(!$data) {
            $data = $this->fetch_url($url);
            $freshness = 'new';
            $this->__cache->store($key, $data, 3600);
        } else {
            $freshness = 'from cache';
        }
        
        $json = $this->find($data, 'broker.publish(routes.activity.details.load, ', ');');
        $json = json_decode($json, true);
        
        if(!empty($json)) {
            $achievements = array();
            
            $achievements['gamertag'] = $g = $json['Players'][0]['Gamertag'];
            $achievements['game'] = $this->clean($json['Game']['Name']);
            $achievements['id'] = $json['Game']['Id'];
            $achievements['gamerscore']['current'] = $json['Game']['Progress'][$g]['Score'];
            $achievements['gamerscore']['total'] = $json['Game']['PossibleScore'];
            $achievements['achievement']['current'] = $json['Game']['Progress'][$g]['Achievements'];
            $achievements['achievement']['total'] = $json['Game']['PossibleAchievements'];
            $achievements['progress'] = $json['Players'][0]['PercentComplete'];
            $achievements['lastplayed'] = (int)substr(str_replace(array('/Date(', ')/'), '', $json['Game']['Progress'][$g]['LastPlayed']), 0, 10);
            
            $i = 0;
            foreach($json['Achievements'] as $achievement) {
                $achievements['achievements'][$i]['id'] = $achievement['Id'];
                $achievements['achievements'][$i]['title'] = '';

                // find colored achievement tile
                // get image name. removes url and extension
                $ach_info = pathinfo($achievement['TileUrl']);
                // decode image name
                $ach_str1 = base64_decode($ach_info['filename']);
                // remove everything before /ach
                $ach_str2 = strstr($ach_str1, '/ach');
                // subtract last 12 spaces and/or whitespace from string
                $ach_str3 = substr($ach_str2, 0, -11);
                // create color tile source
                $ach_color = 'https://image-ssl.xboxlive.com/global/t.' . dechex($json['Game']['Id']) . $ach_str3;

                $achievements['achievements'][$i]['artwork']['locked'] = $achievement['IsHidden'] ? 'https://live.xbox.com/Content/Images/HiddenAchievement.png' : $achievement['TileUrl'];
                $achievements['achievements'][$i]['artwork']['unlocked'] = $achievement['IsHidden'] ? 'https://live.xbox.com/Content/Images/HiddenAchievement.png' : $ach_color;

                if(!empty($achievement['Name'])) {
                    $achievements['achievements'][$i]['title'] = $this->clean($achievement['Name']);
                } else {
                    $achievements['achievements'][$i]['title'] = 'Secret Achievement';
                }

                if(!empty($achievement['Description'])) {
                    $achievements['achievements'][$i]['description'] = $this->clean($achievement['Description']);
                } else {
                    $achievements['achievements'][$i]['description'] = 'This is a secret achievement. Unlock it to find out more.';
                }
                
                if(!empty($achievement['Score'])) {
                    $achievements['achievements'][$i]['gamerscore'] = $achievement['Score'];
                } else {
                    $achievements['achievements'][$i]['gamerscore'] = 0;
                }

                $achievements['achievements'][$i]['secret'] = ($achievement['IsHidden']) ? true : false;
                
                if(!empty($achievement['EarnDates'][$g]['EarnedOn'])) {
                    $achievements['achievements'][$i]['unlocked'] = true;
                    $achievements['achievements'][$i]['unlockdate'] = (int)substr(str_replace(array('/Date(', ')/'), '', $achievement['EarnDates'][$g]['EarnedOn']), 0, 10);
                } else {
                    $achievements['achievements'][$i]['unlocked'] = false;
                    $achievements['achievements'][$i]['unlockdate'] = null;
                }
                
                $i++;
            }
            
            $achievements['freshness'] = $freshness;
            
            return $achievements;
        } else if(stripos($data, 'errorCode: \'404\'')) {
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
     * @access		public
     * @var			string		gamertag
     * @var			string		region
     * @return		array
     */
    public function fetch_games($gamertag, $region) {
        $gamertag = trim($gamertag);
        $url = 'https://live.xbox.com/' . $region . '/Activity?compareTo=' . urlencode($gamertag);
        $key = $this->version . ':games.' . $gamertag;
        
        $data = $this->__cache->fetch($key);
        if(!$data) {
            $data = $this->fetch_url($url);
            $post_data = '__RequestVerificationToken=' . urlencode(trim($this->find($data, '<input name="__RequestVerificationToken" type="hidden" value="', '" />')));
            $headers = array('X-Requested-With: XMLHttpRequest', 'Content-Type: application/x-www-form-urlencoded; charset=UTF-8');
            
            $data = $this->fetch_url('https://live.xbox.com/' . $region . '/Activity/Summary?compareTo=' . urlencode($gamertag) . '&lc=1033', $url, 10, $post_data, $headers);
            $freshness = 'new';
            $this->__cache->store($key, $data, 3600);
        } else {
            $freshness = 'from cache';
        }
        
        $json = json_decode($data, true);
        
        if($json['Success'] == 'true' && $json['Data']['Players'][0]['Gamertag'] != $this->account_gamertag) {
            $json = $json['Data'];
            $games = array();
            
            $games['gamertag'] = $g = $json['Players'][0]['Gamertag'];
            $games['gamerscore']['current'] = $json['Players'][0]['Gamerscore'];
            $games['gamerscore']['total'] = 0;
            $games['achievements']['current'] = 0;
            $games['achievements']['total'] = 0;
            $games['totalgames'] = $json['Players'][0]['GameCount'];
            $games['progress'] = $json['Players'][0]['PercentComplete'];
            
            $i = 0;
            foreach($json['Games'] as $game) {
                if($game['Progress'][$g]['LastPlayed'] !== 'null') {
                    $games['games'][$i]['id'] = $game['Id'];
                    $games['games'][$i]['isapp'] = ($game['PossibleScore'] == 0) ? true : false;
                    $games['games'][$i]['title'] = $this->clean($game['Name']);
                    $games['games'][$i]['artwork']['small'] = 'http://download.xbox.com/content/images/66acd000-77fe-1000-9115-d802' . dechex($game['Id']) . '/1033/boxartsm.jpg';
                    $games['games'][$i]['artwork']['large'] = 'http://download.xbox.com/content/images/66acd000-77fe-1000-9115-d802' . dechex($game['Id']) . '/1033/boxartlg.jpg';
                    $games['games'][$i]['gamerscore']['current'] = $game['Progress'][$g]['Score'];
                    $games['games'][$i]['gamerscore']['total'] = $game['PossibleScore'];
                    $games['games'][$i]['achievements']['current'] = $game['Progress'][$g]['Achievements'];
                    $games['games'][$i]['achievements']['total'] = $game['PossibleAchievements'];
                    $games['games'][$i]['progress'] = 0;
                    $games['games'][$i]['lastplayed'] = (int)substr(str_replace(array('/Date(', ')/'), '', $game['Progress'][$g]['LastPlayed']), 0, 10);

                    $games['gamerscore']['total'] = $games['gamerscore']['total'] + $games['games'][$i]['gamerscore']['total'];
                    $games['achievements']['current'] = $games['achievements']['current'] + $games['games'][$i]['achievements']['current'];
                    $games['achievements']['total'] = $games['achievements']['total'] + $games['games'][$i]['achievements']['total'];

                    if($game['Progress'][$g]['Achievements'] !== 0) {
                        $games['games'][$i]['progress'] = round((($game['Progress'][$g]['Achievements'] / $game['PossibleAchievements']) * 100), 1);
                    }

                    $i++;
                }
            }
            
            $games['freshness'] = $freshness;
            
            return $games;
        } else if($json['Data']['Players'][0]['Gamertag'] == $this->account_gamertag) {
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
     * @access		public
     * @var			string		gamertag
     * @var			string		region
     * @return		array
     */
    public function fetch_friends($gamertag, $region) {
        $gamertag = trim($gamertag);
        $url = 'https://live.xbox.com/' . $region . '/Friends';
        $key = $this->version . ':friends.' . $gamertag;

        $data = $this->__cache->fetch($key);
        if(!$data) {
            $data = $this->fetch_url($url);
            $post_data = '__RequestVerificationToken=' . urlencode(trim($this->find($data, '<input name="__RequestVerificationToken" type="hidden" value="', '" />')));
            $headers = array('X-Requested-With: XMLHttpRequest', 'Content-Type: application/x-www-form-urlencoded; charset=UTF-8');

            $data = $this->fetch_url('https://live.xbox.com/' . $region . '/Friends/List?Gamertag=' . urlencode($gamertag), $url, 10, $post_data, $headers);
            $freshness = 'new';
            $this->__cache->store($data, 3600);
        } else {
            $freshness = 'from cache';
        }

        $json = json_decode($data, true);
        if($json['Data']['Friends'] != null) {
            $friends = array();
            $friends['total'] = 0;
            $friends['totalonline'] = 0;
            $friends['totaloffline'] = 0;

            $i = 0;
            foreach($json['Data']['Friends'] as $friend) {
                $friends['friends'][$i]['gamertag'] = $friend['GamerTag'];
                $friends['friends'][$i]['gamerpic']['large'] = $friend['GamerTileUrl'];
                $friends['friends'][$i]['gamerpic']['small'] = $friend['LargeGamerTileUrl'];
                $friends['friends'][$i]['gamerscore'] = $friend['GamerScore'];
                $friends['friends'][$i]['online'] = $friend['IsOnline'] == 1 ? true : false;
                $friends['friends'][$i]['status'] = $friend['Presence'];
                $friends['friends'][$i]['lastseen'] = (int)substr(str_replace(array('/Date(', ')/'), '', $friend['LastSeen']), 0, 10);

                $friends['total'] = ++$friends['total'];
                if($friend['IsOnline']) {
                    $friends['totalonline'] = ++$friends['totalonline'];
                } else {
                    $friends['totaloffline'] = ++$friends['totaloffline'];
                }
                ++$i;
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
     * @access		public
     * @var			string		query
     * @var			string		region
     * @return		array
     */
    public function fetch_search($query, $region) {
        $query = trim($query);
        $url = 'http://marketplace.xbox.com/' . $region . '/SiteSearch/xbox/?query=' . urlencode($query);
        $key = $this->version . ':friends.' . $query;

        $data = $this->__cache->fetch($key);
        if(!$data) {
            $data = $this->fetch_url($url);
            $freshness = 'new';
            $this->__cache->store($data, 3600);
        } else {
            $freshness = 'from cache';
        }

        $json = json_decode($data, true);
        if($json['totalEntries'] >= 1) {
            $search = array();
            $search['totalresults'] = $json['totalEntries'];
            $search['resultslink'] = 'http://marketplace.xbox.com' . $json['allResultsUrl'];

            $i = 0;
            foreach($json['entries'] as $entry) {
                $search['results'][$i]['title'] = $entry['title'];
                $search['results'][$i]['parent'] = $entry['parentTitle'];
                $search['results'][$i]['link'] = 'http://marketplace.xbox.com' . $entry['detailsUrl'];
                $search['results'][$i]['image'] = $entry['image'];
                $search['results'][$i]['downloadtype']['class'] = $entry['downloadTypeClass'];
                $search['results'][$i]['downloadtype']['title'] = $entry['downloadTypeText'];
                $search['results'][$i]['prices']['silver'] = $entry['prices']['silver'];
                $search['results'][$i]['prices']['gold'] = $entry['prices']['gold'];
                ++$i;
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

?>