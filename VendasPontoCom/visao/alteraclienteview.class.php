<?php
require_once "interfaceabstract.class.php";

class AlteraClienteView extends InterfaceAbstract {
    private $clienteModel = null;

    function __construct ($titulo = "Alterar Dados") {
        parent::__construct ($titulo);
        $this->clienteModel = new ClienteModel();
    }

    protected function montaDivConteudo () {
        $htmlDivConteudo = new HtmlDiv();
        $htmlDivConteudo->setId ("conteudo");

        //Cria o fieldset.
        $htmlLegend   = new HtmlLegend ("Cliente");
        $htmlFieldset = new HtmlFieldset ($htmlLegend);

        //Monta o formulário com as entradas de dados uma por parágrafo.
        $htmlFieldset->adicionaObjeto ($this->montaParagrafoCPF ());
        $htmlFieldset->adicionaObjeto ($this->montaParagrafoNome ());
        $htmlFieldset->adicionaObjeto ($this->montaParagrafoEndereco ());
        $htmlFieldset->adicionaObjeto ($this->montaParagrafoComplementoDoEndereco ());
        $htmlFieldset->adicionaObjeto ($this->montaParagrafoUF ());
        $htmlFieldset->adicionaObjeto ($this->montaParagrafoCidade ());
        $htmlFieldset->adicionaObjeto ($this->montaParagrafoCEP ());
        $htmlFieldset->adicionaObjeto ($this->montaParagrafoFone ());
        $htmlFieldset->adicionaObjeto ($this->montaParagrafoDataDeNascimento ());
        $htmlFieldset->adicionaObjeto ($this->montaParagrafoEmail ());

        //Monta os botões do CRUD
        $htmlFieldset->adicionaObjetos ($this->montaBotoesParaCRUD ());

        //Cria o formulário
        $htmlForm = new HtmlForm();
        $htmlForm->setAction ("");
        $htmlForm->setMethod ("post");
        $htmlForm->adicionaObjeto ($htmlFieldset);

        $htmlDivConteudo->adicionaObjeto ($htmlForm);

        return $htmlDivConteudo;
    }

    protected function montaBotoesParaCRUD () {
        //Array de botões
        $botoes = array ();

        //Botão de alteração.
        $bt        = new HtmlButton();
        $bt->setName ("bt");
        $bt->setValue ("alterar");
        $bt->setType ("submit");
        $bt->setTexto ("Alterar");
        $botoes [] = $bt;      

        return $botoes;
        
    }

    protected function montaParagrafoCPF () {
        $label = new HtmlLabel();
        $label->adicionaObjeto ("CPF");

        $input = new HtmlInput();
        $input->setName ("clieCPF");
        $input->setType ("number");
        $input->setValue ($this->clienteModel->getClieCPF ());
        $input->setReadonly();

        $htmlP = new HtmlP();
        $htmlP->adicionaObjetos (array ($label, $input));

        return $htmlP;
    }

    protected function montaParagrafoNome () {
        $label = new HtmlLabel();
        $label->adicionaObjeto ("Nome");

        $input = new HtmlInput();
        $input->setName ("clieNome");
        $input->setType ("text");
        $input->setValue ($this->clienteModel->getClieNome ());
        $input->setReadonly();

        $_SESSION['clieNome'] = $this->clienteModel->getClieNome ();
        $htmlP = new HtmlP();
        $htmlP->adicionaObjetos (array ($label, $input));

        return $htmlP;
    }

    protected function montaParagrafoEndereco () {
        $label = new HtmlLabel();
        $label->adicionaObjeto ("Endereço");

        $input = new HtmlInput();
        $input->setName ("clieEndereco");
        $input->setType ("text");
        $input->setValue ($this->clienteModel->getClieEndereco ());

        $htmlP = new HtmlP();
        $htmlP->adicionaObjetos (array ($label, $input));

        return $htmlP;
    }

    protected function montaParagrafoComplementoDoEndereco () {
        $label = new HtmlLabel();
        $label->adicionaObjeto ("Complemento");

        $input = new HtmlInput();
        $input->setName ("clieComplementoDoEndereco");
        $input->setType ("text");
        $input->setValue ($this->clienteModel->getClieComplementoDoEndereco ());

        $htmlP = new HtmlP();
        $htmlP->adicionaObjetos (array ($label, $input));

        return $htmlP;
    }

    protected function montaParagrafoUF () {
        $label = new HtmlLabel();
        $label->adicionaObjeto ("UF");

        $input = new HtmlInput();
        $input->setName ("clieUF");
        $input->setType ("text");
        $input->setValue ($this->clienteModel->getClieUF ());

        $htmlP = new HtmlP();
        $htmlP->adicionaObjetos (array ($label, $input));

        return $htmlP;
    }

    protected function montaParagrafoCidade () {
        $label = new HtmlLabel();
        $label->adicionaObjeto ("Cidade");

        $input = new HtmlInput();
        $input->setName ("clieCidade");
        $input->setType ("text");
        $input->setValue ($this->clienteModel->getClieCidade ());

        $htmlP = new HtmlP();
        $htmlP->adicionaObjetos (array ($label, $input));

        return $htmlP;
    }

    protected function montaParagrafoCEP () {
        $label = new HtmlLabel();
        $label->adicionaObjeto ("CEP");

        $input = new HtmlInput();
        $input->setName ("clieCEP");
        $input->setType ("text");
        $input->setValue ($this->clienteModel->getClieCEP ());

        $htmlP = new HtmlP();
        $htmlP->adicionaObjetos (array ($label, $input));

        return $htmlP;
    }

    protected function montaParagrafoFone () {
        $label = new HtmlLabel();
        $label->adicionaObjeto ("Telefone");

        $input = new HtmlInput();
        $input->setName ("clieFone");
        $input->setType ("text");
        $input->setValue ($this->clienteModel->getClieFone ());

        $htmlP = new HtmlP();
        $htmlP->adicionaObjetos (array ($label, $input));

        return $htmlP;
    }

    protected function montaParagrafoDataDeNascimento () {
        $label = new HtmlLabel();
        $label->adicionaObjeto ("Data de nascimento");

        $input = new HtmlInput();
        $input->setName ("clieDataDeNascimento");
        $input->setType ("date");
        $input->setValue ($this->clienteModel->getClieDataDeNascimento ());

        $htmlP = new HtmlP();
        $htmlP->adicionaObjetos (array ($label, $input));

        return $htmlP;
    }

    protected function montaParagrafoEmail () {
        $label = new HtmlLabel();
        $label->adicionaObjeto ("E-mail");

        $input = new HtmlInput();
        $input->setName ("clieEmail");
        $input->setType ("email");

        $input->setValue ($this->clienteModel->getClieEmail ());
        $input->setPlaceholder ("E-mail");

        $htmlP = new HtmlP();
        $htmlP->adicionaObjetos (array ($label, $input));

        return $htmlP;
    }

    public function recebeChaveDaConsulta () {
        return $this->getValorOuNull ($_SESSION['clieCPF']);
    }

    public function recebeNome () {
        return $this->getValorOuNull ($_SESSION["clieNome"]);
    }

    /**
     * Recebe os dados do formulário, aplica as checagens por códigos 
     * maliciosos, e monta na model do objeto ou numa StdClass.
     */
    public function recebeDadosDaInterface () {
        $clienteModel = new ClienteModel();

        $clienteModel->setClieCPF ($this->getValorOuNull ("clieCPF"));
        $clienteModel->setClieNome ($this->getValorOuNull ("clieNome"));
        $clienteModel->setClieEndereco ($this->getValorOuNull ("clieEndereco"));
        $clienteModel->setClieComplementoDoEndereco ($this->getValorOuNull ("clieComplementoDoEndereco"));
        $clienteModel->setClieUF ($this->getValorOuNull ("clieUF"));
        $clienteModel->setClieCidade ($this->getValorOuNull ("clieCidade"));
        $clienteModel->setClieCEP ($this->getValorOuNull ("clieCEP"));
        $clienteModel->setClieFone ($this->getValorOuNull ("clieFone"));
        $clienteModel->setClieDataDeNascimento ($this->getValorOuNull ("clieDataDeNascimento"));
        $clienteModel->setClieEmail ($this->getValorOuNull ("clieEmail"));

        return $clienteModel;
    }

    function getClienteModel () {
        return $this->clienteModel;
    }

    function setClienteModel ($clienteModel): void {
        $this->clienteModel = $clienteModel;
    }

}
?>