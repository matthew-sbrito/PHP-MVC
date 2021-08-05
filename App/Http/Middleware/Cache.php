<?php 

namespace App\Http\Middleware;
use App\Utils\Cache\File as CacheFile;

class Cache {

  private function isCacheable($request){
    //VALIDAÇÕES
    if(getenv('CACHE_TIME') <= 0) return false;

    if($request->getHttpMethod() != 'GET') return false;

    $headers = $request->getHeaders();
    if(isset($headers['Cache-Control']) and $headers['Cache-Control'] == 'no-cache') return false;
    
    //CACHEAVEL
    return true;
  }

  /**
   * Método resposável por executar o middleware
   * @param   Request  
   * @param   Closure  next
   * @return  Response 
   */
  public function handle($request, $next){
    
    if(!$this->isCacheable($request)) return $next($request);
    
    $hash = $this->getHash($request);
    
    // RETORNA OS DADOS DO CACHE
    return CacheFile::getCache($hash, getenv('CACHE_TIME'), function() use($next, $request){
      return $next($request);
    });
  }
  private function getHash($request){
    
    $uri = $request->getRouter()->getUri();
    $queryParams = $request->getQueryParams();
    $uri .= !empty($queryParams) ? '?'. http_build_query($queryParams) : '';

    return rtrim('route-'.preg_replace('/[^0-9a-zA-Z]/','-',ltrim($uri,'/')),'-');
  }
}