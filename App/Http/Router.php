<?php

namespace App\Http;

use \Closure;
use \Exception;

class Router{
    
    /**
     *  URL completa do projeto (raiz)
     * @var string
     */ 
    private $url = '';

    /**
     *  Prefixo de todas as rotas
     * @var string
     */
    private $prefix = '';

    /**
     *  Indice de rotas
     * @var array
     */
    private $routes = [];

    /**
     * Instancia de Request
     * @var Request
     */
    private $request;


    /**
     *  Método responsável por iniciar a classe
     * @param string
     */
    public function __construct($url){
        $this->request  = new Request;
        $this->url      = $url;
        $this->setPrefix();
    }

    /**
     *  Método responsável por definir o prefixo das rotas
     */
    private function setPrefix(){
        //INFORMAÇÕES DA URL ATUAL
        $parseUrl = parse_url($this->url);
        
        //DEFINE O PREFIXO
        $this->prefix = $parseUrl['path'] ?? '';
    }

    /**
     *  Método responsável por adicionar uma rota na classe
     * @param string
     * @param string
     * @param array
     */
    private function addRouter($method, $route, $params = []){
        
        //VALIDAÃO DOS PARAMS
        foreach($params as $key => $value) {
            if($value instanceof Closure) {
                $params['controller'] = $value;
                unset($params[$key]);
                continue;
            }
        }  

        //PADRÃO DE VALIDAÇÃO DA URL
        $patternRoute = '/^'. str_replace('/', '\/', $route). '$';
       
        //ADICIONA A ROTA DENTRO DA CLASSE
        $this->routes[$patternRoute][$method] = $params;       

    }

    /**
     *  Método responsável por definir uma rota no GET 
     * @param string
     * @param array
     */
    public function get($route, $params = []){
        return $this->addRouter('GET', $route, $params);
    }

    /**
     * Método responsável por executar a rota atual.
     * @return Response
     * 
     */
    public function run(){
        try{

            throw new Exception("Página não encontrada!", 404);

        }catch(Exception $e){
            return new Response($e->getCode(), $e->getMessage());
        }
    }
}