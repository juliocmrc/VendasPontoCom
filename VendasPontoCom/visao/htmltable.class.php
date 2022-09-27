<?php
require_once 'htmlabstract.class.php'; 

class HtmlTable extends HtmlAbstract {
    //Atributos da table
    private $caption  = null;
    private $colgroup      = null;
    private $col  = null;
    private $thead      = null;
    private $tbody   = null;
    private $tfoot      = null;
    private $tr;


    function __construct($class = null, $hidden = null, $id = null,
                         $lang = null, $style = null, $title = null) {
        $this->tr = array();

        parent::__construct($class, $hidden, $id, $lang, $style, $title);
    }

    public function geraCodigoDaTag() {
        $meusAtributos = $this->caption
                . $this->colgroup
                . $this->col
                . $this->thead
                . $this->tbody
                . $this->tfoot;

        return "<table{$this->geraAtributosGlobais()}{$meusAtributos}>{$this->geraTRs()}</table>";
    }

    

    function adicionaTR(HtmlTR $htmlTR) {
        $this->tr [] = $htmlTR;
    }

    function adicionaTRs(Array $htmlTRs) {
        foreach ($htmlTRs as $htmlTR) {
            $this->adicionaTR($htmlTR);
        }
    }

    private function geraTRs() {
        return $this->geraCodigoDosObjetos($this->tr);
    }

    function setCaption($caption) { 
        $this->caption = " caption = '{$caption}";
        
    }

    function setColGroup($colgroup) {
        $this->colgroup = " colgroup='{$colgroup}'";
    }

    function setCol($col) {
        $this->col = " col='{$col}'";
    }

    function setThead($thead) {
        $this->thead = " thead='{$thead}'";
    }

    function setTBody($tbody) {
        $this->tbody = " thead='{$tbody}'";
    }

    function setTFoot(int $tfoot) {
        $this->tfoot = " tfoot='{$tfoot}'";
    }

}