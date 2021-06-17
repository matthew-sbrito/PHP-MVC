<?php

namespace App\Http;

class Response{
    
    /**
     * Código do Status HTTP
     * @var integer 
     */
    private $httpCode = 200;

    /**
     *  Cabeçalho do Response 
     * @var array
     */
    private $headers = [];

    /**
     *  Tipo de conteúdo que está sendo retornado 
     * @var string
     */
    private $contentType = 'text/html';

    /**
     * Conteúdo do Response
     * @var mixed
     */
    private $content;

    /**
     *  Construtor define os valores
     * @param interger $httpCode
     * @param mixed $content
     * @param string $contentType
     */
    public function __construct($httpCode,$content,$contentType = 'text/html'){
        $this->httpCode = $httpCode;
        $this->content = $content;
        $this->setContentType($contentType);
    }
    
    /**
     * Método responsável por alterar o contentType do response
     * @param string $contentType
     */
    public function setContentType($contentType){
        $this->contentType = $contentType;
        $this->addHeader('Content-Type', $contentType);
    }

    /**
     * Método responsável por adicionar um registro nos Headers do response
     * @param string $key
     * @param string $value
     */
    public function addHeader($key, $value){
        $this->headers[$key] = $value;
    }
    /**
     * Método responsável por enviar os headers ao navegador
     * 
     */

    private function sendHeaders(){
        //STATUS
        http_response_code($this->httpCode);

        //ENVIAR Headers
        foreach($this->headers as $key => $value){
            header($key .':'.$value);
        }
    }

    /**
     * Método responsável por envair a resposta ao usuário
     * @param string $key
     * @param string $value
     */
    public function sendResponse(){
        // ENVIA OS Headers
        $this->sendHeaders();

        // IMPRIME O CONTEÚDO
        switch($this->contentType){
            case 'text/html':
                echo $this->content;
                exit;
        }
    }

}


