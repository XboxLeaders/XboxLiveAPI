<?php
namespace XboxLeaders\XboxApi\Errors;

use XboxLeaders\XboxApi\Config;

class Errors
{
    public $errors = array(
        300 => 'The key supplied was not valid.',
        301 => 'The gamertag supplied was not valid.',
        302 => 'The gameid supplied was not valid.',
        303 => 'No version specified.',
        304 => 'No method specified.',
        305 => 'The region supplied is not supported by Xbox LIVE.',
        306 => 'The query supplied was not valid.',
        500 => 'There was an internal server error.',
        501 => 'The gamertag supplied does not exist on Xbox Live.',
        502 => 'The gamertag supplied has never played this game or does not exist on Xbox Live.',
        503 => 'No friends found, or friend\'s list is set to private.',
        504 => 'The search query returned empty.',
        600 => 'Could not login to Windows Live. Please email support@xboxleaders.com.',
        601 => 'The Windows Live email address supplied was invalid.',
        602 => 'The Windows Live password supplied was invalid.',
        603 => 'Could not write to the cookie file.',
        604 => 'Could not write to the debug file.',
        605 => 'Could not write to the stack trace file.',
        606 => 'Windows Live caused an infinite redirect loop.',
        607 => 'The server timed out when trying to fetch some data.',
        608 => 'Could not write to the access file.',
        700 => 'The Xbox LIVE Service is down.'
    );

    protected function save_to_debug($string)
    {
        if ($this->debug) {
            $file = fopen($this->debug_file, 'a+');

            if (!$file) {
                $this->error = 604;
            } else {
                fwrite($file, '[' . date('Y-m-d H:i:s') . '] (' . $this->version . ') ' . $string . "\n");
                fclose($file);
            }
        }
    }

    protected function save_stack_trace()
    {
        if ($this->debug) {
            $file = fopen($this->stack_trace_file, 'w');
            if (!$file) {
                $this->error = 605;
            } else {
                fwrite($file, print_r($this->stack_trace, true));
                fclose($file);
            }
        }
    }
}
