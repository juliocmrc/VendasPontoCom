<?php
require_once "interfaceabstract.class.php";
require_once '../modelo/clientemodel.class.php';

class LoginView extends InterfaceAbstract {
    //É interessante declarar um objeto ProdutoModel para possibilitar montar os 
    //dados na interface após a consulta.
    private $loginModel = null;
    private $clieCPF                = null;

    function __construct ($titulo = "Login") {
        parent::__construct ($titulo);
        $this->loginModel = new LoginModel();
    }


    protected function montaDivConteudo () {
        //Monta Identificação e Produtos.
        $htmlMenuLogin = $this->montaMenuLogin ();

        //Monta a div do conteúdo.
        $htmlDivConteudo = new HtmlDiv();
        $htmlDivConteudo->setId ("conteudo");
        $htmlDivConteudo->adicionaObjetos (array ($htmlMenuLogin, ));

        return $htmlDivConteudo;
    }

    protected function montaMenuLogin () {
        //Monta o fieldset com as entradas de dados uma por parágrafo.
        $htmlLegend   = new HtmlLegend ("Login");
        $htmlFieldset = new HtmlFieldset ($htmlLegend);

        $htmlFieldset->adicionaObjeto ($this->montaParagrafoParaLogin ());

        $htmlFieldset->adicionaObjeto($this->montaBotoes());
        //Cria o formulário
        $htmlForm = new HtmlForm();
        $htmlForm->setAction ("");
        $htmlForm->setMethod ("post");
        $htmlForm->adicionaObjeto ($htmlFieldset);

        return $htmlForm;
    }

    private function montaBotoes(){
        
        $botoes = array ();

        //Botão de login.
        $bt    = new HtmlButton();
        $bt->setName ("bt");
        $bt->setValue ("logar");
        $bt->setType ("submit");
        $bt->setTexto ("Login");
        $botoes [] = $bt;
       
        //Botão de cadastro.
        $bt    = new HtmlButton();
        $bt->setName ("bt");
        $bt->setValue ("cadastrar");
        $bt->setType ("submit");
        $bt->setTexto ("Realizar Cadastro");
        $botoes [] = $bt;
        
        return $botoes;

    }

    private function montaParagrafoParaLogin () {
        $labelCPF = new HtmlLabel();
        $labelCPF->adicionaObjeto ("CPF");

        $inputCPF = new HtmlInput();
        $inputCPF->setName ("clieCPF");
        $inputCPF->setType ("text");
       // $inputCPF->setValue ($this->loginModel->getClieCPF ());
        $inputCPF->setPlaceholder ("Digite seu CPF");


        //Se o CPF já foi preenchido significa que o login já se identificou 
        //previamente. Nesse caso monta-se o CPF protegido e o nome na frente.
       /* if (is_null ($this->loginModel->getClieCPF ())) {
            //continua...
        } else {
            $inputCPF->setReadonly (true);
        }*/

        $htmlP = new HtmlP();
        $htmlP->adicionaObjetos (array ($labelCPF, $inputCPF));

        return $htmlP;
    }

    public function recebeChaveDaConsulta () {
        return $this->getValorOuNull ("clieCPF");
    }

    /**
     * Recebe os dados do formulário, aplica as checagens por códigos 
     * maliciosos, e monta na model do objeto ou numa StdClass.
     */
    public function recebeDadosDaInterface () {
        $loginModel = new LoginModel();

        $loginModel->setClieCPF ($this->getValorOuNull ("clieCPF"));

        return $loginModel;
    }

    function setClieCPF ($clieCPF): void {
        $this->clieCPF = $clieCPF;
    }

    function setLoginModel ($loginModel): void {
        $this->loginModel = $loginModel;
    }

}
?>