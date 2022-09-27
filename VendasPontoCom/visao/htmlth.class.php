<?php
require_once 'htmlabstract.class.php';

class HtmlTH extends HtmlAbstract {

    private $conteudo = null;

    function __construct ($class = null, $hidden = null,
                          $id = null, $lang = null, $style = null, $title = null, $conteudo = null) {

   
        $this->conteudo = $conteudo;

        parent::__construct ($class, $hidden, $id, $lang, $style, $title, $conteudo);
    }

    public function geraCodigoDaTag () {
        return "<th{$this->geraAtributosGlobais ()}>{$this->conteudo}</th>";
    }

    function setConteudo($conteudo){
        return $this->conteudo = $conteudo;
    }


}