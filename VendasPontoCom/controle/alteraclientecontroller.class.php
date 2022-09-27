<?php
session_start();
require_once 'controllerabstract.class.php';
require_once '../visao/alteraclienteview.class.php';
require_once '../modelo/clientemodel.class.php';
require_once '../ado/clienteado.class.php';

class AlteraClienteController extends ControllerAbstract{
    private $acao        = null;
    private $clienteView = null;

    public function __construct () {
        $this->clienteView = new AlteraClienteView();

        $this->acao = $this->clienteView->getAcao ();

        switch ($this->acao) {
            case "nova" :
                //Se for uma nova tela não precisa fazer nada!
                break;

            case "alterar":
                $this->alteraCliente ();

                break;                
        }
        $this->consultaCliente();      
        $this->clienteView->geraInterface (false);
    }


    private function alteraCliente () {
        $clienteModel = $this->clienteView->recebeDadosDaInterface ();

        $dadosOk = $clienteModel->checaAtributos ();
        if ($dadosOk) {
            //Se checagem ok, continua para a alteração.
        } else {
            //se retornar com erro repassa as mensagens para a interface.
            $this->clienteView->adicionaMensagens ($clienteModel->getMensagens ());
            $this->clienteView->setClienteModel ($clienteModel);

            //se ocorrer erro na checagem deve interromper para não incluir.
            return;
        }

        $clienteADO = new ClienteADO ($clienteModel);
        $alterou    = $clienteADO->alteraObjeto ();
        if ($alterou) {
            $clienteModel = new ClienteModel();
            $this->clienteView->setClienteModel ($clienteModel);
            $this->clienteView->adicionaMensagem ("Alterado com sucesso!");
        } else {
            $this->clienteView->adicionaMensagem ("Ocorreu um problema na alteração do produto, informe ao responsável pelo sistema!");
        }

        $this->clienteView->setClienteModel ($clienteModel);
    }

    private function consultaCliente () {
        $clieCPF = $_SESSION['clieCPF'];

        $clienteADO   = new ClienteADO();
        $buscou       = $clienteModel = $clienteADO->buscaCliente ($clieCPF);
        if ($buscou) {
            $this->clienteView->setClienteModel ($clienteModel);
        } else {
            //se retornar com erro repassa as mensagens para a interface.
            $this->clienteView->adicionaMensagem("Não foi possível encontrar o cliente! Tente novamente ou informe o problema ao responsável pelo sistema.");
        }
    }

}
?>