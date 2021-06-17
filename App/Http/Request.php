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
     *  Construtor da classe 
     */
    public function __construct(){
        $this->queryParams  = $_GET ?? [];
        $this->postVars     = $_POST ?? [];
        $this->headers      = getallheaders();
        $this->httpMethod   = $_SERVER['REQUEST_METHOD'] ?? '';
        $this->uri          = $_SERVER['REQUEST_URI'] ?? '';
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
        return $this->httpMethod;
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
     *   @return array
     */
    public function getPostVars(){
        return $this->postVars;
    }
}