<?php

require 'lib/__Crypt.php';

// namespace Composer\ClassLoader;

class cache{

    /**
     * @param package PHP-Cache
     * @param author Striker Technologies
     * @param features For easiy caching in php
     * @param version 1.3
     */

    //Public Access Variables
     public $cache_ID;
     public $encrypted = false;
     public $ciphering = null;
     public $encryptIV = null;
     public $encryptKey = "@R(hIv£";
     public $decryptKey = "@R(hIv£";
     public $decryptIV = null;
     public $cacheFolder = 'cache';


    function __construct(string $cacheid)
    {
        /**
         * @param cacheid unique identifier for cache data
         */
        $this->cache_ID = $cacheid;
    }

    public function create(){
        /**
         * @param create create the cache file in the corresponding cache folder
         */
        //CREATES CACHE FILE AND DIRECTORY
        if(!is_dir($this->cacheFolder)){
            mkdir($this->cacheFolder);
        }
        if(!file_exists($this->cacheFolder .'/cacheID_'. $this->cache_ID.'.txt')){
            $handle = fopen($this->cacheFolder .'/cacheID_'. $this->cache_ID.'.txt', "x");
            fclose($handle);
            return true;
        }else{
            return false;
        }
    }

    public function insert($values){
        /**
         * @param values Data to store in cache at the (Writes at the end of the file)
         */
        $streamPath = $this->cacheFolder . '/cacheID_'. $this->cache_ID. '.txt';
        $stream = fopen($streamPath, 'a');
        if(is_resource($stream) && !empty($values)){
            //CHECK IF THE THE ENCRYPTION FOR THE CLASS IS SET TO TRUE
            if($this->encrypted == True){
                $values = encrypt($values, $this->cache_ID, $this->encryptIV, $this->encryptKey, $this->ciphering);
            }
            fwrite($stream, $values);
            fclose($stream);
            return true;
        }else{
            return False;
        }
    }

    public function flash($values){
        /**
         * @param values Data to store in cache at the (Writes at the end of the file)
         */
        $filePath = $this->cacheFolder . '/cacheID_'. $this->cache_ID. '.txt';
        if(!empty($values)){
            //CHECK IF THE THE ENCRYPTION FOR THE CLASS IS SET TO TRUE
            if($this->encrypted == True){
                $values = encrypt($values, $this->cache_ID, $this->encryptIV, $this->encryptKey, $this->ciphering);
            }
            file_put_contents($filePath, $values);
            return true;
        }else{
            return False;
        }
    }

    public function read(){
        /**
         * @param read reads the content of the cache
         */
        $streamPath = $this->cacheFolder . '/cacheID_' . $this->cache_ID . '.txt';
        $stream = fopen($streamPath, 'r');
        if (filesize($streamPath) > 0) {
            $cacheData = fread($stream, filesize($streamPath));
            fclose($stream);
            return $cacheData;
        } else {
            return false;
        }
    }

    public function decode($cacheContent){
        /**
         * @param cacheContent The content of the cache
         */
        //CHECK IF THE THE ENCRYPTION FOR THE CLASS IS SET TO TRUE
        if($this->encrypted == True){
            $values = decrypt($cacheContent, $this->cache_ID, $this->encryptIV, $this->encryptKey, $this->ciphering);
            return $values;
        }else{
            return false;
        }
    }

    public function wipeCache(){
        /**
         * @param deleteCache it deletes the cache
         */
        $streamPath = $this->cacheFolder . '/cacheID_' . $this->cache_ID . '.txt';
        if(unlink($streamPath)){
            return true;
        }else{
            return False;
        }
    }

}

?>