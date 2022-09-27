<?php
require_once 'htmlabstract.class.php'; //Importa a classe mãe

abstract class HtmlH extends HtmlAbstract {
    protected $n = 1;

    public function geraCodigoDaTag() {
        $codigoEntreTag = $this->geraCodigoDasSubTags();
        $codigoHtml = "<h{$this->n}{$this->geraAtributosGlobais()}>{$codigoEntreTag}</h{$this->n}>";

        return $codigoHtml;
    }

}