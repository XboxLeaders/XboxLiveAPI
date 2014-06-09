<?php
namespace XboxLeaders\XboxApi\Utils;

use XboxLeaders\XboxApi\Config;

class Utils
{
    protected function check_culture($code)
    {
        $valid_codes = array(
            'es-AR',	'en-AU',	'de-AT',	'nl-BE',
            'fr-BE',	'pt-BR',	'en-CA',	'fr-CA',
            'es-CL',	'es-CO',	'cs-CZ',	'da-DA',
            'fi-FI',	'fr-FR',	'de-DE',	'el-GR',
            'zh-HK',	'en-HK',	'hu-HU',	'en-ID',
            'en-IE',	'he-IL',	'it-IT',	'ja-JP',
            'ko-KR',	'es-MX',	'nl-NL',	'en-NZ',
            'nb-NO',	'nn-NO',	'pl-PL',	'ru-RU',
            'en-SA',	'en-SG',	'sk-SK',	'en-ZA',
            'es-ES',	'sv-SE',	'de-CH',	'fr-CH',
            'zh-TW',	'tr-TR',	'en-UA',	'en-GB',
            'en-US'
        );

        return in_array($code, $valid_codes, true);
    }

    protected function find($haystack, $start, $finish)
    {
        if (!empty($haystack))
        {
            $s = explode($start, $haystack);

            if (!empty($s[1]))
            {
                $s = explode($finish, $s[1]);
                if (!empty($s[0]))
                {
                    return $s[0];
                }
            }
        }

        return false;
    }

    protected function clean($string)
    {
        $string = html_entity_decode($string, ENT_QUOTES, 'UTF-8');
        $string = htmlentities($string, ENT_QUOTES, 'UTF-8');

        if (function_exists('mb_convert_encoding'))
        {
            $string = mb_convert_encoding($string, 'UTF-8');
        }
        else
        {
            $string = utf8_decode($string);
        }

        return $string;
    }
}
