<?php

namespace App\Utils\Cache;

class File {

  private static function getFilePath($hash){
    $dir = getenv('CACHE_DIR');

    if(!file_exists($dir)){
      mkdir($dir, 0777, true);
    }
    return $dir.'/'.$hash;
  }

  private static function storageCache($hash, $content){
    
    $serialize = serialize($content);
    $cacheFile = self::getFilePath($hash);
    return file_put_contents($cacheFile, $serialize);

  }

  private static function getContentCache($hash, $expiration){
    $cacheFile = self::getFilePath($hash);

    if(!file_exists($cacheFile)) return false;
    
    $createTime = filectime($cacheFile);
    $diffTime = time() - $createTime;
    
    if($diffTime > $expiration) return false;
    
    $serialize = file_get_contents($cacheFile);
    return unserialize($serialize);

  }

  public static function getCache($hash, $expiration, $function){
    if($content = self::getContentCache($hash, $expiration)){
      return $content;
    }

    $content = $function();
    
    self::storageCache($hash, $content);

    return $content;
  }
}