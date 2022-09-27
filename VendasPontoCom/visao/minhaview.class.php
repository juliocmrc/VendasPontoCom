<?php
require_once "interfaceabstract.class.php";

class MinhaView extends InterfaceAbstract {

    function __construct ($titulo = "Minha Segunda View") {
        parent::__construct ($titulo);
    }

    protected function montaDivConteudo () {
        $htmlDivConteudo = new HtmlDiv();
        $htmlDivConteudo->setId ("conteudo");

        $htmlP = new HtmlP();
        $htmlP->adicionaObjeto ("Essa é a div de conteúdo onde o que é pertinente à opção escolhida no menu apresenta o seu conteúdo!");

        $htmlLegend = new HtmlLegend("Legenda");
        $htmlFieldset = new HtmlFieldset();
        $htmlFieldset->setLegend($htmlLegend);
        $htmlFieldset->adicionaObjeto($htmlP);

        $htmlDivConteudo->adicionaObjeto ($htmlFieldset);

        return $htmlDivConteudo;
    }

    public function recebeDadosDaInterface () {
        return null;
    }

    public function recebeChaveDaConsulta () {
        return null;
    }

}
?>