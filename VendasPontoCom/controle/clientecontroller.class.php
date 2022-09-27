<?php
require_once 'controllerabstract.class.php';
require_once '../visao/clienteview.class.php';
require_once '../modelo/clientemodel.class.php';
require_once '../ado/clienteado.class.php';

class ClienteController extends ControllerAbstract{
    private $acao        = null;
    private $clienteView = null;

    public function __construct () {
        $this->clienteView = new ClienteView();

        $this->acao = $this->clienteView->getAcao ();

        switch ($this->acao) {
            case "nova" :
                //Se for uma nova tela não precisa fazer nada!
                break;

            case "inserir":
                $this->insereCliente ();

                break;

            case "limpar":
                $clienteModel = new ClienteModel();

                $this->clienteView->setClienteModel ($clienteModel);

                break;
        }

        $this->clienteView->geraInterface (true);
    }

    private function insereCliente () {
        $clienteModel = $this->clienteView->recebeDadosDaInterface ();
        $chave = $this->clienteView->recebeChaveDaConsulta();
        $dadosOk = $clienteModel->checaAtributos ();
        if ($dadosOk) {
            //Se checagem ok, continua para a inserção.
        } else {
            //se retornar com erro repassa as mensagens para a interface.
            $this->clienteView->adicionaMensagens ($clienteModel->getMensagens ());
            $this->clienteView->setClienteModel ($clienteModel);
            return;
        }

        $clienteADO = new ClienteADO ($clienteModel);
        $incluiu    = $clienteADO->insereObjeto ();
        if ($incluiu) {
            session_start();
            $_SESSION['clieCPF'] = $chave;
            $_SESSION['clieNome'] = $this->clienteView->recebeNome();
            header("Location: http://localhost/VendasPontoCom/modulos/carrinhodecompras.php");
        } else {
            $this->clienteView->adicionaMensagem ("Ocorreu um problema na inserção do cliente, informe ao responsável pelo sistema!");
        }

        $this->clienteView->setClienteModel ($clienteModel);
    }

    private function consultaCliente () {
        $clieCPF = $this->clienteView->recebeChaveDaConsulta ();

        $clienteADO   = new ClienteADO();
        $buscou       = $clienteModel = $clienteADO->buscaCliente ($clieCPF);
        if ($buscou) {
            $this->clienteView->setClienteModel ($clienteModel);
        } else {
            //se retornar com erro repassa as mensagens para a interface.
            $this->clienteView->adicionaMensagem("Não foi possível encontrar o cliente! Tente novamente ou informe o problema ao responsável pelo sistema.");
        }
    }

    /*private function alteraCliente () {
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
            $this->clienteView->adicionaMensagem ("Produto alterado com sucesso!");
        } else {
            $this->clienteView->adicionaMensagem ("Ocorreu um problema na alteração do produto, informe ao responsável pelo sistema!");
        }

        $this->clienteView->setClienteModel ($clienteModel);
    }

    private function excluiCliente () {
        $clienteModel = $this->clienteView->recebeDadosDaInterface ();

        $clienteADO = new ClienteADO ($clienteModel);
        $excluiu    = $clienteADO->excluiObjeto ();
        if ($excluiu) {
            $clienteModel = new ClienteModel();
            $this->clienteView->adicionaMensagem ("Produto excluído com sucesso!");
        } else {
            $this->clienteView->adicionaMensagem ("Ocorreu um problema na exclusão do produto, informe ao responsável pelo sistema!");
        }

        $this->clienteView->setClienteModel ($clienteModel);
    }
*/
}
?>