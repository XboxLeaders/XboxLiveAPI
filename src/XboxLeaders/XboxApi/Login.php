<?php
namespace XboxLeaders\XboxApi\Login;

use XboxLeaders\XboxApi\Config;
use XboxLeaders\XboxApi\Cookie;
use XboxLeaders\XboxApi\Errors;
use XboxLeaders\XboxApi\Utils;

class Login
{
    private $cookie;
    private $errors;

    protected function perform_login()
    {
        $this->cookie = new Cookie();
        $this->errors = new Errors();

        if (empty($this->email))
        {
            $this->errors->error = 601;
            return false;
        }
        elseif (empty($this->password))
        {
            $this->errors->error = 602;
            return false;
        }
        else
        {
            $cookie->add_cookie('.xbox.com', 'MC0', time(), '/', time() + (60*60*24*365));
            $cookie->add_cookie('.xbox.com', 's_vi', '[CS]v1|26AD59C185011B4D-40000113004213F1[CE]', '/', time() + (60*60*24*365));
            $cookie->add_cookie('.xbox.com', 's_nr', '1297891791797', '/', time() + (60*60*24*365));
            $cookie->add_cookie('.xbox.com', 's_sess', '%20s_cc%3Dtrue%3B%20s_ria%3Dflash%252011%257Csilverlight%2520not%2520detected%3B%20s_sq%3D%3B', '/', time() + (60*60*24*365));
            $cookie->add_cookie('.xbox.com', 's_pers', '%20s_vnum%3D1352674046430%2526vn%253D4%7C1352674046430%3B%20s_lastvisit%3D1324587801077%7C1419195801077%3B%20s_invisit%3Dtrue%7C1324589873289%3B', '/', time() + (60*60*24*365));
            $cookie->add_cookie('.xbox.com', 'UtcOffsetMinutes', '60', '/', time() + (60*60*24*365));
            $cookie->add_cookie('.xbox.com', 'xbox_info', 't=6', '/', time() + (60*60*24*365));
            $cookie->add_cookie('.xbox.com', 'PersistentId', '0a652e56e40f42caac3ac84fad02ed01', '/', time() + (60*60*24*365));

            $url = 'https://login.live.com/login.srf?wa=wsignin1.0&rpsnv=11&ct=' . time() . '&rver=6.0.5286.0&wp=MBI&wreply=https://live.xbox.com:443/xweb/live/passport/setCookies.ashx%3Frru%3Dhttp%253a%252f%252fwww.xbox.com%252fen-US%252f&flc=3d1033&lc=1033&cb=reason=0&returnUrl=http%253a%252f%252fwww.xbox.com%252fen-US%252f%253flc%253d1033&id=66262';
            $result = $this->fetch_url($url, 'http://www.xbox.com/en-US/');

            $this->stack_trace[] = array(
                'url'      => $url,
                'postdata' => '',
                'result'   => $result
            );

            $cookie->add_cookie('.login.live.com', 'WLOpt', 'act=[1]', time() + (60*60*24*365));
            $cookie->add_cookie('.login.live.com', 'CkTst', 'G' . time(), '/', time() + (60*60*24*365));

            $url  = $this->find($result, 'urlPost:\'', '\',');
            $PPFT = $this->find($result, 'name="PPFT" id="i0327" value="', '"');
            $PPSX = $this->find($result, 'srf_sRBlob=\'', '\';');

            $post_data = 'login=' . XBOX_EMAIL . '&passwd=' . XBOX_PWORD . '&KMSI=1&mest=0&type=11&LoginOptions=3&PPSX=' . $PPSX . '&PPFT=' . $PPFT . '&idsbho=1&PwdPad=&sso=&i1=1&i2=1&i3=12035&i12=1&i13=1&i14=323&i15=3762&i18=__Login_Strings%7C1%2C__Login_Core%7C1%2C';
            $result = $this->fetch_url($url, 'https://login.live.com/login.srf', null, $post_data);

            $this->stack_trace[] = array(
                'url'       => $url,
                'post_data' => $post_data,
                'result'    => $result
            );

            $cookie->add_cookie('.live.com', 'wlidperf', 'throughput=3&latency=961&FR=L&ST=1297790188859', '/', time() + (60*60*24*365));
            $cookie->add_cookie('login.live.com', 'CkTst', time(), '/ppsecure/', time() + (60*60*24*365));

            $url  = $this->find($result, 'id="fmHF" action="', '"');
            $NAP  = $this->find($result, 'id="NAP" value="', '"');
            $ANON = $this->find($result, 'id="ANON" value="', '"');
            $t    = $this->find($result, 'id="t" value="', '"');

            $cookie->add_cookie('.xbox.com', 'ANON', $ANON, '/', time() + (60*60*24*365));
            $cookie->add_cookie('.xbox.com', 'NAP', $NAP, '/', time() + (60*60*24*365));

            $post_data = 'NAPExp=' . date('c', mktime(date('H'), date('i'), date('s'), date('n') + 1)) . '&NAP=' . $NAP . '&ANONExp=' . date('c', mktime(date('H'), date('i'), date('s'), date('n') + 1)) . '&ANON=' . $ANON . '&t=' . $t;
            $result = $this->fetch_url($url, '', 16, $post_data);

            $this->stack_trace[] = array(
                'url'       => $url,
                'post_data' => $post_data,
                'result'    => $result
            );

            $result = $this->fetch_url('http://www.xbox.com/en-US/');

            if (stripos($result, 'currentUser.isSignedIn = true') !== false)
            {
                $this->logged_in = true;
                return true;
            }
            else
            {
                $this->error = 600;
                $this->save_stack_trace();
                return false;
            }
        }
    }

    protected function check_login()
    {
        if (file_exists(COOKIE_JAR))
        {
            if (time() - filemtime(COOKIE_JAR) >= 3600 || filesize(COOKIE_JAR) == 0)
            {
                $this->empty_cookie_file();
                $this->logged_in = false;
                return false;
            }
            else
            {
                $this->logged_in = true;
                return true;
            }
        }
        else
        {
            $this->empty_cookie_file();
            $this->logged_in = false;
            return false;
        }
    }

    protected function force_new_login()
    {
        Cookie\empty_cookie_file();
        $this->logged_in = false;
        $this->perform_login();

        if ($this->logged_in)
        {
            return true;
        }

        return false;
    }
}
