<?php

namespace App\Http;

class Request{

    /** 
     *  Método HTTP da requisição
     * @var string
     */
    private $httpMethod;

    /**
     *  URI da página
     * @var string
     */
    private $uri;
    
    /**
     *  Parâmetros da URL ($_GET)
     * @var array
     */
    private $queryParams = [];

    /**
     *  Váriaveis recebidas no Método POST da página ($_POST)
     * @var array
     */
    private $postVars = [];

     /**
     *  Cabeçalho da requisição
     * @var array
     */
    private $headers = [];

    /**
     *  Router da página
     * @var Router
     */
    private $router = [];

    /**
     *  Construtor da classe 
     */
    public function __construct($router){
        $this->router       = $router;
        $this->queryParams  = $_GET ?? [];
        $this->headers      = getallheaders();
        $this->httpMethod   = $_SERVER['REQUEST_METHOD'] ?? '';
        $this->setUri();
        $this->setPostVars();
    }
    
    private function setPostVars(){
        if($this->httpMethod == 'GET') return false;
        
        foreach($_POST as $key => $value){
            $array[strtoupper($key)] = $value;
        }
        
        $this->postVars = $array ?? [];
        $this->getJsonObject();
        $this->sanitize();
    }

    private function setUri(){
        $uri = $_SERVER['REQUEST_URI'] ?? '';
        $xUri = explode('?', $uri); 
        $this->uri = $xUri[0];
    }

    /** 
     *  Método responsável por retornar o router
     *   @return Router
     */
    public function getRouter(){
        return $this->router;
    }
    /** 
     *  Método responsável por retornar o metodo HTTP da requisição
     *   @return string
     */
    public function getHttpMethod(){
        return $this->httpMethod;
    }

    /** 
     *  Método responsável por retornar a uri da requisição
     *   @return string
     */
    public function getUri(){
        return $this->uri;
    }

    /** 
     *  Método responsável por retornar os Headers da requisição
     *   @return string
     */
    public function getHeaders(){
        return $this->headers;
    }

     /** 
     *  Método responsável por retornar os parâmetros da URL($_GET) da requisição
     *   @return array
     */
    public function getQueryParams(){
        return $this->queryParams;
    }

      /** 
     *  Método responsável por retornar os parãmetros POST($_POST) da requisição
     *   @return object
     */
    public function getPostVars($postValidated = null): object{
        if($postValidated){
            $this->validateParamsPost($postValidated);
        }
        return json_decode(json_encode($this->postVars));
    }
    /**
     * Método responsável por pegar o post JSON do request e juntar com o postVars da classe Request.
     *
     * @return void
     */
    private function getJsonObject(){
        $json = file_get_contents('php://input');
        $obj = json_decode($json);
        if($obj){
            foreach($obj as $key => $value){
                $this->postVars[strtoupper($key)] = $value;
            }
        }
    }

    /**
     * Método responsável por limpar os dados do post, evitando injection, e deixando todos em UPPER
     * @return object
     */
    private function sanitize() {
        foreach($this->postVars as $key => $value) {  
            $cleanValue = $value;
            if(isset($cleanValue)) {
                $cleanValue = strip_tags(trim($cleanValue));
                $cleanValue = htmlentities($cleanValue, ENT_NOQUOTES);
                $cleanValue = html_entity_decode($cleanValue, ENT_NOQUOTES, 'UTF-8');
            }
            unset($this->postVars[$key]);
            $this->postVars[$key] = $cleanValue;
        }
    }

    private function validateParamsPost($postValidated){
        foreach($postValidated as $key){
            $key = strtoupper($key);
            if($this->postVars[$key]){
                $array[$key] = $this->postVars[$key];
            }
        }
        $this->postVars = $array;
    }
    
    public function postRequired($postRequired): void{
        foreach($postRequired as $key){
            $key = strtoupper($key);
            if(!$this->postVars[$key]){
                throw new \Exception("O parâmetro ${key} é obrigatório!");
            }
        }
    }
}