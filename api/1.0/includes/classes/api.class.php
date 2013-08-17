<?php
/**
 * XboxLeaders API - Xbox LIVE Data Aggregator
 *
 * @file		/1.0/includes/classes/api.class.php
 * @package		XboxLeaders API
 * @version		1.0
 * @copyright	(c) 2013 - Jason Clemons <me@jasonclemons.me>
 * @license		http://opensource.org/licenses/mit-license.php The MIT License
 */

class API extends Base {
	/**
	 * Version of this API
	 */
	public $version = "1.0";

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
		$url = "http://live.xbox.com/" . $region . "/Profile?gamertag=" . urlencode($gamertag);
		$key = $this->version . ":profile." . $gamertag;
		
		$data = $this->__cache->fetch($key);
		if(!$data) {
			$data = $this->fetch_url($url);
			$this->__cache->store($key, $data, 3600);
		}

		if(stripos($data, "<section class=\"contextRail custom\">")) {
			$user = array();
			$user['Tier'] = (strpos($data, "<div class=\"goldBadge\">") !== false) ? "gold" : "silver";
			$user['IsValid'] = (strpos($data, "errorCode: '404'") !== false) ? 0 : 1;
			$user['IsCheater'] = (strpos($data, "<div class=\"cheater\">") !== false) ? 1: 0;
			$user['IsOnline'] = 0;
			$user['OnlineStatus'] = trim(str_replace("\r\n", " - ", trim($this->find($data, "<div class=\"presence\">", "</div>"))));
			if (strpos($data, '<div class="badges">') !== false) {
				$user['XBLLaunchTeam'] = (strpos($data, 'xbox360Badge') !== false) ? 1 : 0;
				$user['NXELaunchTeam'] = (strpos($data, 'nxeBadge') !== false) ? 1 : 0;
				$user['KinectLaunchTeam'] = (strpos($data, 'kinectBadge') !== false) ? 1 : 0;
			}
			$user['AvatarTile'] = str_replace("https://avatar-ssl", "http://avatar", $this->find($data, "<img class=\"gamerpic\" src=\"", "\" alt"));
			$user['AvatarSmall'] = "http://avatar.xboxlive.com/avatar/" . $gamertag . "/avatarpic-s.png";
			$user['AvatarLarge'] = "http://avatar.xboxlive.com/avatar/" . $gamertag . "/avatarpic-l.png";
			$user['AvatarBody'] = "http://avatar.xboxlive.com/avatar/" . $gamertag . "/avatar-body.png";
			$user['AvatarTileSSL'] = $this->find($data, "<img class=\"gamerpic\" src=\"", "\" alt");
			$user['AvatarSmallSSL'] = str_replace("http://avatar", "https://avatar-ssl", $user['AvatarSmall']);
			$user['AvatarLargeSSL'] = str_replace("http://avatar", "https://avatar-ssl", $user['AvatarLarge']);
			$user['AvatarBodySSL'] = str_replace("http://avatar", "https://avatar-ssl", $user['AvatarBody']);
			$user['Gamertag'] = str_replace(array("&#39;s Profile", "'s Profile"), "", trim($this->find($data, "<h1 class=\"pageTitle\">", "</h1>")));
			$user['GamerScore'] = trim($this->find($data, "<div class=\"gamerscore\">", "</div>"));
			$user['Reputation'] = 0;
			$user['Name'] = "";
			$user['Motto'] = "";
			$user['Location'] = "";
			$user['Bio'] = "";

			$user['IsOnline'] = (strpos($user['OnlineStatus'], "Last seen") !== false 
				or (strpos($user['OnlineStatus'], 'Offline') !== false) 
				or (trim(empty($user['OnlineStatus'])))) ? 0 : 1;

			if(strpos($data, "<div class=\"motto\">") !== false) {
				$user['Motto'] = $this->clean(trim(strip_tags($this->find($data, "<div class=\"motto\">", "</div>"))));
			}
			if(strpos($data, "<div class=\"name\" title=\"") !== false) {
				$user['Name'] = trim(strip_tags($this->find($data, "<div class=\"name\" title=\"", "\">")));
			}
			if(strpos($data, "<div class=\"location\">") !== false) {
				$user['Location'] = trim(strip_tags(str_replace("<label>Location:</label>", "", trim($this->find($data, "<div class=\"location\">", "</div>")))));
			}
			if(strpos($data, "<div class=\"bio\">") !== false) {
				$user['Bio'] = trim(strip_tags(str_replace("<label>Bio:</label>", "", trim($this->find($data, "<div class=\"bio\">", "</div>")))));
			}

			preg_match_all('~<div class="Star (.*?)"></div>~si', $data, $reputation);
			foreach ($reputation[1] as $k => $v) {
				$starvalue = array(
					'Empty' => 0, 'Quarter' => 1, 'Half' => 2,
					'ThreeQuarter' => 3, 'Full' => 4
				);
				$user['Reputation'] = $user['Reputation'] + $starvalue[$v];
			}
			
			return $user;
		} else if(stripos($data, "errorCode: '404'")) {
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
	 * @var			int			titleid
	 * @var			string		region
	 * @return		array
	 */
	public function fetch_achievements($gamertag, $titleid, $region) {
		$gamertag = trim($gamertag);
		$url = "https://live.xbox.com/" . $region . "/Activity/Details?titleId=" . urlencode($titleid) . "&compareTo=" . urlencode($gamertag);
		$key = $this->version . ":achievements." . $gamertag . "." . $titleid;
		
		$data = $this->__cache->fetch($key);
		if(!$data) {
			$data = $this->fetch_url($url);
			$this->__cache->store($key, $data, 3600);
		}
		
		$json = $this->find($data, "broker.publish(routes.activity.details.load, ", ");");
		$json = json_decode($json, true);
		
		if(!empty($json)) {
			$achievements = array();
			
			$achievements['Gamertag'] = $g = $json['Players'][0]['Gamertag'];
			$achievements['Id'] = $json['Game']['Id'];
			$achievements['Title'] = $this->clean($json['Game']['Name']);
			$achievements['Url'] = "http://marketplace.xbox.com/" . $region . "/" . $achievements['Id'];
			$achievements['BoxArt'] = "http://download.xbox.com/content/images/66acd000-77fe-1000-9115-d802" . dechex($achievements['Id']) . "/1033/boxartsm.jpg";
			$achievements['LargeBoxArt'] = "http://download.xbox.com/content/images/66acd000-77fe-1000-9115-d802" . dechex($achievements['Id']) . "/1033/boxartlg.jpg";
			$achievements['EarnedGamerScore'] = $json['Game']['Progress'][$g]['Score'];
			$achievements['PossibleGamerScore'] = $json['Game']['PossibleScore'];
			$achievements['EarnedAchievements'] = $json['Game']['Progress'][$g]['Achievements'];
			$achievements['PossibleAchievements'] = $json['Game']['PossibleAchievements'];
			$achievements['LastPlayed'] = substr(str_replace(array("/Date(", ")/"), "", $json['Game']['Progress'][$g]['LastPlayed']), 0, 10);
			
			$i = 0;
			foreach($json['Achievements'] as $achievement) {
				$achievements['Achievements'][$i]['Id'] = $achievement['Id'];
				$achievements['Achievements'][$i]['TileUrl'] = ($achievement['IsHidden'] == "true") ? "https://live.xbox.com/Content/Images/HiddenAchievement.png" : $achievement['TileUrl'];
				$achievements['Achievements'][$i]['Title'] = "";
				$achievements['Achievements'][$i]['Description'] = "";

				if(!empty($achievement['Name'])) {
					$achievements['Achievements'][$i]['Title'] = $this->clean($achievement['Name']);
				} else {
					$achievements['Achievements'][$i]['Title'] = "Secret Achievement";
				}

				if(!empty($achievement['Description'])) {
					$achievements['Achievements'][$i]['Description'] = $this->clean($achievement['Description']);
				} else {
					$achievements['Achievements'][$i]['Description'] = "This is a secret achievement. Unlock it to find out more.";
				}
				
				if(!empty($achievement['Score'])) {
					$achievements['Achievements'][$i]['GamerScore'] = $achievement['Score'];
				} else {
					$achievements['Achievements'][$i]['GamerScore'] = "--";
				}

				$achievements['Achievements'][$i]['IsSecret'] = ($achievement['IsHidden']) ? "yes" : "no";
				
				if(!empty($achievement['EarnDates'][$g]['EarnedOn'])) {
					$achievements['Achievements'][$i]['Unlocked'] = "yes";
					$achievements['Achievements'][$i]['DateEarned'] = substr(str_replace(array("/Date(", ")/"), "", $achievement['EarnDates'][$g]['EarnedOn']), 0, 10);
					$achievements['Achievements'][$i]['EarnedOffline'] = ($achievement['EarnDates'][$g]['IsOffline'] == "true") ? "yes" : "no";
				} else {
					$achievements['Achievements'][$i]['Unlocked'] = "no";
					$achievements['Achievements'][$i]['DateEarned'] = null;
					$achievements['Achievements'][$i]['EarnedOffline'] = null;
				}

				$i++;
			}

			return $achievements;
		} else if(stripos($data, "errorCode: '404'")) {
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
		$url = "https://live.xbox.com/" . $region . "/Activity?compareTo=" . urlencode($gamertag);
		$key = $this->version . ":games." . $gamertag;

		$data = $this->__cache->fetch($key);
		if(!$data) {
			$data = $this->fetch_url($url);
			$post_data = "__RequestVerificationToken=" . urlencode(trim($this->find($data, "<input name=\"__RequestVerificationToken\" type=\"hidden\" value=\"", "\" />")));
			$headers = array("X-Requested-With: XMLHttpRequest", "Content-Type: application/x-www-form-urlencoded; charset=UTF-8");
			
			$data = $this->fetch_url("https://live.xbox.com/" . $region . "/Activity/Summary?compareTo=" . urlencode($gamertag) . "&lc=1033", $url, 10, $post_data, $headers);
			$this->__cache->store($key, $data, 3600);
		}

		$json = json_decode($data, true);

		if($json['Success'] == "true" && $json['Data']['Players'][0]['Gamertag'] != "xboxleaders com") {
			$json = $json['Data'];
			$games = array();

			$games['Gamertag'] = $g = $json['Players'][0]['Gamertag'];
			$games['Gamerpic'] = "http://avatar.xboxlive.com/avatar/" . $games['Gamertag'] . "/avatarpic-l.png";
			$games['GameCount'] = $json['Players'][0]['GameCount'];
			$games['TotalEarnedGamerScore'] = $json['Players'][0]['Gamerscore'];
			$games['TotalPossibleGamerScore'] = 0;
			$games['TotalEarnedAchievements'] = 0;
			$games['TotalPossibleAchievements'] = 0;
			$games['TotalPercentCompleted'] = $json['Players'][0]['PercentComplete'];

			$i = 0;
			foreach($json['Games'] as $game) {
				if($game['Progress'][$g]['LastPlayed'] !== "null" && $game['PossibleScore'] !== 0) {
					$games['PlayedGames'][$i]['Id'] = $game['Id'];
					$games['PlayedGames'][$i]['Title'] = $game['Name'];
					$games['PlayedGames'][$i]['Url'] = "http://marketplace.xbox.com/" . $region . "/Title/" . $game['Id'] . "/";
					$games['PlayedGames'][$i]['BoxArt'] = "http://download.xbox.com/content/images/66acd000-77fe-1000-9115-d802" . dechex($game['Id']) . "/1033/boxartsm.jpg";
					$games['PlayedGames'][$i]['LargeBoxArt'] = "http://download.xbox.com/content/images/66acd000-77fe-1000-9115-d802" . dechex($game['Id']) . "/1033/boxartlg.jpg";
					$games['PlayedGames'][$i]['EarnedGamerScore'] = $game['Progress'][$g]['Score'];
					$games['PlayedGames'][$i]['PossibleGamerScore'] = $game['PossibleScore'];
					$games['PlayedGames'][$i]['EarnedAchievements'] = $game['Progress'][$g]['Achievements'];
					$games['PlayedGames'][$i]['PossibleAchievements'] = $game['PossibleAchievements'];
					$games['PlayedGames'][$i]['PercentageCompleted'] = round((($game['Progress'][$g]['Achievements'] / $game['PossibleAchievements']) * 100), 1);
					$games['PlayedGames'][$i]['LastPlayed'] = (int)substr(str_replace(array("/Date(", ")/"), "", $game['Progress'][$g]['LastPlayed']), 0, 10);

					$games['TotalPossibleGamerScore'] = $games['TotalPossibleGamerScore'] + $games['PlayedGames'][$i]['PossibleGamerScore'];
					$games['TotalEarnedAchievements'] = $games['TotalEarnedAchievements'] + $games['PlayedGames'][$i]['EarnedAchievements'];
					$games['TotalPossibleAchievements'] = $games['TotalPossibleAchievements'] + $games['PlayedGames'][$i]['PossibleAchievements'];

					$i++;
				}
			}

			return $games;
		} else if($json['Data']['Players'][0]['Gamertag'] == "xboxleaders com") {
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
		$url = "https://live.xbox.com/" . $region . "/Friends";
		$key = $this->version . ":friends." . $gamertag;

		$data = $this->__cache->fetch($key);
		if(!$data) {
			$data = $this->fetch_url($url);
			$post_data = "__RequestVerificationToken=" . urlencode(trim($this->find($data, "<input name=\"__RequestVerificationToken\" type=\"hidden\" value=\"", "\" />")));
			$headers = array("X-Requested-With: XMLHttpRequest", "Content-Type: application/x-www-form-urlencoded; charset=UTF-8");

			$data = $this->fetch_url("https://live.xbox.com/" . $region . "/Friends/List?Gamertag=" . urlencode($gamertag), $url, 10, $post_data, $headers);
			$this->__cache->store($data, 3600);
		}

		$json = json_decode($data, true);
		if(!empty($json['Data']['Friends'])) {
			$friends = array();
			$friends['TotalFriends'] = 0;
			$friends['TotalOnlineFriends'] = 0;
			$friends['TotalOfflineFriends'] = 0;

			$i = 0;
			foreach($json['Data']['Friends'] as $friend) {
				$friends['Friends'][$i]['Gamertag'] = $friend['GamerTag'];
				$friends['Friends'][$i]['AvatarSmall'] = $friend['GamerTileUrl'];
				$friends['Friends'][$i]['AvatarLarge'] = $friend['LargeGamerTileUrl'];
				$friends['Friends'][$i]['GamerScore'] = $friend['GamerScore'];
				$friends['Friends'][$i]['IsOnline'] = $friend['IsOnline'] == 1 ? "true" : "false";
				$friends['Friends'][$i]['PresenceInfo']['LastOnline'] = substr(str_replace(array("/Date(", ")/"), "", $friend['LastSeen']), 0, 10);
				$friends['Friends'][$i]['PresenceInfo']['OnlineStatus'] = $friend['Presence'];
				$friends['Friends'][$i]['PresenceInfo']['Game']['Title'] = $friend['TitleInfo']['Name'];
				$friends['Friends'][$i]['PresenceInfo']['Game']['Id'] = $friend['TitleInfo']['Id'];
				$friends['Friends'][$i]['PresenceInfo']['Game']['Url'] = "http://marketplace.xbox.com/" . $region . "/Title/" . $friend['TitleInfo']['Id'] . "/";

				$friends['TotalFriends'] = ++$friends['TotalFriends'];
				if($friend['IsOnline']) {
					$friends['TotalOnlineFriends'] = ++$friends['TotalOnlineFriends'];
				} else {
					$friends['TotalOfflineFriends'] = ++$friends['TotalOfflineFriends'];
				}
				++$i;
			}

			return $friends;
		} else {
			$this->error = 503;
			$this->__cache->remove($key);
			$this->force_new_login();

			return false;
		}
	}
}

?>