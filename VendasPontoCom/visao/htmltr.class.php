<?php
require_once 'htmlabstract.class.php';

class HtmlTR extends HtmlAbstract {

    private $th;
    private $td;

    function __construct ($class = null, $hidden = null,
                          $id = null, $lang = null, $style = null, $title = null, $conteudo = null) {

        $this->th = array();
        $this->td = array();    


        parent::__construct ($class, $hidden, $id, $lang, $style, $title, $conteudo);
    }

    public function geraCodigoDaTag () {
        return "<tr{$this->geraAtributosGlobais ()}>{$this->geraTDs()}{$this->geraTHs()}</tr>"; 
    }

    function adicionaTH(HtmlTH $htmlTH) {
        $this->th [] = $htmlTH;
    }

    function adicionaTHs(Array $htmlTHs) {
        foreach ($htmlTHs as $htmlTH) {
            $this->adicionaTH($htmlTH);
        }
    }

    function adicionaTD(HtmlTD $htmlTD) {
        $this->td [] = $htmlTD;
    }

    function adicionaTDs(Array $htmlTDs) {
        foreach ($htmlTDs as $htmlTD) {
            $this->adicionaTD($htmlTD);
        }
    }

    private function geraTHs() {
        return $this->geraCodigoDosObjetos($this->th);
    }

    private function geraTDs() {
        return $this->geraCodigoDosObjetos($this->td);
    }
}