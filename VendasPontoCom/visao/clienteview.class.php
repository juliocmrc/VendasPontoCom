<?php
require_once "interfaceabstract.class.php";

class ClienteView extends InterfaceAbstract {
    private $clienteModel = null;

    
    function __construct ($titulo = "Cadastro de Cliente") {
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

    private function montaBotoesParaCRUD () {
        //Array de botões
        $botoes = array ();

        //Botão de insersão.
        $bt        = new HtmlButton();
        $bt->setName ("bt");
        $bt->setValue ("inserir");
        $bt->setType ("submit");
        $bt->setTexto ("Inserir");
        $botoes [] = $bt;

        //Botão limpar.
        $bt        = new HtmlButton();
        $bt->setName ("bt");
        $bt->setValue ("limpar");
        $bt->setType ("submit");
        $bt->setTexto ("Limpar");
        $botoes [] = $bt;

        return $botoes;
    }

    private function montaParagrafoCPF () {
        $label = new HtmlLabel();
        $label->adicionaObjeto ("CPF");

        $input = new HtmlInput();
        $input->setName ("clieCPF");
        $input->setType ("number");
        $input->setValue ($this->clienteModel->getClieCPF ());
        $input->setPlaceholder ("CPF (somente os números)");

        $htmlP = new HtmlP();
        $htmlP->adicionaObjetos (array ($label, $input));

        return $htmlP;
    }

    private function montaParagrafoNome () {
        $label = new HtmlLabel();
        $label->adicionaObjeto ("Nome");

        $input = new HtmlInput();
        $input->setName ("clieNome");
        $input->setType ("text");
        $input->setValue ($this->clienteModel->getClieNome ());
        $input->setPlaceholder ("Nome completo");

        $htmlP = new HtmlP();
        $htmlP->adicionaObjetos (array ($label, $input));

        return $htmlP;
    }

    private function montaParagrafoEndereco () {
        $label = new HtmlLabel();
        $label->adicionaObjeto ("Endereço");

        $input = new HtmlInput();
        $input->setName ("clieEndereco");
        $input->setType ("text");
        $input->setValue ($this->clienteModel->getClieEndereco ());
        $input->setPlaceholder ("Endereço completo");

        $htmlP = new HtmlP();
        $htmlP->adicionaObjetos (array ($label, $input));

        return $htmlP;
    }

    private function montaParagrafoComplementoDoEndereco () {
        $label = new HtmlLabel();
        $label->adicionaObjeto ("Complemento");

        $input = new HtmlInput();
        $input->setName ("clieComplementoDoEndereco");
        $input->setType ("text");
        $input->setValue ($this->clienteModel->getClieComplementoDoEndereco ());
        $input->setPlaceholder ("Complemento do endereço");

        $htmlP = new HtmlP();
        $htmlP->adicionaObjetos (array ($label, $input));

        return $htmlP;
    }

    private function montaParagrafoUF () {
        $label = new HtmlLabel();
        $label->adicionaObjeto ("UF");

        $select = new HtmlSelect();
        $select->setName("clieUF");
        $select->setId("UF");

        $ufs = array("AC","AL",'AP','AM','BA','CE','DF','ES','GO','MA','MG','MS','MT',
        'PA','PB','PE','PI','PR','RN','RO','RS','RR','SC','SE','SP','TO' );
        

        foreach ($ufs as $uf) {
            $option = new HtmlOption();
            $option->setLabel($uf);
            $option->setValue($uf);
            $select->adicionaOption($option);
        }

        

        $htmlP = new HtmlP();
        $htmlP->adicionaObjetos (array ($label, $select));

        return $htmlP;
    }

    private function montaParagrafoCidade () {
        $label = new HtmlLabel();
        $label->adicionaObjeto ("Cidade");

        $input = new HtmlInput();
        $input->setName ("clieCidade");
        $input->setType ("text");
        $input->setValue ($this->clienteModel->getClieCidade ());
        $input->setPlaceholder ("Cidade");

        $htmlP = new HtmlP();
        $htmlP->adicionaObjetos (array ($label, $input));

        return $htmlP;
    }

    private function montaParagrafoCEP () {
        $label = new HtmlLabel();
        $label->adicionaObjeto ("CEP");

        $input = new HtmlInput();
        $input->setName ("clieCEP");
        $input->setType ("text");
        $input->setValue ($this->clienteModel->getClieCEP ());
        $input->setPlaceholder ("CEP");

        $htmlP = new HtmlP();
        $htmlP->adicionaObjetos (array ($label, $input));

        return $htmlP;
    }

    private function montaParagrafoFone () {
        $label = new HtmlLabel();
        $label->adicionaObjeto ("Telefone");

        $input = new HtmlInput();
        $input->setName ("clieFone");
        $input->setType ("text");
        $input->setValue ($this->clienteModel->getClieFone ());
        $input->setPlaceholder ("Telefone com DDD");

        $htmlP = new HtmlP();
        $htmlP->adicionaObjetos (array ($label, $input));

        return $htmlP;
    }

    private function montaParagrafoDataDeNascimento () {
        $label = new HtmlLabel();
        $label->adicionaObjeto ("Data de nascimento");

        $input = new HtmlInput();
        $input->setName ("clieDataDeNascimento");
        $input->setType ("date");
        $input->setValue ($this->clienteModel->getClieDataDeNascimento ());
        $input->setPlaceholder ("Data de nascimento");

        $htmlP = new HtmlP();
        $htmlP->adicionaObjetos (array ($label, $input));

        return $htmlP;
    }

    private function montaParagrafoEmail () {
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
        return $this->getValorOuNull ("clieCPF");
    }

    public function recebeNome () {
        return $this->getValorOuNull ("clieNome");
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