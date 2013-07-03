<?php
/*******************************************************************************
 * XboxLeaders Xbox LIVE REST API                                              *
 * =========================================================================== *
 * @file        cache.class.php                                                *
 * @package     XboxLeadersApi                                                 *
 * @version     2.0                                                            *
 * @copyright   (c) 2013 - Jason Clemons <me@jasonclemons.me>                  *
 * @license     http://opensource.org/licenses/mit-license.php The MIT License *
 *******************************************************************************/

class Cache {
    public $driver = "disk";
    public $root = "/tmp/";
    
    public $hits = 0;
    public $misses = 0;
    public $index = array();
    
    public $__memcached = null;
    
    function __construct($driver = null, $root = null) {
        if($driver) $this->driver = strtolower($driver);
        if($root) $this->root = $root;
        
        if($this->driver == "apc") {
            if(!function_exists("apc_fetch")) $this->driver = "disk";
        } else if($this->driver == "memcached") {
            if(!class_exists("Memcached")) $this->driver = "disk";
        } else if($this->driver == "xcache") {
            if(!function_exists("xcache_get")) $this->driver = "disk";
        }
        
        if($this->driver == "memcached") {
            $this->__memcached = new Memcached();
            $this->__memcached->addServer("localhost", 11211);
        } else if($this->driver == "disk") {
            $file = $this->root . "c_index";
            
            if(!file_exists($file)) {
                $this->save_index();
            } else {
                $this->index = unserialize(file_get_contents($file));
            }
            
            $handle = opendir($this->root);
            if($handle) {
                while(false !== ($file = readdir($handle))) {
                    if(substr($file, 0, 2) == "c_") {
                        $key = str_replace(array("c_", ".cache"), "", $file);
                        $created = filemtime($this->root . $file);
                        $ttl = (int)$this->index[$key]['ttl'];
                        $expires = $created + $ttl;
                        
                        if($expires < time() && $ttl !== 0) {
                            unlink($this->root . $file);
                            unset($this->index[$key]);
                        }
                    }
                }
                closedir($handle);
            }
            
            $this->save_index();
        }
    }
    
    public function fetch($key) {
        if($this->driver == "apc") {
            $data = apc_fetch($key);
        } else if($this->driver == "xcache") {
            $data = xcache_get($key);
        } else if($this->driver == "memcached") {
            $data = $this->__memcached->get($key);
        } else if($this->driver == "disk") {
            $file = $this->get_filename($key);
            if(file_exists($file)) {
                $data = file_get_contents($file);
            }
        }
        
        if(isset($data) && $data) {
            $this->hits++;
        } else {
            $this->misses++;
        }
        
        $data = unserialize($data);
        
        return $data;
    }
    
    public function store($key, $data, $ttl = 0) {
        $data = serialize($data);
        
        if($this->driver == "apc") {
            return apc_store($key, $data, $ttl);
        } else if($this->driver == "memcached") {
            return $this->__memcached->set($key, $data, $ttl);
        } else if($this->driver == "xcache") {
            return xcache_set($key, $data, $ttl);
        } else if($this->driver == "disk") {
            $file = $this->get_filename($key);
            
            if(file_exists($file)) {
                unlink($file);
            }
            
            $handle = fopen($file, "w");
            fwrite($handle, $data);
            fclose($handle);
            
            $this->index[$key] = array(
                "ttl" => $ttl
            );
            
            $this->save_index();
            
            return true;
        }
    }
    
    public function remove($key) {
        if($this->driver == "apc") {
            return apc_delete($key);
        } else if($this->driver == "memcached") {
            return $this->__memcached->delete($key);
        } else if($this->driver == "xcache") {
            return xcache_unset($key);
        } else if($this->driver == "disk") {
            $file = $this->get_filename($key);
            
            if(file_exists($file)) {
                unlink($file);
            }
            
            unset($this->index[$key]);
            $this->save_index();
            
            return true;
        }
    }
    
    protected function save_index() {
        $file = $this->root . "c_index";
        
        $handle = fopen($file, "w");
        fwrite($handle, serialize($this->index));
        fclose($handle);
    }
    
    protected function get_filename($key) {
        return $this->root . "c_" . $key . ".cache";
    }
}

?>