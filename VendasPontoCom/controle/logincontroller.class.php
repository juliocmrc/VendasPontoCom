<?php
require_once 'controllerabstract.class.php';
require_once '../visao/loginview.class.php';
require_once '../modelo/loginmodel.class.php';
require_once '../modelo/loginmodel.class.php';
require_once '../ado/clienteado.class.php';

class LoginController extends ControllerAbstract{

    private $acao        = null;
    private $loginView = null;

    public function __construct () {
        $this->loginView = new LoginView();

        $this->acao = $this->loginView->getAcao ();

        switch ($this->acao) {
            case "nova" :
                //Se for uma nova tela não precisa fazer nada!
                break;

            
            case "logar":
                $this->logar ();

                break;


            case "cadastrar":

                $this->realizarCadastro();
                
                break;

            default:

                //session_destroy();
                break;
        }
        
            $this->loginView->geraInterface (true);
        
    }

    private function logar () {
        
        $loginCPF = $this->loginView->recebeChaveDaConsulta();
        $clienteADO = new ClienteADO();
        $buscou = $clienteADO->buscaCliente ($loginCPF);
        if ($buscou){
            session_start ();
            $_SESSION['clieCPF'] = $loginCPF; 
            header("Location: http://localhost/VendasPontoCom/modulos/carrinhodecompras.php");
    
        } else {
            $this->loginView->adicionaMensagem("O CPF informado não foi encontrado. "
                    . "Tente novamente.");
        }
    }

    private function realizarCadastro(){
        header("Location: http://localhost/VendasPontoCom/modulos/cadastrodecliente.php");
    }
    
    private function consultaAdm () {
       /* $clieCPF = $this->loginView->recebeChaveDaConsulta ();
    
        $clienteADO   = new ClienteADO();
        $buscou       = $loginModel = $clienteADO->buscaCliente ($clieEmail);
        if ($buscou) {
            $this->loginView->setloginModel ($loginModel);
        } else {
            //se retornar com erro repassa as mensagens para a interface.
            $this->loginView->adicionaMensagem("Não foi possível encontrar o cliente! Tente novamente ou informe o problema ao responsável pelo sistema.");
        }*/
    }

    private function checaLogin($loginModel) {
        $buscou = $loginModel->buscaCliente();
        if ($buscou) {
            return true;
        } else {
            return false;
        }
        
    }

}



?>