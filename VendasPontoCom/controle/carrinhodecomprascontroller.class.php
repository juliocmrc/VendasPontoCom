<?php
require_once 'controllerabstract.class.php';
require_once '../visao/carrinhodecomprasview.class.php';
require_once '../modelo/carrinhodecomprasmodel.class.php';
require_once '../ado/carrinhodecomprasado.class.php';
require_once '../modelo/produtomodel.class.php';
require_once '../ado/produtoado.class.php';
require_once '../modelo/clientemodel.class.php';
require_once '../ado/clienteado.class.php';

class CarrinhoDeComprasController extends ControllerAbstract {
    private $acao                  = null;
    private $carrinhoDeComprasView = null;

    public function __construct () {
        $this->carrinhoDeComprasView = new CarrinhoDeComprasView();

        $this->acao = $this->carrinhoDeComprasView->getAcao ();

        switch ($this->acao) {
            case "nova" :
                //Se for uma nova tela não precisa fazer nada!
                break;

            case "acrescentar":
                $this->acrescentaProduto ();

                break;

            case "retirar":
                $this->removeProduto ();

                break;

            case "continuar":
                $this->continuaACompra ();

                break;

            case "esvaziar":
                $this->esvaziaOCarrinho ();

                break;
        }
        
        $this->carrinhoDeComprasView->geraInterface (false);
    }

    /**
     * Ao acrescentar um produto ao carrinho pela primeira vez deve-se:
     * I) Verificar se o CPF existe;
     * II) Verificar se o Produto existe e se tem estoque;
     * III) Verificar se o Produto já está no carrinho e se está incrementar 
     * a quantidade;
     * IV) Ao acrescentar ao carrinho deve-se decrementar o estoque
     */
    private function acrescentaProduto () {
        $produtoASerAcrescentado = $this->carrinhoDeComprasView->recebeChaveDaConsulta ();

        // Verificar regras de negócio: I) se o CPF existe, se o Produto existe 
        // e se tem estoque;
        $podeAcrescentar = $this->checarSePodeAcrescentarProdutoAoCarrinhoDoCliente ($produtoASerAcrescentado);
        if ($podeAcrescentar) {
            //continua...
        } else {
            $this->carrinhoDeComprasView->adicionaMensagem ($this->getMensagem ());
            return;
        }

        //Já guarda os dados na view para carregá-los na próxima interação.
        $this->carrinhoDeComprasView->setCarrinhoDeComprasModel ($produtoASerAcrescentado);

        $dadosOk = $produtoASerAcrescentado->checaAtributos ();
        if ($dadosOk) {
            //Se checagem ok, continua para a inserção.
        } else {
            //se retornar com erro repassa as mensagens para a interface.
            $this->carrinhoDeComprasView->adicionaMensagens ($produtoASerAcrescentado->getMensagens ());
            $this->carrinhoDeComprasView->setCarrinhoDeComprasModel ($produtoASerAcrescentado);
            return;
        }

        //Ao acrescentar o produto pela primeira vez na tela deve-se iniciar a 
        //sua quantidade com 1. Mas, se já existe o mesmo produto no carrinho 
        //deve-se incrementar a quantidade.
        $acrescentou       = $carrinhoDeCompras = $this->acrescentaProdutoAoCarrinho ($produtoASerAcrescentado);
        if ($acrescentou) {
            //Acrescentou o produto na tabela.
            $this->carrinhoDeComprasView->adicionaMensagem ("Produto acrescentado com sucesso ao seu carrinho.");
        } else {
            $this->carrinhoDeComprasView->adicionaMensagem ($this->getMensagem ());
        }
    }

    private function removeProduto () {
        $produtoASerRemovido = $this->carrinhoDeComprasView->recebeChaveDaConsulta ();

        // Verificar regras de negócio: I) se o CPF existe, se o Produto existe 
        // e se tem estoque;
        /*$podeRemover = $this->checarSePodeAcrescentarProdutoAoCarrinhoDoCliente ($produtoASerRemovido);
        if ($podeAcrescentar) {
            //continua...
        } else {
            $this->carrinhoDeComprasView->adicionaMensagem ($this->getMensagem ());
            return;
        }*/

        //Já guarda os dados na view para carregá-los na próxima interação.
        $this->carrinhoDeComprasView->setCarrinhoDeComprasModel ($produtoASerRemovido);

        $dadosOk = $produtoASerRemovido->checaAtributos ();
        if ($dadosOk) {
            //Se checagem ok, continua para a inserção.
        } else {
            //se retornar com erro repassa as mensagens para a interface.
            $this->carrinhoDeComprasView->adicionaMensagens ($produtoASerRemovido->getMensagens ());
            $this->carrinhoDeComprasView->setCarrinhoDeComprasModel ($produtoASerRemovido);
            return;
        }

        //Ao acrescentar o produto pela primeira vez na tela deve-se iniciar a 
        //sua quantidade com 1. Mas, se já existe o mesmo produto no carrinho 
        //deve-se incrementar a quantidade.
        $removeu       = $carrinhoDeCompras = $this->removeProdutoDoCarrinho ($produtoASerRemovido);
        if ($removeu) {
            //Acrescentou o produto na tabela.
            $this->carrinhoDeComprasView->adicionaMensagem ("Produto removido com sucesso do seu carrinho.");
        } else {
            $this->carrinhoDeComprasView->adicionaMensagem ($this->getMensagem ());
        }
    }

    
    /**
     * @todo ESTE MÉTODO DEVE APENAS ENCAMINHAR PARA OUTRO MÓDULO QUE APENAS 
     * MOSTRARÁ UMA TELA PARA FINALIZAÇÃO DA COMPRA COM O PARGAMENTO. 
     * VOCÊ NÃO PRECISA IMPLEMENTAR ESTA ROTINA.
     */
    private function continuaACompra () {
        $carrinhoDeCompras = $this->carrinhoDeComprasView->recebeDadosDaInterface ();

        $this->carrinhoDeComprasView->adicionaMensagem (
                "ESTA É A ROTINA PARA CONTINUAR A COMPRA, QUE VOCÊ NÃO PRECISA "
                . "IMPLEMENTAR! APÓS CLICAR DEVE-SE APENAS ENCAMINHAR PARA "
                . "OUTRO MÓDULO QUE VAI MONTAR UMA INTERFACE PARA EFETIVAÇÃO DA "
                . "COMPRA COM O PAGAMENTO. ESSE NOVO MÓDULO AINDA NÃO PRECISA "
                . "SER IMPLEMENTADO, APENAS MOSTAR UMA MENSAGEM DE QUE CHEGOU "
                . "NA PARTE DE PAGAEMNTO. O CARRINHO É DO CLIENTE: "
                . $carrinhoDeCompras->getCarrClieCPF ()
        );

        $this->carrinhoDeComprasView->setCarrinhoDeComprasModel ($carrinhoDeCompras);
    }

    private function removeProdutoDoCarrinho (CarrinhoDeComprasModel $produtoASerDecrementado) {

        $produtoZerado = false;
        //Primero verifica se o produto está no carrinho.
        $carrinhoDeComprasADO   = new CarrinhoDeComprasADO ($produtoASerDecrementado);
        $carrinhoDeComprasModel = $carrinhoDeComprasADO->buscaUmProdutoDeUmCarrinho (
            $produtoASerDecrementado->getCarrClieCPF (),
            $produtoASerDecrementado->getCarrProdId ()
        );

        if($carrinhoDeComprasModel->getCarrQtdeProduto () < 2){
            $produtoZerado = true;
        }else{
            $carrinhoDeComprasModel->setCarrQtdeProduto ($carrinhoDeComprasModel->getCarrQtdeProduto () - 1);
        }
            

        //Depois de preparar tem que iniciar uma transação, excluir ou alterar o
        //produto no carrinho e incrementar a quantidade no estoque do produto.
        $instrucoes = array ();
        $carrinhoDeComprasADO->setCarrinhoDeComprasModel ($carrinhoDeComprasModel);
        if ($produtoZerado) {
            //monta exclusão de produto zerado no carrinho
            $instrucoes [] = $carrinhoDeComprasADO->montaInstrucaoDeExclusaoEArrayDeColunasEValores ();
        } else {
            //monta alteração para remover uma unidade do produto no carrinho
            $colunasParaAlteracao = array (
                "carrQtdeProduto" => $carrinhoDeComprasModel->getCarrQtdeProduto ()
            );
            $instrucoes []        = $carrinhoDeComprasADO->montaInstrucaoDeAlteracaoEArrayDeColunasEValores ($colunasParaAlteracao);
        }

        //Incrementa estoque se acontecer a remoção do produto.
        $produtoADO   = new ProdutoADO();
        $buscou       = $produtoModel = $produtoADO->buscaProduto ($produtoASerDecrementado->getCarrProdId ());
        if ($buscou) { 
            $produtoADO->setProdutoModel ($produtoModel);
            $colunasParaAlteracao = array ("prodQtdeEmEstoque" => $produtoModel->getProdQtdeEmEstoque () + 1);
            $instrucoes []        = $produtoADO->montaInstrucaoDeAlteracaoEArrayDeColunasEValores ($colunasParaAlteracao);
    
        } else {
            if ($buscou === 0) {
                $this->setMensagem ("Ocorreu um erro ao tentar remover o produto do carrinho! Não foi possível encontrar o produto.");
                return false;
            } else {
                $this->setMensagem ("Ocorreu um erro ao tentar remover o produto do carrinho! Tente novamente informe o problema ao responsável pelo sistema.");
                return false;
            }
        }

        //Executa todas as intruções dentro de uma transação.
        $executou = $carrinhoDeComprasADO->executaInstrucoesNumaTransacao ($instrucoes);
        if ($executou) {
            return true;
        } else {
            $this->setMensagem ("Ocorreu um erro desconhecido! Tente novamente ou informe ao responsável pelo sistema.");
            return false;
        }
    }

    /**
     * @todo ESTE MÉTODO DEVE RETIRAR TODOS OS PRODUTOS DO CARRINHO DO CLIENTE E
     * RETORNAR A QUANTIDADE DE CADA PRODUTO PARA O SEU ESTOQUE. TEM QUE USAR 
     * TRANSAÇÃO.
     */
    private function esvaziaOCarrinho () {
        $carrinhoDeCompras = $this->carrinhoDeComprasView->recebeDadosDaInterface ();

        $this->carrinhoDeComprasView->setCarrinhoDeComprasModel ($carrinhoDeCompras);

        //Primero verifica se o produto está no carrinho.
        $carrinhoDeComprasADO   = new CarrinhoDeComprasADO ($carrinhoDeCompras);

        $produtos = $carrinhoDeComprasADO->buscaOCarrinhoDoCliente($carrinhoDeCompras->getCarrClieCPF());

        foreach($produtos as $produto){
              $produtoADO   = new ProdutoADO();
              $produtoModel = $produtoADO->buscaProduto($produto->prodId);
              $totalQtdeProduto = $produtoModel->getProdQtdeEmEstoque () + $produto->carrQtdeProduto;
              $produtoModel->setProdQtdeEmEstoque($totalQtdeProduto);
              $produtoADO->setProdutoModel($produtoModel);
              //Executa todas as intruções dentro de uma transação.
              $executou = $produtoADO->alteraObjeto();
              if ($executou) {
              } else {
                     $this->setMensagem ("Ocorreu um erro desconhecido! Tente novamente ou informe ao responsável pelo sistema.");
                 }
        };

        //Executa todas as intruções dentro de uma transação.
            $esvaziou = $carrinhoDeComprasADO->esvaziaTabela();
            if($esvaziou){
                $this->carrinhoDeComprasView->adicionaMensagem ("Carrinho esvaziado com sucesso.");
            }else {
                $this->carrinhoDeComprasView->adicionaMensagem ("Algo deu errado ao esvaziar o carrinho.");
            }
            return true;

        $carrinhoDeComprasModel = new CarrinhoDeComprasModel();

        $removeu = $this->carrinhoDeComprasView->setCarrinhoDeComprasModel($carrinhoDeComprasModel);
        if ($removeu) {
            //Acrescentou o produto na tabela.
            $this->carrinhoDeComprasView->adicionaMensagem ("Carrinho esvaziado com sucesso.");
            return true;
        } else {
            $this->carrinhoDeComprasView->adicionaMensagem ($this->getMensagem ());
            return false;
        
    }
}

    /**
     * Verifica as regras de negócio: 
     * I) se o CPF existe;
     * II) se o Produto existe e se tem estoque.
     * 
     * @param CarrinhoDeComprasModel $carrinhoDeComprasModel
     * @return boolean True se tudo ok e false caso cntrário.
     */
    private function checarSePodeAcrescentarProdutoAoCarrinhoDoCliente (CarrinhoDeComprasModel $carrinhoDeComprasModel) {
        //Checagem do CPF
        $this->clienteAdo = new ClienteADO();
        $buscou           = $this->clienteAdo->buscaCliente ($carrinhoDeComprasModel->getCarrClieCPF ());
        if ($buscou) {
            //Cliente ok, continua...
        } else {
            //Não encontrou o cliente. Retorna com erro.
            $this->setMensagem ("O cliente não foi identificado. Confira o CPF informado e certifique-se de estar cadastrado no sistema.");
            return false;
        }

        //Checagem do Produto
        $produtoAdo   = new ProdutoADO();
        $buscou       = $produtoModel = $produtoAdo->buscaProduto ($carrinhoDeComprasModel->getCarrProdId ());
        if ($buscou) {
            //Produto ok, então checa se tem estoque.
            if ($produtoModel->getProdQtdeEmEstoque () > 0) {
                //tem estoque, continua...
            } else {
                $this->setMensagem ("O produto está em falta no estoque.");
                return false;
            }
        } else {
            //Não encontrou o produto. Retorna com erro.
            $this->setMensagem ("O produto não foi identificado. Tente novamente mais tarde.");
            return false;
        }

        return true;
    }

    /**
     * Este método deve verificar a existência ou não de um produto no carrinho 
     * de um cliente. Se exitir acresceta mais um na quantidade e caso contrário 
     * prepara para incluir o produto no carrinho com quantidade igual a 1.
     * 
     * @param CarrinhoDeComprasModel $produtoASerAcrescentado Produto a ser 
     * acrescentado.
     * @return boolean returna true se correu tudo bem ou false caso contrário.
     */
    private function acrescentaProdutoAoCarrinho (CarrinhoDeComprasModel $produtoASerAcrescentado) {
        //Identificará se o produto é novo no carrinho ou está sendo 
        //incrementado.
        $novoProduto = true;

        //Primero verifica se o produto já está no carrinho.
        $carrinhoDeComprasADO   = new CarrinhoDeComprasADO ($produtoASerAcrescentado);
        $buscou                 = $carrinhoDeComprasModel = $carrinhoDeComprasADO->buscaUmProdutoDeUmCarrinho (
                $produtoASerAcrescentado->getCarrClieCPF (),
                $produtoASerAcrescentado->getCarrProdId ()
        );

        if ($buscou) {
            $novoProduto = false;
            $carrinhoDeComprasModel->setCarrQtdeProduto ($carrinhoDeComprasModel->getCarrQtdeProduto () + 1);
        } else {
            if ($buscou === 0) {
                $carrData               = Data::getDataDoSistemaNoFormatoDoBD ();
                $carrinhoDeComprasModel = new CarrinhoDeComprasModel (
                        $produtoASerAcrescentado->getCarrClieCPF (),
                        $produtoASerAcrescentado->getCarrProdId (),
                        1,
                        $carrData
                );
            } else {
                $this->setMensagem ("Ocorreu um erro ao tentar acrescentar o produto ao carrinho! Tente novamente ou informe o problema ao responsável pelo sistema.");
                return false;
            }
        }

        //Depois de preparar tem que iniciar uma transação, incluir ou alterar o
        //produto no carrinho e decrementar a quantidade no estoque do produto.
        $instrucoes = array ();
        $carrinhoDeComprasADO->setCarrinhoDeComprasModel ($carrinhoDeComprasModel);
        if ($novoProduto) {
            //monta inserção para novo produto no carrinho
            $instrucoes [] = $carrinhoDeComprasADO->montaInstrucaoDeInsersaoEArrayDeColunasEValores ();
        } else {
            //monta alteração para acrescentar mais uma unidade do produto no carrinho
            $colunasParaAlteracao = array (
                "carrQtdeProduto" => $carrinhoDeComprasModel->getCarrQtdeProduto ()
            );
            $instrucoes []        = $carrinhoDeComprasADO->montaInstrucaoDeAlteracaoEArrayDeColunasEValores ($colunasParaAlteracao);
        }

        //Decremena estoque se tiver estoque para o produto.
        $produtoADO   = new ProdutoADO();
        $buscou       = $produtoModel = $produtoADO->buscaProduto ($produtoASerAcrescentado->getCarrProdId ());
        if ($buscou) {
            //Certifica que o produto tem estoque.
            if ($produtoModel->getProdQtdeEmEstoque () > 0) {
                $produtoADO->setProdutoModel ($produtoModel);
                $colunasParaAlteracao = array ("prodQtdeEmEstoque" => $produtoModel->getProdQtdeEmEstoque () - 1);
                $instrucoes []        = $produtoADO->montaInstrucaoDeAlteracaoEArrayDeColunasEValores ($colunasParaAlteracao);
            } else {
                $this->setMensagem ("Não foi possível acrescentar o produto porque o seu estoque está vazio.");
                return false;
            }
        } else {
            if ($buscou === 0) {
                $this->setMensagem ("Ocorreu um erro ao tentar acrescentar o produto ao carrinho! Não foi possível encontrar o produto.");
                return false;
            } else {
                $this->setMensagem ("Ocorreu um erro ao tentar acrescentar o produto ao carrinho! Tente novamente inform o problema ao responsável pelo sistema.");
                return false;
            }
        }

        //Executa todas as intruções dentro de uma transação.
        $executou = $carrinhoDeComprasADO->executaInstrucoesNumaTransacao ($instrucoes);
        if ($executou) {
            return true;
        } else {
            $this->setMensagem ("Ocorreu um erro desconhecido! Tente novamente ou informe ao responsável pelo sistema.");
            return false;
        }
    }

}
?>